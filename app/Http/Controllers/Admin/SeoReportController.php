<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SeoPlanClient;
use App\Models\SeoTeamWork;
use App\Models\Company;


use App\Models\SeoPlanTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonPeriod;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\SeoTaskDistribution;

use App\Models\BacklinkAssignment;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\View\View;

use App\Models\OnPageSeo;
use App\Models\SeoProjectKeyword;
use App\Models\SeoProjectLocation;



class SeoReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:seo-reports', ['only' => ['index']]);
    }


    public function index()
    {
        $companies = Company::orderBy('name')->get();

        return view('admin.seo-report.index', compact('companies'));
    }

    public function generate(Request $request)
    {
        // dd(extension_loaded('gd'));
        $request->validate([
            'company_id'     => 'required|exists:companies,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'report_remarks' => 'nullable|string',
        ]);

        $company = Company::findOrFail($request->company_id);

        $works = SeoTeamWork::with([
            'planTask',
            'planClient.company',
            'team'
        ])
        ->whereHas('planClient', function ($q) use ($request) {
            $q->where('company_id', $request->company_id);
        })
        ->whereBetween('work_date', [
            $request->start_date,
            $request->end_date
        ])
        ->orderBy('work_date')
        ->get();

        $pdf = Pdf::loadView('admin.seo-report.pdf', [

            'company'         => $company,
            'works'           => $works,
            'startDate'       => $request->start_date,
            'endDate'         => $request->end_date,
            'reportRemarks'   => $request->report_remarks,

        ]);

        return $pdf->download(
            'SEO-Report-'.$company->name.'.pdf'
        );
    }


    // 

   

    // public function dashboard()
    // {
    //     $packages = SeoPlanClient::with([
    //         'company',
    //         'seoPlan',
    //         'assignedUser.designation',
    //     ])
    //     ->where('status', 'active')
    //     ->orderBy('company_id')
    //     ->get();
    
    //     foreach ($packages as $package) {
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Overall Health (unchanged)
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $works = SeoTeamWork::where(
    //             'seo_plan_client_id',
    //             $package->id
    //         )->get();
    
    //         $totalTasks = $works->count();
    
    //         $completedTasks = $works
    //             ->where('status', 'Completed')
    //             ->count();
    
    //         $pendingTasks = $totalTasks - $completedTasks;
    
    //         $overallHealth = $totalTasks > 0
    //             ? round(($completedTasks / $totalTasks) * 100)
    //             : 0;
    
    //         $package->total_tasks      = $totalTasks;
    //         $package->completed_tasks  = $completedTasks;
    //         $package->pending_tasks    = $pendingTasks;
    //         $package->overall_health   = $overallHealth;
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Expected Daily Tasks — from seo_plan_tasks (the plan's task
    //         | template), NOT from seo_team_works.
    //         |
    //         | >>> VERIFY THIS ONE LINE against your seo_plan_tasks schema <<<
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $dailyExpectedTasks = SeoPlanTask::where(
    //             'seo_plan_id',
    //             $package->seo_plan_id
    //         )->count();
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Weekly Health
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $weeks = [];
    
    //         $start = Carbon::parse($package->start_date)->startOfDay();
    //         $end   = Carbon::parse($package->end_date)->endOfDay();
    //         $today = Carbon::now()->endOfDay();
    
    //         $weekNo = 1;
    
    //         while ($start->lte($end)) {
    
    //             $weekStart = $start->copy();
    
    //             $weekEnd = $start->copy()->addDays(6);
    
    //             if ($weekEnd->gt($end)) {
    //                 $weekEnd = $end->copy();
    //             }
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | Expected Tasks for the FULL week
    //             |
    //             | This is the fix: the denominator is always the whole week's
    //             | expected task count (dailyExpectedTasks x days in this week),
    //             | never just "today". A partial/boundary week (e.g. the plan's
    //             | first or last week) naturally has fewer days, so it's counted
    //             | correctly instead of assuming 7.
    //             |--------------------------------------------------------------------------
    //             */
    
    //             $daysInWeek = $weekStart->diffInDays($weekEnd) + 1;
    
    //             $expectedTasks = $dailyExpectedTasks * $daysInWeek;
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | Completed Tasks — still pulled from seo_team_works, scoped to
    //             | this week's date range. For the current week this naturally
    //             | only includes days up to today, since work rows only exist
    //             | for days that have actually happened.
    //             |--------------------------------------------------------------------------
    //             */
    
    //             $weekWorks = $works->filter(function ($item) use ($weekStart, $weekEnd) {
    
    //                 return Carbon::parse($item->work_date)
    //                     ->between($weekStart, $weekEnd);
    
    //             });
    
    //             $weekCompleted = $weekWorks
    //                 ->where('status', 'Completed')
    //                 ->count();
    
    //             $weekRemaining = max($expectedTasks - $weekCompleted, 0);
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | Future / Current / Past
    //             |--------------------------------------------------------------------------
    //             */
    
    //             $isFuture = $weekStart->gt($today);
    
    //             $health = ($expectedTasks > 0 && !$isFuture)
    //                 ? round(($weekCompleted / $expectedTasks) * 100)
    //                 : 0;
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | Color
    //             |--------------------------------------------------------------------------
    //             */
    
    //             if ($isFuture) {
    
    //                 $color = 'secondary';
    
    //             } elseif ($health >= 90) {
    
    //                 $color = 'success';
    
    //             } elseif ($health >= 70) {
    
    //                 $color = 'warning';
    
    //             } elseif ($health >= 40) {
    
    //                 $color = 'orange';
    
    //             } else {
    
    //                 $color = 'danger';
    
    //             }
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | Week Array
    //             |--------------------------------------------------------------------------
    //             */
    
    //             $weeks[] = [
    
    //                 'week'        => $weekNo,
    
    //                 'start'       => $weekStart->toDateString(),
    
    //                 'end'         => $weekEnd->toDateString(),
    
    //                 'future'      => $isFuture,
    
    //                 'health'      => $health,
    
    //                 'expected'    => $expectedTasks,
    
    //                 'completed'   => $weekCompleted,
    
    //                 'remaining'   => $weekRemaining,
    
    //                 'color'       => $color,
    
    //             ];
    
    //             $weekNo++;
    
    //             $start = $weekEnd->copy()->addDay();
    //         }
    
    //         $package->weeks = $weeks;
    //     }
    
    //     return view(
    //         'admin.seo-report.dashboard',
    //         compact('packages')
    //     );
    // }


    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | Packages
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->hasRole('Admin') ||
            auth()->user()->hasRole('SEO Head')
        ) {

            $packages = SeoPlanClient::with([
                'company',
                'seoPlan',
                'assignedUser.designation',
            ])
            ->where('status', 'active')
            ->orderBy('company_id')
            ->get();

        } else {

            $clientIds = SeoTaskDistribution::where('user_id', auth()->id())
                ->pluck('seo_plan_client_id')
                ->unique();

            $packages = SeoPlanClient::with([
                'company',
                'seoPlan',
                'assignedUser.designation',
            ])
            ->whereIn('id', $clientIds)
            ->where('status', 'active')
            ->orderBy('company_id')
            ->get();
        }

        foreach ($packages as $package) {

            /*
            |--------------------------------------------------------------------------
            | Distribution
            |--------------------------------------------------------------------------
            */

            $distributionQuery = SeoTaskDistribution::where(
                'seo_plan_client_id',
                $package->id
            );

            if (
                !auth()->user()->hasRole('Admin') &&
                !auth()->user()->hasRole('SEO Head')
            ) {
                $distributionQuery->where('user_id', auth()->id());
            }

            $distributions = $distributionQuery->get();

            /*
            |--------------------------------------------------------------------------
            | Works
            |--------------------------------------------------------------------------
            */

            $workQuery = SeoTeamWork::where(
                'seo_plan_client_id',
                $package->id
            );

            if (
                !auth()->user()->hasRole('Admin') &&
                !auth()->user()->hasRole('SEO Head')
            ) {
                $workQuery->where('team_id', auth()->id());
            }

            $works = $workQuery->get();

            /*
            |--------------------------------------------------------------------------
            | Overall
            |--------------------------------------------------------------------------
            */

            $totalTasks = $distributions->count();



            $completedTasks = $works
                ->where('status', 'Completed')
                ->count();

            $pendingTasks = max(
                $totalTasks - $completedTasks,
                0
            );

            $overallHealth = $totalTasks > 0
                ? round(($completedTasks / $totalTasks) * 100)
                : 0;

            $package->total_tasks = $totalTasks;
            $package->completed_tasks = $completedTasks;
            $package->pending_tasks = $pendingTasks;
            $package->overall_health = $overallHealth;

            // return $completedTasks;

            /*
            |--------------------------------------------------------------------------
            | Weekly Health
            |--------------------------------------------------------------------------
            */

            $weeks = [];

            $start = Carbon::parse($package->start_date)->startOfDay();
            $end = Carbon::parse($package->end_date)->endOfDay();

            $today = Carbon::today();

            $weekNo = 1;

            while ($start->lte($end)) {

                $weekStart = $start->copy();

                $weekEnd = $start->copy()->addDays(6);

                if ($weekEnd->gt($end)) {
                    $weekEnd = $end->copy();
                }

                $daysInWeek = $weekStart->diffInDays($weekEnd) + 1;

                /*
                |--------------------------------------------------------------------------
                | Expected
                |--------------------------------------------------------------------------
                */

                $expectedTasks = 0;

                $tempDate = $weekStart->copy();

                while ($tempDate->lte($weekEnd)) {

                    $dayName = strtolower($tempDate->format('l'));

                    $expectedTasks += $distributions
                        ->where('day', $dayName)
                        ->count();

                    $tempDate->addDay();
                }

                /*
                |--------------------------------------------------------------------------
                | Completed
                |--------------------------------------------------------------------------
                */

                $weekCompleted = $works
                    ->filter(function ($item) use ($weekStart, $weekEnd) {

                        return Carbon::parse($item->work_date)
                            ->between($weekStart, $weekEnd);

                    })
                    ->where('status', 'Completed')
                    ->count();

                $weekRemaining = max(
                    $expectedTasks - $weekCompleted,
                    0
                );

                $isFuture = $weekStart->gt($today);

                $health = ($expectedTasks > 0 && !$isFuture)
                    ? round(($weekCompleted / $expectedTasks) * 100)
                    : 0;

                if ($isFuture) {

                    $color = 'secondary';

                } elseif ($health >= 90) {

                    $color = 'success';

                } elseif ($health >= 70) {

                    $color = 'warning';

                } elseif ($health >= 40) {

                    $color = 'orange';

                } else {

                    $color = 'danger';

                }

                $weeks[] = [

                    'week' => $weekNo,

                    'start' => $weekStart->toDateString(),

                    'end' => $weekEnd->toDateString(),

                    'future' => $isFuture,

                    'health' => $health,

                    'expected' => $expectedTasks,

                    'completed' => $weekCompleted,

                    'remaining' => $weekRemaining,

                    'color' => $color,

                ];

                $weekNo++;

                $start = $weekEnd->copy()->addDay();
            }

            $package->weeks = $weeks;
        }

        dd($package);

        return view(
            'admin.seo-report.dashboard',
            compact('packages')
        );
    }






    


    // public function reports()
    // {
    //     $companyId = auth()->user()->company->id;
 
    //     // 'company' is eager-loaded too — it's the relation that holds the
    //     // client name shown on each package card.
    //     $planClients = SeoPlanClient::with(['seoPlan', 'company'])
    //         ->where('company_id', $companyId)
    //         ->where('status', 'active')
    //         ->get();
 
    //     foreach ($planClients as $planClient) {
 
    //         $planClient->reports = SeoTeamWork::where('seo_plan_client_id', $planClient->id)
    //             ->where('status', 'Completed')
    //             ->select('work_date')
    //             ->distinct()
    //             ->orderByDesc('work_date')
    //             ->get();
 
    //         // ------------------------------------------------------------
    //         // Per-package metrics for the progress bar / mini-metrics.
    //         // "Total" = expected reporting days between start_date and
    //         // today (or end_date, whichever is sooner), Sundays excluded.
    //         // Adjust the exclusion rule below if your reporting calendar
    //         // differs (e.g. no exclusions, or Sat+Sun off).
    //         // ------------------------------------------------------------
    //         $start = Carbon::parse($planClient->start_date);
    //         $end   = Carbon::parse($planClient->end_date);
    //         $cap   = Carbon::now()->lt($end) ? Carbon::now() : $end;
 
    //         $totalExpected = 0;
    //         if ($start->lte($cap)) {
    //             $period = CarbonPeriod::create($start, $cap);
    //             foreach ($period as $day) {
    //                 if ($day->dayOfWeek !== Carbon::SUNDAY) {
    //                     $totalExpected++;
    //                 }
    //             }
    //         }
 
    //         $completed = $planClient->reports->count();
    //         $pending   = max($totalExpected - $completed, 0);
    //         $progress  = $totalExpected ? round($completed / $totalExpected * 100) : 0;
 
    //         $planClient->total_reports     = $totalExpected;
    //         $planClient->completed_reports = $completed;
    //         $planClient->pending_reports   = $pending;
    //         $planClient->progress          = $progress;
    //     }
 
    //     // Top summary cards
    //     $totalPackages    = $planClients->count();
    //     $completedReports = $planClients->sum('completed_reports');
    //     $pendingReports   = $planClients->sum('pending_reports');
    //     $overallProgress  = $totalPackages ? round($planClients->avg('progress')) : 0;
 
    //     return view('admin.seo-report.reports', compact(
    //         'planClients',
    //         'totalPackages',
    //         'completedReports',
    //         'pendingReports',
    //         'overallProgress'
    //     ));
    // }

    // public function adminReports($planClientId)
    // {
    //     $planClient = SeoPlanClient::with([
    //         'company',
    //         'seoPlan'
    //     ])->findOrFail($planClientId);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Reports
    //     |--------------------------------------------------------------------------
    //     */

    //     $planClient->reports = SeoTeamWork::where('seo_plan_client_id', $planClient->id)
    //         ->where('status', 'Completed')
    //         ->select('work_date')
    //         ->distinct()
    //         ->orderByDesc('work_date')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Progress Calculation
    //     |--------------------------------------------------------------------------
    //     */

    //     $start = Carbon::parse($planClient->start_date);
    //     $end   = Carbon::parse($planClient->end_date);

    //     $cap = now()->lt($end) ? now() : $end;

    //     $totalExpected = 0;

    //     if ($start->lte($cap)) {

    //         $period = CarbonPeriod::create($start, $cap);

    //         foreach ($period as $day) {

    //             if ($day->dayOfWeek !== Carbon::SUNDAY) {
    //                 $totalExpected++;
    //             }
    //         }
    //     }

    //     $completed = $planClient->reports->count();

    //     $pending = max($totalExpected - $completed, 0);

    //     $progress = $totalExpected
    //         ? round(($completed / $totalExpected) * 100)
    //         : 0;

    //     $planClient->total_reports     = $totalExpected;
    //     $planClient->completed_reports = $completed;
    //     $planClient->pending_reports   = $pending;
    //     $planClient->progress          = $progress;

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Variables required by reports.blade.php
    //     |--------------------------------------------------------------------------
    //     */

    //     $totalPackages    = 1;

    //     $completedReports = $completed;

    //     $pendingReports   = $pending;

    //     $overallProgress  = $progress;

    //     // Blade foreach($planClients as $planClient) use kar rahi hai
    //     $planClients = collect([$planClient]);

    //     return view(
    //         'admin.seo-report.reports',
    //         compact(
    //             'planClients',
    //             'totalPackages',
    //             'completedReports',
    //             'pendingReports',
    //             'overallProgress'
    //         )
    //     );
    // }


    // add distribution vise


    // public function reports()
    // {
    //     $companyId = auth()->user()->company->id;

    //     $planClients = SeoPlanClient::with([
    //         'seoPlan',
    //         'company'
    //     ])
    //     ->where('company_id', $companyId)
    //     ->where('status', 'active')
    //     ->get();

    //     foreach ($planClients as $planClient) {

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Completed Report Dates
    //         |--------------------------------------------------------------------------
    //         */

    //         $planClient->reports = SeoTeamWork::where(
    //                 'seo_plan_client_id',
    //                 $planClient->id
    //             )
    //             ->where('status', 'Completed')
    //             ->select('work_date')
    //             ->distinct()
    //             ->orderByDesc('work_date')
    //             ->get();

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Total Expected Reports
    //         |--------------------------------------------------------------------------
    //         */

    //         $start = Carbon::parse($planClient->start_date);
    //         $end   = Carbon::parse($planClient->end_date);

    //         $today = now()->lt($end)
    //             ? now()
    //             : $end;

    //         $distributionCount = SeoTaskDistribution::where(
    //                 'seo_plan_client_id',
    //                 $planClient->id
    //             )
    //             ->count();

    //         $totalExpected = 0;

    //         if ($distributionCount > 0 && $start->lte($today)) {

    //             $period = CarbonPeriod::create($start, $today);

    //             foreach ($period as $date) {

    //                 if ($date->isSunday()) {
    //                     continue;
    //                 }

    //                 $totalExpected += $distributionCount;
    //             }
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Completed
    //         |--------------------------------------------------------------------------
    //         */

    //         $completed = SeoTeamWork::where(
    //                 'seo_plan_client_id',
    //                 $planClient->id
    //             )
    //             ->where('status', 'Completed')
    //             ->count();

    //         $pending = max($totalExpected - $completed, 0);

    //         $progress = $totalExpected
    //             ? round(($completed / $totalExpected) * 100)
    //             : 0;

    //         $planClient->total_reports     = $totalExpected;
    //         $planClient->completed_reports = $completed;
    //         $planClient->pending_reports   = $pending;
    //         $planClient->progress          = $progress;
    //     }

    //     $totalPackages = $planClients->count();

    //     $completedReports = $planClients->sum('completed_reports');

    //     $pendingReports = $planClients->sum('pending_reports');

    //     $overallProgress = $totalPackages
    //         ? round($planClients->avg('progress'))
    //         : 0;

    //     return view(
    //         'admin.seo-report.reports',
    //         compact(
    //             'planClients',
    //             'totalPackages',
    //             'completedReports',
    //             'pendingReports',
    //             'overallProgress'
    //         )
    //     );
    // }

    // public function adminReports($planClientId)
    // {
    //     $planClient = SeoPlanClient::with([
    //         'company',
    //         'seoPlan'
    //     ])->findOrFail($planClientId);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Report Dates
    //     |--------------------------------------------------------------------------
    //     */

    //     $planClient->reports = SeoTeamWork::where(
    //             'seo_plan_client_id',
    //             $planClient->id
    //         )
    //         ->where('status', 'Completed')
    //         ->select('work_date')
    //         ->distinct()
    //         ->orderByDesc('work_date')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Progress
    //     |--------------------------------------------------------------------------
    //     */

    //     $start = Carbon::parse($planClient->start_date);

    //     $end = Carbon::parse($planClient->end_date);

    //     $today = now()->lt($end)
    //         ? now()
    //         : $end;

    //     $distributionCount = SeoTaskDistribution::where(
    //             'seo_plan_client_id',
    //             $planClient->id
    //         )
    //         ->count();

    //     $totalExpected = 0;

    //     if ($distributionCount > 0 && $start->lte($today)) {

    //         $period = CarbonPeriod::create($start, $today);

    //         foreach ($period as $date) {

    //             if ($date->isSunday()) {
    //                 continue;
    //             }

    //             $totalExpected += $distributionCount;
    //         }
    //     }

    //     $completed = SeoTeamWork::where(
    //             'seo_plan_client_id',
    //             $planClient->id
    //         )
    //         ->where('status', 'Completed')
    //         ->count();

    //     $pending = max($totalExpected - $completed, 0);

    //     $progress = $totalExpected
    //         ? round(($completed / $totalExpected) * 100)
    //         : 0;

    //     $planClient->total_reports     = $totalExpected;
    //     $planClient->completed_reports = $completed;
    //     $planClient->pending_reports   = $pending;
    //     $planClient->progress          = $progress;

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Summary
    //     |--------------------------------------------------------------------------
    //     */

    //     $totalPackages = 1;

    //     $completedReports = $completed;

    //     $pendingReports = $pending;

    //     $overallProgress = $progress;

    //     $planClients = collect([$planClient]);

    //     return view(
    //         'admin.seo-report.reports',
    //         compact(
    //             'planClients',
    //             'totalPackages',
    //             'completedReports',
    //             'pendingReports',
    //             'overallProgress'
    //         )
    //     );
    // }

    public function reports()
{
    $companyId = auth()->user()->company->id;

    $planClients = SeoPlanClient::with([
        'seoPlan',
        'company'
    ])
    ->where('company_id', $companyId)
    ->where('status', 'active')
    ->get();

    foreach ($planClients as $planClient) {

        /*
        |--------------------------------------------------------------------------
        | Report Dates
        |--------------------------------------------------------------------------
        */

        $planClient->reports = SeoTeamWork::where(
                'seo_plan_client_id',
                $planClient->id
            )
            ->where('status', 'Completed')
            ->select('work_date')
            ->distinct()
            ->orderByDesc('work_date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Expected Tasks
        |--------------------------------------------------------------------------
        */

        $start = Carbon::parse($planClient->start_date);
        $end   = Carbon::parse($planClient->end_date);

        $today = now()->lt($end)
            ? now()
            : $end;

        $totalExpected = 0;

        if ($start->lte($today)) {

            $period = CarbonPeriod::create($start, $today);

            foreach ($period as $date) {

                if ($date->isSunday()) {
                    continue;
                }

                $day = strtolower($date->format('l'));

                $expectedToday = SeoTaskDistribution::where(
                        'seo_plan_client_id',
                        $planClient->id
                    )
                    ->where('day', $day)
                    ->count();

                $totalExpected += $expectedToday;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Completed
        |--------------------------------------------------------------------------
        */

        $completed = SeoTeamWork::where(
                'seo_plan_client_id',
                $planClient->id
            )
            ->where('status', 'Completed')
            ->count();

        $pending = max($totalExpected - $completed, 0);

        $progress = $totalExpected
            ? round(($completed / $totalExpected) * 100)
            : 0;

        $planClient->total_reports     = $totalExpected;
        $planClient->completed_reports = $completed;
        $planClient->pending_reports   = $pending;
        $planClient->progress          = $progress;
    }

    $totalPackages = $planClients->count();

    $completedReports = $planClients->sum('completed_reports');

    $pendingReports = $planClients->sum('pending_reports');

    $overallProgress = $totalPackages
        ? round($planClients->avg('progress'))
        : 0;

    return view(
        'admin.seo-report.reports',
        compact(
            'planClients',
            'totalPackages',
            'completedReports',
            'pendingReports',
            'overallProgress'
        )
    );
}


    public function adminReports($planClientId)
    {
        $planClient = SeoPlanClient::with([
            'company',
            'seoPlan'
        ])->findOrFail($planClientId);

        /*
        |--------------------------------------------------------------------------
        | Report Dates
        |--------------------------------------------------------------------------
        */

        $planClient->reports = SeoTeamWork::where(
                'seo_plan_client_id',
                $planClient->id
            )
            ->where('status', 'Completed')
            ->select('work_date')
            ->distinct()
            ->orderByDesc('work_date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Expected Tasks
        |--------------------------------------------------------------------------
        */

        $start = Carbon::parse($planClient->start_date);

        $end = Carbon::parse($planClient->end_date);

        $today = now()->lt($end)
            ? now()
            : $end;

        $totalExpected = 0;

        if ($start->lte($today)) {

            $period = CarbonPeriod::create($start, $today);

            foreach ($period as $date) {

                if ($date->isSunday()) {
                    continue;
                }

                $day = strtolower($date->format('l'));

                $expectedToday = SeoTaskDistribution::where(
                        'seo_plan_client_id',
                        $planClient->id
                    )
                    ->where('day', $day)
                    ->count();

                $totalExpected += $expectedToday;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Completed
        |--------------------------------------------------------------------------
        */

        $completed = SeoTeamWork::where(
                'seo_plan_client_id',
                $planClient->id
            )
            ->where('status', 'Completed')
            ->count();

        $pending = max($totalExpected - $completed, 0);

        $progress = $totalExpected
            ? round(($completed / $totalExpected) * 100)
            : 0;

        $planClient->total_reports     = $totalExpected;
        $planClient->completed_reports = $completed;
        $planClient->pending_reports   = $pending;
        $planClient->progress          = $progress;

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $totalPackages = 1;

        $completedReports = $completed;

        $pendingReports = $pending;

        $overallProgress = $progress;

        $planClients = collect([$planClient]);

        return view(
            'admin.seo-report.reports',
            compact(
                'planClients',
                'totalPackages',
                'completedReports',
                'pendingReports',
                'overallProgress'
            )
        );
    }
 
   

    // public function reportDetail($planClientId, $date)
    // {
    //     $planClient = SeoPlanClient::with([
    //         'company',
    //         'seoPlan'
    //     ])->findOrFail($planClientId);

    //     return $planClient;

    //     $workDate = Carbon::parse($date)->toDateString();

    //     $day = strtolower(Carbon::parse($workDate)->format('l'));

    //     $query = SeoTaskDistribution::with([
    //         'task',
    //         'user',
    //         'work' => function ($q) use ($workDate) {
    //             $q->whereDate('work_date', $workDate);
    //         }
            
    //     ])
    //     ->where('seo_plan_client_id', $planClientId)
    //     ->where('day', $day);

    //     // return $query;

    //     // SEO Executive sirf apna report dekhega
    //     if (
    //         !auth()->user()->hasRole('Admin') &&
    //         !auth()->user()->hasRole('SEO Head')
    //     ) {
    //         $query->where('user_id', auth()->id());
    //     }

    //     $works = $query->get();

    //    foreach ($works as $item) {

    //         $work = SeoTeamWork::where('seo_plan_client_id', $planClientId)
    //             ->where('seo_plan_task_id', $item->seo_plan_task_id)
    //             ->whereDate('work_date', $workDate)
    //             ->first();

    //         $item->completed = !is_null($work);

    //         $item->status = $work?->status ?? 'Pending';

    //         $item->attachment = $work?->attachment;

    //         $item->remarks = $work?->remarks;

    //         $item->link = $work?->link;

    //         $item->completed_at = $work?->completed_at;
    //     }

    //     return view(
    //         'admin.seo-report.report-detail',
    //         compact(
    //             'planClient',
    //             'works',
    //             'workDate'
    //         )
    //     );
    // }

     public function reportDetail($planClientId, $date)
    {
        $planClient = SeoPlanClient::with([
            'company',
            'seoPlan'
        ])->findOrFail($planClientId);

        // return $planClient;

        $workDate = Carbon::parse($date)->toDateString();

        $day = strtolower(Carbon::parse($workDate)->format('l'));

        $query = SeoTaskDistribution::with([
            'task',
            'user',
            'work' => function ($q) use ($workDate) {
                $q->whereDate('work_date', $workDate);
            }
        ])
        ->where('seo_plan_client_id', $planClientId)
        ->where('day', $day);

        // Only SEO Executive should see their own tasks
        if(auth()->user()->hasRole('SEO Executive')){
            $query->where('user_id', auth()->id());
        }

        $works = $query->get();

       foreach ($works as $item) {

            $work = SeoTeamWork::where('seo_plan_client_id', $planClientId)
                ->where('seo_plan_task_id', $item->seo_plan_task_id)
                ->whereDate('work_date', $workDate)
                ->first();

            $item->completed = !is_null($work);

            $item->status = $work?->status ?? 'Pending';

            $item->attachment = $work?->attachment;

            $item->remarks = $work?->remarks;

            $item->link = $work?->link;

            $item->completed_at = $work?->completed_at;
        }

        return view(
            'admin.seo-report.report-detail',
            compact(
                'planClient',
                'works',
                'workDate'
            )
        );
    }



    // 



    public function distribution($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Package
        |--------------------------------------------------------------------------
        */

        $package = SeoPlanClient::with([
            'company',
            'seoPlan',
            'assignedUser.designation'
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | SEO Team
        |--------------------------------------------------------------------------
        |
        | Change this according to your system.
        | Example:
        | department = Digital Marketing
        | designation = SEO Executive
        |
        */

        // $seoUsers = User::where('department', 'Digital Marketing')
        //     ->orderBy('name')
        //     ->get();

        $seoUsers = User::whereHas('department', function ($query) {
                                    $query->where('department', '13');
                                })
                                ->orderBy('name')
                                ->get();    

        /*
        |--------------------------------------------------------------------------
        | Package Tasks
        |--------------------------------------------------------------------------
        */

        // $tasks = SeoPlanTask::where('seo_plan_id', $package->seo_plan_id)
        //     ->orderBy('sort')
        //     ->get();

        $tasks = SeoPlanTask::where('seo_plan_id', $package->seo_plan_id)
                    ->orderBy('day')
                    ->orderBy('sort_order')
                    ->get();

        // dd($tasks);            

        /*
        |--------------------------------------------------------------------------
        | Group By Day
        |--------------------------------------------------------------------------
        */

        $weeklyTasks = [];

        foreach ([
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday'
                ] as $day) {

                    $weeklyTasks[ucfirst($day)] = $tasks->where('day', strtolower($day))->values();

        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $assignedUsers = SeoTaskDistribution::where('seo_plan_client_id', $package->id)
                                                     ->pluck('user_id', 'seo_plan_task_id');

        $totalTasks = $tasks->count();

        $assignedTasks = 0;

        $remainingTasks = $totalTasks;

        // return $assignedUsers;

        return view(
            'admin.seo-report.distribution',
            compact(
                'package',
                'seoUsers',
                'weeklyTasks',
                'totalTasks',
                'assignedTasks',
                'remainingTasks',
                'assignedUsers',
            )
        );
    }

    // 

    public function distributionStore(Request $request, $id)
    {
        $package = SeoPlanClient::findOrFail($id);

        // return $request->all();

        if (!$request->has('tasks')) {
            return back()->with('error', 'Please assign at least one task.');
        }

        DB::beginTransaction();

        try {

            // Purane assignments delete
            SeoTaskDistribution::where('seo_plan_client_id', $package->id)->delete();

            foreach ($request->tasks as $taskId => $userId) {

                if (empty($userId)) {
                    continue;
                }

                $task = SeoPlanTask::find($taskId);

                SeoTaskDistribution::create([
                    'seo_plan_client_id' => $package->id,
                    'seo_plan_task_id'   => $taskId,
                    'user_id'            => $userId,
                    'day'                => $task->day,
                    'status'             => 'pending',
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.seo-team-work')
                ->with('success', 'SEO Task Distribution saved successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', $e->getMessage());

        }
    }

     /**
     * Minimum Domain Authority to be considered a "high authority" backlink.
     */
    private const HIGH_AUTHORITY_DA_THRESHOLD = 50;
 
    /**
     * Domain Authority below this is treated as a toxic/low-quality link.
     */
    private const TOXIC_DA_THRESHOLD = 20;
 
    /**
     * Display the SEO Audit Overview dashboard for a single client.
     *
     * Route example:
     *   Route::get('/clients/{client}/seo-audit-overview', [SeoAuditController::class, 'index']);
     *
     * $client is resolved via implicit route model binding to SeoPlanClient.
     */
    // public function clientreportdashboard(SeoPlanClient $client): View
    // {
    //     // =================================================================
    //     // OFF-PAGE SEO — driven live from BacklinkAssignment / Backlink
    //     // =================================================================
    //     $assignments = $client->backlinkAssignments()
    //         ->with('backlink.category')
    //         ->get();
 
    //     $totalAssignments     = $assignments->count();
    //     $completedAssignments = $assignments->where('status', 'completed');
 
    //     $backlinksCreatedScore   = $this->percentage($completedAssignments->count(), $totalAssignments);
    //     $highAuthorityLinksScore = $this->percentage(
    //         $completedAssignments->filter(fn ($a) => optional($a->backlink)->domain_authority >= self::HIGH_AUTHORITY_DA_THRESHOLD)->count(),
    //         $totalAssignments
    //     );
    //     $guestPostsScore       = $this->categoryCompletionScore($assignments, 'guest post');
    //     $businessListingsScore = $this->categoryCompletionScore($assignments, 'business listing');
    //     $socialSignalsScore    = $this->categoryCompletionScore($assignments, 'social');
    //     $citationBuildingScore = $this->categoryCompletionScore($assignments, 'citation');
 
    //     $toxicCount      = $completedAssignments->filter(fn ($a) => optional($a->backlink)->domain_authority < self::TOXIC_DA_THRESHOLD)->count();
    //     $toxicLinksScore = 100 - $this->percentage($toxicCount, $totalAssignments); // higher = cleaner link profile
 
    //     // TODO: no anchor-text field exists on backlink_assignments/backlinks yet.
    //     // Once an `anchor_text` column is added, compute real diversity here
    //     // (e.g. distinct anchor texts / total links * 100). Kept static for now.
    //     $anchorDiversityScore = 50;
 
    //     $offPageScore = (int) round(collect([
    //         $backlinksCreatedScore,
    //         $highAuthorityLinksScore,
    //         $guestPostsScore,
    //         $businessListingsScore,
    //         $socialSignalsScore,
    //         $anchorDiversityScore,
    //         $citationBuildingScore,
    //         $toxicLinksScore,
    //     ])->avg());
 
    //     // =================================================================
    //     // ON-PAGE SEO — no matching model was supplied (no page-crawl /
    //     // content-audit table exists yet). Left as configurable placeholders
    //     // so the view renders correctly; replace with a real crawler/audit
    //     // model (e.g. SeoPageAudit) once available.
    //     // =================================================================
    //     $titleTagsScore        = 0;
    //     $metaDescriptionScore  = 0;
    //     $headingStructureScore = 0;
    //     $imageAltTagsScore     = 0;
    //     $internalLinkingScore  = 0;
    //     $keywordDensityScore   = 0;
    //     $urlStructureScore     = 0;
    //     $canonicalUrlScore     = 0;
 
    //     $onPageScore = (int) round(collect([
    //         $titleTagsScore,
    //         $metaDescriptionScore,
    //         $headingStructureScore,
    //         $imageAltTagsScore,
    //         $internalLinkingScore,
    //         $keywordDensityScore,
    //         $urlStructureScore,
    //         $canonicalUrlScore,
    //     ])->avg());
 
    //     // =================================================================
    //     // TECHNICAL SEO — same situation as On-Page: no crawler/PageSpeed
    //     // model provided. Wire this to your PageSpeed Insights / crawler
    //     // integration once it exists.
    //     // =================================================================
    //     $pageSpeedScore      = 0;
    //     $mobileFriendlyScore = 0;
    //     $coreWebVitalsScore  = 0;
    //     $structuredDataScore = 0;
    //     $sitemapScore        = 0;
    //     $robotsTxtScore      = 0;
    //     $httpsScore          = 0;
    //     $brokenLinksScore    = 0;
 
    //     $technicalSeoScore = (int) round(collect([
    //         $pageSpeedScore,
    //         $mobileFriendlyScore,
    //         $coreWebVitalsScore,
    //         $structuredDataScore,
    //         $sitemapScore,
    //         $robotsTxtScore,
    //         $httpsScore,
    //         $brokenLinksScore,
    //     ])->avg());
 
    //     // =================================================================
    //     // WEBSITE HEALTH MATRIX
    //     // SEO Score is real (rolled up from the three sections above).
    //     // The rest (Performance, Accessibility, Best Practices, Security,
    //     // Indexability, Crawlability, Page Experience) need a crawler /
    //     // Lighthouse-style integration — no such model was supplied.
    //     // =================================================================
    //     $seoHealthScore = (int) round(collect([
    //         $onPageScore,
    //         $offPageScore,
    //         $technicalSeoScore,
    //     ])->avg());
 
    //     $performanceScore    = 0;
    //     $accessibilityScore  = 0;
    //     $bestPracticesScore  = 0;
    //     $securityScore       = 0;
    //     $indexabilityScore   = 0;
    //     $crawlabilityScore   = 0;
    //     $pageExperienceScore = 0;
 
    //     $healthMetrics = [
    //         ['name' => 'Performance Score', 'icon' => 'fa-bolt',             'value' => $performanceScore,    'status' => $this->statusFromScore($performanceScore),    'desc' => 'Core loading & rendering speed'],
    //         ['name' => 'Accessibility',     'icon' => 'fa-universal-access', 'value' => $accessibilityScore,  'status' => $this->statusFromScore($accessibilityScore),  'desc' => 'Usability for all visitors'],
    //         ['name' => 'SEO Score',         'icon' => 'fa-magnifying-glass', 'value' => $seoHealthScore,      'status' => $this->statusFromScore($seoHealthScore),      'desc' => 'Overall search readiness'],
    //         ['name' => 'Best Practices',    'icon' => 'fa-award',            'value' => $bestPracticesScore,  'status' => $this->statusFromScore($bestPracticesScore),  'desc' => 'Modern web standards followed'],
    //         ['name' => 'Security',          'icon' => 'fa-shield-halved',    'value' => $securityScore,       'status' => $this->statusFromScore($securityScore),       'desc' => 'Protection against vulnerabilities'],
    //         ['name' => 'Indexability',      'icon' => 'fa-list-check',       'value' => $indexabilityScore,   'status' => $this->statusFromScore($indexabilityScore),   'desc' => 'Pages eligible for indexing'],
    //         ['name' => 'Crawlability',      'icon' => 'fa-spider',           'value' => $crawlabilityScore,   'status' => $this->statusFromScore($crawlabilityScore),   'desc' => 'Ease of discovery by search bots'],
    //         ['name' => 'Page Experience',   'icon' => 'fa-mobile-screen',    'value' => $pageExperienceScore, 'status' => $this->statusFromScore($pageExperienceScore), 'desc' => 'Overall on-site user experience'],
    //     ];
 
    //     // =================================================================
    //     // SEO RECOMMENDATIONS — generated live from real backlink data.
    //     // Toxic links and pending assignments become real, dynamic
    //     // recommendation cards instead of static demo copy.
    //     // =================================================================
    //     $recommendations = $this->buildRecommendations($assignments, $toxicCount, $totalAssignments);
 
    //     return view('client.seo', [
    //         'client' => $client,
 
    //         // On-Page
    //         'onPageScore'            => $onPageScore,
    //         'titleTagsScore'         => $titleTagsScore,
    //         'metaDescriptionScore'   => $metaDescriptionScore,
    //         'headingStructureScore'  => $headingStructureScore,
    //         'imageAltTagsScore'      => $imageAltTagsScore,
    //         'internalLinkingScore'   => $internalLinkingScore,
    //         'keywordDensityScore'    => $keywordDensityScore,
    //         'urlStructureScore'      => $urlStructureScore,
    //         'canonicalUrlScore'      => $canonicalUrlScore,
 
    //         // Off-Page
    //         'offPageScore'            => $offPageScore,
    //         'backlinksCreatedScore'   => $backlinksCreatedScore,
    //         'highAuthorityLinksScore' => $highAuthorityLinksScore,
    //         'guestPostsScore'         => $guestPostsScore,
    //         'businessListingsScore'   => $businessListingsScore,
    //         'socialSignalsScore'      => $socialSignalsScore,
    //         'anchorDiversityScore'    => $anchorDiversityScore,
    //         'citationBuildingScore'   => $citationBuildingScore,
    //         'toxicLinksScore'         => $toxicLinksScore,
 
    //         // Technical
    //         'technicalSeoScore'   => $technicalSeoScore,
    //         'pageSpeedScore'      => $pageSpeedScore,
    //         'mobileFriendlyScore' => $mobileFriendlyScore,
    //         'coreWebVitalsScore'  => $coreWebVitalsScore,
    //         'structuredDataScore' => $structuredDataScore,
    //         'sitemapScore'        => $sitemapScore,
    //         'robotsTxtScore'      => $robotsTxtScore,
    //         'httpsScore'          => $httpsScore,
    //         'brokenLinksScore'    => $brokenLinksScore,
 
    //         // Health Matrix
    //         'healthMetrics' => $healthMetrics,
 
    //         // Recommendations
    //         'recommendations' => $recommendations,
    //     ]);
    // }
 
    /**
     * Safe percentage helper — avoids division by zero and rounds to an int.
     */
    private function percentage(int $count, int $total): int
    {
        if ($total <= 0) {
            return 0;
        }
 
        return (int) round(($count / $total) * 100);
    }
 
    /**
     * Completion percentage for backlink assignments whose category name
     * contains the given keyword (case-insensitive).
     */
    private function categoryCompletionScore(Collection $assignments, string $categoryKeyword): int
    {
        $matched = $assignments->filter(function ($assignment) use ($categoryKeyword) {
            $categoryName = optional(optional($assignment->backlink)->category)->name;
 
            return $categoryName && str_contains(strtolower($categoryName), $categoryKeyword);
        });
 
        $completed = $matched->where('status', 'completed')->count();
 
        return $this->percentage($completed, $matched->count());
    }
 
    /**
     * Map a numeric score to the badge status labels used by the view
     * (Excellent / Good / Average / Poor) and the checklist color rules.
     */
    private function statusFromScore(int $score): string
    {
        return match (true) {
            $score >= 85 => 'Excellent',
            $score >= 70 => 'Good',
            $score >= 50 => 'Average',
            default      => 'Poor',
        };
    }
 
    /**
     * Build live recommendation cards from real backlink assignment data.
     */
    private function buildRecommendations(Collection $assignments, int $toxicCount, int $totalAssignments): array
    {
        $recommendations = [];
 
        if ($toxicCount > 0) {
            $recommendations[] = [
                'icon'        => 'fa-link-slash',
                'priority'    => 'Critical',
                'status'      => 'Pending',
                'title'       => "Disavow {$toxicCount} toxic backlink" . ($toxicCount === 1 ? '' : 's'),
                'description' => "{$toxicCount} completed backlink(s) point from domains with authority below " . self::TOXIC_DA_THRESHOLD . ", which can drag down overall link profile quality.",
                'impact'      => 'High',
                'time'        => '1 day',
                'category'    => 'Backlinks',
            ];
        }
 
        $pending = $assignments->where('status', '!=', 'completed');
 
        if ($pending->isNotEmpty()) {
            $recommendations[] = [
                'icon'        => 'fa-clock',
                'priority'    => 'High',
                'status'      => 'Pending',
                'title'       => "Complete {$pending->count()} outstanding backlink assignment" . ($pending->count() === 1 ? '' : 's'),
                'description' => 'These assignments are still open and are holding back the Off-Page SEO score for this client.',
                'impact'      => 'Medium',
                'time'        => '2-3 days',
                'category'    => 'Backlinks',
            ];
        }
 
        $highAuthorityCompleted = $assignments->where('status', 'completed')
            ->filter(fn ($a) => optional($a->backlink)->domain_authority >= self::HIGH_AUTHORITY_DA_THRESHOLD)
            ->count();
 
        if ($totalAssignments > 0 && $this->percentage($highAuthorityCompleted, $totalAssignments) < 50) {
            $recommendations[] = [
                'icon'        => 'fa-scale-balanced',
                'priority'    => 'Medium',
                'status'      => 'Pending',
                'title'       => 'Prioritize higher authority backlink sources',
                'description' => 'Less than half of completed backlinks currently come from domains with DA ' . self::HIGH_AUTHORITY_DA_THRESHOLD . '+. Sourcing stronger domains will improve off-page authority faster.',
                'impact'      => 'High',
                'time'        => '1 week',
                'category'    => 'Backlinks',
            ];
        }
 
        // TODO: once On-Page / Technical audit models exist, generate their
        // own recommendation cards here the same way (e.g. missing ALT tags,
        // slow Core Web Vitals) instead of leaving those categories empty.
 
        return $recommendations;
    }

    public function clientreportdashboard(SeoPlanClient $planClient)
    {
        $project = $planClient->load([
            'company',
            'seoPlan',
            'keywords.rankings',
            'locations.rankings'
        ]);

       

        /*
        |--------------------------------------------------------------------------
        | Keyword Progress
        |--------------------------------------------------------------------------
        */

        $keywords = $planClient->keywords;

        /*
        |--------------------------------------------------------------------------
        | Backlink Progress
        |--------------------------------------------------------------------------
        */

        $backlinks = BacklinkAssignment::where(
                'seo_plan_client_id',
                $planClient->id
            )
            ->with('backlink.category')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | On Page SEO
        |--------------------------------------------------------------------------
        */

        $onPages = OnPageSeo::where(
                'seo_plan_client_id',
                $planClient->id
            )
            ->with([
                'category',
                'task'
            ])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards
        |--------------------------------------------------------------------------
        */

        $stats = [

            'keywords' => $keywords->count(),

            'areas' => $planClient
                ->locations
                ->where('type','area')
                ->count(),

            'states' => $planClient
                ->locations
                ->where('type','state')
                ->count(),

            'backlinks' => $backlinks->count(),

            'backlinks_completed' => $backlinks
                ->where('status','completed')
                ->count(),

            'onpage_total' => $onPages->count(),

            'onpage_completed' => $onPages
                ->where('status','completed')
                ->count(),
        ];

        return view('client.seo', compact('planClient', 'project', 'keywords', 'backlinks', 'onPages', 'stats'));
    }

 



}

