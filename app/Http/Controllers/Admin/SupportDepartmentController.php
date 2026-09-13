<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{SupportDepartment};

class SupportDepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:support-department-list', ['only' => ['index']]);
        $this->middleware('permission:support-department-crete', ['only' => ['store']]);
        $this->middleware('permission:support-department-update', ['only' => ['update']]);
        $this->middleware('permission:support-department-delete', ['only' => ['delete']]);
    }


    public function index()
    {
        $supports = SupportDepartment::latest()->get();

        return view('admin.supportdepartment.index', compact('supports'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable',
            'branch_id' => 'nullable',
            'description' => 'nullable'
        ]);

        $res = SupportDepartment::create($data);

        if($res)
        {
            return back()->with('success_message', 'Deprtament created successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $department = SupportDepartment::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'name' => 'nullable',
            'branch_id' => 'nullable',
            'description' => 'nullable'
        ]);

        $res = $department->update($data);

        if($res)
        {
            return back()->with('success_message', 'Department updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $department = SupportDepartment::where('id', $id)->firstOrFail();

        $department->delete();

        return back()->with('success_message', 'Department deleted successfully');
    }
}
