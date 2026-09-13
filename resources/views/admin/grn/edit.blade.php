@extends('index')
@push('title', get_phrase('GRN Creation'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('GRN Creation') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('GRN Creation') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('GRN Creation') }}</p>

                <form action="{{ route('admin.grn.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="eForm-label">Supplier Name</label>
                            <input type="text" name="supplier_name" class="eFrom-control form-control"
                                value="{{ old('supplier_name') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="eForm-label">GRN Date *</label>
                            <input type="date" name="grn_date" class="eFrom-control form-control" value="{{ old('grn_date') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="eForm-label">Warehouse (optional)</label>
                        <select name="warehouse_id" class="eForm-control form-control">
                            <option value="">-- None --</option>
                            @foreach ($warehouses as $w)
                                <option value="{{ $w->id }}">{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <h5 class="eForm-label">GRN Items</h5>

                    <table class="table table-bordered" id="grn_table">
                        <thead>
                            <tr>
                                <th class="eForm-label">Product</th>
                                <th class="eForm-label">Qty Received</th>
                                <th class="eForm-label">Rate</th>
                                <th class="eForm-label">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="items[0][product_id]" class="eForm-control form-control">
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" step="0.0001" name="items[0][quantity]" class="eForm-control form-control">
                                </td>
                                <td><input type="number" step="0.0001" name="items[0][rate]" class="eForm-control form-control"></td>
                                <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" class="btn-form btn-secondary mb-3" id="addRow">Add Item</button>

                    <button class="btn-form btn-primary">Save GRN</button>

                </form>
                {{-- <div class="table-responsive">

                </div> --}}
            </div>
        </div>
    </div>
@endsection

@push('css')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let index = 1;
            const tableBody = document.querySelector("#grn_table tbody");
            const addRowBtn = document.getElementById("addRow");

            // Add new row
            addRowBtn.addEventListener("click", function() {

                let row = `
        <tr>
            <td>
                <select name="items[${index}][product_id]" class="form-control">
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" step="0.0001" name="items[${index}][quantity]" class="form-control">
            </td>
            <td>
                <input type="number" step="0.0001" name="items[${index}][rate]" class="form-control">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm deleteRow">X</button>
            </td>
        </tr>
        `;

                tableBody.insertAdjacentHTML("beforeend", row);
                index++;
            });

            // Delete row (event delegation)
            document.addEventListener("click", function(e) {
                if (e.target.classList.contains("deleteRow")) {
                    e.target.closest("tr").remove();
                }
            });

        });
    </script>


@endpush
