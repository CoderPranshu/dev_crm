<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;



class SubscriptionPaymentController extends Controller
{
    public function create(Request $request)
    {
        $subscription = Subscription::findOrFail($request->subscription_id);

        return view('admin.subscription-payment.create', compact('subscription'));
    }

    

    public function store(Request $request)
{
    $subscription =
        Subscription::findOrFail(
            $request->subscription_id
        );

    if(
        $request->amount >
        $subscription->due_amount
    ){
        return back()->with(
            'error',
            'Payment exceeds due amount'
        );
    }

    SubscriptionPayment::create([

        'subscription_id' =>
            $subscription->id,

        'amount' =>
            $request->amount,

        'payment_date' =>
            $request->payment_date,

        'payment_method' =>
            $request->payment_method,

        'transaction_id' =>
            $request->transaction_id,

        'remarks' =>
            $request->remarks

    ]);

    return redirect()
        ->route(
            'admin.subscriptions.show',
            $subscription->id
        )
        ->with(
            'success',
            'Payment Added Successfully'
        );
}
}
