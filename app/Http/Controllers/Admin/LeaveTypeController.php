<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{LeaveType};

class LeaveTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:leave-type-list|leave-type-create|leave-type-edit|leave-type-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:leave-type-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:leave-type-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:leave-type-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $types = LeaveType::latest()->get();
        return view('admin.type.index', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'days' => 'nullable'
        ]);

        $res = LeaveType::create($data);

        if ($res) {
            return redirect()->back()->with('success_message', 'Leave type created successfully');
        } else {
            return redirect()->back()->withInput('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $type = LeaveType::where('id', $id)->first();

        $data = $request->validate([
            'name' => 'required',
            'days' => 'nullable'
        ]);

        $res = $type->update($data);

        if ($res) {
            return redirect()->back()->with('success_message', 'Leave type updated successfully');
        } else {
            return redirect()->back()->withInput('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $type = LeaveType::where('id', $id)->first();

        $type->delete();

        return back()->with('success_message', 'Leave type deleted successfully');
    }
}
