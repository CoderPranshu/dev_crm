<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketMessage;
use App\Support\SubscriptionDomainAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class SupportController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:support-tickets', ['only' => ['index']]);
    }

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $supports = SupportTicket::latest()->get();
        } else {
            $supports = SupportTicket::where('rasised_by', auth()->id())->latest()->get();
        }

        return view('admin.supportTicket.index', compact('supports'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'              => 'required|string|max:255',
            'subscription_item_id' => 'required|integer|exists:subscription_items,id',
            'message'              => 'required|string',
            'file'                 => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        // Resolve the selected option on the server. The dropdown's item ID
        // identifies a subscription and domain, without trusting a typed name.
        $domain = SubscriptionDomainAccess::domainItemsFor(auth()->user())
            ->where('item.id', $data['subscription_item_id'])
            ->select('item.subscription_id', 'item.domain_name')
            ->first();

        if (!$domain || trim((string) $domain->domain_name) === '') {
            throw ValidationException::withMessages([
                'subscription_item_id' => 'Please select an available subscription domain.',
            ]);
        }

        $filename = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid('support_') . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/file/support');

            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
        }

        $ticket = DB::transaction(function () use ($data, $domain, $filename) {
            // Explicit assignments also work with the model's current $fillable.
            $ticket = new SupportTicket();
            $ticket->priority = 'medium';
            $ticket->rasised_by = auth()->id();
            $ticket->subject = $data['subject'];
            $ticket->department = null;
            $ticket->subscription_id = $domain->subscription_id;
            $ticket->domain_name = trim((string) $domain->domain_name);
            $ticket->status = 'open';
            $ticket->file = $filename;
            $ticket->save();

            SupportTicketMessage::create([
                'support_ticket_id' => $ticket->id,
                'sender_id'         => auth()->id(),
                'sender_type'       => auth()->user()->role === 'admin' ? 'agent' : 'user',
                'message'           => $data['message'],
            ]);

            return $ticket;
        });

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
                extra: [
                    'ticket_no' => $ticket->ticket_no,
                ]
            );
        }

        foreach ($mailRecipients as $user) {
            $mailData = [
                'subject' => 'Support Ticket #' . $ticket->ticket_no,
                'name'    => $user->name,
                'message' => 'A new support ticket has been created.'
                    . ' Ticket Number: #' . $ticket->ticket_no
                    . '. Subject: ' . $ticket->subject
                    . '. Priority: ' . ucfirst($ticket->priority) . '.',
            ];

            Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
        }

        return redirect()->back()->with(
            'success',
            'Support ticket #' . $ticket->ticket_no . ' created successfully.'
        );
    }

    public function show($id)
    {
        $ticket = SupportTicket::with(['message.sender'])->findOrFail($id);

        return view('admin.supportTicket.view', compact('ticket'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'support_ticket_id' => 'required',
            'message' => 'nullable',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $attachment = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/support'), $fileName);
            $attachment = 'uploads/support/' . $fileName;
        }

        SupportTicketMessage::create([
            'support_ticket_id' => $request->support_ticket_id,
            'sender_id' => auth()->id(),
            'sender_type' => auth()->user()->role == 'admin' ? 'agent' : 'user',
            'message' => $request->message,
            'attachment' => $attachment,
        ]);

        SupportTicket::where('id', $request->support_ticket_id)
            ->update(['status' => 'in_progress']);

        return response()->json(['success' => true]);
    }

    public function fetchMessages($id)
    {
        return SupportTicketMessage::with('sender')
            ->where('support_ticket_id', $id)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function closeTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->status = 'closed';
        $ticket->save();

        return redirect()->back()->with('success', 'Support ticket closed successfully');
    }
}



