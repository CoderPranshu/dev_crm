<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Kpi, Department};

class KpiController extends Controller
{

    public function __construct()
    {
         $this->middleware('permission:kpi-list|kpi-create|kpi-edit|kpi-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kpi-create', ['only' => ['create','store']]);
         $this->middleware('permission:kpi-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kpi-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $kpis = Kpi::latest()->get();
        $departments = Department::latest()->get();
        return view('admin.kpi.index', compact('kpis', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'branch_id' => 'required',
            'department_id' => 'required'
        ]);

        $res = Kpi::create($data);

        if($res)
        {
            return redirect()->back()->with('success_message', 'Kpi created successfully');
        }else{
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'branch_id' => 'required',
            'department_id' => 'nullable'
        ]);

        $kpi = Kpi::where('id', $id)->firstOrFail();

        $res = $kpi->update($data);

        if($res)
        {
            return redirect()->back()->with('success_message', 'Kpi created successfully');
        }else{
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $kpi = Kpi::where('id', $id)->firstOrFail();

        $kpi->delete();

        return back()->with('success_message', 'Kpi deleted successfully');
    }
}
