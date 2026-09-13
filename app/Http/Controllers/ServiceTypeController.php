<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use App\Models\SubscriptionCategory;

use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::with('category')
            ->latest()
            ->get();

        return view('admin.service-type.index', compact('serviceTypes'));
    }

    public function create()
    {
        $categories = SubscriptionCategory::where(
            'status',
            1
        )->get();

        return view('admin.service-type.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subscription_category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        ServiceType::create([
            'subscription_category_id' => $request->subscription_category_id,
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.service-types.index')
            ->with(
                'success',
                'Service Type Created Successfully'
            );
    }

    public function edit($id)
    {
        $serviceType = ServiceType::findOrFail($id);

        $categories = SubscriptionCategory::where(
            'status',
            1
        )->get();

        return view(
            'admin.service-type.edit',
            compact(
                'serviceType',
                'categories'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $serviceType = ServiceType::findOrFail($id);

        $serviceType->update([
            'subscription_category_id' => $request->subscription_category_id,
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.service-types.index')
            ->with(
                'success',
                'Service Type Updated Successfully'
            );
    }

    public function destroy($id)
    {
        ServiceType::findOrFail($id)->delete();

        return response()->json([
            'status' => true
        ]);
    }
}
