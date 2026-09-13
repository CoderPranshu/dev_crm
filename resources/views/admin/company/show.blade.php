@php
    $company = DB::table('companies')->where('id', $id)->first();
@endphp

@if ($company)
    <div class="container-fluid">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1 fw-bold text-dark">
                            {{ $company->name ?? 'Company Details' }}
                        </h5>
                        <p class="text-muted mb-0 small">
                            Company information and quick actions
                        </p>
                    </div>

                    <span class="badge {{ !empty($company->is_blocked) ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} px-3 py-2 rounded-pill">
                        {{ !empty($company->is_blocked) ? 'Blocked' : 'Active' }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    {{-- Ledger --}}
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0 fw-semibold">Ledger</h6>
                                <i class="fi-rr-book text-primary fs-5"></i>
                            </div>
                            <p class="text-muted small mb-3">
                                View full ledger details and transaction history of this company.
                            </p>
                            <a href="{{ route('admin.ledger.show', $company->id) }}"
                               class="btn btn-primary btn-sm w-100"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               title="View Ledger">
                                <i class="fi-rr-eye me-1"></i> View Ledger
                            </a>
                        </div>
                    </div>

                    {{-- Rating --}}
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0 fw-semibold">Company Rating</h6>
                                <i class="fi-rr-star text-warning fs-5"></i>
                            </div>
                            <p class="text-muted small mb-3">
                                Current performance rating of the company.
                            </p>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="fw-bold fs-5 text-dark">
                                    {{ $company->rating ?? 0 }} / 5
                                </span>
                                <span class="text-warning fs-6">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if (($company->rating ?? 0) >= $i)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                            </div>

                            <a href="#"
                               onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/company/rate', 'id' => $company->id]) }}', '{{ get_phrase('Rate Company') }}')"
                               class="btn btn-outline-primary btn-sm w-100"
                               title="{{ get_phrase('Rate') }}"
                               data-bs-toggle="tooltip">
                                <i class="fi-rr-star me-1"></i> Update Rating
                            </a>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 h-100 bg-light">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="mb-0 fw-semibold">Company Status</h6>
                                <i class="fi-rr-shield-check text-success fs-5"></i>
                            </div>
                            <p class="text-muted small mb-3">
                                Manage whether this company is active or blocked in the system.
                            </p>

                            <form action="{{ route('admin.company.block', $company->id) }}" method="POST">
                                @csrf

                                @if ($company->is_blocked)
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="fi-rr-ban me-1"></i> Blocked
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        <i class="fi-rr-check me-1"></i> Active
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-danger mb-0">
        Company not found.
    </div>
@endif
