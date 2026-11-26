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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $subscriptions =
    //         Subscription::latest()
    //         ->get();

    //     return view('admin.subscription.index', compact('subscriptions'));
    // }
    
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $subscriptions = Subscription::with(['company', 'items'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $like = "%{$search}%";

                    $query->where('client_name', 'like', $like)
                        ->orWhere('company_name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhereHas('items', fn ($items) =>
                            $items->where('domain_name', 'like', $like)
                        );
                });
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $items = $subscriptions->getCollection()
            ->flatMap(fn ($subscription) => $subscription->items);

        $categoryNames = SubscriptionCategory::whereIn(
            'id', $items->pluck('subscription_category_id')->filter()->unique()
        )->pluck('name', 'id');

        $serviceNames = ServiceType::whereIn(
            'id', $items->pluck('service_type_id')->filter()->unique()
        )->pluck('name', 'id');

        return view('admin.subscription.index', compact(
            'subscriptions', 'categoryNames', 'serviceNames'
        ));
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
    // public function store(Request $request)
    // {

    //     // return $request->all();
    //     $request->validate([
    //         // 'client_name'      => 'required',
    //         'purchase_date'    => 'required',
    //         'duration_months'  => 'required|numeric',
    //         'category_id'      => 'required|array',
    //         'service_type_id'  => 'required|array',
    //         'price'            => 'required|array',
    //     ]);

    //     $company = Company::find(
    //         $request->company_id
    //     );

    //     DB::beginTransaction();

    //     try {

    //         $totalAmount = array_sum(
    //             $request->price
    //         );

    //         $expiryDate = Carbon::parse(
    //             $request->purchase_date
    //         )->addMonths(
    //             $request->duration_months
    //         );

    //         $subscription = Subscription::create([

    //             'company_id' => $company->id,

    //             'client_name'        => $request->client_name,

    //             'company_name'       => $request->company_name,

    //             'email'              => $request->email,

    //             'mobile'             => $request->mobile,

    //             'purchase_date'      => $request->purchase_date,

    //             'duration_months'    => $request->duration_months,

    //             'expiry_date'        => $expiryDate,

    //             'total_amount'       => $totalAmount,

    //             'renew_before_days'  => $request->renew_before_days,

    //             'status'             => 'active',

    //             'remarks'            => $request->remarks

    //         ]);

    //         foreach($request->service_type_id as $key => $serviceType){

    //             SubscriptionItem::create([

    //                 'subscription_id' => $subscription->id,

    //                 'subscription_category_id' =>
    //                     $request->category_id[$key],

    //                 'service_type_id' =>
    //                     $serviceType,

    //                 'price' =>
    //                     $request->price[$key]

    //             ]);

    //         }

    //         DB::commit();

    //         return redirect()
    //             ->route(
    //                 'admin.subscriptions.index'
    //             )
    //             ->with(
    //                 'success',
    //                 'Subscription Created Successfully'
    //             );

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return back()
    //             ->with(
    //                 'error',
    //                 $e->getMessage()
    //             );

    //     }
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id'                         => 'required|integer|exists:companies,id',
            'client_name'                        => 'required|string|max:255',
            'mobile'                             => 'nullable|string|max:30',
            'email'                              => 'nullable|email|max:255',
            'purchase_date'                      => 'required|date',
            'duration_months'                    => 'required|integer|min:1',
            'renew_before_days'                  => 'nullable|integer|min:0',
            'remarks'                            => 'nullable|string',
            'domains'                            => 'required|array|min:1',
            'domains.*.domain_name'              => 'required|string|max:255',
            'domains.*.services'                 => 'required|array|min:1',
            'domains.*.services.*.category_id'   => 'required|integer|exists:subscription_categories,id',
            'domains.*.services.*.service_type_id' => 'required|integer|exists:service_types,id',
        ]);

        $company = Company::findOrFail($validated['company_id']);
        $items = [];
        $totalAmount = 0;

        foreach ($validated['domains'] as $domainIndex => $domain) {
            $domainName = trim($domain['domain_name']);

            foreach ($domain['services'] as $serviceIndex => $selection) {
                $service = ServiceType::findOrFail($selection['service_type_id']);

                // Support either common category foreign-key name on ServiceType.
                $serviceCategoryId = $service->getAttribute('subscription_category_id')
                    ?? $service->getAttribute('category_id');

                if ($serviceCategoryId !== null &&
                    (int) $serviceCategoryId !== (int) $selection['category_id']) {
                    throw ValidationException::withMessages([
                        "domains.{$domainIndex}.services.{$serviceIndex}.service_type_id"
                            => 'Selected service does not belong to this category.',
                    ]);
                }

                if (!is_numeric($service->price) || (float) $service->price < 0) {
                    throw ValidationException::withMessages([
                        "domains.{$domainIndex}.services.{$serviceIndex}.service_type_id"
                            => 'This service does not have a valid price.',
                    ]);
                }

                // Always use the database price, not the readonly browser input.
                $price = round((float) $service->price, 2);
                $totalAmount = round($totalAmount + $price, 2);

                $items[] = [
                    'domain_name'              => $domainName,
                    'subscription_category_id' => $selection['category_id'],
                    'service_type_id'          => $service->id,
                    'price'                    => $price,
                ];
            }
        }

        try {
            DB::transaction(function () use ($validated, $company, $items, $totalAmount) {
                $expiryDate = Carbon::parse($validated['purchase_date'])
                    ->addMonthsNoOverflow((int) $validated['duration_months'])
                    ->toDateString();

                $subscription = Subscription::create([
                    'company_id'         => $company->id,
                    'client_name'        => $validated['client_name'],
                    'company_name'       => $company->name,
                    'email'              => $validated['email'] ?? null,
                    'mobile'             => $validated['mobile'] ?? null,
                    'purchase_date'      => $validated['purchase_date'],
                    'duration_months'    => $validated['duration_months'],
                    'expiry_date'        => $expiryDate,
                    'total_amount'       => $totalAmount,
                    'renew_before_days'  => $validated['renew_before_days'] ?? 3,
                    'status'             => 'active',
                    'remarks'            => $validated['remarks'] ?? null,
                ]);

                foreach ($items as $data) {
                    // Explicit assignments work even if SubscriptionItem has a
                    // restrictive $fillable array; model events still run.
                    $item = new SubscriptionItem();
                    $item->subscription_id = $subscription->id;
                    $item->domain_name = $data['domain_name'];
                    $item->subscription_category_id = $data['subscription_category_id'];
                    $item->service_type_id = $data['service_type_id'];
                    $item->price = $data['price'];
                    $item->save();
                }
            });
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Subscription could not be saved. Please try again.');
        }

        return redirect()
            ->route('admin.subscriptions.index')
            ->with('success', 'Subscription Created Successfully');
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
