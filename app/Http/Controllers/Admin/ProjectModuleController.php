<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectModuleRequest;
use App\Models\Project;
use App\Models\ProjectModule;
use App\Models\ProjectModuleAssignment;
use App\Models\ProjectSubModule;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Throwable;

use Illuminate\Support\Carbon;


use Illuminate\Http\Request;

use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Auth;


class ProjectModuleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:module-list')->only('index');

    //     $this->middleware('permission:module-create')->only([
    //         'create',
    //         'store'
    //     ]);

    //     $this->middleware('permission:module-edit')->only([
    //         'edit',
    //         'update'
    //     ]);

    //     $this->middleware('permission:module-delete')->only([
    //         'destroy'
    //     ]);

    //     $this->middleware('permission:module-show')->only([
    //         'show'
    //     ]);
    // }
    

    public function create(Project $project)
    {
        $users = User::query()->orderBy('name')->get();

        // return $project;
        $departments = Department::orderBy('title')->get();


        // Admin ko sab allowed
        if (auth()->user()->hasRole('Admin')) {
            return view('admin.projects.modules.create', compact('project', 'users', 'departments'));
        }

        // Lead Developer sirf apne project me
        if (auth()->user()->hasRole('Developer')) {

            abort_unless(
                $project->assigned_to == auth()->id(),
                403,
                'You are not allowed to create modules for this project.'
            );

            return view('admin.projects.modules.create', compact('project', 'users', 'departments'));
        }

        // Developer ko mana
        abort(403, 'Only Lead Developer can create modules.');
    }

    /**
     * Persist modules and their sub-modules for a project.
     *
     * Wrapped in a single DB transaction: if anything fails
     * (module save, sub-module save, or file upload), everything
     * is rolled back and no partial data is written.
     */
    public function store(StoreProjectModuleRequest $request): RedirectResponse
    {
        $validated = $request->validated();


        try {
            DB::beginTransaction();

            $project = Project::findOrFail($validated['project_id']);

            foreach ($validated['modules'] as $moduleIndex => $moduleData) {
                $module = $this->storeModule($project, $moduleData, $moduleIndex, $request, $moduleIndex);

                if (!empty($moduleData['sub_modules'])) {
                    foreach ($moduleData['sub_modules'] as $subIndex => $subModuleData) {
                        $this->storeSubModule($module, $subModuleData, $subIndex);
                    }
                }

                // Notify assigned developer
                $this->sendModuleAssignedNotification($module, $project);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Project module store failed: ' . $e->getMessage(), [
                'project_id' => $validated['project_id'] ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the modules. No changes were saved. Please try again.');
        }

        return redirect()
            ->route('admin.projects.show', $project->id)
            ->with('success', 'Modules and sub modules were saved successfully.');
    }

    // notification

    private function sendModuleAssignedNotification($module, Project $project): void
    {
        // Module me assigned developer ki ID `assigned_to` me hai
        $developer = User::find($module->assigned_to);

        if (!$developer) {
            return;
        }

        // Khud ko notification nahi bhejna
        if ($developer->id == Auth::id()) {
            return;
        }

        $assignedBy = Auth::user();

        // Agar khud ko hi assign kiya hai to notification nahi
        if ($developer->id == $assignedBy->id) {
            return;
        }

        $developer->notify(
            new SystemNotification(
                'New Module Assigned',
                'A new module "' . $module->module_name . '" has been assigned to you by ' . $assignedBy->name . '.',
                'module_assigned',
                route('developer.all.modules.index'),
                [
                    'project_id'   => $project->id,
                    'project_name' => $project->project_name,
                    'module_id'    => $module->id,
                    'module_name'  => $module->module_name,
                    'sender_id'    => Auth::id(),
                    'sender_name'  => Auth::user()->name,
                    'message_type' => 'module_assigned',
                ],
                'notification.mp3'
            )
        );
    }

    // private function sendModuleAssignedNotification($module, Project $project): void
    // {
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Get Assigned Developer
    //     |--------------------------------------------------------------------------
    //     */

        

    //     $developer = User::find($module->assign_to);

    //     dd($developer);

    //     if (!$developer) {
    //         return;
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Don't notify yourself
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($developer->id == Auth::id()) {
    //         return;
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Send Notification
    //     |--------------------------------------------------------------------------
    //     */

    //     $developer->notify(
    //         new SystemNotification(
    //             'New Module Assigned',
    //             'A new module "' . $module->name . '" has been assigned to you.',
    //             'module_assigned',
    //             route('admin.projects.show', $project->id),
    //             [
    //                 'project_id'   => $project->id,
    //                 'project_name' => $project->project_name,
    //                 'module_id'    => $module->id,
    //                 'module_name'  => $module->name,
    //                 'sender_id'    => Auth::id(),
    //                 'sender_name'  => Auth::user()->name,
    //                 'message_type' => 'module_assigned',
    //             ],
    //             'notification.mp3'
    //         )
    //     );
    // }

    /**
     * Create a single ProjectModule record and attach any uploaded files.
     */
    private function storeModule(Project $project, array $data, int $index, StoreProjectModuleRequest $request, int $moduleIndex): ProjectModule
    {
        $module = new ProjectModule();
        $module->project_id = $project->id;
        $module->module_name = $data['module_name'];
        $module->module_type = $data['module_type'] ?? null;
        $module->description = $data['description'] ?? null;
        $module->department_id = $data['department_id'] ?? null;
        $module->assigned_to = $data['assigned_to'] ?? null;
        $module->priority = $data['priority'];
        $module->status = $data['status'];
        $module->progress = $data['progress'] ?? 0;
        $module->estimated_hours = $data['estimated_hours'] ?? 0;
        $module->actual_hours = $data['actual_hours'] ?? 0;
        $module->start_date = $data['start_date'] ?? null;
        $module->deadline = $data['deadline'] ?? null;
        $module->color = $data['color'] ?? null;
        $module->tags = $data['tags'] ?? [];
        $module->sort_order = $index;
        $module->is_active = array_key_exists('is_active', $data) ? (bool) $data['is_active'] : true;
        $module->created_by = auth()->id();
        $module->updated_by = auth()->id();
        $module->save();

        // Every module save creates an assignment history record for whoever
        // it's assigned to — this is what store() was updated for.
        if ($module->assigned_to) {
            $this->storeModuleAssignment($module);
        }

        // Handle attachments for this specific module, if any were uploaded.
        $uploadedFiles = $request->file("modules.$moduleIndex.attachments");

        if (!empty($uploadedFiles)) {
            $this->storeModuleAttachments($module, $uploadedFiles);
        }

        return $module;
    }

    /**
     * Record the assignment of a module to a developer.
     *
     * - Self-assignment (the lead developer assigns the module to themselves):
     *   the assignment is automatically "accepted" since no approval step is needed.
     * - Assignment to someone else: the assignment starts as "pending" until
     *   that developer accepts or rejects it (handled elsewhere, not in this method).
     */
    private function storeModuleAssignment(ProjectModule $module): ProjectModuleAssignment
    {
        $assignedBy = auth()->id();
        $assignedTo = $module->assigned_to;
        $isSelfAssigned = $assignedBy === $assignedTo;

        $assignment = new ProjectModuleAssignment();
        $assignment->project_module_id = $module->id;
        $assignment->assigned_by = $assignedBy;
        $assignment->assigned_to = $assignedTo;
        $assignment->status = $isSelfAssigned ? 'accepted' : 'pending';
        $assignment->assigned_at = now();
        $assignment->accepted_at = $isSelfAssigned ? now() : null;
        $assignment->save();

        return $assignment;
    }

    /**
     * Store uploaded attachment files for a module.
     * Assumes a `project_module_attachments` table/model exists;
     * adjust the model/fields to match your actual attachments schema.
     */
    private function storeModuleAttachments(ProjectModule $module, array $files): void
    {
        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $path = $file->store("project-modules/{$module->id}/attachments", 'public');

            // If you have a dedicated attachments model, persist it here, e.g.:
            // $module->attachments()->create([
            //     'file_name'      => $file->getClientOriginalName(),
            //     'file_path'      => $path,
            //     'file_size'      => $file->getSize(),
            //     'mime_type'      => $file->getClientMimeType(),
            //     'created_by'     => auth()->id(),
            // ]);
        }
    }

    /**
     * Create a single ProjectSubModule record tied to its parent module.
     */

    // private function storeSubModule(ProjectModule $module, array $data, int $index): ProjectSubModule
    // {
    //     $subModule = new ProjectSubModule();
    //     $subModule->project_module_id = $module->id;
    //     $subModule->sub_module_name = $data['sub_module_name'];
    //     $subModule->description = $data['description'] ?? null;
    //     $subModule->assigned_to = $data['assigned_to'] ?? null;
    //     $subModule->priority = $data['priority'];
    //     $subModule->status = $data['status'];
    //     $subModule->progress = $data['progress'] ?? 0;
    //     $subModule->estimated_hours = $data['estimated_hours'] ?? 0;
    //     $subModule->actual_hours = $data['actual_hours'] ?? 0;
    //     $subModule->start_date = $data['start_date'] ?? null;
    //     $subModule->deadline = $data['deadline'] ?? null;
    //     $subModule->sort_order = $index;
    //     $subModule->is_active = array_key_exists('is_active', $data) ? (bool) $data['is_active'] : true;
    //     $subModule->created_by = auth()->id();
    //     $subModule->updated_by = auth()->id();
    //     $subModule->save();

    //     return $subModule;
    // }

    private function storeSubModule(ProjectModule $module, array $data, int $index): ProjectSubModule
    {
        $project = $module->project;

        /*
        |--------------------------------------------------------------------------
        | Submodule Assignment
        |--------------------------------------------------------------------------
        |
        | Agar module project ke Lead Developer ko assigned hai,
        | to submodule bhi automatically usi Lead Developer ko assign hoga.
        |
        | Agar module kisi normal Developer ko assigned hai,
        | to submodule assigned_to NULL rahega.
        |
        */

        $assignedTo = null;

        if (
            !empty($project->assigned_to) &&
            $module->assigned_to == $project->assigned_to
        ) {
            $assignedTo = $project->assigned_to;
        }

        $subModule = new ProjectSubModule();

        $subModule->project_module_id = $module->id;
        $subModule->sub_module_name = $data['sub_module_name'];
        $subModule->description = $data['description'] ?? null;

        // Lead Developer case mein automatic assignment
        $subModule->assigned_to = $assignedTo;

        $subModule->priority = $data['priority'];
        $subModule->status = $data['status'];
        $subModule->progress = $data['progress'] ?? 0;
        $subModule->estimated_hours = $data['estimated_hours'] ?? 0;
        $subModule->actual_hours = $data['actual_hours'] ?? 0;
        $subModule->start_date = $data['start_date'] ?? null;
        $subModule->deadline = $data['deadline'] ?? null;
        $subModule->sort_order = $index;
        $subModule->is_active = array_key_exists('is_active', $data)
            ? (bool) $data['is_active']
            : true;
        $subModule->created_by = auth()->id();
        $subModule->updated_by = auth()->id();

        $subModule->save();

        return $subModule;
    }


    public function assingmodule(Request $request): View
    {
        $developerId = auth()->id();
 
        // $baseQuery = ProjectModule::query()->where('assigned_to', $developerId);

        $baseQuery = ProjectModule::query()
            ->whereHas('assignments', function ($q) use ($developerId) {
                $q->where('assigned_to', $developerId)
                ->where('status', 'Accepted');
            });
 
        /*
        |--------------------------------------------------------------------
        | Filter dropdown options — scoped to this developer's own modules
        | only, so the dropdowns never offer choices that return nothing.
        |--------------------------------------------------------------------
        */
        $departmentOptions = Department::query()
            ->whereIn('id', (clone $baseQuery)->whereNotNull('department_id')->distinct()->pluck('department_id'))
            ->orderBy('title')
            ->get();
 
        $projectOptions = Project::query()
            ->whereIn('id', (clone $baseQuery)->distinct()->pluck('project_id'))
            ->orderBy('project_name')
            ->get();
 
        $statusOptions = (clone $baseQuery)->distinct()->pluck('status')->filter()->values();
 
        /*
        |--------------------------------------------------------------------
        | Main query: eager load project, department, and this developer's
        | own assignment history (latest first) — no N+1 queries.
        |--------------------------------------------------------------------
        */
        // $query = ProjectModule::query()
        //     ->where('assigned_to', $developerId)
        //     ->with([
        //         'project',
        //         'department',
        //         'assignments' => function ($assignmentQuery) use ($developerId) {
        //             $assignmentQuery->where('assigned_to', $developerId)->latest('assigned_at');
        //         },
        //     ]);

        $query = ProjectModule::query()
            ->whereHas('assignments', function ($q) use ($developerId) {
                $q->where('assigned_to', $developerId)
                ->where('status', 'Accepted');
            })
            ->with([
                'project',
                'department',
                'assignments' => function ($assignmentQuery) use ($developerId) {
                    $assignmentQuery->where('assigned_to', $developerId)
                                    ->latest('assigned_at');
                },
            ]);
 
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = trim($request->input('search'));
            $q->where(function ($sub) use ($search) {
                $sub->where('module_name', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($projectQuery) use ($search) {
                        $projectQuery->where('project_name', 'like', "%{$search}%");
                    });
            });
        });
 
        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->input('status'));
        });
 
        $query->when($request->filled('priority'), function ($q) use ($request) {
            $q->where('priority', $request->input('priority'));
        });
 
        $query->when($request->filled('department_id'), function ($q) use ($request) {
            $q->where('department_id', $request->input('department_id'));
        });
 
        $query->when($request->filled('project_id'), function ($q) use ($request) {
            $q->where('project_id', $request->input('project_id'));
        });
 
        match ($request->input('sort_by', 'latest')) {
            'deadline' => $query->orderByRaw('deadline IS NULL, deadline ASC'),
            'priority' => $query->orderByRaw("FIELD(priority, 'Critical', 'High', 'Medium', 'Low')"),
            'progress' => $query->orderBy('progress', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
 
        $modules = $query->paginate(9)->withQueryString();
 
        /*
        |--------------------------------------------------------------------
        | Statistics — reflect all of the developer's assigned modules,
        | not just the current filtered/paginated page.
        |--------------------------------------------------------------------
        */
        $totalAssigned = (clone $baseQuery)->count();
        $pendingCount = (clone $baseQuery)->where('status', 'Pending')->count();
        $inProgressCount = (clone $baseQuery)->where('status', 'In Progress')->count();
        $completedCount = (clone $baseQuery)->where('status', 'Completed')->count();
        $criticalCount = (clone $baseQuery)->where('priority', 'Critical')->count();
 
        return view('admin.projects.modules.index', [
            'modules' => $modules,
            'departmentOptions' => $departmentOptions,
            'projectOptions' => $projectOptions,
            'statusOptions' => $statusOptions,
            'totalAssigned' => $totalAssigned,
            'pendingCount' => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'criticalCount' => $criticalCount,
        ]);
    }

    public function show(ProjectModule $module): View
    {

        $developerId = auth()->id();
 
        // A developer may only open the workspace for a module assigned to them.
        abort_unless($module->assigned_to === $developerId, 403, 'This module is not assigned to you.');
 
        $module->load([
            'project.department',
            'project.assignedTo',
            'department',
            'developer',
            'creator',
            'subModules' => function ($query) {
                $query->ordered();
            },
            'assignments' => function ($query) {
                $query->with(['assignedBy', 'assignedTo'])->orderBy('assigned_at', 'desc');
            },
        ]);
 
        /*
        |--------------------------------------------------------------------
        | Sub module stats
        |--------------------------------------------------------------------
        */
        $totalSubModules = $module->subModules->count();
        $completedSubModules = $module->subModules->where('status', 'Completed')->count();
        $pendingSubModules = $module->subModules->where('status', 'Pending')->count();
 
        /*
        |--------------------------------------------------------------------
        | Remaining days until this module's own deadline (negative = overdue)
        |--------------------------------------------------------------------
        */
        $remainingDays = $module->deadline
            ? (int) Carbon::today()->diffInDays(Carbon::parse($module->deadline), false)
            : null;
 
        /*
        |--------------------------------------------------------------------
        | Attachments / Comments — no table/model exists for either yet.
        | Checked defensively so this page never errors while those features
        | are still unbuilt; both simply render as empty until added.
        |--------------------------------------------------------------------
        */
        $moduleAttachments = method_exists($module, 'attachments') ? $module->attachments : collect();
        $moduleComments = method_exists($module, 'comments') ? $module->comments : collect();
 
        /*
        |--------------------------------------------------------------------
        | Activity timeline — built only from real data already available:
        | module creation, its full assignment history (assigned / accepted /
        | rejected), and sub module creation. Nothing here is fabricated.
        |--------------------------------------------------------------------
        */
        $activityFeed = collect();
 
        $activityFeed->push([
            'icon' => 'bi-folder-plus',
            'label' => 'Module Created',
            'description' => '"' . $module->module_name . '" was created' . ($module->creator ? ' by ' . $module->creator->name : ''),
            'at' => $module->created_at,
        ]);
 
        foreach ($module->assignments as $assignment) {
            if ($assignment->assigned_at) {
                $activityFeed->push([
                    'icon' => 'bi-person-plus',
                    'label' => 'Developer Assigned',
                    'description' => ($assignment->assignedTo->name ?? 'A developer') . ' was assigned by ' . ($assignment->assignedBy->name ?? 'a team member'),
                    'at' => $assignment->assigned_at,
                ]);
            }
 
            if ($assignment->accepted_at) {
                $activityFeed->push([
                    'icon' => 'bi-check-circle',
                    'label' => 'Assignment Accepted',
                    'description' => ($assignment->assignedTo->name ?? 'The developer') . ' accepted this module',
                    'at' => $assignment->accepted_at,
                ]);
            }
 
            if ($assignment->rejected_at) {
                $activityFeed->push([
                    'icon' => 'bi-x-circle',
                    'label' => 'Assignment Rejected',
                    'description' => ($assignment->assignedTo->name ?? 'The developer') . ' rejected this module' . ($assignment->reason ? ' — ' . $assignment->reason : ''),
                    'at' => $assignment->rejected_at,
                ]);
            }
        }
 
        foreach ($module->subModules as $subModule) {
            $activityFeed->push([
                'icon' => 'bi-diagram-2',
                'label' => 'Sub Module Added',
                'description' => '"' . $subModule->sub_module_name . '" was added under this module',
                'at' => $subModule->created_at,
            ]);
        }
 
        $activityFeed = $activityFeed
            ->filter(fn ($item) => $item['at'] !== null)
            ->sortByDesc('at')
            ->values();
 
        return view('admin.projects.modules.show', [
            'module' => $module,
            'project' => $module->project,
            'totalSubModules' => $totalSubModules,
            'completedSubModules' => $completedSubModules,
            'pendingSubModules' => $pendingSubModules,
            'remainingDays' => $remainingDays,
            'moduleAttachments' => $moduleAttachments,
            'moduleComments' => $moduleComments,
            'activityFeed' => $activityFeed,
        ]);
    }

    // request


    public function requests(Request $request): View
    {
        // return 'hello';
        $developerId = auth()->id();
 
        $baseQuery = ProjectModuleAssignment::query()
            ->where('assigned_to', $developerId)
            ->where('status', 'pending');
 
        /*
        |--------------------------------------------------------------------
        | Filter dropdown data — departments scoped to this developer's own
        | pending requests only, so no option ever returns an empty list.
        |--------------------------------------------------------------------
        */
        $departmentIds = (clone $baseQuery)
            ->whereHas('module', fn ($q) => $q->whereNotNull('department_id'))
            ->with('module:id,department_id')
            ->get()
            ->pluck('module.department_id')
            ->filter()
            ->unique();
 
        $departmentOptions = Department::whereIn('id', $departmentIds)->orderBy('title')->get();
 
        /*
        |--------------------------------------------------------------------
        | Main query: eager load module + project + department + the
        | requesting lead developer — no N+1 queries.
        |--------------------------------------------------------------------
        */
        $query = ProjectModuleAssignment::query()
            ->where('assigned_to', $developerId)
            ->where('status', 'pending')
            ->with([
                'module.project',
                'module.department',
                'assignedBy',
            ]);
 
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = trim($request->input('search'));
            $q->whereHas('module', function ($moduleQuery) use ($search) {
                $moduleQuery->where('module_name', 'like', "%{$search}%");
            });
        });
 
        $query->when($request->filled('priority'), function ($q) use ($request) {
            $priority = $request->input('priority');
            $q->whereHas('module', fn ($moduleQuery) => $moduleQuery->where('priority', $priority));
        });
 
        $query->when($request->filled('department_id'), function ($q) use ($request) {
            $departmentId = $request->input('department_id');
            $q->whereHas('module', fn ($moduleQuery) => $moduleQuery->where('department_id', $departmentId));
        });
 
        $requests = $query->orderByDesc('assigned_at')->paginate(9)->withQueryString();
 
        /*
        |--------------------------------------------------------------------
        | Summary stats
        |--------------------------------------------------------------------
        */
        $pendingRequestsCount = (clone $baseQuery)->count();
 
        $acceptedTodayCount = ProjectModuleAssignment::query()
            ->where('assigned_to', $developerId)
            ->where('status', 'accepted')
            ->whereDate('responded_at', today())
            ->count();
 
        $rejectedTodayCount = ProjectModuleAssignment::query()
            ->where('assigned_to', $developerId)
            ->where('status', 'rejected')
            ->whereDate('responded_at', today())
            ->count();
 
        return view('admin.projects.modules.requests', [
            'requests' => $requests,
            'departmentOptions' => $departmentOptions,
            'pendingRequestsCount' => $pendingRequestsCount,
            'acceptedTodayCount' => $acceptedTodayCount,
            'rejectedTodayCount' => $rejectedTodayCount,
        ]);
    }
 
    /**
     * Accept a pending module assignment request.
     *
     * - Marks the assignment as accepted.
     * - Confirms this developer as project_modules.assigned_to (in case the
     *   module's assigned_to had drifted since the request was created).
     */
    // public function accept(ProjectModuleAssignment $assignment): RedirectResponse
    // {
    //     $this->authorizePendingOwnRequest($assignment);
 
    //     DB::transaction(function () use ($assignment) {
    //         $assignment->status = 'accepted';
    //         $assignment->responded_at = now();
    //         $assignment->save();
 
    //         $assignment->module()->update([
    //             'assigned_to' => $assignment->assigned_to,
    //         ]);
    //     });
 
    //     return redirect()
    //         ->back()
    //         ->with('success', 'Module request accepted. It has been added to your assigned modules.');
    // }

    public function accept(ProjectModuleAssignment $assignment): RedirectResponse
    {
        $this->authorizePendingOwnRequest($assignment);

        DB::transaction(function () use ($assignment) {
            $assignment->status = 'accepted';
            $assignment->responded_at = now();
            $assignment->save();

           $module = $assignment->module()->lockForUpdate()->first();

            $module->update([
                'assigned_to' => $assignment->assigned_to,
            ]);

            // DEBUG - isko temporarily add karo
            $subCount = $module->subModules()->count();
            \Log::info('SubModules found: ' . $subCount . ' for module ID: ' . $module->id);

            $module->subModules()
                ->lockForUpdate()
                ->get()
                ->each(function ($subModule) use ($assignment) {
                    $updated = $subModule->update([
                        'assigned_to' => $assignment->assigned_to,
                    ]);
                    \Log::info('SubModule ' . $subModule->id . ' updated: ' . ($updated ? 'yes' : 'no'));
                });
        });

        return redirect()
            ->back()
            ->with('success', 'Module request accepted. It has been added to your assigned modules, along with its sub-modules.');
    }
 
    /**
     * Reject a pending module assignment request.
     *
     * project_modules.assigned_to is intentionally left untouched — rejecting
     * a request should not change who the module is currently assigned to.
     */
    public function reject(Request $request, ProjectModuleAssignment $assignment): RedirectResponse
    {
        $this->authorizePendingOwnRequest($assignment);
 
        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);
 
        DB::transaction(function () use ($assignment, $validated) {
            $assignment->status = 'rejected';
            $assignment->reason = $validated['reason'] ?? null;
            $assignment->responded_at = now();
            $assignment->save();

            // Notify Admin + Lead Developer
            $this->sendModuleRejectedNotification($assignment);
        });
 
        return redirect()
            ->back()
            ->with('success', 'Module request rejected.');
    }

    private function sendModuleRejectedNotification(
        ProjectModuleAssignment $assignment
    ): void {
        $module = $assignment->module;

        if (!$module) {
            return;
        }

        $project = $module->project;

        if (!$project) {
            return;
        }

        $currentUser = Auth::user();

        $reason = $assignment->reason
            ? ' Reason: ' . $assignment->reason
            : '';

        /*
        |--------------------------------------------------------------------------
        | Notification Message
        |--------------------------------------------------------------------------
        */

        $message = 'Module "' . $module->module_name . '" has been rejected by '
            . $currentUser->name . '.' . $reason;

        /*
        |--------------------------------------------------------------------------
        | Common Notification Data
        |--------------------------------------------------------------------------
        */

        $extra = [
            'project_id'   => $project->id,
            'project_name' => $project->project_name,
            'module_id'    => $module->id,
            'module_name'  => $module->module_name,
            'assignment_id' => $assignment->id,

            'rejected_by'   => $currentUser->id,
            'rejected_by_name' => $currentUser->name,

            'reason' => $assignment->reason,

            'message_type' => 'module_rejected',
        ];

        /*
        |--------------------------------------------------------------------------
        | 1. Notify Admins
        |--------------------------------------------------------------------------
        */

        $admins = User::role('Admin')->get();

        foreach ($admins as $admin) {

            // Don't notify the person who rejected it
            if ($admin->id == $currentUser->id) {
                continue;
            }

            $admin->notify(
                new SystemNotification(
                    'Module Rejected',
                    $message,
                    'module_rejected',
                    route('admin.projects.show', $project->id),
                    $extra,
                    'notification.mp3'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Notify Lead Developer
        |--------------------------------------------------------------------------
        */

        $leadDeveloper = User::find($project->assigned_to);

        if (
            $leadDeveloper &&
            $leadDeveloper->id != $currentUser->id
        ) {

            $leadDeveloper->notify(
                new SystemNotification(
                    'Module Rejected',
                    $message,
                    'module_rejected',
                    route('developer.all.modules.index'),
                    $extra,
                    'notification.mp3'
                )
            );
        }
    }
 
    /**
     * Guard both accept() and reject(): a developer may only respond to
     * their own request, and only while it's still pending.
     */
    private function authorizePendingOwnRequest(ProjectModuleAssignment $assignment): void
    {
        abort_unless($assignment->assigned_to === auth()->id(), 403, 'This request is not addressed to you.');
        abort_if($assignment->status !== 'pending', 409, 'This request has already been responded to.');
    }

    public function index()
    {
        $user = auth()->user();

        // -- Developer's own working queue: only the CURRENT assignment matters --
        $assigned = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy'])
            ->where('assigned_to', $user->id)
            ->pending()
            ->current()
            ->latest()
            ->get();

        $accepted = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy'])
            ->where('assigned_to', $user->id)
            ->accepted()
            ->current()
            ->latest()
            ->get();

        // -- Rejection HISTORY belonging to this developer (deliberately NOT ->current()) --
        $rejected = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy'])
            ->where('assigned_to', $user->id)
            ->rejected()
            ->latest()
            ->get();

        $leadDeveloperId = Project::where('assigned_to', $user->id)->value('assigned_to');

        $leadProjectIds = Project::where('assigned_to', $user->id)->pluck('id');
        $isAdmin        = $user->hasRole('Admin');

        // -- Reassign queue: current + rejected == "needs action right now" --
        $reassignQuery = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy', 'assignedTo'])
            ->rejected()
            ->current();

        if ($isAdmin) {
            $reassignRequests = $reassignQuery->latest()->get();
        } else {
            $reassignRequests = $leadProjectIds->isNotEmpty()
                ? $reassignQuery
                    ->whereHas('module', fn ($q) => $q->whereIn('project_id', $leadProjectIds))
                    ->latest()
                    ->get()
                : collect();
        }

        // -- NEW: All Modules overview (Admin / Lead only) --
        // Shows every module in scope, regardless of who it's assigned to,
        // with its single current status (pending / accepted / rejected / unassigned).
        $allModules = collect();

        if ($isAdmin || $leadProjectIds->isNotEmpty()) {

            $modulesQuery = ProjectModule::with([
                'project',
                'department',
                'currentAssignment.assignedTo',
                'currentAssignment.assignedBy',
            ]);

            if (! $isAdmin) {
                $modulesQuery->whereIn('project_id', $leadProjectIds);
            }

            $allModules = $modulesQuery->latest()->get();
        }

        $developers = User::role('Developer')->orderBy('name')->get();

        return view('admin.projects.modules.workspace', compact(
            'assigned', 'accepted', 'rejected', 'reassignRequests', 'allModules', 'developers', 'leadDeveloperId'
        ));
    }


    public function reassign(Request $request, $assignmentId)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        return DB::transaction(function () use ($request, $assignmentId) {

            $assignment = ProjectModuleAssignment::with('module.project')
                ->lockForUpdate()
                ->findOrFail($assignmentId);

            if (! $assignment->is_current) {
                abort(409, 'This assignment has already been superseded.');
            }

            if ($assignment->status !== 'rejected') {
                abort(422, 'Only rejected modules can be reassigned.');
            }

            $module  = $assignment->module;
            $isAdmin = auth()->user()->hasRole('Admin');
            $isLead  = $module->project->assigned_to === auth()->id();

            if (! $isAdmin && ! $isLead) {
                abort(403);
            }

            // Retire the old assignment
            $assignment->update([
                'is_current'     => false,
                'reassigned_at'  => now(),
            ]);

            // Move the module's current owner
            $module->update([
                'assigned_to' => $request->assigned_to,
                'status'      => 'Pending',
            ]);

            // Create the new — and only — current assignment.
            // If a race condition somehow produced two "current" rows,
            // the unique index (uniq_project_module_active) throws here
            // and the whole transaction rolls back instead of corrupting data.
            ProjectModuleAssignment::create([
                'project_module_id' => $module->id,
                'assigned_by'       => auth()->id(),
                'assigned_to'       => $request->assigned_to,
                'status'            => 'pending',
                'assigned_at'       => now(),
                'reason'            => null,
                'remarks'           => 'Reassigned from previous developer',
                'is_current'        => true,
            ]);

            return back()->with('success', 'Module reassigned successfully.');
        });
    }


    public function allmodules()
    {
        $user = auth()->user();

        // -- Developer's own working queue: only the CURRENT assignment matters --
        $assigned = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy'])
            ->where('assigned_to', $user->id)
            ->pending()
            ->current()
            ->latest()
            ->get();

        $accepted = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy'])
            ->where('assigned_to', $user->id)
            ->accepted()
            ->current()
            ->latest()
            ->get();

        // -- Rejection HISTORY belonging to this developer --
        $rejected = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy'])
            ->where('assigned_to', $user->id)
            ->rejected()
            ->latest()
            ->get();

        $isAdmin = $user->hasRole('Admin');

        // -- All project IDs this user is Lead Developer of (not just the first one) --
        $leadProjectIds = Project::where('assigned_to', $user->id)->pluck('id');

        // Single flag used everywhere for "can this user see Admin/Lead tabs"
        $isLeadDeveloper = $leadProjectIds->isNotEmpty();

        // -- Reassign queue: current + rejected == "needs action right now" --
        $reassignQuery = ProjectModuleAssignment::with(['module.project', 'module.department', 'assignedBy', 'assignedTo'])
            ->rejected()
            ->current();

        if ($isAdmin) {
            // Admin sees reassign requests across ALL projects
            $reassignRequests = $reassignQuery->latest()->get();
        } elseif ($isLeadDeveloper) {
            // Lead sees reassign requests across EVERY project they lead
            $reassignRequests = $reassignQuery
                ->whereHas('module', fn ($q) => $q->whereIn('project_id', $leadProjectIds))
                ->latest()
                ->get();
        } else {
            $reassignRequests = collect();
        }

        // -- All Modules overview --
        $allModules = collect();

        if ($isAdmin || $isLeadDeveloper) {

            $modulesQuery = ProjectModule::with([
                'project',
                'department',
                'currentAssignment.assignedTo',
                'currentAssignment.assignedBy',
            ]);

            if (! $isAdmin) {
                // Lead: modules across ALL projects they lead
                $modulesQuery->whereIn('project_id', $leadProjectIds);
            }
            // Admin: no filter → literally every module of every project

            $allModules = $modulesQuery->latest()->get();
        }

        $developers = User::role('Developer')->orderBy('name')->get();

        return view('admin.projects.modules.allmodule', compact(
            'assigned', 'accepted', 'rejected', 'reassignRequests',
            'allModules', 'developers', 'isAdmin', 'isLeadDeveloper'
        ));
    }














    
}



