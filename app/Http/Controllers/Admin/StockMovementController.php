<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use DB;

class StockMovementController extends Controller
{

    public function __construct()
    {
         $this->middleware('permission:stockmovement-list|stockmovement-create|stockmovement-edit|stockmovement-delete|stockmovement-show', ['only' => ['index','store']]);
         $this->middleware('permission:stockmovement-create', ['only' => ['create','store']]);
         $this->middleware('permission:stockmovement-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:stockmovement-delete', ['only' => ['destroy']]);
         $this->middleware('permission:stockmovement-show', ['only' => ['show']]);
    }

public function index(Request $request)
{
    $search = $request->search;

    $movements = StockMovement::with(['product', 'warehouse'])
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('warehouse', function ($sub) use ($search) {
                    $sub->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('movement_type', 'like', '%' . $search . '%')
                ->orWhere('reference_type', 'like', '%' . $search . '%')
                ->orWhere('reference_id', 'like', '%' . $search . '%')
                ->orWhere('note', 'like', '%' . $search . '%')
                ->orWhere('quantity', 'like', '%' . $search . '%')
                ->orWhere('quantity_before', 'like', '%' . $search . '%')
                ->orWhere('quantity_after', 'like', '%' . $search . '%');
            });
        })
        ->latest()
        ->paginate(500);

    if ($request->ajax()) {
        return view('admin.stockmovement.partials.table', compact('movements'))->render();
    }

    return view('admin.stockmovement.index', compact('movements'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|string',
            'warehouse_id' => 'nullable',
            'movement_type' => 'required|string',
            'quantity' => 'required|string',
            'quantity_before' => 'nullable',
            'quantity_after' => 'nullable',
            'reference_type' => 'nullable',
            'reference_id' => 'nullable',
            'note' => 'nullable'
        ]);

        $res = StockMovement::create($data);

        if($res)
        {
            return back()->with('success_message', 'Stockmovement created successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $stockmovement = StockMovement::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'product_id' => 'required|string',
            'warehouse_id' => 'nullable',
            'movement_type' => 'required|string',
            'quantity' => 'required|string',
            'quantity_before' => 'nullable',
            'quantity_after' => 'nullable',
            'reference_type' => 'nullable',
            'reference_id' => 'nullable',
            'note' => 'nullable'
        ]);

        $res = $stockmovement->update($data);

        if($res)
        {
            return back()->with('success_message', 'Stockmovement updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $stockmovement = StockMovement::where('id', $id)->firstOrFail();

        $stockmovement->delete();

        return back()->with('success_message', 'Stockmovement deleted sucessfully');
    }

    public function show($id){
        $stockmovement = StockMovement::with('product', 'warehouse')->findOrFail($id);

        return view('admin.stockmovement.show', compact('stockmovement'));
    }



    public function stockCheck()
    {
        $stocks = StockMovement::select(
                'product_id',
                'warehouse_id',
                DB::raw('MAX(id) as latest_id')
            )
            ->groupBy('product_id', 'warehouse_id')
            ->with(['product', 'warehouse'])
            ->get()
            ->map(function ($row) {
                return StockMovement::with(['product', 'warehouse'])
                    ->find($row->latest_id);
            });

        return view('admin.stockmovement.stockmanagement', compact('stocks'));
    }


}
