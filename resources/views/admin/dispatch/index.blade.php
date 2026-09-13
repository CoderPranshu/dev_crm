@extends('index')
@push('title', get_phrase('Dispatch'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Dispatch') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Dispatch') }}</a></li>
                </ul>
            </div>
            {{-- <div class="export-btn-area">
                <a href="{{ route('admin.dispatch.form') }}" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new dispatch') }}</span>
                </a>
            </div> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="column-title mb-2">{{ get_phrase('Invoice') }}</p>
                <div class="mb-3">
                    <input type="text" id="dispatchSearch" class="form-control eForm-control"
                        placeholder="Search delivery / SO / customer / tracking...">
                </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th>Delivery Note</th>
                                <th>Sales Order</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Tracking</th>
                                <th>Courier</th>
                                <th>Status</th>
                                <th>Delivery Note</th>
                            </tr>
                        </thead>
                        <tbody id="dispatchTableBody">
                            @foreach ($dispatched as $d)
                                <tr>
                                    <td class="d-delivery">{{ $d->delivery_no }}</td>
                                    <td class="d-so">{{ $d->salesOrder->salesOrder->so_no ?? 'N/A' }}</td>
                                    <td class="d-customer">{{ $d->salesOrder->customer->name ?? 'N/A' }}</td>
                                    <td class="d-date">{{ $d->dispatch_date }}</td>
                                    <td class="d-tracking">{{ $d->tracking_no }}</td>
                                    <td class="d-courier">{{ $d->courier_name }}</td>
                                    <td class="d-status">
                                        @if ($d->status == 'dispatched')
                                            <form action="{{ route('admin.dispatch.status', $d->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-danger eForm-label text-white btn-sm">Waiting...</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.dispatch.status', $d->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="dispatched">
                                                <button type="submit" class="btn btn-success eForm-label text-white btn-sm">Completed</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.dispatch.delivery_pdf', $d->id) }}" target="_blank"
                                            class="btn btn-sm btn-secondary eForm-label text-white">
                                            Print / View PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("dispatchSearch");
            const tableBody = document.getElementById("dispatchTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {

                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {

                    const delivery = row.querySelector(".d-delivery")?.innerText.toLowerCase() ||
                        "";
                    const so = row.querySelector(".d-so")?.innerText.toLowerCase() || "";
                    const customer = row.querySelector(".d-customer")?.innerText.toLowerCase() ||
                        "";
                    const date = row.querySelector(".d-date")?.innerText.toLowerCase() || "";
                    const tracking = row.querySelector(".d-tracking")?.innerText.toLowerCase() ||
                        "";
                    const courier = row.querySelector(".d-courier")?.innerText.toLowerCase() || "";
                    const status = row.querySelector(".d-status")?.innerText.toLowerCase() || "";

                    const match =
                        delivery.includes(value) ||
                        so.includes(value) ||
                        customer.includes(value) ||
                        date.includes(value) ||
                        tracking.includes(value) ||
                        courier.includes(value) ||
                        status.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("dispatchNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "dispatchNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="8" class="text-center text-muted">
                        No matching records found
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
