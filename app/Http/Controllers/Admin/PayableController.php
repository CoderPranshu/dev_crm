<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PurchaseBill};
use DB;
use App\Models\VendorPayment;
use PDF;

class PayableController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payable-list|payable-create|payable-edit|payable-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:payable-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payable-show', ['only' => ['show', 'pdf', 'vendorBills']]);
        // $this->middleware('permission:payables-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'Admin';
 
        // ==============================
        // BASE QUERY
        // ==============================
        $baseQuery = PurchaseBill::query();

        if (!$isAdmin) {
            $baseQuery->where('branch_id', $user->branch_id);
        }

        // ==============================
        // TOP CARDS
        // ==============================
        $totalPurchase = (clone $baseQuery)->sum('total_amount');
        $totalPaid     = (clone $baseQuery)->sum('paid_amount');
        $totalPayable  = (clone $baseQuery)->sum('due_amount');

        // ==============================
        // VENDOR-WISE SUMMARY
        // ==============================
        $vendorPayables = PurchaseBill::select(
            'supplier_name',
            DB::raw('SUM(total_amount) as total_purchase'),
            DB::raw('SUM(paid_amount) as total_paid'),
            DB::raw('SUM(due_amount) as total_due')
        )
            ->when(!$isAdmin, function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            })
            ->groupBy('supplier_name')
            ->get();

        return view('admin.payables.index', compact(
            'totalPurchase',
            'totalPaid',
            'totalPayable',
            'vendorPayables'
        ));
    }

    public function show(VendorPayment $payment)
    {
        $payment->load('bill');
        return view('admin.payables.show', compact('payment'));
    }

    public function pdf(VendorPayment $payment)
    {
        $payment->load('bill');

        $pdf = PDF::loadView(
            'admin.payables.pdf',
            compact('payment')
        );

        return $pdf->download(
            'Receipt-RCPT-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT) . '.pdf'
        );
    }


    public function vendorBills($supplier)
    {
        $bills = PurchaseBill::with('payments')
            ->where('supplier_name', $supplier)
            ->orderBy('bill_date', 'desc')
            ->get();

        return view('admin.payables.vendor_bills', compact('bills', 'supplier'));
    }
}
