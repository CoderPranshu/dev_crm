<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


use App\Mail\GenericMail;
use App\Models\SupportTicketMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;



class SupportController extends Controller
{
    /**
     * Get support tickets.
     */
    // public function index(Request $request): JsonResponse
    // {
    //     $user = $request->user();

    //     $query = SupportTicket::query()->latest();

    //     // Admin को सभी tickets मिलेंगी।
    //     // दूसरे users को सिर्फ उनकी अपनी tickets मिलेंगी।
    //     if ($user->role !== 'admin') {
    //         $query->where('rasised_by', $user->id);
    //     }

    //     $supports = $query->get();

    //     return response()->json([
    //         'status'  => true,
    //         'message' => 'Support tickets fetched successfully.',
    //         'data'    => $supports,
    //     ], 200);
    // }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // केवल department relation load होगा
        $query = SupportTicket::query()
            ->with('department')
            ->latest();

        if ($user->role !== 'admin') {
            $query->where('rasised_by', $user->id);
        }

        $supports = $query->get();

        return response()->json([
            'status'  => true,
            'message' => 'Support tickets fetched successfully.',
            'data'    => $supports,
        ], 200);
    }

    // 

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'department' => [
                'required',
                'integer',
                'exists:support_departments,id',
            ],
            'message' => [
                'required',
                'string',
            ],
            'file' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:10240',
            ],
        ]);

        $filename = null;
        $uploadedFilePath = null;

        try {
            /*
             * Upload attachment
             */
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $filename = 'support_' . Str::uuid() . '.' .
                    $file->getClientOriginalExtension();

                $destination = public_path('uploads/file/support');

                File::ensureDirectoryExists(
                    $destination,
                    0755,
                    true
                );

                $file->move($destination, $filename);

                $uploadedFilePath = $destination . DIRECTORY_SEPARATOR .
                    $filename;
            }

            /*
             * Create ticket and first message together
             */
            $ticket = DB::transaction(function () use (
                $data,
                $filename,
                $user
            ) {
                $ticket = SupportTicket::create([
                    'priority'   => 'medium',
                    'rasised_by' => $user->id,
                    'subject'    => $data['subject'],
                    'department' => $data['department'],
                    'status'     => 'open',
                    'file'       => $filename,
                ]);

                SupportTicketMessage::create([
                    'support_ticket_id' => $ticket->id,
                    'sender_id'         => $user->id,
                    'sender_type'       => $user->role === 'admin'
                        ? 'agent'
                        : 'user',
                    'message'           => $data['message'],
                ]);

                return $ticket;
            });

            /*
             * Send system and email notifications.
             * Notification failure ticket creation को प्रभावित नहीं करेगी।
             */
            try {
                $this->sendTicketNotifications($ticket);
            } catch (Throwable $exception) {
                Log::error('Support ticket notification failed.', [
                    'ticket_id' => $ticket->id,
                    'error'     => $exception->getMessage(),
                ]);
            }

            // केवल department relation response में load होगा
            $ticket->load('department');

            return response()->json([
                'status'  => true,
                'message' => 'Support ticket #' .
                    $ticket->ticket_no .
                    ' created successfully.',
                'data' => [
                    'ticket' => $ticket,
                    'file_url' => $filename
                        ? asset('uploads/file/support/' . $filename)
                        : null,
                ],
            ], 201);
        } catch (Throwable $exception) {
            /*
             * Database operation fail होने पर uploaded file delete करें।
             */
            if (
                $uploadedFilePath &&
                File::exists($uploadedFilePath)
            ) {
                File::delete($uploadedFilePath);
            }

            Log::error('Support ticket creation failed.', [
                'user_id' => $user->id,
                'error'   => $exception->getMessage(),
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Support ticket could not be created.',
            ], 500);
        }
    }

    /**
     * Send support-ticket notifications.
     */
    private function sendTicketNotifications(
        SupportTicket $ticket
    ): void {
        $systemRecipients = getNotificationRecipients(
            type: 'support',
            channel: 'system'
        );

        $mailRecipients = getNotificationRecipients(
            type: 'support',
            channel: 'mail'
        )->filter(
            fn ($user) => !empty($user->email)
        );

        if ($systemRecipients->isNotEmpty()) {
            sendSystemNotification(
                users: $systemRecipients->all(),
                title: 'New Support Ticket #' . $ticket->ticket_no,
                message: $ticket->subject,
                type: 'support',
                url: route('admin.support.show', $ticket->id),
                extra: [
                    'ticket_no' => $ticket->ticket_no,
                ]
            );
        }

        foreach ($mailRecipients as $recipient) {
            $mailData = [
                'subject' => 'Support Ticket #' .
                    $ticket->ticket_no,
                'name' => $recipient->name,
                'message' => 'A new support ticket has been created.' .
                    ' Ticket Number: #' . $ticket->ticket_no .
                    '. Subject: ' . $ticket->subject .
                    '. Priority: ' .
                    ucfirst($ticket->priority) . '.',
            ];

            Mail::to($recipient->email)
                ->queue(new GenericMail($mailData));
        }
    }

    /**
 * Display a single support ticket.
 */
    public function show(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $query = SupportTicket::query()
            ->with([
                'department',
                'message.sender',
            ]);

        // Normal user केवल अपना ticket देख सकता है
        if ($user->role !== 'admin') {
            $query->where('rasised_by', $user->id);
        }

        $ticket = $query->find($id);

        if (!$ticket) {
            return response()->json([
                'status'  => false,
                'message' => 'Support ticket not found.',
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Support ticket fetched successfully.',
            'data'    => [
                'ticket'   => $ticket,
                'file_url' => $ticket->file
                    ? asset('uploads/file/support/' . $ticket->file)
                    : null,
            ],
        ], 200);
    }

    public function reply(Request $request): JsonResponse
    {
        $data = $request->validate([
            'support_ticket_id' => 'required|integer',
            'message' => 'nullable|required_without:attachment|string',
            'attachment' => 'nullable|required_without:message|file'
                . '|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $user = $request->user();

        $query = SupportTicket::query();

        // Admin सभी tickets पर reply कर सकता है।
        // बाकी users केवल अपने tickets पर।
        if (!$user->hasRole('admin')) {
            $query->where('rasised_by', $user->id);
        }

        $ticket = $query->find($data['support_ticket_id']);

        if (!$ticket) {
            return response()->json([
                'status' => false,
                'message' => 'Support ticket not found.',
            ], 404);
        }

        $attachmentPath = null;

        try {
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $directory = public_path('uploads/support');

                File::ensureDirectoryExists($directory);

                $fileName = Str::uuid() . '.' . $file->extension();
                $file->move($directory, $fileName);

                $attachmentPath = 'uploads/support/' . $fileName;
            }

            $reply = DB::transaction(function () use (
                $ticket,
                $user,
                $data,
                $attachmentPath
            ) {
                $reply = SupportTicketMessage::create([
                    'support_ticket_id' => $ticket->id,
                    'sender_id' => $user->id,
                    'sender_type' => $user->hasRole('admin') ? 'agent' : 'user',
                    'message' => $data['message'] ?? null,
                    'attachment' => $attachmentPath,
                ]);

                $ticket->update([
                    'status' => 'in_progress',
                ]);

                return $reply;
            });
        } catch (Throwable $exception) {
            if ($attachmentPath) {
                File::delete(public_path($attachmentPath));
            }

            throw $exception;
        }

        return response()->json([
            'status' => true,
            'message' => 'Reply sent successfully.',
            'data' => [
                'reply' => $reply,
                'ticket_status' => $ticket->status,
                'attachment_url' => $attachmentPath
                    ? asset($attachmentPath)
                    : null,
            ],
        ], 201);
    }


}