<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Illuminate\Support\Facades\Hash; // <-- Add this
use App\Models\ProjectAttachment;
use Illuminate\Support\Facades\Auth;

use App\Notifications\SystemNotification;




use App\Models\ProjectModule;




class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Project List
        $this->middleware('permission:project-list')->only(['index']);

        // Project Create
        $this->middleware('permission:project-create')->only([
            'create',
            'store'
        ]);

        // Project Edit
        $this->middleware('permission:project-edit')->only([
            'edit',
            'update'
        ]);

        // Project Delete
        $this->middleware('permission:project-delete')->only([
            'destroy'
        ]);

        // Project Overview
        $this->middleware('permission:project-show')->only([
            'show'
        ]);
    }

    

    

        

        

   

    public function index(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Main Project Query
        |--------------------------------------------------------------------------
        */

        $query = Project::query()->with([
            'department',
            'assignedTo',
            'modules',
            'createdBy',
            'attachments',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin -> All Projects
        | Lead Developer -> Own Projects
        | Developer -> Accepted Modules Projects
        |--------------------------------------------------------------------------
        */

        if (!$user->hasRole('Admin')) {

            $query->where(function ($q) use ($user) {

                // Lead Developer
                $q->where('assigned_to', $user->id)

                // Module Developer (Accepted Modules Only)
                ->orWhereHas('modules.assignments', function ($assignment) use ($user) {

                    $assignment->where('assigned_to', $user->id)
                            ->where('status', 'Accepted');

                });

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Statistics Base Query
        |--------------------------------------------------------------------------
        */

        $projectStats = Project::query();

        $moduleStats = ProjectModule::query();

        if (!$user->hasRole('Admin')) {

            $projectStats->where(function ($q) use ($user) {

                // Lead Developer
                $q->where('assigned_to', $user->id)

                // Module Developer
                ->orWhereHas('modules.assignments', function ($assignment) use ($user) {

                    $assignment->where('assigned_to', $user->id)
                            ->where('status', 'Accepted');

                });

            });

            $moduleStats->whereHas('assignments', function ($assignment) use ($user) {

                $assignment->where('assigned_to', $user->id)
                        ->where('status', 'Accepted');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $query->when($request->filled('search'), function ($q) use ($request) {

            $search = trim($request->search);

            $q->where(function ($sub) use ($search) {

                $sub->where('project_name', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");

            });

        });

        $query->when($request->filled('department_id'), function ($q) use ($request) {

            $q->where('department_id', $request->department_id);

        });

        $query->when($request->filled('assigned_to'), function ($q) use ($request) {

            $q->where('assigned_to', $request->assigned_to);

        });

        $query->when($request->filled('client_name'), function ($q) use ($request) {

            $q->where('client_name', $request->client_name);

        });

        $query->when($request->filled('priority'), function ($q) use ($request) {

            $q->where('priority', $request->priority);

        });

        $query->when($request->filled('status'), function ($q) use ($request) {

            $q->where('status', $request->status);

        });

        $query->when($request->filled('source'), function ($q) use ($request) {

            $q->where('source', $request->source);

        });

        $query->when($request->filled('from_date'), function ($q) use ($request) {

            $q->whereDate('deadline', '>=', $request->from_date);

        });

        $query->when($request->filled('to_date'), function ($q) use ($request) {

            $q->whereDate('deadline', '<=', $request->to_date);

        });

            /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        match ($request->input('sort_by', 'latest')) {

            'oldest' => $query->orderBy('created_at', 'asc'),

            'deadline_asc' => $query->orderByRaw('deadline IS NULL, deadline ASC'),

            'deadline_desc' => $query->orderByRaw('deadline IS NULL, deadline DESC'),

            'name_asc' => $query->orderBy('project_name', 'asc'),

            'name_desc' => $query->orderBy('project_name', 'desc'),

            'priority' => $query->orderByRaw("FIELD(priority, 'Critical', 'High', 'Medium', 'Low')"),

            default => $query->latest(),

        };

        /*
        |--------------------------------------------------------------------------
        | View Type
        |--------------------------------------------------------------------------
        */

        $view = $request->input('view', 'cards');

        if ($view === 'kanban') {

            $projects = $query->limit(300)->get();

        } else {

            $projects = $query->paginate(12)->withQueryString();

        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalProjects = (clone $projectStats)->count();

        $activeProjects = (clone $projectStats)
            ->where('status', 'In Progress')
            ->count();

        $completedProjects = (clone $projectStats)
            ->where('status', 'Completed')
            ->count();

        $pendingProjects = (clone $projectStats)
            ->where('status', 'Pending')
            ->count();

        $onHoldProjects = (clone $projectStats)
            ->where('status', 'On Hold')
            ->count();

        $cancelledProjects = (clone $projectStats)
            ->where('status', 'Cancelled')
            ->count();

        $overdueProjects = (clone $projectStats)
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', today())
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->count();

        $todayDeadlineProjects = (clone $projectStats)
            ->whereDate('deadline', today())
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->count();

        $totalDevelopers = (clone $projectStats)
            ->whereNotNull('assigned_to')
            ->distinct('assigned_to')
            ->count('assigned_to');

        $totalClients = (clone $projectStats)
            ->whereNotNull('client_name')
            ->distinct('client_name')
            ->count('client_name');

        $overallProgress = (int) round(
            (clone $moduleStats)->avg('progress') ?? 0
        );

            /*
        |--------------------------------------------------------------------------
        | Filter Dropdown Data
        |--------------------------------------------------------------------------
        */

        $departments = Department::orderBy('title')->get();

        $developers = User::orderBy('name')->get();

        $clients = (clone $projectStats)
            ->select('client_name')
            ->whereNotNull('client_name')
            ->distinct()
            ->orderBy('client_name')
            ->pluck('client_name');

        /*
        |--------------------------------------------------------------------------
        | Sidebar Data
        |--------------------------------------------------------------------------
        */

        $recentProjects = (clone $projectStats)
            ->with('assignedTo')
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = (clone $projectStats)
            ->with('createdBy')
            ->latest()
            ->take(6)
            ->get();

        $upcomingDeadlines = (clone $projectStats)
            ->whereNotNull('deadline')
            ->whereDate('deadline', '>=', today())
            ->whereNotIn('status', ['Completed', 'Cancelled'])
            ->orderBy('deadline')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        

        return view('admin.projects.index', compact(

            'projects',

            'departments',

            'developers',

            'clients',

            'totalProjects',

            'activeProjects',

            'completedProjects',

            'pendingProjects',

            'onHoldProjects',

            'cancelledProjects',

            'overdueProjects',

            'todayDeadlineProjects',

            'totalDevelopers',

            'totalClients',

            'overallProgress',

            'recentProjects',

            'recentActivities',

            'upcomingDeadlines'

        ));
    }


    public function create()
    {
        $departments = Department::orderBy('title')->get();

        // $leads = Lead::where('stage', 'Won')
        //             ->orderBy('company_name')
        //             ->get();

        $leads = Lead::where('stage', 'Won')->get();            

        return view('admin.projects.create', compact(
            'departments',
            'leads'
        ));
    }

    public function getLead(Lead $lead)
    {
        return response()->json($lead);
    }

    public function store(Request $request)
    {
        $request->validate([

            'source'              => 'required|in:manual,lead',
            'email'               => 'required|email',

            'project_name'        => 'required|max:255',

            'client_name'         => 'required|max:255',

            'phone'               => 'required|max:20',

            'department_id'       => 'required|exists:departments,id',

            'assigned_to'         => 'required|exists:users,id',

            'priority'            => 'required|in:Low,Medium,High,Critical',

            'start_date'          => 'nullable|date',

            'deadline'            => 'nullable|date|after_or_equal:start_date',

            'attachments.*'       => 'nullable|file|max:51200', // 50 MB

        ]);

        if ($request->source == 'manual') {

            $name  = $request->client_name;
            $email = $request->email;
            $phone = $request->phone;

        } else {

            $lead = Lead::findOrFail($request->lead_id);

            $name  = $lead->name;
            $email = $lead->email;
            $phone = $lead->phone;
        }

        $clientUser = User::where('email', $email)->first();

        if (!$clientUser) {

            // $password = Str::random(10);

            $clientUser = User::create([

                'name'     => $name,
                'email'    => $email,
                'phone'    => $phone,
                'password' => Hash::make('password'),
                'status'   => 'active',
            ]);

            

            $clientUser->assignRole('End Customer');

            // dd($clientUser);

        }

        DB::beginTransaction();

        try {

            $project = Project::create([

                'source'              => $request->source,

                'lead_id'             => $request->lead_id,

                'client_name'         => $request->client_name,

                'phone'               => $request->phone,

                'email'               => $request->email,

                'address'             => $request->address,

                'project_name'        => $request->project_name,

                'project_description' => $request->project_description,

                'department_id'       => $request->department_id,

                'assigned_to'         => $request->assigned_to,

                'start_date'          => $request->start_date,

                'deadline'            => $request->deadline,

                'priority'            => $request->priority,

                'status'              => $request->status ?? 'Pending',

                'remarks'             => $request->remarks,

                'created_by'          => Auth::id(),

                'client_user_id'      => $clientUser->id,

            ]);

            // ==========================
            // Multiple Attachments
            // ==========================

            if ($request->hasFile('attachments')) {

                foreach ($request->file('attachments') as $file) {

                    // Move se PEHLE sari information le lo
                    $originalName = $file->getClientOriginalName();
                    $extension    = $file->getClientOriginalExtension();
                    $mimeType     = $file->getMimeType();
                    $fileSize     = $file->getSize();

                    $fileName = time().'_'.uniqid().'.'.$extension;

                    // Upload
                    $file->move(public_path('uploads/projects'), $fileName);

                    // Database
                    ProjectAttachment::create([
                        'project_id'    => $project->id,
                        'original_name' => $originalName,
                        'file_name'     => $fileName,
                        'file_path'     => 'uploads/projects/'.$fileName,
                        'extension'     => $extension,
                        'mime_type'     => $mimeType,
                        'file_size'     => $fileSize,
                        'disk'          => 'public',
                        'uploaded_by'   => Auth::id(),
                    ]);
                }
            }

            DB::commit();

            $this->sendProjectCreatedNotifications($project);


            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Project created successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            dd([
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);
        }
    }

    private function sendProjectCreatedNotifications(Project $project): void
    {
        $sender = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Lead Developer Notification
        |--------------------------------------------------------------------------
        */

        $leadDeveloper = User::find($project->assigned_to);

        if ($leadDeveloper && $leadDeveloper->id != $sender->id) {

            $leadDeveloper->notify(
                new SystemNotification(
                    'New Project Assigned',
                    'A new project "' . $project->project_name . '" has been assigned to you.',
                    'project_created',
                    route('admin.projects.show', $project->id),
                    [
                        'project_id'   => $project->id,
                        'project_name' => $project->project_name,
                        'sender_id'    => $sender->id,
                        'sender_name'  => $sender->name,
                        'message_type' => 'project_created',
                    ],
                    'notification.mp3'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Customer Notification
        |--------------------------------------------------------------------------
        */

        $customer = User::find($project->client_user_id);

        if ($customer && $customer->id != $sender->id) {

            $customer->notify(
                new SystemNotification(
                    'New Project Created',
                    'A new project "' . $project->project_name . '" has been created for you.',
                    'project_created',
                    route('admin.projects.show', $project->id),
                    [
                        'project_id'   => $project->id,
                        'project_name' => $project->project_name,
                        'sender_id'    => $sender->id,
                        'sender_name'  => $sender->name,
                        'message_type' => 'project_created',
                    ],
                    'notification.mp3'
                )
            );
        }
    }


    public function show(Project $project)
    {
        $user = auth()->user();

        // Admin
        if ($user->hasRole('Admin')) {

            // allowed

        }
        // Developer (Lead Developer + Assigned Developer)
        elseif ($user->hasRole('Developer')) {

            $isLeadDeveloper = $project->assigned_to == $user->id;

            $isAssignedDeveloper = $project->modules()
                ->whereHas('assignments', function ($q) use ($user) {
                    $q->where('assigned_to', $user->id)
                    ->where('status', 'Accepted');
                })
                ->exists();

            abort_unless(
                $isLeadDeveloper || $isAssignedDeveloper,
                403,
                'You are not authorized to view this project.'
            );

        }
        else {
            abort(403);
        }

        // ---------------------------------------------------------------
        // Eager load every relationship the workspace view needs.
        // No N+1 queries: modules, sub modules, attachments, users and
        // department are all pulled up front.
        // ---------------------------------------------------------------
        $project->load([
            'department',
            'assignedTo',
            'creator',
            'modules' => function ($query) use ($user, $project) {

                $query->ordered();

                // Admin sab dekhe
                if ($user->hasRole('Admin')) {
                    return;
                }

                // Lead Developer sab modules dekhe
                if ($project->assigned_to == $user->id) {
                    return;
                }

                // Developer sirf Accepted modules dekhe
                $query->whereHas('assignments', function ($q) use ($user) {

                    $q->where('assigned_to', $user->id)
                    ->where('status', 'Accepted');

                });

            },
            'modules.department',
            'modules.assignments',
            'modules.developer',
            'modules.subModules' => function ($query) {
                $query->orderBy('sort_order');
            },
            'modules.subModules.assignedTo',
            'attachments' => function ($query) {
                $query->latest();
            },
            'attachments.uploadedBy',
        ]);

        // return $project;
    
        // ---------------------------------------------------------------
        // Module level stats
        // ---------------------------------------------------------------
        $totalModules     = $project->modules->count();
        $completedModules = $project->modules->where('status', 'Completed')->count();
        $pendingModules   = $totalModules - $completedModules;
    
        // ---------------------------------------------------------------
        // Sub module level stats (flattened across all modules)
        // ---------------------------------------------------------------
        $totalSubModules = $project->modules->sum(function ($module) {
            return $module->subModules->count();
        });
    
        $completedSubModules = $project->modules->sum(function ($module) {
            return $module->subModules->where('status', 'Completed')->count();
        });
    
        $pendingSubModules = $totalSubModules - $completedSubModules;
    
        // ---------------------------------------------------------------
        // Hours
        // ---------------------------------------------------------------
        $totalEstimatedHours = (float) $project->modules->sum('estimated_hours');
        $totalActualHours    = (float) $project->modules->sum('actual_hours');
        $remainingHours      = max(0, $totalEstimatedHours - $totalActualHours);
    
        // ---------------------------------------------------------------
        // Overall progress (average of module progress)
        // ---------------------------------------------------------------
        $overallProgress = $totalModules > 0
            ? (int) round($project->modules->avg('progress'))
            : 0;
    
        // ---------------------------------------------------------------
        // People / files
        // ---------------------------------------------------------------
        $developersCount = $project->modules
            ->pluck('assigned_to')
            ->filter()
            ->unique()
            ->count();
    
        $attachmentsCount = $project->attachments->count();
    
        // ---------------------------------------------------------------
        // Timeline / deadline math
        // ---------------------------------------------------------------
        $remainingDays = null;
    
        if ($project->deadline) {
            // Positive = days left, Negative = overdue
            $remainingDays = (int) ceil(
                now()->startOfDay()->diffInDays($project->deadline, false)
            );
        }
    
        return view('admin.projects.show', compact(
            'project',
            'totalModules',
            'completedModules',
            'pendingModules',
            'totalSubModules',
            'completedSubModules',
            'pendingSubModules',
            'totalEstimatedHours',
            'totalActualHours',
            'remainingHours',
            'overallProgress',
            'developersCount',
            'attachmentsCount',
            'remainingDays'
        ));
    }
  

    public function edit(Project $project)
    {
        $developers = User::role('Developer')
            ->orderBy('name')
            ->get();

        return view('admin.projects.edit', compact(
            'project',
            'developers'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'project_name'        => 'required|string|max:255',
            'project_description' => 'nullable|string',

            'assigned_to'         => 'required|exists:users,id',

            'start_date'          => 'nullable|date',
            'deadline'            => 'nullable|date|after_or_equal:start_date',

            'priority'            => 'required|in:Low,Medium,High,Critical',
            'status'              => 'required|in:Pending,In Progress,Completed,On Hold,Cancelled',

            'remarks'             => 'nullable|string',
        ]);

        $project->update([
            'project_name'        => $request->project_name,
            'project_description' => $request->project_description,

            'assigned_to'         => $request->assigned_to,

            'start_date'          => $request->start_date,
            'deadline'            => $request->deadline,

            'priority'            => $request->priority,
            'status'              => $request->status,

            'remarks'             => $request->remarks,
        ]);

        return redirect()
            ->route('admin.projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
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

    public function destroy(Project $project)
    {
        DB::beginTransaction();

        try {

            // ==========================
            // Delete Attachments
            // ==========================
            foreach ($project->attachments as $attachment) {

                if (
                    $attachment->file_path &&
                    file_exists(public_path($attachment->file_path))
                ) {
                    @unlink(public_path($attachment->file_path));
                }

                $attachment->delete();
            }

            // ==========================
            // Delete Sub Modules
            // ==========================
            foreach ($project->modules as $module) {

                $module->subModules()->delete();

                // Module Assignments
                $module->assignments()->delete();

                $module->delete();
            }

            // ==========================
            // Delete Project
            // ==========================
            $project->delete();

            DB::commit();

            return redirect()
                ->route('admin.projects.index')
                ->with('success', 'Project deleted successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    

    public function getDevelopers($departmentId)
    {
        $developers = User::where('department', $departmentId)
            ->where('status', 'active')
            ->where('role', '!=', 'Admin')
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($developers);
    }

    public function workspace(Project $project)
    {
        $project->load([
            'department',
            'leadDeveloper',
            'creator',
            'modules.subModules'
        ]);

        return view('admin.projects.workspace', compact('project'));
    }
}
