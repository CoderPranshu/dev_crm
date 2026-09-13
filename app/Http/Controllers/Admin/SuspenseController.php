<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuspenseEntry;
use DB;

class SuspenseController extends Controller
{

        public function __construct()
    {
        $this->middleware('permission:suspense-entry-list|suspense-entry-create', ['only' => ['index', 'store']]);
        $this->middleware('permission:suspense-entry-create', ['only' => ['create', 'store']]);
    }

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Assumption:
        | perform_payments = received payments
        | vendor_payments  = paid payments
        |--------------------------------------------------------------------------
        */

        $receivedPayments = DB::table('proforma_payments')
            ->select(
                'id',
                DB::raw("'received' as source_type"),
                DB::raw("amount as amount"),
                DB::raw("created_at as payment_date")
            )
            ->latest()
            ->get();

        $paidPayments = DB::table('vendor_payments')
            ->select(
                'id',
                DB::raw("'paid' as source_type"),
                DB::raw("amount as amount"),
                DB::raw("created_at as payment_date")
            )
            ->latest()
            ->get();

        $suspenseEntries = SuspenseEntry::latest()->get();

        $totalReceived = DB::table('proforma_payments')->sum('amount');
        $totalPaid = DB::table('vendor_payments')->sum('amount');

        $totalSuspenseReceived = SuspenseEntry::where('type', 'received')->sum('amount');
        $totalSuspensePaid = SuspenseEntry::where('type', 'paid')->sum('amount');

        $grandReceived = $totalReceived + $totalSuspenseReceived;
        $grandPaid = $totalPaid + $totalSuspensePaid;

        $difference = $grandReceived - $grandPaid;

        return view('admin.suspense.index', compact(
            'receivedPayments',
            'paidPayments',
            'suspenseEntries',
            'totalReceived',
            'totalPaid',
            'totalSuspenseReceived',
            'totalSuspensePaid',
            'grandReceived',
            'grandPaid',
            'difference'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'entry_date'    => 'required|date',
            'type'          => 'required|in:received,paid',
            'amount'        => 'required|numeric|min:0.01',
            'reference_no'  => 'nullable|string|max:255',
            'description'   => 'nullable|string',
        ]);

        SuspenseEntry::create([
            'entry_date'   => $request->entry_date,
            'type'         => $request->type,
            'amount'       => $request->amount,
            'reference_no' => $request->reference_no,
            'description'  => $request->description,
        ]);

        return redirect()->route('admin.suspense.index')->with('success_message', 'Suspense entry added successfully.');
    }
}
