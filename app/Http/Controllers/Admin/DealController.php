<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Deal};

class DealController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:deal-list|deal-create|deal-update|deal-delete', ['only' => ['index','store']]);
         $this->middleware('permission:deal-create', ['only' => ['create','store']]);
         $this->middleware('permission:deal-update', ['only' => ['edit','update']]);
         $this->middleware('permission:deal-delete', ['only' => ['destroy']]);
    }

    public function index(){

        $stages = ['Open', 'Meeting', 'Proposal', 'Negotiable', 'poi', 'Payment_waiting', 'Lost', 'Won'];
        $users = User::where('name', '!=', 'admin')->where('name', '!=', 'Adminn')->get();
        $names = $users->pluck('id', 'name');

        // return $names;

        $dealsByStage = [];
        foreach ($stages as $stage) {
            $dealsByStage[$stage] = Deal::where('stage', $stage)->get();
        }

        return view('admin.deals.index', compact('stages', 'dealsByStage', 'names'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'close_date' => 'nullable',
            'remark' => 'nullable',
            'requirement' => 'nullable',
            'description' => 'nullable'
        ]);

        $res = Deal::create($data);

        if($res)
        {
            return redirect()->back()->with('success_message', 'Deal store successfully');
        }else{
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $deal = Deal::where('id', $id)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string',
            'close_date' => 'nullable',
            'remark' => 'nullable',
            'requirement' => 'nullable',
            'description' => 'nullable'
        ]);

        $res = $deal->update($data);

        if($res)
        {
            return redirect()->back()->with('success_message', 'Deal updated successfully');
        }else{
            return redirect()->back()->withInput()->with('error_message', 'Something went wrong');
        }
    }

    public function updateStage($id, Request $request)
    {
        $deal = Deal::findOrFail($id);
        $deal->stage = $request->stage;
        $deal->stage_change_date = now(); // Save current date and time
        $deal->save();

        return response()->json([
            'success' => true,
            'stage' => $deal->stage,
            'stage_change_date' => $deal->stage_change_date
        ]);
    }

    public function updateDate($id, Request $request)
{
    $request->validate([
        'datetime' => 'required',
    ]);

    $deal = Deal::findOrFail($id);
    $deal->call_again = $request->datetime;
    $deal->save();

    return response()->json(['success' => true, 'call_again' => $deal->call_again]);
}

public function updateStageTime($id, Request $request)
{
    $deal = Deal::findOrFail($id);
    $deal->stage_changed = $request->stage_changed;
    $deal->save();

    return response()->json(['success' => true]);
}




}
