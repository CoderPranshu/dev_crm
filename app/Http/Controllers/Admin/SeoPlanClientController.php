<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoPlan;
use App\Models\Company;
use App\Models\SeoPlanClient;

use App\Models\User;

use Illuminate\Support\Facades\DB;


class SeoPlanClientController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:seo-assign-client-list', ['only' => ['index']]);

        $this->middleware('permission:seo-assign-client-view', ['only' => ['show']]);

        $this->middleware('permission:seo-assign-client-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:seo-assign-client-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:seo-assign-client-delete', ['only' => ['destroy']]);
    }

    // INDEX
    public function index()
    {
        $assignments = SeoPlanClient::with(['seoPlan', 'company', 'team'])->latest()->get();

        // return $assignments;

        return view('admin.seo-plan-clients.index', compact('assignments'));
    }

    // CREATE
    public function create()
    {
        $plans = SeoPlan::with('service')->where('status', 1)->get();
        $clients  = Company::all(); // 👈 IMPORTANT (companies = clients)

        // return $plans;
        // $teams = User::orderBy('name')->get();

        $teams = User::whereHas('department', function ($query) {
                                    $query->where('department', '13');
                                })
                                ->orderBy('name')
                                ->get();

        // return $teams;


        // return $plans;

        return view('admin.seo-plan-clients.create', compact(
                                                            'plans',
                                                            'clients',
                                                            'teams'
                                                        )
                                                    );

        // return view('admin.seo-plan-clients.create', compact('plans', 'clients'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'seo_plan_id' => 'required|exists:seo_plans,id',
            'client_id'   => 'required|exists:companies,id', // 👈 FIXED
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date',
            'status'      => 'required',
            'team_id' => 'required|exists:users,id',
        ]);

        SeoPlanClient::create([
            'seo_plan_id' => $request->seo_plan_id,
            'company_id'   => $request->client_id, // companies.id store hoga
            'team_id'=>$request->team_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.seo-plan-clients.index')
            ->with('success', 'SEO Plan assigned successfully!');
    }

    // SHOW (optional)
    public function show($id)
    {
        $data = SeoPlanClient::with(['seoPlan', 'client'])->findOrFail($id);

        return view('admin.seo-plan-clients.show', compact('data'));
    }

    // DELETE
    public function destroy($id)
    {
        SeoPlanClient::findOrFail($id)->delete();

        return back()->with('success', 'Deleted successfully!');
    }
}




