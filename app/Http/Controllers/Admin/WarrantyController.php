<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Warranty, User};
use Hash;
use Str;

class WarrantyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sold-product-list|sold-product-create', ['only' => ['index', 'store']]);
        $this->middleware('permission:sold-product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sold-product-show', ['only' => ['userProducts']]);
        // $this->middleware('permission:warehouse-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $warranties = Warranty::latest()->get();
        } elseif ($user->hasRole('Vendor')) {
            $warranties = Warranty::where('vendor_id', $user->id)
                ->latest()
                ->get();
        } elseif ($user->hasRole('End Customer')) {
            $warranties = Warranty::where('user_id', $user->id)
                ->latest()
                ->get();
        } else {
            $warranties = Warranty::where('user_id', $user->id)
                ->whereHas('product', function ($query) use ($user) {
                    $query->where('branch_id', $user->branch_id);
                })
                ->latest()
                ->get();
        }

        return view('admin.warranty.index', compact('warranties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'phone_no'   => 'required|string',
            'user_id'    => 'nullable|exists:users,id',
            'name'       => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255',
            'product_id' => 'required|exists:products,id',
        ]);

        if ($request->filled('user_id')) {
            $user = User::findOrFail($request->user_id);
        } else {
            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone' => $request->phone_no,
                'password' => Hash::make($request->phone_no),
            ]);

            // optional role assignment
            $user->assignRole('End Customer');
        }

        $warrantyNo = 'WAR-' . strtoupper(Str::random(8));

        Warranty::create([
            'user_id'     => $user->id,
            'phone_no'    => $request->phone_no,
            'product_id'  => $request->product_id,
            'warranty_no' => $warrantyNo,
            'vendor_id'   => auth()->id(),
        ]);

        return redirect()->back()->with('success_message', 'Warranty created successfully.');
    }

    public function checkUser(Request $request)
    {
        $request->validate([
            'phone_no' => 'required|string'
        ]);

        $user = User::where('phone', $request->phone_no)->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_no' => $user->phone_no,
                ]
            ]);
        }

        return response()->json([
            'exists' => false
        ]);
    }


    public function userProducts($userId)
    {
        $user = User::findOrFail($userId);

        $warranties = Warranty::with(['product', 'vendor'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('admin.warranty.user_products', compact('user', 'warranties'));
    }
}
