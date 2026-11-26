@extends('index')

@push('title', get_phrase('Support Ticket Details'))

@push('css')

<style>

    #cs-ticket-view {

        --cv-brand:#137d83; --cv-accent:#15aebb; --cv-ink:#282828;

        --cv-muted:#617575; --cv-line:#deebeb; --cv-soft:#eaf6f6;

        background:#f4f8f8; color:var(--cv-ink); 

        /* padding:24px; */

        border-radius:20px; margin:18px 0; min-width:0; line-height:1.5;

    }

    #cs-ticket-view *, #cs-ticket-view *::before, #cs-ticket-view *::after { box-sizing:border-box; }

    #cs-ticket-view [hidden] { display:none !important; }

    #cs-ticket-view :is(button,input,textarea) { font:inherit; }

    #cs-ticket-view :is(a,button,input,textarea):focus-visible { outline:3px solid var(--cv-accent); outline-offset:3px; }

    #cs-ticket-view a { text-decoration:none; }

    #cs-ticket-view .cv-crumb { display:flex; flex-wrap:wrap; gap:9px; font-size:12px; color:var(--cv-muted); margin-bottom:22px; }

    #cs-ticket-view .cv-crumb a { color:var(--cv-muted); }

    #cs-ticket-view .cv-header { display:flex; justify-content:space-between; align-items:flex-start; gap:20px; margin-bottom:23px; }

    #cs-ticket-view .cv-heading { min-width:0; }

    #cs-ticket-view .cv-eyebrow { color:var(--cv-brand); font-size:11px; letter-spacing:.13em; font-weight:700; margin:0 0 8px; }

    #cs-ticket-view h1 { font-size:clamp(23px,2.6vw,31px); font-weight:700; line-height:1.3; letter-spacing:-.035em; color:var(--cv-ink); margin:0; overflow-wrap:anywhere; }

    #cs-ticket-view .cv-header-meta { display:flex; flex-wrap:wrap; align-items:center; gap:10px; margin-top:12px; color:var(--cv-muted); font-size:12px; }

    #cs-ticket-view .cv-number { color:var(--cv-brand); font-weight:700; font-variant-numeric:tabular-nums; }

    #cs-ticket-view .cv-actions { display:flex; flex-wrap:wrap; gap:9px; }

    #cs-ticket-view .cv-button { display:inline-flex; align-items:center; justify-content:center; gap:8px; min-height:40px; border:1px solid var(--cv-line); border-radius:9px; padding:9px 13px; background:#fff; color:var(--cv-ink); cursor:pointer; font-size:12px; font-weight:600; white-space:nowrap; }

    #cs-ticket-view .cv-button:hover { background:var(--cv-soft); }

    #cs-ticket-view .cv-primary { background:var(--cv-brand); border-color:var(--cv-brand); color:#fff; }

    #cs-ticket-view .cv-primary:hover { background:#0c666c; color:#fff; }

    #cs-ticket-view .cv-button:disabled { opacity:.5; cursor:not-allowed; }

    #cs-ticket-view .cv-layout { display:grid; grid-template-columns:minmax(0,1fr) 300px; align-items:start; gap:20px; }

    #cs-ticket-view .cv-conversation { background:#fff; border:1px solid var(--cv-line); border-radius:16px; overflow:hidden; min-width:0; }

    #cs-ticket-view .cv-conversation-head { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; padding:18px 22px; border-bottom:1px solid var(--cv-line); }

    #cs-ticket-view .cv-conversation-title { display:flex; align-items:center; gap:11px; }

    #cs-ticket-view .cv-icon { width:39px; height:39px; border-radius:11px; display:grid; place-items:center; background:var(--cv-soft); color:var(--cv-brand); font-size:18px; }

    #cs-ticket-view h2 { font-size:15px; font-weight:700; margin:0; color:var(--cv-ink); }

    #cs-ticket-view .cv-small { font-size:11px; color:var(--cv-muted); margin:3px 0 0; }

    #cs-ticket-view .cv-refresh-info { padding:9px 22px; border-bottom:1px solid #edf2f2; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; font-size:10px; color:var(--cv-muted); }

    #cs-ticket-view .cv-refresh-info [data-failed="true"] { color:#a22c41; }

    #cs-ticket-view .cv-chat { height:480px; height:clamp(320px,53vh,620px); overflow-y:auto; overscroll-behavior:contain; scrollbar-width:thin; scrollbar-color:#bad6d6 transparent; padding:22px; 

        /* background:#f8fbfb;  */

    }

    #cs-ticket-view .cv-day { display:flex; align-items:center; gap:12px; margin:7px 0 22px; font-size:10px; color:var(--cv-muted); text-align:center; }

    #cs-ticket-view .cv-day::before, #cs-ticket-view .cv-day::after { content:''; height:1px; flex:1; background:#e3eded; }

    #cs-ticket-view .cv-message { display:flex; align-items:flex-start; gap:9px; margin:0 0 20px; }

    #cs-ticket-view .cv-message.cv-mine { flex-direction:row-reverse; }

    #cs-ticket-view .cv-avatar { width:32px; height:32px; flex:0 0 32px; display:grid; place-items:center; border-radius:10px; color:#476566; background:#e5eeee; font-size:11px; font-weight:700; }

    #cs-ticket-view .cv-mine .cv-avatar { background:#d9eeee; color:var(--cv-brand); }

    #cs-ticket-view .cv-message-body { max-width:min(82%,600px); min-width:0; }

    #cs-ticket-view .cv-message-meta { display:flex; gap:7px; flex-wrap:wrap; align-items:center; font-size:10px; color:var(--cv-muted); margin-bottom:6px; }

    #cs-ticket-view .cv-message-meta strong { color:#365051; font-size:11px; overflow-wrap:anywhere; }

    #cs-ticket-view .cv-mine .cv-message-meta { justify-content:flex-end; }

    #cs-ticket-view .cv-bubble { background:#fff; color:#344849; border:1px solid #e0eaea; border-radius:0 13px 13px 13px; padding:12px 14px; }

    #cs-ticket-view .cv-mine .cv-bubble { background:#e6f5f4; border-color:#c4e4e2; border-radius:13px 0 13px 13px; }

    #cs-ticket-view .cv-message-text { white-space:pre-wrap; overflow-wrap:anywhere; font-size:13px; line-height:1.75; margin:0; }

    #cs-ticket-view .cv-message-time { display:block; color:var(--cv-muted); font-size:9px; margin-top:7px; }

    #cs-ticket-view .cv-mine .cv-message-time { text-align:right; }

    #cs-ticket-view .cv-file-link { display:flex; align-items:center; gap:8px; color:var(--cv-brand); background:#ffffffb3; border:1px solid #d2e6e6; padding:10px; border-radius:8px; margin-top:9px; font-size:11px; overflow-wrap:anywhere; }

    #cs-ticket-view .cv-file-link:hover { text-decoration:underline; }

    #cs-ticket-view .cv-image { display:block; width:220px; max-width:100%; height:150px; object-fit:contain; border:1px solid #dce8e8; border-radius:8px; background:#f2f7f7; margin-top:10px; }

    #cs-ticket-view .cv-empty { text-align:center; color:var(--cv-muted); font-size:13px; padding:65px 16px; }

    #cs-ticket-view .cv-new-message { display:block; margin:10px auto; }

    #cs-ticket-view .cv-compose { padding:19px 22px; border-top:1px solid var(--cv-line); }

    #cs-ticket-view .cv-compose label { display:block; font-size:12px; font-weight:600; color:#3d5555; margin-bottom:9px; }

    #cs-ticket-view .cv-editor { border:1px solid #cbdede; background:#fff; border-radius:11px; overflow:hidden; }

    #cs-ticket-view .cv-editor:focus-within { border-color:var(--cv-brand); }

    #cs-ticket-view .cv-editor textarea { display:block; width:100%; min-height:106px; max-height:260px; padding:13px 14px; border:0; resize:vertical; font-size:13px; line-height:1.7; color:var(--cv-ink); background:transparent; }

    #cs-ticket-view .cv-editor textarea:focus-visible { outline-offset:-3px; }

    #cs-ticket-view .cv-editor textarea::placeholder { color:#718787; }

    #cs-ticket-view .cv-compose-tools { border-top:1px solid #edf2f2; padding:10px; display:flex; justify-content:space-between; flex-wrap:wrap; align-items:center; gap:10px; background:#fcfefe; }

    #cs-ticket-view .cv-selected-file { display:flex; align-items:center; gap:8px; background:var(--cv-soft); border:1px solid #cce4e4; padding:8px 10px; border-radius:8px; margin-top:10px; font-size:11px; }

    #cs-ticket-view .cv-selected-file span { flex:1; min-width:0; overflow-wrap:anywhere; }

    #cs-ticket-view .cv-remove { background:transparent; color:#934052; border:0; border-radius:6px; padding:7px; cursor:pointer; font-size:11px; }

    #cs-ticket-view .cv-feedback { padding:11px 13px; border:1px solid #ecd0d6; background:#fff4f6; color:#993347; border-radius:9px; font-size:12px; margin:12px 0 0; white-space:pre-line; }

    #cs-ticket-view .cv-success { background:#ebf7f1; border-color:#cce6d9; color:#26664a; }

    #cs-ticket-view .cv-closed { display:flex; align-items:center; gap:12px; background:#edf7f3; padding:19px 22px; border-top:1px solid #d5e9df; color:#26664a; font-size:12px; }

    #cs-ticket-view .cv-sidebar { display:grid; gap:16px; }

    #cs-ticket-view .cv-card { background:#fff; border:1px solid var(--cv-line); border-radius:15px; padding:19px; min-width:0; }

    #cs-ticket-view .cv-card h2 { padding-bottom:14px; border-bottom:1px solid #edf2f2; margin-bottom:15px; }

    #cs-ticket-view .cv-ticket-card { background:#263737; border-color:#263737; color:#fff; }

    #cs-ticket-view .cv-ticket-card .cv-small { color:#bfd0d0; }

    #cs-ticket-view .cv-ticket-card .cv-number { color:#8be0e4; font-size:24px; margin:7px 0 12px; overflow-wrap:anywhere; }

    #cs-ticket-view .cv-badge { display:inline-flex; align-items:center; gap:6px; padding:5px 9px; border-radius:7px; font-size:10px; font-weight:600; }

    #cs-ticket-view .cv-badge::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; }

    #cs-ticket-view .cv-teal { color:#116970; background:#e0f3f3; }

    #cs-ticket-view .cv-amber { color:#885500; background:#fff2d8; }

    #cs-ticket-view .cv-green { color:#216345; background:#e6f5ed; }

    #cs-ticket-view .cv-red { color:#a32e42; background:#ffedf0; }

    #cs-ticket-view .cv-neutral { color:#5b6c6c; background:#edf2f2; }

    #cs-ticket-view .cv-details { margin:0; display:grid; gap:16px; }

    #cs-ticket-view .cv-detail { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; }

    #cs-ticket-view .cv-detail dt { font-size:11px; color:var(--cv-muted); font-weight:400; }

    #cs-ticket-view .cv-detail dd { text-align:right; font-size:12px; color:#344c4c; margin:0; max-width:65%; overflow-wrap:anywhere; }

    #cs-ticket-view .cv-requester { display:flex; gap:10px; align-items:flex-start; }

    #cs-ticket-view .cv-requester div { min-width:0; }

    #cs-ticket-view .cv-requester strong { display:block; font-size:12px; overflow-wrap:anywhere; }

    #cs-ticket-view .cv-requester p { overflow-wrap:anywhere; }

    #cs-ticket-view .cv-close-button { width:100%; color:#a03648; border-color:#ebccd3; margin-top:13px; }

    #cs-ticket-view .cv-close-button:hover { background:#fff1f3; }

    #cs-ticket-view .cv-alert { padding:12px 15px; margin-bottom:16px; background:#fff2f4; border:1px solid #edcbd3; border-radius:10px; color:#a23349; font-size:12px; }

    @media(max-width:1100px) { #cs-ticket-view .cv-layout { grid-template-columns:minmax(0,1fr) 260px; gap:14px; } #cs-ticket-view .cv-header { flex-direction:column; } }

    @media(max-width:860px) { #cs-ticket-view .cv-layout { grid-template-columns:1fr; } #cs-ticket-view .cv-sidebar { grid-template-columns:repeat(2,minmax(0,1fr)); } }

    @media(max-width:520px) { #cs-ticket-view { padding:12px; } #cs-ticket-view .cv-sidebar { grid-template-columns:1fr; } #cs-ticket-view .cv-chat { padding:14px; } #cs-ticket-view .cv-conversation-head, #cs-ticket-view .cv-compose { padding:15px; } #cs-ticket-view .cv-message-body { max-width:calc(100% - 41px); } #cs-ticket-view .cv-editor textarea { font-size:16px; } }

</style>

@endpush

@section('content')

@php

    $ticket->loadMissing(['message.sender', 'raised']);

    $timezone = config('app.timezone', 'UTC');

    $status = strtolower($ticket->status ?? 'open');

    $closed = $status === 'closed';

    $priority = strtolower($ticket->priority ?? 'medium');

    $statusClasses = ['open'=>'cv-teal', 'in_progress'=>'cv-amber', 'closed'=>'cv-green'];

    $priorityClasses = ['low'=>'cv-green', 'medium'=>'cv-amber', 'high'=>'cv-red', 'urgent'=>'cv-red'];

    $ticketNumber = $ticket->ticket_no ? '#' . $ticket->ticket_no : get_phrase('Not assigned');

    $created = $ticket->created_at ? \Carbon\Carbon::parse($ticket->created_at)->timezone($timezone) : null;

    $requester = $ticket->raised;

    $departmentName = DB::table('support_departments')->where('id', $ticket->getRawOriginal('department'))->value('name');

    // The public folder is the web root for uploaded files.

    $attachmentBase = rtrim(asset(''), '/') . '/';

    $originalFile = $ticket->file ? basename(str_replace(chr(92), '/', $ticket->file)) : null;

    $originalFileUrl = $originalFile ? asset('uploads/file/support/' . rawurlencode($originalFile)) : null;

    // Only expose the message fields needed by this interface.

    $initialMessages = $ticket->message->sortBy('id')->values()->map(function ($message) {

        return [

            'id' => $message->id,

            'sender_id' => $message->sender_id,

            'sender_type' => $message->sender_type,

            'sender' => ['name' => optional($message->sender)->name ?? get_phrase('Unknown user')],

            'message' => $message->message,

            'attachment' => $message->attachment,

            'created_at' => $message->created_at ? $message->created_at->toIso8601String() : null,

        ];

    });

@endphp

<div id="cs-ticket-view">

    <nav class="cv-crumb" aria-label="{{ get_phrase('Breadcrumb') }}">

        <a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a><span aria-hidden="true">/</span>

        <a href="{{ route('admin.support.index') }}">{{ get_phrase('Support') }}</a><span aria-hidden="true">/</span>

        <span aria-current="page">{{ get_phrase('Ticket details') }}</span>

    </nav>

    {{-- <header class="cv-header">

        <div class="cv-heading">

            <p class="cv-eyebrow">CODE SPARROW / {{ get_phrase('SUPPORT DESK') }}</p>

            <h1>{{ $ticket->subject }}</h1>

            <div class="cv-header-meta">

                <span class="cv-number">{{ $ticketNumber }}</span>

                <span data-ticket-status class="cv-badge {{ $statusClasses[$status] ?? 'cv-neutral' }}">{{ get_phrase(ucfirst(str_replace('_', ' ', $status))) }}</span>

                <span>{{ get_phrase('Created') }} {{ $created ? $created->format('d M Y, h:i A') : '—' }}</span>

            </div>

        </div>

        <div class="cv-actions">

            <a class="cv-button" href="{{ route('admin.support.index') }}"><i class="bi bi-arrow-left" aria-hidden="true"></i>{{ get_phrase('All tickets') }}</a>

            <button type="button" id="cv-add" class="cv-button cv-primary"

                data-url="{{ route('right_modal', ['view_path'=>'admin/supportTicket/add']) }}"

                data-title="{{ get_phrase('Add new support ticket') }}"><i class="bi bi-plus-lg" aria-hidden="true"></i>{{ get_phrase('New ticket') }}</button>

        </div>

    </header> --}}

    @if(session('success'))<div class="cv-alert cv-success" role="status">{{ session('success') }}</div>@endif

    @if(session('error'))<div class="cv-alert" role="alert">{{ session('error') }}</div>@endif

    @if($errors->any())<div class="cv-alert" role="alert">{{ $errors->first() }}</div>@endif

    <div id="cv-page-error" class="cv-alert" role="alert" hidden></div>

    <div class="cv-layout">

        <section class="cv-conversation" aria-labelledby="cv-conversation-title">

            <div class="cv-conversation-head">

                <div class="cv-conversation-title">

                    <span class="cv-icon"><i class="bi bi-chat-left-text" aria-hidden="true"></i></span>

                    <div><h2 id="cv-conversation-title">{{ get_phrase('Conversation') }}</h2><p class="cv-small"><span id="cv-message-count">{{ $initialMessages->count() }}</span> {{ get_phrase('messages in this ticket') }}</p></div>

                </div>

                <button type="button" id="cv-refresh" class="cv-button"><i class="bi bi-arrow-clockwise" aria-hidden="true"></i>{{ get_phrase('Refresh') }}</button>

            </div>

            <div class="cv-refresh-info"><span id="cv-sync" role="status">{{ get_phrase('Showing saved messages') }}</span><span>{{ get_phrase('Auto-refresh: every 3 seconds') }}</span></div>

            <div id="chatBox" class="cv-chat" role="log" aria-label="{{ get_phrase('Ticket messages') }}" aria-live="off" tabindex="0"></div>

            <button id="cv-jump" type="button" class="cv-button cv-new-message" hidden>{{ get_phrase('View latest messages') }} <i class="bi bi-arrow-down" aria-hidden="true"></i></button>

            <noscript><p class="cv-empty">{{ get_phrase('Enable JavaScript to display the conversation and send replies.') }}</p></noscript>

            @if(!$closed)

                <div class="cv-compose">

                    <form id="replyForm" action="{{ route('admin.support.reply') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <input type="hidden" name="support_ticket_id" value="{{ $ticket->id }}">

                        <label for="messageInput">{{ get_phrase('Your reply') }}</label>

                        <div class="cv-editor">

                            <textarea name="message" id="messageInput" rows="3" placeholder="{{ get_phrase('Write your reply with the details the team needs...') }}" aria-describedby="cv-reply-hint cv-reply-feedback"></textarea>

                            <div class="cv-compose-tools">

                                <button type="button" class="cv-button" id="cv-attach"><i class="bi bi-paperclip" aria-hidden="true"></i>{{ get_phrase('Attach file') }}</button>

                                <input type="file" name="attachment" id="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" hidden>

                                <button type="submit" id="cv-send" class="cv-button cv-primary"><i class="bi bi-send" aria-hidden="true"></i><span id="cv-send-label">{{ get_phrase('Send reply') }}</span></button>

                            </div>

                        </div>

                        <div id="cv-selected" class="cv-selected-file" hidden><i class="bi bi-file-earmark" aria-hidden="true"></i><span id="fileName"></span><button type="button" id="cv-remove" class="cv-remove">{{ get_phrase('Remove') }}</button></div>

                        <p id="cv-reply-hint" class="cv-small">{{ get_phrase('JPG, PNG, PDF, DOC, DOCX · Max 10 MB. Send a message or an attachment.') }}</p>

                        <div id="cv-reply-feedback" class="cv-feedback" role="status" aria-live="polite" hidden></div>

                    </form>

                </div>

            @else

                <div class="cv-closed"><i class="bi bi-lock-fill" aria-hidden="true"></i><div><strong>{{ get_phrase('This ticket is closed') }}</strong><p class="cv-small">{{ get_phrase('You can read the conversation. Create a new ticket if you need more help.') }}</p></div></div>

            @endif

        </section>

        <aside class="cv-sidebar" aria-label="{{ get_phrase('Ticket information') }}">

            <section class="cv-card cv-ticket-card">

                <p class="cv-small">{{ get_phrase('TICKET REFERENCE') }}</p>

                <div class="cv-number">{{ $ticketNumber }}</div>

                <span data-ticket-status class="cv-badge {{ $statusClasses[$status] ?? 'cv-neutral' }}">{{ get_phrase(ucfirst(str_replace('_', ' ', $status))) }}</span>

            </section>

            <section class="cv-card">

                <h2>{{ get_phrase('Ticket overview') }}</h2>

                <dl class="cv-details">

                    <div class="cv-detail"><dt>{{ get_phrase('Department') }}</dt><dd>{{ $departmentName ?? get_phrase('Unassigned') }}</dd></div>

                    <div class="cv-detail"><dt>{{ get_phrase('Priority') }}</dt><dd><span class="cv-badge {{ $priorityClasses[$priority] ?? 'cv-neutral' }}">{{ get_phrase(ucfirst($priority)) }}</span></dd></div>

                    <div class="cv-detail"><dt>{{ get_phrase('Created date') }}</dt><dd>{{ $created ? $created->format('d M Y') : '—' }}</dd></div>

                    <div class="cv-detail"><dt>{{ get_phrase('Created time') }}</dt><dd>{{ $created ? $created->format('h:i A') : '—' }}</dd></div>

                    <div class="cv-detail"><dt>{{ get_phrase('Timezone') }}</dt><dd>{{ $timezone }}</dd></div>

                </dl>

            </section>

            <section class="cv-card">

                <h2>{{ get_phrase('Requested by') }}</h2>

                <div class="cv-requester">

                    <span class="cv-avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(optional($requester)->name ?? '?', 0, 1)) }}</span>

                    <div><strong>{{ optional($requester)->name ?? get_phrase('Unknown user') }}</strong><p class="cv-small">{{ optional($requester)->email ?? '—' }}</p></div>

                </div>

            </section>

            @if($originalFileUrl)

                <section class="cv-card"><h2>{{ get_phrase('Original attachment') }}</h2><a class="cv-file-link" href="{{ $originalFileUrl }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-file-earmark-arrow-down" aria-hidden="true"></i>{{ $originalFile }}</a><p class="cv-small">{{ get_phrase('Uploaded when this ticket was created.') }}</p></section>

            @endif

            @if(!$closed)

                <section class="cv-card">

                    <h2>{{ get_phrase('Finish this conversation') }}</h2>

                    <p class="cv-small">{{ get_phrase('Close the ticket when no further reply is needed. Any unsent reply will be discarded.') }}</p>

                    <form id="cv-close-form" action="{{ route('admin.support.closeTicket', $ticket->id) }}" method="POST">

                        @csrf

                        <button id="cv-close" type="submit" class="cv-button cv-close-button"><i class="bi bi-check2-circle" aria-hidden="true"></i>{{ get_phrase('Close ticket') }}</button>

                    </form>

                </section>

            @endif

        </aside>

    </div>

</div>

@endsection

@push('js')

@php

    // Precompute values before passing a simple variable to Blade's JSON directive.

    $supportViewConfig = [

        'initial' => $initialMessages,

        'userId' => (string) auth()->id(),

        'fetchUrl' => route('admin.support.fetch', $ticket->id),

        'attachmentBase' => $attachmentBase,

        'timezone' => $timezone,

        'words' => [

            'unknown' => get_phrase('Unknown user'),

            'you' => get_phrase('You'),

            'team' => get_phrase('Support team'),

            'requester' => get_phrase('Requester'),

            'noMessages' => get_phrase('No messages yet. Start the conversation below.'),

            'noDate' => get_phrase('Date unavailable'),

            'attachment' => get_phrase('Attachment'),

            'checking' => get_phrase('Checking for messages...'),

            'updated' => get_phrase('Messages updated'),

            'refreshError' => get_phrase('Could not refresh. Your current conversation is still visible.'),

            'sessionError' => get_phrase('Access or session expired. Reload the page to continue.'),

            'empty' => get_phrase('Please write a message or attach a file.'),

            'fileError' => get_phrase('Choose a JPG, PNG, PDF, DOC or DOCX file up to 10 MB.'),

            'sending' => get_phrase('Sending...'),

            'send' => get_phrase('Send reply'),

            'sent' => get_phrase('Reply sent.'),

            'progress' => get_phrase('In progress'),

            'sendError' => get_phrase('Could not confirm the reply. Refresh the conversation before trying again.'),

            'invalid' => get_phrase('Please check your reply and attachment.'),

            'close' => get_phrase('Close this ticket? Any unsent reply will be discarded.'),

            'modal' => get_phrase('The ticket form could not open. Please refresh the page and try again.'),

        ],

    ];

@endphp

<script>

(() => {

    'use strict';

    function init() {

        const root = document.getElementById('cs-ticket-view');

        if (!root || root.dataset.initialized) return;

        root.dataset.initialized = 'true';

        const get = id => root.querySelector('#' + id);

        const chat = get('chatBox'), form = get('replyForm');

        const config = @json($supportViewConfig);

        const initial = config.initial;

        const userId = config.userId;

        const fetchUrl = config.fetchUrl;

        const attachmentBase = config.attachmentBase;

        const timezone = config.timezone;

        const words = config.words;

        const dayFormat = new Intl.DateTimeFormat('en-GB', {day:'2-digit',month:'short',year:'numeric',timeZone:timezone});

        const timeFormat = new Intl.DateTimeFormat('en-GB', {hour:'2-digit',minute:'2-digit',hour12:true,timeZone:timezone});

        let signature = '', loading = null, sending = false, timer = null, stopped = false;

        const node = (tag, className, text) => {

            const element = document.createElement(tag);

            if (className) element.className = className;

            if (text !== undefined) element.textContent = String(text);

            return element;

        };

        function safeAttachment(path) {

            if (!path) return null;

            path = String(path).replace(/\\/g, '/').replace(/^\/+/, '').replace(/^public\//i, '');

            if (!/^uploads\/(?:support|file\/support)\/[^/]+$/i.test(path)) return null;

            return attachmentBase + path.split('/').map(encodeURIComponent).join('/');

        }

        function bottom() { chat.scrollTop = chat.scrollHeight; get('cv-jump').hidden = true; }

        function render(messages, forceBottom = false) {

            const rows = messages.map(message => ({

                id:message.id, sender_id:message.sender_id, sender_type:message.sender_type,

                sender:{name:message.sender?.name || words.unknown}, message:message.message || '',

                attachment:message.attachment || '', created_at:message.created_at || null

            }));

            const nextSignature = JSON.stringify(rows);

            if (signature === nextSignature) { if (forceBottom) bottom(); return; }

            const nearBottom = chat.scrollHeight - chat.scrollTop - chat.clientHeight < 90;

            const oldTop = chat.scrollTop, fragment = document.createDocumentFragment();

            let previousDay = '';

            if (!rows.length) fragment.appendChild(node('p','cv-empty',words.noMessages));

            rows.forEach(message => {

                const date = message.created_at ? new Date(message.created_at) : null;

                const validDate = date && !Number.isNaN(date.getTime());

                const day = validDate ? dayFormat.format(date) : words.noDate;

                if (day !== previousDay) { fragment.appendChild(node('div','cv-day',day)); previousDay = day; }

                const mine = String(message.sender_id) === userId;

                const article = node('article','cv-message' + (mine ? ' cv-mine' : ''));

                const avatar = node('span','cv-avatar',Array.from(message.sender.name)[0]?.toUpperCase() || '?');

                avatar.setAttribute('aria-hidden','true');

                const body = node('div','cv-message-body'), meta = node('div','cv-message-meta');

                meta.append(node('strong','',message.sender.name), node('span','',mine ? words.you : (message.sender_type === 'agent' ? words.team : words.requester)));

                const bubble = node('div','cv-bubble');

                if (message.message) bubble.appendChild(node('p','cv-message-text',message.message));

                const url = safeAttachment(message.attachment);

                if (url) {

                    const filename = message.attachment.split('/').pop().replace(/^\d+_/, '');

                    const ext = filename.split('.').pop().toLowerCase();

                    if (['jpg','jpeg','png','gif','webp'].includes(ext)) {

                        const imageLink = node('a'); imageLink.href = url; imageLink.target = '_blank'; imageLink.rel = 'noopener noreferrer';

                        const image = node('img','cv-image'); image.src = url; image.alt = filename || words.attachment; image.loading = 'lazy';

                        imageLink.appendChild(image); bubble.appendChild(imageLink);

                    }

                    const link = node('a','cv-file-link',filename || words.attachment);

                    link.href = url; link.target = '_blank'; link.rel = 'noopener noreferrer'; bubble.appendChild(link);

                }

                body.append(meta,bubble);

                const time = node('time','cv-message-time',validDate ? timeFormat.format(date) : words.noDate);

                if (validDate) { time.dateTime = date.toISOString(); time.title = day + ' ' + timeFormat.format(date) + ' (' + timezone + ')'; }

                body.appendChild(time); article.append(avatar,body); fragment.appendChild(article);

            });

            chat.replaceChildren(fragment); signature = nextSignature;

            get('cv-message-count').textContent = String(rows.length);

            if (forceBottom || nearBottom) bottom();

            else { chat.scrollTop = oldTop; get('cv-jump').hidden = false; }

        }

        async function refresh(forceBottom = false) {

            if (loading) { await loading; if (!forceBottom) return; }

            get('cv-refresh').disabled = true;

            get('cv-sync').textContent = words.checking;

            loading = (async () => {

                const controller = new AbortController();

                const timeout = setTimeout(() => controller.abort(), 15000);

                try {

                    const response = await fetch(fetchUrl, {headers:{Accept:'application/json'}, credentials:'same-origin', cache:'no-store', signal:controller.signal});

                    if ([401,403,419].includes(response.status)) { stopped = true; throw new Error(words.sessionError); }

                    if (!response.ok) throw new Error(words.refreshError);

                    const data = await response.json();

                    if (!Array.isArray(data)) throw new Error(words.refreshError);

                    render(data,forceBottom);

                    get('cv-sync').textContent = words.updated;

                    get('cv-sync').dataset.failed = 'false';

                } catch(error) {

                    get('cv-sync').textContent = stopped ? words.sessionError : words.refreshError;

                    get('cv-sync').dataset.failed = 'true';

                } finally { clearTimeout(timeout); }

            })();

            try { await loading; } finally { loading = null; get('cv-refresh').disabled = false; }

        }

        function schedule() {

            clearTimeout(timer);

            if (stopped) return;

            timer = setTimeout(async () => {

                if (!document.hidden && !sending) await refresh();

                schedule();

            },3000);

        }

        render(initial,true);

        schedule();

        get('cv-refresh').addEventListener('click', () => { if (!sending) refresh(); });

        get('cv-jump').addEventListener('click',bottom);

        chat.addEventListener('scroll', () => { if (chat.scrollHeight-chat.scrollTop-chat.clientHeight < 90) get('cv-jump').hidden = true; });

        window.addEventListener('pagehide', () => { stopped = true; clearTimeout(timer); });

        window.addEventListener('pageshow', event => { if (event.persisted) { stopped = false; schedule(); } });

        if (get('cv-add')) get('cv-add').addEventListener('click', () => {

            const button = get('cv-add');

            if (typeof window.showRightModal === 'function') window.showRightModal(button.dataset.url,button.dataset.title);

            else { get('cv-page-error').textContent = words.modal; get('cv-page-error').hidden = false; }

        });

        if (get('cv-close-form')) get('cv-close-form').addEventListener('submit', event => {

            if (sending || !window.confirm(words.close)) event.preventDefault();

        });

        if (!form) return;

        const input = get('messageInput'), file = get('attachment'), feedback = get('cv-reply-feedback');

        function notify(text, success = false) {

            feedback.textContent = text; feedback.hidden = !text;

            feedback.classList.toggle('cv-success',success);

        }

        function updateFile() {

            const selected = file.files[0];

            get('cv-selected').hidden = !selected;

            get('fileName').textContent = selected ? selected.name + ' (' + (selected.size/1024/1024).toFixed(2) + ' MB)' : '';

        }

        get('cv-attach').addEventListener('click', () => file.click());

        file.addEventListener('change',updateFile);

        get('cv-remove').addEventListener('click', () => { file.value = ''; updateFile(); });

        function busy(value) {

            sending = value; input.readOnly = value; file.disabled = value;

            ['cv-send','cv-attach','cv-remove','cv-close','cv-refresh'].forEach(id => { if (get(id)) get(id).disabled = value; });

            get('cv-send-label').textContent = value ? words.sending : words.send;

            form.setAttribute('aria-busy',String(value));

        }

        form.addEventListener('submit', async event => {

            event.preventDefault(); if (sending) return;

            const text = input.value.trim(), selected = file.files[0];

            if (!text && !selected) { notify(words.empty); input.focus(); return; }

            if (selected && (selected.size > 10 * 1024 * 1024 || !/\.(jpe?g|png|pdf|docx?)$/i.test(selected.name))) { notify(words.fileError); return; }

            const data = new FormData(form); data.set('message',text);

            busy(true); notify('');

            try {

                const response = await fetch(form.action,{method:'POST',body:data,headers:{Accept:'application/json'},credentials:'same-origin'});

                const result = await response.json().catch(() => null);

                if (!response.ok) {

                    if ([401,403,419].includes(response.status)) { stopped = true; throw new Error(words.sessionError); }

                    if (response.status === 422) {

                        const errors = result?.errors ? Object.values(result.errors).flat().join('\n') : words.invalid;

                        throw new Error(errors);

                    }

                    throw new Error(words.sendError);

                }

                if (result?.success !== true) throw new Error(words.sendError);

                input.value = ''; file.value = ''; updateFile(); notify(words.sent,true);

                // Your supplied reply controller sets the status to in_progress.

                root.querySelectorAll('[data-ticket-status]').forEach(badge => { badge.className = 'cv-badge cv-amber'; badge.textContent = words.progress; });

                await refresh(true);

            } catch(error) { notify(error instanceof TypeError ? words.sendError : error.message); }

            finally { busy(false); }

        });

    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded',init,{once:true});

    else init();

})();

</script>

@endpush



