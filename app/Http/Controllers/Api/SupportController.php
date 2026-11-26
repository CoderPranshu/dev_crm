<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\GenericMail;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use App\Support\SubscriptionDomainAccess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class SupportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = SupportTicket::query()->latest();

        if ($user->role !== 'admin') {
            $query->where('rasised_by', $user->id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Support tickets fetched successfully.',
            'data' => $query->get(),
        ]);
    }

    /**
     * Options for the Subscription Plan dropdown in the API ticket form.
     * One option represents one active domain within one owned subscription.
     */
    public function subscriptionDomains(Request $request): JsonResponse
    {
        $domains = SubscriptionDomainAccess::domainItemsFor($request->user())
            ->selectRaw('MIN(item.id) as id, item.subscription_id, item.domain_name, subscription.company_name')
            ->groupBy('item.subscription_id', 'item.domain_name', 'subscription.company_name')
            ->orderBy('item.domain_name')
            ->get()
            ->map(fn ($domain) => [
                'subscription_item_id' => (int) $domain->id,
                'subscription_id' => (int) $domain->subscription_id,
                'domain_name' => $domain->domain_name,
                'company_name' => $domain->company_name,
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Active subscription domains fetched successfully.',
            'data' => $domains,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:255'],
            'subscription_item_id' => ['required', 'integer'],
            'message' => ['required', 'string'],
            'file' => [
                'nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240',
            ],
            'priority' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Do not trust a domain name or subscription ID supplied by the client.
        // The shared access query enforces owner + active subscription + active domain.
        $domain = SubscriptionDomainAccess::domainItemsFor($user)
            ->where('item.id', $data['subscription_item_id'])
            ->select('item.subscription_id', 'item.domain_name')
            ->first();

        if (!$domain) {
            return $this->unavailableDomainResponse();
        }

        $filename = null;
        $uploadedFilePath = null;

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = 'support_' . Str::uuid() . '.' .
                    $file->getClientOriginalExtension();

                $destination = public_path('uploads/file/support');
                File::ensureDirectoryExists($destination, 0755, true);
                $file->move($destination, $filename);
                $uploadedFilePath = $destination . DIRECTORY_SEPARATOR . $filename;
            }

            $ticket = DB::transaction(function () use ($data, $filename, $user) {
                // Recheck at save time if the domain was disabled after form load.
                $domain = SubscriptionDomainAccess::domainItemsFor($user)
                    ->where('item.id', $data['subscription_item_id'])
                    ->select('item.subscription_id', 'item.domain_name')
                    ->lockForUpdate()
                    ->first();

                if (!$domain) {
                    throw ValidationException::withMessages([
                        'subscription_item_id' =>
                            'Please select an active domain from your subscription.',
                    ]);
                }

                // Assign explicitly: this works even when the current model's
                // fillable list does not include the new domain fields.
                $ticket = new SupportTicket();
                // $ticket->priority = 'medium';
                $ticket->priority = $data['priority'];
                $ticket->rasised_by = $user->id;
                $ticket->subject = $data['subject'];
                $ticket->department = null;
                $ticket->subscription_id = $domain->subscription_id;
                $ticket->domain_name = trim((string) $domain->domain_name);
                $ticket->status = 'open';
                $ticket->file = $filename;
                $ticket->save();

                SupportTicketMessage::create([
                    'support_ticket_id' => $ticket->id,
                    'sender_id' => $user->id,
                    'sender_type' => $user->role === 'admin' ? 'agent' : 'user',
                    'message' => $data['message'],
                ]);

                return $ticket;
            });

            // Notification errors should not roll back an already saved ticket.
            try {
                $this->sendTicketNotifications($ticket);
            } catch (Throwable $exception) {
                Log::error('Support ticket notification failed.', [
                    'ticket_id' => $ticket->id,
                    'error' => $exception->getMessage(),
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Support ticket #' . $ticket->ticket_no .
                    ' created successfully.',
                'data' => [
                    'ticket' => $ticket,
                    'file_url' => $filename
                        ? asset('uploads/file/support/' . $filename)
                        : null,
                ],
            ], 201);
        } catch (ValidationException $exception) {
            $this->deleteUploadedFile($uploadedFilePath);

            return $this->unavailableDomainResponse();
        } catch (Throwable $exception) {
            $this->deleteUploadedFile($uploadedFilePath);

            Log::error('Support ticket creation failed.', [
                'user_id' => $user->id,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Support ticket could not be created.',
            ], 500);
        }
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        $query = SupportTicket::query()->with('message.sender');

        if ($user->role !== 'admin') {
            $query->where('rasised_by', $user->id);
        }

        $ticket = $query->find($id);

        if (!$ticket) {
            return response()->json([
                'status' => false,
                'message' => 'Support ticket not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Support ticket fetched successfully.',
            'data' => [
                'ticket' => $ticket,
                'file_url' => $ticket->file
                    ? asset('uploads/file/support/' . $ticket->file)
                    : null,
            ],
        ]);
    }

    public function reply(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'support_ticket_id' => ['required', 'integer'],
            'message' => ['nullable', 'required_without:attachment', 'string'],
            'attachment' => [
                'nullable', 'required_without:message', 'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $user = $request->user();
        $query = SupportTicket::query();

        if ($user->role !== 'admin') {
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
                $ticket, $user, $data, $attachmentPath
            ) {
                $reply = SupportTicketMessage::create([
                    'support_ticket_id' => $ticket->id,
                    'sender_id' => $user->id,
                    'sender_type' => $user->role === 'admin' ? 'agent' : 'user',
                    'message' => $data['message'] ?? null,
                    'attachment' => $attachmentPath,
                ]);

                $ticket->update(['status' => 'in_progress']);

                return $reply;
            });
        } catch (Throwable $exception) {
            if ($attachmentPath) {
                File::delete(public_path($attachmentPath));
            }

            Log::error('Support ticket reply failed.', [
                'ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Reply could not be sent.',
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Reply sent successfully.',
            'data' => [
                'reply' => $reply,
                'ticket_status' => $ticket->status,
                'attachment_url' => $attachmentPath ? asset($attachmentPath) : null,
            ],
        ], 201);
    }

    private function unavailableDomainResponse(): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => [
                'subscription_item_id' => [
                    'Please select an active domain from your subscription.',
                ],
            ],
        ], 422);
    }

    private function deleteUploadedFile(?string $path): void
    {
        if ($path && File::exists($path)) {
            File::delete($path);
        }
    }

    private function sendTicketNotifications(SupportTicket $ticket): void
    {
        $systemRecipients = getNotificationRecipients(
            type: 'support',
            channel: 'system'
        );

        $mailRecipients = getNotificationRecipients(
            type: 'support',
            channel: 'mail'
        )->filter(fn ($user) => !empty($user->email));

        if ($systemRecipients->isNotEmpty()) {
            sendSystemNotification(
                users: $systemRecipients->all(),
                title: 'New Support Ticket #' . $ticket->ticket_no,
                message: $ticket->subject,
                type: 'support',
                url: route('admin.support.show', $ticket->id),
                extra: ['ticket_no' => $ticket->ticket_no]
            );
        }

        foreach ($mailRecipients as $recipient) {
            $mailData = [
                'subject' => 'Support Ticket #' . $ticket->ticket_no,
                'name' => $recipient->name,
                'message' => 'A new support ticket has been created.' .
                    ' Ticket Number: #' . $ticket->ticket_no .
                    '. Subject: ' . $ticket->subject .
                    '. Priority: ' . ucfirst($ticket->priority) . '.',
            ];

            Mail::to($recipient->email)->queue(new GenericMail($mailData));
        }
    }
}