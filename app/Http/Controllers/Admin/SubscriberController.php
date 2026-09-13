<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Subscriber};

class SubscriberController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:subscriber-list|subscriber-create|subscriber-update|subscriber-delete', ['only' => ['index','store']]);
         $this->middleware('permission:subscriber-create', ['only' => ['create','store']]);
         $this->middleware('permission:subscriber-update', ['only' => ['edit','update']]);
         $this->middleware('permission:subscriber-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $subscribers = Subscriber::latest()->get();
        }else{
            $subscribers = Subscriber::where('branch_id', auth()->user()->branch_id)->latest()->get();
        }

        return view('admin.subscriber.index', compact('subscribers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'status' => 'required',
            'branch_id' => 'required'
        ]);

        // dd($data);

        $res = Subscriber::create($data);

        if($res)
        {
            return back()->with('success_message', 'Subscriber created successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $sub = Subscriber::where('id', $id)->first();

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'status' => 'required'
        ]);

        $res = $sub->update($data);

        if($res)
        {
            return back()->with('success_message', 'Subscriber updated successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $sub = Subscriber::where('id', $id)->first();

        $res = $sub->delete();

        if($res)
        {
            return back()->with('success_message', 'Subscriber deleted successfully');
        }else{
            return back()->withInput()->with('error_message', 'Something went wrong');
        }
    }
}
