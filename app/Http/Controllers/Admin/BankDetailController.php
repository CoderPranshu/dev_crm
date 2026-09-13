<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{BankDetail};

class BankDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'banks' => 'required|array',
            'banks.*.ac_holder_name' => 'nullable',
            'banks.*.bank_name' => 'nullable',
            'banks.*.ac_no' => 'nullable',
            'banks.*.branch_name' => 'nullable',
            'banks.*.ifsc_code' => 'nullable'
        ]);
    
        try {
    
            $branchId = $request->branch_id;
    
            // ollect incoming IDs
            $incomingIds = collect($request->banks)
                ->pluck('id')
                ->filter()
                ->toArray();
    
            // ELETE removed rows
            BankDetail::where('branch_id', $branchId)
                ->whereNotIn('id', $incomingIds)
                ->delete();
    
            // ✅ UPDATE / CREATE
            foreach ($request->banks as $bank) {
    
                BankDetail::updateOrCreate(
                    [
                        'id' => $bank['id'] ?? null,
                        'branch_id' => $branchId // 🔒 prevent cross-branch overwrite
                    ],
                    [
                        'ac_holder_name' => $bank['ac_holder_name'] ?? null,
                        'bank_name'      => $bank['bank_name'] ?? null,
                        'ac_no'          => $bank['ac_no'] ?? null,
                        'branch_name'    => $bank['branch_name'] ?? null,
                        'ifsc_code'      => $bank['ifsc_code'] ?? null,
                    ]
                );
            }
    
            return back()->with('success_message', 'Bank Detail synced successfully');
    
        } catch (\Exception $e) {
    
            return back()
                ->withInput()
                ->with('error_message', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        BankDetail::where('id', $id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Bank detail deleted successfully'
        ]);
    }

}
