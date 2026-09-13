@extends('index')
@push('title', get_phrase('Payments'))
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
                    <li><a href="#">{{ get_phrase('Payments') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">

    <!-- TOTAL INVOICE -->
    <div class="col-md-3">
        <div class="card text-center border-primary">
            <div class="card-body">
                <h6 class="eForm-label">Total Invoice</h6>
                <h4 class="eForm-label">₹ {{ number_format($totalInvoices, 2) }}</h4>
            </div>
        </div>
    </div>

    <!-- TOTAL RECEIVED -->
    <div class="col-md-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <h6 class="eForm-label">Total Received</h6>
                <h4 class="text-success eForm-label">₹ {{ number_format($totalReceived, 2) }}</h4>
            </div>
        </div>
    </div>

    <!-- PENDING -->
    <div class="col-md-3">
        <div class="card text-center border-danger">
            <div class="card-body">
                <h6 class="eForm-label">Pending</h6>
                <h4 class="text-danger eForm-label">₹ {{ number_format($pending, 2) }}</h4>
            </div>
        </div>
    </div>

    <!-- EXTRA -->
    <div class="col-md-3">
        <div class="card text-center border-warning">
            <div class="card-body">
                <h6 class="eForm-label">Advance / Extra</h6>
                <h4 class="text-warning eForm-label">₹ {{ number_format($extra, 2) }}</h4>
            </div>
        </div>
    </div>

</div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Payments') }}</p>


                <div class="card">
                    <div class="card-body p-3">

                        <table class="table eTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Receipt No</th>
                                    <th>Proforma</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Transaction</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($payments as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $p->receipt_no }}</td>

                                        <td>
                                            {{ $p->proforma->proforma_no ?? 'N/A' }}
                                        </td>

                                        <td>{{ $p->payment_date }}</td>

                                        <td>{{ ucfirst($p->payment_method) }}</td>

                                        <td>{{ $p->transaction_id ?? 'N/A' }}</td>

                                        <td class="text-end text-success">
                                            ₹{{ number_format($p->amount, 2) }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.proforma.recipt', $p->id) }}" class="btn btn-info btn-sm text-white"><i class="fi-rr-eye"></i></a>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center text-danger">
                                            No payments found
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


@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
    </script>
@endpush
