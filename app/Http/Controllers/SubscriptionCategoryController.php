<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionCategory;
use Illuminate\Http\Request;

class SubscriptionCategoryController extends Controller
{
    public function index()
    {
        $categories = SubscriptionCategory::latest()->get();

        return view(
            'admin.subscription-category.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view('admin.subscription-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subscription_categories,name'
        ]);

        SubscriptionCategory::create([
            'name' => $request->name,
            'status' => $request->status ?? 1
        ]);

        return redirect()
            ->route('admin.subscription-categories.index')
            ->with('success', 'Category Created Successfully');
    }

    public function edit($id)
    {
        $category = SubscriptionCategory::findOrFail($id);

        return view(
            'admin.subscription-category.edit',
            compact('category')
        );
    }

    public function update(Request $request, $id)
    {
        $category = SubscriptionCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:subscription_categories,name,' . $id
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect()
            ->route('subscription-categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy($id)
    {
        SubscriptionCategory::findOrFail($id)->delete();

        return back()
            ->with('success', 'Category Deleted Successfully');
    }
}
