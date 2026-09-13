@extends('index')
@push('title', get_phrase('Proforma Invoices'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Proforma Invoices') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Proforma Invoices') }}</a></li>
                </ul>
            </div>
            @can('performa-create')
                <div class="export-btn-area">
                    <a href="{{ route('admin.proforma.create') }}" class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new proforma invoice') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="column-title mb-2">{{ get_phrase('Proforma Invoices') }}</p>
                    <div class="mb-3">
                        <input type="text" id="proformaSearch" class="form-control eForm-control"
                            placeholder="Search proforma / customer / status / amount...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Proforma No</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                {{-- <th>Status</th> --}}
                                
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="proformaTableBody">
                            @php
                                $remainingAdvance = $customerAdvance;
                            @endphp
                            
                            @foreach ($proformas as $p)
                            
                                @php
                                    $total = (float) $p->total;
                            
                                    // 1. Direct payment (FIRST priority)
                                    $directPaid = (float) ($proformaPayments[$p->id] ?? 0);
                            
                                    // remaining after direct payment
                                    $remainingAfterDirect = max(0, $total - $directPaid);
                            
                                    // 2. Apply advance ONLY if needed
                                    $availableAdvance = (float) ($remainingAdvance[$p->customer_id] ?? 0);
                                    $advanceUsed = min($availableAdvance, $remainingAfterDirect);
                            
                                    // deduct advance
                                    $remainingAdvance[$p->customer_id] = $availableAdvance - $advanceUsed;
                            
                                    $received = $directPaid + $advanceUsed;
                                    $due = $total - $received;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="p-no">{{ $p->proforma_no }}</td>
                                    <td class="p-customer">{{ $p->customer->name ?? 'N/A' }}</td>
                                    <td class="p-date">{{ $p->proforma_date }}</td>
                                    <td class="p-total">₹{{ number_format($p->total, 2) }}</td>
                                    <td class="p-status">
                                        @if ($received <= 0)
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/proforma/payment', 'id' => $p->id]) }}', '{{ get_phrase('Add Payment') }}')"
                                                class="badge bg-danger text-white">Unpaid</a>
                                        @elseif ($due <= 0)
                                            <a target="_blank" href="{{ route('admin.proforma.pay', $p->id) }}"
                                                class="badge bg-success text-white">Paid</a>
                                        @else
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/proforma/payment', 'id' => $p->id]) }}', '{{ get_phrase('Add Payment') }}')"
                                                class="badge bg-warning text-white">Partial pay</a>
                                        @endif
                                    </td>

                                    <td>
                                        @can('performa-show')
                                            <a href="{{ route('admin.proforma.edit', $p->id) }}"
                                                class="btn-form py-2 me-2 shadow-none btn-primary btn-sm">
                                                Edit
                                            </a>

                                            <a href="{{ route('admin.proforma.view', $p->id) }}"
                                                class="btn-form py-2 me-2 btn-sm shadow-none btn-info">
                                                View
                                            </a>

                                            <a href="{{ route('admin.proforma.pdf', $p->id) }}" target="_blank"
                                                class="btn-form py-2 shadow-none btn-sm btn-secondary">
                                                Print
                                            </a>
                                        @endcan

                                        @if ($p->status == 'proforma')
                                            <a href="{{ route('admin.salesorder.convert', $p->id) }}"
                                                class="btn-form ms-2 py-2 shadow-none btn-primary">
                                                Convert to Processing
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("proformaSearch");
            const tableBody = document.getElementById("proformaTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    const no = row.querySelector(".p-no")?.innerText.toLowerCase() || "";
                    const customer = row.querySelector(".p-customer")?.innerText.toLowerCase() ||
                        "";
                    const date = row.querySelector(".p-date")?.innerText.toLowerCase() || "";
                    const total = row.querySelector(".p-total")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".p-status")?.innerText.toLowerCase() || "";

                    const match =
                        no.includes(value) ||
                        customer.includes(value) ||
                        date.includes(value) ||
                        total.includes(value) ||
                        status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("proformaNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "proformaNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="7" class="text-center text-muted">
                        No matching proforma found
                    </td>
                `;
                        tableBody.appendChild(noResultRow);
                    }
                } else {
                    if (noResultRow) {
                        noResultRow.remove();
                    }
                }

            });

        });
    </script>
@endpush
