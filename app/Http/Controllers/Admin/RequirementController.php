<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectModule;
use App\Models\Requirement;
use App\Models\RequirementType;
use App\Models\User;
use App\Notifications\RequirementCompleted;
use App\Notifications\RequirementForwardedToAdmin;
use App\Notifications\RequirementRaised;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RequirementController extends Controller
{
    /**
     * List requirements for a single module.
     */
    public function index(ProjectModule $module): View
    {
        abort_unless(
            $module->assigned_to === auth()->id()
                || auth()->user()->hasRole('Admin')
                || $module->project->assigned_to === auth()->id(),
            403
        );

        $requirements = $module->requirements()
            ->with(['type', 'raisedBy', 'seenByUser'])
            ->latest()
            ->paginate(10);

        return view('admin.requirements.index', [
            'module' => $module,
            'requirements' => $requirements,
            'types' => RequirementType::active()->ordered()->get(),
        ]);
    }

    /**
     * Show a single requirement with full detail, timeline, comments.
     */
    public function show(Requirement $requirement): View
    {
        $isAssignedDeveloper = $requirement->module->assigned_to === auth()->id();
        $isLead = $requirement->module->project->assigned_to === auth()->id();
        $isAdmin = auth()->user()->hasRole('Admin');

        abort_unless($isAssignedDeveloper || $isLead || $isAdmin, 403);

        $requirement->load([
            'type',
            'raisedBy',
            'seenByUser',
            'completedByUser',
            'module.project',
            'timeline.actor',
            'comments.user',
            'comments.replies.user',
            'attachments.uploader',
        ]);

        return view('admin.requirements.show', [
            'requirement' => $requirement,
        ]);
    }

    /**
     * Developer raises a new requirement on a module assigned to them.
     */
    public function store(Request $request, ProjectModule $module): RedirectResponse
    {
        abort_unless(
            $module->assigned_to === auth()->id(),
            403,
            'Only the assigned developer can raise a requirement for this module.'
        );

        $validated = $request->validate([
            'requirement_type_id' => ['required', 'exists:requirement_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:Low,Medium,High,Critical'],
            'is_blocker' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($validated, $module) {
            $requirement = Requirement::create([
                ...$validated,
                'project_module_id' => $module->id,
                'raised_by' => auth()->id(),
                'is_blocker' => (bool) ($validated['is_blocker'] ?? false),
                'status' => 'Pending',
                'created_by' => auth()->id(),
            ]);

            $requirement->timeline()->create([
                'event_type' => 'raised',
                'actor_id' => auth()->id(),
                'to_status' => 'Pending',
                'description' => auth()->user()->name . ' raised requirement "' . $requirement->title . '"',
            ]);

            $leadId = $module->project->assigned_to;

            // if ($leadId) {
            //     User::find($leadId)?->notify(new RequirementRaised($requirement));
            // }
        });

        return back()->with('success', 'Requirement raised successfully.');
    }

    /**
     * Lead Developer marks a requirement as seen (WhatsApp-style read receipt).
     */
    public function markSeen(Requirement $requirement): RedirectResponse
    {
        $this->authorizeLead($requirement);

        if ($requirement->isSeen()) {
            return back();
        }

        DB::transaction(function () use ($requirement) {
            $fromStatus = $requirement->status;

            $requirement->update([
                'seen_by' => auth()->id(),
                'seen_at' => now(),
                'status' => 'Seen',
            ]);

            $requirement->timeline()->create([
                'event_type' => 'seen',
                'actor_id' => auth()->id(),
                'from_status' => $fromStatus,
                'to_status' => 'Seen',
                'description' => auth()->user()->name . ' saw this requirement',
            ]);
        });

        return back();
    }

    /**
     * Lead Developer forwards to Admin (server access, hosting, credentials, etc).
     */
    public function forwardAdmin(Requirement $requirement): RedirectResponse
    {
        $this->authorizeLead($requirement);

        DB::transaction(function () use ($requirement) {
            $fromStatus = $requirement->status;

            $requirement->update([
                'forwarded_to' => 'admin',
                'status' => 'Waiting Admin',
            ]);

            $requirement->timeline()->create([
                'event_type' => 'forwarded_admin',
                'actor_id' => auth()->id(),
                'from_status' => $fromStatus,
                'to_status' => 'Waiting Admin',
                'description' => auth()->user()->name . ' forwarded this to Admin',
            ]);

            // User::role('Admin')->get()->each->notify(new RequirementForwardedToAdmin($requirement));
        });

        return back()->with('success', 'Forwarded to Admin.');
    }

    /**
     * Lead Developer forwards to Client (logo, keys, content, images, etc).
     * No client user accounts exist yet — status/log only, per current scope.
     */
    public function forwardClient(Requirement $requirement): RedirectResponse
    {
        $this->authorizeLead($requirement);

        DB::transaction(function () use ($requirement) {
            $fromStatus = $requirement->status;

            $requirement->update([
                'forwarded_to' => 'client',
                'status' => 'Waiting Client',
            ]);

            $requirement->timeline()->create([
                'event_type' => 'forwarded_client',
                'actor_id' => auth()->id(),
                'from_status' => $fromStatus,
                'to_status' => 'Waiting Client',
                'description' => auth()->user()->name . ' forwarded this to Client',
            ]);
        });

        return back()->with('success', 'Marked as waiting on Client.');
    }

    /**
     * Lead Developer / Admin marks requirement completed.
     */
    public function complete(Requirement $requirement): RedirectResponse
    {
        $this->authorizeLead($requirement);

        DB::transaction(function () use ($requirement) {
            $fromStatus = $requirement->status;

            $requirement->update([
                'status' => 'Completed',
                'completed_at' => now(),
                'completed_by' => auth()->id(),
            ]);

            $requirement->timeline()->create([
                'event_type' => 'completed',
                'actor_id' => auth()->id(),
                'from_status' => $fromStatus,
                'to_status' => 'Completed',
                'description' => 'Requirement marked completed',
            ]);

            // $requirement->raisedBy?->notify(new RequirementCompleted($requirement));
        });

        return back()->with('success', 'Requirement completed.');
    }

    /**
     * Lead Developer / Admin rejects a requirement with a reason.
     */
    public function reject(Request $request, Requirement $requirement): RedirectResponse
    {
        $this->authorizeLead($requirement);

        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($requirement, $validated) {
            $fromStatus = $requirement->status;

            $requirement->update([
                'status' => 'Rejected',
                'rejected_at' => now(),
                'rejection_reason' => $validated['reason'],
            ]);

            $requirement->timeline()->create([
                'event_type' => 'rejected',
                'actor_id' => auth()->id(),
                'from_status' => $fromStatus,
                'to_status' => 'Rejected',
                'description' => 'Rejected: ' . $validated['reason'],
            ]);
        });

        return back()->with('success', 'Requirement rejected.');
    }

    /**
     * Lead Developer of the module's project, or Admin.
     */
    private function authorizeLead(Requirement $requirement): void
    {
        $isLead = $requirement->module->project->assigned_to === auth()->id();
        $isAdmin = auth()->user()->hasRole('Admin');

        abort_unless($isLead || $isAdmin, 403, 'Only the Lead Developer or Admin can perform this action.');
    }
}
