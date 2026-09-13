@extends('index')

@section('title','Requirement Detail')

@section('content')

@php
    $isLead = $requirement->module->project->assigned_to === auth()->id();
    $isAdmin = auth()->user()->hasRole('Admin');
    $isRaiser = $requirement->raised_by === auth()->id();
    $canAct = $isLead || $isAdmin;

    $statusColors = [
        'Pending' => 'secondary',
        'Seen' => 'info',
        'In Progress' => 'primary',
        'Waiting Admin' => 'warning',
        'Waiting Client' => 'warning',
        'Completed' => 'success',
        'Rejected' => 'danger',
    ];

    $priorityColors = [
        'Low' => 'secondary',
        'Medium' => 'info',
        'High' => 'warning',
        'Critical' => 'danger',
    ];

    $eventIcons = [
        'raised' => 'bi-flag',
        'seen' => 'bi-eye',
        'replied' => 'bi-reply',
        'forwarded_admin' => 'bi-person-badge',
        'forwarded_client' => 'bi-send',
        'file_uploaded' => 'bi-paperclip',
        'status_changed' => 'bi-arrow-repeat',
        'completed' => 'bi-check-circle',
        'rejected' => 'bi-x-circle',
        'comment_added' => 'bi-chat-dots',
    ];

    // Local-only helper for avatar initials/colors — no data change.
    $initialsOf = function ($name) {
        $parts = explode(' ', trim($name ?: '?'));
        $initials = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1));
        return $initials ?: '?';
    };
    $colorOf = function ($name) {
        $palette = ['#0F8EA3', '#16B6C8', '#6366F1', '#D97706', '#059669', '#DB2777'];
        return $palette[crc32($name ?: 'x') % count($palette)];
    };
@endphp

