<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use App\Models\RequirementComment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class RequirementCommentController extends Controller
{
    /**
     * Add a top-level comment or a reply (when parent_id is present)
     * to a requirement's discussion thread.
     */
    public function store(Request $request, Requirement $requirement): RedirectResponse
    {
        $isAssignedDeveloper = $requirement->module->assigned_to === auth()->id();
        $isLead = $requirement->module->project->assigned_to === auth()->id();
        $isAdmin = auth()->user()->hasRole('Admin');

        abort_unless($isAssignedDeveloper || $isLead || $isAdmin, 403);

        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:5000'],
            'parent_id' => ['nullable', 'exists:requirement_comments,id'],
        ]);

        // A reply's parent must belong to the same requirement.
        if (!empty($validated['parent_id'])) {
            $parentBelongsHere = RequirementComment::where('id', $validated['parent_id'])
                ->where('requirement_id', $requirement->id)
                ->exists();

            abort_unless($parentBelongsHere, 422, 'Invalid parent comment.');
        }

        DB::transaction(function () use ($requirement, $validated) {
            $comment = $requirement->comments()->create([
                'user_id' => auth()->id(),
                'parent_id' => $validated['parent_id'] ?? null,
                'comment' => $validated['comment'],
            ]);

            $requirement->timeline()->create([
                'event_type' => 'comment_added',
                'actor_id' => auth()->id(),
                'description' => auth()->user()->name . ' commented: "' . \Illuminate\Support\Str::limit($comment->comment, 80) . '"',
            ]);
        });

        return back()->with('success', 'Comment added.');
    }

    public function destroy(RequirementComment $comment): RedirectResponse
    {
        abort_unless($comment->user_id === auth()->id() || auth()->user()->hasRole('Admin'), 403);

        $comment->delete();

        return back()->with('success', 'Comment removed.');
    }
}
