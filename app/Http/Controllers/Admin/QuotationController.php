<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Quotation, User, Company, PaymentType, PaymentStatus, PaymentCurrency, QuotationItem, Tax, Hsn, Product, Proforma, ProformaItem, Lead};
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\QuotationMail;
use Mail;
use DB;


class QuotationController extends Controller
{
    public function index()
    {
        $quotations = Quotation::latest()->get();
        return view('admin.quotation.index', compact('quotations'));
    }

    public function create($id = null)
    {
        $users = User::latest()->get();
        $companies = Company::latest()->get();
        $payment_type = PaymentType::all();
        $payment_status = PaymentStatus::all();
        $payment_currency = PaymentCurrency::all();
        $gsts = Tax::all();
        $hsns = Hsn::all();
        $products = Product::where('category_id', '3')->get();

        return view('admin.quotation.add', compact('users', 'companies', 'payment_status', 'payment_type', 'payment_currency', 'gsts', 'hsns', 'products', 'id'));
    }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'client_id' => 'required|exists:companies,id',
            'create_date' => 'required|date',
            'due_date' => 'required|date',

            'payment_type' => 'nullable',
            'payment_currency' => 'nullable',

            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',

            'unit_price' => 'required|array|min:1',
            'unit_price.*' => 'required|numeric|min:0',

            'description' => 'required|array|min:1',
            'description.*' => 'required',

            /*
             * Optional lead ID when quotation create page
             * was opened from a lead.
             */
            'id' => 'nullable|exists:leads,id',

            'discount' => 'nullable|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',

