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
                    $finsishedproduct = DB::table('products')->where('category_id', 3)->get();
                    $rawproduct = DB::table('products')->where('category_id', 1)->get();
                @endphp

                <form action="{{ route('admin.bom.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <!-- Finished Product -->
                        <div class="@if(auth()->user()->hasRole('Admin')) col-md-6 @else col-md-12 @endif mb-3">
                            <label class="eForm-label">Finished Product *</label>
                            <select name="product_id" class="form-control eForm-control" required>
                                <option value="">Select Product</option>
                                @foreach ($finsishedproduct as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <!-- Version -->
                        <div class="col-md-6 mb-3">
                            <label class="eForm-label">Version</label>
                            <input type="text" name="version" value="1.0" class="form-control eForm-control">
                        </div> --}}

                        @if (auth()->user()->hasRole('Admin'))
                            <div class="col-md-6 mb-3">
                                <label class="eForm-label">Branch</label>
                                <select name="branch_id" class="form-control eForm-control" id="">
                                    @foreach ($branches as $b)
                                        <option value="{{ $b->id }}">{{ $b->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                        @endif

                        <!-- Notes -->
                        <div class="col-md-12 mb-3">
                            <label class="eForm-label">Notes</label>
                            <textarea name="notes" class="form-control eForm-control" rows="4"></textarea>
                        </div>

                        <!-- Active Switch -->
                        <div class="col-md-12 mb-3">
                            <label class="eForm-label d-block">Status</label>
                            <input type="checkbox" name="is_active" value="1" checked>
                            Active
                        </div>

                        <div class="col-md-12">
                            <h6 class="eForm-label">BOM Items</h6>
                            <table class="table table-bordered" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th class="eForm-label" width="40%">Raw Material</th>
                                        <th class="eForm-label" width="20%">Quantity</th>
                                        <th class="eForm-label" width="20%">Wastage %</th>
                                        <th class="eForm-label" width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>
                                            <select name="items[0][raw_product_id]" class="eForm-control form-control"
                                                required>
                                                @foreach ($rawproduct as $p)
                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" step="1" name="items[0][quantity]"
                                                class="eForm-label form-control" required>
                                        </td>

                                        <td>
                                            <input type="number" step="1" name="items[0][wastage_percent]"
                                                class="eForm-label form-control">
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger removeRow">X</button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <button type="button" class="btn-form btn-sm btn-secondary mb-3" id="addRow">+ Add
                                Item</button>
                        </div>

                        <!-- Submit -->
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn-form btn-primary w-100">
                                {{ get_phrase('Add') }}
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('jsbom')

@stop
