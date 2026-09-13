<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Carbon\CarbonPeriod;
use App\Models\SeoTeamTask;


use App\Models\SeoPlanClient;
use App\Models\SeoPlanTask;
use App\Models\SeoTeamWork;
use Carbon\Carbon;
use App\Models\SeoTaskDistribution;
use Illuminate\Support\Facades\DB;

use Illuminate\View\View;

class SeoTeamWorkController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:seo-team-task-list', ['only' => ['index']]);

    //     $this->middleware('permission:seo-team-task-view', ['only' => ['show']]);

    //     $this->middleware('permission:seo-team-task-create', ['only' => ['create', 'store']]);

    //     $this->middleware('permission:seo-team-task-edit', ['only' => ['edit', 'update']]);

    //     $this->middleware('permission:seo-team-task-delete', ['only' => ['destroy']]);
    // }
  

    

    public function complete(Request $request, $id)
    {
        $item = SeoTeamTaskItem::findOrFail($id);

        if($request->has('status'))
        {
            $item->status = 'Completed';
            $item->completed_at = now();
        }
        else
        {
            $item->status = 'Pending';
            $item->completed_at = null;
        }

        $item->remarks = $request->remarks;

        $item->save();

        return back()->with('success','Task updated successfully.');
    }



    // public function index()
    // {
    //     $today = strtolower(Carbon::now()->format('l'));
    //     $todayDate = now()->toDateString();

    //     $teamTasks = SeoPlanClient::with([
    //         'company',
    //         'seoPlan',
    //         'team'
    //     ])
    //     ->whereDate('start_date', '<=', $todayDate)
    //     ->whereDate('end_date', '>=', $todayDate)
    //     ->where('status', 'active');

    //     // Admin ko sab dikhana hai
    //     if (!auth()->user()->hasRole('Admin')) {
    //         $teamTasks->where('team_id', auth()->id()); // apna column name use kare
    //     }

    //     $teamTasks = $teamTasks->get();

    //     foreach ($teamTasks as $teamTask) {

    //         $teamTask->todayTasks = SeoPlanTask::where('seo_plan_id', $teamTask->seo_plan_id)
    //             ->where('day', $today)
    //             ->orderBy('sort_order')
    //             ->get();
    //     }

    //     return view('admin.seo-team-work.index', compact('teamTasks', 'today'));
    // }

    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        $today = strtolower(Carbon::now()->format('l')); // 'tuesday', 'monday' etc.
        $todayDate = now()->toDateString();

        // 1. Active Clients Fetch Query
        $clientQuery = SeoPlanClient::with(['company', 'seoPlan', 'team'])
            ->whereDate('start_date', '<=', $todayDate)
            ->whereDate('end_date', '>=', $todayDate)
            ->where('status', 'active');

        // Admin / Lead / Executive Access Check:
        // Admin ko sab dikhenge.
        // Agar Admin nahi hai, toh check karo client filter
        if (!$user->hasRole('Admin')) {
            // Executive ko sirf unhi clients se matlab hai jahan unko aaj ya continuous tasks assigned hain
            // Yaa fir user khud Team Lead ($client->team_id) ho
            $clientQuery->where(function($q) use ($userId) {
                $q->where('team_id', $userId)
                ->orWhereHas('distributions', function($dist) use ($userId) {
                    $dist->where('user_id', $userId);
                });
            });
        }

        $teamTasks = $clientQuery->get();

        // 2. Continuous/Bulk Querying for Today's Distributed Tasks (No N+1 Issue)
        $clientIds = $teamTasks->pluck('id')->toArray();

        $distQuery = SeoTaskDistribution::with(['task', 'user'])
            ->whereIn('seo_plan_client_id', $clientIds)
            ->where('day', $today);

        // Agar Admin ya Team Lead (team_id) nahi hai, to sirf login executive ke tasks laao
        // Note: Local filtering for individual executive view
        $allTodayDistributions = $distQuery->get()->groupBy('seo_plan_client_id');

        // 3. Attach todayTasks directly to each client object
        foreach ($teamTasks as $teamTask) {

            // Check if user has full access for THIS specific client (Admin OR Team Lead of this client)
            $hasFullAccess = $user->hasRole('Admin') 
                        || $user->hasAnyRole(['SEO Lead', 'SEO Head']) 
                        || ($teamTask->team_id == $userId);

            $clientDistributions = $allTodayDistributions->get($teamTask->id, collect());

            if (!$hasFullAccess) {
                // Executive ko sirf unke apne assigned tasks dikhenge
                $clientDistributions = $clientDistributions->where('user_id', $userId);
            }

            $teamTask->todayTasks = $clientDistributions;
        }

        return view('admin.seo-team-work.index', compact('teamTasks', 'today'));
    }

   

    // public function show($id)
    // {
    //     $planClient = SeoPlanClient::with([
    //         'company',
    //         'seoPlan'
    //     ])->findOrFail($id);

    //     $schedule = [];

    //     $projectStart = Carbon::parse($planClient->start_date)->startOfDay();
    //     $projectEnd   = Carbon::parse($planClient->end_date)->startOfDay();

    //     $currentDate = $projectStart->copy();

    //     while ($currentDate->lte($projectEnd)) {

    //         $day = strtolower($currentDate->format('l'));

    //         $taskQuery = SeoTaskDistribution::with('task')
    //             ->where('seo_plan_client_id', $planClient->id)
    //             ->where('day', $day);

    //         // SEO Executive only his tasks
    //         if (
    //             !auth()->user()->hasRole('Admin') &&
    //             !auth()->user()->hasRole('SEO Head')
    //         ) {
    //             $taskQuery->where('user_id', auth()->id());
    //         }

    //         $tasks = $taskQuery
    //             ->orderBy('seo_plan_task_id')
    //             ->get();

    //         foreach ($tasks as $distribution) {

    //             $task = $distribution->task;

    //             if (!$task) {
    //                 continue;
    //             }

    //             /*
    //             |--------------------------------------------------------------------------
    //             | Repeat Type Logic
    //             |--------------------------------------------------------------------------
    //             */

    //             $repeatType = $task->repeat_type ?? 'weekly';

    //             switch ($repeatType) {

    //                 /*
    //                 |--------------------------------------------------------------------------
    //                 | WEEKLY
    //                 |--------------------------------------------------------------------------
    //                 */

    //                 case 'weekly':
    //                     // Every occurrence
    //                     break;

    //                 /*
    //                 |--------------------------------------------------------------------------
    //                 | FIRST TIME
    //                 |--------------------------------------------------------------------------
    //                 */

    //                 case 'first_time':

    //                     $firstOccurrence = $projectStart->copy();

    //                     while (strtolower($firstOccurrence->format('l')) != $day) {
    //                         $firstOccurrence->addDay();
    //                     }

    //                     if (!$currentDate->isSameDay($firstOccurrence)) {
    //                         continue 2;
    //                     }

    //                     break;

    //                 /*
    //                 |--------------------------------------------------------------------------
    //                 | MONTHLY
    //                 |--------------------------------------------------------------------------
    //                 */

    //                 case 'monthly':

    //                     $firstOccurrence = $currentDate
    //                         ->copy()
    //                         ->startOfMonth();

    //                     while (strtolower($firstOccurrence->format('l')) != $day) {
    //                         $firstOccurrence->addDay();
    //                     }

    //                     if (!$currentDate->isSameDay($firstOccurrence)) {
    //                         continue 2;
    //                     }

    //                     break;

    //                 default:
    //                     break;
    //             }

    //             /*
    //             |--------------------------------------------------------------------------
    //             | Work
    //             |--------------------------------------------------------------------------
    //             */

    //             $work = SeoTeamWork::where([
    //                 'seo_task_distribution_id' => $distribution->id,
    //                 'work_date'                => $currentDate->toDateString(),
    //             ])->first();

    //             $schedule[] = [

    //                 'distribution_id' => $distribution->id,

    //                 'task_id'         => $task->id,

    //                 'task_title'      => $task->task_title,

    //                 'repeat_type'     => $repeatType,

    //                 'date'            => $currentDate->toDateString(),

    //                 'day'             => ucfirst($day),

    //                 'checked'         => !is_null($work),

    //                 'attachment'      => $work->attachment ?? null,

    //                 'remarks'         => $work->remarks ?? null,

    //                 'link'            => $work->link ?? null,

    //                 'status'          => $work->status ?? 'Pending',

    //                 'completed_at'    => $work->completed_at ?? null,

    //                 'is_today'        => $currentDate->isToday(),

    //                 'is_future'       => $currentDate->gt(now()),

    //             ];
    //         }

    //         $currentDate->addDay();
    //     }

    //     return view(
    //         'admin.seo-team-work.show',
    //         compact(
    //             'planClient',
    //             'schedule'
    //         )
    //     );
    // }

          public function show($id)
    {
        $planClient = SeoPlanClient::with([
            'company',
            'seoPlan',
        ])->findOrFail($id);

        $planStart = Carbon::parse($planClient->start_date)->startOfDay();
        $planEnd   = Carbon::parse($planClient->end_date)->startOfDay();

        $today = Carbon::now();

        /*
        |--------------------------------------------------------------------------
        | Current week (Monday - Saturday) — used for the "Today Tasks" tab
        |--------------------------------------------------------------------------
        */
        $currentWeekStart = $today->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $currentWeekEnd   = $currentWeekStart->copy()->addDays(5)->endOfDay();

        $isAdminOrHead = auth()->user()->hasRole('Admin')
            || auth()->user()->hasRole('SEO Head');

        /*
        |--------------------------------------------------------------------------
        | Load ALL distributions for this client once (mon-sat)
        |--------------------------------------------------------------------------
        */
        $distributionQuery = SeoTaskDistribution::with('task')
            ->where('seo_plan_client_id', $planClient->id)
            ->whereIn('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);

        if (!$isAdminOrHead) {
            $distributionQuery->where('user_id', auth()->id());
        }

        $distributions = $distributionQuery
            ->orderBy('seo_plan_task_id')
            ->get();

        $distributionsByDay = $distributions->groupBy('day');

        /*
        |--------------------------------------------------------------------------
        | Load ALL SeoTeamWork rows for these distributions across the whole plan
        | (grouped by distribution id, so we can match "any date within window")
        |--------------------------------------------------------------------------
        */
        $workByDistribution = SeoTeamWork::whereIn('seo_task_distribution_id', $distributions->pluck('id'))
            ->whereBetween('work_date', [
                $planStart->toDateString(),
                $planEnd->copy()->addDays(6)->toDateString(),
            ])
            ->get()
            ->groupBy('seo_task_distribution_id');

        /*
        |--------------------------------------------------------------------------
        | Build every scheduled occurrence for the WHOLE plan (date by date)
        |--------------------------------------------------------------------------
        */
        $allRows = collect();

        $cursor = $planStart->copy();

        while ($cursor->lte($planEnd)) {

            $day = strtolower($cursor->format('l'));

            $dayDistributions = $distributionsByDay->get($day, collect());

            foreach ($dayDistributions as $distribution) {

                $task = $distribution->task;

                if (!$task) {
                    continue;
                }

                $repeatType = $task->repeat_type ?? 'weekly';

                switch ($repeatType) {

                    case 'weekly':
                        // Every occurrence
                        break;

                    case 'first_time':

                        $firstOccurrence = $planStart->copy();

                        while (strtolower($firstOccurrence->format('l')) != $day) {
                            $firstOccurrence->addDay();
                        }

                        if (!$cursor->isSameDay($firstOccurrence)) {
                            continue 2;
                        }

                        break;

                    case 'monthly':

                        $firstOccurrence = $cursor->copy()->startOfMonth();

                        while (strtolower($firstOccurrence->format('l')) != $day) {
                            $firstOccurrence->addDay();
                        }

                        if (!$cursor->isSameDay($firstOccurrence)) {
                            continue 2;
                        }

                        break;

                    default:
                        break;
                }

                /*
                |----------------------------------------------------------------
                | Window for THIS occurrence = Monday-Saturday containing $cursor
                |----------------------------------------------------------------
                */
                $windowStart = $cursor->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
                $windowEnd   = $windowStart->copy()->addDays(5)->endOfDay();

                $works = $workByDistribution->get($distribution->id, collect());

                $matchingWork = $works->first(function ($w) use ($windowStart, $windowEnd) {
                    $wd = Carbon::parse($w->work_date);
                    return $wd->betweenIncluded($windowStart, $windowEnd);
                });

                $checked = !is_null($matchingWork);

                if ($checked) {
                    $status = 'completed';
                } elseif ($today->betweenIncluded($windowStart, $windowEnd)) {
                    $status = 'available';
                } elseif ($today->lt($windowStart)) {
                    $status = 'upcoming';
                } else {
                    $status = 'overdue';
                }

                $assignedUser = null;
                if (method_exists($distribution, 'user') && $distribution->user) {
                    $assignedUser = $distribution->user->name ?? null;
                }

                $allRows->push([
                    'distribution_id' => $distribution->id,
                    'task_id'         => $task->id,
                    'task_title'      => $task->task_title,
                    'repeat_type'     => $repeatType,
                    'date'            => $cursor->toDateString(),
                    'day'             => ucfirst($day),
                    'checked'         => $checked,
                    'attachment'      => $matchingWork->attachment ?? null,
                    'remarks'         => $matchingWork->remarks ?? null,
                    'link'            => $matchingWork->link ?? null,
                    'status_label'    => $status, // completed | available | upcoming | overdue
                    'completed_at'    => $matchingWork->completed_at ?? null,
                    'is_today'        => $cursor->isToday(),
                    'assigned_user'   => $assignedUser,
                    'window_start'    => $windowStart,
                    'window_end'      => $windowEnd,
                ]);
            }

            $cursor->addDay();
        }

        /*
        |--------------------------------------------------------------------------
        | TAB 1 — TODAY TASKS (current week window only)
        |--------------------------------------------------------------------------
        */
        $currentWeekRows = $allRows->filter(function ($row) use ($currentWeekStart) {
            return $row['window_start']->isSameDay($currentWeekStart);
        })->values();

        $currentWeekDays = [];

        $dayCursor = $currentWeekStart->copy();
        while ($dayCursor->lte($currentWeekEnd)) {

            $dayName = strtolower($dayCursor->format('l'));

            $tasksForDay = $currentWeekRows
                ->where('date', $dayCursor->toDateString())
                ->values()
                ->all();

            $currentWeekDays[] = [
                'day_name'   => ucfirst($dayName),
                'date'       => $dayCursor->copy(),
                'is_today'   => $dayCursor->isToday(),
                'tasks'      => $tasksForDay,
                'task_count' => count($tasksForDay),
            ];

            $dayCursor->addDay();
        }

        $currentWeekTotal     = $currentWeekRows->count();
        $currentWeekCompleted = $currentWeekRows->where('checked', true)->count();
        $currentWeekPending   = $currentWeekTotal - $currentWeekCompleted;
        $currentWeekProgress  = $currentWeekTotal > 0
            ? (int) round(($currentWeekCompleted / $currentWeekTotal) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | TAB 2 — ALL TASKS (whole plan, grouped week by week)
        |--------------------------------------------------------------------------
        */
        $planWeeks = [];

        $weekCursor = $planStart->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $weekIndex  = 1;

        while ($weekCursor->lte($planEnd)) {

            $wStart = $weekCursor->copy();
            $wEnd   = $wStart->copy()->addDays(5)->endOfDay();

            $weekRows = $allRows->filter(function ($row) use ($wStart) {
                return $row['window_start']->isSameDay($wStart);
            })->values();

            $weekDays = [];
            $wDayCursor = $wStart->copy();

            while ($wDayCursor->lte($wEnd)) {

                if ($wDayCursor->between($planStart, $planEnd)) {

                    $dayName = strtolower($wDayCursor->format('l'));

                    $tasksForDay = $weekRows
                        ->where('date', $wDayCursor->toDateString())
                        ->values()
                        ->all();

                    $weekDays[] = [
                        'day_name'   => ucfirst($dayName),
                        'date'       => $wDayCursor->copy(),
                        'is_today'   => $wDayCursor->isToday(),
                        'tasks'      => $tasksForDay,
                        'task_count' => count($tasksForDay),
                    ];
                }

                $wDayCursor->addDay();
            }

            if (!empty($weekDays)) {
                $planWeeks[] = [
                    'week_number' => $weekIndex,
                    'week_start'  => $wStart,
                    'week_end'    => $wEnd,
                    'days'        => $weekDays,
                    'total'       => $weekRows->count(),
                    'completed'   => $weekRows->where('checked', true)->count(),
                ];
                $weekIndex++;
            }

            $weekCursor->addDays(7);
        }

        $planTotal     = $allRows->count();
        $planCompleted = $allRows->where('checked', true)->count();
        $planPending   = $planTotal - $planCompleted;
        $planProgress  = $planTotal > 0
            ? (int) round(($planCompleted / $planTotal) * 100)
            : 0;

        return view('admin.seo-team-work.show', compact(
            'planClient',
            'planStart',
            'planEnd',
            'currentWeekStart',
            'currentWeekEnd',
            'currentWeekDays',
            'currentWeekTotal',
            'currentWeekCompleted',
            'currentWeekPending',
            'currentWeekProgress',
            'planWeeks',
            'planTotal',
            'planCompleted',
            'planPending',
            'planProgress'
        ));
    }




   
    

    
   

    

   




   

    public function store(Request $request)
    {
        $request->validate([
            'seo_plan_client_id' => 'required|exists:seo_plan_clients,id',
            'distribution_id'    => 'required|exists:seo_task_distributions,id',
            'attachment'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remarks'            => 'nullable|string',
            'link'               => 'nullable|url',
        ]);

        DB::beginTransaction();

        try {

            $distribution = SeoTaskDistribution::findOrFail($request->distribution_id);

            // Security
            if (
                !auth()->user()->hasRole('Admin') &&
                !auth()->user()->hasRole('SEO Head') &&
                $distribution->user_id != auth()->id()
            ) {
                abort(403);
            }

            $attachment = null;

            if ($request->hasFile('attachment')) {

                $file = $request->file('attachment');

                $fileName = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('uploads/seo-team-work'), $fileName);

                $attachment = 'uploads/seo-team-work/'.$fileName;
            }

            SeoTeamWork::updateOrCreate(
                [
                    'seo_plan_client_id' => $distribution->seo_plan_client_id,
                    'seo_plan_task_id'   => $distribution->seo_plan_task_id,
                    'work_date'          => now()->toDateString(),
                ],
                [
                    'seo_task_distribution_id' => $distribution->id,
                    'team_id'                  => $distribution->user_id,
                    'attachment'               => $attachment,
                    'remarks'                  => $request->remarks,
                    'link'                     => $request->link,
                    'status'                   => 'Completed',
                    'completed_at'             => now(),
                ]
            );

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Task completed successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    
}






