@extends('index')
@push('title', get_phrase('Purchase Requisition'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Purchase Requisition') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Purchase Requisition') }}</a></li>
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
                    <p class="column-title mb-2">{{ get_phrase('Purchase Requisitions') }}</p>
                    <div class="mb-3">
                        <input type="text" id="purchaseSearch" class="eForm-control form-control"
                            placeholder="{{ get_phrase('Search purchase requisition...') }}">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PR No</th>
                                <th>Requested</th>
                                <th>Department</th>
                                <th>Reference Type</th>
                                <th>Status</th>
                                <th>Approved by</th>
                                @can('purchase-requisition-show')
                                    <th>Action</th>
                                @endcan
                            </tr>
                        </thead>



                        <tbody id="purchaseTableBody">
                            @foreach ($purchases as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="purchase-pr">{{ $p->pr_number }}</td>
                                    <td class="purchase-user">{{ $p->user->name ?? 'N/A' }}</td>
                                    <td class="purchase-department">{{ $p->department }}</td>
                                    <td class="purchase-reference">{{ $p->reference_type }}</td>
                                    <td class="purchase-status">
                                        @if ($p->status == 'draft')
                                            <a href="{{ route('admin.pr.convert', $p->id) }}"
                                                class="bg-warning text-black rounded p-1">Draft</a>
                                        @elseif ($p->status == 'pending')
                                            <a href="{{ route('admin.pr.convert', $p->id) }}"
                                                class="bg-info text-black rounded p-1">Pending</a>
                                        @elseif ($p->status == 'approved')
                                            <a href="#"
                                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/purchaseRequisition/rfq', 'id' => $p->id]) }}', '{{ get_phrase('Add new Select Vendor') }}')"
                                                class="btn-form py-2 btn-primary">RFQ(Request Quotation)</a>
                                        @elseif ($p->status == 'processing')
                                            <a href="javascript::void(0);"
                                                class="bg-warning text-white rounded p-1">Processing</a>
                                        @endif
                                    </td>
                                    <td class="purchase-approved">{{ $p->approved->name ?? 'N/A' }}</td>

                                    @can('purchase-requisition-show')
                                        <td>
                                            <a href="{{ route('admin.purchase.view', $p->id) }}"
                                                class="btn-form py-2 me-2 btn-sm btn-info shadow-none">
                                                View
                                            </a>
                                        </td>
                                    @endcan
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
