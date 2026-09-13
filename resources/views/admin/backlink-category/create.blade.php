@extends('index')

@push('title', get_phrase('Create Backlink Category'))

@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>
    .bce-page {
        --bce-primary: #0F8EA3;
        --bce-primary-light: #16B6C8;
        --bce-bg: #F8FAFC;
        --bce-card: #FFFFFF;
        --bce-border: #E8EDF3;
        --bce-text: #1F2937;
        --bce-text-soft: #6B7280;
        --bce-success: #22C55E;
        --bce-success-soft: #E9FBF0;
        --bce-danger: #EF4444;
        --bce-danger-soft: #FDECEC;
        --bce-warning: #F59E0B;
        --bce-radius-lg: 18px;
        --bce-radius-md: 12px;
        --bce-radius-sm: 8px;
        --bce-shadow-sm: 0 1px 2px rgba(15,23,42,.04);
        --bce-shadow-md: 0 6px 20px -8px rgba(15,23,42,.10);
        --bce-shadow-lg: 0 16px 40px -16px rgba(15,23,42,.16);

        /* background: var(--bce-bg); */
        color: var(--bce-text);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Inter, Roboto, Helvetica, Arial, sans-serif;
        /* padding: 28px clamp(16px, 3vw, 36px) 60px; */
        min-height: 100%;
    }

    .bce-page *, .bce-page *::before, .bce-page *::after { box-sizing: border-box; }

    @media (prefers-reduced-motion: reduce) {
        .bce-page * { animation: none !important; transition: none !important; }
    }

    /* ---------- Breadcrumb ---------- */
    .bce-crumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--bce-text-soft); margin-bottom: 14px; }
    .bce-crumb .bce-crumb-current { color: var(--bce-text); font-weight: 600; }
    .bce-crumb i { font-size: 10px; opacity: .6; }

    /* ---------- Header ---------- */
    .bce-header {
        display: flex; justify-content: space-between; align-items: flex-start; gap: 18px; flex-wrap: wrap;
        padding: 10px 0 26px;
    }
    .bce-title { font-size: 26px; font-weight: 700; letter-spacing: -.02em; color: var(--bce-text); margin: 0 0 6px; }
    .bce-subtitle { font-size: 14.5px; color: var(--bce-text-soft); margin: 0; max-width: 520px; }

    .bce-btn-ghost {
        display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px; color: var(--bce-text-soft);
        background: #fff; border: 1px solid var(--bce-border); border-radius: 999px; padding: 10px 18px;
        box-shadow: var(--bce-shadow-sm); text-decoration: none; transition: all .15s ease;
    }
    .bce-btn-ghost:hover { color: var(--bce-text); border-color: #D7DEE8; background: var(--bce-bg); transform: translateX(-2px); }

    .bce-btn-gradient {
        display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 14px; color: #fff;
        background: linear-gradient(135deg, var(--bce-primary), var(--bce-primary-light));
        border: none; border-radius: 999px; padding: 12px 24px; box-shadow: 0 10px 24px -10px rgba(15,142,163,.55);
        transition: transform .16s ease, box-shadow .16s ease, filter .16s ease; cursor: pointer;
    }
    .bce-btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 16px 30px -12px rgba(15,142,163,.6); filter: brightness(1.04); color: #fff; }
    .bce-btn-gradient:active { transform: translateY(0); }

    .bce-btn-plain {
        display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 14px; color: var(--bce-text-soft);
        background: #fff; border: 1px solid var(--bce-border); border-radius: 999px; padding: 12px 20px;
        transition: all .15s ease; text-decoration: none;
    }
    .bce-btn-plain:hover { background: var(--bce-bg); color: var(--bce-text); border-color: #D7DEE8; }

    /* ---------- Form card ---------- */
    .bce-form-wrap { display: flex; justify-content: center; }
    .bce-form-card {
        width: 100%; max-width: 1150px; background: var(--bce-card); border: 1px solid var(--bce-border);
        border-radius: var(--bce-radius-lg); box-shadow: var(--bce-shadow-md); overflow: hidden;
        opacity: 0; animation: bceFadeUp .45s ease forwards;
    }
    @keyframes bceFadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .bce-form-head {
        display: flex; align-items: center; gap: 12px; padding: 20px 26px;
        border-bottom: 1px solid var(--bce-border); background: linear-gradient(180deg, #FBFCFE, #FFFFFF);
    }
    .bce-form-head-icon {
        width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center;
        background: color-mix(in srgb, var(--bce-primary) 12%, white); color: var(--bce-primary); font-size: 17px; flex-shrink: 0;
    }
    .bce-form-head-title { font-size: 15.5px; font-weight: 700; color: var(--bce-text); margin: 0; }
    .bce-form-head-sub { font-size: 12.5px; color: var(--bce-text-soft); margin: 1px 0 0; }

    .bce-form-body { padding: 28px 26px 26px; }

    .bce-field { margin-bottom: 24px; }
    .bce-label { display: block; font-size: 13.5px; font-weight: 600; color: var(--bce-text); margin-bottom: 8px; }
    .bce-label .bce-req { color: var(--bce-danger); margin-left: 2px; }
    .bce-label .bce-optional { font-weight: 500; color: var(--bce-text-soft); font-size: 12px; margin-left: 6px; }

    .bce-input, .bce-textarea {
        width: 100%; border: 1px solid var(--bce-border); background: var(--bce-bg); border-radius: var(--bce-radius-md);
        padding: 12px 15px; font-size: 14px; color: var(--bce-text); transition: all .15s ease; font-family: inherit;
    }
    .bce-input::placeholder, .bce-textarea::placeholder { color: #9CA6B4; }
    .bce-input:focus, .bce-textarea:focus {
        outline: none; background: #fff; border-color: var(--bce-primary);
        box-shadow: 0 0 0 4px rgba(15,142,163,.12);
    }
    .bce-textarea { resize: vertical; min-height: 110px; line-height: 1.55; }

    .bce-input.is-invalid, .bce-textarea.is-invalid {
        border-color: var(--bce-danger); background: var(--bce-danger-soft);
    }
    .bce-input.is-invalid:focus, .bce-textarea.is-invalid:focus { box-shadow: 0 0 0 4px rgba(239,68,68,.12); }

    .bce-error {
        display: flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 500; color: var(--bce-danger); margin-top: 7px;
    }

    .bce-hint { font-size: 12px; color: var(--bce-text-soft); margin-top: 7px; }
    .bce-char-count { font-size: 11.5px; color: var(--bce-text-soft); text-align: right; margin-top: 5px; }

    /* Status toggle cards — two radios styled as selectable cards, same name/value as a native select */
    .bce-status-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .bce-status-option { position: relative; }
    .bce-status-option input {
        position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer;
    }
    .bce-status-card {
        display: flex; align-items: center; gap: 10px; border: 1.5px solid var(--bce-border); border-radius: var(--bce-radius-md);
        padding: 13px 14px; transition: all .15s ease; background: #fff;
    }
    .bce-status-icon {
        width: 32px; height: 32px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;
    }
    .bce-status-option.is-on .bce-status-icon { background: var(--bce-success-soft); color: var(--bce-success); }
    .bce-status-option.is-off .bce-status-icon { background: #F1F3F6; color: #6B7280; }
    .bce-status-option input:checked + .bce-status-card {
        border-color: var(--bce-primary); box-shadow: 0 0 0 4px rgba(15,142,163,.10); background: #FBFEFF;
    }
    .bce-status-title { font-size: 13.5px; font-weight: 600; color: var(--bce-text); line-height: 1.2; }
    .bce-status-desc { font-size: 11.5px; color: var(--bce-text-soft); margin-top: 1px; }

    .bce-divider { border: none; border-top: 1px solid var(--bce-border); margin: 4px 0 22px; }

    .bce-actions { display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap; }

    @media (max-width: 640px) {
        .bce-page { padding: 18px 14px 50px; }
        .bce-title { font-size: 21px; }
        .bce-header { flex-direction: column; }
        .bce-status-group { grid-template-columns: 1fr; }
        .bce-actions { flex-direction: column-reverse; }
        .bce-actions .bce-btn-plain, .bce-actions .bce-btn-gradient { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')

<div class="bce-page">

    <nav class="bce-crumb" aria-label="breadcrumb">
        <span>Dashboard</span>
        <i class="fa-solid fa-chevron-right"></i>
        <span>SEO</span>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('admin.backlink-categories.index') }}" style="color:inherit;text-decoration:none;">Backlink Categories</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span class="bce-crumb-current">Create</span>
    </nav>

    <div class="bce-header">
        <div>
            <h1 class="bce-title">Create Backlink Category</h1>
            <p class="bce-subtitle">Create categories for backlink inventory management.</p>
        </div>
        <a href="{{ route('admin.backlink-categories.index') }}" class="bce-btn-ghost">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
    </div>

    <div class="bce-form-wrap">
        <div class="bce-form-card">

            <div class="bce-form-head">
                <span class="bce-form-head-icon"><i class="fa-solid fa-folder-tree"></i></span>
                <div>
                    <h5 class="bce-form-head-title">Category Details</h5>
                    <p class="bce-form-head-sub">Fields marked with an asterisk are required.</p>
                </div>
            </div>

            <form action="{{ route('admin.backlink-categories.store') }}" method="POST">
                @csrf

                <div class="bce-form-body">

                    <div class="bce-field">
                        <label class="bce-label" for="bceName">
                            Category Name <span class="bce-req">*</span>
                        </label>
                        <input type="text"
                            id="bceName"
                            name="name"
                            class="bce-input @error('name') is-invalid @enderror"
                            placeholder="Example : Guest Post"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="bce-error">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="bce-field">
                        <label class="bce-label" for="bceDescription">
                            Description <span class="bce-optional">(optional)</span>
                        </label>
                        <textarea
                            id="bceDescription"
                            name="description"
                            rows="5"
                            class="bce-textarea @error('description') is-invalid @enderror"
                            placeholder="Short description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="bce-error">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="bce-field">
                        <label class="bce-label">Status</label>
                        <div class="bce-status-group">
                            <label class="bce-status-option is-on">
                                <input type="radio" name="status" value="1" {{ old('status',1)==1 ? 'checked' : '' }}>
                                <div class="bce-status-card">
                                    <span class="bce-status-icon"><i class="fa-solid fa-toggle-on"></i></span>
                                    <div>
                                        <div class="bce-status-title">Active</div>
                                        <div class="bce-status-desc">Visible and usable</div>
                                    </div>
                                </div>
                            </label>
                            <label class="bce-status-option is-off">
                                <input type="radio" name="status" value="0" {{ old('status')==='0' ? 'checked' : '' }}>
                                <div class="bce-status-card">
                                    <span class="bce-status-icon"><i class="fa-solid fa-ban"></i></span>
                                    <div>
                                        <div class="bce-status-title">Inactive</div>
                                        <div class="bce-status-desc">Hidden from use</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <hr class="bce-divider">

                    <div class="bce-actions">
                        <a href="{{ route('admin.backlink-categories.index') }}" class="bce-btn-plain">
                            <i class="fa-solid fa-xmark"></i>
                            Cancel
                        </a>
                        <button type="submit" class="bce-btn-gradient">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Save Category
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

</div>

@endsection