            'sales_credit' => 'nullable|exists:users,id',
            'note' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
        ], [
            'description.*.required' => 'Description required',
            'unit_price.*.required' => 'Unit price required',
            'quantity.*.required' => 'Quantity required',
        ]);


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | OPTIONAL LEAD
            |--------------------------------------------------------------------------
            */

            $lead = null;

            if ($request->filled('id')) {
                $lead = Lead::findOrFail($request->id);
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE REGULAR QUOTATION
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            | This screen creates NORMAL / REGULAR quotations.
            | Quick and Detailed quotations are created from Lead Index.
            |
            */

            $quotation = Quotation::create([

                'client_id' => $request->client_id,

                /*
                 * Keep lead relation when this form was opened
                 * from a lead. Otherwise null.
                 */
                'lead_id' => $lead?->id,

                'user_id' => Auth::id(),

                /*
                 * Used by Quotation Index to distinguish:
                 * regular / quick / detailed.
                 */
                'quotation_type' => 'regular',

                'create_date' => $request->create_date,

                'due_date' => $request->due_date,

                'note' => $request->note,

                'terms_condition' =>
                    $request->terms_conditions,

                'payment_type' =>
                    $request->payment_type,

                'payment_status' =>
                    $request->payment_status,

                'payment_currency' =>
                    $request->payment_currency,

                'discount' =>
                    (float) ($request->discount ?? 0),

                'vat' =>
                    (float) ($request->vat ?? 0),

                'sales_credit' =>
                    $request->sales_credit,
            ]);


            /*
            |--------------------------------------------------------------------------
            | CREATE QUOTATION ITEMS
            |--------------------------------------------------------------------------
            */

            foreach ($request->quantity as $key => $value) {

                QuotationItem::create([

                    'quotation_id' =>
                        $quotation->id,

                    'quantity' =>
                        $request->quantity[$key],

                    'description' =>
                        $request->description[$key],

                    'unit_price' =>
                        $request->unit_price[$key],

                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE LEAD STAGE
            |--------------------------------------------------------------------------
            |
            | Existing behavior preserved.
            |
            | This is a Regular Quotation, therefore we are NOT setting
            | quick-quotation or detailed-quotation status here.
            |
            */

            if ($lead) {

                $lead->stage =
                    'Proposal Sent';

                $lead->save();
            }


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | RESPONSE / REDIRECT
            |--------------------------------------------------------------------------
            */

            if ($request->ajax()) {

                if ($lead) {

                    return response()->json([
                        'status' => true,
                        'quotation_id' => $quotation->id,
                        'quotation_type' => 'regular',
                        'redirect' =>
                            route('admin.salespipeline'),
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'quotation_id' => $quotation->id,
                    'quotation_type' => 'regular',
                    'redirect' =>
                        route(
                            'admin.quotation.view',
                            ['id' => $quotation->id]
                        ),
                ]);
            }


            if ($lead) {

                return redirect()
                    ->route('admin.salespipeline')
                    ->with(
                        'success_message',
                        'Quotation created successfully'
                    );
            }


            return redirect()->route(
                'admin.quotation.view',
                ['id' => $quotation->id]
            );


        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);


            if ($request->ajax()) {

                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }


            return back()
                ->withInput()
                ->with(
                    'error_message',
                    'Unable to create quotation.'
                );
        }
    }

    public function show(Quotation $quotation, $id)
    {
        $settings = '';
        $quotation = Quotation::find($id);
        // $templates = EmailTemplate::all();
        $total = 0;
        foreach ($quotation->items as $item) {
            $total = $total + ($item->quantity * $item->unit_price);
        }
        return view('admin.quotation.view-quotation', compact('quotation', 'settings', 'total'));
    }

    public function edit(Quotation $quotation, $id)
    {
        $quotation = Quotation::find($id);
        $clients = Company::all();
        // $payment_type = PaymentType::all();
        // $payment_status = PaymentStatus::all();
        // $payment_currency = PaymentCurrency::all();

        $gsts = Tax::all();
        $hsns = Hsn::all();
        $products = Product::where('category_id', '3')->get();

        $total = 0;
        foreach ($quotation->items as $item) {
            $total = $total + ($item->quantity * $item->unit_price);
        }

        return view('admin.quotation.edit')->with([
            'clients' => $clients,
            'quotation' => $quotation,
            'total_price' => $total,
            'gsts' => $gsts,
            'hsns' => $hsns,
            'products' => $products
        ]);
    }

    public function update(Request $request, Quotation $quotation, $id)
    {
        $request->validate([
            'client_id' => 'required',
            'create_date' => 'required',
            'due_date' => 'required',
            'payment_type' => 'nullable',
            'payment_currency' => 'nullable',
            'quantity.*' => 'required',
            'unit_price.*' => 'required',
            'description.*' => 'required',
        ], [
            'description.*.required' => 'Description required',
            'unit_price.*.required' => 'Unit price required',
            'quantity.*.required' => 'Quantity required'
        ]);

        $quotation = Quotation::find($id);
        $quotation->client_id = $request->client_id;
        $quotation->user_id = Auth::id();
        $quotation->create_date = $request->create_date;
        $quotation->note = $request->note;
        $quotation->payment_type = $request->payment_type;
        $quotation->payment_currency = $request->payment_currency;
        $quotation->discount = $request->discount ?? 0;
        $quotation->terms_condition = $request->terms_conditions;
        $quotation->vat = $request->vat ?? 0;
        $quotation->update();

        $items = QuotationItem::where('quotation_id', $quotation->id);
        $items->delete();

        foreach ($request->quantity as $key => $value) {
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'quantity' => $request->quantity[$key],
                'description' => $request->description[$key],
                'unit_price' => $request->unit_price[$key]
            ]);
        }

        return response()->json(['redirect' => route('admin.quotation.view', ['id' => $quotation->id])]);
    }

    public function printQuotation($id)
    {
        $quotation = Quotation::find($id);
        $total_price = 0;
        foreach ($quotation->items as $item) {
            $total_price = $total_price + ($item->quantity * $item->unit_price);
        }
        $total_price = $total_price * ($quotation->vat / 100 + 1);
        $file_name = date('Y-m-d-H-i-s') . '-quotation-' . $quotation->id . '.pdf';
        $pdf = PDF::loadView('admin.quotation.pdf', compact('quotation', 'total_price'));
        $quotationPath = 'assets/pdf/' . $file_name;
        if ($pdf->save($quotationPath)) {
            return $pdf->stream();
        } else {
            return false;
        }
    }

    public function destroy(Quotation $quotation, $id)
    {
        $quotation = Quotation::find($id);
        if ($quotation) {
            $quotation->delete();
            return redirect()->back()->with(['success_message' => 'Quotation deleted successfully']);
        }
        return redirect()->back()->with(['error_message' => 'Quotation not found']);
    }

    public function sendQuotation($id)
    {
        $quotation = Quotation::with('items.product', 'client')->findOrFail($id);

        $total = $quotation->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });

        \Mail::to($quotation->client->email)
            ->send(new QuotationMail($quotation, $total));

        return back()->with('success', 'Quotation sent successfully!');
    }

    // public function createProforma(Request $request, $id)
    // {
    //     $quotation = Quotation::where('id', $id)->firstOrFail();

    //     // dd($quotation);

    //     $quotationItem = QuotationItem::where('quotation_id', $id)->sum(DB::raw('unit_price * quantity'));

    //     // dd($quotationItem);
    //     $taxrate = $quotation->vat;

    //     $taxvalue = ($quotationItem * $taxrate) / 100;

    //     $last   = Proforma::latest('id')->first();
    //     $nextId = $last ? $last->id + 1 : 1;
    //     $number = 'PF-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

    //    $performa = Proforma::create([
    //         'customer_id' => $quotation->client_id,
    //         'subtotal' => $quotationItem,
    //         'tax' => $taxvalue,
    //         'total' => $quotationItem + $taxvalue,
    //         'proforma_date' => now(),
    //         'proforma_no' => $number,
    //     ]);


    //         foreach ($request->product_id as $index => $pid) {

    //             // ✅ Explicit casting (fixes your error)
    //             $qty     = (int) $request->quantity[$index];
    //             $price   = (float) $request->price[$index];
    //             $gstRate = (float) $request->gst[$index];
    //             $hsnCode = trim($request->hsn_code[$index]);

    //             $lineAmount = $price * $qty;
    //             $taxAmount  = ($lineAmount * $gstRate) / 100;

    //             $subtotal += $lineAmount;
    //             $totalTax += $taxAmount;

    //             ProformaItem::create([
    //                 'proforma_id' => $proforma->id,
    //                 'product_id'  => $pid,
    //                 'hsn_code'    => $hsnCode,
    //                 'price'       => $price,
    //                 'quantity'    => $qty,
    //                 'gst'         => $gstRate,
    //                 'tax_amount'  => $taxAmount,
    //                 'line_total'  => $lineAmount + $taxAmount
    //             ]);
    //         }
    // }



    public function createProforma(Request $request, $id)
    {
        $quotation = Quotation::where('id', $id)->firstOrFail();

        // dd($quotation);

        $last   = Proforma::latest('id')->first();
        $nextId = $last ? $last->id + 1 : 1;
        $number = 'PF-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $quotationItems = QuotationItem::where('quotation_id', $id)->get();

        $subtotal = 0;
        $totalTax = 0;

        foreach ($quotationItems as $item) {
            $lineAmount = $item->unit_price * $item->quantity;
            $taxAmount  = ($lineAmount * $item->tax) / 100;

            $subtotal += $lineAmount;
            $totalTax += $taxAmount;
        }

        $performa = Proforma::create([
            'customer_id'   => $quotation->client_id,
            'subtotal'      => $subtotal,
            'tax'           => $totalTax,
            'total'         => $subtotal + $totalTax,
            'proforma_date' => now(),
            'proforma_no'   => $number,
        ]);

        foreach ($quotationItems as $item) {
            $lineAmount = $item->unit_price * $item->quantity;
            $taxAmount  = ($lineAmount * $item->tax) / 100;

            ProformaItem::create([
                'proforma_id' => $performa->id,
                'product_id'  => $item->description,
                'hsn_code'    => $item->hsn_code,
                'price'       => $item->unit_price,
                'quantity'    => $item->quantity,
                'gst'         => $quotation->vat,
                // 'tax_amount'  => $taxAmount,
                'line_total'  => $lineAmount + $taxAmount
            ]);
        }

        return back()->with('success_message', 'Proforma Created Successfully');
    }
}








