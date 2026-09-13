@extends('index')

@push('title', get_phrase('Edit SEO Plan'))

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>
    :root {
        --seo-primary: #0f8ea3;
        --seo-primary-dark: #087789;
        --seo-secondary: #18b7c9;
        --seo-bg: #f6f9fb;
        --seo-border: #e4ebef;
        --seo-text: #172033;
        --seo-muted: #7b8794;
        --seo-success: #16a34a;
        --seo-danger: #ef4444;
        --seo-warning: #f59e0b;
        --seo-radius: 18px;
    }

    .seo-edit-page {
        padding-bottom: 50px;
    }

    /* =========================
       PAGE HEADER
    ========================== */

    .seo-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .seo-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--seo-primary);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .seo-eyebrow span {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--seo-primary);
        box-shadow: 0 0 0 5px rgba(15,142,163,.10);
    }

    .seo-page-title {
        margin: 0;
        color: var(--seo-text);
        font-size: 28px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .seo-page-subtitle {
        margin: 7px 0 0;
        color: var(--seo-muted);
        font-size: 13px;
    }

    .seo-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 17px;
        border: 1px solid var(--seo-border);
        border-radius: 11px;
        background: #fff;
        color: #344054;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .25s ease;
    }

    .seo-back-btn:hover {
        color: var(--seo-primary);
        border-color: rgba(15,142,163,.3);
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(15,142,163,.08);
    }

    /* =========================
       MAIN CARD
    ========================== */

    .seo-editor {
        background: #fff;
        border: 1px solid var(--seo-border);
        border-radius: 22px;
        box-shadow:
            0 18px 45px rgba(25, 50, 65, .07),
            0 3px 10px rgba(25, 50, 65, .03);
        overflow: hidden;
    }

    .seo-editor-top {
        position: relative;
        padding: 24px 26px;
        background:
            radial-gradient(circle at 85% 20%, rgba(24,183,201,.10), transparent 28%),
            linear-gradient(135deg, #ffffff 0%, #f8fcfd 100%);
        border-bottom: 1px solid var(--seo-border);
    }

    .seo-editor-top::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(
            90deg,
            var(--seo-primary),
            var(--seo-secondary),
            #76d6df
        );
    }

    .seo-plan-identity {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .seo-plan-icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        color: #fff;
        background: linear-gradient(
            135deg,
            var(--seo-primary),
            var(--seo-secondary)
        );
        box-shadow: 0 10px 22px rgba(15,142,163,.22);
        font-size: 18px;
    }

    .seo-plan-kicker {
        display: block;
        margin-bottom: 3px;
        color: var(--seo-muted);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.1px;
        text-transform: uppercase;
    }

    .seo-plan-name-preview {
        margin: 0;
        color: var(--seo-text);
        font-size: 18px;
        font-weight: 800;
    }

    .seo-plan-badge {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(15,142,163,.08);
        color: var(--seo-primary);
        font-size: 11px;
        font-weight: 800;
    }

    /* =========================
       BASIC INFORMATION
    ========================== */

    .seo-section {
        padding: 26px;
        border-bottom: 1px solid var(--seo-border);
    }

    .seo-section:last-child {
        border-bottom: 0;
    }

    .seo-section-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .seo-section-number {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(15,142,163,.09);
        color: var(--seo-primary);
        font-size: 11px;
        font-weight: 900;
    }

    .seo-section-title {
        margin: 0;
        color: var(--seo-text);
        font-size: 15px;
        font-weight: 800;
    }

    .seo-section-description {
        margin: 3px 0 0;
        color: var(--seo-muted);
        font-size: 12px;
    }

    .seo-label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    .seo-required {
        color: var(--seo-danger);
    }

    .seo-input,
    .seo-select {
        width: 100%;
        min-height: 46px;
        border: 1px solid #dfe7eb;
        border-radius: 11px;
        background: #fff;
        color: #253142;
        font-size: 13px;
        padding: 10px 13px;
        box-shadow: none !important;
        transition: .25s ease;
    }

    .seo-input:focus,
    .seo-select:focus {
        border-color: var(--seo-primary);
        box-shadow: 0 0 0 4px rgba(15,142,163,.09) !important;
        outline: 0;
    }

    /* =========================
       WEEKLY TASK ARCHITECTURE
    ========================== */

    .seo-week-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .seo-day-card {
        position: relative;
        border: 1px solid var(--seo-border);
        border-radius: 17px;
        background: #fff;
        overflow: hidden;
        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
    }

    .seo-day-card:hover {
        transform: translateY(-2px);
        border-color: rgba(15,142,163,.24);
        box-shadow: 0 14px 30px rgba(25,50,65,.07);
    }

    .seo-day-card.is-open {
        border-color: rgba(15,142,163,.28);
        box-shadow: 0 14px 30px rgba(15,142,163,.08);
    }

    .seo-day-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 17px;
        background: linear-gradient(
            180deg,
            #ffffff,
            #f9fcfd
        );
        cursor: pointer;
        user-select: none;
    }

    .seo-day-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: rgba(15,142,163,.09);
        color: var(--seo-primary);
        font-size: 14px;
    }

    .seo-day-title {
        margin: 0;
        color: var(--seo-text);
        font-size: 13px;
        font-weight: 800;
    }

    .seo-day-meta {
        margin-top: 3px;
        color: var(--seo-muted);
        font-size: 10px;
    }

    .seo-day-count {
        margin-left: auto;
        min-width: 29px;
        height: 25px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #eef7f9;
        color: var(--seo-primary);
        font-size: 10px;
        font-weight: 800;
    }

    .seo-chevron {
        width: 27px;
        height: 27px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f4f7f8;
        color: #667085;
        transition: transform .25s ease;
    }

    .seo-day-card.is-open .seo-chevron {
        transform: rotate(180deg);
        color: var(--seo-primary);
    }

    .seo-day-body {
        display: none;
        padding: 0 15px 15px;
        border-top: 1px solid #edf2f4;
    }

    .seo-day-card.is-open .seo-day-body {
        display: block;
        animation: seoReveal .25s ease;
    }

    @keyframes seoReveal {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* =========================
       TASK ROW
    ========================== */

    .seo-task-list {
        padding-top: 12px;
    }

    .seo-task-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 145px 40px;
        gap: 9px;
        align-items: center;
        padding: 9px;
        margin-bottom: 8px;
        border: 1px solid #e8eef1;
        border-radius: 12px;
        background: #fbfcfd;
        transition: .2s ease;
    }

    .seo-task-row:hover {
        border-color: rgba(15,142,163,.22);
        background: #fff;
        box-shadow: 0 7px 16px rgba(25,50,65,.05);
    }

    .seo-task-number {
        position: absolute;
        margin-left: 8px;
        font-size: 9px;
        font-weight: 800;
        color: #98a2b3;
        pointer-events: none;
    }

    .seo-task-input {
        padding-left: 27px !important;
    }

    .seo-remove {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #f0d9dd;
        border-radius: 10px;
        background: #fff7f8;
        color: #dc3545;
        transition: .2s ease;
    }

    .seo-remove:hover {
        background: #dc3545;
        color: #fff;
        border-color: #dc3545;
        transform: scale(1.04);
    }

    .seo-add-task {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 40px;
        margin-top: 9px;
        border: 1px dashed rgba(15,142,163,.35);
        border-radius: 11px;
        background: rgba(15,142,163,.025);
        color: var(--seo-primary);
        font-size: 11px;
        font-weight: 800;
        transition: .2s ease;
    }

    .seo-add-task:hover {
        background: rgba(15,142,163,.08);
        border-color: var(--seo-primary);
    }

    /* =========================
       DAY SUMMARY
    ========================== */

    .seo-day-summary {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .seo-repeat-summary {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 999px;
        background: #f2f5f7;
        color: #667085;
        font-size: 9px;
        font-weight: 700;
    }

    /* =========================
       FOOTER
    ========================== */

    .seo-form-footer {
        position: sticky;
        bottom: 15px;
        z-index: 20;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        padding: 13px;
        border: 1px solid rgba(228,235,239,.9);
        border-radius: 16px;
        background: rgba(255,255,255,.88);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 15px 35px rgba(25,50,65,.10);
    }

    .seo-btn {
        min-height: 43px;
        padding: 0 17px;
        border-radius: 11px;
        font-size: 12px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: .2s ease;
    }

    .seo-btn-secondary {
        border: 1px solid #dfe6e9;
        background: #fff;
        color: #475467;
    }

    .seo-btn-secondary:hover {
        color: var(--seo-primary);
        border-color: rgba(15,142,163,.3);
    }

    .seo-btn-primary {
        border: 1px solid transparent;
        color: #fff;
        background: linear-gradient(
            135deg,
            var(--seo-primary),
            var(--seo-secondary)
        );
        box-shadow: 0 9px 20px rgba(15,142,163,.20);
    }

    .seo-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 13px 25px rgba(15,142,163,.26);
    }

    /* =========================
       RESPONSIVE
    ========================== */

    @media(max-width: 992px) {
        .seo-week-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 768px) {
        .seo-page-header {
            flex-direction: column;
        }

        .seo-page-title {
            font-size: 23px;
        }

        .seo-editor-top,
        .seo-section {
            padding: 18px;
        }

        .seo-plan-badge {
            display: none;
        }

        .seo-task-row {
            grid-template-columns: 1fr;
        }

        .seo-remove {
            width: 100%;
        }

        .seo-form-footer {
            bottom: 8px;
        }
    }