<style>

    .req-dashboard {
        --c-primary: #0F8EA3;
        --c-accent: #16B6C8;
        --c-bg: #F8FAFC;
        --c-border: #E5E7EB;
        --c-text: #1F2937;
        --c-muted: #6B7280;
        --c-surface: #FFFFFF;

        --c-success: #10B981;
        --c-success-bg: #ECFDF5;
        --c-danger: #EF4444;
        --c-danger-bg: #FEF2F2;
        --c-warning: #D97706;
        --c-warning-bg: #FFFBEB;
        --c-info: #2563EB;
        --c-info-bg: #EFF6FF;
        --c-secondary: #6B7280;
        --c-secondary-bg: #F1F5F9;
        --c-primary-bg: #E6F6F8;

        --radius: 14px;
        --radius-sm: 8px;
        --shadow-sm: 0 1px 2px rgba(15,23,42,.04), 0 1px 3px rgba(15,23,42,.05);
        --shadow-md: 0 8px 24px rgba(15,23,42,.07), 0 2px 6px rgba(15,23,42,.04);

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--c-text);
        background: var(--c-bg);
        padding: 28px clamp(12px, 3vw, 32px) 60px;
        border-radius: 18px;
        animation: reqFadeIn .35s ease both;
    }

    @keyframes reqFadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .req-dashboard * { box-sizing: border-box; }
    .req-dashboard a { text-decoration: none; color: inherit; }

    .req-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 999px;
        white-space: nowrap; line-height: 1.4;
    }
    .req-badge-secondary { background: var(--c-secondary-bg); color: var(--c-secondary); }
    .req-badge-info { background: var(--c-info-bg); color: var(--c-info); }
    .req-badge-primary { background: var(--c-primary-bg); color: var(--c-primary); }
    .req-badge-warning { background: var(--c-warning-bg); color: var(--c-warning); }
    .req-badge-success { background: var(--c-success-bg); color: var(--c-success); }
    .req-badge-danger { background: var(--c-danger-bg); color: var(--c-danger); }
    .req-badge-lg { font-size: 13px; padding: 6px 14px; }

    .req-btn {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 14px; font-weight: 600; padding: 10px 18px;
        border-radius: var(--radius-sm); border: 1px solid transparent;
        cursor: pointer; transition: all .15s ease; white-space: nowrap; width: 100%;
        justify-content: center;
    }
    .req-btn-primary {
        background: linear-gradient(135deg, var(--c-primary), var(--c-accent));
        color: #fff; box-shadow: var(--shadow-sm);
    }
    .req-btn-primary:hover { transform: translateY(-1px); box-shadow: var(--shadow-md); color: #fff; }
    .req-btn-outline { background: var(--c-surface); color: var(--c-text); border-color: var(--c-border); }
    .req-btn-outline:hover { border-color: var(--c-primary); color: var(--c-primary); }
    .req-btn-success-outline { background: var(--c-success-bg); color: var(--c-success); border-color: transparent; }
    .req-btn-success-outline:hover { filter: brightness(0.95); }
    .req-btn-danger-outline { background: var(--c-danger-bg); color: var(--c-danger); border-color: transparent; }
    .req-btn-danger-outline:hover { filter: brightness(0.96); }
    .req-btn-sm { padding: 8px 14px; font-size: 13px; width: auto; }

    /* ---------- Header ---------- */
    .req-breadcrumb { font-size: 13px; color: var(--c-muted); margin-bottom: 8px; font-weight: 500; }
    .req-breadcrumb a:hover { color: var(--c-primary); }

    .req-issue-header {
        background: var(--c-surface); border: 1px solid var(--c-border); border-radius: var(--radius);
        box-shadow: var(--shadow-sm); padding: 24px 26px; margin-bottom: 20px;
        position: relative; overflow: hidden;
    }
    .req-issue-header::before {
        content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
    }
    .req-issue-header.priority-low::before { background: var(--c-secondary); }
    .req-issue-header.priority-medium::before { background: var(--c-info); }
    .req-issue-header.priority-high::before { background: var(--c-warning); }
    .req-issue-header.priority-critical::before { background: var(--c-danger); }

    .req-issue-title { font-size: 23px; font-weight: 800; letter-spacing: -0.02em; margin: 0 0 12px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .req-issue-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 4px; }
    .req-issue-meta { font-size: 13px; color: var(--c-muted); font-weight: 500; }
    .req-issue-meta b { color: var(--c-text); font-weight: 600; }

    /* ---------- Grid ---------- */
    .req-issue-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
    @media (max-width: 960px) { .req-issue-grid { grid-template-columns: 1fr; } }

    .req-panel {
        background: var(--c-surface); border: 1px solid var(--c-border); border-radius: var(--radius);
        box-shadow: var(--shadow-sm); margin-bottom: 20px; overflow: hidden;
    }
    .req-panel-header {
        padding: 14px 20px; border-bottom: 1px solid var(--c-border);
        font-size: 13.5px; font-weight: 700; display: flex; align-items: center; justify-content: space-between;
    }
    .req-panel-body { padding: 20px; }

    /* ---------- Seen banner ---------- */
    .req-seen-banner {
        display: flex; align-items: center; gap: 10px; padding: 14px 20px;
        background: var(--c-surface); border: 1px solid var(--c-border); border-radius: var(--radius);
        box-shadow: var(--shadow-sm); margin-bottom: 20px; font-size: 13.5px; font-weight: 600;
    }
    .req-seen-dot {
        width: 9px; height: 9px; border-radius: 50%; background: var(--c-success); flex-shrink: 0;
        box-shadow: 0 0 0 0 rgba(16,185,129,.5); animation: reqSeenPulse 1.8s infinite;
    }
    .req-seen-dot.is-unseen { background: var(--c-muted); animation: none; }
    @keyframes reqSeenPulse {
        0% { box-shadow: 0 0 0 0 rgba(16,185,129,.45); }
        70% { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
        100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
    }
    .req-seen-banner.is-seen { color: var(--c-success); }
    .req-seen-banner.is-unseen { color: var(--c-muted); }

    /* ---------- Description ---------- */
    .req-description { font-size: 14.5px; line-height: 1.7; color: var(--c-text); white-space: pre-line; }

    /* ---------- Attachments ---------- */
    .req-file-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px; }
    .req-file-card {
        border: 1px solid var(--c-border); border-radius: var(--radius-sm); padding: 12px;
        display: flex; align-items: center; gap: 12px; transition: border-color .15s ease, box-shadow .15s ease;
    }
    .req-file-card:hover { border-color: var(--c-primary); box-shadow: var(--shadow-sm); }
    .req-file-icon {
        width: 38px; height: 38px; border-radius: 9px; background: var(--c-primary-bg); color: var(--c-primary);
        display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;
    }
    .req-file-info { min-width: 0; flex: 1; }
    .req-file-name { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .req-file-meta { font-size: 11.5px; color: var(--c-muted); margin-top: 2px; }
    .req-file-download {
        width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
        color: var(--c-muted); border: 1px solid var(--c-border); flex-shrink: 0; transition: all .15s ease;
    }
    .req-file-download:hover { color: var(--c-primary); border-color: var(--c-primary); background: var(--c-primary-bg); }
    .req-empty-inline { color: var(--c-muted); font-size: 13.5px; }

    /* ---------- Timeline ---------- */
    .req-timeline { position: relative; padding-left: 28px; }
    .req-timeline::before {
        content: ''; position: absolute; left: 13px; top: 6px; bottom: 6px; width: 2px; background: var(--c-border);
    }
    .req-timeline-item { position: relative; padding-bottom: 22px; }
    .req-timeline-item:last-child { padding-bottom: 0; }
    .req-timeline-icon {
        position: absolute; left: -28px; top: 0; width: 26px; height: 26px; border-radius: 50%;
        background: var(--c-primary-bg); color: var(--c-primary); display: flex; align-items: center; justify-content: center;
        font-size: 12px; border: 2px solid var(--c-surface); box-shadow: 0 0 0 1px var(--c-border);
    }
    .req-timeline-text { font-size: 13.5px; font-weight: 500; }
    .req-timeline-time { font-size: 11.5px; color: var(--c-muted); margin-top: 2px; font-weight: 500; }
    .req-empty-timeline { color: var(--c-muted); font-size: 13.5px; }

    /* ---------- Comments (chat style) ---------- */
    .req-avatar {
        width: 34px; height: 34px; border-radius: 50%; color: #fff; font-size: 12.5px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .req-comment { display: flex; gap: 12px; margin-bottom: 18px; }
    .req-comment-body { flex: 1; min-width: 0; }
    .req-bubble {
        background: #F8FAFC; border: 1px solid var(--c-border); border-radius: 4px 14px 14px 14px;
        padding: 12px 14px; font-size: 13.5px; line-height: 1.55;
    }
    .req-comment-head { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
    .req-comment-name { font-size: 13px; font-weight: 700; }
    .req-comment-time { font-size: 11.5px; color: var(--c-muted); font-weight: 500; }
    .req-comment-reply-link { font-size: 12px; font-weight: 600; color: var(--c-primary); margin-top: 6px; display: inline-block; }
    .req-reply { margin-left: 30px; margin-top: 10px; }

    .req-comment-form { display: flex; gap: 10px; margin-top: 6px; }
    .req-comment-form input[type=text] {
        flex: 1; border: 1px solid var(--c-border); border-radius: 999px; padding: 10px 16px;
        font-size: 13.5px; font-family: inherit;
    }
    .req-comment-form input[type=text]:focus { outline: none; border-color: var(--c-primary); box-shadow: 0 0 0 3px var(--c-primary-bg); }
    .req-comment-form button {
        border: none; background: var(--c-primary); color: #fff; border-radius: 999px; padding: 0 20px;
        font-size: 13px; font-weight: 600; cursor: pointer; transition: filter .15s ease;
    }
    .req-comment-form button:hover { filter: brightness(1.08); }

    /* ---------- Sidebar ---------- */
    .req-info-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--c-border); font-size: 13px; }
    .req-info-row:last-child { border-bottom: none; }
    .req-info-label { color: var(--c-muted); font-weight: 500; }
    .req-info-value { font-weight: 600; text-align: right; }

    .req-sidebar-actions .req-btn { margin-bottom: 8px; }
    .req-sidebar-actions .req-btn:last-child { margin-bottom: 0; }

</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="req-dashboard">

    <div class="req-breadcrumb">
        <a href="{{ route('admin.requirements.index', $requirement->module->id) }}">{{ $requirement->module->module_name }}</a>
        <span style="margin:0 4px;">/</span> Requirement #{{ $requirement->id }}
    </div>

    {{-- ========================= Issue Header ========================= --}}
    <div class="req-issue-header priority-{{ strtolower($requirement->priority) }}">

        <h1 class="req-issue-title">
            {{ $requirement->title }}
            @if($requirement->is_blocker && !in_array($requirement->status, ['Completed','Rejected']))
                <span class="req-badge req-badge-danger req-badge-lg">
                    <i class="bi bi-exclamation-triangle-fill"></i> Blocking
                </span>
            @endif
        </h1>

        <div class="req-issue-badges">
            <span class="req-badge req-badge-lg req-badge-{{ $statusColors[$requirement->status] ?? 'secondary' }}">
                {{ $requirement->status }}
            </span>
            <span class="req-badge req-badge-lg req-badge-{{ $priorityColors[$requirement->priority] ?? 'secondary' }}">
                {{ $requirement->priority }} Priority
            </span>
        </div>

        <div class="req-issue-meta" style="margin-top:12px;">
            <b>{{ $requirement->type->name ?? '-' }}</b>
            &nbsp;&middot;&nbsp; Raised by <b>{{ $requirement->raisedBy->name ?? '-' }}</b>
            &nbsp;&middot;&nbsp; {{ $requirement->created_at->format('d M Y, h:i A') }}
        </div>

    </div>

    <div class="req-issue-grid">

        {{-- ================= LEFT: Main ================= --}}
        <div class="req-issue-main">

            {{-- Seen indicator --}}
            <div class="req-seen-banner {{ $requirement->isSeen() ? 'is-seen' : 'is-unseen' }}">
                <span class="req-seen-dot {{ $requirement->isSeen() ? '' : 'is-unseen' }}"></span>
                @if($requirement->isSeen())
                    Seen by {{ $requirement->seenByUser->name ?? '-' }} on {{ optional($requirement->seen_at)->format('d M Y \a\t h:i A') }}
                @else
                    Not yet seen by Lead Developer
                @endif
            </div>

            {{-- Description --}}
            <div class="req-panel">
                <div class="req-panel-header">Description</div>
                <div class="req-panel-body">
                    <p class="req-description mb-0">{{ $requirement->description ?: 'No description provided.' }}</p>
                </div>
            </div>

            {{-- Attachments --}}
            <div class="req-panel">
                <div class="req-panel-header">
                    Attachments
                    @if($canAct)
                        <button class="req-btn req-btn-outline req-btn-sm" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
                            <i class="bi bi-upload"></i> Upload File
                        </button>
                    @endif
                </div>
                <div class="req-panel-body">

                    @forelse($requirement->attachments as $attachment)

                        @php
                            $ext = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                            $fileIcon = match(true) {
                                in_array($ext, ['jpg','jpeg','png','gif','webp']) => 'bi-file-earmark-image',
                                $ext === 'pdf' => 'bi-file-earmark-pdf',
                                $ext === 'zip' => 'bi-file-earmark-zip',
                                in_array($ext, ['xls','xlsx','csv']) => 'bi-file-earmark-spreadsheet',
                                default => 'bi-file-earmark-text',
                            };
                        @endphp

                        <div class="req-file-grid" style="margin-bottom:10px;">
                            <div class="req-file-card">
                                <div class="req-file-icon"><i class="bi {{ $fileIcon }}"></i></div>
                                <div class="req-file-info">
                                    <div class="req-file-name">{{ $attachment->file_name }}</div>
                                    <div class="req-file-meta">{{ ucfirst($attachment->uploaded_by_role) }}</div>
                                </div>
                                <a href="{{ asset($attachment->file_path) }}" target="_blank" class="req-file-download">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        </div>

                    @empty
                        <p class="req-empty-inline mb-0">No files uploaded yet.</p>
                    @endforelse

                </div>
            </div>

            {{-- Timeline --}}
            <div class="req-panel">
                <div class="req-panel-header">Timeline</div>
                <div class="req-panel-body">

                    <div class="req-timeline">

                        @forelse($requirement->timeline as $event)

                            <div class="req-timeline-item">
                                <div class="req-timeline-icon">
                                    <i class="bi {{ $eventIcons[$event->event_type] ?? 'bi-dot' }}"></i>
                                </div>
                                <div class="req-timeline-text">{{ $event->description }}</div>
                                <div class="req-timeline-time">
                                    {{ $event->actor->name ?? 'System' }} &middot; {{ $event->created_at->format('d M Y, h:i A') }}
                                </div>
                            </div>

                        @empty
                            <div class="req-empty-timeline">No activity yet.</div>
                        @endforelse

                    </div>

                </div>
            </div>

            {{-- Comments --}}
            <div class="req-panel" id="req-comments">
                <div class="req-panel-header">Discussion</div>
                <div class="req-panel-body">

                    @forelse($requirement->comments as $comment)

                        <div class="req-comment">
                            <div class="req-avatar" style="background:{{ $colorOf($comment->user->name ?? '') }};">
                                {{ $initialsOf($comment->user->name ?? '') }}
                            </div>
                            <div class="req-comment-body">

                                <div class="req-comment-head">
                                    <span class="req-comment-name">{{ $comment->user->name ?? '-' }}</span>
                                    <span class="req-comment-time">{{ $comment->created_at->format('d M, h:i A') }}</span>
                                </div>

                                <div class="req-bubble">{{ $comment->comment }}</div>

                                @foreach($comment->replies as $reply)
                                    <div class="req-reply req-comment">
                                        <div class="req-avatar" style="background:{{ $colorOf($reply->user->name ?? '') }}; width:28px; height:28px; font-size:11px;">
                                            {{ $initialsOf($reply->user->name ?? '') }}
                                        </div>
                                        <div class="req-comment-body">
                                            <div class="req-comment-head">
                                                <span class="req-comment-name">{{ $reply->user->name ?? '-' }}</span>
                                                <span class="req-comment-time">{{ $reply->created_at->format('d M, h:i A') }}</span>
                                            </div>
                                            <div class="req-bubble">{{ $reply->comment }}</div>
                                        </div>
                                    </div>
                                @endforeach

                                <a class="req-comment-reply-link" data-bs-toggle="collapse" href="#replyForm{{ $comment->id }}">
                                    Reply
                                </a>

                                <div class="collapse" id="replyForm{{ $comment->id }}">
                                    <form action="{{ route('admin.requirements.comments.store', $requirement->id) }}" method="POST" class="req-comment-form">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <input type="text" name="comment" placeholder="Write a reply..." required>
                                        <button type="submit">Send</button>
                                    </form>
                                </div>

                            </div>
                        </div>

                    @empty
                        <p class="req-empty-inline">No comments yet. Start the discussion below.</p>
                    @endforelse

                    <form action="{{ route('admin.requirements.comments.store', $requirement->id) }}" method="POST" class="req-comment-form" style="margin-top:16px;">
                        @csrf
                        <input type="text" name="comment" placeholder="Write a comment..." required>
                        <button type="submit">Send</button>
                    </form>

                </div>
            </div>

        </div>

        {{-- ================= RIGHT: Sidebar ================= --}}
        <div class="req-issue-sidebar">

            @if($canAct && !in_array($requirement->status, ['Completed', 'Rejected']))

                <div class="req-panel">
                    <div class="req-panel-header">Actions</div>
                    <div class="req-panel-body req-sidebar-actions">

                        @if(!$requirement->isSeen())
                            <form action="{{ route('admin.requirements.seen', $requirement->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="req-btn req-btn-outline">
                                    <i class="bi bi-eye"></i> Mark as Seen
                                </button>
                            </form>
                        @endif

                        @if($requirement->forwarded_to !== 'admin')
                            <form action="{{ route('admin.requirements.forward-admin', $requirement->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="req-btn req-btn-outline">
                                    <i class="bi bi-person-badge"></i> Forward to Admin
                                </button>
                            </form>
                        @endif

                        @if($requirement->forwarded_to !== 'client')
                            <form action="{{ route('admin.requirements.forward-client', $requirement->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="req-btn req-btn-outline">
                                    <i class="bi bi-send"></i> Forward to Client
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.requirements.complete', $requirement->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="req-btn req-btn-success-outline">
                                <i class="bi bi-check-circle"></i> Mark Completed
                            </button>
                        </form>

                        <button type="button" class="req-btn req-btn-danger-outline" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle"></i> Reject
                        </button>

                    </div>
                </div>

            @endif

            <div class="req-panel">
                <div class="req-panel-header">Details</div>
                <div class="req-panel-body">

                    <div class="req-info-row">
                        <span class="req-info-label">Assigned Developer</span>
                        <span class="req-info-value">{{ $requirement->module->developer->name ?? $requirement->raisedBy->name ?? '-' }}</span>
                    </div>

                    <div class="req-info-row">
                        <span class="req-info-label">Module</span>
                        <span class="req-info-value">{{ $requirement->module->module_name }}</span>
                    </div>

                    <div class="req-info-row">
                        <span class="req-info-label">Project</span>
                        <span class="req-info-value">{{ $requirement->module->project->project_name ?? '-' }}</span>
                    </div>

                    <div class="req-info-row">
                        <span class="req-info-label">Type</span>
                        <span class="req-info-value">{{ $requirement->type->name ?? '-' }}</span>
                    </div>

                    <div class="req-info-row">
                        <span class="req-info-label">Created</span>
                        <span class="req-info-value">{{ $requirement->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="req-info-row">
                        <span class="req-info-label">Updated</span>
                        <span class="req-info-value">{{ $requirement->updated_at->format('d M Y') }}</span>
                    </div>

                    <div class="req-info-row">
                        <span class="req-info-label">Blocker</span>
                        <span class="req-info-value">
                            @if($requirement->is_blocker)
                                <span class="req-badge req-badge-danger">Yes</span>
                            @else
                                <span class="req-badge req-badge-secondary">No</span>
                            @endif
                        </span>
                    </div>

                    <div class="req-info-row">
                        <span class="req-info-label">Seen</span>
                        <span class="req-info-value">
                            @if($requirement->isSeen())
                                <span class="req-badge req-badge-success">Seen</span>
                            @else
                                <span class="req-badge req-badge-secondary">Not seen</span>
                            @endif
                        </span>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

{{-- ========================================= --}}
{{-- Reject Modal --}}
{{-- ========================================= --}}
@if($canAct)

<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.requirements.reject', $requirement->id) }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Reject Requirement</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" name="reason" rows="4" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-danger">Reject Requirement</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- ========================================= --}}
{{-- Upload File Modal --}}
{{-- ========================================= --}}
<div class="modal fade" id="uploadFileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.requirements.upload', $requirement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File</label>
                        <input type="file" class="form-control" name="file" required>
                        <small class="text-muted">Images, PDF, ZIP, Excel, Documents supported.</small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    <button class="btn btn-primary">Upload</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endif

@endsection