<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BacklinkCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BacklinkCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = BacklinkCategory::query();

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');

            });
        }

        $categories = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalCategories = BacklinkCategory::count();

        $activeCategories = BacklinkCategory::where('status',1)->count();

        $inactiveCategories = BacklinkCategory::where('status',0)->count();

        return view(
            'admin.backlink-category.index',
            compact(
                'categories',
                'totalCategories',
                'activeCategories',
                'inactiveCategories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.backlink-category.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|unique:backlink_categories,name',

            'description' => 'nullable|string',

            'status' => 'required|boolean',

        ]);

        DB::beginTransaction();

        try {

            BacklinkCategory::create([

                'name' => $request->name,

                'description' => $request->description,

                'status' => $request->status,

            ]);

            DB::commit();

            return redirect()
                ->route('admin.backlink-categories.index')
                ->with('success','Backlink Category Created Successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error',$e->getMessage());

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $category = BacklinkCategory::findOrFail($id);

        return view(
            'admin.backlink-category.edit',
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
        $category = BacklinkCategory::findOrFail($id);

        $request->validate([

            'name' => 'required|unique:backlink_categories,name,' . $category->id,

            'description' => 'nullable|string',

            'status' => 'required|boolean',

        ]);

        DB::beginTransaction();

        try {

            $category->update([

                'name' => $request->name,

                'description' => $request->description,

                'status' => $request->status,

            ]);

            DB::commit();

            return redirect()
                ->route('admin.backlink-categories.index')
                ->with('success','Backlink Category Updated Successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error',$e->getMessage());

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $category = BacklinkCategory::findOrFail($id);

            $category->delete();

            DB::commit();

            return redirect()
                ->route('admin.backlink-categories.index')
                ->with('success','Backlink Category Deleted Successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error',$e->getMessage());

        }
    }
}