@extends('index')
@push('title', get_phrase('Sales Orders'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Sales Orders') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Sales Orders') }}</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Sales Orders') }}</p>
                    <div class="mb-3">
                        <input type="text" id="salesOrderSearch" class="form-control eForm-control"
                            placeholder="Search SO No / customer / amount / status / delivery date...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SO No</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Expected Delivery</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="salesOrderTableBody">
                            @foreach ($salesOrders as $so)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="so-no">{{ $so->so_no }}</td>
                                    <td class="so-customer">{{ $so->proforma->customer->name ?? 'N/A' }}</td>
                                    <td class="so-status-text">
                                        @if ($so->status == 'billing')
                                            <span
                                                class="badge bg-warning text-dark">{{ get_phrase('Invoice generated') }}</span>
                                        @else
                                            @if ($so->status == 'processing')
                                                @if ($so->production_status == 'unapproved')
                                                    <span class="text-danger">Waiting for the raw material approval</span>
                                                @else
                                                    <span class="text-info">Waiting for the manufacturing</span>
                                                @endif
                                            @endif

                                            <select
                                                {{ $so->status == 'ready to dispatch' || $so->production_status == 'unapproved' ? 'disabled' : '' }}
                                                class="form-select form-select-sm so-status eForm-label"
                                                data-id="{{ $so->id }}">
                                                <option value="processing"
                                                    {{ $so->status == 'processing' ? 'selected' : '' }}>
                                                    Processing
                                                </option>
                                                <option value="manufacturing"
                                                    {{ $so->status == 'manufacturing' ? 'selected' : '' }}>
                                                    Manufacturing Start
                                                </option>
                                                {{--<option value="completed"
                                                    {{ $so->status == 'completed' ? 'selected' : '' }}>
                                                    Completed
                                                </option>--}}
                                                <option value="cancelled"
                                                    {{ $so->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled
                                                </option>
                                                <option value="ready to delivery"
                                                    {{ $so->status == 'ready to delivery' ? 'selected' : '' }}>
                                                    Ready to Packing
                                                </option>
                                                {{-- <option value="ready to dispatch"
                                                    {{ $so->status == 'ready to dispatch' ? 'selected' : '' }}>
                                                    Ready to Dispatch
                                                </option> --}}
                                            </select>
                                        @endif
                                    </td>

                                    <td class="so-delivery-date">{{ $so->expected_delivery_date }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @can('sales-order-show')
                                                <a href="{{ route('admin.salesorder.view', $so->id) }}">
                                                    <button
                                                        class="btn-form py-2 btn-sm btn-info ready-dispatch-btn shadow-none">
                                                        View
                                                    </button>
                                                </a>
                                            @endcan
                                        </div>
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
        $(document).on('change', '.so-status', function() {

            let status = $(this).val();
            let id = $(this).data('id');
            let select = $(this);

            $.ajax({
                url: "{{ route('admin.salesorder.updateStatus') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);

                        let row = select.closest('tr');
                        let readyBtn = row.find('.ready-dispatch-btn');

                        if (status === 'ready to delivery') {
                            readyBtn.fadeIn();
                        } else {
                            readyBtn.fadeOut();
                        }
                    }
                },
                error: function() {
                    toastr.error('Failed to update status');
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("salesOrderSearch");
            const tableBody = document.getElementById("salesOrderTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    const soNo = row.querySelector(".so-no")?.innerText.toLowerCase() || "";
                    const customer = row.querySelector(".so-customer")?.innerText.toLowerCase() ||
                        "";
                    const total = row.querySelector(".so-total")?.innerText.toLowerCase() || "";
                    const deliveryDate = row.querySelector(".so-delivery-date")?.innerText
                        .toLowerCase() || "";
                    const statusText = row.querySelector(".so-status-text")?.innerText
                        .toLowerCase() || "";
                    const selectedStatus = row.querySelector(".so-status")?.selectedOptions[0]?.text
                        .toLowerCase() || "";

                    const match =
                        soNo.includes(value) ||
                        customer.includes(value) ||
                        total.includes(value) ||
                        deliveryDate.includes(value) ||
                        statusText.includes(value) ||
                        selectedStatus.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("salesOrderNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "salesOrderNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted">
                        No matching sales order found
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
