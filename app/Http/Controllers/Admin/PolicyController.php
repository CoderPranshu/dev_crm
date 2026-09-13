<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Policy};
use File;

class PolicyController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:policy-list|policy-create|policy-update|policy-delete|policy-show', ['only' => ['index','store']]);
         $this->middleware('permission:policy-create', ['only' => ['create','store']]);
         $this->middleware('permission:policy-update', ['only' => ['edit','update']]);
         $this->middleware('permission:policy-delete', ['only' => ['destroy']]);
         $this->middleware('permission:policy-show', ['only' => ['show']]);
    }

    public function index()
    {
        $policies = Policy::latest()->get();
        return view('admin.policy.index', compact('policies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable',
            'date' => 'nullable',
            'document' => 'nullable',
        ]);

        if($request->hasFile('document'))
        {
            $filename = uniqid().'.'.$request->document->getClientOriginalExtension();
            $request->document->move(public_path('uploads/document/'),$filename);
            $data['document'] = $filename;
        }


        $res = Policy::create($data);

        if ($res) {
            return redirect()->back()->with('success_message', 'Policy created successfully');
        } else {
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $policy = Policy::where('id', $id)->first();

        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable',
            'date' => 'nullable',
            'document' => 'nullable',
        ]);

        if($request->hasFile('document'))
        {
            $file = public_path('uploads/document/'.$policy->document);

            if(File::exists($file))
            {
                File::delete($file);
            }

            $name = uniqid().'.'.$request->document->getClientOriginalExtension();
            $request->document->move(public_path('uploads/document/'),$name);
            $data['document'] = $name;
        }

        $res = $policy->update($data);

        if($res)
        {
            return redirect()->back()->with('success_message', 'Policy created successfully');
        }else{
            return back()->withInput()-with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
         $policy = Policy::where('id', $id)->first();

        if($request->hasFile('document'))
        {
            $file = public_path('uploads/document/'.$policy->document);

            if(File::exists($file))
            {
                File::delete($file);
            }
        }

        $policy->delete();

        return back()->with('success_message', 'Policy deleted successfully');

    }

    public function show($id)
    {
        // return $id;
        $policy = Policy::findOrFail($id);
        return view('admin.policy.show', compact('policy'));
    }
}
