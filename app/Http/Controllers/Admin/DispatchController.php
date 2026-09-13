<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{SalesOrder, DeliveryNote, DeliveryNoteItem, StockMovement, Product, Warehouse, Invoice};
use DB;
use PDF;
use Illuminate\Support\Facades\Mail;

class DispatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dispatch-list', ['only' => ['index']]);
    }

    public function dispatchForm($id)
    {
        $order = Invoice::with('items')->findOrFail($id);
        $warehouses = Warehouse::get();
        $track = strtoupper(substr(uniqid(), -10));

        return view('admin.dispatch.form', compact('order', 'warehouses', 'track'));
    }

    public function submitDispatch(Request $request, $id)
    {
        $request->validate([
            'dispatch_date' => 'required|date',
            'tracking_no'   => 'nullable|string',
            'courier_name'  => 'nullable|string',
            'warehouse_id'  => 'nullable|exists:warehouses,id',
            'docket_no'     => 'nullable|string',
            'company_link'  => 'nullable|url',
            'branch_id' => 'required'
        ]);

        // dd($data);

        $order = Invoice::with('items')->findOrFail($id);

        // if ($order->status !== 'paid') {
        //     return back()->with('error_message', 'Order is not paid so cannot dispatch.');
        // }

        // dd($order);

        // foreach ($order->items as $item) {
        //     // dd($item->quantity);
        //     $product = Product::find($item->product_id);

        //     // dd($product->stock);

        //     $invv = $product->update([
        //         'stock' => $product->stock - $item->quantity
        //     ]);

        //     // dd($invv);
        // }

        DB::beginTransaction();

        try {

            // Generate delivery note number
            $deliveryNo = 'DN-' . str_pad(DeliveryNote::count() + 1, 5, '0', STR_PAD_LEFT);

            // Create delivery note
            $dn = DeliveryNote::create([
                'delivery_no'   => $deliveryNo,
                'sales_order_id' => $order->id,
                'customer_id'   => $order->customer_id,
                'dispatch_date' => $request->dispatch_date,
                'tracking_no'   => $request->tracking_no,
                'courier_name'  => $request->courier_name,
                'status'        => 'dispatched',
                'docket_no'     => $request->docket_no,
                'company_link'  => $request->company_link,
                'branch_id' => $request->branch_id
            ]);

            // Save each delivered item + perform STOCK OUT
            foreach ($order->items as $item) {

                // Insert into delivery_note_items
                DeliveryNoteItem::create([
                    'delivery_note_id' => $dn->id,
                    'product_id'       => $item->product_id,
                    'quantity'         => $item->quantity,
                    'hsn_code' => $item->hsn_code,
                    'gst' => $item->tax_id,
                    'unit_price' => $item->price,
                    'line_total' => $item->line_total
                ]);

                // ==== STOCK OUT LOGIC ====

                // Last Movement
                $query = StockMovement::where('product_id', $item->product_id);

                if ($request->warehouse_id) {
                    $query->where('warehouse_id', $request->warehouse_id);
                } else {
                    $query->whereNull('warehouse_id');
                }

                $lastMovement = $query->latest()->first();

                $product = Product::find($item->product_id);
                $before = $lastMovement ? $lastMovement->quantity_after : $product->opening_stock;
                $after  = $before - $item->quantity;

                // Insert stock movement
                StockMovement::create([
                    'product_id'      => $item->product_id,
                    'warehouse_id'    => $request->warehouse_id ?? null,
                    'movement_type'   => 'sale',
                    'quantity'        => $item->quantity,
                    'quantity_before' => $before,
                    'quantity_after'  => $after,
                    'reference_type'  => 'sales_order',
                    'reference_id'    => $order->id,
                    'note'            => 'Dispatched through Delivery Note',
                ]);
            }



            // Update Sales Order Status
            $order->update(['o_status' => 'dispatched']);

            DB::commit();


            $vendorUser = $order->customer?->user;

            // Global recipients from notification_settings table
            $systemRecipients = getNotificationRecipients(
                type: 'order_dispacth',
                channel: 'system',
                extraUsers: $vendorUser ? [$vendorUser] : []
            );

            $mailRecipients = getNotificationRecipients(
                type: 'order_dispacth',
                channel: 'mail',
                extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
            )->filter(fn($user) => !empty($user->email));

            // Send system notification
            if ($systemRecipients->isNotEmpty()) {
                sendSystemNotification(
                    users: $systemRecipients->all(),
                    title: 'Order Dispatched',
                    message: 'Dispatched Delivery No ' . $dn->delivery_no,
                    type: 'order_dispacth',
                    url: route('admin.dispatch.list'),
                    extra: [
                        'proforma_id' => $order->id,
                        'received_by' => auth()->id(),
                    ]
                );
            }

            // Send mail
            // foreach ($mailRecipients as $user) {
            //     $mailData = [
            //         'subject' => 'Order Dispatched',
            //         'name' => $user->name,
            //         'message' => 'Your order has been successfully dispatched via ' . $dn->courier_name . '. Delivery Number: ' . $dn->delivery_no . ', Tracking Number: ' . $dn->tracking_no . '. You can track your shipment here: ' . $dn->company_link . '.',
            //     ];
            //     Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
            // }



            return redirect()->route('admin.dispatch.list')
                ->with('success_message', 'Order dispatched successfully!');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error_message', $e->getMessage());
        }

        TrackingController::logEvent(
            $order->id,
            'dispatched',
            'Order Dispatched',
            'Your package has been handed over to the courier.'
        );
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $dispatched = DeliveryNote::latest()->get();
        }else{
            $dispatched = DeliveryNote::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }
        $track = strtoupper(substr(uniqid(), -10));
        return view('admin.dispatch.index', compact('dispatched', 'track'));
    }




    public function deliveryNotePdf($id)
    {
        // eager load related models
        // $delivery = DeliveryNote::with([
        //     'salesOrder.proforma.customer',
        //     'items.product'
        // ])->findOrFail($id);

        $delivery =  DeliveryNote::findOrFail($id);

        // Gather data for the view
        $data = [
            'delivery' => $delivery,
            'company' => [
                'name' => get_settings('system_name'),
                'address' => get_settings('address'),
                'phone' => get_settings('phone'),
                'email' => get_settings('system_email'),
                'gst' => 'GSTIN: 12ABCDE3456F7Z8'
            ],
            'generated_at' => now(),
        ];

        // load view and render PDF
        $pdf = PDF::loadView('admin.dispatch.delivery_note_pdf', $data);
        // optional: set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // stream to browser (inline)
        $fileName = 'DeliveryNote-' . $delivery->delivery_no . '.pdf';

        $delivery->status = 'completed';
        $delivery->save();

        return $pdf->stream($fileName);

        // or to force download:
        // return $pdf->download($fileName);
    }

    public function dispatchStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'nullable'
        ]);

        $del = DeliveryNote::find($id);

        $del->update($data);

        return back()->with('success_message', 'Status updated successfully');
    }
}
