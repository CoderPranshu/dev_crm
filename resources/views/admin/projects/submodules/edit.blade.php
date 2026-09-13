@extends('index')

@push('title', 'Edit Sub Module')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fas fa-edit text-warning"></i>

                Edit Sub Module

            </h3>

            <small class="text-muted">

                Project :
                <strong>{{ $module->project->project_name ?? 'N/A' }}</strong>

                &nbsp; | &nbsp;

                Module :
                <strong>{{ $module->module_name }}</strong>

            </small>

        </div>

        <a href="{{ route('admin.modules.show',$module->id) }}"
           class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left"></i>

            Back

        </a>

    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                <i class="fas fa-pencil-alt text-primary"></i>

                Update Sub Module

            </h5>

        </div>

        <div class="card-body">

            <form
                action="{{ route('submodules.update',[$module->id,$submodule->id]) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Name -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            Sub Module Name

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="sub_module_name"
                            class="form-control @error('sub_module_name') is-invalid @enderror"
                            value="{{ old('sub_module_name',$submodule->sub_module_name) }}">

                        @error('sub_module_name')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <!-- Priority -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            Priority

                        </label>

                        <select
                            name="priority"
                            class="form-select">

                            <option value="Low"
                                {{ old('priority',$submodule->priority)=='Low' ? 'selected' : '' }}>
                                Low
                            </option>

                            <option value="Medium"
                                {{ old('priority',$submodule->priority)=='Medium' ? 'selected' : '' }}>
                                Medium
                            </option>

                            <option value="High"
                                {{ old('priority',$submodule->priority)=='High' ? 'selected' : '' }}>
                                High
                            </option>

                            <option value="Critical"
                                {{ old('priority',$submodule->priority)=='Critical' ? 'selected' : '' }}>
                                Critical
                            </option>

                        </select>

                    </div>

                    <!-- Estimated Hours -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">

                            Estimated Hours

                        </label>

                        <input
                            type="number"
                            step="0.5"
                            min="0"
                            name="estimated_hours"
                            class="form-control"
                            value="{{ old('estimated_hours',$submodule->estimated_hours) }}">

                    </div>

                    <!-- Actual Hours -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">

                            Actual Hours

                        </label>

                        <input
                            type="number"
                            step="0.5"
                            min="0"
                            name="actual_hours"
                            class="form-control"
                            value="{{ old('actual_hours',$submodule->actual_hours) }}"
                            readonly>

                    </div>

                    <!-- Status -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label fw-bold">

                            Current Status

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $submodule->status }}"
                            readonly>

                    </div>

                    <!-- Start Date -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            Start Date

                        </label>

                        <input
                            type="date"
                            name="start_date"
                            class="form-control"
                            value="{{ old('start_date',optional($submodule->start_date)->format('Y-m-d')) }}">

                    </div>

                    <!-- Deadline -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-bold">

                            Deadline

                        </label>

                        <input
                            type="date"
                            name="deadline"
                            class="form-control"
                            value="{{ old('deadline',optional($submodule->deadline)->format('Y-m-d')) }}">

                    </div>

                    <!-- Description -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label fw-bold">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="6"
                            class="form-control">{{ old('description',$submodule->description) }}</textarea>

                    </div>

                </div>

                <hr>

                <div class="text-end">

                    <a
                        href="{{ route('admin.modules.show',$module->id) }}"
                        class="btn btn-light">

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="btn btn-warning">

                        <i class="fas fa-save"></i>

                        Update Sub Module

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection