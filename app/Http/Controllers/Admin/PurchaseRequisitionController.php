<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PurchaseRequisition};
use Auth;

class PurchaseRequisitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:purchase-requisition-list|purchase-requisition-create|purchase-requisition-show|purchase-requisition-edit|purchase-requisition-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:purchase-requisition-pay', ['only' => ['pay']]);
        $this->middleware('permission:purchase-requisition-show', ['only' => ['show']]);
        // $this->middleware('permission:payables-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $purchases = PurchaseRequisition::latest()->get();
        }else{
            $purchases = PurchaseRequisition::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }

        return view('admin.purchaseRequisition.index', compact('purchases'));
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function delete(Request $request, $id)
    {

    }

    public function convertpurchase($id)
    {
        $purchaseReq = PurchaseRequisition::where('id',$id)->first();

        $purchaseReq->update([
            'status' => 'Approved',
            'approved_by' => Auth::user()->id
        ]);

        return back()->with('success_message', 'Data Approved successfully');
    }

    public function show($id)
    {
        // return $id;
        $purchase = PurchaseRequisition::with('user', 'items.product', 'approved')->where('id', $id)->first();

        // return $purchase;

        return view('admin.purchaseRequisition.show', compact('purchase'));
    }

}
