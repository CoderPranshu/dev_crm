@extends('index')

@push('title', get_phrase('Client Backlink Manager'))

@push('css')
<style>
    .cbm-page {
        --cbm-primary: #0f8ea3;
        --cbm-success: #20b26b;
        --cbm-warning: #f59e0b;
        --cbm-border: #e5eaf0;
        --cbm-text: #1f2937;
        --cbm-muted: #6b7280;
        color: var(--cbm-text);
    }

    .cbm-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 22px;
    }

    .cbm-title { margin: 0; font-size: 25px; font-weight: 800; }
    .cbm-subtitle { margin: 5px 0 0; color: var(--cbm-muted); font-size: 13px; }
    .cbm-company { color: var(--cbm-primary); }
    .cbm-actions { display: flex; gap: 9px; flex-wrap: wrap; }

    .cbm-btn {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 15px;
        border: 1px solid var(--cbm-border);
        border-radius: 10px;
        color: var(--cbm-text);
        background: #fff;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .cbm-btn:hover { color: var(--cbm-primary); border-color: var(--cbm-primary); }
    .cbm-btn-primary { color: #fff; border-color: var(--cbm-primary); background: var(--cbm-primary); }
    .cbm-btn-primary:hover { color: #fff; background: #0b7587; }
    .cbm-btn[disabled] { cursor: not-allowed; opacity: .55; }

    .cbm-client-strip {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        margin-bottom: 18px;
        border: 1px solid #dbecef;
        border-radius: 13px;
        background: #f2fbfc;
        font-size: 12.5px;
    }

    .cbm-client-strip i { color: var(--cbm-primary); }

    .cbm-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .cbm-stat {
        padding: 17px;
        border: 1px solid var(--cbm-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 7px 22px rgba(15, 23, 42, .05);
    }

    .cbm-stat-top { display: flex; align-items: center; justify-content: space-between; }
    .cbm-stat-icon { width: 38px; height: 38px; display: grid; place-items: center; border-radius: 10px; background: #e9f7f9; color: var(--cbm-primary); }
    .cbm-stat-number { margin-top: 13px; font-size: 25px; font-weight: 800; }
    .cbm-stat-label { margin-top: 2px; color: var(--cbm-muted); font-size: 12px; }

    .cbm-card {
        margin-bottom: 20px;
        overflow: hidden;
        border: 1px solid var(--cbm-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 7px 22px rgba(15, 23, 42, .045);
    }

    .cbm-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 17px;
        border-bottom: 1px solid var(--cbm-border);
    }

    .cbm-card-title { margin: 0; font-size: 15px; font-weight: 800; }
    .cbm-card-body { padding: 16px 17px; }

    .cbm-imports { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 10px; }
    .cbm-import {
        min-width: 0;
        padding: 12px;
        border: 1px solid var(--cbm-border);
        border-radius: 11px;
        background: #fafcfd;
    }
    .cbm-import-name { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 12px; font-weight: 750; }
    .cbm-import-meta { margin-top: 5px; color: var(--cbm-muted); font-size: 10.5px; }

    .cbm-toolbar { display: flex; gap: 10px; flex-wrap: wrap; }
    .cbm-input, .cbm-select {
        min-height: 41px;
        padding: 9px 12px;
        border: 1px solid var(--cbm-border);
        border-radius: 9px;
        outline: none;
        background: #fff;
        font-size: 12.5px;
    }
    .cbm-input { min-width: 280px; flex: 1; }
    .cbm-input:focus, .cbm-select:focus { border-color: var(--cbm-primary); }

    .cbm-table-wrap { overflow-x: auto; }
    .cbm-table { width: 100%; min-width: 850px; border-collapse: collapse; }
    .cbm-table th { padding: 11px 14px; color: #70798a; background: #f8fafc; font-size: 10.5px; letter-spacing: .05em; text-align: left; text-transform: uppercase; }
    .cbm-table td { padding: 13px 14px; border-top: 1px solid #edf0f4; font-size: 12.5px; vertical-align: middle; }
    .cbm-url { color: var(--cbm-text); font-weight: 700; text-decoration: none; }
    .cbm-url:hover { color: var(--cbm-primary); }
    .cbm-secret { display:inline-flex; align-items:center; gap:7px; }
    .cbm-secret-value { min-width:55px; font-family:ui-monospace,SFMono-Regular,Menlo,monospace; }
    .cbm-secret-toggle { padding:0; border:0; background:transparent; color:var(--cbm-primary); cursor:pointer; }

    .cbm-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        font-size: 10.5px;
        font-weight: 750;
        text-transform: capitalize;
    }
    .cbm-status-assigned { color: #9a6100; background: #fff4d9; }
    .cbm-status-completed { color: #137a48; background: #e8f8ef; }
    .cbm-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .cbm-empty { padding: 42px 20px; text-align: center; color: var(--cbm-muted); }
    .cbm-empty i { margin-bottom: 10px; color: #b4bdc9; font-size: 30px; }
    .cbm-pagination { display: flex; justify-content: flex-end; padding: 14px 17px; border-top: 1px solid var(--cbm-border); }

    @media (max-width: 1050px) {
        .cbm-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .cbm-imports { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 650px) {
        .cbm-header { flex-direction: column; }
        .cbm-actions { width: 100%; }
        .cbm-actions .cbm-btn { flex: 1; }
        .cbm-stats, .cbm-imports { grid-template-columns: 1fr; }
        .cbm-input { min-width: 100%; }
    }
</style>
@endpush

@section('content')

<div class="cbm-page">

    @include('admin.backlinks.partials.alerts')

    <div class="cbm-header">
        <div>
            <h1 class="cbm-title">
                Backlink Manager —
                <span class="cbm-company">{{ $seoPlanClient->company->name ?? 'SEO Client' }}</span>
            </h1>
            <p class="cbm-subtitle">Client-specific backlink imports, assignments and progress.</p>
        </div>

        <div class="cbm-actions">
            <button type="button" class="cbm-btn" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Back
            </button>

            @if(Route::has('admin.seo-client-backlinks.upload'))
                <a href="{{ route('admin.seo-client-backlinks.upload', $seoPlanClient) }}" class="cbm-btn cbm-btn-primary">
                    <i class="fa-solid fa-file-arrow-up"></i> Upload CSV / Excel
                </a>
            @else
                <button type="button" class="cbm-btn cbm-btn-primary" disabled title="Upload flow will be added in Step 5">
                    <i class="fa-solid fa-file-arrow-up"></i> Upload CSV / Excel
                </button>
            @endif
        </div>
    </div>

    <div class="cbm-client-strip">
        <i class="fa-solid fa-lock"></i>
        <span>
            Showing data only for <strong>{{ $seoPlanClient->company->name ?? 'this SEO client' }}</strong>
            · Client ID: {{ $seoPlanClient->id }}
            @if($seoPlanClient->assignedUser)
                · SEO Executive: {{ $seoPlanClient->assignedUser->name }}
            @endif
        </span>
    </div>

    <div class="cbm-stats">
        <div class="cbm-stat">
            <div class="cbm-stat-top"><span class="cbm-stat-icon"><i class="fa-solid fa-link"></i></span></div>
            <div class="cbm-stat-number">{{ $totalBacklinks }}</div>
            <div class="cbm-stat-label">Total Backlinks</div>
        </div>

        <div class="cbm-stat">
            <div class="cbm-stat-top"><span class="cbm-stat-icon"><i class="fa-solid fa-user-clock"></i></span></div>
            <div class="cbm-stat-number">{{ $assignedBacklinks }}</div>
            <div class="cbm-stat-label">Assigned</div>
        </div>

        <div class="cbm-stat">
            <div class="cbm-stat-top"><span class="cbm-stat-icon"><i class="fa-solid fa-circle-check"></i></span></div>
            <div class="cbm-stat-number">{{ $completedBacklinks }}</div>
            <div class="cbm-stat-label">Completed</div>
        </div>

        <div class="cbm-stat">
            <div class="cbm-stat-top"><span class="cbm-stat-icon"><i class="fa-solid fa-file-import"></i></span></div>
            <div class="cbm-stat-number">{{ $totalImports }}</div>
            <div class="cbm-stat-label">Uploaded Files</div>
        </div>
    </div>

    <div class="cbm-card">
        <div class="cbm-card-head">
            <h2 class="cbm-card-title">Recent Import Files</h2>
        </div>

        <div class="cbm-card-body">
            @if($recentImports->count())
                <div class="cbm-imports">
                    @foreach($recentImports as $import)
                        <div class="cbm-import">
                            <div class="cbm-import-name" title="{{ $import->original_name }}">
                                <i class="fa-solid {{ in_array($import->extension, ['xls', 'xlsx'], true) ? 'fa-file-excel' : 'fa-file-csv' }} me-1"></i>
                                {{ $import->original_name }}
                            </div>
                            <div class="cbm-import-meta">
                                {{ strtoupper($import->extension) }} · {{ ucfirst($import->status) }}
                                <br>Imported: {{ $import->imported }} · Skipped: {{ $import->skipped }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="cbm-empty">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <div>No file has been uploaded for this client yet.</div>
                </div>
            @endif
        </div>
    </div>

    <div class="cbm-card">
        <div class="cbm-card-head">
            <h2 class="cbm-card-title">Client Backlinks</h2>

            <form method="GET" action="{{ route('admin.seo-client-backlinks.index', $seoPlanClient) }}" class="cbm-toolbar">
                <input type="search" name="search" value="{{ request('search') }}" class="cbm-input" placeholder="Search website URL, DA, PA or username...">

                <select name="status" class="cbm-select">
                    <option value="">All Statuses</option>
                    <option value="assigned" @selected(request('status') === 'assigned')>Assigned</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                </select>

                <button type="submit" class="cbm-btn cbm-btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                <a href="{{ route('admin.seo-client-backlinks.index', $seoPlanClient) }}" class="cbm-btn">Reset</a>
            </form>
        </div>

        <div class="cbm-table-wrap">
            <table class="cbm-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Website</th>
                        {{-- <th>Category</th> --}}
                        <th>DA</th>
                        <th>PA</th>
                        <th>Username</th>
                        <th>Password</th>
                        {{-- <th>Assigned To</th> --}}
                        {{-- <th>Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $key => $assignment)
                        <tr>
                            <td>{{ $assignments->firstItem() + $key }}</td>
                            <td>
                                <a href="{{ $assignment->backlink->website_url }}" target="_blank" rel="noopener" class="cbm-url">
                                    {{ $assignment->backlink->website_url }}
                                    <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                </a>
                            </td>
                            {{-- <td>{{ $assignment->backlink->category->name ?? '—' }}</td> --}}
                            <td>{{ $assignment->backlink->domain_authority ?? '—' }}</td>
                            <td>{{ $assignment->backlink->page_authority ?? '—' }}</td>
                            <td>{{ $assignment->username ?: '—' }}</td>
                            {{-- <td>
                                @if($assignment->password)
                                    <span class="cbm-secret">
                                        <span class="cbm-secret-value">••••••••</span>
                                        <button type="button" class="cbm-secret-toggle" data-password="{{ $assignment->password }}" aria-label="Show password" title="Show password">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </span>
                                @else
                                    —
                                @endif
                            </td> --}}
                            <td>
                              {{ $assignment->password }}
                            </td>

                            {{-- <td>{{ $assignment->assignedUser->name ?? 'Unassigned' }}</td> --}}
                            {{-- <td>
                                <span class="cbm-status cbm-status-{{ $assignment->status }}">
                                    <span class="cbm-dot"></span>{{ $assignment->status }}
                                </span>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="cbm-empty">
                                    <i class="fa-solid fa-link-slash"></i>
                                    <div>No backlinks found for this client.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($assignments->hasPages())
            <div class="cbm-pagination">{{ $assignments->links() }}</div>
        @endif
    </div>

</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cbm-secret-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const value = button.closest('.cbm-secret').querySelector('.cbm-secret-value');
            const icon = button.querySelector('i');
            const isHidden = value.textContent === '••••••••';

            value.textContent = isHidden ? button.dataset.password : '••••••••';
            icon.className = isHidden ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
            button.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            button.title = isHidden ? 'Hide password' : 'Show password';
        });
    });
});
</script>
@endpush

@endsection