</style>
@endpush


@section('content')

@php
    $days = [
        'monday'    => 'Monday',
        'tuesday'   => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday'  => 'Thursday',
        'friday'    => 'Friday',
        'saturday'  => 'Saturday',
    ];

    $dayIcons = [
        'monday'    => 'fa-calendar-day',
        'tuesday'   => 'fa-calendar-day',
        'wednesday' => 'fa-calendar-day',
        'thursday'  => 'fa-calendar-day',
        'friday'    => 'fa-calendar-day',
        'saturday'  => 'fa-calendar-day',
    ];

    /*
     * Controller se $tasksByDay aayega.
     * Example:
     * $tasksByDay['monday']
     */
@endphp

<div class="seo-edit-page">

    {{-- ========================= PAGE HEADER ========================= --}}
    <div class="seo-page-header">

        <div>
            <div class="seo-eyebrow">
                <span></span>
                SEO PLAN MANAGEMENT
            </div>

            <h1 class="seo-page-title">
                Edit SEO Plan
            </h1>

            <p class="seo-page-subtitle">
                Update plan details, weekly task architecture and repeat schedules.
            </p>
        </div>

        <a href="{{ route('admin.seo-plans.index') }}"
           class="seo-back-btn">

            <i class="fi-rr-arrow-left"></i>

            Back to SEO Plans

        </a>

    </div>


    {{-- ========================= EDITOR ========================= --}}
    <div class="seo-editor">

        {{-- ========================= PLAN IDENTITY ========================= --}}
        <div class="seo-editor-top">

            <div class="seo-plan-identity">

                <div class="seo-plan-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

                <div>

                    <span class="seo-plan-kicker">
                        Editing SEO Plan
                    </span>

                    <h2 class="seo-plan-name-preview">
                        {{ $plan->name }}
                    </h2>

                </div>

                <div class="seo-plan-badge">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Update Mode
                </div>

            </div>

        </div>


        <form action="{{ route('admin.seo-plans.update', $plan->id) }}"
              method="POST"
              id="seoPlanEditForm">

            @csrf
            @method('PUT')


            {{-- ========================= BASIC INFORMATION ========================= --}}
            <div class="seo-section">

                <div class="seo-section-head">

                    <div class="seo-section-number">
                        01
                    </div>

                    <div>
                        <h3 class="seo-section-title">
                            Plan Information
                        </h3>

                        <p class="seo-section-description">
                            Configure the core identity and lifecycle of this SEO plan.
                        </p>
                    </div>

                </div>


                <div class="row g-3">

                    {{-- SEO SERVICE --}}
                    <div class="col-lg-5">

                        <label class="seo-label">
                            SEO Service
                            <span class="seo-required">*</span>
                        </label>

                        <select name="seo_service_id"
                                class="seo-select"
                                required>

                            <option value="">
                                Select SEO Service
                            </option>

                            @foreach($seoServices as $service)

                                <option value="{{ $service->id }}"
                                    @selected(old('seo_service_id', $plan->seo_service_id) == $service->id)>

                                    {{ $service->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- PLAN NAME --}}
                    <div class="col-lg-4">

                        <label class="seo-label">
                            Plan Name
                            <span class="seo-required">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               class="seo-input"
                               value="{{ old('name', $plan->name) }}"
                               placeholder="e.g. Premium SEO Growth Plan"
                               required>

                    </div>


                    {{-- DURATION --}}
                    <div class="col-lg-1 col-md-6">

                        <label class="seo-label">
                            Duration
                        </label>

                        <input type="number"
                               name="duration"
                               class="seo-input"
                               min="1"
                               value="{{ old('duration', $plan->duration) }}">

                    </div>


                    {{-- STATUS --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="seo-label">
                            Status
                        </label>

                        <select name="status"
                                class="seo-select">

                            <option value="1"
                                @selected(old('status', $plan->status) == 1)>
                                Active
                            </option>

                            <option value="0"
                                @selected(old('status', $plan->status) == 0)>
                                Inactive
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- ========================= WEEKLY TASK ARCHITECTURE ========================= --}}
            <div class="seo-section">

                <div class="seo-section-head">

                    <div class="seo-section-number">
                        02
                    </div>

                    <div>
                        <h3 class="seo-section-title">
                            Weekly Task Architecture
                        </h3>

                        <p class="seo-section-description">
                            Manage the recurring task structure of this SEO plan.
                        </p>
                    </div>

                </div>


                <div class="seo-week-grid">

                    @foreach($days as $dayKey => $dayName)

                        @php
                            $dayTasks = $tasksByDay->get($dayKey, collect());
                            $isOpen = $dayKey === 'monday' || $dayTasks->count() > 0;
                        @endphp

                        <div class="seo-day-card {{ $isOpen ? 'is-open' : '' }}"
                             data-day-card="{{ $dayKey }}">

                            {{-- DAY HEADER --}}
                            <div class="seo-day-header">

                                <div class="seo-day-icon">

                                    <i class="fa-solid {{ $dayIcons[$dayKey] }}"></i>

                                </div>

                                <div>

                                    <h4 class="seo-day-title">
                                        {{ $dayName }}
                                    </h4>

                                    <div class="seo-day-meta">
                                        Weekly task schedule
                                    </div>

                                </div>

                                <span class="seo-day-count"
                                      data-day-count="{{ $dayKey }}">
                                    {{ $dayTasks->count() }}
                                </span>

                                <div class="seo-chevron">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>

                            </div>


                            {{-- DAY BODY --}}
                            <div class="seo-day-body">

                                <div class="seo-task-list"
                                     id="{{ $dayKey }}TaskList">

                                    @forelse($dayTasks as $index => $task)

                                        <div class="seo-task-row">

                                            {{-- Existing Task ID --}}
                                            <input type="hidden"
                                                   name="task_ids[{{ $dayKey }}][]"
                                                   value="{{ $task->id }}">

                                            <div style="position:relative;">

                                                <span class="seo-task-number">
                                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                                </span>

                                                <input type="text"
                                                       name="tasks[{{ $dayKey }}][]"
                                                       class="seo-input seo-task-input"
                                                       value="{{ old('tasks.' . $dayKey . '.' . $index, $task->task_title) }}"
                                                       placeholder="Enter SEO task..."
                                                       autocomplete="off">

                                            </div>


                                            <select name="repeat_type[{{ $dayKey }}][]"
                                                    class="seo-select">

                                                <option value="weekly"
                                                    @selected(old(
                                                        'repeat_type.' . $dayKey . '.' . $index,
                                                        $task->repeat_type
                                                    ) === 'weekly')>
                                                    Weekly
                                                </option>

                                                <option value="monthly"
                                                    @selected(old(
                                                        'repeat_type.' . $dayKey . '.' . $index,
                                                        $task->repeat_type
                                                    ) === 'monthly')>
                                                    Monthly
                                                </option>

                                                <option value="first_time"
                                                    @selected(old(
                                                        'repeat_type.' . $dayKey . '.' . $index,
                                                        $task->repeat_type
                                                    ) === 'first_time')>
                                                    First Time
                                                </option>

                                            </select>


                                            <button type="button"
                                                    class="seo-remove removeTask"
                                                    title="Remove task">

                                                <i class="fa-solid fa-xmark"></i>

                                            </button>

                                        </div>

                                    @empty

                                        <div class="seo-task-row">

                                            <input type="hidden"
                                                   name="task_ids[{{ $dayKey }}][]"
                                                   value="">

                                            <div style="position:relative;">

                                                <span class="seo-task-number">
                                                    01
                                                </span>

                                                <input type="text"
                                                       name="tasks[{{ $dayKey }}][]"
                                                       class="seo-input seo-task-input"
                                                       placeholder="Enter SEO task..."
                                                       autocomplete="off">

                                            </div>

                                            <select name="repeat_type[{{ $dayKey }}][]"
                                                    class="seo-select">

                                                <option value="weekly" selected>
                                                    Weekly
                                                </option>

                                                <option value="monthly">
                                                    Monthly
                                                </option>

                                                <option value="first_time">
                                                    First Time
                                                </option>

                                            </select>

                                            <button type="button"
                                                    class="seo-remove removeTask"
                                                    title="Remove task">

                                                <i class="fa-solid fa-xmark"></i>

                                            </button>

                                        </div>

                                    @endforelse

                                </div>


                                <button type="button"
                                        class="seo-add-task addTask"
                                        data-day="{{ $dayKey }}">

                                    <i class="fa-solid fa-plus"></i>

                                    Add Task

                                </button>


                                <div class="seo-day-summary">

                                    <span class="seo-repeat-summary">
                                        <i class="fa-solid fa-repeat"></i>
                                        Weekly
                                    </span>

                                    <span class="seo-repeat-summary">
                                        <i class="fa-regular fa-calendar"></i>
                                        Monthly
                                    </span>

                                    <span class="seo-repeat-summary">
                                        <i class="fa-solid fa-bolt"></i>
                                        First Time
                                    </span>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </form>

    </div>


    {{-- ========================= STICKY ACTION BAR ========================= --}}
    <div class="seo-form-footer">

        <a href="{{ route('admin.seo-plans.index') }}"
           class="seo-btn seo-btn-secondary">

            <i class="fa-solid fa-xmark"></i>

            Cancel

        </a>

        <button type="submit"
                form="seoPlanEditForm"
                class="seo-btn seo-btn-primary">

            <i class="fa-solid fa-check"></i>

            Update SEO Plan

        </button>

    </div>

