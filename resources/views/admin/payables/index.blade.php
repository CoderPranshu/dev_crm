@extends('index')
@push('title', get_phrase('Payables'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Payments') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Payables') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">Payable</p>

                <div class="row mb-4">

                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h6 class="eForm-label">Total Purchase Amount</h6>
                                <h4 class="text-primary" style="font-size: 16px">
                                    ₹ {{ number_format($totalPurchase, 2) }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <h6 class="eForm-label">Total Payment Made</h6>
                                <h4 class="text-success" style="font-size: 16px">
                                    ₹ {{ number_format($totalPaid, 2) }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-danger">
                            <div class="card-body text-center">
                                <h6 class="eForm-label">Total Payable Amount</h6>
                                <h4 class="text-danger" style="font-size: 16px">
                                    ₹ {{ number_format($totalPayable, 2) }}
                                </h4>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <strong class="column-title">Vendor Wise Payable Summary</strong>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0 eForm-label">
                            <thead class="table-light ">
                                <tr>
                                    <th>#</th>
                                    <th>Vendor</th>
                                    <th class="text-end">Total Purchase</th>
                                    <th class="text-end text-success">Paid</th>
                                    <th class="text-end text-danger">Payable</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($vendorPayables as $key => $vendor)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $vendor->supplier->user->name }}</td>

                                        <td class="text-end">
                                            ₹ {{ number_format($vendor->total_purchase, 2) }}
                                        </td>

                                        <td class="text-end text-success">
                                            ₹ {{ number_format($vendor->total_paid, 2) }}
                                        </td>

                                        <td class="text-end text-danger fw-bold">
                                            ₹ {{ number_format($vendor->total_due, 2) }}
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.vendor.payables.bills', $vendor->supplier_name) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="fi-rr-eye"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No payable data found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop
