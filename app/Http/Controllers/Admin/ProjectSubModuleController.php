<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectModule;

use App\Models\Project;

use App\Models\ProjectSubModule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification;
use App\Models\User;


class ProjectSubModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

     private const DEVELOPER_SETTABLE_STATUSES = [
        'Pending',
        'Planning',
        'In Progress',
        'Testing',
        'Ready For Review',
        'On Hold',
        'Cancelled',
    ];

   
    public function index(ProjectModule $module): View
{
    $user = auth()->user();

    $module->load([
        'project',
        'subModules.assignedTo',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Admin can see all submodules
    |--------------------------------------------------------------------------
    */

    if ($user->hasRole('Admin')) {

        $submodules = ProjectSubModule::with('assignedTo')
            ->where('project_module_id', $module->id)
            ->ordered()
            ->paginate(10);

    } else {

        /*
        |--------------------------------------------------------------------------
        | Check whether this user has any task in this module
        |--------------------------------------------------------------------------
        */

        $hasPermission = $module->subModules()
            ->where('assigned_to', $user->id)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | No task assigned = Permission Denied
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $hasPermission,
            403,
            'You do not have permission to access the tasks of this module.'
        );

        /*
        |--------------------------------------------------------------------------
        | User can see only his own tasks
        |--------------------------------------------------------------------------
        */

        $submodules = ProjectSubModule::with('assignedTo')
            ->where('project_module_id', $module->id)
            ->where('assigned_to', $user->id)
            ->ordered()
            ->paginate(10);
    }

    return view('admin.projects.submodules.index', compact(
        'module',
        'submodules'
    ));
}

    // public function index(ProjectModule $module): View
    // {
    //     $module->load([
    //         'project',
    //         'subModules.assignedTo',
    //     ]);

    //     $submodules = ProjectSubModule::with('assignedTo')
    //         ->where('project_module_id', $module->id)
    //         ->ordered()
    //         ->paginate(10);

    //     return view('admin.projects.submodules.index', compact(
    //         'module',
    //         'submodules'
    //     ));
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    public function create(ProjectModule $module)
    {
        $user = auth()->user();

        // ==========================
        // Admin
        // ==========================
        if ($user->hasRole('Admin')) {

            // allowed

        } else {

            $isLeadDeveloper = $module->project->assigned_to == $user->id;

            $isAssignedDeveloper = $module->assigned_to == $user->id;

            abort_unless(
                $isLeadDeveloper || $isAssignedDeveloper,
                403,
                'You are not authorized to create sub modules.'
            );
        }

        return view('admin.projects.submodules.create', [
            'module'  => $module,
            'project' => $module->project,
        ]);
    }

    // public function create(ProjectModule $module): View
    // {
    //     abort_unless(auth()->user()->role == 'admin' || auth()->user()->role == 'lead_developer', 403);

    //     return view('admin.projects.submodules.create', [
    //         'module' => $module
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    public function store(Request $request, ProjectModule $module): RedirectResponse
    {
        // abort_unless(auth()->user()->role == 'admin' || auth()->user()->role == 'lead_developer', 403);

        $validated = $request->validate([

            'sub_module_name' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

            'priority' => ['required', 'in:Low,Medium,High,Critical'],

            'estimated_hours' => ['nullable', 'numeric', 'min:0'],

            'start_date' => ['nullable', 'date'],

            'deadline' => ['nullable', 'date', 'after_or_equal:start_date'],

        ]);

        $nextSortOrder = ProjectSubModule::where('project_module_id', $module->id)->max('sort_order');

        // return $nextSortOrder;

        ProjectSubModule::create([

            'project_module_id' => $module->id,

            'sub_module_name' => $validated['sub_module_name'],

            'description' => $validated['description'] ?? null,

            'priority' => $validated['priority'],

            'status' => 'Pending',

            'progress' => 0,

            'estimated_hours' => $validated['estimated_hours'] ?? 0,

            'actual_hours' => 0,

            'start_date' => $validated['start_date'] ?? null,

            'deadline' => $validated['deadline'] ?? null,

            'assigned_to' => $module->assigned_to,

            'sort_order' => ($nextSortOrder ?? 0) + 1,

            'is_active' => true,

            'created_by' => auth()->id(),

            'updated_by' => auth()->id(),

        ]);

        return redirect()
            ->route('admin.projects.show', $module->project->id)
            ->with('success', 'Sub Module created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    public function edit(ProjectModule $module, ProjectSubModule $submodule): View
    {
        abort_unless(
            auth()->user()->role == 'admin' ||
                auth()->user()->role == 'lead_developer',
            403
        );

        abort_if($submodule->project_module_id != $module->id, 404);

        return view('admin.projects.submodules.edit', [
            'module' => $module,
            'submodule' => $submodule
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    public function update(Request $request, ProjectModule $module, ProjectSubModule $submodule): RedirectResponse
    {
        abort_unless(
            auth()->user()->role == 'admin' ||
                auth()->user()->role == 'lead_developer',
            403
        );

        abort_if($submodule->project_module_id != $module->id, 404);

        $validated = $request->validate([

            'sub_module_name' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

            'priority' => ['required', 'in:Low,Medium,High,Critical'],

            'estimated_hours' => ['nullable', 'numeric', 'min:0'],

            'start_date' => ['nullable', 'date'],

            'deadline' => ['nullable', 'date', 'after_or_equal:start_date'],

        ]);

        $submodule->update([

            'sub_module_name' => $validated['sub_module_name'],

            'description' => $validated['description'] ?? null,

            'priority' => $validated['priority'],

            'estimated_hours' => $validated['estimated_hours'] ?? 0,

            'start_date' => $validated['start_date'] ?? null,

            'deadline' => $validated['deadline'] ?? null,

            'updated_by' => auth()->id(),

        ]);

        return redirect()
            ->route('modules.show', $module->id)
            ->with('success', 'Sub Module updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }

    public function destroy(ProjectModule $module, ProjectSubModule $submodule): RedirectResponse
    {
        abort_unless(
            auth()->user()->role == 'admin' ||
                auth()->user()->role == 'lead_developer',
            403
        );

        abort_if($submodule->project_module_id != $module->id, 404);

        $submodule->delete();

        return back()->with('success', 'Sub Module deleted successfully.');
    }

    public function status(ProjectSubModule $submodule)
    {
        abort_unless(
            $submodule->assigned_to == auth()->id(),
            403
        );

        return view(
            'admin.projects.submodules.status',
            compact('submodule')
        );
    }

    // public function updateStatus(Request $request, ProjectSubModule $submodule)
    // {
    //     abort_unless(
    //         $submodule->assigned_to == auth()->id(),
    //         403
    //     );

    //     $request->validate([
    //         'status' => 'required'
    //     ]);

    //     $allowed = [

    //         'Pending' => ['In Progress'],

    //         'In Progress' => ['Completed'],

    //         'Completed' => []

    //     ];

    //     if (! in_array(
    //         $request->status,
    //         $allowed[$submodule->status] ?? []
    //     )) {

    //         return back()->with(
    //             'error',
    //             'Invalid status change.'
    //         );
    //     }

    //     $submodule->update([

    //         'status' => $request->status,

    //         'updated_by' => auth()->id()

    //     ]);

    //     return redirect()
    //         ->route('modules.show', $submodule->project_module_id)
    //         ->with(
    //             'success',
    //             'Status updated successfully.'
    //         );
    // }


    // public function updateStatus(Request $request, ProjectSubModule $subModule)
    // {
    //     $request->validate([
    //         'status' => 'required|in:Pending,Planning,In Progress,Testing,Completed,On Hold,Cancelled,Ready For Review',
    //     ]);

    //     $subModule->status = $request->status;

    //     // Auto Progress
    //     switch ($request->status) {

    //         case 'Pending':
    //             $subModule->progress = 0;
    //             break;

    //         case 'Planning':
    //             $subModule->progress = 10;
    //             break;

    //         case 'In Progress':
    //             $subModule->progress = 50;
    //             break;

    //         case 'Testing':
    //             $subModule->progress = 90;
    //             break;

    //         case 'Completed':
    //             $subModule->progress = 100;
    //             break;
            
    //         case 'Ready For Review':
    //             $subModule->progress = 95;
    //             break;
                
    //         case 'Ready For Review':
    //             $subModule->progress = 100;
    //             break;    

    //         default:
    //             $subModule->progress = 0;
    //     }

    //     $subModule->save();

    //     // ===============================
    //     // Update Parent Module Progress
    //     // ===============================

    //     $module = $subModule->module;

    //     $moduleProgress = (int) round(
    //         $module->subModules()->avg('progress')
    //     );

    //     $module->progress = $moduleProgress;

    //     if ($moduleProgress == 100) {
    //         $module->status = 'Completed';
    //     } elseif ($moduleProgress > 0) {
    //         $module->status = 'In Progress';
    //     }

    //     $module->save();

    //     // ===============================
    //     // Update Project Progress
    //     // ===============================

    //     $project = $module->project;

    //     $projectProgress = (int) round(
    //         $project->modules()->avg('progress')
    //     );

    //     $project->progress = $projectProgress;

    //     $project->save();

    //     return response()->json([
    //         'success' => true,

    //         'submodule_progress' => $subModule->progress,

    //         'module_progress' => $module->progress,
    //         'module_status' => $module->status,

    //         'project_progress' => $project->progress,
    //     ]);

    //     // return back()->with('success','Sub Module Updated Successfully');
    // }

    //  public function updateStatus(Request $request, ProjectSubModule $subModule)
    // {
    //     $request->validate([
    //         'status' => 'required|in:Pending,Planning,In Progress,Testing,Completed,On Hold,Cancelled,Ready For Review',
    //     ]);

    //     $subModule->status = $request->status;

    //     $user = Auth::user();

    //     // Old status save kar lo notification ke liye
    //     $oldStatus = $subModule->status;
    //     $newStatus = $request->status;


    //     // Auto Progress
    //     switch ($request->status) {

    //         case 'Pending':
    //             $subModule->progress = 0;
    //             break;

    //         case 'Planning':
    //             $subModule->progress = 10;
    //             break;

    //         case 'In Progress':
    //             $subModule->progress = 50;
    //             break;

    //         case 'Testing':
    //             $subModule->progress = 90;
    //             break;

    //         case 'Completed':
    //             $subModule->progress = 100;
    //             break;
            
    //         case 'Ready For Review':
    //             $subModule->progress = 95;
    //             break;
                
    //         case 'Ready For Review':
    //             $subModule->progress = 100;
    //             break;    

    //         default:
    //             $subModule->progress = 0;
    //     }

    //     $subModule->save();

    //     // ===============================
    //     // Update Parent Module Progress
    //     // ===============================

    //     $module = $subModule->module;

    //     $moduleProgress = (int) round(
    //         $module->subModules()->avg('progress')
    //     );

    //     $module->progress = $moduleProgress;

    //     if ($moduleProgress == 100) {
    //         $module->status = 'Completed';
    //     } elseif ($moduleProgress > 0) {
    //         $module->status = 'In Progress';
    //     }

    //     $module->save();

    //     // ===============================
    //     // Update Project Progress
    //     // ===============================

    //     $project = $module->project;

    //     $projectProgress = (int) round(
    //         $project->modules()->avg('progress')
    //     );

    //     $project->progress = $projectProgress;

    //     $project->save();


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Send Notification
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($oldStatus !== $newStatus) {
    //         $this->sendSubModuleStatusNotification(
    //             $subModule,
    //             $module,
    //             $project,
    //             $oldStatus,
    //             $newStatus,
    //             $user
    //         );
    //     }

    //     return response()->json([
    //         'success' => true,

    //         'submodule_progress' => $subModule->progress,

    //         'module_progress' => $module->progress,
    //         'module_status' => $module->status,

    //         'project_progress' => $project->progress,
    //     ]);

    //     // return back()->with('success','Sub Module Updated Successfully');
    // }

    public function updateStatus(Request $request, ProjectSubModule $subModule)
{
    $request->validate([
        'status' => 'required|in:Pending,Planning,In Progress,Testing,Completed,On Hold,Cancelled,Ready For Review',
    ]);

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Old / New Status
    |--------------------------------------------------------------------------
    */

    $oldStatus = $subModule->status;
    $newStatus = $request->status;

    /*
    |--------------------------------------------------------------------------
    | Update Sub Module Status
    |--------------------------------------------------------------------------
    */

    $subModule->status = $newStatus;

    // Auto Progress
    switch ($newStatus) {

        case 'Pending':
            $subModule->progress = 0;
            break;

        case 'Planning':
            $subModule->progress = 10;
            break;

        case 'In Progress':
            $subModule->progress = 50;
            break;

        case 'Testing':
            $subModule->progress = 90;
            break;

        case 'Ready For Review':
            $subModule->progress = 95;
            break;

        case 'Completed':
            $subModule->progress = 100;
            break;

        default:
            $subModule->progress = 0;
    }

    $subModule->save();

    /*
    |--------------------------------------------------------------------------
    | Update Parent Module Progress
    |--------------------------------------------------------------------------
    */

    $module = $subModule->module;

    $moduleProgress = (int) round(
        $module->subModules()->avg('progress')
    );

    $module->progress = $moduleProgress;

    if ($moduleProgress == 100) {
        $module->status = 'Completed';
    } elseif ($moduleProgress > 0) {
        $module->status = 'In Progress';
    }

    $module->save();

    /*
    |--------------------------------------------------------------------------
    | Update Project Progress
    |--------------------------------------------------------------------------
    */

    $project = $module->project;

    $projectProgress = (int) round(
        $project->modules()->avg('progress')
    );

    $project->progress = $projectProgress;

    $project->save();

    /*
    |--------------------------------------------------------------------------
    | Send Notification
    |--------------------------------------------------------------------------
    */

    if ($oldStatus !== $newStatus) {

        $this->sendSubModuleStatusNotification(
            $subModule,
            $module,
            $project,
            $oldStatus,
            $newStatus,
            $user
        );
    }

    return response()->json([
        'success' => true,

        'submodule_progress' => $subModule->progress,

        'module_progress' => $module->progress,
        'module_status' => $module->status,

        'project_progress' => $project->progress,
    ]);
}

    private function sendSubModuleStatusNotification(
    ProjectSubModule $subModule,
    $module,
    $project,
    ?string $oldStatus,
    string $newStatus,
    User $changedBy
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Notification Message
        |--------------------------------------------------------------------------
        */

        $subModuleName = $subModule->sub_module_name
            ?? $subModule->sub_module_name
            ?? 'Task1';

        $message = 'Task "' . $subModuleName . '" status changed from "'
            . ($oldStatus ?? 'N/A')
            . '" to "'
            . $newStatus
            . '" by '
            . $changedBy->name
            . '.';

        /*
        |--------------------------------------------------------------------------
        | Common Notification Data
        |--------------------------------------------------------------------------
        */

        $extra = [
            'project_id'       => $project->id,
            'project_name'     => $project->project_name,

            'module_id'        => $module->id,
            'module_name'      => $module->module_name,

            'submodule_id'     => $subModule->id,
            'submodule_name'   => $subModuleName,

            'old_status'       => $oldStatus,
            'new_status'       => $newStatus,

            'changed_by'       => $changedBy->id,
            'changed_by_name'  => $changedBy->name,

            'message_type'     => 'submodule_status_changed',
        ];

        /*
        |--------------------------------------------------------------------------
        | Check Who Changed The Task
        |--------------------------------------------------------------------------
        */

        $isLeadDeveloper = $project->assigned_to == $changedBy->id;

        /*
        |--------------------------------------------------------------------------
        | 1. Lead Developer Changed Task
        |    => ONLY ADMIN
        |--------------------------------------------------------------------------
        */

        if ($isLeadDeveloper) {

            $admins = User::role('Admin')->get();

            foreach ($admins as $admin) {

                // Don't notify yourself
                if ($admin->id == $changedBy->id) {
                    continue;
                }

                $admin->notify(
                    new SystemNotification(
                        'Task Status Updated',
                        $message,
                        'submodule_status_changed',
                        route('admin.submodules.all'),
                        $extra,
                        'notification.mp3'
                    )
                );
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Developer Changed Task
        |    => ADMIN + LEAD DEVELOPER
        |--------------------------------------------------------------------------
        */

        // Admins
        $admins = User::role('Admin')->get();

        foreach ($admins as $admin) {

            // Don't notify yourself
            if ($admin->id == $changedBy->id) {
                continue;
            }

            $admin->notify(
                new SystemNotification(
                    'Task Status Updated',
                    $message,
                    'submodule_status_changed',
                    route('admin.submodules.all'),
                    $extra,
                    'notification.mp3'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Lead Developer
        |--------------------------------------------------------------------------
        */

        $leadDeveloper = User::find($project->assigned_to);

        if (
            $leadDeveloper &&
            $leadDeveloper->id != $changedBy->id
        ) {

            $leadDeveloper->notify(
                new SystemNotification(
                    'Task Status Updated',
                    $message,
                    'submodule_status_changed',
                    route('admin.submodules.all'),
                    $extra,
                    'notification.mp3'
                )
            );
        }
    }

    // public function allSubmodules(Request $request): View
    // {
    //     $user = auth()->user();
    //     $isAdmin = $user->hasRole('Admin');

    //     $leadProjectIds = Project::where('assigned_to', $user->id)->pluck('id');
    //     $isLeadOfAny = $leadProjectIds->isNotEmpty();

    //     $baseQuery = ProjectSubModule::query()
    //         ->when(! $isAdmin, function ($q) use ($user, $leadProjectIds, $isLeadOfAny) {
    //             $q->where(function ($sub) use ($user, $leadProjectIds, $isLeadOfAny) {
    //                 // Their own assigned submodules...
    //                 $sub->where('assigned_to', $user->id);

    //                 // ...OR anything under a project they lead (so a Lead
    //                 // Developer sees their whole team's submodules, not
    //                 // just the ones assigned to themself).
    //                 if ($isLeadOfAny) {
    //                     $sub->orWhereHas('module', function ($moduleQuery) use ($leadProjectIds) {
    //                         $moduleQuery->whereIn('project_id', $leadProjectIds);
    //                     });
    //                 }
    //             });
    //         });

    //     /*
    //     |--------------------------------------------------------------------
    //     | Filter dropdown options — scoped to what this user can actually
    //     | see, same pattern as assingmodule() above.
    //     |--------------------------------------------------------------------
    //     */
    //     $projectOptions = Project::query()
    //         ->whereIn('id', (clone $baseQuery)->join('project_modules', 'project_modules.id', '=', 'project_sub_modules.project_module_id')
    //             ->distinct()
    //             ->pluck('project_modules.project_id'))
    //         ->orderBy('project_name')
    //         ->get();

    //     $moduleOptions = ProjectModule::query()
    //         ->whereIn('id', (clone $baseQuery)->distinct()->pluck('project_module_id'))
    //         ->orderBy('module_name')
    //         ->get();

    //     /*
    //     |--------------------------------------------------------------------
    //     | Main query
    //     |--------------------------------------------------------------------
    //     */
    //     $query = (clone $baseQuery)->with([
    //         'assignedTo',
    //         'module.project',
    //         'reviews' => fn ($q) => $q->latest('review_round')->limit(1),
    //     ]);

    //     $query->when($request->filled('search'), function ($q) use ($request) {
    //         $search = trim($request->input('search'));
    //         $q->where(function ($sub) use ($search) {
    //             $sub->where('sub_module_name', 'like', "%{$search}%")
    //                 ->orWhereHas('module', function ($moduleQuery) use ($search) {
    //                     $moduleQuery->where('module_name', 'like', "%{$search}%");
    //                 })
    //                 ->orWhereHas('module.project', function ($projectQuery) use ($search) {
    //                     $projectQuery->where('project_name', 'like', "%{$search}%");
    //                 });
    //         });
    //     });

    //     $query->when($request->filled('status'), function ($q) use ($request) {
    //         $q->where('status', $request->input('status'));
    //     });

    //     $query->when($request->filled('priority'), function ($q) use ($request) {
    //         $q->where('priority', $request->input('priority'));
    //     });

    //     $query->when($request->filled('project_id'), function ($q) use ($request) {
    //         $projectId = $request->input('project_id');
    //         $q->whereHas('module', fn ($moduleQuery) => $moduleQuery->where('project_id', $projectId));
    //     });

    //     $query->when($request->filled('module_id'), function ($q) use ($request) {
    //         $q->where('project_module_id', $request->input('module_id'));
    //     });

    //     match ($request->input('sort_by', 'latest')) {
    //         'deadline' => $query->orderByRaw('deadline IS NULL, deadline ASC'),
    //         'priority' => $query->orderByRaw("FIELD(priority, 'Critical', 'High', 'Medium', 'Low')"),
    //         'progress' => $query->orderBy('progress', 'desc'),
    //         default => $query->orderBy('created_at', 'desc'),
    //     };

    //     $submodules = $query->paginate(15)->withQueryString();

    //     /*
    //     |--------------------------------------------------------------------
    //     | Summary stats — reflect the full scoped set, not just this page.
    //     |--------------------------------------------------------------------
    //     */
    //     $totalCount = (clone $baseQuery)->count();
    //     $waitingReviewCount = (clone $baseQuery)->where('status', 'Ready For Review')->count();
    //     $changesRequestedCount = (clone $baseQuery)->where('status', 'Changes Requested')->count();
    //     $approvedCount = (clone $baseQuery)->where('status', 'Approved')->count();
    //     $inProgressCount = (clone $baseQuery)->where('status', 'In Progress')->count();

    //     return view('admin.projects.submodules.all', [
    //         'submodules' => $submodules,
    //         'projectOptions' => $projectOptions,
    //         'moduleOptions' => $moduleOptions,
    //         'totalCount' => $totalCount,
    //         'waitingReviewCount' => $waitingReviewCount,
    //         'changesRequestedCount' => $changesRequestedCount,
    //         'approvedCount' => $approvedCount,
    //         'inProgressCount' => $inProgressCount,
    //     ]);
    // }

    // public function allSubmodules(Request $request): View
    // {
    //     $user = auth()->user();
    //     $isAdmin = $user->hasRole('Admin');
 
    //     $leadProjectIds = Project::where('assigned_to', $user->id)->pluck('id');
    //     $isLeadOfAny = $leadProjectIds->isNotEmpty();
 
    //     $baseQuery = ProjectSubModule::query()
    //         ->when(! $isAdmin, function ($q) use ($user, $leadProjectIds, $isLeadOfAny) {
    //             $q->where(function ($sub) use ($user, $leadProjectIds, $isLeadOfAny) {
    //                 // Their own assigned submodules... (table-qualified —
    //                 // project_modules also has an `assigned_to` column, and
    //                 // this query gets joined against project_modules below
    //                 // for the project filter options, which made the bare
    //                 // column name ambiguous and threw a 1052 SQL error).
    //                 $sub->where('project_sub_modules.assigned_to', $user->id);
 
    //                 // ...OR anything under a project they lead (so a Lead
    //                 // Developer sees their whole team's submodules, not
    //                 // just the ones assigned to themself).
    //                 if ($isLeadOfAny) {
    //                     $sub->orWhereHas('module', function ($moduleQuery) use ($leadProjectIds) {
    //                         $moduleQuery->whereIn('project_id', $leadProjectIds);
    //                     });
    //                 }
    //             });
    //         });
 
    //     /*
    //     |--------------------------------------------------------------------
    //     | Filter dropdown options — scoped to what this user can actually
    //     | see, same pattern as assingmodule() above.
    //     |--------------------------------------------------------------------
    //     */
    //     $projectOptions = Project::query()
    //         ->whereIn('id', (clone $baseQuery)->join('project_modules', 'project_modules.id', '=', 'project_sub_modules.project_module_id')
    //             ->distinct()
    //             ->pluck('project_modules.project_id'))
    //         ->orderBy('project_name')
    //         ->get();
 
    //     $moduleOptions = ProjectModule::query()
    //         ->whereIn('id', (clone $baseQuery)->distinct()->pluck('project_module_id'))
    //         ->orderBy('module_name')
    //         ->get();
 
    //     /*
    //     |--------------------------------------------------------------------
    //     | Main query
    //     |--------------------------------------------------------------------
    //     */
    //     $query = (clone $baseQuery)->with([
    //         'assignedTo',
    //         'module.project',
    //         'reviews' => fn ($q) => $q->latest('review_round')->limit(1),
    //     ]);
 
    //     $query->when($request->filled('search'), function ($q) use ($request) {
    //         $search = trim($request->input('search'));
    //         $q->where(function ($sub) use ($search) {
    //             $sub->where('sub_module_name', 'like', "%{$search}%")
    //                 ->orWhereHas('module', function ($moduleQuery) use ($search) {
    //                     $moduleQuery->where('module_name', 'like', "%{$search}%");
    //                 })
    //                 ->orWhereHas('module.project', function ($projectQuery) use ($search) {
    //                     $projectQuery->where('project_name', 'like', "%{$search}%");
    //                 });
    //         });
    //     });
 
    //     $query->when($request->filled('status'), function ($q) use ($request) {
    //         $q->where('status', $request->input('status'));
    //     });
 
    //     $query->when($request->filled('priority'), function ($q) use ($request) {
    //         $q->where('priority', $request->input('priority'));
    //     });
 
    //     $query->when($request->filled('project_id'), function ($q) use ($request) {
    //         $projectId = $request->input('project_id');
    //         $q->whereHas('module', fn ($moduleQuery) => $moduleQuery->where('project_id', $projectId));
    //     });
 
    //     $query->when($request->filled('module_id'), function ($q) use ($request) {
    //         $q->where('project_module_id', $request->input('module_id'));
    //     });
 
    //     match ($request->input('sort_by', 'latest')) {
    //         'deadline' => $query->orderByRaw('deadline IS NULL, deadline ASC'),
    //         'priority' => $query->orderByRaw("FIELD(priority, 'Critical', 'High', 'Medium', 'Low')"),
    //         'progress' => $query->orderBy('progress', 'desc'),
    //         default => $query->orderBy('created_at', 'desc'),
    //     };
 
    //     // $submodules = $query->paginate(15)->withQueryString();

    //     $submodules = $query->latest()->paginate(15); // <-- must be named exactly this

 
    //     /*
    //     |--------------------------------------------------------------------
    //     | Summary stats — reflect the full scoped set, not just this page.
    //     |--------------------------------------------------------------------
    //     */
    //     $totalCount = (clone $baseQuery)->count();
    //     $waitingReviewCount = (clone $baseQuery)->where('status', 'Ready For Review')->count();
    //     $changesRequestedCount = (clone $baseQuery)->where('status', 'Changes Requested')->count();
    //     $approvedCount = (clone $baseQuery)->where('status', 'Approved')->count();
    //     $inProgressCount = (clone $baseQuery)->where('status', 'In Progress')->count();
 
    //     return view('admin.projects.submodules.all', [
    //         'submodules' => $submodules,
    //         'projectOptions' => $projectOptions,
    //         'moduleOptions' => $moduleOptions,
    //         'totalCount' => $totalCount,
    //         'waitingReviewCount' => $waitingReviewCount,
    //         'changesRequestedCount' => $changesRequestedCount,
    //         'approvedCount' => $approvedCount,
    //         'inProgressCount' => $inProgressCount,
    //     ]);
    // }

    public function allSubmodules(Request $request): View
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('Admin');

        $leadProjectIds = Project::where('assigned_to', $user->id)->pluck('id');
        $isLeadOfAny = $leadProjectIds->isNotEmpty();

        $baseQuery = ProjectSubModule::query()
            ->when(! $isAdmin, function ($q) use ($user, $leadProjectIds, $isLeadOfAny) {
                $q->where(function ($sub) use ($user, $leadProjectIds, $isLeadOfAny) {
                    $sub->where('project_sub_modules.assigned_to', $user->id);

                    if ($isLeadOfAny) {
                        $sub->orWhereHas('module', function ($moduleQuery) use ($leadProjectIds) {
                            $moduleQuery->whereIn('project_id', $leadProjectIds);
                        });
                    }
                });
            });

        $projectOptions = Project::query()
            ->whereIn('id', (clone $baseQuery)->join('project_modules', 'project_modules.id', '=', 'project_sub_modules.project_module_id')
                ->distinct()
                ->pluck('project_modules.project_id'))
            ->orderBy('project_name')
            ->get();

        $moduleOptions = ProjectModule::query()
            ->whereIn('id', (clone $baseQuery)->distinct()->pluck('project_module_id'))
            ->orderBy('module_name')
            ->get();

        $query = (clone $baseQuery)->with([
            'assignedTo',
            'module.project',
            'reviews' => fn ($q) => $q->latest('review_round')->limit(1),
        ]);

        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = trim($request->input('search'));
            $q->where(function ($sub) use ($search) {
                $sub->where('sub_module_name', 'like', "%{$search}%")
                    ->orWhereHas('module', function ($moduleQuery) use ($search) {
                        $moduleQuery->where('module_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('module.project', function ($projectQuery) use ($search) {
                        $projectQuery->where('project_name', 'like', "%{$search}%");
                    });
            });
        });

        $query->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')));
        $query->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->input('priority')));

        $query->when($request->filled('project_id'), function ($q) use ($request) {
            $projectId = $request->input('project_id');
            $q->whereHas('module', fn ($moduleQuery) => $moduleQuery->where('project_id', $projectId));
        });

        $query->when($request->filled('module_id'), fn ($q) => $q->where('project_module_id', $request->input('module_id')));

        match ($request->input('sort_by', 'latest')) {
            'deadline' => $query->orderByRaw('deadline IS NULL, deadline ASC'),
            'priority' => $query->orderByRaw("FIELD(priority, 'Critical', 'High', 'Medium', 'Low')"),
            'progress' => $query->orderBy('progress', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $submodules = $query->paginate(15)->withQueryString(); // <-- must be named exactly this

        $totalCount = (clone $baseQuery)->count();
        $waitingReviewCount = (clone $baseQuery)->where('status', 'Ready For Review')->count();
        $changesRequestedCount = (clone $baseQuery)->where('status', 'Changes Requested')->count();
        $approvedCount = (clone $baseQuery)->where('status', 'Approved')->count();
        $inProgressCount = (clone $baseQuery)->where('status', 'In Progress')->count();

        return view('admin.projects.submodules.all', [
            'submodules' => $submodules,
            'projectOptions' => $projectOptions,
            'moduleOptions' => $moduleOptions,
            'totalCount' => $totalCount,
            'waitingReviewCount' => $waitingReviewCount,
            'changesRequestedCount' => $changesRequestedCount,
            'approvedCount' => $approvedCount,
            'inProgressCount' => $inProgressCount,
        ]);
    }
}
