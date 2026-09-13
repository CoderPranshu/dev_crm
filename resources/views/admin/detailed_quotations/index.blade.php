@extends('index')

@section('title', 'Detailed Quotations')

@push('css')
<style>
    :root {
        --dq-blue: #1496d4;
        --dq-blue-dark: #087fba;
        --dq-blue-soft: #eaf7fd;
        --dq-red: #f12617;
        --dq-red-soft: #fff0ee;
        --dq-green: #16a36a;
        --dq-green-soft: #eafaf3;
        --dq-text: #121820;
        --dq-muted: #65727c;
        --dq-border: #e3e9ed;
        --dq-bg: #f5f8fa;
        --dq-shadow: 0 10px 30px rgba(20, 150, 212, .07);
    }

    .dq-page { min-height: 100vh; padding: 24px; background: var(--dq-bg); }
    .dq-shell { max-width: 1400px; margin: 0 auto; }
    .dq-header { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 22px; padding: 24px; border: 1px solid #bfe7f7; border-radius: 18px; background: linear-gradient(120deg, #fff, #eef9fd); box-shadow: var(--dq-shadow); }
    .dq-header-left { display: flex; align-items: center; gap: 15px; }
    .dq-header-icon { display: flex; align-items: center; justify-content: center; width: 56px; height: 56px; flex-shrink: 0; border-bottom: 3px solid var(--dq-red); border-radius: 15px; background: linear-gradient(135deg, var(--dq-blue), var(--dq-blue-dark)); color: #fff; font-size: 22px; }
    .dq-header h1 { margin: 0; color: var(--dq-text); font-size: 25px; font-weight: 800; }
    .dq-header p { margin: 5px 0 0; color: var(--dq-muted); font-size: 13px; }
    .dq-create { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 43px; padding: 0 17px; border-radius: 10px; background: linear-gradient(135deg, var(--dq-blue), var(--dq-blue-dark)); color: #fff; font-size: 12px; font-weight: 800; text-decoration: none; box-shadow: 0 6px 15px rgba(20,150,212,.18); }
    .dq-create:hover { color: #fff; }

    .dq-alert { margin-bottom: 18px; padding: 13px 15px; border: 1px solid #b7ebd2; border-radius: 11px; background: var(--dq-green-soft); color: #087a4c; font-size: 12px; font-weight: 700; }
    .dq-card { overflow: hidden; border: 1px solid var(--dq-border); border-radius: 18px; background: #fff; box-shadow: var(--dq-shadow); }
    .dq-card-head { display: flex; align-items: center; justify-content: space-between; gap: 15px; padding: 19px 22px; border-bottom: 1px solid var(--dq-border); }
    .dq-card-head h3 { margin: 0; color: var(--dq-text); font-size: 16px; font-weight: 800; }
    .dq-count { padding: 5px 10px; border-radius: 20px; background: var(--dq-blue-soft); color: var(--dq-blue-dark); font-size: 11px; font-weight: 800; }
    .dq-table-wrap { overflow-x: auto; }
    .dq-table { width: 100%; min-width: 980px; border-collapse: collapse; }
    .dq-table th { padding: 13px 16px; border-bottom: 1px solid var(--dq-border); background: #f8fafc; color: var(--dq-muted); font-size: 11px; font-weight: 800; letter-spacing: .3px; text-align: left; text-transform: uppercase; white-space: nowrap; }
    .dq-table td { padding: 15px 16px; border-bottom: 1px solid var(--dq-border); color: var(--dq-text); font-size: 12px; vertical-align: middle; }
    .dq-table tbody tr:hover { background: #fbfdff; }
    .dq-table tbody tr:last-child td { border-bottom: 0; }
    .dq-name { max-width: 260px; font-weight: 800; word-break: break-word; }
    .dq-subtext { margin-top: 3px; color: var(--dq-muted); font-size: 10px; font-weight: 500; }
    .dq-badge { display: inline-flex; align-items: center; gap: 5px; padding: 6px 9px; border-radius: 20px; font-size: 10px; font-weight: 800; white-space: nowrap; }
    .dq-badge-manual { background: var(--dq-blue-soft); color: var(--dq-blue-dark); }
    .dq-badge-uploaded { background: var(--dq-red-soft); color: var(--dq-red); }
    .dq-price { color: var(--dq-green); font-size: 13px; font-weight: 800; white-space: nowrap; }
    .dq-actions { display: flex; align-items: center; gap: 7px; }
    .dq-action { display: inline-flex; align-items: center; justify-content: center; width: 35px; height: 35px; border: 1px solid var(--dq-border); border-radius: 9px; background: #fff; color: var(--dq-muted); text-decoration: none; cursor: pointer; transition: .2s ease; }
    .dq-action:hover { border-color: var(--dq-blue); color: var(--dq-blue); }
    .dq-action.download { border-color: #bfe7f7; background: var(--dq-blue-soft); color: var(--dq-blue-dark); }
    .dq-action.delete { border-color: #ffd2cd; background: var(--dq-red-soft); color: var(--dq-red); }
    .dq-empty { padding: 60px 20px; text-align: center; }
    .dq-empty-icon { display: flex; align-items: center; justify-content: center; width: 70px; height: 70px; margin: 0 auto 15px; border-radius: 18px; background: var(--dq-blue-soft); color: var(--dq-blue); font-size: 30px; }
    .dq-empty h4 { margin: 0 0 6px; color: var(--dq-text); font-size: 17px; }
    .dq-empty p { margin: 0 0 18px; color: var(--dq-muted); font-size: 12px; }
    .dq-pagination { padding: 18px 22px; border-top: 1px solid var(--dq-border); }

    @media (max-width: 767.98px) {
        .dq-page { padding: 14px; }
        .dq-header { align-items: flex-start; flex-direction: column; padding: 18px; }
        .dq-header h1 { font-size: 21px; }
        .dq-create { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="dq-page">
    <div class="dq-shell">
        <div class="dq-header">
            <div class="dq-header-left">
                <div class="dq-header-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div>
                    <h1>Detailed Quotations</h1>
                    <p>Manage manual proposals and uploaded PDF quotations.</p>
                </div>
            </div>

            <a href="{{ route('admin.detailed-quotations.create') }}" class="dq-create">
                <i class="bi bi-plus-lg"></i> Create Proposal
            </a>
        </div>

        @if(session('success'))
            <div class="dq-alert"><i class="bi bi-check-circle me-1"></i> {{ session('success') }}</div>
        @endif

        <div class="dq-card">
            <div class="dq-card-head">
                <h3>Quotation List</h3>
                <span class="dq-count">
                    {{ method_exists($quotations, 'total') ? $quotations->total() : $quotations->count() }} Records
                </span>
            </div>

            @if($quotations->count())
                <div class="dq-table-wrap">
                    <table class="dq-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Proposal Name</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Quotation Service</th>
                                <th>Price</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($quotations as $quotation)
                                <tr>
                                    <td>
                                        {{ method_exists($quotations, 'firstItem') && $quotations->firstItem()
                                            ? $quotations->firstItem() + $loop->index
                                            : $loop->iteration }}
                                    </td>

                                    <td>
                                        <div class="dq-name">{{ $quotation->name }}</div>
                                        <div class="dq-subtext">ID: {{ $quotation->id }}</div>
                                    </td>

                                    <td>
                                        @if($quotation->quotation_type === 'manual')
                                            <span class="dq-badge dq-badge-manual"><i class="bi bi-pencil-square"></i> Manual</span>
                                        @else
                                            <span class="dq-badge dq-badge-uploaded"><i class="bi bi-file-earmark-pdf"></i> Uploaded PDF</span>
                                        @endif
                                    </td>

                                    <td>{{ $quotation->category?->name ?? '—' }}</td>
                                    <td>{{ $quotation->service?->name ?? '—' }}</td>
                                    <td><span class="dq-price">₹{{ number_format((float) $quotation->price, 2) }}</span></td>
                                    <td>{{ optional($quotation->created_at)->format('d M Y, h:i A') ?? '—' }}</td>

                                    <td>
                                        <div class="dq-actions">
                                            @if(Route::has('admin.detailed-quotations.download'))
                                                <a href="{{ route('admin.detailed-quotations.download', $quotation) }}" class="dq-action download" title="Download PDF">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @endif

                                            @if(Route::has('admin.detailed-quotations.show'))
                                                <a href="{{ route('admin.detailed-quotations.show', $quotation) }}" class="dq-action" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif

                                            @if(Route::has('admin.detailed-quotations.destroy'))
                                                <form action="{{ route('admin.detailed-quotations.destroy', $quotation) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this proposal?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dq-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(method_exists($quotations, 'hasPages') && $quotations->hasPages())
                    <div class="dq-pagination">{{ $quotations->links() }}</div>
                @endif
            @else
                <div class="dq-empty">
                    <div class="dq-empty-icon"><i class="bi bi-file-earmark-text"></i></div>
                    <h4>No proposals found</h4>
                    <p>Create a manual proposal or upload an existing PDF.</p>
                    <a href="{{ route('admin.detailed-quotations.create') }}" class="dq-create"><i class="bi bi-plus-lg"></i> Create Proposal</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

