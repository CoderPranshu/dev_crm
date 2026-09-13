<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Module Review System — schema changes.
 *
 * IMPORTANT — SAFETY NOTES
 * -------------------------
 * - This migration ONLY touches `project_sub_modules` and `project_modules`.
 * - It does NOT touch requirements, project_module_assignments, projects,
 *   or any other table.
 * - Enum columns are widened (new values added), nothing is removed, so
 *   existing rows keep working with their current status untouched.
 * - Run this on a staging copy of the DB first and confirm row counts
 *   before/after are identical (see down() for a full rollback path).
 */
return new class extends Migration
{
    public function up(): void
    {
        /*
        |----------------------------------------------------------------
        | project_sub_modules
        |----------------------------------------------------------------
        | Old enum: Pending, Planning, In Progress, Testing, Completed,
        |           On Hold, Cancelled
        |
        | New enum adds: Ready For Review, Changes Requested, Approved
        |
        | NOTE: 'Completed' is kept in the enum for backward compatibility
        | with any existing rows / reports that reference it, but the
        | application will no longer set a submodule to 'Completed'
        | directly — 'Approved' is the new terminal state.
        |----------------------------------------------------------------
        */
        DB::statement("
            ALTER TABLE `project_sub_modules`
            MODIFY `status` ENUM(
                'Pending',
                'Planning',
                'In Progress',
                'Testing',
                'Ready For Review',
                'Changes Requested',
                'Approved',
                'Completed',
                'On Hold',
                'Cancelled'
            ) NOT NULL DEFAULT 'Pending'
        ");

        Schema::table('project_sub_modules', function ($table) {
            // Denormalized convenience column — who/when last reviewed.
            // Kept in sync by SubModuleReviewController; source of truth
            // for full history is always submodule_reviews.
            $table->timestamp('last_reviewed_at')->nullable()->after('deadline');
            $table->unsignedBigInteger('last_reviewed_by')->nullable()->after('last_reviewed_at');

            $table->foreign('last_reviewed_by')
                ->references('id')->on('users')
                ->nullOnDelete();
        });

        /*
        |----------------------------------------------------------------
        | project_modules
        |----------------------------------------------------------------
        | Old enum: Pending, Planning, In Progress, Testing, Completed,
        |           On Hold, Cancelled
        |
        | New enum adds: Under Review
        |
        | 'Completed' is kept as the terminal state — its MEANING changes
        | (only reachable when 100% of submodules are Approved) but the
        | value itself is unchanged, so nothing downstream that reads
        | project_modules.status === 'Completed' needs to change.
        |----------------------------------------------------------------
        */
        DB::statement("
            ALTER TABLE `project_modules`
            MODIFY `status` ENUM(
                'Pending',
                'Planning',
                'In Progress',
                'Testing',
                'Under Review',
                'Completed',
                'On Hold',
                'Cancelled'
            ) NOT NULL DEFAULT 'Pending'
        ");

        /*
        |----------------------------------------------------------------
        | submodule_reviews — append-only review history
        |----------------------------------------------------------------
        */
        Schema::create('submodule_reviews', function ($table) {
            $table->id();

            $table->unsignedBigInteger('project_sub_module_id');
            $table->foreign('project_sub_module_id', 'fk_subreview_submodule')
                ->references('id')->on('project_sub_modules')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('reviewed_by');
            $table->foreign('reviewed_by', 'fk_subreview_reviewer')
                ->references('id')->on('users')
                ->restrictOnDelete();

            $table->enum('decision', ['Approved', 'Changes Requested']);
            $table->text('remarks')->nullable();

            // 1, 2, 3... per submodule — set in the controller, not DB-generated,
            // so it stays simple and portable.
            $table->unsignedInteger('review_round')->default(1);

            $table->timestamps();

            $table->index(['project_sub_module_id', 'review_round']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submodule_reviews');

        Schema::table('project_sub_modules', function ($table) {
            $table->dropForeign(['last_reviewed_by']);
            $table->dropColumn(['last_reviewed_at', 'last_reviewed_by']);
        });

        DB::statement("
            ALTER TABLE `project_sub_modules`
            MODIFY `status` ENUM(
                'Pending',
                'Planning',
                'In Progress',
                'Testing',
                'Completed',
                'On Hold',
                'Cancelled'
            ) NOT NULL DEFAULT 'Pending'
        ");

        DB::statement("
            ALTER TABLE `project_modules`
            MODIFY `status` ENUM(
                'Pending',
                'Planning',
                'In Progress',
                'Testing',
                'Completed',
                'On Hold',
                'Cancelled'
            ) NOT NULL DEFAULT 'Pending'
        ");
    }
};
