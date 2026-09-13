<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{SalesOrder, Invoice, InvoiceItem, Company, Product, Payment, Tax, Hsn, BankDetail, Proforma, ProformaPayment};
use Auth;
use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;


class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:invoice-list|invoice-create|invoice-edit|invoice-delete|invoice-show', ['only' => ['index', 'store']]);
        $this->middleware('permission:invoice-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:invoice-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:invoice-delete', ['only' => ['destroy']]);
        $this->middleware('permission:invoice-show', ['only' => ['view', 'pdf', 'show']]);
        $this->middleware('permission:disptach-invoice-list', ['only' => ['view', 'dispatchinvoice']]);
    }

    public function generateFromSalesOrder($id)
    {
        $so = SalesOrder::with(['proforma', 'items', 'customer.user'])->findOrFail($id);

        // Safety check
        if ($so->status != 'ready to dispatch') {
            return back()->with('error_message', 'Order is not ready for the dispatch yet.');
        }

        DB::beginTransaction();

        try {

            // -----------------------------
            // PAYMENT CALCULATION (FIXED)
            // -----------------------------
            $proformaId = $so->proforma_id;

            $totalPaid = ProformaPayment::where('proforma_id', $proformaId)
                ->sum('amount');

            $invoiceTotal = round($so->proforma->total, 2);
            $totalPaid    = round($totalPaid, 2);

            $due = round($invoiceTotal - $totalPaid, 2);

            if ($totalPaid <= 0) {
                $status = 'unpaid';
            } elseif ($due <= 0.01) {
                $status = 'paid';
            } else {
                $status = 'partial_paid';
            }

            // -----------------------------
            // INVOICE NUMBER (SAFE)
            // -----------------------------
            $lastId = Invoice::max('id') + 1;
            $invoiceNo = 'INV-' . str_pad($lastId, 5, "0", STR_PAD_LEFT);

            // -----------------------------
            // CREATE INVOICE
            // -----------------------------
            $invoice = Invoice::create([
                'invoice_no'      => $invoiceNo,
                'sales_order_id'  => $so->id,
                'customer_id'     => $so->customer_id,
                'invoice_date'    => now(),
                'subtotal'        => $so->subtotal,
                'tax'             => $so->tax,
                'total'           => $so->total,
                'status'          => $status,
                'branch_id'       => $so->branch_id
            ]);

            // -----------------------------
            // CREATE INVOICE ITEMS
            // -----------------------------
            foreach ($so->items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                    'line_total' => $item->line_total,
                    'tax_rate'   => $item->gst,
                    'hsn_code'   => $item->hsn_code
                ]);
            }

            // -----------------------------
            // UPDATE SALES ORDER
            // -----------------------------
            $so->update(['status' => 'billing']);

            DB::commit();

            // -----------------------------
            // NOTIFICATIONS
            // -----------------------------
            $vendorUser = $so->customer?->user;

            $systemRecipients = getNotificationRecipients(
                type: 'invoice_generate',
                channel: 'system',
                extraUsers: $vendorUser ? [$vendorUser] : []
            );

            $mailRecipients = getNotificationRecipients(
                type: 'invoice_generate',
                channel: 'mail',
                extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
            )->filter(fn($user) => !empty($user->email));

            // System Notification
            if ($systemRecipients->isNotEmpty()) {
                sendSystemNotification(
                    users: $systemRecipients->all(),
                    title: 'Invoice Generated',
                    message: 'Invoice ' . $invoice->invoice_no . ' has been generated',
                    type: 'invoice_generate',
                    url: route('admin.invoice.index'),
                    extra: [
                        'sales_order_id' => $so->id,
                        'received_by'    => auth()->id(),
                    ]
                );
            }

            // Mail (optional - currently commented)
            /*
            foreach ($mailRecipients as $user) {
                $mailData = [
                    'subject' => 'Invoice Generated',
                    'name'    => $user->name,
                    'message' => 'Invoice ' . $invoice->invoice_no . ' has been generated against Sales Order ' . $so->so_no,
                ];

                Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
            }
            */

            return back()->with('success_message', 'Invoice generated successfully.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error_message', $e->getMessage());
        }
    }

    public function generatepacking($id)
    {
        $so = SalesOrder::with('items', 'proforma')->findOrFail($id);

        // dd($so->proforma->payment->sum('amount'));

        $r = $so->proforma->payment->sum('amount');
        $p = $so->proforma->total;

        if (abs($r - $p) < 0.01) {
            $status = 'paid';
        } elseif ($r == 0) {
            $status = 'unpaid';
        } else {
            $status = 'partial_paid';
        }

        // dd($status);

        if ($so->status != 'ready to delivery') {
            return back()->with('error_message', 'Order is not ready for the dispatch yet.');
        }

        DB::beginTransaction();

        try {

            // ==============================
            // STOCK DEDUCTION
            // ==============================
            foreach ($so->items as $item) {

                if (!$item->product) {
                    throw new \Exception("Product not found for item ID: {$item->id}");
                }

                $product = \App\Models\Product::where('id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new \Exception("Product not found (ID: {$item->product_id})");
                }

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $product->decrement('stock', $item->quantity);
            }

            // ==============================
            // UPDATE STATUS
            // ==============================
            $so->update(['status' => 'ready to dispatch']);

            DB::commit();

            // ==============================
            // NOTIFICATIONS (unchanged)
            // ==============================
            $vendorUser = $so->customer?->user;

            $systemRecipients = getNotificationRecipients(
                type: 'invoice_generate',
                channel: 'system',
                extraUsers: $vendorUser ? [$vendorUser] : []
            );

            $mailRecipients = getNotificationRecipients(
                type: 'invoice_generate',
                channel: 'mail',
                extraUsers: ($vendorUser && !empty($vendorUser->email)) ? [$vendorUser] : []
            )->filter(fn($user) => !empty($user->email));

            if ($systemRecipients->isNotEmpty()) {
                sendSystemNotification(
                    users: $systemRecipients->all(),
                    title: 'Packing Completed',
                    message: 'Packing for the order has been completed',
                    type: 'invoice_generate',
                    url: route('admin.invoice.index'),
                    extra: [
                        'proforma_id' => $so->id,
                        'received_by' => auth()->id(),
                    ]
                );
            }

            return back()->with('success_message', 'Stock deducted and packing completed.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error_message', $e->getMessage());
        }
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $invoices = Invoice::where('o_status', 'dispatched')->orWhere('sales_order_id', null)->latest()->get();
        } else {
            $invoices = Invoice::where('o_status', 'dispatched')->where('branch_id', auth()->user()->branch_id)->latest()->get();
        }
        return view('admin.invoice.index', compact('invoices'));
    }

    public function dispatchinvoice()
    {
        if (auth()->user()->hasRole('Admin')) {
            $invoices = Invoice::where('o_status', null)->latest()->get();
        } else {
            $invoices = Invoice::where('o_status', null)->where('branch_id', auth()->user()->branch_id)->latest()->get();
        }
        return view('admin.invoice.index', compact('invoices'));
    }


    public function view($id)
    {
        $invoice = Invoice::with([
            'items.product',
            'salesOrder.proforma.customer',
            'payments'
        ])->findOrFail($id);

        return view('admin.invoice.view', compact('invoice'));
    }


    public function pdf($id)
    {
        $invoice = Invoice::with([
            'items.product',
            'salesOrder.proforma.customer'
        ])->findOrFail($id);

        $company = [
            'name'    => config('app.name', 'Your Company Name'),
            'address' => 'Your Address, City, State, PIN',
            'phone'   => '9876543210',
            'email'   => 'info@company.com',
            'gst'     => 'GSTIN: 12ABCDE3456F7Z8'
        ];

        $pdf = Pdf::loadView('admin.invoice.pdf', compact('invoice', 'company'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Invoice-' . $invoice->invoice_no . '.pdf');
    }




    public function create()
    {
        $customers = Company::latest()->get();
        $products  = Product::latest()->get();
        $taxes = Tax::get();
        $hsns = Hsn::get();
        $bankDetails = BankDetail::get();

        return view('admin.invoice.add', compact('customers', 'products', 'taxes', 'hsns', 'bankDetails'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'customer_id'     => 'required|exists:companies,id',
            'invoice_date'    => 'required|date',
            'product_id'      => 'required|array',
            'product_id.*'    => 'required|exists:products,id',
            'price'           => 'required|array',
            'quantity'        => 'required|array',
            'hsn_id'          => 'nullable|array',
            'tax_rate'          => 'nullable|array',
            'payment_status'  => 'nullable|in:0,1',
            'due_date'        => 'required_if:payment_status,0|nullable|date',
            'acc_details'  => 'nullable|exists:bank_details,id',
            'decleration'     => 'nullable|string',
            'status' => 'nullable',
            'branch_id' => 'nullable',
        ]);

        DB::beginTransaction();

        try {

            $invoiceNo = 'INV-' . str_pad(Invoice::count() + 1, 5, '0', STR_PAD_LEFT);

            $subtotal = 0;
            $totalTax = 0;

            foreach ($request->product_id as $i => $pid) {

                $lineSubtotal = $request->price[$i] * $request->quantity[$i];
                $subtotal += $lineSubtotal;

                if (!empty($request->tax_id[$i])) {
                    $tax = Tax::find($request->tax_id[$i]);
                    $lineTax = ($lineSubtotal * $tax->rate) / 100;
                    $totalTax += $lineTax;
                }
            }

            $total = $subtotal + $totalTax;

            $invoice = Invoice::create([
                'invoice_no'      => $invoiceNo,
                'customer_id'     => $request->customer_id,
                'invoice_date'    => $request->invoice_date,
                'due_date'        => $request->payment_status == 0 ? $request->due_date : null,
                'subtotal'        => $subtotal,
                'tax'             => $totalTax,
                'total'           => $total,
                'payment_status'  => $request->payment_status,
                'acc_details'     => $request->acc_details,
                'decleration'     => $request->decleration,
                'status' => $request->status,
                'branch_id' => $request->branch_id
            ]);

            foreach ($request->product_id as $i => $pid) {

                $lineSubtotal = $request->price[$i] * $request->quantity[$i];
                $lineTax = 0;

                if (!empty($request->tax_id[$i])) {
                    $tax = Tax::find($request->tax_id[$i]);
                    $lineTax = ($lineSubtotal * $tax->rate) / 100;
                }

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $pid,
                    'hsn_id'     => $request->hsn_id[$i] ?? null,
                    'price'      => $request->price[$i],
                    'quantity'   => $request->quantity[$i],
                    'tax_rate'     => $request->tax_rate[$i] ?? null,
                    'tax_amount' => $lineTax,
                    'line_total' => $lineSubtotal + $lineTax
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.invoice.view', $invoice->id)
                ->with('success_message', 'Invoice created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error_message', $e->getMessage());
        }
    }





    public function show()
    {
        $user = auth()->user();

        // Check if admin
        $isAdmin = $user->role === 'admin';

        // ==============================
        // TOTAL INVOICES
        // ==============================
        $invoiceQuery = Proforma::query();

        if (!$isAdmin) {
            $invoiceQuery->where('branch_id', $user->branch_id);
        }

        $totalInvoices = $invoiceQuery->sum('total');

        // ==============================
        // TOTAL RECEIVED
        // ==============================
        $paymentQuery = ProformaPayment::query();

        if (!$isAdmin) {
            $paymentQuery->where('branch_id', $user->branch_id);
        }

        $totalReceived = $paymentQuery->sum('amount');

        // ==============================
        // TOTAL RECEIVABLE
        // ==============================
        $totalReceivable = $totalInvoices - $totalReceived;

        // ==============================
        // PAYMENTS GROUPED (BY CUSTOMER)
        // ==============================
        $payments = ProformaPayment::select(
            'customer_id',
            DB::raw('SUM(amount) as received'),
            DB::raw('MAX(id) as payment_id')
        )
            ->when(!$isAdmin, function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            })
            ->groupBy('customer_id')
            ->get()
            ->keyBy('customer_id');

        // ==============================
        // CUSTOMER RECEIVABLES
        // ==============================
        $customerReceivables = Proforma::select(
            'customer_id',
            DB::raw('SUM(total) as total_invoice')
        )
            ->when(!$isAdmin, function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            })
            ->groupBy('customer_id')
            ->with('customer')
            ->get()
            ->map(function ($row) use ($payments) {

                $payment = $payments[$row->customer_id] ?? null;

                $row->received = $payment->received ?? 0;
                $row->payment_id = $payment->payment_id ?? null;
                $row->due = $row->total_invoice - $row->received;

                return $row;
            });

        return view('admin.invoice.show', compact(
            'totalInvoices',
            'totalReceived',
            'totalReceivable',
            'customerReceivables'
        ));
    }

    // public function show()
    // {
    //     $user = auth()->user();

    //     // Check admin (adjust if needed)
    //     $isAdmin = $user->role === 'admin';

    //     // ==============================
    //     // TOTAL INVOICES
    //     // ==============================
    //     $invoiceQuery = Proforma::query();

    //     if (!$isAdmin) {
    //         $invoiceQuery->where('branch_id', $user->branch_id);
    //     }

    //     $totalInvoices = $invoiceQuery->sum('total');

    //     // ==============================
    //     // TOTAL RECEIVED
    //     // ==============================
    //     $paymentQuery = ProformaPayment::query();

    //     if (!$isAdmin) {
    //         $paymentQuery->where('branch_id', $user->branch_id);
    //     }

    //     $totalReceived = $paymentQuery->sum('amount');

    //     // ==============================
    //     // TOTAL RECEIVABLE (NO NEGATIVE)
    //     // ==============================
    //     $totalReceivable = max(0, $totalInvoices - $totalReceived);

    //     // ==============================
    //     // PAYMENTS GROUPED BY CUSTOMER
    //     // ==============================
    //     $payments = ProformaPayment::select(
    //             'customer_id',
    //             DB::raw('SUM(amount) as received'),
    //             DB::raw('MAX(id) as payment_id')
    //         )
    //         ->when(!$isAdmin, function ($q) use ($user) {
    //             $q->where('branch_id', $user->branch_id);
    //         })
    //         ->groupBy('customer_id')
    //         ->get()
    //         ->keyBy('customer_id');

    //     // ==============================
    //     // CUSTOMER RECEIVABLES
    //     // ==============================
    //     $customerReceivables = Proforma::select(
    //             'customer_id',
    //             DB::raw('SUM(total) as total_invoice')
    //         )
    //         ->when(!$isAdmin, function ($q) use ($user) {
    //             $q->where('branch_id', $user->branch_id);
    //         })
    //         ->groupBy('customer_id')
    //         ->with('customer')
    //         ->get()
    //         ->map(function ($row) use ($payments) {

    //             $payment = $payments[$row->customer_id] ?? null;

    //             $row->received = $payment->received ?? 0;
    //             $row->payment_id = $payment->payment_id ?? null;

    //             // BALANCE CALCULATION
    //             $balance = $row->total_invoice - $row->received;

    //             // ✅ FIX: No negative receivable
    //             $row->due = max(0, $balance);

    //             // ✅ OPTIONAL: track advance payment
    //             $row->advance = $balance < 0 ? abs($balance) : 0;

    //             return $row;
    //         });

    //     return view('admin.invoice.show', compact(
    //         'totalInvoices',
    //         'totalReceived',
    //         'totalReceivable',
    //         'customerReceivables'
    //     ));
    // }


    public function getBranchData($id)
    {
        $banks = BankDetail::where('branch_id', $id)->get();
        $hsns = Hsn::where('branch_id', $id)->get();
        $taxes = Tax::where('branch_id', $id)->get();
        $products = Product::where('branch_id', $id)->get();

        return response()->json([
            'banks' => $banks,
            'hsns' => $hsns,
            'taxes' => $taxes,
            'products' => $products
        ]);
    }
}
