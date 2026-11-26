<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{SupportTicket, SupportTicketMessage};
use Auth;
use Mail;

class SupportController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:support-tickets', ['only' => ['index']]);
        // $this->middleware('permission:support-ticket', ['only' => ['store']]);
        // $this->middleware('permission:support-ticket', ['only' => ['show']]);
        // $this->middleware('permission:support-ticket', ['only' => ['reply']]);
        // $this->middleware('permission:support-messages', ['only' => ['fetchMessages']]);
    }

    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $supports = SupportTicket::latest()->get();
        }else{
            $supports = SupportTicket::where('rasised_by', auth()->user()->id)->latest()->get();
        }
        return view('admin.supportTicket.index', compact('supports'));
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'department' => 'nullable',
    //         'message' => 'required',
    //         'file' => 'nullable|file'
    //     ]);

    //     $filename = null;

    //     if ($request->hasFile('file')) {
    //         $filename = uniqid() . '.' . $request->file->getClientOriginalExtension();
    //         $request->file->move(public_path('uploads/file/support/'), $filename);
    //     }

    //     $ticket = SupportTicket::create([
    //         'priority'   => 'medium',
    //         'rasised_by' => auth()->id(),
    //         'subject'    => 'Support Request',
    //         'department' => $data['department'] ?? null,
    //         'status'     => 'open',
    //         'file'       => $filename
    //     ]);

    //     SupportTicketMessage::create([
    //         'support_ticket_id' => $ticket->id,
    //         'sender_id'         => auth()->id(),
    //         'sender_type'       => 'user',
    //         'message'           => $data['message']
    //     ]);


    //     // ---------------- SYSTEM NOTIFICATION ----------------
    //     $systemRecipients = getNotificationRecipients(
    //         type: 'support',
    //         channel: 'system'
    //     );

    //     // ---------------- MAIL NOTIFICATION ----------------
    //     $mailRecipients = getNotificationRecipients(
    //         type: 'support',
    //         channel: 'mail'
    //     )->filter(fn($user) => !empty($user->email));

    //     // ---------------- SEND SYSTEM ----------------
    //     if ($systemRecipients->isNotEmpty()) {
    //         sendSystemNotification(
    //             users: $systemRecipients->all(),
    //             title: 'Support request',
    //             message: 'New Support Request Created',
    //             type: 'support',
    //             url: route('admin.support.index'),
    //             extra: []
    //         );
    //     }

    //     // ---------------- SEND MAIL ----------------
    //     foreach ($mailRecipients as $user) {
    //         $mailData = [
    //             'subject' => 'Support Request',
    //             'name' => $user->name,
    //             'message' => 'A new support ticket has been created. Priority level: ' . ucfirst($ticket->priority) . '. Please review and take necessary action.',
    //         ];

    //         Mail::to($user->email)->queue(new \App\Mail\GenericMail($mailData));
    //     }

    //     return redirect()->back()->with('success', 'Support ticket created successfully');
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'    => 'required|string|max:255',
            'department' => 'required|exists:support_departments,id',
            'message'    => 'required|string',
            'file'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $filename = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filename = uniqid('support_') . '.' .
                $file->getClientOriginalExtension();

            $destination = public_path('uploads/file/support');

            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
        }

        $ticket = SupportTicket::create([
            'priority'   => 'medium',
            'rasised_by' => auth()->id(),
            'subject'    => $data['subject'],
            'department' => $data['department'],
            'status'     => 'open',
            'file'       => $filename,
        ]);

        SupportTicketMessage::create([
            'support_ticket_id' => $ticket->id,
            'sender_id'         => auth()->id(),
            'sender_type'       => auth()->user()->role === 'admin'
                ? 'agent'
                : 'user',
            'message'           => $data['message'],
        ]);

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

            Mail::to($user->email)
                ->queue(new \App\Mail\GenericMail($mailData));
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Support ticket #' . $ticket->ticket_no .
                ' created successfully.'
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
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240'
        ]);

        $attachment = null;

        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');

            $fileName = time().'_'.$file->getClientOriginalName();

            // public/uploads/support folder me save hoga
            $file->move(public_path('uploads/support'), $fileName);

            $attachment = 'uploads/support/'.$fileName;
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

        return response()->json([
            'success' => true
        ]);
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

        // dd($ticket);
        $ticket->status = 'closed';
        $ticket->save();

        return redirect()->back()->with('success', 'Support ticket closed successfully');
    }
}
