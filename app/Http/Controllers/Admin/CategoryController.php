<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category};

class CategoryController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:product-category-list|product-category-create|product-category-update|product-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-category-update', ['only' => ['edit','update']]);
         $this->middleware('permission:product-category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'parent_id' => 'nullable',
            'description' => 'nullable'
        ]);

        $res = Category::create($data);

        if($res)
        {
            return back()->with('success_message', 'Categroy created successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'parent_id' => 'nullable',
            'description' => 'nullable'
        ]);

        $cat = Category::where('id', $id)->first();

        $res = $cat->update($data);

        if($res)
        {
            return back()->with('success_message', 'Category created successfully');
        }
    }

    public function delete(Request $request, $id)
    {
        $cat = Category::where('id', $id)->first();

        $cat->delete();

        return back()->with('success_message', 'Category deleted successfully');
    }
}
