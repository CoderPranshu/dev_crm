@extends('index')

@push('title', 'Tax')

@section('content')
<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
        <div class="d-flex flex-column">
            <h4>{{ get_phrase('Branches') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                <li><a href="#">{{ get_phrase('Branch') }}</a></li>
            </ul>
        </div>
        @can('branch-create')
        <div class="export-btn-area">
            <a href="#"
                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/branch/add']) }}', '{{ get_phrase('Add new branch') }}')"
                class="export_btn">
                <i class="bi bi-plus"></i>
                <span class="d-none d-sm-inline-block">{{ get_phrase('Add new branch') }}</span>
            </a>
        </div>
        @endcan
    </div>
</div>
<div class="eSection-wrap pb-3">

    {{-- ================= BRANCH TABS ================= --}}
    <ul class="nav nav-tabs">
        @foreach($branches as $key => $branch)
        <li class="nav-item">
            <button class="nav-link {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab"
                data-bs-target="#branch_{{ $branch->id }}">
                {{ $branch->title }}
            </button>
        </li>
        @endforeach
    </ul>

    {{-- ================= TAB CONTENT ================= --}}
    <div class="tab-content mt-3">

        @foreach($branches as $key => $branch)
        <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="branch_{{ $branch->id }}">
            <form action="{{ route('admin.branch.update', $branch->id) }}" method="POST" class="mb-4" enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-body">

                        <h5 class="mb-3 eForm-label">Branch Details</h5>

                        <div class="row">

                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">Branch Name</label>
                                <input type="text" name="title" value="{{ $branch->title }}"
                                    class="form-control eForm-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">Company Name</label>
                                <input type="text" name="company_name" value="{{ $branch->company_name }}"
                                    class="form-control eForm-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">Contact Person</label>
                                <input type="text" name="contact_person" value="{{ $branch->contact_person }}"
                                    class="form-control eForm-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">Phone</label>
                                <input type="text" name="phone_no" value="{{ $branch->phone_no }}"
                                    class="form-control eForm-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">GST Number</label>
                                <input type="text" name="gstin" value="{{ $branch->gstin }}"
                                    class="form-control eForm-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">Machine Serial</label>
                                <input type="text" name="machine_serial_no" value="{{ $branch->machine_serial_no }}"
                                    class="form-control eForm-control">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="eForm-label">Address</label>
                                <textarea name="address"
                                    class="form-control eForm-control">{{ $branch->address }}</textarea>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">State Code</label>
                                <input type="text" name="state_code" value="{{ $branch->state_code }}"
                                    class="form-control eForm-control">
                            </div>
                            
                            <div class="col-md-6 mb-2">
                                <label class="eForm-label">Business Logo</label>
                                <input type="file" name="logo" value=""
                                    class="form-control eForm-control">
                                    
                                    <img src="{{ asset('businesslogo/'.$branch->logo) }}" style="width:100px">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label class="eForm-label">Terms & Condition</label>
                                <textarea name="terms_condition"
                                    class="form-control eForm-control">{{ $branch->terms_condition }}</textarea>
                            </div>

                            <div class="col-md-12 text-end mt-2">
                                <button type="submit" class="btn btn-primary">
                                    Update Branch
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </form>
            {{-- ================= TAX ================= --}}
            <form action="{{ route('admin.tax.store') }}" method="POST">
                @csrf
                <input type="hidden" name="branch_id" value="{{ $branch->id }}">

                <h5 class="eForm-label">Tax</h5>

                <div class="taxRepeater">
                    @foreach($taxes[$branch->id] ?? [] as $i => $tax)
                    <div class="card mb-2 tax-row">
                        <div class="card-body">

                            <input type="hidden" name="taxes[{{ $i }}][id]" value="{{ $tax->id }}">
                            <input type="hidden" name="taxes[{{ $i }}][branch_id]" value="{{ $branch->id }}">

                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="taxes[{{ $i }}][name]" value="{{ $tax->name }}"
                                        class="form-control eForm-control" placeholder="GST Name">
                                </div>

                                <div class="col-md-2">
                                    <select name="taxes[{{ $i }}][type]" class="form-control eForm-control">
                                        <option value="percentage" @selected($tax->type=='percentage')>Percentage
                                        </option>
                                        <option value="fixed" @selected($tax->type=='fixed')>Fixed</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <input type="number" name="taxes[{{ $i }}][rate]" value="{{ $tax->rate }}"
                                        class="form-control eForm-control">
                                </div>

                                <div class="col-md-2">
                                    <select name="taxes[{{ $i }}][status]" class="form-control eForm-control">
                                        <option value="active" @selected($tax->status=='active')>Active</option>
                                        <option value="inactive" @selected($tax->status=='inactive')>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger removeTax">X</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-primary addTax">Add Tax</button>

                <div class="text-end mt-2">
                    <button class="btn btn-success">Save Tax</button>
                </div>

            </form>


            {{-- ================= HSN ================= --}}
            <form action="{{ route('admin.hsn.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="branch_id" value="{{ $branch->id }}">

                <h5 class="eForm-label">HSN</h5>

                <div class="hsnRepeater">

                    @foreach($hsns[$branch->id] ?? [] as $i => $hsn)
                    <div class="card mb-2 hsn-row">
                        <div class="card-body">

                            <input type="hidden" name="hsns[{{ $i }}][branch_id]" value="{{ $branch->id }}">

                            <div class="row">

                                <div class="col-md-3">
                                    <input type="text" name="hsns[{{ $i }}][hsn_code]" value="{{ $hsn->hsn_code }}"
                                        class="form-control eForm-control" placeholder="HSN Code">
                                </div>

                                <div class="col-md-3">
                                    <input type="text" name="hsns[{{ $i }}][description]"
                                        value="{{ $hsn->description }}" class="form-control eForm-control"
                                        placeholder="Description">
                                </div>

                                <div class="col-md-3">
                                    <select name="hsns[{{ $i }}][tax_id]" class="form-control eForm-control">
                                        <option value="">Select GST</option>
                                        @foreach($taxes[$branch->id] ?? [] as $t)
                                        <option value="{{ $t->id }}" @selected($hsn->tax_id == $t->id)>
                                            {{ $t->name }} ({{ $t->rate }}%)
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger removeHsn">X</button>
                                </div>

                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>

                <button type="button" class="btn btn-primary addHsn">Add HSN</button>

                <div class="text-end mt-2">
                    <button class="btn btn-success">Save HSN</button>
                </div>

            </form>


            {{-- ================= BANK ================= --}}
            <form action="{{ route('admin.bank.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="branch_id" value="{{ $branch->id }}">

                <h5 class="eForm-label">Bank</h5>

                <div class="bankRepeater">

                    @foreach($banks[$branch->id] ?? [] as $i => $bank)
                    <div class="card mb-2 bank-row">
                        <div class="card-body">

                            <input type="hidden" name="banks[{{ $i }}][branch_id]" value="{{ $branch->id }}">

                            <div class="row">

                                <div class="col-md-3">
                                    <input type="text" name="banks[{{ $i }}][bank_name]" value="{{ $bank->bank_name }}"
                                        class="form-control eForm-control">
                                </div>

                                <div class="col-md-3">
                                    <input type="text" name="banks[{{ $i }}][ac_no]" value="{{ $bank->ac_no }}"
                                        class="form-control eForm-control">
                                </div>

                                <div class="col-md-3">
                                    <input type="text" name="banks[{{ $i }}][ifsc_code]" value="{{ $bank->ifsc_code }}"
                                        class="form-control eForm-control">
                                </div>

                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger removeBank">X</button>
                                </div>

                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>

                <button type="button" class="btn btn-primary addBank">Add Bank</button>

                <div class="text-end mt-2">
                    <button class="btn btn-success">Save Bank</button>
                </div>

            </form>

        </div>
        @endforeach

    </div>

</div>

@endsection


@push('js')

<script>
    document.addEventListener('click', function (e) {

        let activeTab = document.querySelector('.tab-pane.active');

        // TAX
        if (e.target.classList.contains('addTax')) {
            let container = activeTab.querySelector('.taxRepeater');
            let i = container.children.length;
            let branchId = activeTab.querySelector('input[name="branch_id"]').value;

            container.insertAdjacentHTML('beforeend', `
        <div class="card mb-2 tax-row">
            <div class="card-body">
                <input type="hidden" name="taxes[${i}][branch_id]" value="${branchId}">
                <div class="row">
                    <div class="col-md-3"><input type="text" name="taxes[${i}][name]" class="form-control eForm-control"></div>
                    <div class="col-md-2">
                        <select name="taxes[${i}][type]" class="form-control eForm-control">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>
                    <div class="col-md-2"><input type="number" name="taxes[${i}][rate]" class="form-control eForm-control"></div>
                    <div class="col-md-2">
                        <select name="taxes[${i}][status]" class="form-control eForm-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger removeTax">X</button>
                    </div>
                </div>
            </div>
        </div>`);
        }

        if (e.target.classList.contains('removeTax')) {
            e.target.closest('.tax-row').remove();
        }

        // HSN
        if (e.target.classList.contains('addHsn')) {
            let container = activeTab.querySelector('.hsnRepeater');
            let i = container.children.length;
            let branchId = activeTab.querySelector('input[name="branch_id"]').value;

            let taxOptions = activeTab.querySelector('.hsnRepeater select')?.innerHTML || '<option>Select GST</option>';

            container.insertAdjacentHTML('beforeend', `
        <div class="card mb-2 hsn-row">
            <div class="card-body">
                <input type="hidden" name="hsns[${i}][branch_id]" value="${branchId}">
                <div class="row">
                    <div class="col-md-3"><input type="text" name="hsns[${i}][hsn_code]" class="form-control eForm-control"></div>
                    <div class="col-md-3"><input type="text" name="hsns[${i}][description]" class="form-control eForm-control"></div>
                    <div class="col-md-3">
                        <select name="hsns[${i}][tax_id]" class="form-control eForm-control">
                            ${taxOptions}
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger removeHsn">X</button>
                    </div>
                </div>
            </div>
        </div>`);
        }

        if (e.target.classList.contains('removeHsn')) {
            e.target.closest('.hsn-row').remove();
        }

        // BANK
        if (e.target.classList.contains('addBank')) {
            let container = activeTab.querySelector('.bankRepeater');
            let i = container.children.length;
            let branchId = activeTab.querySelector('input[name="branch_id"]').value;

            container.insertAdjacentHTML('beforeend', `
        <div class="card mb-2 bank-row">
            <div class="card-body">
                <input type="hidden" name="banks[${i}][branch_id]" value="${branchId}">
                <div class="row">
                    <div class="col-md-3"><input type="text" name="banks[${i}][bank_name]" class="form-control eForm-control"></div>
                    <div class="col-md-3"><input type="text" name="banks[${i}][ac_no]" class="form-control eForm-control"></div>
                    <div class="col-md-3"><input type="text" name="banks[${i}][ifsc_code]" class="form-control eForm-control"></div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger removeBank">X</button>
                    </div>
                </div>
            </div>
        </div>`);
        }

        if (e.target.classList.contains('removeBank')) {
            e.target.closest('.bank-row').remove();
        }

    });
</script>

@endpush