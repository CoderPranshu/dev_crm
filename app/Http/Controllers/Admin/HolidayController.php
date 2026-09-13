<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Holiday};

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:holiday-list|holiday-create|holiday-edit|holiday-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:holiday-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:holiday-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:holiday-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $holidays = Holiday::latest()->get();

        return view('admin.holidays.index', compact('holidays'));
    }


    public  function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable',
            'date' => 'nullable',
            'description' => 'nullable',
        ]);

        $res = Holiday::create($data);

        if ($res) {
            return back()->with('success_message', 'Holiday created successfully');
        } else {
            return back()->withInput('error_message', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $holiday = Holiday::where('id', $id)->first();

        $data = $request->validate([
            'title' => 'nullable',
            'date' => 'nullable',
            'description' => 'nullable',
        ]);

        $res = $holiday->update($data);

        if ($res) {
            return back()->with('success_message', 'Holiday created successfully');
        } else {
            return back()->withInput('error_message', 'Something went wrong');
        }
    }

    public function delete(Request $request, $id)
    {
        $holiday = Holiday::where('id', $id)->first();

        $holiday->delete();

        return back()->with('success_message', 'Holiday delete successfully');
    }
}
