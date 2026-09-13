<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, Branch, Hsn, Tax};

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-update|product-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

public function index()
{
    $user = auth()->user();

    // Branch control
    if ($user->hasRole('Admin')) {
        $branches = Branch::all();
    } else {
        $branches = Branch::where('id', $user->branch_id)->get();
    }

    // Base query
    $query = Product::latest();

    // Restrict for non-admin
    if (!$user->hasRole('Admin')) {
        $query->where('branch_id', $user->branch_id);
    }

    // Raw Products
    $rawproducts = (clone $query)
        ->where('category_id', 1)
        ->get()
        ->groupBy('branch_id');

    // Finished Products
    $finishedProducts = (clone $query)
        ->where('category_id', 3)
        ->get()
        ->groupBy('branch_id');

    return view('admin.products.index', compact('branches', 'rawproducts', 'finishedProducts'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products',
            'category_id' => 'nullable|exists:categories,id',
            'unit' => 'required',
            'cost_price' => 'numeric',
            'sale_price' => 'numeric',
            'opening_stock' => 'numeric',
            'min_stock' => 'numeric',
            'is_stock_item' => 'boolean',
            'meta' => 'nullable|json',
            'branch_id' => 'nullable'
        ]);

        $res = Product::create($data);

        if ($res) {
            return back()->with('success_message', 'Product created successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $id,
            'category_id' => 'nullable|exists:categories,id',
            'unit' => 'required',
            'cost_price' => 'numeric',
            'sale_price' => 'numeric',
            'opening_stock' => 'numeric',
            'min_stock' => 'numeric',
            'is_stock_item' => 'boolean',
            'meta' => 'nullable|json',
            'branch_id' => 'nullable'
        ]);

        $product = Product::where('id', $id)->firstOrFail();

        $res = $product->update($data);

        if ($res) {
            return back()->with('success_message', 'Product updated successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();

        $product->delete();

        return back()->with('success_message', 'Product deleted successfully');
    }

public function getByBranch ($branchId)
{
    $userBranchId = auth()->user()->branch_id;

    // Priority → Auth user branch
    $finalBranchId = $userBranchId ?? $branchId;

    $products = Product::where('branch_id', $finalBranchId)->get();

    $hsn = Hsn::where('branch_id', $finalBranchId)->get();
    $gst = Tax::where('branch_id', $finalBranchId)->get();

    return response()->json([
        'products' => $products,
        'hsn' => $hsn,
        'gst' => $gst
    ]);
}
}
