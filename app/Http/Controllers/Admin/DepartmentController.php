<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:department-list|department-create|department-edit|department-delete', ['only' => ['index','store']]);
         $this->middleware('permission:department-create', ['only' => ['create','store']]);
         $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $departments = Department::latest()->get();
        return view('admin.department.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'branch' => 'nullable'
        ]);

        $response = Department::create($data);

        if($response)
        {
            return redirect()->route('admin.department.index')->with('success_message','Department Created Successfully');
        }else{
            return redirect()->back()->withInput()->with('error_message', 'Something want wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $department = Department::where('id', $id)->first();

        $data = $request->validate([
            'title' => 'required',
            'branch' => 'required'
        ]);

        $response = $department->update($data);

        if($response)
        {
            return redirect()->back()->with('success_message', 'Department Updated successfully');
        }else{
            return redirect()->back()->withInput()->with('error_message', 'Something want wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $department = Department::where('id', $id)->firstOrFail();

        $department->delete();

        return redirect()->back()->with('success_message', 'Department Updated successfully');
    }
}
