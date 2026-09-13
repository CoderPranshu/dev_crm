@extends('index')

@push('title', get_phrase('Backlink Assignment'))

@section('content')

<input type="hidden" id="inlineCsrfToken" value="{{ csrf_token() }}">

<div class="bl-page">

    {{-- ===========================================
        Header
    =========================================== --}}
    <div class="bl-topbar fade-up">
        <div class="bl-topbar-left">
            <a href="{{ route('admin.seo-team-work.index') }}" class="bl-back-btn" aria-label="Go back">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="bl-heading">Backlink Assignment</h1>
                <p class="bl-subheading">Manage backlink inventory &amp; assign SEO executives.</p>
            </div>
        </div>
    </div>

    {{-- ===========================================
        Project Information
    =========================================== --}}
    <div class="bl-card bl-project-card fade-up">
        <div class="bl-project-left">
            <div class="bl-project-icon"><i class="fa-solid fa-link"></i></div>
            <div>
                <h3 class="bl-project-name">{{ $project->company->name }}</h3>
                <div class="bl-project-plan">{{ $project->seoPlan->name }}</div>
                <span class="bl-status-badge">
                    <i class="fa-solid fa-circle-dot"></i> Active Project
                </span>
            </div>
        </div>

        <div class="bl-project-right">
            <div class="bl-project-stat">
                <small>Start Date</small>
                <span>{{ \Carbon\Carbon::parse($project->start_date)->format('d M Y') }}</span>
            </div>
            <div class="bl-project-stat">
                <small>End Date</small>
                <span>{{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ===========================================
        Summary Cards
    =========================================== --}}
    <div class="bl-stats-grid fade-up">
        <div class="bl-stat-card bl-border-teal">
            <div class="bl-stat-top">
                <div>
                    <small>Inventory</small>
                    <h2 class="bl-stat-value">{{ number_format($totalBacklinks) }}</h2>
                </div>
                <div class="bl-stat-icon bl-icon-teal"><i class="fa-solid fa-database"></i></div>
            </div>
        </div>

        <div class="bl-stat-card bl-border-success">
            <div class="bl-stat-top">
                <div>
                    <small>Available</small>
                    <h2 class="bl-stat-value bl-text-success">{{ number_format($availableCount) }}</h2>
                </div>
                <div class="bl-stat-icon bl-icon-success"><i class="fa-solid fa-circle-check"></i></div>
            </div>
        </div>

        <div class="bl-stat-card bl-border-warning">
            <div class="bl-stat-top">
                <div>
                    <small>Assigned</small>
                    <h2 class="bl-stat-value bl-text-warning">{{ number_format($assignedCount) }}</h2>
                </div>
                <div class="bl-stat-icon bl-icon-warning"><i class="fa-solid fa-user-check"></i></div>
            </div>
        </div>

        <div class="bl-stat-card bl-border-dark">
            <div class="bl-stat-top">
                <div>
                    <small>Completed</small>
                    <h2 class="bl-stat-value bl-text-dark">{{ number_format($completedCount) }}</h2>
                </div>
                <div class="bl-stat-icon bl-icon-dark"><i class="fa-solid fa-award"></i></div>
            </div>
        </div>
    </div>

    {{-- ===========================================
        Tip Banner
    =========================================== --}}
    <div class="bl-tip-banner fade-up">
        <i class="fa-solid fa-lightbulb bl-tip-icon"></i>
        <div>
            <strong>Tip:</strong> Click any highlighted cell to add or edit information. Changes save automatically.
            Only team members assigned to this project can view or complete these backlinks.
        </div>
    </div>

    {{-- ===========================================
        Assigned Backlinks (Inline Editable Grid)
    =========================================== --}}
    <div class="bl-card bl-assigned-card fade-up">

        <div class="bl-inventory-header">
            <h5 class="bl-section-title">Assigned Backlinks</h5>

            <div class="bl-filters">
                <select id="categoryFilter" class="bl-select bl-filter-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ strtolower(trim($category->name)) }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <span class="bl-pill bl-pill-success bl-pill-lg" id="visibleCountPill">
                {{ $assignedBacklinks->count() }} Backlinks
            </span>
        </div>

        <div class="table-responsive bl-table-wrap">

            <table class="bl-table bl-table-inline" id="assignedBacklinksTable">

                <thead>
                    <tr>
                        <th>Website</th>
                        <th width="150">Category</th>
                        <th width="170">Username</th>
                        <th width="170">Password</th>
                        <th width="230">Remarks</th>
                        <th width="190">Attachment</th>
                        <th width="120">Assigned Date</th>
                        <th width="200">Status</th>
                    </tr>
                </thead>

                <tbody id="assignedBacklinksBody">

                @forelse($assignedBacklinks as $assignment)

                    <tr
                        class="bl-editable-row {{ $assignment->status == 'completed' ? 'bl-row-completed' : 'bl-row-assigned' }}"
                        data-row-id="{{ $assignment->id }}">

                        <td>
                            <div class="bl-website">{{ $assignment->backlink->website_url }}</div>
                            <small class="bl-meta-text">
                                DA: {{ $assignment->backlink->domain_authority }}
                                &middot;
                                PA: {{ $assignment->backlink->page_authority }}
                            </small>
                        </td>

                        {{-- ⭐ FIX: category-name class add ki — filter isi se match karta hai --}}
                        <td>
                            <span class="bl-pill bl-pill-neutral category-name">{{ $assignment->backlink->category->name ?? '-' }}</span>
                        </td>

                        {{-- ============ Username (click-to-edit) ============ --}}
                        <td>
                            <div class="bl-editable-cell" data-field="username" data-id="{{ $assignment->id }}">

                                <div class="bl-cell-display {{ $assignment->username ? '' : 'bl-cell-empty' }}">
                                    <span class="bl-cell-value">{{ $assignment->username ?: '+ Add Username' }}</span>
                                    <i class="fa-solid {{ $assignment->username ? 'fa-pen' : 'fa-plus' }} bl-cell-edit-icon"></i>
                                </div>

                                <div class="bl-cell-edit-wrap" style="display:none;">
                                    <input
                                        type="text"
                                        class="bl-inline-input inline-field"
                                        data-field="username"
                                        data-id="{{ $assignment->id }}"
                                        value="{{ $assignment->username }}"
                                        placeholder="Add Username"
                                        autocomplete="off">
                                    <span class="bl-cell-icon"></span>
                                </div>

                                <div class="bl-saved-toast">✓ Saved</div>
                            </div>
                            <div class="bl-field-error"></div>
                        </td>

                        {{-- ============ Password (click-to-edit) ============ --}}
                        <td>
                            <div class="bl-editable-cell" data-field="password" data-id="{{ $assignment->id }}">

                                <div class="bl-cell-display {{ $assignment->password ? '' : 'bl-cell-empty' }}">
                                    <span class="bl-cell-value">{{ $assignment->password ? '••••••••' : '+ Add Password' }}</span>
                                    <i class="fa-solid {{ $assignment->password ? 'fa-pen' : 'fa-plus' }} bl-cell-edit-icon"></i>
                                </div>

                                <div class="bl-cell-edit-wrap bl-password-wrap" style="display:none;">
                                    <input
                                        type="password"
                                        class="bl-inline-input inline-field bl-password-input"
                                        data-field="password"
                                        data-id="{{ $assignment->id }}"
                                        value="{{ $assignment->password }}"
                                        placeholder="Add Password"
                                        autocomplete="new-password">
                                    <button type="button" class="bl-eye-toggle" tabindex="-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <span class="bl-cell-icon"></span>
                                </div>

                                <div class="bl-saved-toast">✓ Saved</div>
                            </div>
                            <div class="bl-field-error"></div>
                        </td>

                        {{-- ============ Remarks (click-to-edit) ============ --}}
                        <td>
                            <div class="bl-editable-cell" data-field="remarks" data-id="{{ $assignment->id }}">

                                <div class="bl-cell-display {{ $assignment->remarks ? '' : 'bl-cell-empty' }}">
                                    <span class="bl-cell-value">{{ $assignment->remarks ?: '+ Add Remarks' }}</span>
                                    <i class="fa-solid {{ $assignment->remarks ? 'fa-pen' : 'fa-plus' }} bl-cell-edit-icon"></i>
                                </div>

                                <div class="bl-cell-edit-wrap" style="display:none;">
                                    <textarea
                                        class="bl-inline-textarea inline-field"
                                        data-field="remarks"
                                        data-id="{{ $assignment->id }}"
                                        rows="1"
                                        placeholder="Add remarks...">{{ $assignment->remarks }}</textarea>
                                    <span class="bl-cell-icon bl-cell-icon-textarea"></span>
                                </div>

                                <div class="bl-saved-toast">✓ Saved</div>
                            </div>
                        </td>

                        {{-- ============ Attachment (click-to-upload) ============ --}}
                        <td>
                            <div class="bl-attachment-wrap {{ $assignment->attachment ? '' : 'bl-cell-empty' }}" data-attachment-for="{{ $assignment->id }}">

                                <label class="bl-attachment-trigger" title="{{ $assignment->attachment ? 'Replace File' : 'Upload File' }}">
                                    <span class="bl-attachment-icon">
                                        <i class="fa-solid {{ $assignment->attachment ? 'fa-file-lines' : 'fa-paperclip' }}"></i>
                                    </span>
                                    <span class="bl-attachment-name">
                                        {{ $assignment->attachment ? basename($assignment->attachment) : '+ Upload File' }}
                                    </span>
                                    <span class="bl-attachment-hover-label">{{ $assignment->attachment ? 'Replace File' : 'Upload' }}</span>
                                    <input
                                        type="file"
                                        class="bl-file-input inline-file-field"
                                        data-field="attachment"
                                        data-id="{{ $assignment->id }}"
                                        accept=".jpg,.jpeg,.png,.webp,.pdf"
                                        hidden>
                                </label>

                                @if($assignment->attachment)
                                   <a href="{{ asset($assignment->attachment) }}" target="_blank" class="bl-mini-btn bl-attachment-view" title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ asset($assignment->attachment) }}" download class="bl-mini-btn bl-attachment-download" title="Download">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                @endif

                                <span class="bl-cell-icon"></span>
                                <div class="bl-saved-toast">✓ Saved</div>
                            </div>
                            <div class="bl-field-error"></div>
                        </td>

                        <td>
                            @if($assignment->assigned_at)
                                {{ \Carbon\Carbon::parse($assignment->assigned_at)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>

                        {{-- ============ Status (pill button) ============ --}}
                        <td>
                            <div class="bl-status-wrap">
                                <button
                                    type="button"
                                    class="bl-status-btn inline-field {{ $assignment->status == 'completed' ? 'bl-status-done' : '' }}"
                                    data-field="status"
                                    data-id="{{ $assignment->id }}"
                                    data-value="{{ $assignment->status }}">
                                    <i class="fa-solid {{ $assignment->status == 'completed' ? 'fa-circle-check' : 'fa-square' }}"></i>
                                    <span class="bl-status-btn-label">{{ $assignment->status == 'completed' ? 'Completed' : 'Mark Complete' }}</span>
                                </button>
                                <span class="bl-cell-icon"></span>
                                <div class="bl-saved-toast">✓ Saved</div>

                                @if($assignment->status == 'completed' && $assignment->completedByUser)
                                    <small class="bl-completed-by">by {{ $assignment->completedByUser->name }}</small>
                                @endif
                            </div>
                        </td>

                    </tr>

                @empty

                    <tr id="emptyAssignedRow">
                        <td colspan="8" class="bl-empty-cell">
                            <div class="bl-empty-state">
                                <i class="fa-regular fa-folder-open"></i>
                                <div class="bl-empty-title">No Assigned Backlinks</div>
                                <small>Backlinks assigned to this project will appear here.</small>
                            </div>
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>

<style>

    .bl-filters{ display:flex; gap:12px; flex-wrap:wrap; align-items:center; }
    .bl-filter-select{ min-width:190px; }

:root{
    --bl-accent:#00A8C6;
    --bl-dark:#0F172A;
    --bl-success:#16A34A;
    --bl-warning:#F59E0B;
    --bl-danger:#EF4444;
    --bl-border:#E5E7EB;
    --bl-bg:#F8FAFC;
    --bl-radius:20px;
    --bl-shadow:0 10px 30px rgba(15,23,42,.06);
}

.bl-page{
    font-family:'Inter','Segoe UI',sans-serif;
    color:var(--bl-dark);
    background:var(--bl-bg);
    padding:28px;
    border-radius:24px;
}

/* ---------- Header ---------- */
.bl-topbar{ display:flex; align-items:center; margin-bottom:24px; }
.bl-topbar-left{ display:flex; align-items:center; gap:16px; }
.bl-back-btn{
    width:44px; height:44px; display:flex; align-items:center; justify-content:center;
    background:#fff; border:1px solid var(--bl-border); border-radius:50%;
    color:var(--bl-dark); box-shadow:var(--bl-shadow); transition:all .2s ease;
}
.bl-back-btn:hover{ transform:translateY(-2px); color:var(--bl-accent); }
.bl-heading{ font-size:28px; font-weight:700; margin:0; letter-spacing:-.02em; }
.bl-subheading{ font-size:14.5px; color:#6B7280; margin:2px 0 0; }

/* ---------- Card base ---------- */
.bl-card{
    background:#fff; border:1px solid var(--bl-border); border-radius:var(--bl-radius);
    box-shadow:var(--bl-shadow); padding:26px; margin-bottom:24px;
}

/* ---------- Project card ---------- */
.bl-project-card{ display:flex; justify-content:space-between; align-items:center; gap:24px; flex-wrap:wrap; }
.bl-project-left{ display:flex; align-items:center; gap:20px; }
.bl-project-icon{
    width:64px; height:64px; border-radius:16px; flex-shrink:0;
    background:rgba(0,168,198,.08); color:var(--bl-accent);
    display:flex; align-items:center; justify-content:center; font-size:24px;
}
.bl-project-name{ font-size:19px; font-weight:700; margin:0 0 4px; }
.bl-project-plan{ color:#6B7280; font-size:14px; margin-bottom:8px; }
.bl-status-badge{
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(22,163,74,.1); color:var(--bl-success);
    font-size:12px; font-weight:600; padding:5px 12px; border-radius:999px;
}
.bl-status-badge i{ font-size:8px; }
.bl-project-right{ display:flex; gap:32px; flex-wrap:wrap; }
.bl-project-stat{ display:flex; flex-direction:column; gap:4px; }
.bl-project-stat small{ font-size:12px; color:#9CA3AF; text-transform:uppercase; letter-spacing:.03em; }
.bl-project-stat span{ font-weight:600; font-size:14.5px; }

/* ---------- Stats ---------- */
.bl-stats-grid{ display:grid; grid-template-columns:repeat(4, 1fr); gap:20px; margin-bottom:24px; }
.bl-stat-card{
    background:#fff; border:1px solid var(--bl-border); border-top:3px solid transparent;
    border-radius:var(--bl-radius); box-shadow:var(--bl-shadow); padding:22px;
    transition:transform .25s ease, box-shadow .25s ease;
}
.bl-stat-card:hover{ transform:translateY(-4px); box-shadow:0 18px 36px rgba(15,23,42,.1); }
.bl-border-teal{ border-top-color:var(--bl-accent); }
.bl-border-success{ border-top-color:var(--bl-success); }
.bl-border-warning{ border-top-color:var(--bl-warning); }
.bl-border-dark{ border-top-color:var(--bl-dark); }
.bl-stat-top{ display:flex; justify-content:space-between; align-items:flex-start; }
.bl-stat-top small{ color:#9CA3AF; font-size:13px; font-weight:500; display:block; margin-bottom:6px; }
.bl-stat-value{ font-size:26px; font-weight:700; margin:0; }
.bl-text-success{ color:var(--bl-success); }
.bl-text-warning{ color:var(--bl-warning); }
.bl-text-dark{ color:var(--bl-dark); }
.bl-stat-icon{
    width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center;
    font-size:18px; flex-shrink:0;
}
.bl-icon-teal{ background:rgba(0,168,198,.1); color:var(--bl-accent); }
.bl-icon-success{ background:rgba(22,163,74,.1); color:var(--bl-success); }
.bl-icon-warning{ background:rgba(245,158,11,.12); color:var(--bl-warning); }
.bl-icon-dark{ background:rgba(15,23,42,.06); color:var(--bl-dark); }

/* ---------- Tip banner ---------- */
.bl-tip-banner{
    display:flex; align-items:flex-start; gap:12px;
    background:rgba(0,168,198,.06); border:1px solid rgba(0,168,198,.18);
    color:#0F172A; font-size:13.5px; line-height:1.5;
    padding:14px 18px; border-radius:14px; margin-bottom:18px;
}
.bl-tip-icon{ color:var(--bl-accent); font-size:16px; margin-top:1px; flex-shrink:0; }
.bl-tip-banner strong{ color:var(--bl-accent); }

/* ---------- Inventory / assigned header ---------- */
.bl-inventory-header{
    display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;
    gap:14px; margin-bottom:20px;
}
.bl-section-title{ font-size:17px; font-weight:700; margin:0; }

.bl-select{
    height:44px; border-radius:12px; border:1px solid var(--bl-border);
    padding:0 14px; font-size:14px; background:#fff; transition:border-color .2s, box-shadow .2s;
}
.bl-select:focus{ outline:none; border-color:var(--bl-accent); box-shadow:0 0 0 4px rgba(0,168,198,.12); }

/* ---------- Table ---------- */
.bl-table-wrap{
    border:1px solid var(--bl-border);
    border-radius:16px;
    overflow-x:auto;
    overflow-y:hidden;
}
.bl-table{ width:100%; border-collapse:collapse; margin:0; }
.bl-table-inline{ min-width:1250px; }
.bl-table thead th{
    background:var(--bl-bg); color:#6B7280; font-size:12px; font-weight:600;
    text-transform:uppercase; letter-spacing:.04em; padding:14px 18px; text-align:left;
    border-bottom:1px solid var(--bl-border); white-space:nowrap;
}
.bl-table tbody td{
    padding:14px 16px; border-bottom:1px solid var(--bl-border); font-size:14px; vertical-align:middle;
}
.bl-table tbody tr:last-child td{ border-bottom:none; }
.bl-table tbody tr{ transition:background .2s ease; }
.bl-table tbody tr:hover{ background:var(--bl-bg); }

.bl-website{ font-weight:600; font-size:14px; }
.bl-meta-text{ color:#9CA3AF; font-size:12px; }

.bl-pill{
    display:inline-flex; align-items:center; gap:6px;
    font-size:12px; font-weight:600; padding:5px 12px; border-radius:999px;
}
.bl-pill-neutral{ background:#F3F4F6; color:#4B5563; }
.bl-pill-success{ background:rgba(22,163,74,.1); color:var(--bl-success); }
.bl-pill-lg{ font-size:13px; padding:7px 16px; }

/* ---------- Empty state ---------- */
.bl-empty-cell{ padding:0 !important; border-bottom:none !important; }
.bl-empty-state{ text-align:center; padding:60px 10px; color:#9CA3AF; }
.bl-empty-state i{ font-size:32px; margin-bottom:10px; display:block; color:#D1D5DB; }
.bl-empty-title{ font-weight:600; color:var(--bl-dark); margin-bottom:4px; }

/* ---------- Buttons ---------- */
.bl-btn{
    border:none; border-radius:12px; font-weight:600; font-size:14px;
    padding:12px 24px; display:inline-flex; align-items:center; gap:8px;
    cursor:pointer; transition:all .2s ease; position:relative; overflow:hidden;
}
.bl-btn-primary{
    background:linear-gradient(135deg, var(--bl-accent), #0EC8DE); color:#fff;
    box-shadow:0 8px 20px rgba(0,168,198,.25);
}
.bl-btn-primary:hover{ transform:translateY(-2px); box-shadow:0 12px 26px rgba(0,168,198,.35); color:#fff; }
.bl-btn-primary:disabled{ opacity:.75; cursor:not-allowed; transform:none; }

/* ---------- Fade-up ---------- */
.fade-up{ opacity:1; }

/* ===========================================
    INLINE EDITING GRID
=========================================== */
.bl-table-inline td{ min-width:130px; }

/* ---------- Editable cell (click-to-edit) ---------- */
.bl-editable-cell{ position:relative; }

.bl-cell-display{
    display:flex; align-items:center; justify-content:space-between; gap:8px;
    padding:8px 10px; border-radius:10px; border:1px dashed transparent;
    cursor:pointer; transition:background .18s ease, border-color .18s ease;
    font-size:13.5px; color:var(--bl-dark);
}
.bl-cell-display:hover{
    background:rgba(0,168,198,.07); border-color:rgba(0,168,198,.3);
}
.bl-cell-display .bl-cell-value{ overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:170px; }

.bl-cell-edit-icon{
    font-size:11px; color:var(--bl-accent); opacity:0; transition:opacity .18s ease; flex-shrink:0;
}
.bl-cell-display:hover .bl-cell-edit-icon{ opacity:1; }

.bl-cell-empty{
    border:1px dashed rgba(0,168,198,.35);
    background:rgba(0,168,198,.03);
}
.bl-cell-empty .bl-cell-value{ color:var(--bl-accent); font-weight:600; }
.bl-cell-empty .bl-cell-edit-icon{ opacity:.6; }
.bl-cell-empty:hover{ background:rgba(0,168,198,.09); }

.bl-cell-edit-wrap{ position:relative; display:flex; align-items:center; }
.bl-cell-edit-wrap .bl-inline-input,
.bl-cell-edit-wrap .bl-inline-textarea{
    width:100%; border:1px solid var(--bl-accent); background:#fff;
    border-radius:10px; padding:8px 30px 8px 10px; font-size:13.5px;
    box-shadow:0 0 0 4px rgba(0,168,198,.14); outline:none;
    transition:box-shadow .18s ease;
}
.bl-cell-edit-wrap .bl-inline-textarea{ resize:none; overflow:hidden; min-height:38px; line-height:1.4; }

/* ---------- Floating "Saved" toast ---------- */
.bl-saved-toast{
    position:absolute; top:-8px; right:0; transform:translateY(-100%);
    background:var(--bl-success); color:#fff; font-size:11px; font-weight:600;
    padding:4px 10px; border-radius:999px; opacity:0; pointer-events:none;
    transition:opacity .25s ease, transform .25s ease; white-space:nowrap; z-index:5;
}
.bl-saved-toast.show{ opacity:1; transform:translateY(-110%); }

/* ---------- Cell save icon (spinner / error) ---------- */
.bl-cell-icon{
    position:absolute; right:6px; top:50%; transform:translateY(-50%);
    width:16px; height:16px; display:flex; align-items:center; justify-content:center;
    font-size:12px; pointer-events:none;
}
.bl-cell-icon-textarea{ top:12px; transform:none; }
.bl-cell-icon .fa-spinner{ color:var(--bl-accent); }
.bl-cell-icon .fa-circle-xmark{ color:var(--bl-danger); }

.bl-field-invalid{ border-color:var(--bl-danger) !important; box-shadow:0 0 0 4px rgba(239,68,68,.12) !important; }
.bl-field-error{ font-size:11px; color:var(--bl-danger); margin-top:3px; min-height:14px; padding-left:2px; }

.bl-password-wrap{ position:relative; }
.bl-password-wrap .bl-inline-input{ padding-right:56px; }
.bl-eye-toggle{
    position:absolute; right:30px; top:50%; transform:translateY(-50%);
    border:none; background:transparent; color:#9CA3AF; font-size:13px; cursor:pointer; padding:4px;
}
.bl-eye-toggle:hover{ color:var(--bl-accent); }

/* ---------- Attachment ---------- */
.bl-attachment-wrap{ position:relative; display:flex; align-items:center; gap:6px; padding-right:20px; }
.bl-attachment-trigger{
    display:flex; align-items:center; gap:8px; cursor:pointer;
    padding:8px 10px; border-radius:10px; border:1px dashed transparent;
    transition:background .18s ease, border-color .18s ease; font-size:13px;
}
.bl-attachment-trigger:hover{ background:rgba(0,168,198,.07); border-color:rgba(0,168,198,.3); }
.bl-attachment-wrap.bl-cell-empty .bl-attachment-trigger{
    border:1px dashed rgba(0,168,198,.35); background:rgba(0,168,198,.03);
}
.bl-attachment-icon{ color:var(--bl-accent); font-size:13px; }
.bl-attachment-name{
    color:var(--bl-dark); font-weight:500; max-width:120px;
    overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
}
.bl-attachment-wrap.bl-cell-empty .bl-attachment-name{ color:var(--bl-accent); font-weight:600; }
.bl-attachment-hover-label{
    display:none; font-size:11px; color:var(--bl-accent); font-weight:600;
}
.bl-attachment-trigger:hover .bl-attachment-hover-label{ display:inline; }
.bl-attachment-trigger:hover .bl-attachment-name{ display:none; }

.bl-mini-btn{
    width:30px; height:30px; border-radius:9px; border:1px solid var(--bl-border);
    background:#fff; display:flex; align-items:center; justify-content:center;
    color:var(--bl-dark); font-size:12.5px; cursor:pointer; transition:all .2s ease; flex-shrink:0;
}
.bl-mini-btn:hover{ background:var(--bl-bg); border-color:var(--bl-accent); color:var(--bl-accent); }
.bl-attachment-view{ color:var(--bl-accent); }
.bl-attachment-download{ color:var(--bl-success); }

/* ---------- Status button ---------- */
.bl-status-wrap{ position:relative; display:flex; align-items:center; flex-wrap:wrap; gap:2px 10px; }
.bl-status-btn{
    display:inline-flex; align-items:center; gap:8px;
    border:1px solid var(--bl-border); background:#fff; color:#6B7280;
    font-size:12.5px; font-weight:600; padding:7px 14px; border-radius:999px;
    cursor:pointer; transition:all .2s ease;
}
.bl-status-btn:hover{ border-color:var(--bl-accent); color:var(--bl-accent); }
.bl-status-btn i{ font-size:13px; }
.bl-status-btn.bl-status-done{
    background:rgba(22,163,74,.1); border-color:rgba(22,163,74,.25); color:var(--bl-success);
}
.bl-status-btn.bl-status-done:hover{ color:var(--bl-success); border-color:rgba(22,163,74,.4); }
.bl-status-btn:disabled{ opacity:.65; cursor:not-allowed; }
.bl-completed-by{ display:block; width:100%; color:#9CA3AF; font-size:11px; margin-top:2px; margin-left:2px; }

.bl-row-completed{ background:rgba(22,163,74,.035); }
.bl-row-assigned{ background:transparent; }

/* ---------- Responsive ---------- */
@media (max-width: 992px){
    .bl-stats-grid{ grid-template-columns:repeat(2, 1fr); }
    .bl-project-card{ flex-direction:column; align-items:flex-start; }
}
@media (max-width: 576px){
    .bl-page{ padding:16px; }
    .bl-stats-grid{ grid-template-columns:1fr; }
}
</style>

@endsection

@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<script>

$(document).ready(function () {

    /*
    |--------------------------------------------------------------------------
    | Entrance animation
    |--------------------------------------------------------------------------
    */
    if (window.gsap) {
        gsap.from('.fade-up', {
            y: 18,
            opacity: 0,
            duration: 0.5,
            stagger: 0.08,
            ease: 'power2.out'
        });
    }

});

</script>

@endpush

@push('js')
<script>

/*
|==========================================================================
| CATEGORY FILTER (fixed — now matches the .category-name class added
| to the table markup above, and also updates the visible-count pill)
|==========================================================================
*/
$(document).on('change keyup', '#categoryFilter', function () {
    applyCategoryFilter();
});

function applyCategoryFilter() {

    let category = $('#categoryFilter').val().toLowerCase().trim();
    let visibleCount = 0;

    $('#assignedBacklinksBody tr.bl-editable-row').each(function () {

        let $row = $(this);
        let rowCategory = $row.find('.category-name').text().toLowerCase().trim();

        let show = (category === '') || (rowCategory === category);

        $row.toggle(show);

        if (show) visibleCount++;
    });

    $('#visibleCountPill').text(visibleCount + ' Backlinks');
}

/*
|==========================================================================
| ASSIGNED BACKLINKS — Click-to-edit grid
|
| Endpoint: PUT {{ route('admin.backlink-assignment.inline-update', ['id' => '__ID__']) }}
| Fields  : username | password | remarks | status | attachment
|
| NOTE: Quick-Add / manual assign flow has been fully removed — backlinks
| are auto-synced into this table server-side, so there is no
| quick-assign route or button referenced here anymore.
|==========================================================================
*/
(function () {

    const inlineUrlTemplate = "{{ route('admin.backlink-assignment.inline-update', ['id' => '__ID__']) }}";
    const csrfToken = $('meta[name="csrf-token"]').attr('content') || $('#inlineCsrfToken').val();

    function inlineUrl(id) {
        return inlineUrlTemplate.replace('__ID__', id);
    }

    function showToast($container) {
        let $toast = $container.find('.bl-saved-toast');
        if (!$toast.length) return;
        $toast.addClass('show');
        setTimeout(function () { $toast.removeClass('show'); }, 1500);
    }

    function setCellIcon($wrap, state) {
        let $icon = $wrap.find('.bl-cell-icon');
        if (!$icon.length) return;

        if (state === 'saving') {
            $icon.html('<i class="fa-solid fa-spinner fa-spin"></i>');
        } else if (state === 'error') {
            $icon.html('<i class="fa-solid fa-circle-xmark"></i>');
        } else {
            $icon.empty();
        }
    }

    function setFieldError($field, message) {
        let $errorBox = $field.closest('td').find('.bl-field-error');
        if (message) {
            $field.addClass('bl-field-invalid');
            $errorBox.text(message);
        } else {
            $field.removeClass('bl-field-invalid');
            $errorBox.text('');
        }
    }

    const pending = {};

    function getState(key) {
        if (!pending[key]) {
            pending[key] = { saving: false, dirty: false, value: null, file: null };
        }
        return pending[key];
    }

    /*
    |--------------------------------------------------------------------------
    | Core save routine
    |--------------------------------------------------------------------------
    */
    function saveField(id, field, $field, $wrap, onDone) {

        const key = id + '_' + field;
        const state = getState(key);

        if (state.saving) {
            state.dirty = true;
            return;
        }

        state.saving = true;
        state.dirty = false;

        setCellIcon($wrap, 'saving');

        let ajaxOptions = {
            url: inlineUrl(id),
            method: 'PUT',
            data: {
                _token: csrfToken,
                field: field,
                value: state.value
            }
        };

        if (field === 'attachment') {
            let formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('_method', 'PUT');
            formData.append('field', 'attachment');
            formData.append('attachment', state.file);

            ajaxOptions = {
                url: inlineUrl(id),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false
            };
        }

        $.ajax(ajaxOptions)
            .done(function (res) {

                setCellIcon($wrap, '');
                setFieldError($field, '');

                let $toastContainer = $wrap.closest('.bl-editable-cell, .bl-attachment-wrap, .bl-status-wrap');
                showToast($toastContainer);

                if (onDone) onDone(res, null);

            })
            .fail(function (xhr) {

                setCellIcon($wrap, 'error');

                let message = 'Something went wrong. Please try again.';

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let firstKey = Object.keys(errors)[0];
                    message = errors[firstKey][0];
                    setFieldError($field, message);
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                if (onDone) onDone(null, message);

            })
            .always(function () {

                state.saving = false;

                if (state.dirty) {
                    saveField(id, field, $field, $wrap, onDone);
                }

            });
    }

    function autoExpand($textarea) {
        $textarea.css('height', 'auto');
        $textarea.css('height', $textarea[0].scrollHeight + 'px');
    }

    /*
    |--------------------------------------------------------------------------
    | Click-to-edit (Username / Password / Remarks)
    |--------------------------------------------------------------------------
    */
    function openEdit($cell) {

        let $display = $cell.find('.bl-cell-display');
        let $editWrap = $cell.find('.bl-cell-edit-wrap');
        let $input = $editWrap.find('.inline-field');

        $display.hide();
        $editWrap.show();

        $input.data('original-value', $input.val());

        if ($input.is('textarea')) autoExpand($input);

        $input.trigger('focus');

        if ($input[0].setSelectionRange) {
            let len = $input.val().length;
            try { $input[0].setSelectionRange(len, len); } catch (e) {}
        }
    }

    function closeEdit($cell, newValue, field) {

        let $display = $cell.find('.bl-cell-display');
        let $editWrap = $cell.find('.bl-cell-edit-wrap');
        let $valueSpan = $display.find('.bl-cell-value');
        let $icon = $display.find('.bl-cell-edit-icon');

        let placeholder = {
            username: '+ Add Username',
            password: '+ Add Password',
            remarks: '+ Add Remarks'
        }[field];

        let isEmpty = !newValue || !newValue.toString().trim();

        if (field === 'password') {
            $valueSpan.text(isEmpty ? placeholder : '••••••••');
        } else {
            $valueSpan.text(isEmpty ? placeholder : newValue);
        }

        $display.toggleClass('bl-cell-empty', isEmpty);
        $icon.removeClass('fa-pen fa-plus').addClass(isEmpty ? 'fa-plus' : 'fa-pen');

        $editWrap.hide();
        $display.show();
    }

    function commitField($cell) {

        let field = $cell.data('field');
        let id = $cell.data('id');
        let $input = $cell.find('.inline-field');
        let $wrap = $cell.find('.bl-cell-edit-wrap');
        let value = $input.val();

        if (field === 'username' && !value.trim()) {
            setFieldError($input, 'Username is required.');
            $input.trigger('focus');
            return;
        }

        if (field === 'password' && !value.trim()) {
            setFieldError($input, 'Password is required.');
            $input.trigger('focus');
            return;
        }

        setFieldError($input, '');

        let key = id + '_' + field;
        getState(key).value = value;

        saveField(id, field, $input, $wrap, function (res, errorMsg) {
            if (errorMsg) {
                let original = $input.data('original-value');
                $input.val(original);
                closeEdit($cell, original, field);
            } else {
                closeEdit($cell, value, field);
            }
        });
    }

    function cancelEdit($cell) {

        let field = $cell.data('field');
        let $input = $cell.find('.inline-field');
        let original = $input.data('original-value');

        $input.val(original);
        setFieldError($input, '');
        closeEdit($cell, original, field);
    }

    $(document).on('click', '.bl-cell-display', function () {
        openEdit($(this).closest('.bl-editable-cell'));
    });

    $(document).on('blur', '.bl-editable-cell .inline-field', function () {
        let $cell = $(this).closest('.bl-editable-cell');
        setTimeout(function () {
            if ($cell.find('.bl-cell-edit-wrap').is(':visible')) {
                commitField($cell);
            }
        }, 50);
    });

    $(document).on('input', '.bl-editable-cell textarea.inline-field', function () {
        autoExpand($(this));
    });

    /*
    |--------------------------------------------------------------------------
    | Keyboard: Enter = save, Esc = cancel, Tab = save + move to next cell
    |--------------------------------------------------------------------------
    */
    $(document).on('keydown', '.bl-editable-cell .inline-field', function (e) {

        let $cell = $(this).closest('.bl-editable-cell');

        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            commitField($cell);
        }

        if (e.key === 'Escape') {
            e.preventDefault();
            cancelEdit($cell);
        }

        if (e.key === 'Tab') {
            e.preventDefault();
            commitField($cell);

            let $row = $cell.closest('tr');
            let $editableCells = $row.find('.bl-editable-cell');
            let currentIndex = $editableCells.index($cell);
            let $next = $editableCells.eq(currentIndex + 1);

            if ($next.length) {
                setTimeout(function () { openEdit($next); }, 60);
            }
        }
    });

    $(document).on('click', '.bl-eye-toggle', function (e) {
        e.preventDefault();
        let $input = $(this).siblings('.bl-password-input');
        let isPassword = $input.attr('type') === 'password';
        $input.attr('type', isPassword ? 'text' : 'password');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    /*
    |--------------------------------------------------------------------------
    | Status — pill button
    |--------------------------------------------------------------------------
    */
    $(document).on('click', '.bl-status-btn', function () {

        let $btn = $(this);
        if ($btn.is(':disabled')) return;

        let id = $btn.data('id');
        let current = $btn.data('value');
        let newValue = current === 'completed' ? 'assigned' : 'completed';
        let $wrap = $btn.closest('.bl-status-wrap');

        $btn.prop('disabled', true);

        let key = id + '_status';
        getState(key).value = newValue;

        saveField(id, 'status', $btn, $wrap, function (res, errorMsg) {

            $btn.prop('disabled', false);

            if (errorMsg) return;

            $btn.data('value', newValue);
            let $row = $btn.closest('tr');

            $wrap.find('.bl-completed-by').remove();

            if (newValue === 'completed') {
                $btn.addClass('bl-status-done');
                $btn.html('<i class="fa-solid fa-circle-check"></i><span class="bl-status-btn-label">Completed</span>');
                $row.removeClass('bl-row-assigned').addClass('bl-row-completed');

                if (res && res.completed_by) {
                    $wrap.append('<small class="bl-completed-by">by ' + res.completed_by + '</small>');
                }
            } else {
                $btn.removeClass('bl-status-done');
                $btn.html('<i class="fa-solid fa-square"></i><span class="bl-status-btn-label">Mark Complete</span>');
                $row.removeClass('bl-row-completed').addClass('bl-row-assigned');
            }
        });

    });

    /*
    |--------------------------------------------------------------------------
    | Attachment — immediate AJAX upload with client-side validation
    |--------------------------------------------------------------------------
    */
    const allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
    const maxSizeBytes = 5 * 1024 * 1024; // 5MB

    $(document).on('change', '.inline-file-field', function () {

        let $field = $(this);
        let id = $field.data('id');
        let file = this.files && this.files[0];
        let $wrap = $field.closest('.bl-attachment-wrap');

        if (!file) return;

        let ext = file.name.split('.').pop().toLowerCase();

        if (allowedExt.indexOf(ext) === -1) {
            setCellIcon($wrap, 'error');
            $field.val('');
            return;
        }

        if (file.size > maxSizeBytes) {
            setCellIcon($wrap, 'error');
            $field.val('');
            return;
        }

        let key = id + '_attachment';
        let state = getState(key);
        state.file = file;

        saveField(id, 'attachment', $field, $wrap, function (res, errorMsg) {

            if (errorMsg || !res) return;

            $wrap.removeClass('bl-cell-empty');
            $wrap.find('.bl-attachment-icon i').removeClass('fa-paperclip').addClass('fa-file-lines');
            $wrap.find('.bl-attachment-name').text(res.attachment_name || 'Screenshot');
            $wrap.find('.bl-attachment-trigger').attr('title', 'Replace File');
            $wrap.find('.bl-attachment-hover-label').text('Replace File');

            let $existingLinks = $wrap.find('.bl-attachment-view, .bl-attachment-download');

            if (!$existingLinks.length && res.attachment_url) {
                $wrap.find('.bl-attachment-trigger').after(`
                    <a href="${res.attachment_url}" target="_blank" class="bl-mini-btn bl-attachment-view" title="View">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="${res.attachment_url}" download class="bl-mini-btn bl-attachment-download" title="Download">
                        <i class="fa-solid fa-download"></i>
                    </a>
                `);
            } else if (res.attachment_url) {
                $existingLinks.attr('href', res.attachment_url);
            }

        });

    });

    // Expand any pre-filled textareas on load.
    $(function () {
        $('.bl-editable-cell textarea.inline-field').each(function () {
            autoExpand($(this));
        });
    });

})();
</script>
@endpush