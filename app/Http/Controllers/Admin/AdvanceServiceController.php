<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{AdvanceService, User};

class AdvanceServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // dd($user);

        if (auth()->user()->hasRole('Admin')) {
            $services = AdvanceService::latest()->get();
        } else {
            $services = AdvanceService::where('vendor_id', $user->id)->get();
        }
        return view('admin.advanceservices.index', compact('services', 'user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'nullable',
            'components' => 'required|array',
            'components.*' => 'exists:products,id',
        ]);

        $data['vendor_id'] = auth()->user()->id;

        $service = AdvanceService::create([
            'description' => $data['description'],
            'vendor_id' => $data['vendor_id']
        ]);

        $service->products()->attach($request->components);

        return redirect()->back()->with('success_message', 'Service Created Successfully');
    }



    public function approve($id)
    {
        $service = AdvanceService::findOrFail($id);

        if ($service->status !== 'approved') {
            $service->status = 'approved';
            $service->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Service approved successfully!'
        ]);
    }
}
