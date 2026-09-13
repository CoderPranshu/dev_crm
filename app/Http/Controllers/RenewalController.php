<?php

namespace App\Http\Controllers;
use App\Models\Renewal;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SubscriptionPayment;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request)
    {
        $subscription = Subscription::findOrFail($request->subscription_id);

        return view('admin.renewal.create', compact('subscription'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

   public function store(Request $request)
    {
        $subscription = Subscription::findOrFail(
            $request->subscription_id
        );

        $oldExpiry = $subscription->expiry_date;

        $today = Carbon::today();

        $currentExpiry = Carbon::parse(
            $subscription->expiry_date
        );

        if ($currentExpiry->lt($today)) {

            // Expired subscription
            $newExpiry = $today->copy()
                ->addMonths($request->duration_months);

        } else {

            // Active subscription
            $newExpiry = $currentExpiry->copy()
                ->addMonths($request->duration_months);

        }

        Renewal::create([

            'subscription_id' =>
                $subscription->id,

            'old_expiry_date' =>
                $oldExpiry,

            'new_expiry_date' =>
                $newExpiry,

            'duration_months' =>
                $request->duration_months,

            'amount' =>
                $request->amount,

            'renewal_date' =>
                $request->renewal_date,

            'remarks' =>
                $request->remarks

        ]);

        //
          
        SubscriptionPayment::create([

            'subscription_id' =>
                $subscription->id,

            'amount' =>
                $request->amount,

            'payment_date' =>
                $request->renewal_date,

            'payment_method' =>
                $request->payment_method ?? 'Cash',

            'transaction_id' =>
                $request->transaction_id,

            'remarks' =>
                'Renewal Payment'

        ]);

        // 

        $subscription->update([

            'expiry_date' =>
                $newExpiry,

            'duration_months' =>
                $request->duration_months,

            'status' =>
                'active'

        ]);

        return redirect()
            ->route('admin.subscriptions.index')
            ->with(
                'success',
                'Subscription Renewed Successfully'
            );
    }
  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Renewal  $renewal
     * @return \Illuminate\Http\Response
     */
    public function show(Renewal $renewal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Renewal  $renewal
     * @return \Illuminate\Http\Response
     */
    public function edit(Renewal $renewal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Renewal  $renewal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Renewal $renewal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Renewal  $renewal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Renewal $renewal)
    {
        //
    }
}
