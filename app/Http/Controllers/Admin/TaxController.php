<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Tax,Hsn,BankDetail, Branch};

class TaxController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:tax-list|tax-create|tax-update|tax-delete', ['only' => ['index','store']]);
         $this->middleware('permission:tax-create', ['only' => ['create','store']]);
         $this->middleware('permission:tax-update', ['only' => ['edit','update']]);
         $this->middleware('permission:tax-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
         $branches = Branch::all();

        $taxes = Tax::all()->groupBy('branch_id');
        $hsns = Hsn::all()->groupBy('branch_id');
        $banks = BankDetail::all()->groupBy('branch_id');

        return view('admin.tax.index', compact('taxes', 'hsns', 'banks', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'taxes' => 'required|array',
            'taxes.*.name' => 'nullable|string',
            'taxes.*.rate' => 'nullable|numeric',
            'taxes.*.type' => 'nullable|string',
            'taxes.*.status' => 'nullable|in:active,inactive',
        ]);
    
        try {
    
            $branchId = $request->branch_id;
    
            // collect incoming IDs
            $incomingIds = collect($request->taxes)
                ->pluck('id')
                ->filter()
                ->toArray();
    
            // ELETE removed GST (Tax)
            Tax::where('branch_id', $branchId)
                ->whereNotIn('id', $incomingIds)
                ->delete();
    
            // UPDATE / CREATE
            foreach ($request->taxes as $tax) {
    
                Tax::updateOrCreate(
                    [
                        'id' => $tax['id'] ?? null,
                        'branch_id' => $branchId // prevent cross-branch overwrite
                    ],
                    [
                        'name'   => $tax['name'] ?? null,
                        'rate'   => $tax['rate'] ?? null,
                        'type'   => $tax['type'] ?? null,
                        'status' => $tax['status'] ?? 'active',
                    ]
                );
    
            }
    
            return back()->with('success_message', 'Taxes synced successfully');
    
        } catch (\Exception $e) {
    
            return back()
                ->withInput()
                ->with('error_message', 'Something went wrong');
    
        }
    }


    public function update(Request $request, $id)
    {
        $tax = Tax::where('id', $id)->first();

        $data = $request->validate([
            'name' => 'nullable',
            'rate' => 'nullable',
            'type' => 'nullable',
            'status' => 'nullable'
        ]);

        $res = $tax->update($data);

        if($res)
        {
            return back()->with('success_message', 'Tax updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $tax = Tax::where('id', $id)->first();

        $tax->delete();

        return back()->with('success_message', 'Tax deleted successfully');
    }

    public function destroy($id)
    {
        Tax::where('id', $id)->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Tax deleted successfully'
        ]);
    }

}
