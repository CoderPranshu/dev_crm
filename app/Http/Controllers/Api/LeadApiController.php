<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadAction;
use App\Models\Proforma;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class LeadApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $status = $request->get('status', 'pending');

        $query = Lead::query();

        if ($status === 'pending') {
            // Only show pending leads that are still awaiting an outcome.
            $query->where('status', 'pending')
                ->whereDoesntHave('latestAction', function ($q) {
                    $q->whereIn('action_type', [
                        'not_contactable',
                        'wrong_category',
                        'out_of_area',
                        'marketing_job',
                    ]);
                });
        } elseif ($status !== 'all') {
            $query->where('status', $status);
        }

        // Admin can view all eligible leads.
        // Other users can view only their assigned leads.
        if (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        // Optional filters.
        if ($request->filled('category_id')) {
            $query->where(
                'categories_id',
                $request->category_id
            );
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('remarks', 'like', "%{$search}%")
                    ->orWhere('requirement', 'like', "%{$search}%");
            });
        }

        // Return JSON instead of a Blade view.
        $leads = $query
            ->with(['leadcat', 'assignedUser'])
            ->latest()
            ->paginate($request->integer('per_page', 25));

        return response()->json([
            'status' => true,
            'message' => 'Leads retrieved successfully.',
            'data' => $leads,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();

        $query = Lead::with([
            'leadcat',
            'assignedUser',
            'branch',
            'actions',
            'latestNote',
            'deals',
            'quotations',
        ]);

        // Employees can view only their assigned leads.
        // Admins can view leads assigned to any employee.
        if (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        $lead = $query->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Lead retrieved successfully.',
            'data' => $lead,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'email' => ['required', 'email', 'max:255'],
            'requirement' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'categories_id' => [
                'required',
                'integer',
                'exists:lead_categories,id',
            ],
        ]);

        $currentUser = $request->user();

        $lead = Lead::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'requirement' => $data['requirement'],
            'address' => $data['address'] ?? null,
            'categories_id' => $data['categories_id'],
            'user_id' => $currentUser->id,
            'branch_id' => $currentUser->branch_id,
        ]);

        $lead->load(['leadcat', 'assignedUser', 'branch']);

        return response()->json([
            'status' => true,
            'message' => 'Lead created successfully.',
            'data' => $lead,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $currentUser = $request->user();

        // Find a lead the employee is allowed to access.
        $query = Lead::query();

        if (!$currentUser->hasRole('Admin')) {
            $query->where('user_id', $currentUser->id);
        }

        $lead = $query->findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'digits:10'],
            'email' => ['sometimes', 'required', 'email', 'max:255'],
            'requirement' => ['sometimes', 'required', 'string', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'categories_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:lead_categories,id',
            ],
        ]);

        if (empty($data)) {
            return response()->json([
                'status' => false,
                'message' => 'No valid fields provided for update.',
            ], 422);
        }

        $lead->update($data);

        $lead->load(['leadcat', 'assignedUser', 'branch']);

        return response()->json([
            'status' => true,
            'message' => 'Lead updated successfully.',
            'data' => $lead,
        ]);
    }

    public function categories()
    {
        $categories = \App\Models\LeadCategory::query()
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $categories,
        ]);
    }

    public function actions(Request $request, $id)
    {
        $user = $request->user();

        // Apply the same lead access rules as the show endpoint.
        $leadQuery = Lead::query();

        if (!$user->hasRole('Admin')) {
            $leadQuery->where('user_id', $user->id);
        }

        $lead = $leadQuery->findOrFail($id);

        // Validate and limit pagination.
        $validated = $request->validate([
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ]);

        $perPage = (int) ($validated['per_page'] ?? 25);

        // Retrieve the existing action records; do not create new ones.
        $actions = $lead->actions()
            ->orderByDesc('action_at')
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Lead actions retrieved successfully.',
            'data' => [
                'lead_id' => $lead->id,
                'actions' => $actions->items(),
                'pagination' => [
                    'current_page' => $actions->currentPage(),
                    'per_page' => $actions->perPage(),
                    'total' => $actions->total(),
                    'last_page' => $actions->lastPage(),
                ],
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Dashboard Stats  (Counts for badges/home screen)
    // GET /api/leads/stats
    // ─────────────────────────────────────────────────────────────────────────
    public function stats(Request $request)
    {
        $user = $request->user();

        $tz    = 'Asia/Kolkata';
        $today = now()->setTimezone($tz)->toDateString();

        $baseQuery = Lead::query();

        if (!$user->hasRole('Admin')) {
            $baseQuery->where('user_id', $user->id);
        }

        $pending = (clone $baseQuery)
            ->where('status', 'pending')
            ->whereDoesntHave('latestAction', function ($q) {
                $q->whereIn('action_type', [
                    'not_contactable',
                    'wrong_category',
                    'out_of_area',
                    'marketing_job',
                ]);
            })
            ->count();

        $todayFollowUps = (clone $baseQuery)
            ->where('status', 'call')
            ->whereDate('call_schedule', $today)
            ->count();

        $overdueFollowUps = (clone $baseQuery)
            ->where('status', 'call')
            ->whereDate('call_schedule', '<', $today)
            ->count();

        $contacted = (clone $baseQuery)
            ->where('status', 'contacted')
            ->count();

        $dealsWon = (clone $baseQuery)
            ->where('status', 'accept')
            ->count();

        $rejected = (clone $baseQuery)
            ->where('status', 'reject')
            ->count();

        $total = (clone $baseQuery)->count();

        return response()->json([
            'status'  => true,
            'message' => 'Lead stats retrieved successfully.',
            'data'    => [
                'pending'             => $pending,
                'today_follow_ups'    => $todayFollowUps,
                'overdue_follow_ups'  => $overdueFollowUps,
                'contacted'           => $contacted,
                'deals_won'           => $dealsWon,
                'rejected'            => $rejected,
                'total_leads'         => $total,
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Follow-ups  (leads with status = 'call')
    // GET /api/leads/follow-ups
    // ─────────────────────────────────────────────────────────────────────────
    public function followUps(Request $request)
    {
        $user = $request->user();

        $tz    = 'Asia/Kolkata';
        $today = now()->setTimezone($tz)->toDateString();

        $validated = $request->validate([
            'date'     => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'priority' => ['sometimes', 'nullable', 'in:hot,warm,cold'],
            'all'      => ['sometimes', 'nullable', 'boolean'],
            'overdue'  => ['sometimes', 'nullable', 'boolean'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Lead::query()->where('status', 'call');

        // Admin sees all, others see only their own leads.
        if (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        $showAll = filter_var($validated['all'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $isOverdue = filter_var($validated['overdue'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($isOverdue) {
            // Overdue follow-ups (past scheduled date)
            $query->whereDate('call_schedule', '<', $today);
        } elseif ($showAll) {
            // All future follow-ups (today and beyond)
            $query->whereDate('call_schedule', '>=', $today);
        } else {
            // Default: only today's follow-ups
            $date = $validated['date'] ?? $today;
            $query->whereDate('call_schedule', $date);
        }

        if (!empty($validated['priority'])) {
            $query->where('follow_up_priority', $validated['priority']);
        }

        $perPage = (int) ($validated['per_page'] ?? 25);

        $leads = $query
            ->with(['leadcat', 'assignedUser', 'latestAction'])
            ->orderByRaw("FIELD(follow_up_priority, 'hot', 'warm', 'cold')")
            ->orderBy('call_schedule')
            ->paginate($perPage);

        return response()->json([
            'status'  => true,
            'message' => 'Follow-ups retrieved successfully.',
            'data'    => $leads,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Rejected leads  (status = 'reject')
    // GET /api/leads/rejected
    // ─────────────────────────────────────────────────────────────────────────
    public function rejected(Request $request)
    {
        $user = $request->user();

        $query = Lead::query()->where('status', 'reject');

        if (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('requirement', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('categories_id', $request->category_id);
        }

        $leads = $query
            ->with(['leadcat', 'assignedUser', 'latestAction'])
            ->latest()
            ->paginate($request->integer('per_page', 25));

        return response()->json([
            'status'  => true,
            'message' => 'Rejected leads retrieved successfully.',
            'data'    => $leads,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Lead Notes  — GET & POST
    // GET  /api/leads/{id}/notes
    // POST /api/leads/{id}/notes
    // ─────────────────────────────────────────────────────────────────────────
    public function getNotes(Request $request, $id)
    {
        $user = $request->user();

        $leadQuery = Lead::query();
        if (!$user->hasRole('Admin')) {
            $leadQuery->where('user_id', $user->id);
        }
        $lead = $leadQuery->findOrFail($id);

        $notes = $lead->notes()
            ->with('user:id,name')
            ->latest()
            ->paginate($request->integer('per_page', 25));

        return response()->json([
            'status'  => true,
            'message' => 'Notes retrieved successfully.',
            'data'    => [
                'lead_id'    => $lead->id,
                'notes'      => $notes->items(),
                'pagination' => [
                    'current_page' => $notes->currentPage(),
                    'per_page'     => $notes->perPage(),
                    'total'        => $notes->total(),
                    'last_page'    => $notes->lastPage(),
                ],
            ],
        ]);
    }

    public function storeNote(Request $request, $id)
    {
        $user = $request->user();

        $leadQuery = Lead::query();
        if (!$user->hasRole('Admin')) {
            $leadQuery->where('user_id', $user->id);
        }
        $lead = $leadQuery->findOrFail($id);

        $validated = $request->validate([
            'description' => ['required', 'string', 'max:2000'],
            'call_date'   => ['nullable', 'date'],
        ]);

        $note = $lead->notes()->create([
            'description' => $validated['description'],
            'call_date'   => $validated['call_date'] ?? null,
            'created_by'  => $user->id,
        ]);

        $note->load('user:id,name');

        return response()->json([
            'status'  => true,
            'message' => 'Note added successfully.',
            'data'    => $note,
        ], 201);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Action type options  (static — for mobile dropdowns)
    // GET /api/lead-action-options
    // ─────────────────────────────────────────────────────────────────────────
    public function actionOptions()
    {
        return response()->json([
            'status' => true,
            'data'   => [
                'action_types' => [
                    'call'              => 'Call',
                    'whatsapp'          => 'WhatsApp',
                    'contacted'         => 'Contacted',
                    'follow_up'         => 'Follow Up',
                    'deal_close'        => 'Deal Close',
                    'not_interested'    => 'Not Interested',
                    'not_contactable'   => 'Not Contactable',
                    'wrong_category'    => 'Wrong Category',
                    'out_of_area'       => 'Out of Area',
                    'marketing_job'     => 'Marketing / Job',
                    'quotation_shared'  => 'Quotation Shared',
                ],
                'call_reasons' => [
                    'contacted' => [
                        'interested'           => 'Interested',
                        'information_requested' => 'Information Requested',
                        'follow_up_later'       => 'Follow Up Later',
                        'discuss_internal'      => 'Discuss Internal',
                        'other'                => 'Other',
                    ],
                    'not_contactable' => [
                        'busy'            => 'Busy',
                        'no_answer'       => 'No Answer',
                        'switched_off'    => 'Switched Off',
                        'out_of_coverage' => 'Out of Coverage',
                        'invalid_number'  => 'Invalid Number',
                        'other'           => 'Other',
                    ],
                ],
                'follow_up_priorities' => ['hot', 'warm', 'cold'],
                'lead_statuses'        => [
                    'pending'           => 'Pending',
                    'contacted'         => 'Contacted',
                    'call'              => 'Follow Up Scheduled',
                    'accept'            => 'Deal Closed',
                    'reject'            => 'Rejected',
                    'detailed-quotation' => 'Detailed Quotation',
                ],
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Branches dropdown
    // GET /api/branches
    // ─────────────────────────────────────────────────────────────────────────
    public function branches()
    {
        $branches = DB::table('branches')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $branches,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Sales users dropdown  (for lead transfer)
    // GET /api/sales-users
    // ─────────────────────────────────────────────────────────────────────────
    public function salesUsers(Request $request)
    {
        $user = $request->user();

        // Only active users who have a Sales-related role.
        // We load users whose role name contains 'Sales' or who have
        // the lead-list permission — consistent with the web transfer logic.
        $users = \App\Models\User::query()
            ->where('status', 'active')
            ->whereHas('roles', function ($q) {
                $q->where('name', 'Sales');
            })
            ->select('id', 'name', 'branch_id')
            ->with('branch:id,name');

        // Non-admin can only transfer within their own branch.
        if (!$user->hasRole('Admin')) {
            $users->where('branch_id', $user->branch_id);
        }

        return response()->json([
            'status' => true,
            'data'   => $users->get(),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Global Lead Actions Index  (matches web's leadActionsIndex)
    // GET /api/lead-actions
    // ─────────────────────────────────────────────────────────────────────────
    public function allActions(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'search'      => 'nullable|string|max:200',
            'action_type' => 'nullable|string|max:50',
            'user_id'     => 'nullable|integer',
            'from_date'   => 'nullable|date_format:Y-m-d',
            'to_date'     => 'nullable|date_format:Y-m-d|after_or_equal:from_date',
            'per_page'    => 'nullable|integer|min:1|max:100',
        ]);

        $baseQuery = LeadAction::query();

        // Access control: non-Admin sees only actions on leads assigned to them
        if (!$user->hasRole('Admin')) {
            $baseQuery->whereHas('lead', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        // Shared search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $baseQuery->where(function ($q) use ($search) {
                $q->where('action_label', 'like', "%{$search}%")
                    ->orWhere('action_type', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%")
                    ->orWhereHas('lead', function ($leadQuery) use ($search) {
                        $leadQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($user->hasRole('Admin') && $request->filled('user_id')) {
            $baseQuery->where('user_id', (int) $request->user_id);
        }

        if ($request->filled('from_date')) {
            $baseQuery->whereDate('action_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $baseQuery->whereDate('action_at', '<=', $request->to_date);
        }

        $callCountBase = clone $baseQuery;

        // Exclude system pending call placeholders from normal action feed
        $baseQuery->where(function ($q) {
            $q->whereNotIn('action_type', ['call', 'contacted'])
                ->orWhereNull('note')
                ->orWhereNotIn('note', [
                    'Call initiated from lead index; outcome pending.',
                    'Call initiated from lead panel.',
                ]);
        });

        // Summary counts
        $totalActions      = (clone $baseQuery)->count();
        $contactedActions  = (clone $baseQuery)->where('action_type', 'contacted')->count();
        $followUpActions   = (clone $baseQuery)->where('action_type', 'follow_up')->count();
        $quotationActions  = (clone $baseQuery)->where('action_type', 'quotation_shared')->count();
        $dealClosedActions = (clone $baseQuery)->where('action_type', 'deal_close')->count();
        $whatsappActions   = (clone $baseQuery)->where('action_type', 'whatsapp')->count();
        $callActions       = (clone $callCountBase)->sum('call_count');

        // Apply action_type filter to main list
        $listQuery = clone $baseQuery;
        if ($request->filled('action_type')) {
            if ($request->action_type === 'call') {
                $listQuery->where('call_count', '>', 0);
            } else {
                $listQuery->where('action_type', $request->action_type);
            }
        }

        $perPage = (int) ($request->per_page ?? 25);
        $actions = $listQuery
            ->with(['lead:id,name,phone,status', 'user:id,name', 'quotation'])
            ->orderByDesc('action_at')
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json([
            'status'  => true,
            'message' => 'Lead actions retrieved successfully.',
            'data'    => [
                'summary' => [
                    'total_actions'       => $totalActions,
                    'call_actions'        => (int) $callActions,
                    'whatsapp_actions'    => $whatsappActions,
                    'contacted_actions'   => $contactedActions,
                    'follow_up_actions'   => $followUpActions,
                    'quotation_actions'   => $quotationActions,
                    'deal_closed_actions' => $dealClosedActions,
                ],
                'actions' => $actions,
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Today's Meetings  (matches web's todayMeetings)
    // GET /api/leads/today-meetings
    // ─────────────────────────────────────────────────────────────────────────
    public function todayMeetings(Request $request)
    {
        $user = $request->user();
        $tz    = 'Asia/Kolkata';
        $today = Carbon::now($tz);
        $start = $today->copy()->startOfDay()->format('Y-m-d H:i:s');
        $end   = $today->copy()->addDay()->startOfDay()->format('Y-m-d H:i:s');

        $leadQuery = Lead::query()
            ->with('userlead:id,name')
            ->join('pipeline_meetings as pm', function ($join) {
                $join->on('pm.entity_id', '=', 'leads.id')
                    ->where('pm.entity_type', '=', 'lead');
            })
            ->where('leads.stage', 'Meeting')
            ->where('pm.meeting_at', '>=', $start)
            ->where('pm.meeting_at', '<', $end)
            ->where(function ($query) {
                $query->where('leads.status', 'accept')
                    ->orWhereHas('quotations');
            })
            ->select('leads.*', 'pm.meeting_at as scheduled_at');

        if ($user->hasRole('Admin')) {
            // Admin sees all
        } elseif ($user->hasRole('Sales')) {
            $leadQuery->where('leads.branch_id', $user->branch_id);
        } else {
            $leadQuery->where(function ($query) use ($user) {
                $query->where('leads.user_id', $user->id)
                    ->orWhereHas('quotations', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            });
        }

        $leadMeetings = $leadQuery->get()->map(function ($lead) use ($tz) {
            return [
                'type'        => $lead->status === 'accept' ? 'Lead' : 'Quotation',
                'reference'   => 'Lead #' . $lead->id,
                'lead_id'     => $lead->id,
                'name'        => trim($lead->name . ' ' . ($lead->last_name ?? '')),
                'phone'       => $lead->phone,
                'salesperson' => $lead->userlead->name ?? 'Unassigned',
                'meeting_at'  => Carbon::parse($lead->scheduled_at, $tz)->toDateTimeString(),
            ];
        });

        // Proformas meetings (if table exists)
        $proformaMeetings = collect();
        if (class_exists(Proforma::class)) {
            $proformaQuery = Proforma::query()
                ->with(['lead.userlead:id,name', 'customer'])
                ->join('pipeline_meetings as pm', function ($join) {
                    $join->on('pm.entity_id', '=', 'proformas.id')
                        ->where('pm.entity_type', '=', 'proforma');
                })
                ->whereNotNull('proformas.lead_id')
                ->whereHas('lead')
                ->where('proformas.stage', 'Meeting')
                ->where('pm.meeting_at', '>=', $start)
                ->where('pm.meeting_at', '<', $end)
                ->select('proformas.*', 'pm.meeting_at as scheduled_at');

            if ($user->hasRole('Admin')) {
                // Admin sees all
            } elseif ($user->hasRole('Sales')) {
                $proformaQuery->whereHas('lead', function ($q) use ($user) {
                    $q->where('branch_id', $user->branch_id);
                });
            } else {
                $proformaQuery->whereHas('lead', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }

            $proformaMeetings = $proformaQuery->get()->map(function ($proforma) use ($tz) {
                $lead = $proforma->lead;
                return [
                    'type'        => 'Proforma',
                    'reference'   => $proforma->proforma_no ?: 'PF-' . str_pad($proforma->id, 5, '0', STR_PAD_LEFT),
                    'lead_id'     => $lead->id ?? null,
                    'name'        => $lead->name ?? data_get($proforma->customer, 'company_name') ?? 'Client',
                    'phone'       => $lead->phone ?? null,
                    'salesperson' => $lead->userlead->name ?? 'Unassigned',
                    'meeting_at'  => Carbon::parse($proforma->scheduled_at, $tz)->toDateTimeString(),
                ];
            });
        }

        $meetings = $leadMeetings->concat($proformaMeetings)
            ->sortBy('meeting_at')
            ->values();

        return response()->json([
            'status'  => true,
            'message' => "Today's meetings retrieved successfully.",
            'data'    => [
                'date'     => $today->toDateString(),
                'total'    => $meetings->count(),
                'meetings' => $meetings,
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Sales Pipeline  (matches web's salespipeline)
    // GET /api/leads/pipeline
    // ─────────────────────────────────────────────────────────────────────────
    public function pipeline(Request $request)
    {
        $user = $request->user();

        $leadDbStages = [
            'New Lead',
            'Meeting',
            'Proposal Pending',
            'Proforma Pending',
            'Proposal Sent',
            'Negotiation',
            'Payment Waiting',
            'Won',
            'Lost',
        ];

        $visibleStageNames = $this->visiblePipelineStages($user);

        $leadQuery = Lead::with(['userlead:id,name', 'leadcat:id,title'])
            ->where('status', 'accept')
            ->whereIn('stage', array_intersect($leadDbStages, $visibleStageNames));

        if ($user->hasRole('Admin')) {
            // Admin sees all
        } elseif ($user->hasRole('Sales')) {
            $leadQuery->where('branch_id', $user->branch_id);
        } else {
            $leadQuery->where('user_id', $user->id);
        }

        if ($request->filled('stage')) {
            $leadQuery->where('stage', $request->stage);
        }

        $leads = $leadQuery->latest()->get();

        // Group by stage
        $grouped = [];
        foreach ($visibleStageNames as $stage) {
            $stageLeads = $leads->where('stage', $stage)->values();
            $grouped[$stage] = [
                'stage' => $stage,
                'count' => $stageLeads->count(),
                'leads' => $stageLeads,
            ];
        }

        return response()->json([
            'status'  => true,
            'message' => 'Sales pipeline retrieved successfully.',
            'data'    => [
                'stages'   => $visibleStageNames,
                'pipeline' => $grouped,
            ],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Lead Transfer History
    // GET /api/leads/{id}/transfers
    // ─────────────────────────────────────────────────────────────────────────
    public function transfers(Request $request, $id)
    {
        $user = $request->user();

        $leadQuery = Lead::query();
        if (!$user->hasRole('Admin')) {
            $leadQuery->where('user_id', $user->id);
        }
        $lead = $leadQuery->findOrFail($id);

        $transfers = DB::table('lead_transfers as lt')
            ->leftJoin('users as old_user', 'old_user.id', '=', 'lt.from_user_id')
            ->join('users as new_user', 'new_user.id', '=', 'lt.to_user_id')
            ->join('users as actor_user', 'actor_user.id', '=', 'lt.transferred_by')
            ->where('lt.lead_id', $lead->id)
            ->select(
                'lt.id',
                'lt.lead_id',
                'lt.source',
                'lt.reason',
                'lt.created_at',
                'old_user.name as from_user_name',
                'new_user.name as to_user_name',
                'actor_user.name as transferred_by_name'
            )
            ->orderByDesc('lt.id')
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Transfer history retrieved successfully.',
            'data'    => [
                'lead_id'   => $lead->id,
                'transfers' => $transfers,
            ],
        ]);
    }

    private function pipelineStageNames()
    {
        return [
            'New Lead',
            'Meeting',
            'Proposal Pending',
            'Proforma Pending',
            'Send Proforma',
            'Proposal Sent',
            'Negotiation',
            'Payment Waiting',
            'Won',
            'Lost',
        ];
    }

    private function visiblePipelineStages($user)
    {
        $stages = $this->pipelineStageNames();

        if ($user->hasRole('Admin') || !$user->hasRole('Sales')) {
            return $stages;
        }

        $configured = DB::table('sales_pipeline_stage_permissions')
            ->where('user_id', $user->id)
            ->get(['stage', 'is_allowed']);

        // An untouched Sales account sees every stage.
        if ($configured->isEmpty()) {
            return $stages;
        }

        return $configured->where('is_allowed', 1)
            ->pluck('stage')
            ->intersect($stages)
            ->values()
            ->all();
    }

    public function quotationCategories()
    {
        $categories = DB::table('quotation_categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Quotation categories fetched successfully.',
            'data' => $categories
        ]);
    }

    public function detailedQuotations(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['sometimes', 'nullable', 'integer', 'exists:quotation_categories,id'],
        ]);

        $query = DB::table('detailed_quotations')
            ->select('id', 'name', 'category_id', 'service_id', 'price', 'quotation_type')
            ->orderByDesc('id');

        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        $quotations = $query->get()->map(function ($item) {
            $item->pdf_url = URL::temporarySignedRoute(
                'detailed-quotations.public-share',
                now()->addDays(7),
                ['quotation' => $item->id]
            );
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Detailed proposals fetched successfully.',
            'data' => $quotations,
        ]);
    }

    public function sendDetailedQuotation(Request $request, $id)
    {
        $validated = $request->validate([
            'detailed_quotation_id' => [
                'required',
                'integer',
                'exists:detailed_quotations,id'
            ],
        ]);

        $user = $request->user();

        $lead = Lead::findOrFail($id);

        // Check lead access
        if (
            !$user->hasRole('Admin') &&
            (int) $lead->user_id !== (int) $user->id
        ) {
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to update this lead.'
            ], 403);
        }

        $detailedQuotation = DB::table('detailed_quotations')
            ->where('id', $validated['detailed_quotation_id'])
            ->first();

        if (!$detailedQuotation) {
            return response()->json([
                'status' => false,
                'message' => 'Detailed quotation not found.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            // Create quotation record
            $quotation = Quotation::create([
                'lead_id' => $lead->id,
                'user_id' => $user->id,
                'quotation_type' => 'detailed',
                'create_date' => now()->toDateString(),
                'note' => 'Detailed Quotation: ' . $detailedQuotation->name,
            ]);

            // Create quotation item
            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'description' => 0,
                'custom_description' => $detailedQuotation->name,
                'quantity' => 1,
                'unit_price' => 0,
            ]);

            // Generate 7-day signed URL
            $pdfUrl = URL::temporarySignedRoute(
                'detailed-quotations.public-share',
                now()->addDays(7),
                ['quotation' => $detailedQuotation->id]
            );

            $quotationNumber = 'QT-' . str_pad($quotation->id, 5, '0', STR_PAD_LEFT);

            // Save lead action
            LeadAction::create([
                'lead_id' => $lead->id,
                'user_id' => $user->id,
                'action_type' => 'quotation_shared',
                'action_label' => 'Detailed Quotation Shared',
                'call_count' => 0,
                'quotation_id' => $quotation->id,
                'note' => 'Detailed quotation ' . $quotationNumber . ' shared: ' . $detailedQuotation->name,
                'meta' => [
                    'quotation_number' => $quotationNumber,
                    'quotation_id' => $quotation->id,
                    'detailed_quotation_id' => $detailedQuotation->id,
                    'detailed_quotation_name' => $detailedQuotation->name,
                    'channel' => 'whatsapp',
                    'pdf_url' => $pdfUrl,
                ],
                'action_at' => now(),
            ]);

            // Update lead status
            $lead->status = 'detailed-quotation';
            $lead->pending_call_action = false;
            $lead->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Detailed quotation generated successfully.',
                'data' => [
                    'quotation_id' => $quotation->id,
                    'quotation_no' => $quotationNumber,
                    'detailed_quotation_id' => $detailedQuotation->id,
                    'quotation_name' => $detailedQuotation->name,
                    'lead_id' => $lead->id,
                    'lead_status' => $lead->status,
                    'pdf_url' => $pdfUrl,
                    'whatsapp_url' => 'https://wa.me/?text=' . urlencode(
                        "Hello, please find your quotation here: " . $pdfUrl
                    ),
                ],
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Mobile detailed quotation error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Unable to generate detailed quotation.'
            ], 500);
        }
    }
}   