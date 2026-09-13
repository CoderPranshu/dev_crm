<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\ServiceType;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::with('serviceType')
                    ->latest()
                    ->get();

        return view(
            'admin.subscription-plan.index',
            compact('plans')
        );
    }

    public function create()
    {
        $serviceTypes = ServiceType::where('status',1)->get();

        return view(
            'admin.subscription-plan.create',
            compact('serviceTypes')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_type_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'duration_months' => 'required'
        ]);

        SubscriptionPlan::create($request->all());

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('success','Plan Created Successfully');
    }

    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $serviceTypes = ServiceType::where('status',1)->get();

        return view(
            'admin.subscription-plan.edit',
            compact(
                'plan',
                'serviceTypes'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $plan->update($request->all());

        return redirect()
            ->route('admin.subscription-plans.index')
            ->with('success','Plan Updated Successfully');
    }

    public function destroy($id)
    {
        SubscriptionPlan::findOrFail($id)->delete();

        return back()
            ->with('success','Plan Deleted Successfully');
    }

}
