<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Company, Proforma, ProformaPayment, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:organization-list|organization-create|organization-edit|organization-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:organization-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:organization-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:organization-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $companies = Company::with('invoices', 'user')->latest()->get();

        foreach ($companies as $company) {

            $dates = $company->invoices
                ->sortBy('created_at')
                ->pluck('created_at')
                ->map(fn($date) => Carbon::parse($date));

            $diffs = [];

            for ($i = 1; $i < count($dates); $i++) {
                $diffs[] = $dates[$i]->diffInDays($dates[$i - 1]);
            }

            $company->avg_order_frequency = count($diffs)
                ? round(array_sum($diffs) / count($diffs), 2)
                : null;
        }

        return view('admin.company.index', compact('companies'));
    }


    public function customerLedger(Request $request, $id)
    {
        $from = $request->from_date;
        $to = $request->to_date;

        $proformas = Proforma::where('customer_id', $id)
            ->when($from, fn($q) => $q->whereDate('proforma_date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('proforma_date', '<=', $to))
            ->get()
            ->map(function ($proforma) {
                return [
                    'date' => $proforma->proforma_date,
                    'type' => 'Proforma',
                    'ref' => $proforma->proforma_no,
                    'debit' => $proforma->total,
                    'credit' => 0,
                ];
            });

        $payments = ProformaPayment::where('customer_id', $id)
            ->when($from, fn($q) => $q->whereDate('payment_date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('payment_date', '<=', $to))
            ->get()
            ->map(function ($payment) {
                return [
                    'date' => $payment->payment_date,
                    'type' => 'Payment',
                    'ref' => 'PAY-' . $payment->id,
                    'debit' => 0,
                    'credit' => $payment->amount,
                ];
            });

        $ledger = $proformas
            ->merge($payments)
            ->sortBy('date')
            ->values()
            ->toArray();

        $balance = 0;

        foreach ($ledger as $key => $row) {
            $balance += $row['debit'] - $row['credit'];
            $ledger[$key]['balance'] = $balance;
        }

        $totalBalance = $balance;

        return view('admin.company.ledger', compact('ledger', 'totalBalance', 'from', 'to', 'id'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable',
            'email' => 'required|email',
            'gst_no' => 'nullable',
            'address' => 'required',
            'ship_to' => 'nullable',
            'shipping' => 'nullable',
            'contact_person' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create([
            'name' => $data['contact_person'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        $res = Company::create([
            'name' => $data['name'],
            'user_id' => $user->id,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'gst_no' => $data['gst_no'],
            'address' => $data['address'],
            'shipping' => $data['shipping'],
            'ship_to' => $data['ship_to'],
        ]);
        // $res = Company::create($data);

        $user->assignRole('Vendor');

        if ($res) {
            return redirect()->back()->with('success_message', 'Organization listed successfully');
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Something is wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $company = Company::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|nullable',
            'email' => 'required|email|',
            'phone' => 'required',
            'gst_no' => 'nullable',
            'address' => 'nullable',
            'contact_person' => 'nullable',
            'shipping' => 'nullable',
            'ship_to' => 'nullable'
        ]);

        $res = $company->update($data);

        // dd($data);

        if ($res) {
            return redirect()->back()->with('success_message', 'Company updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function destroy(Request $request, $id)
    {
        $company = Company::where('id', $id)->firstOrFail();

        $res = $company->delete();

        if ($res) {
            return redirect()->back()->with('success_message', 'Organization deleted successfully');
        } else {
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }


    public function rate(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->rating = $request->rating;
        $company->save();

        return back()->with('success', 'Customer rated successfully');
    }


    public function block($id)
    {
        $company = Company::findOrFail($id);

        $company->is_blocked = !$company->is_blocked;
        $company->save();

        return back()->with('success', 'Customer status updated');
    }
}
