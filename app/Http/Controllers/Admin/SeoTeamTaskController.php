<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoPlanClient;
use App\Models\SeoTeamTask;

use App\Models\SeoPlanTask;
use App\Models\SeoTeamTaskItem;


class SeoTeamTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $tasks = SeoTeamTask::with([
            'seoPlanClient.company',
            'seoPlanClient.seoPlan'
        ])->latest()->get();

        // return 'hello';

        return view('admin.seo-team-tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = SeoPlanClient::with([
            'company',
            'seoPlan'
        ])->get();

        return view(
            'admin.seo-team-tasks.create',
            compact('clients')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'seo_plan_client_id' => 'required|exists:seo_plan_clients,id',
    //         'team_name'          => 'required|string|max:255',
    //         'week_days'          => 'required|array',
    //         'status'             => 'required',
    //         'notes'              => 'nullable|string',
    //     ]);

    //     SeoTeamTask::create([
    //         'seo_plan_client_id' => $request->seo_plan_client_id,
    //         'team_name'          => $request->team_name,
    //         'week_days'          => json_encode($request->week_days),
    //         'notes'              => $request->notes,
    //         'status'             => $request->status,
    //     ]);

    //     return redirect()
    //             ->route('admin.seo-team-tasks.index')
    //             ->with('success', 'SEO Team Task Assigned Successfully.');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'seo_plan_client_id' => 'required|exists:seo_plan_clients,id',
    //         'team_name'          => 'required|string|max:255',
    //         'week_days'          => 'required|array',
    //         'status'             => 'nullable',
    //         'notes'              => 'nullable|string',
    //     ]);

    //     SeoTeamTask::create([
    //         'seo_plan_client_id' => $request->seo_plan_client_id,
    //         'team_name'          => $request->team_name,
    //         'week_days'          => json_encode($request->week_days),
    //         'notes'              => $request->notes,
    //         'status'             => $request->status ?? 'Pending',
    //     ]);

    //     return redirect()
    //         ->route('admin.seo-team-tasks.index')
    //         ->with('success', 'SEO Team Task Assigned Successfully');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'seo_plan_client_id' => 'required|exists:seo_plan_clients,id',
            'team_name'          => 'required|string|max:255',
            'status'             => 'nullable',
            'notes'              => 'nullable|string',
        ]);

        // SEO Team Task Save
        $seoTeamTask = SeoTeamTask::create([
            'seo_plan_client_id' => $request->seo_plan_client_id,
            'team_name'          => $request->team_name,
            'notes'              => $request->notes,
            'status'             => $request->status ?? 'Pending',
        ]);

        // Selected Client
        $planClient = SeoPlanClient::findOrFail($request->seo_plan_client_id);

        // Plan ke Tasks nikalo
        $planTasks = SeoPlanTask::where('seo_plan_id', $planClient->seo_plan_id)
                        ->whereIn('day', $request->week_days)
                        ->orderBy('sort_order')
                        ->get();

        // Har task ko Team Task Item me save karo
        foreach ($planTasks as $task) {

            SeoTeamTaskItem::create([
                'seo_team_task_id' => $seoTeamTask->id,
                'seo_plan_task_id' => $task->id,
                'status'           => 'Pending',
                'completed_at'     => null,
                'remarks'          => null,
            ]);

        }

        return redirect()
            ->route('admin.seo-team-tasks.index')
            ->with('success', 'SEO Team Task Assigned Successfully');
    }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $task = SeoTeamTask::with([
                'seoPlanClient.company',
                'seoPlanClient.seoPlan'
            ])->findOrFail($id);

            return view('admin.seo-team-tasks.show', compact('task'));
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTasks($id)
    {
        $client = SeoPlanClient::findOrFail($id);

        $tasks = SeoPlanTask::where('seo_plan_id', $client->seo_plan_id)
                    ->orderBy('sort_order')
                    ->get();

        return response()->json($tasks);
    }
}
