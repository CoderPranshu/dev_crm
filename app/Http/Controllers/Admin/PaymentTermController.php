<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentTerm;
use File;

class PaymentTermController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:payment-terms-list|payment-terms-create|payment-terms-edit|payment-terms-delete', ['only' => ['index','store']]);
        $this->middleware('permission:payment-terms-create', ['only' => ['create','store']]);
        $this->middleware('permission:payment-terms-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:payment-terms-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $paymentterms = PaymentTerm::latest()->get();
        return view('admin.vendorpayment.index', compact('paymentterms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'doc' => 'nullable|mimes:pdf',
            'vendor_id' => 'nullable'
        ]);

        if($request->has('doc'))
        {
            $filename = uniqid().'.'.$request->doc->getClientOriginalExtension();
            $request->doc->move(public_path('uploads/vendor/paymentterm/'),$filename);
            $data['doc'] = $filename;
        }

        $res = PaymentTerm::create($data);

        if($res)
        {
            return back()->with('success_message', 'PaymentTerm created successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $payment = PaymentTerm::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'title' => 'nullable',
            'description' => 'nullable',
            'status' => 'nullable',
            'doc' => 'nullable|mimes:pdf',
            'vendor_id' => 'nullable'
        ]);

        if($request->has('doc'))
        {
            $file = public_path('uplaods/vendor/paymentterm',$payment->doc);

            if(File::exists($file))
            {
                File::delete($file);
            }

            $filename = uniqid().'.'.$request->doc->getClientOriginalExtension();
            $request->doc->move(public_path('uploads/vendor/paymentterm/'),$filename);
            $data['doc'] = $filename;
        }

        $res = $payment->update($data);

        if($res)
        {
            return back()->with('success_message', 'Payment term updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $payment = PaymentTerm::where('id', $id)->firstOrFail();

        $payment->delete();

        return back()->with('success_message', 'Payment term deleted successfully');
    }
}
