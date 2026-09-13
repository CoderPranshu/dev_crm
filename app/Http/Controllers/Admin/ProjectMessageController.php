<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

use App\Models\User;


use App\Models\ProjectMessage;
use App\Models\ProjectMessageFile;
use Illuminate\Support\Facades\DB;

use App\Notifications\SystemNotification;

use Illuminate\Support\Str;



class ProjectMessageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:project-view');
    // }




    public function index(Project $project)
    {
        $user = auth()->user();

        // Admin
        if ($user->hasRole('Admin')) {

            // Allow

        }

        // Lead Developer
        elseif (
            $project->assigned_to == $user->id
        ) {

            // Allow

        }

        // End Customer
        elseif (
            // $project->client_user_id == $user->id
            auth()->user()->email == $project->email
        ) {

            // Allow

        }

        else {

            abort(403);

        }

        $messages = $project->messages()
            ->with([
                'sender',
                'files',
            ])
            ->latest()
            ->get()
            ->reverse();

        return view(
            'admin.projects.chat.index',
            compact(
                'project',
                'messages'
            )
        );
    }

    // public function store(Request $request, Project $project)
    // {
    //     // $user = auth()->user();

    //     $user = auth()->user();

    //     $isAdmin = $user->hasRole('Admin');
    //     $isLead = $project->assigned_to == $user->id;
    //     $isCustomer = $project->email == $user->email;

    //     if (!($isAdmin || $isLead || $isCustomer)) {
    //         abort(403, 'Unauthorized');
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Authorization
    //     |--------------------------------------------------------------------------
    //     */

    //     // if (
    //     //     !$user->hasRole('Admin') &&
    //     //     $project->assigned_to != $user->id &&
    //     //     $project->client_user_id != $user->id
    //     // ) {
    //     //     abort(403);
    //     // }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Validation
    //     |--------------------------------------------------------------------------
    //     */

    //     $request->validate([

    //         'message' => 'nullable|string',

    //         'files.*' => 'nullable|file|max:51200', // 50 MB

    //     ]);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Message OR File Required
    //     |--------------------------------------------------------------------------
    //     */

    //     if (
    //         !$request->filled('message') &&
    //         !$request->hasFile('files')
    //     ) {
    //         return back()->with('error', 'Please enter a message or select a file.');
    //     }

    //     DB::beginTransaction();

    //     try {

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Save Message
    //         |--------------------------------------------------------------------------
    //         */

    //         $message = ProjectMessage::create([

    //             'project_id' => $project->id,

    //             'sender_id' => $user->id,

    //             'sender_type' => $project->assigned_to == $user->id
    //                 ? 'lead'
    //                 : 'customer',

    //             'message' => $request->message,

    //         ]);

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Upload Files
    //         |--------------------------------------------------------------------------
    //         */

    //         if ($request->hasFile('files')) {

    //             foreach ($request->file('files') as $file) {

    //                 $originalName = $file->getClientOriginalName();

    //                 $extension = $file->getClientOriginalExtension();

    //                 $mime = $file->getMimeType();

    //                 $size = $file->getSize();

    //                 $fileName = time().'_'.uniqid().'.'.$extension;

    //                 $file->move(
    //                     public_path('uploads/project-chat'),
    //                     $fileName
    //                 );

    //                 ProjectMessageFile::create([

    //                     'project_message_id' => $message->id,

    //                     'original_name' => $originalName,

    //                     'file_name' => $fileName,

    //                     'file_path' => 'uploads/project-chat/'.$fileName,

    //                     'mime_type' => $mime,

    //                     'file_size' => $size,

    //                 ]);

    //             }

    //         }

    //         // Notification
    //         $this->sendProjectMessageNotification($project, $user, $request, $message);

    //         DB::commit();

    //         return back()->with('success', 'Message sent successfully.');

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return back()->with('error', $e->getMessage());

    //     }
    // }


    // private function sendProjectMessageNotification(
    // Project $project,
    // User $user,
    // Request $request,
    // ProjectMessage $message
    // ): void {
    //     $notificationMessage = $request->filled('message')
    //         ? \Illuminate\Support\Str::limit(
    //             $request->message,
    //             100
    //         )
    //         : 'You received a new file in the project chat.';

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Lead / Admin -> Customer
    //     |--------------------------------------------------------------------------
    //     */

    //     if (
    //         $user->hasRole('Admin') ||
    //         $project->assigned_to == $user->id
    //     ) {

    //         $customer = User::where(
    //             'email',
    //             $project->email
    //         )->first();

    //         if ($customer && $customer->id != $user->id) {

    //             $customer->notify(
    //                 new SystemNotification(
    //                     'New Project Message',
    //                     $notificationMessage,
    //                     'project_message',
    //                     route(
    //                         'admin.projects.show',
    //                         $project->id
    //                     ),
    //                     [
    //                         'project_id' => $project->id,
    //                         'project_name' => $project->name ?? 'Project',
    //                         'sender_id' => $user->id,
    //                         'sender_name' => $user->name,
    //                         'message_id' => $message->id,
    //                     ]
    //                 )
    //             );
    //         }
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Customer -> Lead
    //     |--------------------------------------------------------------------------
    //     */

    //     if ($project->email == $user->email) {

    //         $lead = User::find(
    //             $project->assigned_to
    //         );

    //         if ($lead && $lead->id != $user->id) {

    //             $lead->notify(
    //                 new SystemNotification(
    //                     'New Customer Message',
    //                     $notificationMessage,
    //                     'project_message',
    //                     route(
    //                         'admin.projects.show',
    //                         $project->id
    //                     ),
    //                     [
    //                         'project_id' => $project->id,
    //                         'project_name' => $project->name ?? 'Project',
    //                         'sender_id' => $user->id,
    //                         'sender_name' => $user->name,
    //                         'message_id' => $message->id,
    //                     ]
    //                 )
    //             );
    //         }
    //     }
    // }

    public function store(Request $request, Project $project)
    {
        $user = auth()->user();

        $isAdmin = $user->hasRole('Admin');
        $isLead = $project->assigned_to == $user->id;
        $isCustomer = $project->email == $user->email;

        if (!($isAdmin || $isLead || $isCustomer)) {
            abort(403, 'Unauthorized');
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'message' => 'nullable|string',
            'files.*' => 'nullable|file|max:51200',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Message OR File Required
        |--------------------------------------------------------------------------
        */

        if (
            !$request->filled('message') &&
            !$request->hasFile('files')
        ) {
            return back()->with(
                'error',
                'Please enter a message or select a file.'
            );
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Save Message
            |--------------------------------------------------------------------------
            */

            $message = ProjectMessage::create([

                'project_id' => $project->id,

                'sender_id' => $user->id,

                'sender_type' => $project->assigned_to == $user->id
                    ? 'lead'
                    : 'customer',

                'message' => $request->message,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Upload Files
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('files')) {

                foreach ($request->file('files') as $file) {

                    $originalName = $file->getClientOriginalName();

                    $extension = $file->getClientOriginalExtension();

                    $mime = $file->getMimeType();

                    $size = $file->getSize();

                    $fileName = time() . '_' . uniqid() . '.' . $extension;

                    $file->move(
                        public_path('uploads/project-chat'),
                        $fileName
                    );

                    ProjectMessageFile::create([

                        'project_message_id' => $message->id,

                        'original_name' => $originalName,

                        'file_name' => $fileName,

                        'file_path' => 'uploads/project-chat/' . $fileName,

                        'mime_type' => $mime,

                        'file_size' => $size,

                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Notification
            |--------------------------------------------------------------------------
            */

            $notificationMessage = $request->filled('message')
                ? \Illuminate\Support\Str::limit(
                    $request->message,
                    100
                )
                : 'You received a new file in the project chat.';

            /*
            |--------------------------------------------------------------------------
            | Lead -> Customer
            |--------------------------------------------------------------------------
            */

            if ($isLead || $isAdmin) {

                $customer = User::where('email', $project->email)->first();

                if ($customer && $customer->id != $user->id) {

                    $customer->notify(
                        new SystemNotification(
                            'New Project Message',
                            $notificationMessage,
                            'project_message',
                            route('admin.projects.show', $project->id),
                            [
                                'project_id' => $project->id,
                                'project_name' => $project->name ?? 'Project',
                                'sender_id' => $user->id,
                                'sender_name' => $user->name,
                                'message_id' => $message->id,
                            ]
                        )
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Customer -> Lead
            |--------------------------------------------------------------------------
            */

            if ($isCustomer) {

                $lead = User::find($project->assigned_to);

                if ($lead && $lead->id != $user->id) {

                    $lead->notify(
                        new SystemNotification(
                            'New Customer Message',
                            $notificationMessage,
                            'project_message',
                            route('admin.projects.show', $project->id),
                            [
                                'project_id' => $project->id,
                                'project_name' => $project->name ?? 'Project',
                                'sender_id' => $user->id,
                                'sender_name' => $user->name,
                                'message_id' => $message->id,
                            ]
                        )
                    );
                }
            }

            DB::commit();

            return back()->with(
                'success',
                'Message sent successfully.'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

}
