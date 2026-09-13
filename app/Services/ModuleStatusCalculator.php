<?php

namespace App\Services;

use App\Models\ProjectModule;

/**
 * Derives a ProjectModule's status and progress from the state of its
 * ProjectSubModules. This is the ONLY place that should ever set
 * ProjectModule::status going forward — replaces the inline block that
 * used to live in ProjectSubModuleController::updateStatus().
 *
 * Rules (confirmed with product owner):
 *
 *   - No submodule has ever reached "Ready For Review" yet:
 *         status = Pending   (avg progress == 0)
 *         status = In Progress (avg progress > 0)
 *
 *   - At least one submodule has entered the review cycle
 *     (Ready For Review / Changes Requested / Approved):
 *         status = Completed     -> ALL submodules are Approved
 *         status = Under Review  -> anything else (mixed Ready For Review /
 *                                   Changes Requested / Approved, in any
 *                                   combination)
 *
 * Module `progress` remains a simple average of submodule progress —
 * it reflects developer completion %, independent of review outcome.
 */
class ModuleStatusCalculator
{
    private const REVIEW_CYCLE_STATUSES = [
        'Ready For Review',
        'Changes Requested',
        'Approved',
    ];

    /**
     * Recalculate and persist the module's progress + status.
     * Also cascades the recalculation up to the parent project.
     */
    public static function recalculate(ProjectModule $module): ProjectModule
    {
        // Fresh load so we're never working off a stale in-memory collection
        // (e.g. right after a submodule was just updated elsewhere).
        $subModules = $module->subModules()->get(['status', 'progress']);

        $module->progress = $subModules->isEmpty()
            ? 0
            : (int) round($subModules->avg('progress'));

        $module->status = self::deriveStatus($subModules);

        $module->save();

        self::recalculateProject($module);

        return $module;
    }

    private static function deriveStatus($subModules): string
    {
        if ($subModules->isEmpty()) {
            return 'Pending';
        }

        $inReviewCycle = $subModules->contains(
            fn ($sub) => in_array($sub->status, self::REVIEW_CYCLE_STATUSES, true)
        );

        if (! $inReviewCycle) {
            return $subModules->every(fn ($sub) => $sub->status === 'Pending')
                ? 'Pending'
                : 'In Progress';
        }

        $allApproved = $subModules->every(fn ($sub) => $sub->status === 'Approved');

        return $allApproved ? 'Completed' : 'Under Review';
    }

    /**
     * Project-level progress stays as-is (avg of module progress) —
     * untouched behavior, just re-run here so it stays in sync whenever
     * a module's progress changes as a side effect of a review.
     */
    private static function recalculateProject(ProjectModule $module): void
    {
        $project = $module->project;

        if (! $project) {
            return;
        }

        $projectProgress = (int) round(
            $project->modules()->avg('progress')
        );

        $project->progress = $projectProgress;
        $project->save();
    }
}
