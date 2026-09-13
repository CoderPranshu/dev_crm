<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Payment, Invoice, ProformaPayment, Proforma};
use Barryvdh\DomPDF\Facade\Pdf;
use DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'invoice_id'      => 'required|exists:invoices,id',
            'amount'          => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'payment_date'   => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            $invoice = Invoice::findOrFail($request->invoice_id);

            // Generate Receipt Number
            $receiptNo = 'RCPT-' . str_pad(Payment::count() + 1, 5, '0', STR_PAD_LEFT);

            // Create Payment
            $payment = Payment::create([
                'invoice_id'     => $invoice->id,
                'customer_id'    => $invoice->customer_id,
                'receipt_no'     => $receiptNo,
                'amount'         => $request->amount,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'payment_date'  => $request->payment_date,
                'status'         => 'received',
            ]);

            // ✅ Update Invoice Status
            if ($request->amount >= $invoice->total) {
                $invoice->update(['status' => 'paid']);
            } else {
                $invoice->update(['status' => 'partially_paid']);
            }

            DB::commit();

            return redirect()->route('admin.payment.view', $payment->id)
                ->with('success_message', 'Payment recorded successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_message', $e->getMessage());
        }
    }

    // public function view($id)
    // {
    //     $payment = Payment::with('invoice.salesOrder.proforma.customer')->findOrFail($id);
    //     return view('admin.payment.view', compact('payment'));
    // }

    public function view($id)
    {
        $payment = ProformaPayment::with('proforma.customer')
            ->findOrFail($id);
    
        $customerId = $payment->customer_id;
    
        // All payments of customer
        $payments = ProformaPayment::with('proforma')
            ->where('customer_id', $customerId)
            ->latest()
            ->get();
    
        // TOTAL RECEIVED
        $totalReceived = $payments->sum('amount');
    
        // TOTAL INVOICES (ALL PROFORMAS OF CUSTOMER)
        $totalInvoices = Proforma::where('customer_id', $customerId)->sum('total');
    
        // CALCULATIONS
        $pending = max(0, $totalInvoices - $totalReceived);
        $extra   = max(0, $totalReceived - $totalInvoices);
    
        return view('admin.payment.view', compact(
            'payments',
            'payment',
            'totalReceived',
            'totalInvoices',
            'pending',
            'extra'
        ));
    }

    public function pdf($id)
    {
        $payment = Payment::with('invoice.salesOrder.proforma.customer')->findOrFail($id);

        $company = [
            'name'    => config('app.name', 'Your Company Name'),
            'address' => 'Your Address, City, State',
            'phone'   => '9876543210',
            'email'   => 'info@company.com',
            'gst'     => 'GSTIN: 12ABCDE3456F7Z8'
        ];

        $pdf = Pdf::loadView('admin.payment.pdf', compact('payment', 'company'));
        return $pdf->stream('Receipt-' . $payment->receipt_no . '.pdf');
    }
}
