@extends('index')
@push('title', get_phrase('BOM'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    @php
        $branches = \App\Models\Branch::get();
    @endphp
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('BOM') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('BOM') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('BOM') }}</p>
                @php
                    $products = DB::table('products')->get();
                    $bom = \App\Models\Bom::where('id', $id)->first();
                @endphp

                <form action="{{ route('admin.bom.update', $bom->id) }}" method="POST">
                    @Csrf

                    <div class="row">

                        <!-- Finished Product -->
                        <div class="@if(auth()->user()->hasRole('Admin')) col-md-6 @else col-md-12 @endif mb-3">
                            <label class="eForm-label">Finished Product *</label>
                            <select name="product_id" class="form-control eForm-control" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}" @selected($p->id == $bom->product_id)>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if (auth()->user()->hasRole('Admin'))
                            <div class="col-md-6 mb-3">
                                <label class="eForm-label">Branch</label>
                                <select name="branch_id" class="form-control eForm-control">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" @selected($bom->branch_id == $branch->id)>
                                            {{ $branch->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <!-- Version -->
                        {{-- <div class="col-md-12 mb-3">
                            <label class="eForm-label">Version</label>
                            <input type="text" name="version" class="form-control eForm-control"
                                value="{{ $bom->version }}">
                        </div> --}}

                        <!-- Notes -->
                        <div class="col-md-12 mb-3">
                            <label class="eForm-label">Notes</label>
                            <textarea name="notes" class="form-control eForm-control" rows="4">
                {{ $bom->notes }}
            </textarea>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12 mb-3">
                            <label class="eForm-label d-block">Status</label>
                            <input type="checkbox" name="is_active" value="1" @checked($bom->is_active)>
                            Active
                        </div>

                        <!-- 🟧 BOM ITEMS -->
                        <div class="col-md-12">
                            <h5>BOM Items</h5>

                            <table class="table table-bordered" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th class="eForm-label" width="40%">Raw Material</th>
                                        <th class="eForm-label" width="20%">Qty</th>
                                        <th class="eForm-label" width="20%">Wastage %</th>
                                        <th class="eForm-label" width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bom->items as $index => $item)
                                        <tr>
                                            <input type="hidden" name="items[{{ $index }}][id]"
                                                value="{{ $item->id }}">

                                            <td>
                                                <select name="items[{{ $index }}][raw_product_id]"
                                                    class="eForm-control form-control" required>
                                                    @foreach ($products as $p)
                                                        <option value="{{ $p->id }}" @selected($p->id == $item->raw_product_id)>
                                                            {{ $p->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <input type="number" step="1"
                                                    name="items[{{ $index }}][quantity]"
                                                    class="eForm-control form-control" value="{{ $item->quantity }}"
                                                    required>
                                            </td>

                                            <td>
                                                <input type="number" step="1"
                                                    name="items[{{ $index }}][wastage_percent]"
                                                    class="eForm-control form-control"
                                                    value="{{ $item->wastage_percent }}">
                                            </td>

                                            <td>
                                                <button type="button"
                                                    class="btn-form btn-sm btn-danger removeRow">X</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="button" class="btn-form btn-sm btn-secondary mb-3" id="addRow">+ Add
                                Item</button>
                        </div>

                        <!-- Submit -->
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100">
                                Update BOM
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('jsbomedit')

@stop
