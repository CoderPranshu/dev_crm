<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Rfq, RfqItem, VendorQuotation, VendorQuotationItem};
use DB;

class VendorQuotationController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('permission:rfq-quotation', ['only' => ['quotations']]);
        // $this->middleware('permission:rfq-send', ['only' => ['create', 'send']]);
        // $this->middleware('permission:rfq-show', ['only' => ['create', 'show']]);
    }
    
    public function create($rfqId)
    {
        // Get vendor from logged in user
        $vendor = \App\Models\Vendor::where('user_id', auth()->id())->first();

        if (!$vendor) {
            abort(403, 'Vendor not found');
        }

        $vendorId = $vendor->id;

        // Check vendor is assigned to RFQ
        $exists = DB::table('rfq_vendor')
            ->where('rfq_id', $rfqId)
            ->where('vendor_id', $vendorId)
            ->exists();

        if (!$exists) {
            abort(403, 'You are not allowed to quote for this RFQ');
        }

        // Check already submitted
        $alreadySubmitted = \App\Models\VendorQuotation::where('rfq_id', $rfqId)
            ->where('vendor_id', $vendorId)
            ->exists();

        if ($alreadySubmitted) {
            return redirect()->back()->with('error', 'You have already submitted quotation');
        }

        $rfq = \App\Models\Rfq::with('items')->findOrFail($rfqId);

        return view('admin.vendorQuotation.create', compact('rfq'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rfq_id' => 'required',
            'prices' => 'required|array',
        ]);

        // Get vendor from logged in user
        $vendor = \App\Models\Vendor::where('user_id', auth()->id())->first();

        if (!$vendor) {
            abort(403, 'Vendor not found');
        }

        $vendorId = $vendor->id;

        // ✅ SECURITY CHECK: Vendor must be assigned
        $exists = DB::table('rfq_vendor')
            ->where('rfq_id', $request->rfq_id)
            ->where('vendor_id', $vendorId)
            ->exists();

        if (!$exists) {
            abort(403, 'Unauthorized action');
        }

        // ✅ PREVENT DUPLICATE SUBMISSION
        $alreadySubmitted = \App\Models\VendorQuotation::where('rfq_id', $request->rfq_id)
            ->where('vendor_id', $vendorId)
            ->exists();

        if ($alreadySubmitted) {
            return back()->with('error', 'Quotation already submitted');
        }

        DB::beginTransaction();

        try {
            $quotation = \App\Models\VendorQuotation::create([
                'rfq_id' => $request->rfq_id,
                'vendor_id' => $vendorId, // ✅ FIXED HERE
                'quotation_number' => 'QT-' . time(),
                'note' => $request->note,
                'status' => 'submitted',
            ]);

            $total = 0;

            foreach ($request->prices as $productId => $price) {

                $quantity = $request->quantities[$productId];
                $delivery = $request->delivery_days[$productId] ?? 0;

                \App\Models\VendorQuotationItem::create([
                    'vendor_quotation_id' => $quotation->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'delivery_days' => $delivery,
                ]);

                $total += ($price * $quantity);
            }

            // Update total
            $quotation->update(['total_amount' => $total]);

            // Update pivot status
            DB::table('rfq_vendor')
                ->where('rfq_id', $request->rfq_id)
                ->where('vendor_id', $vendorId) // ✅ FIXED HERE
                ->update(['status' => 'responded']);

            DB::commit();

            return redirect()->route('vendor.dashboard')->with('success_message', 'Quotation Submitted');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error_message', $e->getMessage());
        }
    }

    public function quotations($rfqId)
    {
        $quotations = VendorQuotation::with('vendor', 'items')
            ->where('rfq_id', $rfqId)
            ->get();

        return view('admin.vendorQuotation.index', compact('quotations'));
    }

    public function view($id)
    {
        $quotation = VendorQuotation::with([
            'vendor',
            'items',
            'items.product' // if you have product relation
        ])->findOrFail($id);

        return view('admin.vendorQuotation.view', compact('quotation'));
    }
}
