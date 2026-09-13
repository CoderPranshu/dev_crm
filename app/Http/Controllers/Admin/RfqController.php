<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\{Rfq, RfqItem, PurchaseRequisition, PurchaseRequisitionItem};

class RfqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:rfq-list|rfq-create|rfq-send|rfq-show', ['only' => ['index', 'store']]);
        $this->middleware('permission:rfq-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:rfq-send', ['only' => ['create', 'send']]);
        $this->middleware('permission:rfq-show', ['only' => ['create', 'show']]);
    }
    
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $rfqs = Rfq::latest()->get();
        }else{
            $rfqs = Rfq::latest()->get();
        }

        return view('admin.purchaseRequisition.rfqtable', compact('rfqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pr_id' => 'required',
            'vendors' => 'required|array',
            'last_date' => 'required|date',
            'branch_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $rfq = Rfq::create([
                'pr_id' => $request->pr_id,
                'rfq_number' => 'RFQ-' . time(),
                'last_date' => $request->last_date,
                'branch_id' => $request->branch_id
            ]);

            // UPDATE PR STATUS HERE
            PurchaseRequisition::where('id', $request->pr_id)
                ->update(['status' => 'processing']);

            // Get PR items
            $prItems = PurchaseRequisitionItem::where('requisition_id', $request->pr_id)->get();

            foreach ($prItems as $item) {
                RfqItem::create([
                    'rfq_id' => $rfq->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->required_qty,
                ]);
            }

            // Attach vendors
            foreach ($request->vendors as $vendorId) {
                DB::table('rfq_vendor')->insert([
                    'rfq_id' => $rfq->id,
                    'vendor_id' => $vendorId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success_message', 'RFQ Created Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error_message', $e->getMessage());
        }
    }

    public function send($id)
    {
        $rfq = Rfq::findOrFail($id);
        $rfq->update(['status' => 'sent']);

        // Optional: Send Email Here

        return back()->with('success', 'RFQ Sent to Vendors');
    }

    public function show($id)
    {
        $rfq = Rfq::with('items', 'vendors')->findOrFail($id);
        return view('admin.purchaseRequisition.rfqshow', compact('rfq'));
    }
}
