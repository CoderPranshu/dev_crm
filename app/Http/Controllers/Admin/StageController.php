<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stage;
use App\Models\Recruitment;

class StageController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:stage-list|stage-create|stage-edit|stage-delete', ['only' => ['index','store']]);
         $this->middleware('permission:stage-create', ['only' => ['create','store']]);
         $this->middleware('permission:stage-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:stage-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $stages = Stage::orderBy('created_at', 'asc')->get();

        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $recruitments = Recruitment::orderBy('created_at', 'asc')->get();

        } elseif ($user->is_manager == 1) {
            $recruitments = Recruitment::where('manager_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

        } else {
            $recruitments = Recruitment::where('branch_id', $user->branch_id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // dd($recruitments);
        return view('admin.stage.index', compact('stages', 'recruitments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'recruitment_id' => 'required'
        ]);

        $data['slug'] = str()->slug($data['title']);

        $response = Stage::create($data);

        if ($response) {
            return redirect()->back()->with([
                'success_message' => __('New stage added successfully'),
                'active_recruitment_id' => $data['recruitment_id']
            ]);
        } else {
            return redirect()->back()->withInput()->with('error_message', __('Something is wrong!'));
        }
    }

    public function destroy(Request $request, $id)
    {
        $candi = Stage::where('id', $id)->firstOrFail();

        $res = $candi->delete();

        if($res)
        {
            return back()->with('success_message', 'Candidate Deleted successfully');
        }
    }
}
