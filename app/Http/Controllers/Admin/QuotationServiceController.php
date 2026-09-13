<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuotationService;
use Illuminate\Http\Request;

class QuotationServiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:quotation_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_price' => 'nullable|numeric|min:0',
        ]);

        QuotationService::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'default_price' => $request->default_price,
        ]);

        return redirect()
            ->route('admin.quotation-categories.index')
            ->with(
                'success',
                'Subcategory added successfully.'
            );
    }

    public function update(
        Request $request,
        QuotationService $quotationService
    ) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_price' => 'nullable|numeric|min:0',
        ]);

        $quotationService->update([
            'name' => $request->name,
            'description' => $request->description,
            'default_price' => $request->default_price,
        ]);

        return redirect()
            ->route('admin.quotation-categories.index')
            ->with(
                'success',
                'Subcategory updated successfully.'
            );
    }

    public function destroy(
        QuotationService $quotationService
    ) {
        $quotationService->delete();

        return redirect()
            ->route('admin.quotation-categories.index')
            ->with(
                'success',
                'Subcategory deleted successfully.'
            );
    }
}



