<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use App\Notifications\RequirementFileUploaded;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class RequirementAttachmentController extends Controller
{
    /**
     * Upload a file against a requirement (Admin uploading credentials/hosting docs,
     * or Lead/Developer uploading supporting material). Role recorded per-file
     * so the UI can label who provided it.
     */
    public function store(Request $request, Requirement $requirement): RedirectResponse
    {
        $isAssignedDeveloper = $requirement->module->assigned_to === auth()->id();
        $isLead = $requirement->module->project->assigned_to === auth()->id();
        $isAdmin = auth()->user()->hasRole('Admin');

        abort_unless($isAssignedDeveloper || $isLead || $isAdmin, 403);

        $request->validate([
            'file' => ['required', 'file', 'max:20480', 'mimes:jpg,jpeg,png,gif,pdf,zip,xlsx,xls,doc,docx,csv'],
        ]);

        $role = $isAdmin ? 'admin' : ($isLead ? 'lead' : 'developer');

        DB::transaction(function () use ($request, $requirement, $role) {
            $file = $request->file('file');

            // IMPORTANT: read size/mime/original-name BEFORE move().
            // move() relocates the underlying tmp file, so any getSize()/
            // getClientMimeType() call AFTER move() tries to stat a path
            // that no longer exists and throws "stat failed".
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $mimeType = $file->getClientMimeType();

            $folder = "uploads/requirements/{$requirement->id}";
            $destination = public_path($folder);

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalName);
            $file->move($destination, $fileName);

            $relativePath = $folder . '/' . $fileName;

            $requirement->attachments()->create([
                'uploaded_by' => auth()->id(),
                'uploaded_by_role' => $role,
                'file_name' => $originalName,
                'file_path' => $relativePath,
                'file_size' => $fileSize,
                'mime_type' => $mimeType,
            ]);

            $requirement->timeline()->create([
                'event_type' => 'file_uploaded',
                'actor_id' => auth()->id(),
                'description' => auth()->user()->name . ' uploaded ' . $file->getClientOriginalName(),
            ]);

            // Notify the developer who raised it, unless they're the uploader.
            if ($requirement->raised_by !== auth()->id()) {
                // $requirement->raisedBy?->notify(new RequirementFileUploaded($requirement));
            }
        });

        return back()->with('success', 'File uploaded.');
    }

    public function destroy(\App\Models\RequirementAttachment $attachment): RedirectResponse
    {
        abort_unless(
            $attachment->uploaded_by === auth()->id() || auth()->user()->hasRole('Admin'),
            403
        );

        $attachment->delete();

        return back()->with('success', 'Attachment removed.');
    }
}