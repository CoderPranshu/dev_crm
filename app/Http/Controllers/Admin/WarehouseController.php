<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Warehouse};

class WarehouseController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:warehouse-list|warehouse-create|warehouse-edit|warehouse-delete', ['only' => ['index','store']]);
         $this->middleware('permission:warehouse-create', ['only' => ['create','store']]);
         $this->middleware('permission:warehouse-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:warehouse-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $warehouses = Warehouse::latest()->get();

        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable',
            'code' => 'nullable',
            'address' => 'nullable'
        ]);

        $res = Warehouse::create($data);

        if($res)
        {
            return back()->with('success_message', 'Warehouse created successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'nullable',
            'code' => 'nullable',
            'address' => 'nullable'
        ]);

        $warehouse = Warehouse::where('id', $id)->firstOrFail();

        $res = $warehouse->update($data);

        if($res)
        {
            return back()->with('success_message', 'Warehouse updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $warehouse = Warehouse::where('id', $id)->firstOrFail();

        $res = $warehouse->delete();

        if($res)
        {
            return back()->with('success_message', 'Warehouse updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }
}
