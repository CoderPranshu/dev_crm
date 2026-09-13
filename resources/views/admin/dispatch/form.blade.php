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
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Dispatch') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Dispatch') }}</p>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>
                @endif

                <form action="{{ route('admin.dispatch.submit', $order->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="eForm-label">Dispatch Date</label>
                        <input type="date" name="dispatch_date" class="eForm-control form-control"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
{{--
                    <div class="mb-3">
                        <label class="eForm-label">Warehouse (Optional)</label>
                        <select name="warehouse_id" class="eForm-control form-control">
                            <option value="">Global Stock</option>
                            @foreach ($warehouses as $w)
                                <option value="{{ $w->id }}">{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <input type="hidden" value="{{ $order->branch_id }}" name="branch_id">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="eForm-label">{{ get_phrase('Docket No.') }}</label>
                                <input type="text" name="docket_no" placeholder="Enter the Docket No"
                                    class="eForm-control form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="eForm-label">Courier Details(Tracking No)</label>
                                <input type="text" name="tracking_no" class="eForm-control form-control"
                                    value="{{ $track }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="eForm-label">Courier Company(Tracking Link)</label>
                                <input type="text" class="eForm-control form-control" name="company_link"
                                    placeholder="Enter the link">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="eForm-label">Courier Name</label>
                        <input type="text" value="{{ $order->invoice_no }}" name="courier_name"
                            class="eForm-control form-control">
                    </div>

                    <h5 class="eForm-label">Items Dispatching</h5>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="eForm-label">Product</th>
                                <th class="eForm-label">Qty</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="eForm-label">{{ $item->product->name ?? 'N/A' }}</td>
                                    <td class="eForm-label">{{ $item->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button class="btn-form btn-success w-100">Confirm Dispatch</button>
                </form>

            </div>
        </div>
    </div>
@endsection
