<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Hsn};

class HSNController extends Controller
{

    public function __construct()
    {
         $this->middleware('permission:hsn-list|hsn-create|hsn-edit|hsn-delete', ['only' => ['index','store']]);
         $this->middleware('permission:hsn-create', ['only' => ['create','store']]);
         $this->middleware('permission:hsn-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:hsn-delete', ['only' => ['destroy']]);
    }

public function store(Request $request)
{
    $request->validate([
        'branch_id' => 'required|exists:branches,id',
        'hsns' => 'required|array',
        'hsns.*.hsn_code' => 'nullable',
        'hsns.*.description' => 'nullable',
        'hsns.*.tax_id' => 'nullable|exists:taxes,id',
        'hsns.*.status' => 'nullable',
    ]);

    try {

        $branchId = $request->branch_id;

        // 🔥 collect incoming IDs
        $incomingIds = collect($request->hsns)
            ->pluck('id')
            ->filter()
            ->toArray();

        //  DELETE removed rows
        Hsn::where('branch_id', $branchId)
            ->whereNotIn('id', $incomingIds)
            ->delete();

        //  UPDATE / CREATE
        foreach ($request->hsns as $hsn) {

            Hsn::updateOrCreate(
                [
                    'id' => $hsn['id'] ?? null,
                    'branch_id' => $branchId // 🔒 safe update
                ],
                [
                    'hsn_code'    => $hsn['hsn_code'] ?? null,
                    'description' => $hsn['description'] ?? null,
                    'tax_id'      => $hsn['tax_id'] ?? null,
                    'status'      => $hsn['status'] ?? 'active',
                ]
            );
        }

        return back()->with('success_message', 'HSN synced successfully');

    } catch (\Exception $e) {

        return back()
            ->withInput()
            ->with('error_message', 'Something went wrong');
    }
}


    public function destroy($id)
    {
        Hsn::where('id', $id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'HSN deleted successfully'
        ]);
    }

}
