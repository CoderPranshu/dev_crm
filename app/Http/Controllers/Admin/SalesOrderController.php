<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Proforma, SalesOrder, SalesOrderItem, User};
use DB;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SystemNotification;

class salesOrderController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view-sales-orders', ['only' => ['index']]);
    //     $this->middleware('permission:create-sales-order', ['only' => ['store']]);
    //     $this->middleware('permission:convert-sales-order-from-proforma', ['only' => ['convertFromProforma']]);
    // }

    public function __construct()
    {
        $this->middleware('permission:sales-order-list|sales-order-create|sales-order-edit|sales-order-show|sales-order-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:purchase-bill-pay', ['only' => ['pay']]);
        $this->middleware('permission:sales-order-show', ['only' => ['show']]);
        // $this->middleware('permission:payables-delete', ['only' => ['destroy']]);
    }


    public function convertFromProforma($id)
    {
        $proforma = Proforma::with('items.product')->findOrFail($id);

        if ($proforma->status != 'proforma') {
            return back()->with('error_message', 'This Proforma is already processed.');
        }

        DB::beginTransaction();

        try {

            // ==============================
            // CHECK STOCK AVAILABILITY
            // ==============================
            $isReadyToDeliver = true;

            foreach ($proforma->items as $item) {
                $product = $item->product;

                if (!$product || $product->stock < $item->quantity) {
                    $isReadyToDeliver = false;
                    break;
                }
            }

            // ==============================
            // GENERATE SAFE SO NUMBER
            // ==============================
            $lastSO = SalesOrder::lockForUpdate()->latest('id')->first();
            $nextId = $lastSO ? $lastSO->id + 1 : 1;
            $soNumber = 'SO-' . str_pad($nextId, 5, "0", STR_PAD_LEFT);

            // ==============================
            // CREATE SALES ORDER
            // ==============================
            $so = SalesOrder::create([
                'so_no'          => $soNumber,
                'proforma_id'    => $proforma->id,
                'customer_id'    => $proforma->customer_id,
                'subtotal'       => $proforma->subtotal,
                'tax'            => $proforma->tax,
                'total'          => $proforma->total,
                'status'         => $isReadyToDeliver ? 'ready to delivery' : 'processing',
                'expected_delivery_date' => now()->addDays(5),
                'branch_id'      => $proforma->branch_id,
            ]);

            // ==============================
            // INSERT ITEMS + DEDUCT STOCK
            // ==============================
            foreach ($proforma->items as $item) {

                SalesOrderItem::create([
                    'sales_order_id' => $so->id,
                    'product_id'     => $item->product_id,
                    'price'          => $item->price,
                    'quantity'       => $item->quantity,
                    'line_total'     => $item->line_total,
                    'hsn_code'       => $item->hsn_code,
                    'gst'            => $item->gst,
                ]);

                // Deduct stock only if ready to deliver
                // if ($isReadyToDeliver) {
                //     $item->product->decrement('stock', $item->quantity);
                // }
            }

            // ==============================
            // UPDATE PROFORMA STATUS
            // ==============================
            $proforma->update(['status' => 'processing']);

            DB::commit();

            // ==============================
            // NOTIFICATIONS
            // ==============================
            $vendorUser = $proforma->customer?->user;

            $systemRecipients = getNotificationRecipients(
                type: 'convert_to_processing',
                channel: 'system',
                extraUsers: $vendorUser ? [$vendorUser] : []
            );

            $mailRecipients = getNotificationRecipients(
                type: 'convert_to_processing',
                channel: 'mail',
                extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
            )->filter(fn($user) => !empty($user->email));

            if ($systemRecipients->isNotEmpty()) {
                sendSystemNotification(
                    users: $systemRecipients->all(),
                    title: 'Converted to processing',
                    message: 'Order with ID ' . $proforma->id . ' has been updated to ' . $so->status,
                    type: 'convert_to_processing',
                    url: route('admin.proforma.index'),
                    extra: [
                        'proforma_id' => $proforma->id,
                        'sales_order_id' => $so->id
                    ]
                );
            }

            foreach ($mailRecipients as $user) {
                $mailData = [
                    'subject' => 'Order Status Update',
                    'name' => $user->name,
                    'sales' => $so->id,
                    'message' => 'Order with ID ' . $proforma->id . ' is now ' . $so->status,
                ];

                Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
            }

            return redirect()->route('admin.salesorders.index')
                ->with('success_message', 'Proforma converted to Sales Order successfully.');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error_message', $e->getMessage());
        }
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $salesOrders = SalesOrder::latest()->get();
        } else {
            $salesOrders = SalesOrder::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }
        return view('admin.salesOrder.index', compact('salesOrders'));
    }

    public function show($id)
    {
        $salesOrder = SalesOrder::with('items.product', 'proforma.customer')->findOrFail($id);

        // return $salesOrder;
        return view('admin.salesOrder.show', compact('salesOrder'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sales_orders,id',
            'status' => 'required'
        ]);

        $so = SalesOrder::findOrFail($request->id);
        $so->status = $request->status;
        $so->save();

        $vendorUser = $so->customer?->user;

        // Global recipients from notification_settings table
        $systemRecipients = getNotificationRecipients(
            type: 'status_update',
            channel: 'system',
            extraUsers: $vendorUser ? [$vendorUser] : []
        );

        $mailRecipients = getNotificationRecipients(
            type: 'status_update',
            channel: 'mail',
            extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
        )->filter(fn($user) => !empty($user->email));

        // Send system notification
        if ($systemRecipients->isNotEmpty()) {
            sendSystemNotification(
                users: $systemRecipients->all(),
                title: 'Status update ' . $so->status,
                message: 'Sales Order ' . $so->so_no . ' has been updated to ' . $so->status,
                type: 'status_update',
                url: route('admin.salesorders.index'),
                extra: [
                    'sales_order' => $so->id,
                    'received_by' => auth()->id(),
                ]
            );
        }

        // Send mail
        // foreach ($mailRecipients as $user) {
        //     $mailData = [
        //         'subject' => 'Status update ' . $so->status,
        //         'name' => $user->name,
        //         'message' => 'Sales Order ' . $so->so_no . ' has been updated to ' . $so->status,
        //     ];

        //     Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
        // }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    }
}
