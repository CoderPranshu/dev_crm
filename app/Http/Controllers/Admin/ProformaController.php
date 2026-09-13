<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Proforma, ProformaItem, Tax, Hsn, Company, User, Lead};
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ProformaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:performa-list|performa-create|performa-show|performa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:performa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:performa-show', ['only' => ['view', 'pdf']]);
        // $this->middleware('permission:payables-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $proformas = Proforma::with('customer')
            ->orderBy('customer_id')
            ->orderBy('proforma_date') // FIFO for calculation
            ->get();

        $proformaPayments = \App\Models\ProformaPayment::select(
                'proforma_id',
                DB::raw('SUM(amount) as total_paid')
            )
            ->whereNotNull('proforma_id')
            ->groupBy('proforma_id')
            ->pluck('total_paid', 'proforma_id');

        $customerAdvance = \App\Models\ProformaPayment::select(
                'customer_id',
                DB::raw('SUM(amount) as total_paid')
            )
            ->whereNull('proforma_id')
            ->groupBy('customer_id')
            ->pluck('total_paid', 'customer_id');

        // Reverse for UI (latest first)
        $proformas = $proformas->reverse()->values();

        return view('admin.proforma.index', compact(
            'proformas',
            'proformaPayments',
            'customerAdvance'
        ));
    }

    public function create()
    {
        $customers = Company::where('is_blocked', 0)->get();
        $products = DB::table('products')->get();
        $gsts = Tax::get();
        $hsn = Hsn::get();

        return view('admin.proforma.add', compact('customers', 'products', 'gsts', 'hsn'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'      => 'required',
            'proforma_date'    => 'required|date',
            'branch_id'        => 'required',
            'notes'           => 'nullable',
            'lead_id' => 'nullable',

            'product_id'       => 'required|array',
            'product_id.*'     => 'required|integer',

            'quantity'         => 'required|array',
            'quantity.*'       => 'required|integer|min:1',

            'price'            => 'required|array',
            'price.*'          => 'required|numeric|min:0',

            'hsn_code'         => 'required|array',
            'hsn_code.*'       => 'required|string|max:20',

            'gst'              => 'required|array',
            'gst.*'            => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {

            // Safer proforma number generation
            $last   = Proforma::latest('id')->first();
            $nextId = $last ? $last->id + 1 : 1;
            $number = 'PF-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

            $subtotal = 0;
            $totalTax = 0;

            // Create Proforma first
            $proforma = Proforma::create([
                'proforma_no'   => $number,
                'customer_id'   => $request->customer_id,
                'proforma_date' => $request->proforma_date,
                'subtotal'      => 0,
                'tax'           => 0,
                'total'         => 0,
                'status'        => 'proforma',
                'notes'         => $request->notes,
                'branch_id'     => $request->branch_id,
                'lead_id' => $request->lead_id
            ]);

            foreach ($request->product_id as $index => $pid) {

                // ✅ Explicit casting (fixes your error)
                $qty     = (int) $request->quantity[$index];
                $price   = (float) $request->price[$index];
                $gstRate = (float) $request->gst[$index];
                $hsnCode = trim($request->hsn_code[$index]);

                $lineAmount = $price * $qty;
                $taxAmount  = ($lineAmount * $gstRate) / 100;

                $subtotal += $lineAmount;
                $totalTax += $taxAmount;

                ProformaItem::create([
                    'proforma_id' => $proforma->id,
                    'product_id'  => $pid,
                    'hsn_code'    => $hsnCode,
                    'price'       => $price,
                    'quantity'    => $qty,
                    'gst'         => $gstRate,
                    'tax_amount'  => $taxAmount,
                    'line_total'  => $lineAmount + $taxAmount
                ]);
            }

            // Update final totals
            $proforma->update([
                'subtotal' => round($subtotal, 2),
                'tax'      => round($totalTax, 2),
                'total'    => round($subtotal + $totalTax, 2)
            ]);

            if ($request->filled('lead_id')) {
                Lead::where('id', $request->lead_id)
                    ->update(['stage' => 'Payment Waiting']);
            }

            DB::commit();

            $vendorUser = $proforma->customer?->user;

            $users = collect([$vendorUser])->filter();

            if ($users->isNotEmpty()) {
                sendSystemNotification(
                    users: $users->all(),
                    title: 'New Proforma Created',
                    message: 'A new proforma #' . $proforma->id . ' was created by ' . auth()->user()->name,
                    type: 'proforma_created',
                    url: route('admin.proforma.index'),
                    extra: [
                        'proforma_id' => $proforma->id,
                        'created_by' => auth()->id(),
                    ]
                );
            }


            return redirect()
                ->route('admin.proforma.index')
                ->with('success_message', 'Proforma Invoice Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error_message', $e->getMessage())
                ->withInput();
        }
    }



    public function view($id)
    {
        $proforma = Proforma::with([
            'items.product',
            'customer',
            'payment'
        ])->findOrFail($id);

        $received = $proforma->payment->sum('amount');
        // dd($received);

        return view('admin.proforma.view', compact('proforma', 'received'));
    }


    public function pdf($id)
    {
        $proforma = Proforma::with([
            'items.product',
            'customer',
            'payment'
        ])->findOrFail($id);

        $received = $proforma->payment->sum('amount');

        $pdf = Pdf::loadView('admin.proforma.pdf', compact('proforma', 'received'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Proforma-' . $proforma->proforma_no . '.pdf');
    }

    public function edit($id)
    {
        $proforma = Proforma::with('items')->findOrFail($id);
        $customers = DB::table('companies')->get();
        $products = DB::table('products')->get();
        $gsts = Tax::get();
        $hsn = Hsn::get();

        return view('admin.proforma.edit', compact('proforma', 'customers', 'products', 'gsts', 'hsn'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id'      => 'required',
            'proforma_date'    => 'required|date',
            'notes' => 'nullable',
            'branch_id' => 'nullable',

            'product_id'       => 'required|array',
            'product_id.*'     => 'required|integer',

            'quantity'         => 'required|array',
            'quantity.*'       => 'required|integer|min:1',

            'price'            => 'required|array',
            'price.*'          => 'required|numeric|min:0',

            'hsn_code'         => 'required|array',
            'hsn_code.*'       => 'required|string|max:20',

            'gst'              => 'required|array',
            'gst.*'            => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {

            $proforma = Proforma::findOrFail($id);

            $subtotal = 0;
            $totalTax = 0;

            // Update main proforma
            $proforma->update([
                'customer_id'   => $request->customer_id,
                'proforma_date' => $request->proforma_date,
                'notes'         => $request->notes,
                'branch_id' => $request->branch_id
            ]);

            // Remove old items
            ProformaItem::where('proforma_id', $proforma->id)->delete();

            // Insert updated items
            foreach ($request->product_id as $index => $pid) {

                $qty     = (int) $request->quantity[$index];
                $price   = (float) $request->price[$index];
                $gstRate = (float) $request->gst[$index];
                $hsnCode = trim($request->hsn_code[$index]);

                $lineAmount = $price * $qty;
                $taxAmount  = ($lineAmount * $gstRate) / 100;

                $subtotal += $lineAmount;
                $totalTax += $taxAmount;

                ProformaItem::create([
                    'proforma_id' => $proforma->id,
                    'product_id'  => $pid,
                    'hsn_code'    => $hsnCode,
                    'price'       => $price,
                    'quantity'    => $qty,
                    'gst'         => $gstRate,
                    'tax_amount'  => $taxAmount,
                    'line_total'  => $lineAmount + $taxAmount
                ]);
            }

            // Update totals
            $proforma->update([
                'subtotal' => round($subtotal, 2),
                'tax'      => round($totalTax, 2),
                'total'    => round($subtotal + $totalTax, 2)
            ]);

            DB::commit();

            return redirect()
                ->route('admin.proforma.index')
                ->with('success_message', 'Proforma Invoice Updated Successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error_message', $e->getMessage())
                ->withInput();
        }
    }
}
