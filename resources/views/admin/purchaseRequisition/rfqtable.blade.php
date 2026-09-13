@extends('index')
@push('title', get_phrase('Request For Quotation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Request For Quotation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Request For Quotation') }}</a></li>
                </ul>
            </div>
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

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('RFQ') }}</p>
                    <div class="mb-3">

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>RFQ No</th>
                                <th>Status</th>
                                <th>Last Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="purchaseTableBody">
                            @foreach ($rfqs as $rfq)
                                <tr>
                                    <td>{{ $rfq->rfq_number }}</td>
                                    <td>{{ $rfq->status }}</td>
                                    <td>{{ $rfq->last_date }}</td>
                                    <td>


                                        
                                            @can('rfq-show')
                                            <a class="btn btn-info btn-sm text-white eForm-label"
                                                href="{{ route('admin.rfq.show', $rfq->id) }}">View</a>
                                            @endcan
                                            @can('rfq-quotation')
                                                <a class="btn btn-outline-dark btn-sm  eForm-label"
                                                href="{{ route('admin.rfq.quotations', $rfq->id) }}">View Quotations</a>
                                            @endcan
                                            @can('rfq-compare')
                                                <a class="btn btn-outline-primary btn-sm eForm-label"
                                                href="{{ route('admin.rfq.compare', $rfq->id) }}">Compare Quotation</a>
                                            @endcan

                                            @if ($rfq->status == 'draft')
                                                @can('rfq-send')
                                                <a href="{{ route('admin.rfq.send', $rfq->id) }}"
                                                    class="btn btn-success">Send</a>
                                                @endcan
                                            @endif
                                     
                                        @php
                                            $vendor = \App\Models\Vendor::where('user_id', auth()->id())->first();
                                        @endphp

                                        @if ($vendor)
                                            @php
                                                $vendorId = $vendor->id;

                                                $isAssigned = DB::table('rfq_vendor')
                                                    ->where('rfq_id', $rfq->id)
                                                    ->where('vendor_id', $vendorId)
                                                    ->exists();

                                                $alreadySubmitted = \App\Models\VendorQuotation::where(
                                                    'rfq_id',
                                                    $rfq->id,
                                                )
                                                    ->where('vendor_id', $vendorId)
                                                    ->exists();
                                            @endphp

                                            @if ($isAssigned && !$alreadySubmitted)
                                                <a class="btn btn-outline-info btn-sm"
                                                    href="{{ route('admin.vendor.quotation.create', $rfq->id) }}">
                                                    Create Quotation
                                                </a>
                                            @elseif($alreadySubmitted)
                                                <span class="badge bg-success">Submitted</span>
                                            @else
                                                <span class="badge bg-secondary">Not Allowed</span>
                                            @endif
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
            const searchInput = document.getElementById("purchaseSearch");
            const tableBody = document.getElementById("purchaseTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    const prNumber = row.querySelector(".purchase-pr")?.innerText.toLowerCase() ||
                        "";
                    const user = row.querySelector(".purchase-user")?.innerText.toLowerCase() || "";
                    const department = row.querySelector(".purchase-department")?.innerText
                        .toLowerCase() || "";
                    const reference = row.querySelector(".purchase-reference")?.innerText
                        .toLowerCase() || "";
                    const status = row.querySelector(".purchase-status")?.innerText.toLowerCase() ||
                        "";
                    const approved = row.querySelector(".purchase-approved")?.innerText
                        .toLowerCase() || "";

                    const match =
                        prNumber.includes(value) ||
                        user.includes(value) ||
                        department.includes(value) ||
                        reference.includes(value) ||
                        status.includes(value) ||
                        approved.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("purchaseNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "purchaseNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="8" class="text-center text-muted">
                        {{ get_phrase('No matching purchase requisition found') }}
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
