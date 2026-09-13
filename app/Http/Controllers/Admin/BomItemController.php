<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{BomItems};

class BomItemController extends Controller
{
    public function index()
    {
        $bomitems = BomItem::latest()->get();

        return view('admin.bomItems.index', compact('bomitems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bom_id' => 'nullable',
            'raw_product_id' => 'nullable',
            'quantity' => 'nullable',
            'wastage_percent' => 'nullable',
            'notes' => 'nullable'
        ]);

        $res = BomItems::create($data);

        if($res)
        {
            return back()->with('success_message', 'Bom items created successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $bomitems = BomItem::where('id', $id)->get();

        $data = $request->validate([
            'bom_id' => 'nullable',
            'raw_product_id' => 'nullable',
            'quantity' => 'nullable',
            'wastage_percent' => 'nullable',
            'notes' => 'nullable'
        ]);

        $res = $bomitems->update($data);

        if($res)
        {
            return back()->with('success_message', 'Bom Item updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $bomitems = BomItem::where('id', $id)->get();

        $bomitems->delete();

        return back()->with('success_message', 'Deleted successfully');
    }
}
