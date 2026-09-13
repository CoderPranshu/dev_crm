<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPlan;
use App\Models\SeoService;
use Illuminate\Http\Request;

use App\Models\SeoPlanTask;
use Illuminate\Support\Facades\DB;

class SeoPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:seo-plan-list', ['only' => ['index']]);

        $this->middleware('permission:seo-plan-view', ['only' => ['show']]);

        $this->middleware('permission:seo-plan-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:seo-plan-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:seo-plan-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $seoPlans = SeoPlan::with('service')
            ->latest()
            ->get();

        return view('admin.seo-plans.index', compact('seoPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seoServices = SeoService::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.seo-plans.create', compact('seoServices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'seo_service_id' => 'required',
    //         'name' => 'required',
    //         'duration' => 'required',
    //         'tasks' => 'required|array'
    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         $plan = SeoPlan::create([
    //             'seo_service_id' => $request->seo_service_id,
    //             'name' => $request->name,
    //             'duration' => $request->duration,
    //             'status' => $request->status ?? 1,
    //         ]);

    //         // TASK INSERTION
    //         foreach ($request->tasks as $day => $taskList) {

    //             foreach ($taskList as $index => $task) {

    //                 if (!empty($task)) {

    //                     SeoPlanTask::create([
    //                         'seo_plan_id' => $plan->id,
    //                         'day' => $day,
    //                         'task_title' => $task,
    //                         'sort_order' => $index + 1,
    //                         'status' => 1,
    //                     ]);

    //                 }
    //             }
    //         }

    //         DB::commit();

    //         return redirect()
    //             ->route('admin.seo-plans.index')
    //             ->with('success', 'SEO Plan created successfully.');

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return back()->with('error', $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'seo_service_id' => 'required',
            'name' => 'required',
            'duration' => 'required',
            'tasks' => 'required|array',
            'repeat_type' => 'nullable|array',
            'repeat_type.*.*' => 'nullable|in:weekly,monthly,first_time',
        ]);

        DB::beginTransaction();

        try {

            $plan = SeoPlan::create([
                'seo_service_id' => $request->seo_service_id,
                'name' => $request->name,
                'duration' => $request->duration,
                'status' => $request->status ?? 1,
            ]);

            foreach ($request->tasks as $day => $taskList) {

                foreach ($taskList as $index => $task) {

                    if (!empty($task)) {

                        SeoPlanTask::create([
                            'seo_plan_id' => $plan->id,
                            'day' => $day,
                            'task_title' => $task,
                            'repeat_type' => $request->repeat_type[$day][$index] ?? 'weekly',
                            'sort_order' => $index + 1,
                            'status' => 1,
                        ]);

                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.seo-plans.index')
                ->with('success', 'SEO Plan created successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SeoPlan $seoPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    // public function edit($id)
    // {
    //     $seoPlan = SeoPlan::with('tasks')->findOrFail($id);

    //     $groupedTasks = $seoPlan->tasks->groupBy('day');

    //     $seoServices = SeoService::where('status', 1)->get(); 
    //     // 👆 THIS WAS MISSING

    //     return view('admin.seo-plans.edit', compact(
    //         'seoPlan',
    //         'groupedTasks',
    //         'seoServices'
    //     ));
    // }

    // public function edit($id)
    // {
    //     $seoPlan = SeoPlan::with('tasks')->findOrFail($id);

    //     $seoServices = SeoService::where('status', 1)->get();

    //     $groupedTasks = SeoPlanTask::where('seo_plan_id', $id)
    //         ->get()
    //         ->groupBy('day');

    //     return view('admin.seo-plans.edit', compact(
    //         'seoPlan',
    //         'seoServices',
    //         'groupedTasks'
    //     ));
    // }

    public function edit($id)
    {
        $plan = SeoPlan::findOrFail($id);

        $seoServices = SeoService::orderBy('name')->get();

        $tasks = SeoPlanTask::where('seo_plan_id', $plan->id)
            ->orderBy('day')
            ->orderBy('sort_order')
            ->get();

        $tasksByDay = $tasks->groupBy('day');

        return view('admin.seo-plans.edit', compact(
            'plan',
            'seoServices',
            'tasksByDay'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'seo_service_id' => 'required',
    //         'name' => 'required',
    //         'duration' => 'required',
    //         'tasks' => 'required|array'
    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         $plan = SeoPlan::findOrFail($id);

    //         $plan->update([
    //             'seo_service_id' => $request->seo_service_id,
    //             'name' => $request->name,
    //             'duration' => $request->duration,
    //             'status' => $request->status ?? 1,
    //         ]);

    //         // OLD TASKS DELETE
    //         SeoPlanTask::where('seo_plan_id', $plan->id)->delete();

    //         // NEW TASKS INSERT
    //         foreach ($request->tasks as $day => $taskList) {

    //             foreach ($taskList as $index => $task) {

    //                 if (!empty($task)) {

    //                     SeoPlanTask::create([
    //                         'seo_plan_id' => $plan->id,
    //                         'day' => $day,
    //                         'task_title' => $task,
    //                         'sort_order' => $index + 1,
    //                         'status' => 1,
    //                     ]);

    //                 }
    //             }
    //         }

    //         DB::commit();

    //         return redirect()
    //             ->route('admin.seo-plans.index')
    //             ->with('success', 'SEO Plan updated successfully.');

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return back()->with('error', $e->getMessage());
    //     }
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'seo_service_id' => 'required|exists:seo_services,id',
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',

            'status' => 'nullable|boolean',

            'tasks' => 'required|array',

            'task_ids' => 'nullable|array',

            'repeat_type' => 'nullable|array',
            'repeat_type.*.*' => 'nullable|in:weekly,monthly,first_time',
        ]);

        DB::beginTransaction();

        try {

            $plan = SeoPlan::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Update SEO Plan
            |--------------------------------------------------------------------------
            */

            $plan->update([
                'seo_service_id' => $request->seo_service_id,
                'name'           => $request->name,
                'duration'       => $request->duration,
                'status'         => $request->status ?? 1,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Existing Task IDs That Are Kept
            |--------------------------------------------------------------------------
            */

            $keptTaskIds = [];


            /*
            |--------------------------------------------------------------------------
            | Days
            |--------------------------------------------------------------------------
            */

            $days = [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
            ];


            /*
            |--------------------------------------------------------------------------
            | Update / Create Tasks
            |--------------------------------------------------------------------------
            */

            foreach ($days as $day) {

                $taskList = $request->input("tasks.$day", []);

                $taskIds = $request->input("task_ids.$day", []);

                $repeatTypes = $request->input("repeat_type.$day", []);


                foreach ($taskList as $index => $taskTitle) {

                    $taskTitle = trim($taskTitle);


                    /*
                    * Empty task row ignore karo
                    */
                    if ($taskTitle === '') {
                        continue;
                    }


                    $taskId = $taskIds[$index] ?? null;

                    $repeatType = $repeatTypes[$index] ?? 'weekly';


                    /*
                    |--------------------------------------------------------------------------
                    | Existing Task
                    |--------------------------------------------------------------------------
                    */

                    if ($taskId) {

                        $task = SeoPlanTask::where('id', $taskId)
                            ->where('seo_plan_id', $plan->id)
                            ->first();


                        if ($task) {

                            $task->update([
                                'day'         => $day,
                                'task_title'  => $taskTitle,
                                'repeat_type' => $repeatType,
                                'sort_order'  => $index + 1,
                                'status'      => 1,
                            ]);

                            $keptTaskIds[] = $task->id;

                            continue;
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | New Task
                    |--------------------------------------------------------------------------
                    */

                    $newTask = SeoPlanTask::create([
                        'seo_plan_id' => $plan->id,
                        'day'         => $day,
                        'task_title'  => $taskTitle,
                        'repeat_type' => $repeatType,
                        'sort_order'  => $index + 1,
                        'status'      => 1,
                    ]);

                    $keptTaskIds[] = $newTask->id;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Remove Tasks Deleted From Edit Screen
            |--------------------------------------------------------------------------
            */

            SeoPlanTask::where('seo_plan_id', $plan->id)
                ->when(
                    !empty($keptTaskIds),
                    function ($query) use ($keptTaskIds) {
                        $query->whereNotIn('id', $keptTaskIds);
                    }
                )
                ->delete();


            DB::commit();


            return redirect()
                ->route('admin.seo-plans.index')
                ->with(
                    'success',
                    'SEO Plan updated successfully.'
                );


        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(SeoPlan $seoPlan)
    // {
    //     $seoPlan->delete();

    //     return redirect()
    //         ->route('admin.seo-plans.index')
    //         ->with('success', 'SEO Plan deleted successfully.');
    // }

    public function destroy($id)
    {
        $seoPlan = SeoPlan::findOrFail($id);

        SeoPlanTask::where('seo_plan_id', $id)->delete();

        $seoPlan->delete();

        return redirect()->route('admin.seo-plans.index')
            ->with('success', 'SEO Plan deleted successfully');
    }
}