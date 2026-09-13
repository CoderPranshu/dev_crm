<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{EmailTemplate};

class EmailTemplateController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:email-template-list|email-template-create|email-template-update|email-template-delete', ['only' => ['index','store']]);
         $this->middleware('permission:email-template-create', ['only' => ['create','store']]);
         $this->middleware('permission:email-template-update', ['only' => ['edit','update']]);
         $this->middleware('permission:email-template-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $emailtemplates = EmailTemplate::latest()->get();
        }else{
            $emailtemplates = EmailTemplate::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }

        return view('admin.EmailTemplate.index', compact('emailtemplates'));
    }

    public function add()
    {
        return view('admin.EmailTemplate.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body'    => 'required',
            'branch_id' => 'required'
        ]);

        EmailTemplate::create([
            'title'   => $request->title,
            'subject' => $request->subject,
            'body'    => $request->body,
            'branch_id' => $request->branch_id
        ]);

        return back()->with('success_message', 'Email Template Created Successfully!');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.EmailTemplate.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body'    => 'required',
        ]);

        $template = EmailTemplate::findOrFail($id);

        $template->update([
            'title'   => $request->title,
            'subject' => $request->subject,
            'body'    => $request->body,
        ]);

        return back()->with('success_message', 'Template updated successfully!');
    }

    public function delete(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $template->delete();

        return back()->with('success_message', 'Template deleted successfully!');
    }

}
