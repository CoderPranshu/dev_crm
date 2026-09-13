@extends('index')
@push('title', get_phrase('Purchase Requisition'))
@push('meta')
@endpush
@push('css')
    <style>
        th {

            padding: 0px;
            font-size: 13px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 600;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            text-transform: capitalize;
        }

        .info-label {
            color: #6c757d;
            font-weight: 600;
            font-size: 14px;
        }

        .info-value {
            font-weight: 400;
            color: black;
        }

        .section-title {
            font-size: 15px;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .priority-badge {
            font-size: 12px;
            padding: 6px 12px;
        }

        .timeline {
            border-left: 2px solid #dee2e6;
            padding-left: 20px;
        }

        .timeline-item {
            margin-bottom: 15px;
            position: relative;
        }

        .timeline-item::before {
            content: "";
            width: 10px;
            height: 10px;
            background: #0d6efd;
            border-radius: 50%;
            position: absolute;
            left: -26px;
            top: 5px;
        }
    </style>
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Requisition') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.purchase.index') }}">{{ get_phrase('Purchase Requisition') }}</a></li>
                    <li><a href="#">{{ get_phrase('Purchase Requisition Details') }}</a></li>
                </ul>
            </div>

            <span class="badge bg-warning text-dark badge-status">
                <i class="bi bi-clock-history me-1"></i> {{ ucfirst($purchase->status) }}
            </span>
            {{-- <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/proforma/add']) }}', '{{ get_phrase('Add new proforma invoice') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new purchase requisition') }}</span>
                </a>
            </div> --}}
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            {{-- ================= BASIC INFO ================= --}}
            <div class="section-title mb-3">
                <i class="bi bi-file-earmark-text me-1"></i>
                Requisition Information
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="info-label">PR Number</div>
                    <div class="info-value">{{ $purchase->pr_number }}</div>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Department</div>
                    <div class="info-value">{{ $purchase->department }}</div>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Reference Type</div>
                    <div class="info-value">{{ Str::title(str_replace('_', ' ', $purchase->reference_type)) }}</div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">Requested By</div>
                    <div class="info-value">{{ $purchase->user->name }}</div>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Approved By</div>
                    <div class="info-value">{{ $purchase->approved->name ?? 'N/A'}}</div>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Created At</div>
                    <div class="info-value">{{ $purchase->created_at->format('d M Y, h:i A') }}</div>
                </div>
                <div class="col-md-3">
                    <div class="info-label">Status</div>
                    <span class="badge bg-warning text-dark">{{ ucfirst($purchase->status) }}</span>
                </div>
            </div>

            <hr>


            {{-- ================= ITEM DETAILS ================= --}}
            <div class="section-title mb-3">
                <i class="bi bi-box-seam me-1"></i>
                Item Details
            </div>

            <div class="table-responsive mb-4">
                <table class="table eTable table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Unit</th>
                            <th>SKU</th>
                            <th>Required Qty</th>
                            <th>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->unit }}</td>
                                <td>{{ $item->product->sku }}</td>
                                <td>{{ $item->required_qty }}</td>
                                <td>
                                    <span class="badge bg-primary priority-badge">
                                        {{ ucfirst($item->priority) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            {{-- ================= APPROVAL TIMELINE ================= --}}
            <div class="section-title mb-3">
                <i class="bi bi-check2-circle me-1"></i>
                Approval Timeline
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="fw-semibold">Requisition Created</div>
                    <small class="text-muted">{{ $purchase->created_at->format('d M Y, h:i A') }}</small>
                </div>
                <div class="timeline-item">
                    <div class="fw-semibold">Current Status</div>
                    <small class="text-muted">{{ ucfirst($purchase->status) }}</small>
                </div>
            </div>

        </div>
    </div>







@stop
