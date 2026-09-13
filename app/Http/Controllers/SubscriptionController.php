<?php

namespace App\Http\Controllers;

// use App\Models\Subscription;
use App\Models\SubscriptionCategory;
use App\Models\ServiceType;
use App\Models\SubscriptionPlan;

use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\SubscriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;


class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $subscriptions =
            Subscription::latest()
            ->get();

        return view('admin.subscription.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $categories = SubscriptionCategory::where(
    //         'status',
    //         1
    //     )->get();

    //     return view(
    //         'admin.subscription.create',
    //         compact('categories')
    //     );
    // }

    public function create()
    {
        $categories = SubscriptionCategory::where(
            'status',
            1
        )->get();

        $companies = Company::orderBy('name')
            ->get();

        return view('admin.subscription.create', compact('categories','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request->all();
        $request->validate([
            // 'client_name'      => 'required',
            'purchase_date'    => 'required',
            'duration_months'  => 'required|numeric',
            'category_id'      => 'required|array',
            'service_type_id'  => 'required|array',
            'price'            => 'required|array',
        ]);

        $company = Company::find(
            $request->company_id
        );

        DB::beginTransaction();

        try {

            $totalAmount = array_sum(
                $request->price
            );

            $expiryDate = Carbon::parse(
                $request->purchase_date
            )->addMonths(
                $request->duration_months
            );

            $subscription = Subscription::create([

                'company_id' => $company->id,

                'client_name'        => $request->client_name,

                'company_name'       => $request->company_name,

                'email'              => $request->email,

                'mobile'             => $request->mobile,

                'purchase_date'      => $request->purchase_date,

                'duration_months'    => $request->duration_months,

                'expiry_date'        => $expiryDate,

                'total_amount'       => $totalAmount,

                'renew_before_days'  => $request->renew_before_days,

                'status'             => 'active',

                'remarks'            => $request->remarks

            ]);

            foreach($request->service_type_id as $key => $serviceType){

                SubscriptionItem::create([

                    'subscription_id' => $subscription->id,

                    'subscription_category_id' =>
                        $request->category_id[$key],

                    'service_type_id' =>
                        $serviceType,

                    'price' =>
                        $request->price[$key]

                ]);

            }

            DB::commit();

            return redirect()
                ->route(
                    'admin.subscriptions.index'
                )
                ->with(
                    'success',
                    'Subscription Created Successfully'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = Subscription::with([
                            'items.category',
                            'items.serviceType',
                            'payments'
                        ])->findOrFail($id);

        return view('admin.subscription.show',compact('subscription'));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscription = Subscription::with([
            'items.serviceType',
            'items.category'
        ])->findOrFail($id);

        $categories = SubscriptionCategory::where(
            'status',
            1
        )->get();

        return view(
            'admin.subscription.edit',
            compact(
                'subscription',
                'categories'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $id)
    {
        $request->validate([

            'client_name' => 'required',

            'purchase_date' => 'required',

            'duration_months' => 'required',

            'category_id' => 'required|array',

            'service_type_id' => 'required|array',

            'price' => 'required|array'

        ]);

        DB::beginTransaction();

        try {

            $subscription =
                Subscription::findOrFail($id);

            $totalAmount =
                array_sum($request->price);

            $expiryDate =
                Carbon::parse(
                    $request->purchase_date
                )->addMonths(
                    $request->duration_months
                );

            $subscription->update([

                'client_name' =>
                    $request->client_name,

                'company_name' =>
                    $request->company_name,

                'email' =>
                    $request->email,

                'mobile' =>
                    $request->mobile,

                'purchase_date' =>
                    $request->purchase_date,

                'duration_months' =>
                    $request->duration_months,

                'expiry_date' =>
                    $expiryDate,

                'total_amount' =>
                    $totalAmount,

                'renew_before_days' =>
                    $request->renew_before_days,

                'remarks' =>
                    $request->remarks

            ]);

            SubscriptionItem::where(
                'subscription_id',
                $subscription->id
            )->delete();

            foreach(
                $request->service_type_id
                as $key => $serviceType
            ){

                SubscriptionItem::create([

                    'subscription_id' =>
                        $subscription->id,

                    'subscription_category_id' =>
                        $request->category_id[$key],

                    'service_type_id' =>
                        $serviceType,

                    'price' =>
                        $request->price[$key]

                ]);

            }

            DB::commit();

            return redirect()
                ->route(
                    'admin.subscriptions.index'
                )
                ->with(
                    'success',
                    'Subscription Updated Successfully'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Subscription Deleted Successfully'
            );
    }
    // public function getServiceTypes($id)
    // {
    //     // dd($id);

    //     return ServiceType::where(
    //         'subscription_category_id',
    //         $id
    //     )->get();
    // }

    public function getPlans($id)
    {
        $plans = SubscriptionPlan::where('service_type_id', $id)
                    ->where('status', 1)
                    ->get();

        return response()->json($plans);
    }

    public function getServiceTypes($categoryId)
    {
        $serviceTypes = ServiceType::where(
            'subscription_category_id',
            $categoryId
        )
        ->where(
            'status',
            1
        )
        ->get();

        return response()->json(
            $serviceTypes
        );
    }

    public function getCompanyDetails($id)
    {
        $company = Company::find($id);

        return response()->json($company);
    }
}
