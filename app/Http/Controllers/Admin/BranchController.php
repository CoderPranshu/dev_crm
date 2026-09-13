<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\{Branch, Tax, Hsn, BankDetail};

use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:branch-list|branch-create|branch-edit|branch-delete', ['only' => ['index','store']]);
         $this->middleware('permission:branch-create', ['only' => ['create','store']]);
         $this->middleware('permission:branch-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:branch-delete', ['only' => ['destroy']]);
    }

    // function index(){
    //     return view('admin.branch.index');
    // }
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
            'title' => 'required|max:255',
            'company_name' => 'nullable|max:255',
            'contact_person' => 'nullable|max:255',
            'phone_no' => 'nullable|max:20',
            'gstin' => 'nullable|max:50',
            'machine_serial_no' => 'nullable|max:255',
            'address' => 'nullable',
            'state_code' => 'nullable|max:10',
            'terms_condition' => 'nullable',
        ]);
    
        $data = [
            'title' => $request->title,
            'company_name' => $request->company_name,
            'contact_person' => $request->contact_person,
            'phone_no' => $request->phone_no,
            'gstin' => $request->gstin,
            'machine_serial_no' => $request->machine_serial_no,
            'address' => $request->address,
            'state_code' => $request->state_code,
            'terms_condition' => $request->terms_condition,
        ];
    
        Branch::create($data);
    
        return back()
            ->with('success_message', get_phrase('New branch has been added'));
    }
    
    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'company_name' => 'nullable|max:255',
            'contact_person' => 'nullable|max:255',
            'phone_no' => 'nullable|max:20',
            'gstin' => 'nullable|max:50',
            'machine_serial_no' => 'nullable|max:255',
            'address' => 'nullable',
            'state_code' => 'nullable|max:10',
            'terms_condition' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);
    
        $branch = Branch::findOrFail($id);
    
        $data = [
            'title' => $request->title,
            'company_name' => $request->company_name,
            'contact_person' => $request->contact_person,
            'phone_no' => $request->phone_no,
            'gstin' => $request->gstin,
            'machine_serial_no' => $request->machine_serial_no,
            'address' => $request->address,
            'state_code' => $request->state_code,
            'terms_condition' => $request->terms_condition,
        ];
    
        // Handle Logo Upload
        if ($request->hasFile('logo')) {
    
            // Delete old logo if exists
            if ($branch->logo && file_exists(public_path('businesslogo/' . $branch->logo))) {
                unlink(public_path('businesslogo/' . $branch->logo));
            }
    
            $file = $request->file('logo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            $file->move(public_path('businesslogo'), $filename);
    
            $data['logo'] = $filename;
        }
    
        $branch->update($data);
    
        return back()->with('success_message', get_phrase('Branch has been updated'));
    }
    function delete($id = ""){
        Branch::where('id', $id)->delete();
        return redirect(route('admin.branch'))->with('success_message', get_phrase('Branch has been updated'));
    }
}
