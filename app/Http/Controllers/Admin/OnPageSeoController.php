<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnPageSeo;
use App\Models\OnPageSeoCategory;
use App\Models\OnPageSeoTask;
use App\Models\SeoPlanClient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OnPageSeoController extends Controller
{
   

    public function index($projectId)
{
    $seoProject = SeoPlanClient::with([
        'company',
        'seoPlan',
    ])->findOrFail($projectId);

    /*
    |--------------------------------------------------------------------------
    | Categories + Tasks + Project Progress
    |--------------------------------------------------------------------------
    */

    $categories = OnPageSeoCategory::with([

        'tasks' => function ($query) use ($projectId) {

            $query->with([

                'projectTask' => function ($q) use ($projectId) {

                    $q->where('seo_plan_client_id', $projectId);

                }

            ])
            ->orderBy('sort_order');

        }

    ])
    ->where('status',1)
    ->orderBy('sort_order')
    ->get();

    return view(
        'admin.on_page_seo.index',
        compact(
            'seoProject',
            'categories'
        )
    );
}

   
    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $projects = SeoPlanClient::orderBy('id','desc')->get();

        $categories = OnPageSeoCategory::where('status','active')
            ->orderBy('sort_order')
            ->get();

        $tasks = OnPageSeoTask::where('status','active')
            ->orderBy('sort_order')
            ->get();

        return view(
            'admin.on_page_seo.create',
            compact(
                'projects',
                'categories',
                'tasks'
            )
        );
    }

    

  

    

   

   

    public function update(Request $request)
    {
        $request->validate([
            'seo_plan_client_id'  => 'required|exists:seo_plan_clients,id',
            'on_page_seo_task_id' => 'required|exists:on_page_seo_tasks,id',
            'status'  => 'nullable|in:pending,rejected,completed',
            'remarks' => 'nullable|string',
        ]);

        // Task se uska category id nikalo
        $task = OnPageSeoTask::findOrFail($request->on_page_seo_task_id);

        $existing = OnPageSeo::where('seo_plan_client_id', $request->seo_plan_client_id)
            ->where('on_page_seo_task_id', $request->on_page_seo_task_id)
            ->first();

        $data = [
            'assigned_to' => auth()->id(),
            'on_page_seo_category_id' => $task->on_page_seo_category_id,
        ];

        if ($request->filled('status')) {
            $data['status'] = $request->status;
            $data['completed_at'] = $request->status == 'completed' ? Carbon::now() : null;
        } elseif (!$existing) {
            $data['status'] = 'pending';
        }

        if ($request->has('remarks')) {
            $data['remarks'] = $request->remarks;
        }

        $record = OnPageSeo::updateOrCreate(
            [
                'seo_plan_client_id' => $request->seo_plan_client_id,
                'on_page_seo_task_id' => $request->on_page_seo_task_id,
            ],
            $data
        );

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    

}

