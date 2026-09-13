<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PurchaseBill, PurchaseBillItem, VendorPayment};
use PDF;

class PurchaseBillController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:purchase-bill-list|purchase-bill-create|purchase-bill-edit|paypurchase-billables-delete', ['only' => ['index','store']]);
        $this->middleware('permission:purchase-bill-pay', ['only' => ['pay']]);
        $this->middleware('permission:purchase-bill-show', ['only' => ['show','pdf']]);
        // $this->middleware('permission:payables-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $purchases = PurchaseBill::latest()->get();
        }else{
            $purchases = PurchaseBill::where('branch_id', auth()->user()->branch_id)->get();
        }

        return view('admin.purchase.index', compact('purchases'));
    }

    public function show(PurchaseBill $bill)
    {
        $bill->load('items.product');
        return view('admin.purchase.show', compact('bill'));
    }

    // Pay bill (partial / full)
    public function pay(Request $request, PurchaseBill $bill)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $bill->due_amount,
            'payment_mode' => 'required|string'
        ]);

        VendorPayment::create([
            'purchase_bill_id' => $bill->id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'payment_date' => now()
        ]);

        $bill->paid_amount += $request->amount;
        $bill->due_amount = $bill->total_amount - $bill->paid_amount;
        $bill->status = $bill->due_amount == 0 ? 'paid' : 'partial';
        $bill->save();

        return back()->with('success', 'Payment recorded successfully');
    }

    // PDF download
    public function pdf(PurchaseBill $bill)
    {
        $bill->load('items.product');

        $pdf = PDF::loadView('admin.purchase.pdf', compact('bill'));
        return $pdf->download('Purchase-Bill-' . $bill->bill_no . '.pdf');
    }
}


