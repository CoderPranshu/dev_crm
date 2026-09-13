@extends('index')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@section('content')

<style>
    :root {
        --qt-primary: #4f46e5;
        --qt-primary-soft: #eef2ff;
        --qt-primary-border: #c7d2fe;

        --qt-success: #059669;
        --qt-success-soft: #ecfdf5;

        --qt-danger: #dc2626;
        --qt-danger-soft: #fef2f2;

        --qt-warning: #d97706;
        --qt-warning-soft: #fffbeb;

        --qt-bg: #f4f7fb;
        --qt-card: #ffffff;
        --qt-border: #e5e7eb;

        --qt-text: #111827;
        --qt-muted: #6b7280;
        --qt-soft-text: #94a3b8;

        --qt-radius-lg: 20px;
        --qt-radius-md: 14px;
        --qt-radius-sm: 10px;

        --qt-shadow:
            0 10px 35px rgba(15, 23, 42, 0.07);
    }

    .quotation-taxonomy-page {
        padding-bottom: 40px;
    }

    .qt-topbar {
        background:
            linear-gradient(
                135deg,
                #ffffff 0%,
                #f8faff 55%,
                #f5f3ff 100%
            );
        border: 1px solid var(--qt-border);
        border-radius: var(--qt-radius-lg);
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: var(--qt-shadow);
    }

    .qt-topbar-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .qt-page-heading {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .qt-page-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(
            135deg,
            #4f46e5,
            #7c3aed
        );
        color: #fff;
        font-size: 20px;
        box-shadow: 0 8px 22px rgba(79, 70, 229, .22);
    }

    .qt-page-title {
        margin: 0;
        color: var(--qt-text);
        font-size: 23px;
        font-weight: 800;
        letter-spacing: -.3px;
    }

    .qt-page-subtitle {
        margin: 4px 0 0;
        color: var(--qt-muted);
        font-size: 13px;
    }

    .qt-top-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .qt-btn {
        border: none;
        outline: none;
        border-radius: 11px;
        padding: 10px 15px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        cursor: pointer;
        text-decoration: none;
        transition: all .2s ease;
    }

    .qt-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .qt-btn-primary {
        background: var(--qt-primary);
        color: #fff;
        box-shadow: 0 7px 18px rgba(79, 70, 229, .18);
    }

    .qt-btn-primary:hover {
        background: #4338ca;
        color: #fff;
    }

    .qt-btn-soft {
        background: #f8fafc;
        color: #334155;
        border: 1px solid var(--qt-border);
    }

    .qt-btn-success-soft {
        background: var(--qt-success-soft);
        color: var(--qt-success);
    }

    .qt-btn-warning-soft {
        background: var(--qt-warning-soft);
        color: var(--qt-warning);
    }

    .qt-btn-danger-soft {
        background: var(--qt-danger-soft);
        color: var(--qt-danger);
    }

    .qt-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .qt-summary-card {
        background: var(--qt-card);
        border: 1px solid var(--qt-border);
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 6px 24px rgba(15, 23, 42, .04);
    }

    .qt-summary-label {
        color: var(--qt-muted);
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .qt-summary-value {
        color: var(--qt-text);
        font-size: 24px;
        font-weight: 800;
        line-height: 1;
    }

    .qt-workspace {
        display: grid;
        grid-template-columns: 310px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .qt-sidebar,
    .qt-main-panel {
        background: var(--qt-card);
        border: 1px solid var(--qt-border);
        border-radius: var(--qt-radius-lg);
        box-shadow: var(--qt-shadow);
        overflow: hidden;
    }

    .qt-sidebar-header {
        padding: 18px;
        border-bottom: 1px solid var(--qt-border);
        background: #fbfcfe;
    }

    .qt-sidebar-title {
        margin: 0 0 4px;
        color: var(--qt-text);
        font-size: 15px;
        font-weight: 800;
    }

    .qt-sidebar-subtitle {
        margin: 0;
        color: var(--qt-muted);
        font-size: 12px;
    }

    .qt-category-list {
        padding: 10px;
        max-height: 690px;
        overflow-y: auto;
    }

    .qt-category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        width: 100%;
        padding: 12px;
        border-radius: 13px;
        border: 1px solid transparent;
        background: transparent;
        cursor: pointer;
        transition: all .2s ease;
        margin-bottom: 6px;
    }

    .qt-category-item:hover {
        background: #f8fafc;
        border-color: #edf0f4;
    }

    .qt-category-item.active {
        background: var(--qt-primary-soft);
        border-color: var(--qt-primary-border);
    }

    .qt-category-item-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .qt-category-avatar {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
    }

    .qt-category-item.active .qt-category-avatar {
        background: #fff;
        color: var(--qt-primary);
    }

    .qt-category-meta {
        min-width: 0;
    }

    .qt-category-name {
        color: var(--qt-text);
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .qt-category-count {
        color: var(--qt-muted);
        font-size: 11px;
        margin-top: 2px;
    }

    .qt-chevron {
        color: var(--qt-soft-text);
        font-size: 11px;
    }

    .qt-main-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--qt-border);
        background:
            linear-gradient(
                180deg,
                #ffffff 0%,
                #fcfdff 100%
            );
    }

    .qt-main-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .qt-selected-category {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .qt-selected-icon {
        width: 44px;
        height: 44px;
        border-radius: 13px;
        background: var(--qt-primary-soft);
        color: var(--qt-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .qt-selected-name {
        margin: 0;
        color: var(--qt-text);
        font-size: 18px;
        font-weight: 800;
    }

    .qt-selected-meta {
        margin-top: 3px;
        color: var(--qt-muted);
        font-size: 12px;
    }

    .qt-category-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .qt-main-body {
        padding: 22px;
    }

    .qt-section-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .qt-section-title {
        margin: 0;
        color: var(--qt-text);
        font-size: 15px;
        font-weight: 800;
    }

    .qt-section-subtitle {
        margin: 3px 0 0;
        color: var(--qt-muted);
        font-size: 12px;
    }

    .qt-subcategory-grid {
        display: grid;
        grid-template-columns:
            repeat(auto-fill, minmax(240px, 1fr));
        gap: 12px;
    }

    .qt-subcategory-card {
        position: relative;
        border: 1px solid var(--qt-border);
        background: #fff;
        border-radius: 14px;
        padding: 16px;
        transition: all .2s ease;
    }

    .qt-subcategory-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(15, 23, 42, .06);
    }

    .qt-subcategory-top {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: flex-start;
    }

    .qt-subcategory-info {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .qt-subcategory-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f8fafc;
        color: #64748b;
        border: 1px solid var(--qt-border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .qt-subcategory-title {
        color: #1f2937;
        font-size: 13px;
        font-weight: 700;
        word-break: break-word;
    }

    .qt-sub-actions {
        display: flex;
        gap: 5px;
        flex-shrink: 0;
    }

    .qt-icon-btn {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: .2s ease;
    }

    .qt-icon-btn:hover {
        transform: translateY(-1px);
    }

    .qt-empty-workspace {
        min-height: 350px;
        padding: 50px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .qt-empty-graphic {
        width: 72px;
        height: 72px;
        border-radius: 22px;
        background: var(--qt-primary-soft);
        color: var(--qt-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        margin-bottom: 16px;
    }

    .qt-empty-title {
        margin: 0 0 6px;
        color: var(--qt-text);
        font-size: 17px;
        font-weight: 800;
    }

    .qt-empty-text {
        max-width: 420px;
        margin: 0 0 16px;
        color: var(--qt-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .qt-alert-success {
        background: var(--qt-success-soft);
        border: 1px solid #a7f3d0;
        color: #047857;
        padding: 12px 15px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .qt-modal .modal-content {
        border: none;
        border-radius: 18px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, .22);
        overflow: hidden;
    }

    .qt-modal .modal-header {
        border-bottom: 1px solid var(--qt-border);
        padding: 18px 20px;
        background: #fbfcfe;
    }

    .qt-modal .modal-title {
        font-size: 17px;
        font-weight: 800;
        color: var(--qt-text);
    }

    .qt-modal .modal-body {
        padding: 20px;
    }

    .qt-modal .modal-footer {
        border-top: 1px solid var(--qt-border);
        padding: 14px 20px;
        background: #fbfcfe;
    }

    .qt-field {
        margin-bottom: 16px;
    }

    .qt-field:last-child {
        margin-bottom: 0;
    }

    .qt-label {
        display: block;
        color: #374151;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .qt-input {
        width: 100%;
        height: 44px;
        border: 1px solid #dbe1e8;
        border-radius: 11px;
        padding: 0 12px;
        color: var(--qt-text);
        font-size: 13px;
        background: #fff;
        outline: none;
        transition: .2s ease;
    }

    .qt-input:focus {
        border-color: var(--qt-primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, .09);
    }

    .qt-helper {
        color: var(--qt-muted);
        font-size: 11px;
        margin-top: 6px;
    }

    .qt-delete-form {
        margin: 0;
        display: inline-flex;
    }

    .qt-mobile-category-select {
        display: none;
        margin-bottom: 15px;
    }

    @media(max-width: 991px) {
        .qt-workspace {
            grid-template-columns: 1fr;
        }

        .qt-sidebar {
            display: none;
        }

        .qt-mobile-category-select {
            display: block;
        }

        .qt-summary-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width: 575px) {
        .qt-summary-grid {
            grid-template-columns: 1fr;
        }

        .qt-topbar {
            padding: 18px;
        }

        .qt-topbar-inner {
            align-items: flex-start;
        }

        .qt-top-actions {
            width: 100%;
        }

        .qt-top-actions .qt-btn {
            width: 100%;
        }

        .qt-main-header-row {
            align-items: flex-start;
        }

        .qt-category-actions {
            width: 100%;
        }

        .qt-category-actions .qt-btn {
            flex: 1;
        }
    }
</style>


@php
    $totalCategories = $categories->count();

    $totalSubcategories = $categories->sum(function ($category) {
        return $category->services->count();
    });

    $selectedCategory = $categories->first();
@endphp


<div class="container-fluid quotation-taxonomy-page">

    {{-- TOP HEADER --}}
    <div class="qt-topbar">

        <div class="qt-topbar-inner">

            <div class="qt-page-heading">

                <div class="qt-page-icon">
                    <i class="fa fa-sitemap"></i>
                </div>

                <div>
                    <h3 class="qt-page-title">
                        Quotation Structure
                    </h3>

                    <p class="qt-page-subtitle">
                        Build and manage quotation categories and subcategories.
                    </p>
                </div>

            </div>


            <div class="qt-top-actions">

                <button type="button"
                        class="qt-btn qt-btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal">

                    <i class="fa fa-plus"></i>
                    New Category

                </button>

            </div>

        </div>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="qt-alert-success">

            <i class="fa fa-check-circle me-1"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- SUMMARY --}}
    <div class="qt-summary-grid">

        <div class="qt-summary-card">

            <div class="qt-summary-label">
                Total Quotation Categories
            </div>

            <div class="qt-summary-value">
                {{ $totalCategories }}
            </div>

        </div>


        <div class="qt-summary-card">

            <div class="qt-summary-label">
                Total Quotation Services
            </div>

            <div class="qt-summary-value">
                {{ $totalSubcategories }}
            </div>

        </div>


        <div class="qt-summary-card">

            <div class="qt-summary-label">
                Active Structure
            </div>

            <div class="qt-summary-value">
                {{ $totalCategories ? 'Ready' : 'Empty' }}
            </div>

        </div>

    </div>


    @if($categories->count())

        {{-- MOBILE CATEGORY SWITCHER --}}
        <div class="qt-mobile-category-select">

            <select class="form-control"
                    id="mobileCategorySelector">

                @foreach($categories as $category)

                    <option value="category-panel-{{ $category->id }}">
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="qt-workspace">

            {{-- LEFT CATEGORY NAVIGATION --}}
            <aside class="qt-sidebar">

                <div class="qt-sidebar-header">

                    <h5 class="qt-sidebar-title">
                        Quotation Categories
                    </h5>

                    <p class="qt-sidebar-subtitle">
                        Select a category to manage its structure.
                    </p>

                </div>


                <div class="qt-category-list">

                    @foreach($categories as $category)

                        <button type="button"
                                class="qt-category-item {{ $loop->first ? 'active' : '' }}"
                                data-category-target="category-panel-{{ $category->id }}">

                            <div class="qt-category-item-left">

                                <div class="qt-category-avatar">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </div>

                                <div class="qt-category-meta">

                                    <div class="qt-category-name">
                                        {{ $category->name }}
                                    </div>

                                    <div class="qt-category-count">

                                        {{ $category->services->count() }}

                                        {{ $category->services->count() == 1
                                            ? 'subcategory'
                                            : 'subcategories'
                                        }}

                                    </div>

                                </div>

                            </div>


                            <i class="fa fa-chevron-right qt-chevron"></i>

                        </button>

                    @endforeach

                </div>

            </aside>


            {{-- RIGHT CATEGORY WORKSPACE --}}
            <section>

                @foreach($categories as $category)

                    <div class="qt-main-panel category-panel"
                         id="category-panel-{{ $category->id }}"
                         style="{{ !$loop->first ? 'display:none;' : '' }}">

                        {{-- CATEGORY HEADER --}}
                        <div class="qt-main-header">

                            <div class="qt-main-header-row">

                                <div class="qt-selected-category">

                                    <div class="qt-selected-icon">
                                        {{ strtoupper(substr($category->name, 0, 1)) }}
                                    </div>

                                    <div>

                                        <h4 class="qt-selected-name">
                                            {{ $category->name }}
                                        </h4>

                                        <div class="qt-selected-meta">

                                            {{ $category->services->count() }}

                                            {{ $category->services->count() == 1
                                                ? 'subcategory'
                                                : 'subcategories'
                                            }}

                                        </div>

                                    </div>

                                </div>


                                <div class="qt-category-actions">

                                    <button type="button"
                                            class="qt-btn qt-btn-success-soft"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addSubcategory{{ $category->id }}">

                                        <i class="fa fa-plus"></i>
                                        Add Quotation Services

                                    </button>


                                    <button type="button"
                                            class="qt-btn qt-btn-warning-soft"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCategory{{ $category->id }}">

                                        <i class="fa fa-edit"></i>
                                        Edit

                                    </button>


                                    <form action="{{ route('admin.quotation-categories.destroy', $category->id) }}"
                                          method="POST"
                                          class="qt-delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="qt-btn qt-btn-danger-soft"
                                                onclick="return confirm('Delete this category?')">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>


                        {{-- CATEGORY BODY --}}
                        <div class="qt-main-body">

                            <div class="qt-section-heading">

                                <div>

                                    <h5 class="qt-section-title">
                                        Quotation Services
                                    </h5>

                                    <p class="qt-section-subtitle">
                                        Manage quotation options under this category.
                                    </p>

                                </div>

                            </div>


                            @if($category->services->count())

                                <div class="qt-subcategory-grid">

                                    @foreach($category->services as $service)

                                        <div class="qt-subcategory-card">

                                            <div class="qt-subcategory-top">

                                                <div class="qt-subcategory-info">

                                                    <div class="qt-subcategory-icon">
                                                        <i class="fa fa-cube"></i>
                                                    </div>

                                                    <div class="qt-subcategory-title">
                                                        {{ $service->name }}
                                                    </div>

                                                </div>


                                                <div class="qt-sub-actions">

                                                    <button type="button"
                                                            class="qt-icon-btn qt-btn-warning-soft"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editSubcategory{{ $service->id }}">

                                                        <i class="fa fa-edit"></i>

                                                    </button>


                                                    <form action="{{ route('admin.quotation-subcategories.destroy', $service->id) }}"
                                                          method="POST"
                                                          class="qt-delete-form">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="qt-icon-btn qt-btn-danger-soft"
                                                                onclick="return confirm('Delete this subcategory?')">

                                                            <i class="fa fa-trash"></i>

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- EDIT SUBCATEGORY MODAL --}}
                                        <div class="modal fade qt-modal"
                                             id="editSubcategory{{ $service->id }}"
                                             tabindex="-1">

                                            <div class="modal-dialog modal-dialog-centered">

                                                <div class="modal-content">

                                                    <form action="{{ route('admin.quotation-subcategories.update', $service->id) }}"
                                                          method="POST">

                                                        @csrf
                                                        @method('PUT')


                                                        <div class="modal-header">

                                                            <h5 class="modal-title">
                                                                Edit Subcategory
                                                            </h5>

                                                            <button type="button"
                                                                    class="btn-close"
                                                                    data-bs-dismiss="modal">
                                                            </button>

                                                        </div>


                                                        <div class="modal-body">

                                                            <div class="qt-field">

                                                                <label class="qt-label">
                                                                    Subcategory Name
                                                                </label>

                                                                <input type="text"
                                                                       name="name"
                                                                       value="{{ $service->name }}"
                                                                       class="qt-input"
                                                                       required>

                                                            </div>

                                                        </div>


                                                        <div class="modal-footer">

                                                            <button type="button"
                                                                    class="qt-btn qt-btn-soft"
                                                                    data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>

                                                            <button type="submit"
                                                                    class="qt-btn qt-btn-primary">
                                                                Save Changes
                                                            </button>

                                                        </div>

                                                    </form>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="qt-empty-workspace">

                                    <div class="qt-empty-graphic">
                                        <i class="fa fa-folder-open"></i>
                                    </div>

                                    <h5 class="qt-empty-title">
                                        No Quotation Services Yet
                                    </h5>

                                    <p class="qt-empty-text">
                                        Add the first quotation option under
                                        {{ $category->name }}.
                                    </p>

                                    <button type="button"
                                            class="qt-btn qt-btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addSubcategory{{ $category->id }}">

                                        <i class="fa fa-plus"></i>
                                        Add First Subcategory

                                    </button>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- Add Quotation Services MODAL --}}
                    <div class="modal fade qt-modal"
                         id="addSubcategory{{ $category->id }}"
                         tabindex="-1">

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">

                                <form action="{{ route('admin.quotation-subcategories.store') }}"
                                      method="POST">

                                    @csrf


                                    <input type="hidden"
                                           name="category_id"
                                           value="{{ $category->id }}">


                                    <div class="modal-header">

                                        <div>

                                            <h5 class="modal-title">
                                                Add Quotation Services
                                            </h5>

                                            <div class="qt-helper">
                                                Under {{ $category->name }}
                                            </div>

                                        </div>


                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>

                                    </div>


                                    <div class="modal-body">

                                        <div class="qt-field">

                                            <label class="qt-label">
                                                Subcategory Name
                                            </label>

                                            <input type="text"
                                                   name="name"
                                                   class="qt-input"
                                                   placeholder="Enter subcategory"
                                                   required>

                                        </div>

                                    </div>


                                    <div class="modal-footer">

                                        <button type="button"
                                                class="qt-btn qt-btn-soft"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button type="submit"
                                                class="qt-btn qt-btn-primary">

                                            <i class="fa fa-plus"></i>
                                            Add Quotation Services

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>


                    {{-- EDIT CATEGORY MODAL --}}
                    <div class="modal fade qt-modal"
                         id="editCategory{{ $category->id }}"
                         tabindex="-1">

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">

                                <form action="{{ route('admin.quotation-categories.update', $category->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('PUT')


                                    <div class="modal-header">

                                        <h5 class="modal-title">
                                            Edit Category
                                        </h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>

                                    </div>


                                    <div class="modal-body">

                                        <div class="qt-field">

                                            <label class="qt-label">
                                                Category Name
                                            </label>

                                            <input type="text"
                                                   name="name"
                                                   value="{{ $category->name }}"
                                                   class="qt-input"
                                                   required>

                                        </div>

                                    </div>


                                    <div class="modal-footer">

                                        <button type="button"
                                                class="qt-btn qt-btn-soft"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button type="submit"
                                                class="qt-btn qt-btn-primary">
                                            Save Changes
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </section>

        </div>

    @else

        <div class="qt-main-panel">

            <div class="qt-empty-workspace">

                <div class="qt-empty-graphic">
                    <i class="fa fa-sitemap"></i>
                </div>

                <h5 class="qt-empty-title">
                    Start Your Quotation Structure
                </h5>

                <p class="qt-empty-text">
                    Create your first category, then organize all related
                    subcategories under it.
                </p>

                <button type="button"
                        class="qt-btn qt-btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal">

                    <i class="fa fa-plus"></i>
                    Create First Category

                </button>

            </div>

        </div>

    @endif

</div>


{{-- ADD CATEGORY MODAL --}}
<div class="modal fade qt-modal"
     id="addCategoryModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form action="{{ route('admin.quotation-categories.store') }}"
                  method="POST">

                @csrf


                <div class="modal-header">

                    <div>

                        <h5 class="modal-title">
                            Create Category
                        </h5>

                        <div class="qt-helper">
                            Create a category and optionally its first subcategory.
                        </div>

                    </div>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="qt-field">

                        <label class="qt-label">
                            Category Name
                        </label>

                        <input type="text"
                               name="name"
                               class="qt-input"
                               placeholder="Example: Website"
                               required>

                    </div>


                    <div class="qt-field">

                        <label class="qt-label">
                            First Subcategory
                        </label>

                        <input type="text"
                               name="subcategory_name"
                               class="qt-input"
                               placeholder="Example: Static Website">

                        <div class="qt-helper">
                            Optional. More can be added later.
                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="qt-btn qt-btn-soft"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="qt-btn qt-btn-primary">

                        <i class="fa fa-check"></i>
                        Create Category

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const categoryButtons =
        document.querySelectorAll('.qt-category-item');

    const categoryPanels =
        document.querySelectorAll('.category-panel');

    categoryButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId =
                this.getAttribute('data-category-target');


            categoryButtons.forEach(function (item) {
                item.classList.remove('active');
            });


            this.classList.add('active');


            categoryPanels.forEach(function (panel) {
                panel.style.display = 'none';
            });


            const targetPanel =
                document.getElementById(targetId);

            if (targetPanel) {
                targetPanel.style.display = 'block';
            }


            const mobileSelector =
                document.getElementById('mobileCategorySelector');

            if (mobileSelector) {
                mobileSelector.value = targetId;
            }

        });

    });


    const mobileSelector =
        document.getElementById('mobileCategorySelector');

    if (mobileSelector) {

        mobileSelector.addEventListener('change', function () {

            const targetId = this.value;


            categoryPanels.forEach(function (panel) {
                panel.style.display = 'none';
            });


            const targetPanel =
                document.getElementById(targetId);

            if (targetPanel) {
                targetPanel.style.display = 'block';
            }


            categoryButtons.forEach(function (item) {

                item.classList.remove('active');

                if (
                    item.getAttribute('data-category-target')
                    === targetId
                ) {
                    item.classList.add('active');
                }

            });

        });

    }

});
</script>

@endsection



