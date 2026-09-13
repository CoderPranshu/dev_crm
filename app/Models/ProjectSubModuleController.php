<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectModule;
use App\Models\ProjectSubModule;
use App\Services\ModuleStatusCalculator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectSubModuleController extends Controller
{
    /**
     * Statuses a DEVELOPER is allowed to move a submodule into via
     * updateStatus(). 'Approved' and 'Changes Requested' are reviewer-only
     * outcomes and are deliberately excluded — they can only be set by
     * SubModuleReviewController::store().
     */
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
        $module->load([
            'project',
            'subModules.assignedTo',
        ]);

        $submodules = ProjectSubModule::with('assignedTo')
            ->where('project_module_id', $module->id)
            ->ordered()
            ->paginate(10);

        return view('admin.projects.submodules.index', compact(
            'module',
            'submodules'
        ));
    }

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

    public function store(Request $request, ProjectModule $module): RedirectResponse
    {
        abort_unless(auth()->user()->role == 'admin' || auth()->user()->role == 'lead_developer', 403);

        $validated = $request->validate([

            'sub_module_name' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

            'priority' => ['required', 'in:Low,Medium,High,Critical'],

            'estimated_hours' => ['nullable', 'numeric', 'min:0'],

            'start_date' => ['nullable', 'date'],

            'deadline' => ['nullable', 'date', 'after_or_equal:start_date'],

        ]);

        $nextSortOrder = ProjectSubModule::where('project_module_id', $module->id)->max('sort_order');

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

        // A brand-new submodule changes the module's submodule set, so the
        // module's derived status/progress needs a recalculation too
        // (covers the case where this is the module's first submodule).
        ModuleStatusCalculator::recalculate($module);

        return redirect()
            ->route('admin.projects.show', $module->project->id)
            ->with('success', 'Sub Module created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit(ProjectModule $module, ProjectSubModule $submodule): View
    {
        abort_unless(
            auth()->user()->role == 'admin' ||
                auth()->user()->role == 'lead_developer',
            403
        );

        abort_if($submodule->project_module_id != $module->id, 404);

        $this->guardNotLocked($submodule);

        return view('admin.projects.submodules.edit', [
            'module' => $module,
            'submodule' => $submodule
        ]);
    }

    public function update(Request $request, ProjectModule $module, ProjectSubModule $submodule): RedirectResponse
    {
        abort_unless(
            auth()->user()->role == 'admin' ||
                auth()->user()->role == 'lead_developer',
            403
        );

        abort_if($submodule->project_module_id != $module->id, 404);

        $this->guardNotLocked($submodule);

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

    public function destroy(ProjectModule $module, ProjectSubModule $submodule): RedirectResponse
    {
        abort_unless(
            auth()->user()->role == 'admin' ||
                auth()->user()->role == 'lead_developer',
            403
        );

        abort_if($submodule->project_module_id != $module->id, 404);

        $this->guardNotLocked($submodule);

        $submodule->delete();

        ModuleStatusCalculator::recalculate($module);

        return back()->with('success', 'Sub Module deleted successfully.');
    }

    public function status(ProjectSubModule $submodule)
    {
        abort_unless(
            $submodule->assigned_to == auth()->id(),
            403
        );

        $this->guardNotLocked($submodule);

        return view(
            'admin.projects.submodules.status',
            compact('submodule')
        );
    }

    /**
     * Developer-facing status update.
     *
     * Replaces the old inline "avg progress == 100 -> module Completed"
     * block entirely. This endpoint now only ever touches the SUBMODULE's
     * own status/progress and hands the derived MODULE status off to
     * ModuleStatusCalculator — which is the only place module status is
     * decided, per the Module Review System design.
     */
    public function updateStatus(Request $request, ProjectSubModule $subModule)
    {
        abort_unless(
            $subModule->assigned_to == auth()->id() || auth()->user()->hasRole(['Admin']),
            403,
            'You are not authorized to update this sub module.'
        );

        $this->guardNotLocked($subModule);

        $request->validate([
            'status' => ['required', 'in:' . implode(',', self::DEVELOPER_SETTABLE_STATUSES)],
        ]);

        // A submodule coming out of "Changes Requested" re-enters normal
        // dev work — any of the forward statuses (In Progress, Testing,
        // Ready For Review, etc.) are valid next steps from there, same
        // as from a fresh Pending submodule. No separate transition table
        // needed beyond "not locked" + "one of the allowed values".

        $subModule->status = $request->status;

        // Auto Progress — unchanged behavior for the pre-review states,
        // extended for the new review states.
        switch ($request->status) {

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
                $subModule->progress = 100;
                break;

            case 'On Hold':
            case 'Cancelled':
                // Leave progress as-is — pausing/cancelling isn't a
                // completion signal in either direction.
                break;

            default:
                $subModule->progress = 0;
        }

        $subModule->updated_by = auth()->id();
        $subModule->save();

        // ===============================
        // Update Parent Module (status + progress) — delegated
        // ===============================
        $module = ModuleStatusCalculator::recalculate($subModule->module);

        return response()->json([
            'success' => true,

            'submodule_progress' => $subModule->progress,
            'submodule_status' => $subModule->status,

            'module_progress' => $module->progress,
            'module_status' => $module->status,

            'project_progress' => $module->project?->progress,
        ]);
    }

    /**
     * Blocks any developer-facing mutation once a submodule has been
     * Approved by a Lead Developer / Admin. Enforced here at the
     * controller level (not just hidden in the UI) so a direct request
     * to any of these endpoints is rejected the same way.
     *
     * Only a future reopen() action (Lead/Admin only, not built yet)
     * can move a submodule out of 'Approved'.
     */
    private function guardNotLocked(ProjectSubModule $submodule): void
    {
        abort_if(
            $submodule->isLocked(),
            423,
            'This sub module has been approved and is locked. Contact your Lead Developer or Admin to reopen it.'
        );
    }
}
