<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;

class DesignationController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:designation-list|designation-create|designation-edit|designation-delete', ['only' => ['index','store']]);
         $this->middleware('permission:designation-create', ['only' => ['create','store']]);
         $this->middleware('permission:designation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:designation-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $designation = Designation::latest()->get();
        return view('admin.designation.index', compact('designation'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'department_id' => 'required'
        ]);

        $response = Designation::create($data);

        if($response)
        {
            return redirect()->back()->with('success_message', 'Designation Created Successfully');
        }else
        {
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $desi = Designation::where('id', $id)->firstOrFail();
        $data = $request->validate([
            'title' => 'required',
            'department_id' => 'required'
        ]);

        $response = $desi->update($data);

        if($response)
        {
            return redirect()->back()->with('success_message','Designation updated successfully');
        }else{
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $desi = Designation::where('id', $id)->firstOrFail();

        $resp = $desi->delete();

        if($resp)
        {
            return redirect()->back()->with('success_message', 'Designation deleted successfully');
        }
    }
}
