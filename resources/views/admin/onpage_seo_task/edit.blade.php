@extends('index')

@push('title', get_phrase('Edit On Page SEO Task'))

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    <i class="fa fa-edit text-primary me-2"></i>
                    Edit On Page SEO Task
                </h4>

                <a href="{{ route('admin.onpage-seo-task.index') }}"
                   class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i>
                    Back
                </a>

            </div>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.onpage-seo-task.update',$task->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Category
                            <span class="text-danger">*</span>
                        </label>

                        <select name="category_id"
                                class="form-select"
                                required>

                            <option value="">Select Category</option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ $task->category_id == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Task Name
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="task_name"
                            class="form-control"
                            value="{{ old('task_name',$task->task_name) }}"
                            required>

                    </div>

                    <div class="col-md-12 mb-4">

                        <label class="form-label">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            class="form-control">{{ old('description',$task->description) }}</textarea>

                    </div>

                    <div class="col-md-4 mb-4">

                        <label class="form-label">

                            Priority

                        </label>

                        <select
                            name="priority"
                            class="form-select">

                            <option value="low"
                                {{ $task->priority=='low'?'selected':'' }}>
                                Low
                            </option>

                            <option value="medium"
                                {{ $task->priority=='medium'?'selected':'' }}>
                                Medium
                            </option>

                            <option value="high"
                                {{ $task->priority=='high'?'selected':'' }}>
                                High
                            </option>

                        </select>

                    </div>

                    <div class="col-md-4 mb-4">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="active"
                                {{ $task->status=='active'?'selected':'' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ $task->status=='inactive'?'selected':'' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                    <div class="col-md-4 mb-4">

                        <label class="form-label">

                            Sort Order

                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order',$task->sort_order) }}">

                    </div>

                </div>

                <div class="text-end">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fa fa-save me-1"></i>

                        Update Task

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection