<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnPageSeoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OnPageSeoCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $categories = OnPageSeoCategory::orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view(
            'admin.on_page_seo_category.index',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.on_page_seo_category.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255|unique:on_page_seo_categories,name',

            'description' => 'nullable|string',

            'sort_order' => 'nullable|integer',

            'status' => 'required|in:active,inactive',

        ]);

        OnPageSeoCategory::create([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.on-page-seo-category.index')
            ->with('success', 'Category created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $category = OnPageSeoCategory::findOrFail($id);

        return view(
            'admin.on_page_seo_category.show',
            compact('category')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $category = OnPageSeoCategory::findOrFail($id);

        return view(
            'admin.on_page_seo_category.edit',
            compact('category')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $category = OnPageSeoCategory::findOrFail($id);

        $request->validate([

            'name' => 'required|string|max:255|unique:on_page_seo_categories,name,' . $category->id,

            'description' => 'nullable|string',

            'sort_order' => 'nullable|integer',

            'status' => 'required|in:active,inactive',

        ]);

        $category->update([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.on-page-seo-category.index')
            ->with('success', 'Category updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $category = OnPageSeoCategory::findOrFail($id);

        $category->delete();

        return redirect()
            ->route('admin.on-page-seo-category.index')
            ->with('success', 'Category deleted successfully.');
    }
}