</div>

@endsection


@push('js')
<script>

document.addEventListener('DOMContentLoaded', function () {

    'use strict';


    /* =========================================================
       DAY ACCORDION
    ========================================================= */

    document.querySelectorAll('.seo-day-header').forEach(function (header) {

        header.addEventListener('click', function () {

            const card = this.closest('.seo-day-card');

            card.classList.toggle('is-open');

        });

    });


    /* =========================================================
       CREATE TASK ROW
    ========================================================= */

    function createTaskRow(day) {

        const row = document.createElement('div');

        row.className = 'seo-task-row';

        row.innerHTML = `
            <input type="hidden"
                   name="task_ids[${day}][]"
                   value="">

            <div style="position:relative;">

                <span class="seo-task-number">
                    01
                </span>

                <input type="text"
                       name="tasks[${day}][]"
                       class="seo-input seo-task-input"
                       placeholder="Enter SEO task..."
                       autocomplete="off">

            </div>

            <select name="repeat_type[${day}][]"
                    class="seo-select">

                <option value="weekly" selected>
                    Weekly
                </option>

                <option value="monthly">
                    Monthly
                </option>

                <option value="first_time">
                    First Time
                </option>

            </select>

            <button type="button"
                    class="seo-remove removeTask"
                    title="Remove task">

                <i class="fa-solid fa-xmark"></i>

            </button>
        `;

        return row;
    }


    /* =========================================================
       ADD TASK
    ========================================================= */

    document.querySelectorAll('.addTask').forEach(function (button) {

        button.addEventListener('click', function () {

            const day = this.dataset.day;

            const list = document.getElementById(day + 'TaskList');

            if (!list) {
                return;
            }

            const row = createTaskRow(day);

            list.appendChild(row);

            renumberTasks(day);

            updateDayCount(day);

            const card = this.closest('.seo-day-card');

            if (card) {
                card.classList.add('is-open');
            }

            const input = row.querySelector('input[type="text"]');

            if (input) {
                setTimeout(function () {
                    input.focus();
                }, 50);
            }

        });

    });


    /* =========================================================
       REMOVE TASK
    ========================================================= */

    document.addEventListener('click', function (event) {

        const removeButton = event.target.closest('.removeTask');

        if (!removeButton) {
            return;
        }

        const row = removeButton.closest('.seo-task-row');

        const list = removeButton.closest('.seo-task-list');

        if (!row || !list) {
            return;
        }

        const rows = list.querySelectorAll('.seo-task-row');

        /*
         * At least one blank row remains in each day.
         * This keeps the existing create-page behaviour friendly.
         */

        if (rows.length === 1) {

            const textInput = row.querySelector('input[type="text"]');

            const hiddenInput = row.querySelector('input[type="hidden"]');

            const select = row.querySelector('select');

            if (textInput) {
                textInput.value = '';
            }

            if (hiddenInput) {
                hiddenInput.value = '';
            }

            if (select) {
                select.value = 'weekly';
            }

        } else {

            row.remove();

        }

        const day = list.id.replace('TaskList', '');

        renumberTasks(day);

        updateDayCount(day);

    });


    /* =========================================================
       NUMBER TASKS
    ========================================================= */

    function renumberTasks(day) {

        const list = document.getElementById(day + 'TaskList');

        if (!list) {
            return;
        }

        list.querySelectorAll('.seo-task-row').forEach(function (row, index) {

            const number = row.querySelector('.seo-task-number');

            if (number) {

                number.textContent =
                    String(index + 1).padStart(2, '0');

            }

        });

    }


    /* =========================================================
       DAY COUNT
    ========================================================= */

    function updateDayCount(day) {

        const list = document.getElementById(day + 'TaskList');

        const counter = document.querySelector(
            `[data-day-count="${day}"]`
        );

        if (!list || !counter) {
            return;
        }

        let count = 0;

        list.querySelectorAll('input[type="text"]').forEach(function (input) {

            if (input.value.trim() !== '') {
                count++;
            }

        });

        counter.textContent = count;

    }


    /* =========================================================
       LIVE COUNT WHEN USER TYPES
    ========================================================= */

    document.addEventListener('input', function (event) {

        if (!event.target.matches('.seo-task-input')) {
            return;
        }

        const list = event.target.closest('.seo-task-list');

        if (!list) {
            return;
        }

        const day = list.id.replace('TaskList', '');

        updateDayCount(day);

    });


    /* =========================================================
       INITIAL DAY COUNTERS
    ========================================================= */

    document.querySelectorAll('.seo-day-card').forEach(function (card) {

        const list = card.querySelector('.seo-task-list');

        if (!list) {
            return;
        }

        const day = list.id.replace('TaskList', '');

        renumberTasks(day);

        updateDayCount(day);

    });


    /* =========================================================
       FORM SUBMIT PROTECTION
    ========================================================= */

    const form = document.getElementById('seoPlanEditForm');

    if (form) {

        form.addEventListener('submit', function () {

            const submitButton =
                document.querySelector(
                    '[form="seoPlanEditForm"][type="submit"]'
                );

            if (submitButton) {

                submitButton.disabled = true;

                submitButton.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Updating...
                `;

            }

        });

    }

});

</script>
@endpush
