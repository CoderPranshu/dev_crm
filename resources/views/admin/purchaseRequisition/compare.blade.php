@extends('index')
@push('title', get_phrase('Compare Quotation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Compare Quotation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Compare Quotation') }}</a></li>
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
                    <p class="column-title mb-2">{{ get_phrase('Compare Quotation') }}</p>
                    <div class="mb-3">

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead class="eForm-label">
                            <tr>
                                <th>Vendor</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="eForm-label">
                            @foreach ($quotations as $q)
                                <tr @if ($q->total_amount == $lowest) style="background:#d4edda" @endif>
                                    <td>{{ $q->vendor->user->name }}</td>
                                    <td>{{ $q->total_amount }}</td>
                                    <td>{{ $q->status }}</td>

                                    <td>
                                        @if($q->status == 'submitted')
                                            <a href="{{ route('admin.quotation.approve', $q->id) }}"
                                                class="btn btn-sm btn-success">
                                                Approve
                                            </a>
                                            
                                            <a href="{{ route('admin.vendor.quotation.view', $q->id) }}"
                                                class="btn btn-sm btn-success">
                                                View Details
                                            </a>
    
                                            <a href="{{ route('admin.quotation.reject', $q->id) }}"
                                                class="btn btn-sm btn-danger">
                                                Reject
                                            </a>
                                        @else
                                            <span class="">{{$q->status}}</span>
                                            
                                             <a href="{{ route('admin.vendor.quotation.view', $q->id) }}"
                                                class="btn btn-sm ms-3 btn-success">
                                                View Details
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
