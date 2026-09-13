<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Vendor, User, VendorRate};
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vendor-list|vendor-create|vendor-update|vendor-delete|vendor-rate', ['only' => ['index', 'store']]);
        $this->middleware('permission:vendor-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:vendor-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:vendor-delete', ['only' => ['destroy']]);
        $this->middleware('permission:vendor-rate', ['only' => ['rating']]);
    }

    public function index()
    {
        $vendors = Vendor::with('vendorRate')->latest()->get();

        return view('admin.vendor.index', compact('vendors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable',
            'name' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company' => 'nullable',
            'website' => 'nullable',
            'notes' => 'nullable',
            'status' => 'nullable',
            'vendor_type' => 'nullable',
            'contact_person' => 'nullable',
            'tax_id' => 'nullable'
        ]);

        // dd($data);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'vendor',
            'password' => Hash::make($data['phone'])
        ]);

        Vendor::create([
            'user_id' => $user->id,
            'phone' => $data['phone'],
            'address' => $data['address'],
            'company' => $data['company'],
            'website' => $data['website'],
            // 'notes' => $data['notes'],
            'status' => $data['status'],
            'vendor_type' => $data['vendor_type'],
            // 'contact_person' => $data['contact_person'],
            'tax_id' => $data['tax_id']
        ]);

        $user->assignRole('Saler');

        return back()->with('success_message', 'Vendor create successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company' => 'nullable',
            'website' => 'nullable',
            'notes' => 'nullable',
            'status' => 'nullable',
            'vendor_type' => 'nullable',
            'contact_person' => 'nullable',
            'tax_id' => 'nullable',
            'role' => 'nullable' // optional if you want role change
        ]);

        // Find Vendor
        $vendor = Vendor::findOrFail($id);

        // Find related User
        $user = User::findOrFail($vendor->user_id);

        // ✅ Update User
        $user->update([
            'name'  => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
        ]);

        // ✅ Update password if phone exists
        if (!empty($data['phone'])) {
            $user->update([
                'password' => Hash::make($data['phone'])
            ]);
        }

        // ✅ Update Vendor
        $vendor->update([
            'phone' => $data['phone'] ?? $vendor->phone,
            'address' => $data['address'] ?? $vendor->address,
            'company' => $data['company'] ?? $vendor->company,
            'website' => $data['website'] ?? $vendor->website,
            'notes' => $data['notes'] ?? $vendor->notes,
            'status' => $data['status'] ?? $vendor->status,
            'vendor_type' => $data['vendor_type'] ?? $vendor->vendor_type,
            'contact_person' => $data['contact_person'] ?? $vendor->contact_person,
            'tax_id' => $data['tax_id'] ?? $vendor->tax_id,
        ]);

        // ✅ Update Role ONLY if provided
        if (!empty($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return back()->with('success_message', 'Vendor updated successfully');
    }
    // public function update(Request $request, Vendor $vendor)
    // {
    //     $rules = [
    //         'name' => 'nullable|string|max:255',
    //         'email' => [
    //             'nullable',
    //             'email',
    //             'max:255',
    //             Rule::unique('users', 'email')->ignore($vendor->user_id),
    //         ],
    //         'phone' => 'nullable|string|max:50',
    //         'address' => 'nullable|string|max:1000',
    //         'company' => 'nullable|string|max:255',
    //         'website' => 'nullable|url|max:255',
    //         'notes' => 'nullable|string',
    //         'status' => 'nullable|in:active,inactive',
    //         'vendor_type' => 'nullable|string|max:100',
    //         'contact_person' => 'nullable|string|max:255',
    //         'tax_id' => 'nullable|string|max:100',
    //     ];

    //     $data = $request->validate($rules);

    //     try {
    //         DB::transaction(function () use ($data, $vendor) {

    //             /** ----------------------------
    //              *  Handle linked user
    //              *  ----------------------------
    //              */
    //             if ($vendor->user) {
    //                 // Update existing user
    //                 $userUpdates = [];

    //                 if (array_key_exists('name', $data)) {
    //                     $userUpdates['name'] = $data['name'];
    //                 }

    //                 if (array_key_exists('email', $data)) {
    //                     $userUpdates['email'] = $data['email'];
    //                 }

    //                 if (!empty($userUpdates)) {
    //                     $vendor->user->update($userUpdates);
    //                 }

    //             } elseif (!empty($data['name']) || !empty($data['email'])) {
    //                 // Create new user and link it
    //                 $user = User::create([
    //                     'name'  => $data['name'] ?? null,
    //                     'email' => $data['email'] ?? null,
    //                     'role'  => 'vendor',
    //                 ]);

    //                 $vendor->user_id = $user->id;
    //                 $vendor->save(); // IMPORTANT: persist the relation
    //             }

    //             /** ----------------------------
    //              *  Update vendor fields
    //              *  ----------------------------
    //              */
    //             $vendorUpdates = [
    //                 'phone'          => $data['phone'] ?? $vendor->phone,
    //                 'address'        => $data['address'] ?? $vendor->address,
    //                 'company'        => $data['company'] ?? $vendor->company,
    //                 'website'        => $data['website'] ?? $vendor->website,
    //                 'notes'          => $data['notes'] ?? $vendor->notes,
    //                 'status'         => $data['status'] ?? $vendor->status,
    //                 'vendor_type'    => $data['vendor_type'] ?? $vendor->vendor_type,
    //                 'contact_person' => $data['contact_person'] ?? $vendor->contact_person,
    //                 'tax_id'         => $data['tax_id'] ?? $vendor->tax_id,
    //             ];

    //             $vendor->update($vendorUpdates);
    //         });

    //         return back()->with('success_message', 'Vendor updated successfully');

    //     } catch (\Exception $e) {
    //         Log::error('Vendor update error: ' . $e->getMessage());

    //         return back()
    //             ->withInput()
    //             ->with('error_message', 'Error: ' . $e->getMessage());
    //     }
    // }


    public function delete(Request $request, $id)
    {
        $vendor = Vendor::where('id', $id)->first();

        $res = $vendor->delete();

        if ($res) {
            return back()->with('success_message', 'Vendor deleted successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function rating(Request $request, $id)
    {
        $vendor = Vendor::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'rating' => 'required',
            'note' => 'nullable',
        ]);

        $res = VendorRate::create([
            'rating' => $data['rating'],
            'note' => $data['note'],
            'vendor_id' => $vendor->id
        ]);

        if ($res) {
            return back()->with('success_message', 'Rating submited to the vendor');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }
}
