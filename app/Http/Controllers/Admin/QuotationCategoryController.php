<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuotationCategory;
use App\Models\QuotationService;
use Illuminate\Http\Request;

class QuotationCategoryController extends Controller
{
    public function index()
    {
        // return 'hello';
        $categories = QuotationCategory::with('services')
            ->latest()
            ->get();

        return view('admin.quotation_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_name' => 'nullable|string|max:255',
        ]);

        $category = QuotationCategory::create([
            'name' => $request->name,
        ]);

        if ($request->filled('subcategory_name')) {

            QuotationService::create([
                'category_id' => $category->id,
                'name' => $request->subcategory_name,
            ]);
        }

        return redirect()
            ->route('admin.quotation-categories.index')
            ->with(
                'success',
                'Category created successfully.'
            );
    }

    public function update(
        Request $request,
        QuotationCategory $quotationCategory
    ) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $quotationCategory->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.quotation-categories.index')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }

    public function destroy(
        QuotationCategory $quotationCategory
    ) {
        $quotationCategory->delete();

        return redirect()
            ->route('admin.quotation-categories.index')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }
}


