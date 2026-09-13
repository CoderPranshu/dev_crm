<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PurchaseOrder, PurchaseRequisition, PurchaseOrderItem, VendorQuotation, Rfq};
use DB;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:purchase-order-list|purchase-order-create|purchase-order-show|purchase-order-edit|purchse-order-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:purchase-order-pay', ['only' => ['pay']]);
        $this->middleware('permission:purchase-order-show', ['only' => ['show']]);

        $this->middleware('permission:rfq-compare', ['only' => ['compare']]);
    }


    public function purchaseorderconvert(Request $request, $id)
    {
        // dd($id);

        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id'
        ]);

        // dd($data);

        DB::beginTransaction();

        try {

            $pr = PurchaseRequisition::with('items.product')->findOrFail($id);

            if ($pr->status != 'approved') {
                return back()->with('error_message', 'Purchase Order is already created');
            }

            $poNumber = 'PO-' . str_pad(PurchaseOrder::count() + 1, 5, "0", STR_PAD_LEFT);

            $po = PurchaseOrder::create([
                'po_number'       => $poNumber,
                'vendor_id'       => $data['vendor_id'],
                'requisition_id' => $pr->id,
            ]);

            $totalAmount = 0;
            foreach ($pr->items as $item) {
                $itemAmount = $item->to_order_qty * $item->product->cost_price;
                $totalAmount += $itemAmount;

                PurchaseOrderItem::create([
                    'po_id'      => $po->id,
                    'product_id' => $item->product_id,
                    'order_qty' => $item->to_order_qty,
                    'amount'    => $itemAmount,
                ]);
            }

            $po->update(['total_amount' => $totalAmount]);

            $pr->update(['status' => 'processing']);

            DB::commit();

            return redirect()->route('admin.purchase.index')
                ->with('success_message', 'Purchase Order successfully created');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.purchase.index')->withInput()
                ->with('error_message', $e->getMessage());
        }
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $purchaseorders = PurchaseOrder::latest()->get();
        } else {
            $purchaseorders = PurchaseOrder::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }

        return view('admin.purchaseOrder.index', compact('purchaseorders'));
    }

    public function show($id)
    {
        $purchaseorder = PurchaseOrder::with('purchaseRequisition.items.product', 'vendor.tax', 'vendor.user')->findOrFail($id);

        // return $purchaseorder;
        return view('admin.purchaseOrder.show', compact('purchaseorder'));
    }




    public function compare($rfqId)
    {
        $quotations = VendorQuotation::with('vendor', 'items')
            ->where('rfq_id', $rfqId)
            // ->where('status', 'submitted')
            ->get();

        // Find lowest total
        $lowest = $quotations->min('total_amount');

        return view('admin.purchaseRequisition.compare', compact('quotations', 'lowest'));
    }


    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $quotation = VendorQuotation::with('items')->findOrFail($id);

            // Create PO
            $po = PurchaseOrder::create([
                'rfq_id' => $quotation->rfq_id,
                'vendor_id' => $quotation->vendor_id,
                'vendor_quotation_id' => $quotation->id,
                'po_number' => 'PO-' . time(),
                'total_amount' => $quotation->total_amount,
                'order_date' => now(),
                'branch_id' => $quotation->rfq->branch_id
            ]);

            // Copy items
            foreach ($quotation->items as $item) {
                PurchaseOrderItem::create([
                    'po_id' => $po->id,
                    'product_id' => $item->product_id,
                    'order_qty' => $item->quantity,
                    'amount' => $item->price,
                ]);
            }

            // Update quotation status
            $quotation->update(['status' => 'approved']);

            // Reject others
            VendorQuotation::where('rfq_id', $quotation->rfq_id)
                ->where('id', '!=', $quotation->id)
                ->update(['status' => 'rejected']);

            // Lock RFQ
            Rfq::where('id', $quotation->rfq_id)
                ->update(['status' => 'closed']);

            DB::commit();

            return redirect()->route('po.show', $po->id)
                ->with('success', 'PO Generated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }


    public function reject($id)
    {
        VendorQuotation::where('id', $id)->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Quotation Rejected');
    }

    public function showPO($id)
    {
        $po = PurchaseOrder::with('items')->findOrFail($id);
        return view('admin.purchaseOrder.show', compact('po'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required'
    ]);

    $purchase = PurchaseOrder::findOrFail($id);

    $purchase->status = $request->status;
    $purchase->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.'
    ]);
}
}
