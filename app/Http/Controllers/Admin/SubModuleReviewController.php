<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmoduleReviewRequest;
use App\Models\ProjectSubModule;
use App\Models\SubmoduleReview;
use App\Services\ModuleStatusCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;

/**
 * Handles the Lead Developer / Admin side of the review flow:
 * Approve or Request Changes on a single submodule, with a mandatory
 * remark on rejection and a permanent history row either way.
 *
 * Deliberately separate from ProjectSubModuleController — that
 * controller is the DEVELOPER'S surface (status updates while working);
 * this one is the REVIEWER'S surface (approve / reject). Keeping them
 * apart makes the permission boundary obvious and avoids accidentally
 * widening what a developer's endpoint can do.
 */
class SubModuleReviewController extends Controller
{
    /**
     * Submit a review decision for a submodule that is currently
     * "Ready For Review".
     */
    // public function store(StoreSubmoduleReviewRequest $request, ProjectSubModule $submodule): RedirectResponse
    // {
    //     $this->authorizeReviewer($submodule);

    //     abort_unless(
    //         $submodule->status === 'Ready For Review',
    //         409,
    //         'Only sub modules currently "Ready For Review" can be reviewed.'
    //     );

    //     $validated = $request->validated();

    //     DB::transaction(function () use ($submodule, $validated) {
    //         $newStatus = $validated['decision'] === 'Approved'
    //             ? 'Approved'
    //             : 'Changes Requested';

    //         SubmoduleReview::create([
    //             'project_sub_module_id' => $submodule->id,
    //             'reviewed_by' => auth()->id(),
    //             'decision' => $validated['decision'],
    //             'remarks' => $validated['remarks'] ?? null,
    //             'review_round' => $submodule->nextReviewRound(),
    //         ]);

    //         $submodule->status = $newStatus;
    //         $submodule->last_reviewed_at = now();
    //         $submodule->last_reviewed_by = auth()->id();
    //         $submodule->updated_by = auth()->id();
    //         $submodule->save();

    //         ModuleStatusCalculator::recalculate($submodule->module);
    //     });

    //     return back()->with(
    //         'success',
    //         $validated['decision'] === 'Approved'
    //             ? 'Sub module approved.'
    //             : 'Changes requested. The developer has been sent back to work on this sub module.'
    //     );
    // }

    public function store(StoreSubmoduleReviewRequest $request, ProjectSubModule $submodule): RedirectResponse
    {

        $this->authorizeReviewer($submodule);

        abort_unless(
            $submodule->status === 'Ready For Review',
            409,
            'Only sub modules currently "Ready For Review" can be reviewed.'
        );

        $validated = $request->validated();

        DB::transaction(function () use ($submodule, $validated) {

            $isApproved = $validated['decision'] === 'Approved';

            $newStatus = $isApproved
                ? 'Approved'
                : 'Changes Requested';

            $newProgress = $isApproved
                ? 100
                : 50;

            SubmoduleReview::create([
                'project_sub_module_id' => $submodule->id,
                'reviewed_by' => auth()->id(),
                'decision' => $validated['decision'],
                'remarks' => $validated['remarks'] ?? null,
                'review_round' => $submodule->nextReviewRound(),
            ]);

            $submodule->status = $newStatus;
            $submodule->progress = $newProgress;
            $submodule->last_reviewed_at = now();
            $submodule->last_reviewed_by = auth()->id();
            $submodule->updated_by = auth()->id();
            $submodule->save();

            $this->sendSubmoduleReviewNotification(
                $submodule,
                $validated['decision'],
                $validated['remarks'] ?? null,
                auth()->user()
            );

            ModuleStatusCalculator::recalculate($submodule->module);
        });

        return back()->with(
            'success',
            $validated['decision'] === 'Approved'
                ? 'Sub module approved and progress set to 100%.'
                : 'Changes requested and progress set to 50%. The developer has been sent back to work on this sub module.'
        );
    }

    private function sendSubmoduleReviewNotification(
    ProjectSubModule $submodule,
    string $decision,
    ?string $remarks,
    User $reviewedBy
    ): void {

        $module = $submodule->module;
        $project = $module->project;

        // Assigned developer
        $developer = User::find($submodule->assigned_to);

        // Testing ke liye
        if (!$developer) {
            \Log::warning('Submodule review notification: Developer not found', [
                'submodule_id' => $submodule->id,
                'assigned_to' => $submodule->assigned_to,
            ]);

            return;
        }

        $submoduleName = $submodule->sub_module_name
            ?? $submodule->sub_module_name
            ?? 'Task';

        $title = $decision === 'Approved'
            ? 'Task Approved'
            : 'Changes Requested';

        $message = $decision === 'Approved'
            ? 'Task "' . $submoduleName . '" has been approved by ' . $reviewedBy->name . '.'
            : 'Changes have been requested for task "' . $submoduleName . '" by ' . $reviewedBy->name . '.';

        $developer->notify(
            new SystemNotification(
                $title,
                $message,
                'submodule_review',
                route('admin.projects.show', $project->id),
                [
                    'project_id'       => $project->id,
                    'project_name'     => $project->project_name,

                    'module_id'        => $module->id,
                    'module_name'      => $module->module_name,

                    'submodule_id'     => $submodule->id,
                    'submodule_name'   => $submoduleName,

                    'decision'         => $decision,
                    'remarks'          => $remarks,

                    'reviewed_by'      => $reviewedBy->id,
                    'reviewed_by_name' => $reviewedBy->name,

                    'message_type'     => 'submodule_review',
                ],
                'notification.mp3'
            )
        );
    }

    /**z
     * Read-only review history for a single submodule (oldest -> newest),
     * for the "Review History" panel in the submodule detail view.
     */
    public function history(ProjectSubModule $submodule)
    {
        $submodule->load(['reviews.reviewer', 'module.project']);

        $this->authorizeViewer($submodule);

        return view('admin.projects.submodules.review-history', [
            'submodule' => $submodule,
            'reviews' => $submodule->reviews,
        ]);
    }

    /**
     * Only Admin, or the Lead Developer of the submodule's project, may
     * review. Matches the authorization pattern already used elsewhere
     * in this codebase (project->assigned_to === auth()->id()).
     */
    private function authorizeReviewer(ProjectSubModule $submodule): void
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            return;
        }

        $isLeadDeveloper = $submodule->module->project->assigned_to === $user->id;

        abort_unless($isLeadDeveloper, 403, 'Only the Lead Developer or Admin can review sub modules.');
    }

    /**
     * Slightly wider than authorizeReviewer(): the assigned developer may
     * also read their own submodule's review history, just not submit
     * new reviews.
     */
    private function authorizeViewer(ProjectSubModule $submodule): void
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            return;
        }

        $isLeadDeveloper = $submodule->module->project->assigned_to === $user->id;
        $isAssignedDeveloper = $submodule->assigned_to === $user->id;

        abort_unless(
            $isLeadDeveloper || $isAssignedDeveloper,
            403,
            'You are not authorized to view this review history.'
        );
    }
}
