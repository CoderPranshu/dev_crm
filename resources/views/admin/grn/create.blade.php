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
                    <input type="hidden" name="purchase_order_id" value="{{ request()->id }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="eForm-label">Supplier Name</label>

                            <select name="supplier_name" id="supplier_name" class="form-control eForm-control">
                                <option value="">-- Select Vendor --</option>

                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">
                                        {{ $vendor->user->name ?? 'N/A' }}
                                    </option>
                                @endforeach

                                <option value="add_vendor">+ Add Vendor</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="eForm-label">GRN Date *</label>
                            <input type="date" name="grn_date" class="eForm-control form-control"
                                value="{{ old('grn_date') }}">
                        </div>
                    </div>



                    @if (auth()->user()->hasRole('Admin'))
                        @php
                            $branches = App\Models\Branch::get();
                        @endphp
                        <div class="mb-3">
                            <label class="eForm-label">Branch</label>
                            <select name="branch_id" class="eForm-control form-control" id="branch_id">
                                <option value="" disabled selected>-- Select Branch --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                    @endif

                    <hr>

                    <h5 class="eForm-label">GRN Items</h5>

                    <table class="table table-bordered" id="grn_table">
                        <thead>
                            <tr>
                                <th class="eForm-label">Product</th>
                                <th class="eForm-label">Qty Received</th>
                                <th class="eForm-label">Rate</th>
                                <th class="eForm-label">Hsn Code</th>
                                <th class="eForm-label">Gst Rate</th>
                                <th class="eForm-label">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="items[0][product_id]" class="eForm-control form-control product_select">
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" step="0.0001" name="items[0][quantity]"
                                        class="eForm-control form-control">
                                </td>
                                <td><input type="number" step="0.0001" name="items[0][rate]"
                                        class="eForm-control form-control"></td>
                                <td><input type="number" step="1" name="items[0][hsn_code]"
                                        class="eForm-control form-control"></td>
                                <td><input type="number" step="1" name="items[0][gst_rate]"
                                        class="eForm-control form-control"></td>
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

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let index = 1;

            // ==============================
            // GLOBAL STORE
            // ==============================
            let branchProducts = [];

            const tableBody = document.querySelector("#grn_table tbody");
            const addRowBtn = document.getElementById("addRow");

            // ==============================
            // BUILD PRODUCT OPTIONS
            // ==============================
            function getProductOptions() {
                let html = '<option value="">Select Product</option>';
                branchProducts.forEach(p => {
                    html += `<option value="${p.id}">${p.name}</option>`;
                });
                return html;
            }

            // ==============================
            // UPDATE EXISTING ROWS
            // ==============================
            function updateAllProductDropdowns() {
                document.querySelectorAll('.product_select').forEach(select => {
                    select.innerHTML = getProductOptions();
                });
            }

            // ==============================
            // ADD ROW
            // ==============================
            addRowBtn.addEventListener("click", function() {

                let row = `
        <tr>
            <td>
                <select name="items[${index}][product_id]" class="eForm-control form-control product_select">
                    ${getProductOptions()}
                </select>
            </td>
            <td>
                <input type="number" step="0.0001" name="items[${index}][quantity]" class="eForm-control form-control">
            </td>
            <td>
                <input type="number" step="0.0001" name="items[${index}][rate]" class="eForm-control form-control">
            </td>
            <td>
                <input type="number" step="1" name="items[${index}][hsn_code]" class="eForm-control form-control">
            </td>
            <td>
                <input type="number" step="1" name="items[${index}][gst_rate]" class="eForm-control form-control">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm deleteRow">X</button>
            </td>
        </tr>
        `;

                tableBody.insertAdjacentHTML("beforeend", row);
                index++;
            });

            // ==============================
            // DELETE ROW
            // ==============================
            document.addEventListener("click", function(e) {
                if (e.target.classList.contains("deleteRow")) {
                    e.target.closest("tr").remove();
                }
            });

            // ==============================
            // BRANCH CHANGE
            // ==============================
            $(document).on('change', '#branch_id', function() {

                let branchId = $(this).val();

                $.ajax({
                    url: '/admin/get-branch-products/' + branchId,
                    type: 'GET',
                    success: function(res) {

                        branchProducts = res.products || [];

                        // UPDATE ALL ROWS
                        updateAllProductDropdowns();
                    }
                });
            });

            // ==============================
            // AUTO LOAD (IMPORTANT)
            // ==============================
            $('#branch_id').trigger('change');

        });
    </script>
@endpush
