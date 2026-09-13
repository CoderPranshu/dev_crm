<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmoduleReviewRequest;
use App\Models\ProjectSubModule;
use App\Models\SubmoduleReview;
use App\Services\ModuleStatusCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
            $newStatus = $validated['decision'] === 'Approved'
                ? 'Approved'
                : 'Changes Requested';

            SubmoduleReview::create([
                'project_sub_module_id' => $submodule->id,
                'reviewed_by' => auth()->id(),
                'decision' => $validated['decision'],
                'remarks' => $validated['remarks'] ?? null,
                'review_round' => $submodule->nextReviewRound(),
            ]);

            $submodule->status = $newStatus;
            $submodule->last_reviewed_at = now();
            $submodule->last_reviewed_by = auth()->id();
            $submodule->updated_by = auth()->id();
            $submodule->save();

            ModuleStatusCalculator::recalculate($submodule->module);
        });

        return back()->with(
            'success',
            $validated['decision'] === 'Approved'
                ? 'Sub module approved.'
                : 'Changes requested. The developer has been sent back to work on this sub module.'
        );
    }

    /**
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
