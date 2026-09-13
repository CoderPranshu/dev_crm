@extends('index')

@section('title', 'Add Modules - ' . $project->name)

@push('css')
    <style>
        :root {
            --mb-primary: #0F8EA3;
            --mb-primary-light: #E6F5F7;
            --mb-secondary: #16B6C8;
            --mb-border: #E4EAF0;
            --mb-bg-soft: #F6F8FB;
            --mb-bg-panel: #F8FAFC;
            --mb-text-dark: #172033;
            --mb-text-dark-2: #1F2937;
            --mb-text-muted: #64748B;
            --mb-green: #17A76A;
            --mb-yellow: #D97706;
            --mb-red: #E23B5C;
            --mb-blue: #2563EB;
        }

        body {
            background: var(--mb-bg-soft);
        }

        

        .arch-workspace {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 4px 96px;
            font-family: 'Inter', 'Manrope', 'Plus Jakarta Sans', -apple-system, sans-serif;
        }

        .arch-workspace * {
            box-sizing: border-box;
        }

        .arch-workspace[data-mb-ready="0"] .mb-anim {
            opacity: 0;
        }

        @media (prefers-reduced-motion: reduce) {
            .arch-workspace .mb-anim {
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* ============================================================ */
        /* Workspace header                                              */
        /* ============================================================ */
        .arch-header {
            margin-bottom: 18px;
        }

        .arch-header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .arch-breadcrumb {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 600;
            color: var(--mb-text-muted);
        }

        .arch-breadcrumb a {
            color: var(--mb-text-muted);
            text-decoration: none;
            transition: color .16s ease;
        }

        .arch-breadcrumb a:hover {
            color: var(--mb-primary);
        }

        .arch-breadcrumb i {
            font-size: 9px;
            opacity: .6;
        }

        .arch-breadcrumb .is-current {
            color: var(--mb-primary);
        }

        .arch-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 36px;
            padding: 0 15px;
            border-radius: 9px;
            border: 1px solid var(--mb-border);
            background: #fff;
            color: var(--mb-text-dark);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: border-color .18s ease, color .18s ease, transform .18s ease;
        }

        .arch-btn-back:hover {
            border-color: var(--mb-primary);
            color: var(--mb-primary);
            transform: translateX(-2px);
            text-decoration: none;
        }

        .arch-header-main {
            background: #fff;
            border: 1px solid var(--mb-border);
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
        }

        .arch-header-main::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--mb-primary), var(--mb-secondary));
        }

        .arch-project-icon {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--mb-primary), var(--mb-secondary));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(15,142,163,.25);
        }

        .arch-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--mb-text-dark);
            letter-spacing: -.01em;
            margin: 0;
        }

        .arch-subtitle {
            font-size: 12.5px;
            color: var(--mb-text-muted);
            margin: 2px 0 0;
        }

        .arch-meta-pills {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .arch-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            background: var(--mb-primary-light);
            color: var(--mb-primary);
            white-space: nowrap;
        }

        .arch-pill.is-status {
            background: #E5F6EE;
            color: var(--mb-green);
        }

        /* ============================================================ */
        /* Two-panel workspace                                          */
        /* ============================================================ */
        .arch-main {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 18px;
            align-items: start;
        }

        .arch-panel-tree,
        .arch-panel-editor {
            background: #fff;
            border: 1px solid var(--mb-border);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .arch-panel-tree {
            height: calc(100vh - 250px);
            min-height: 420px;
            position: sticky;
            top: 16px;
        }

        .arch-panel-editor {
            /* height: calc(100vh - 250px); */
            min-height: 420px;
        }

        .arch-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            padding: 16px 18px;
            border-bottom: 1px solid var(--mb-border);
            background: var(--mb-bg-panel);
            flex-shrink: 0;
        }

        .arch-panel-eyebrow {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--mb-secondary);
            margin-bottom: 3px;
        }

        .arch-panel-sub {
            font-size: 12px;
            color: var(--mb-text-muted);
            font-weight: 600;
        }

        .arch-tree-toolbar {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .arch-icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--mb-border);
            background: #fff;
            color: var(--mb-text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: border-color .16s ease, color .16s ease, background .16s ease;
        }

        .arch-icon-btn:hover {
            border-color: var(--mb-primary);
            color: var(--mb-primary);
            background: var(--mb-primary-light);
        }

        .arch-icon-btn.is-accent {
            background: var(--mb-primary);
            border-color: var(--mb-primary);
            color: #fff;
        }

        .arch-icon-btn.is-accent:hover {
            background: #0C7684;
            border-color: #0C7684;
            color: #fff;
        }

        .arch-tree-scroll {
            padding: 16px 16px 20px;
            overflow-y: auto;
            flex: 1;
        }

        .arch-editor-scroll {
            padding: 20px 24px 28px;
            overflow-y: auto;
            flex: 1;
        }

        .arch-editor-head {
            margin-bottom: 18px;
        }

        .arch-editor-eyebrow {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--mb-secondary);
            margin-bottom: 4px;
        }

        .arch-editor-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--mb-text-dark);
            margin: 0;
        }

        .arch-editor-sub {
            font-size: 12.5px;
            color: var(--mb-text-muted);
            margin: 3px 0 0;
        }

        .arch-editor-sub strong {
            color: var(--mb-text-dark-2);
        }

        /* ---------- Tree ---------- */
        .tree-root-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: var(--mb-text-dark);
            color: #fff;
            font-weight: 700;
            font-size: 0.74rem;
            border-radius: 999px;
            padding: 0.34rem 0.85rem;
            margin-bottom: 0.9rem;
        }

        .tree-node {
            list-style: none;
            margin: 0;
            padding-left: 1.3rem;
            border-left: 2px solid var(--mb-border);
        }

        .tree-node.tree-root {
            padding-left: 0;
            border-left: none;
        }

        .tree-node li {
            position: relative;
            padding-top: 2px;
        }

        .tree-node:not(.tree-root) > li::before {
            content: '';
            position: absolute;
            left: -1.3rem;
            top: 1rem;
            width: 1rem;
            height: 2px;
            background: var(--mb-border);
        }

        .tree-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.55rem;
            border-radius: 9px;
            font-size: 0.8rem;
            background: #fff;
            border: 1px solid transparent;
            transition: background .15s ease, border-color .15s ease, transform .12s ease;
            flex-wrap: wrap;
        }

        .tree-row:hover {
            background: var(--mb-bg-soft);
            border-color: var(--mb-border);
            transform: translateX(2px);
        }

        .tree-row .tree-icon {
            width: 21px;
            height: 21px;
            border-radius: 6px;
            background: var(--mb-primary-light);
            color: var(--mb-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 9.5px;
            flex-shrink: 0;
        }

        .tree-node .tree-node .tree-row .tree-icon {
            background: #F1F5F9;
            color: var(--mb-secondary);
            width: 17px;
            height: 17px;
            font-size: 8.5px;
        }

        .tree-row .tree-name {
            flex: 1;
            color: var(--mb-text-dark);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 60px;
        }

        .tree-row .tree-meta {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: .02em;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 20px;
            background: var(--mb-bg-soft);
            color: var(--mb-text-muted);
            white-space: nowrap;
        }

        .tree-row .tree-pct {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--mb-primary);
            min-width: 30px;
            text-align: right;
        }

        .tree-empty {
            color: var(--mb-text-muted);
            font-size: 0.82rem;
            padding: 1.6rem 0.4rem;
            text-align: center;
            border: 1.5px dashed var(--mb-border);
            border-radius: 12px;
            list-style: none;
        }

        /* ============================================================ */
        /* Module editor cards (property-group style, no numbering)      */
        /* ============================================================ */
        .module-card {
            background: #fff;
            border: 1px solid var(--mb-border);
            border-radius: 14px;
            margin-bottom: 1.1rem;
            overflow: hidden;
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        .module-card:hover {
            border-color: #CBD5E1;
            box-shadow: 0 6px 20px rgba(15,23,42,.06);
        }

        .module-header {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.95rem 1.15rem;
            cursor: pointer;
            background: #fff;
            flex-wrap: wrap;
        }

        .module-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            flex-shrink: 0;
            font-size: 1rem;
            box-shadow: 0 3px 8px rgba(15,23,42,.14);
        }

        .module-header-main {
            flex: 1;
            min-width: 140px;
        }

        .module-header-main .module-name-preview {
            font-weight: 700;
            font-size: 0.94rem;
            display: block;
            color: var(--mb-text-dark);
        }

        .module-header-main small {
            color: var(--mb-text-muted);
            font-size: 11px;
        }

        .module-header-badges {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .mini-progress {
            width: 84px;
            height: 6px;
            background: #EDF2F7;
            border-radius: 999px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .mini-progress > span {
            display: block;
            height: 100%;
            background: linear-gradient(90deg, var(--mb-primary), var(--mb-secondary));
            transition: width .3s ease;
        }

        .mini-progress-label {
            font-size: 0.72rem;
            color: var(--mb-text-muted);
        }

        .module-header-actions {
            display: flex;
            align-items: center;
            gap: 0.32rem;
            flex-shrink: 0;
        }

        .icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1px solid var(--mb-border);
            background: #fff;
            color: var(--mb-text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            transition: border-color .16s ease, background .16s ease, color .16s ease;
        }

        .icon-btn:hover {
            background: var(--mb-bg-soft);
            border-color: #CBD5E1;
            color: var(--mb-text-dark);
        }

        .icon-btn.danger:hover {
            background: #FDECEF;
            color: var(--mb-red);
            border-color: #F7C3CE;
        }

        .module-body {
            padding: 1.3rem 1.3rem 1.4rem;
            border-top: 1px solid var(--mb-border);
            background: var(--mb-bg-panel);
        }

        /* ---------- Property groups (replaces numbered form sections) ---------- */
        .prop-group {
            background: #fff;
            border: 1px solid var(--mb-border);
            border-radius: 12px;
            padding: 1.1rem 1.15rem;
            margin-bottom: 0.9rem;
        }

        .prop-group:last-child {
            margin-bottom: 0;
        }

        .prop-group-head {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.9rem;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--mb-text-dark);
        }

        .prop-group-head i {
            color: var(--mb-primary);
            font-size: 0.82rem;
        }

        .prop-identity {
            border-color: var(--mb-primary);
            box-shadow: 0 0 0 3px rgba(15,142,163,.08);
        }

        .mb-label {
            font-size: 0.79rem;
            font-weight: 600;
            color: var(--mb-text-dark);
            margin-bottom: 0.4rem;
        }

        /* ---------- Form controls ---------- */
        .arch-workspace .form-control,
        .arch-workspace .form-select {
            height: 46px;
            border: 1px solid var(--mb-border);
            border-radius: 10px;
            font-size: 0.87rem;
            background: #fff;
            color: var(--mb-text-dark);
            box-shadow: none;
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        .arch-workspace textarea.form-control {
            height: auto;
        }

        .arch-workspace .form-control-sm,
        .arch-workspace .form-select-sm {
            height: 38px;
        }

        .arch-workspace .form-control:focus,
        .arch-workspace .form-select:focus {
            border-color: var(--mb-primary);
            box-shadow: 0 0 0 4px rgba(15,142,163,.12);
        }

        .arch-workspace .input-group-text {
            background: #fff;
            border-color: var(--mb-border);
            color: var(--mb-primary);
            border-radius: 10px 0 0 10px;
        }

        .arch-workspace .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        /* ---------- Badges ---------- */
        .badge-soft {
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.68rem;
            padding: 0.3rem 0.65rem;
            letter-spacing: .01em;
        }

        .badge-priority-low { background: #EEF1F5; color: #64748B; }
        .badge-priority-medium { background: var(--mb-primary-light); color: var(--mb-primary); }
        .badge-priority-high { background: #FDF2E3; color: var(--mb-yellow); }
        .badge-priority-critical { background: #FCE7EB; color: var(--mb-red); }

        .badge-status-pending { background: #EEF1F5; color: #64748B; }
        .badge-status-in_progress { background: #E7F0FE; color: var(--mb-blue); }
        .badge-status-completed { background: #E5F6EE; color: var(--mb-green); }
        .badge-status-on_hold { background: #FDF2E3; color: var(--mb-yellow); }

        /* ---------- Pill toggle groups ---------- */
        .pill-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .pill-btn {
            border: 1.5px solid var(--mb-border);
            background: #fff;
            color: #55607A;
            border-radius: 10px;
            font-size: 0.79rem;
            font-weight: 600;
            padding: 0.48rem 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: border-color .14s ease, background .14s ease, color .14s ease, box-shadow .14s ease;
        }

        .pill-btn:hover {
            border-color: #CBD5E1;
        }

        .pill-btn.active[data-value="low"] { background: #EEF1F5; color: #55607A; border-color: #D6DCE5; }
        .pill-btn.active[data-value="medium"] { background: var(--mb-primary-light); color: var(--mb-primary); border-color: var(--mb-primary); box-shadow: 0 0 0 3px rgba(15,142,163,.12); }
        .pill-btn.active[data-value="high"] { background: #FDF2E3; color: var(--mb-yellow); border-color: #F3D9A6; box-shadow: 0 0 0 3px rgba(217,119,6,.1); }
        .pill-btn.active[data-value="critical"] { background: #FCE7EB; color: var(--mb-red); border-color: #F3B7C3; box-shadow: 0 0 0 3px rgba(226,59,92,.1); }

        .pill-btn.active[data-value="pending"] { background: #EEF1F5; color: #55607A; border-color: #D6DCE5; }
        .pill-btn.active[data-value="in_progress"] { background: #E7F0FE; color: var(--mb-blue); border-color: #BBD3FB; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .pill-btn.active[data-value="completed"] { background: #E5F6EE; color: var(--mb-green); border-color: #A9E4C7; box-shadow: 0 0 0 3px rgba(23,167,106,.1); }
        .pill-btn.active[data-value="on_hold"] { background: #FDF2E3; color: var(--mb-yellow); border-color: #F3D9A6; box-shadow: 0 0 0 3px rgba(217,119,6,.1); }

        /* ---------- Color swatches ---------- */
        .color-swatch-group {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding-top: 4px;
        }

        .color-dot {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 2px solid transparent;
            cursor: pointer;
            display: inline-block;
            transition: transform .16s ease, box-shadow .16s ease;
        }

        .color-dot:hover { transform: scale(1.12); }

        .color-dot.active {
            border-color: #fff;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--mb-primary);
            transform: scale(1.08);
        }

        /* ---------- Tags ---------- */
        .tags-input-box {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            border: 1px solid var(--mb-border);
            border-radius: 10px;
            background: #fff;
            padding: 8px 10px;
            min-height: 46px;
            align-items: center;
        }

        .tags-input-box:focus-within {
            border-color: var(--mb-primary);
            box-shadow: 0 0 0 4px rgba(15,142,163,.12);
        }

        .tags-input-box input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 100px;
            font-size: 0.84rem;
            background: transparent;
        }

        .tag-chip {
            background: var(--mb-primary-light);
            color: var(--mb-primary);
            border-radius: 999px;
            padding: 4px 11px;
            font-size: 0.77rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .tag-chip .remove-tag { cursor: pointer; font-weight: 700; opacity: .7; }
        .tag-chip .remove-tag:hover { opacity: 1; }

        /* ---------- Progress row ---------- */
        .progress-slider-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .progress-slider-row .form-range {
            flex: 1;
            accent-color: var(--mb-primary);
            height: auto;
        }

        .progress-value-label {
            font-size: 0.79rem;
            font-weight: 700;
            min-width: 36px;
            text-align: right;
            color: var(--mb-primary);
        }

        /* ---------- Dropzone ---------- */
        .dropzone {
            border: 1.5px dashed #CBD5E1;
            border-radius: 12px;
            text-align: center;
            padding: 1.6rem 1rem;
            color: var(--mb-text-muted);
            cursor: pointer;
            background: #fff;
            transition: border-color .16s ease, background .16s ease;
        }

        .dropzone:hover { border-color: var(--mb-primary); }
        .dropzone i { font-size: 1.5rem; color: var(--mb-primary); }
        .dropzone.dragover { background: var(--mb-primary-light); border-color: var(--mb-primary); }
        .dropzone small { display: block; margin-top: 0.25rem; }

        .file-chip-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.6rem;
        }

        .file-chip {
            background: #fff;
            border: 1px solid var(--mb-border);
            border-radius: 8px;
            font-size: 0.77rem;
            padding: 0.3rem 0.7rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--mb-text-dark);
        }

        /* ---------- Sub modules ---------- */
        .submodules-label {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sub-module-row {
            border: 1px solid var(--mb-border);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            background: #fff;
            overflow: hidden;
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        .sub-module-row:hover {
            box-shadow: 0 3px 12px rgba(15,23,42,.06);
        }

        .sub-module-row-head {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.72rem 0.85rem;
            cursor: pointer;
            flex-wrap: wrap;
        }

        .sub-module-icon {
            width: 27px;
            height: 27px;
            border-radius: 8px;
            background: var(--mb-primary-light);
            color: var(--mb-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            flex-shrink: 0;
        }

        .sub-module-row-head .sm-name {
            font-weight: 700;
            font-size: 0.85rem;
            flex: 1;
            min-width: 100px;
            color: var(--mb-text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sub-module-row-head .sm-badges {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .sub-module-body {
            padding: 0 0.95rem 0.95rem;
            border-top: 1px solid var(--mb-border);
            padding-top: 0.85rem;
        }

        .add-submodule-link {
            border: 1.5px dashed #CBD5E1;
            background: #fff;
            color: var(--mb-primary);
            border-radius: 12px;
            padding: 0.68rem;
            width: 100%;
            text-align: center;
            font-weight: 700;
            font-size: 0.84rem;
            transition: border-color .16s ease, background .16s ease, transform .12s ease;
        }

        .add-submodule-link:hover {
            background: var(--mb-primary-light);
            border-color: var(--mb-primary);
            transform: translateY(-1px);
        }

        /* ---------- Add another module ---------- */
        .arch-add-module-cta {
            width: 100%;
            border: 1.5px dashed #CBD5E1;
            background: #fff;
            border-radius: 14px;
            padding: 1rem;
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--mb-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: border-color .16s ease, background .16s ease, transform .12s ease;
            margin-top: 4px;
        }

        .arch-add-module-cta:hover {
            background: var(--mb-primary-light);
            border-color: var(--mb-primary);
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 2.6rem 1rem;
            color: var(--mb-text-muted);
            border: 1.5px dashed var(--mb-border);
            border-radius: 16px;
            background: #fff;
        }

        /* ---------- Sticky glass action bar ---------- */
        .arch-actionbar {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 40;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 28px;
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid var(--mb-border);
            box-shadow: 0 -6px 24px rgba(15,23,42,.05);
        }

        .arch-actionbar-left {
            font-size: 12px;
            color: var(--mb-text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .arch-actionbar-left .mb-dot-live {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--mb-secondary);
        }

        .arch-actionbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #addModuleBtn {
            background: #fff;
            border: 1.5px solid var(--mb-border);
            color: var(--mb-text-dark);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.6rem 1.1rem;
            transition: border-color .16s ease, color .16s ease;
        }

        #submitBtn {
            background: var(--mb-primary);
            border-color: var(--mb-primary);
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.87rem;
            padding: 0.65rem 1.5rem;
            transition: background .16s ease, border-color .16s ease, transform .14s ease;
        }

        #submitBtn:hover {
            background: #0C7684;
            border-color: #0C7684;
            transform: translateY(-1px);
        }

        .arch-actionbar .btn-outline-secondary {
            border-radius: 10px;
            font-size: 0.85rem;
            border-color: var(--mb-border);
            color: var(--mb-text-dark);
            padding: 0.6rem 1.1rem;
        }

        .arch-actionbar .btn-outline-secondary:hover {
            background: var(--mb-bg-soft);
            border-color: #CBD5E1;
        }

        /* ---------- Hidden JS-compatibility block ----------
           These elements are not part of the redesigned page,
           but existing JavaScript writes to them (donut progress,
           statistics counters, activity log) on every change, so
           they stay in the DOM to avoid breaking that logic. */
        .mb-js-compat {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 1100px) {
            .arch-main {
                grid-template-columns: 300px 1fr;
            }
        }

        @media (max-width: 900px) {
            .arch-header-top { flex-direction: column; align-items: stretch; }
            .arch-btn-back { justify-content: center; }
            .arch-header-main { padding: 16px 18px; }
            .arch-meta-pills { margin-left: 0; }
            .arch-main {
                grid-template-columns: 1fr;
            }
            .arch-panel-tree {
                position: static;
                height: auto;
                max-height: 320px;
            }
            .arch-panel-editor {
                height: auto;
            }
            .arch-editor-scroll,
            .arch-tree-scroll {
                overflow-y: visible;
            }
            .module-body { padding: 1.05rem 0.95rem 1.2rem; }
            .arch-actionbar { flex-direction: column; align-items: stretch; padding: 12px 16px; }
            .arch-actionbar-right { justify-content: stretch; }
            .arch-actionbar-right a, .arch-actionbar-right button { flex: 1; justify-content: center; }
        }
    </style>
@endpush

@section('content')
    <div class="arch-workspace" data-mb-ready="0">

        {{-- ================= WORKSPACE HEADER ================= --}}
        <div class="arch-header mb-anim" data-mb-anim>
            <div class="arch-header-top">
                <div class="arch-breadcrumb">
                    <a href="{{ url()->previous() }}">Projects</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>{{ $project->project_name }}</span>
                    <i class="bi bi-chevron-right"></i>
                    <span class="is-current">Module Architecture</span>
                </div>
                <a href="{{ url()->previous() }}" class="arch-btn-back">
                    <i class="bi bi-arrow-left"></i> Back to Project
                </a>
            </div>
            <div class="arch-header-main">
                <span class="arch-project-icon"><i class="bi bi-diagram-3-fill"></i></span>
                <div>
                    <h1 class="arch-title">{{ $project->project_name }}</h1>
                    <p class="arch-subtitle">Project Module Architecture</p>
                </div>
                <div class="arch-meta-pills">
                    <span class="arch-pill"><i class="bi bi-hash"></i>PRJ-{{ str_pad($project->id, 5, '0', STR_PAD_LEFT) }}</span>
                    @if(!empty($project->status))
                        <span class="arch-pill is-status"><i class="bi bi-broadcast"></i>{{ $project->status }}</span>
                    @endif
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-anim" data-mb-anim>
                <strong>Please fix the following before saving:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mb-anim" data-mb-anim>{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.projects.modules.store') }}" method="POST" enctype="multipart/form-data"
            id="moduleForm">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            {{-- ================= TWO-PANEL WORKSPACE ================= --}}
            <div class="arch-main mb-anim" data-mb-anim>

                {{-- LEFT PANEL — PROJECT ARCHITECTURE --}}
                <aside class="arch-panel-tree">
                    <div class="arch-panel-head">
                        <div>
                            <div class="arch-panel-eyebrow">Project Architecture</div>
                            <div class="arch-panel-sub" id="structureCount">&middot; 0 modules</div>
                        </div>
                        <div class="arch-tree-toolbar">
                            <button type="button" class="arch-icon-btn" id="qaExpandAll" title="Expand all"><i class="bi bi-arrows-expand"></i></button>
                            <button type="button" class="arch-icon-btn" id="qaCollapseAll" title="Collapse all"><i class="bi bi-arrows-collapse"></i></button>
                            <button type="button" class="arch-icon-btn is-accent" id="qaAddModule" title="Add module"><i class="bi bi-plus-lg"></i></button>
                        </div>
                    </div>
                    <div class="arch-tree-scroll">
                        <span class="tree-root-badge"><i class="bi bi-folder2-open"></i> {{ $project->name }} (Project)</span>
                        <ul class="tree-node tree-root" id="structureTree">
                            <li class="tree-empty">Add a module to see the project structure here.</li>
                        </ul>
                    </div>
                </aside>

                {{-- RIGHT PANEL — MODULE EDITOR --}}
                <section class="arch-panel-editor">
                    <div class="arch-editor-scroll">
                        <div class="arch-editor-head">
                            <div class="arch-editor-eyebrow">Module Workspace</div>
                            <h2 class="arch-editor-title">Create Module</h2>
                            <p class="arch-editor-sub">Adding new modules to <strong>{{ $project->project_name }}</strong></p>
                        </div>

                        <div id="modulesContainer"></div>

                        <div id="emptyState" class="empty-state d-none">
                            <i class="bi bi-diagram-3 fs-1 d-block mb-2"></i>
                            No modules added yet. Click <strong>"Add Module"</strong> to get started.
                        </div>

                        <button type="button" class="arch-add-module-cta" id="addModuleBtn">
                            <i class="bi bi-plus-lg"></i> Add Another Module
                        </button>
                    </div>
                </section>
            </div>

            {{-- Sticky glass action bar --}}
            <div class="arch-actionbar">
                <div class="arch-actionbar-left">
                    <span class="mb-dot-live"></span>
                    Draft &middot; Unsaved changes
                </div>
                <div class="arch-actionbar-right">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="bi bi-check-lg"></i> Save Modules
                    </button>
                </div>
            </div>
        </form>

        {{-- ============================================================
             JS-COMPATIBILITY BLOCK (visually hidden)
             The right sidebar (Project Progress / Statistics / Quick
             Actions / Activity Timeline) is not part of the redesigned
             UI. The existing JavaScript still calculates and writes
             into these elements on every change, so they're kept in
             the DOM — invisibly — purely so that logic keeps running
             without errors.
        ============================================================ --}}
        <div class="mb-js-compat" aria-hidden="true">
            <svg width="140" height="140" viewBox="0 0 140 140">
                <circle cx="70" cy="70" r="58" fill="none" stroke="#EDF2F7" stroke-width="14"></circle>
                <circle id="donutArc" cx="70" cy="70" r="58" fill="none" stroke="#0F8EA3" stroke-width="14"
                    stroke-linecap="round" stroke-dasharray="364.4" stroke-dashoffset="364.4"
                    transform="rotate(-90 70 70)"></circle>
                <text x="70" y="72" text-anchor="middle" id="donutPercent">0%</text>
            </svg>
            <span id="statTotalModules">0</span>
            <span id="statCompletedModules">0</span>
            <span id="statPendingModules">0</span>
            <span id="statTotalSub">0</span>
            <span id="statCompletedSub">0</span>
            <span id="statDevelopers">0</span>
            <span id="statEstHours">0 hrs</span>
            <span id="statRemainingHours">0 hrs</span>
            <ul id="activityTimeline">
                <li>
                    <span class="timeline-title">Module Builder Opened</span>
                    <span class="timeline-sub">Draft initialized &middot; just now</span>
                </li>
            </ul>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- MODULE TEMPLATE (cloned via JS - never submitted as-is)       --}}
    {{-- ============================================================ --}}
    <template id="moduleTemplate">
        <div class="module-card" data-module-block>
            <div class="module-header" data-toggle-collapse>
                <span class="module-icon" data-module-icon style="background:#0F8EA3;"><i
                        class="bi bi-folder2"></i></span>

                <div class="module-header-main">
                    <span class="module-name-preview" data-module-name-preview>New Module</span>
                    <small data-sub-count-preview>0 sub-modules</small>
                </div>

                <div class="module-header-badges">
                    <span class="badge-soft badge-priority-medium" data-priority-badge>Medium</span>
                    <span class="badge-soft badge-status-pending" data-status-badge>Pending</span>
                    <div class="mini-progress"><span data-mini-progress-bar style="width:0%;"></span></div>
                    <span class="mini-progress-label" data-mini-progress-label>0%</span>
                </div>

                <div class="module-header-actions">
                    <button type="button" class="icon-btn" data-add-submodule title="Add sub module"><i
                            class="bi bi-plus-lg"></i></button>
                    <button type="button" class="icon-btn" data-duplicate-module title="Duplicate module"><i
                            class="bi bi-files"></i></button>
                    <button type="button" class="icon-btn danger" data-delete-module title="Delete module"><i
                            class="bi bi-trash"></i></button>
                    <button type="button" class="icon-btn" data-collapse-icon title="Collapse/expand"><i
                            class="bi bi-chevron-up"></i></button>
                </div>
            </div>

            <div class="module-body" data-module-collapse-target>

                <div class="prop-group prop-identity">
                    <div class="prop-group-head"><i class="bi bi-tag"></i><span>Identity</span></div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-label">Module Name <span class="text-danger">*</span></div>
                            <input type="text" class="form-control" data-field="module_name" required maxlength="255"
                                placeholder="e.g. Websites">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-label">Module Type</div>
                            <input type="text" class="form-control" data-field="module_type" maxlength="255"
                                placeholder="e.g. Website, Admin Panel, CRM">
                        </div>
                    </div>
                </div>

                <div class="prop-group">
                    <div class="prop-group-head"><i class="bi bi-people"></i><span>Ownership</span></div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="mb-label">Assigned Department</div>
                            <select class="form-select department-select" data-field="department_id">
                                <option value="">-- Select Department --</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-label">Assigned Developer</div>
                            <select class="form-select assigned-select" data-field="assigned_to">
                                <option value="">-- Select Developer --</option>
                                {{-- @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-label">Estimated Hours</div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                <input type="number" class="form-control" data-field="estimated_hours" min="0"
                                    step="0.5">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="prop-group">
                    <div class="prop-group-head"><i class="bi bi-flag"></i><span>Planning</span></div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="mb-label">Priority <span class="text-danger">*</span></div>
                            <div class="pill-group" data-pill-group="priority">
                                <button type="button" class="pill-btn" data-value="low">Low</button>
                                <button type="button" class="pill-btn" data-value="medium">Medium</button>
                                <button type="button" class="pill-btn active" data-value="high">High</button>
                                <button type="button" class="pill-btn" data-value="critical">Critical</button>
                            </div>
                            <select class="d-none" data-field="priority" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high" selected>High</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="mb-label">Status <span class="text-danger">*</span></div>
                            <div class="pill-group" data-pill-group="status">
                                <button type="button" class="pill-btn active" data-value="pending">Pending</button>
                                <button type="button" class="pill-btn" data-value="in_progress">In Progress</button>
                                <button type="button" class="pill-btn" data-value="completed">Completed</button>
                                <button type="button" class="pill-btn" data-value="on_hold">On Hold</button>
                            </div>
                            <select class="d-none" data-field="status" required>
                                <option value="pending" selected>Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-label">Start Date</div>
                            <input type="date" class="form-control" data-field="start_date">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-label">Deadline</div>
                            <input type="date" class="form-control" data-field="deadline">
                        </div>
                    </div>
                </div>

                <div class="prop-group">
                    <div class="prop-group-head"><i class="bi bi-palette"></i><span>Appearance</span></div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-label">Module Color</div>
                            <div class="color-swatch-group" data-color-swatch-group>
                                <span class="color-dot active" data-color="#0F8EA3" style="background:#0F8EA3;"></span>
                                <span class="color-dot" data-color="#16B6C8" style="background:#16B6C8;"></span>
                                <span class="color-dot" data-color="#17A76A" style="background:#17A76A;"></span>
                                <span class="color-dot" data-color="#E23B5C" style="background:#E23B5C;"></span>
                                <span class="color-dot" data-color="#2563EB" style="background:#2563EB;"></span>
                                <span class="color-dot" data-color="#8B5CF6" style="background:#8B5CF6;"></span>
                            </div>
                            <input type="hidden" data-field="color" value="#0F8EA3">
                        </div>

                        <div class="col-md-6">
                            <div class="mb-label">Tags</div>
                            <div class="tags-input-box" data-tags-box>
                                <input type="text" placeholder="Type & press Enter..." data-tags-input>
                            </div>
                            <input type="hidden" data-field="tags">
                        </div>

                        <div class="col-md-6" style="display: none;">
                            <div class="mb-label">Module Progress</div>
                            <div class="progress-slider-row">
                                <input type="range" class="form-range" min="0" max="100" value="0"
                                    data-field="progress_range">
                                <span class="progress-value-label" data-progress-label>0%</span>
                            </div>
                            <input type="hidden" data-field="progress" value="0">
                        </div>
                    </div>
                </div>

                <div class="prop-group">
                    <div class="prop-group-head"><i class="bi bi-text-paragraph"></i><span>Description</span></div>
                    <textarea class="form-control" data-field="description" rows="3"
                        placeholder="Briefly describe what this module covers..."></textarea>
                </div>

                <div class="prop-group" style="display: none;">
                    <div class="prop-group-head"><i class="bi bi-paperclip"></i><span>Attachments</span></div>
                    <div class="dropzone" data-dropzone>
                        <i class="bi bi-cloud-arrow-up"></i>
                        <div>Drag &amp; drop files, or click to browse</div>
                        <small>ZIP, PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG &middot; up to 10MB each</small>
                        <input type="file" class="d-none" data-field="attachments" multiple>
                    </div>
                    <div class="file-chip-list" data-file-chip-list></div>
                </div>

                <div class="prop-group prop-submodules">
                    <div class="prop-group-head"><i class="bi bi-diagram-2"></i><span class="submodules-label">Sub-Modules</span></div>
                    <div data-submodules-container></div>
                    <button type="button" class="add-submodule-link" data-add-submodule-link>
                        <i class="bi bi-plus-lg"></i> Add Sub Module
                    </button>
                </div>
            </div>
        </div>
    </template>

    {{-- ============================================================ --}}
    {{-- SUB MODULE TEMPLATE (cloned via JS)                           --}}
    {{-- ============================================================ --}}
    <template id="subModuleTemplate">
        <div class="sub-module-row" data-submodule-block>
            <div class="sub-module-row-head" data-submodule-toggle-collapse>
                <span class="sub-module-icon"><i class="bi bi-diagram-2"></i></span>
                <span class="sm-name" data-submodule-name-preview>New Sub Module</span>
                <div class="sm-badges">
                    <span class="badge-soft badge-priority-medium" data-submodule-priority-badge>Medium</span>
                    <span class="badge-soft badge-status-pending" data-status-badge>Pending</span>
                    <button type="button" class="icon-btn danger" data-delete-submodule title="Delete sub module"><i
                            class="bi bi-trash"></i></button>
                    <button type="button" class="icon-btn" data-submodule-collapse-icon title="Collapse/expand"><i
                            class="bi bi-chevron-up"></i></button>
                </div>
            </div>

            <div class="sub-module-body" data-submodule-collapse-target>

                <div class="row g-2 mb-2">
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-sm" data-field="sub_module_name" required
                            maxlength="255" placeholder="Sub module name">
                    </div>
                    <div class="col-md-6">
                        <select class="form-select form-select-sm" data-field="assigned_to" hidden>
                            <option value="">-- Developer --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-2 align-items-center mb-2">
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" data-field="priority" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" data-field="status" required>
                            <option value="pending" selected>Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="on_hold">On Hold</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control form-control-sm" data-field="estimated_hours"
                            min="0" step="0.5" placeholder="Hrs">
                    </div>
                    <div class="col-md-4">
                        <div class="progress-slider-row">
                            <input type="range" class="form-range" min="0" max="100" value="0"
                                data-field="progress_range">
                            <span class="progress-value-label" data-progress-label>0%</span>
                        </div>
                        <input type="hidden" data-field="progress" value="0">
                    </div>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <input type="date" class="form-control form-control-sm" data-field="start_date">
                    </div>
                    <div class="col-md-6">
                        <input type="date" class="form-control form-control-sm" data-field="deadline">
                    </div>
                </div>

                <textarea class="form-control form-control-sm" data-field="description" rows="2"
                    placeholder="Short description..."></textarea>
            </div>
        </div>
    </template>

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';

            const modulesContainer = document.getElementById('modulesContainer');
            const emptyState = document.getElementById('emptyState');
            const moduleTemplate = document.getElementById('moduleTemplate');
            const subModuleTemplate = document.getElementById('subModuleTemplate');
            const addModuleBtn = document.getElementById('addModuleBtn');
            const moduleForm = document.getElementById('moduleForm');
            const submitBtn = document.getElementById('submitBtn');
            const structureTree = document.getElementById('structureTree');
            const structureCount = document.getElementById('structureCount');
            const activityTimeline = document.getElementById('activityTimeline');

            let moduleCounter = 0;

            const PRIORITY_LABELS = {
                low: 'Low',
                medium: 'Medium',
                high: 'High',
                critical: 'Critical'
            };
            const STATUS_LABELS = {
                pending: 'Pending',
                in_progress: 'In Progress',
                completed: 'Completed',
                on_hold: 'On Hold'
            };

            /* ============================================================ */
            /* Helpers                                                        */
            /* ============================================================ */
            function escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            }

            function logActivity(title, sub) {
                const li = document.createElement('li');
                li.innerHTML =
                    `<span class="timeline-title">${escapeHtml(title)}</span><span class="timeline-sub">${escapeHtml(sub)} &middot; just now</span>`;
                activityTimeline.insertBefore(li, activityTimeline.firstChild);
                while (activityTimeline.children.length > 6) {
                    activityTimeline.removeChild(activityTimeline.lastChild);
                }
            }

            function toggleEmptyState() {
                const hasModules = modulesContainer.querySelectorAll('[data-module-block]').length > 0;
                emptyState.classList.toggle('d-none', hasModules);
            }

            function renumberSubModules(moduleBlock) {
                const container = moduleBlock.querySelector('[data-submodules-container]');
                container.querySelectorAll('[data-submodule-block]').forEach((block, i) => {
                    block.dataset.displayIndex = i + 1;
                });
            }

            /* ============================================================ */
            /* Field name indexing (keeps modules[i][field] in sync with DOM) */
            /* ============================================================ */
            function reindexAll() {
                modulesContainer.querySelectorAll('[data-module-block]').forEach((moduleBlock) => {
                    const mIndex = moduleBlock.dataset.moduleIndex;

                    moduleBlock.querySelectorAll(':scope > .module-body [data-field]').forEach((el) => {
                        if (el.closest('[data-submodule-block]')) return;
                        applyFieldName(el, `modules[${mIndex}]`);
                    });

                    const subContainer = moduleBlock.querySelector('[data-submodules-container]');
                    subContainer.querySelectorAll('[data-submodule-block]').forEach((subBlock) => {
                        const sIndex = subBlock.dataset.submoduleIndex;
                        subBlock.querySelectorAll('[data-field]').forEach((el) => {
                            applyFieldName(el,
                            `modules[${mIndex}][sub_modules][${sIndex}]`);
                        });
                    });
                });
            }

            function applyFieldName(el, prefix) {
                const field = el.dataset.field;
                if (!field || field.endsWith('_range')) return;
                el.setAttribute('name', field === 'attachments' ? `${prefix}[attachments][]` :
                    `${prefix}[${field}]`);
            }

            /* ============================================================ */
            /* Progress range <-> hidden field + header mini bar             */
            /* ============================================================ */
            function wireProgressRange(scope, onChange) {
                const range = scope.querySelector('[data-field="progress_range"]');
                const hidden = scope.querySelector('[data-field="progress"]');
                const label = scope.querySelector('[data-progress-label]');

                range.addEventListener('input', () => {
                    hidden.value = range.value;
                    label.textContent = range.value + '%';
                    if (onChange) onChange(parseInt(range.value, 10));
                    refreshDashboard();
                });
            }

            /* ============================================================ */
            /* Pill toggle groups (priority / status)                        */
            /* ============================================================ */
            function wirePillGroup(scope, groupName, onSelect) {
                const group = scope.querySelector(`[data-pill-group="${groupName}"]`);
                const select = scope.querySelector(`select[data-field="${groupName}"]`);

                group.querySelectorAll('.pill-btn').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        group.querySelectorAll('.pill-btn').forEach(b => b.classList.remove(
                            'active'));
                        btn.classList.add('active');
                        select.value = btn.dataset.value;
                        if (onSelect) onSelect(btn.dataset.value);
                        refreshDashboard();
                    });
                });
            }

            /* ============================================================ */
            /* Tag chips                                                      */
            /* ============================================================ */
            function wireTagsInput(scope) {
                const box = scope.querySelector('[data-tags-box]');
                const input = box.querySelector('[data-tags-input]');
                const hidden = scope.querySelector('[data-field="tags"]');
                let tags = [];

                function syncHidden() {
                    hidden.value = tags.join(',');
                }

                function addChip(value) {
                    value = value.trim();
                    if (!value || tags.includes(value)) return;
                    tags.push(value);
                    const chip = document.createElement('span');
                    chip.className = 'tag-chip';
                    chip.innerHTML =
                        `${escapeHtml(value)} <span class="remove-tag" data-tag-value="${escapeHtml(value)}">&times;</span>`;
                    box.insertBefore(chip, input);
                    syncHidden();
                }

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        addChip(input.value);
                        input.value = '';
                    }
                });

                box.addEventListener('click', (e) => {
                    if (e.target.matches('[data-tag-value]')) {
                        const value = e.target.dataset.tagValue;
                        tags = tags.filter(t => t !== value);
                        e.target.closest('.tag-chip').remove();
                        syncHidden();
                    }
                });
            }

            /* ============================================================ */
            /* Color swatches                                                 */
            /* ============================================================ */
            function wireColorSwatches(moduleBlock) {
                const group = moduleBlock.querySelector('[data-color-swatch-group]');
                const hidden = moduleBlock.querySelector('[data-field="color"]');
                const icon = moduleBlock.querySelector('[data-module-icon]');

                group.querySelectorAll('.color-dot').forEach((dot) => {
                    dot.addEventListener('click', () => {
                        group.querySelectorAll('.color-dot').forEach(d => d.classList.remove(
                            'active'));
                        dot.classList.add('active');
                        hidden.value = dot.dataset.color;
                        icon.style.background = dot.dataset.color;
                    });
                });
            }

            /* ============================================================ */
            /* Dropzone / file chips                                         */
            /* ============================================================ */
            function wireDropzone(scope) {
                const zone = scope.querySelector('[data-dropzone]');
                const input = zone.querySelector('[data-field="attachments"]');
                const chipList = scope.querySelector('[data-file-chip-list]');

                function renderChips() {
                    chipList.innerHTML = '';
                    Array.from(input.files || []).forEach((file) => {
                        const chip = document.createElement('span');
                        chip.className = 'file-chip';
                        chip.innerHTML = `<i class="bi bi-paperclip"></i> ${escapeHtml(file.name)}`;
                        chipList.appendChild(chip);
                    });
                }

                zone.addEventListener('click', () => input.click());
                input.addEventListener('change', renderChips);

                ['dragover', 'dragenter'].forEach(evt => zone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    zone.classList.add('dragover');
                }));
                ['dragleave', 'drop'].forEach(evt => zone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    zone.classList.remove('dragover');
                }));
                zone.addEventListener('drop', (e) => {
                    input.files = e.dataTransfer.files;
                    renderChips();
                });
            }

            /* ============================================================ */
            /* Header preview (name, sub count, badges)                      */
            /* ============================================================ */
            function wireHeaderPreview(moduleBlock) {
                const nameInput = moduleBlock.querySelector(':scope > .module-body [data-field="module_name"]');
                const preview = moduleBlock.querySelector('[data-module-name-preview]');

                nameInput.addEventListener('input', () => {
                    preview.textContent = nameInput.value.trim() || 'New Module';
                    refreshDashboard();
                });
            }

            function updateModuleHeaderBadges(moduleBlock) {
                const prioritySelect = moduleBlock.querySelector(
                    ':scope > .module-body select[data-field="priority"]');
                const statusSelect = moduleBlock.querySelector(':scope > .module-body select[data-field="status"]');
                const progressHidden = moduleBlock.querySelector(':scope > .module-body [data-field="progress"]');
                const subCount = moduleBlock.querySelectorAll('[data-submodule-block]').length;

                const pBadge = moduleBlock.querySelector('[data-priority-badge]');
                pBadge.textContent = PRIORITY_LABELS[prioritySelect.value];
                pBadge.className = 'badge-soft badge-priority-' + prioritySelect.value;

                const sBadge = moduleBlock.querySelector('[data-status-badge]');
                sBadge.textContent = STATUS_LABELS[statusSelect.value];
                sBadge.className = 'badge-soft badge-status-' + statusSelect.value;

                moduleBlock.querySelector('[data-mini-progress-bar]').style.width = progressHidden.value + '%';
                moduleBlock.querySelector('[data-mini-progress-label]').textContent = progressHidden.value + '%';
                moduleBlock.querySelector('[data-sub-count-preview]').textContent = subCount + (subCount === 1 ?
                    ' sub-module' : ' sub-modules');
            }

            function updateSubModuleBadge(subBlock) {
                const nameInput = subBlock.querySelector('[data-field="sub_module_name"]');
                const statusSelect = subBlock.querySelector('select[data-field="status"]');
                subBlock.querySelector('[data-submodule-name-preview]').textContent = nameInput.value.trim() ||
                    'New Sub Module';
                const badge = subBlock.querySelector('[data-status-badge]');
                badge.textContent = STATUS_LABELS[statusSelect.value];
                badge.className = 'badge-soft badge-status-' + statusSelect.value;

                // Additive: keep the sub-module's collapsed-header priority badge in sync too.
                const prioritySelect = subBlock.querySelector('select[data-field="priority"]');
                const priorityBadge = subBlock.querySelector('[data-submodule-priority-badge]');
                if (prioritySelect && priorityBadge) {
                    priorityBadge.textContent = PRIORITY_LABELS[prioritySelect.value];
                    priorityBadge.className = 'badge-soft badge-priority-' + prioritySelect.value;
                }
            }

            /* ============================================================ */
            /* Collapse / expand (modules)                                    */
            /* ============================================================ */
            function setCollapsed(moduleBlock, collapsed) {
                const body = moduleBlock.querySelector('[data-module-collapse-target]');
                const icon = moduleBlock.querySelector('[data-collapse-icon] i');
                body.style.display = collapsed ? 'none' : '';
                icon.className = collapsed ? 'bi bi-chevron-down' : 'bi bi-chevron-up';
            }

            function wireCollapse(moduleBlock) {
                const header = moduleBlock.querySelector('[data-toggle-collapse]');
                header.addEventListener('click', (e) => {
                    if (e.target.closest('.module-header-actions')) return;
                    const body = moduleBlock.querySelector('[data-module-collapse-target]');
                    setCollapsed(moduleBlock, body.style.display !== 'none');
                });
            }

            /* ============================================================ */
            /* Collapse / expand (sub-modules) — additive, visual-only,       */
            /* new data attributes, doesn't touch any required selector.     */
            /* ============================================================ */
            function setSubCollapsed(subBlock, collapsed) {
                const body = subBlock.querySelector('[data-submodule-collapse-target]');
                const icon = subBlock.querySelector('[data-submodule-collapse-icon] i');
                if (!body || !icon) return;
                body.style.display = collapsed ? 'none' : '';
                icon.className = collapsed ? 'bi bi-chevron-down' : 'bi bi-chevron-up';
            }

            function wireSubCollapse(subBlock) {
                const header = subBlock.querySelector('[data-submodule-toggle-collapse]');
                if (!header) return;
                header.addEventListener('click', (e) => {
                    if (e.target.closest('[data-delete-submodule]') || e.target.closest(
                            '[data-submodule-collapse-icon]')) {
                        // still allow the dedicated collapse icon to toggle
                        if (e.target.closest('[data-submodule-collapse-icon]')) {
                            const body = subBlock.querySelector('[data-submodule-collapse-target]');
                            setSubCollapsed(subBlock, body.style.display !== 'none');
                        }
                        return;
                    }
                    const body = subBlock.querySelector('[data-submodule-collapse-target]');
                    setSubCollapsed(subBlock, body.style.display !== 'none');
                });
            }

            /* ============================================================ */
            /* Sub module add / delete                                       */
            /* ============================================================ */
            function addSubModule(moduleBlock) {
                const subContainer = moduleBlock.querySelector('[data-submodules-container]');
                const nextIndex = parseInt(moduleBlock.dataset.subCounter || '0', 10);
                moduleBlock.dataset.subCounter = nextIndex + 1;

                const fragment = subModuleTemplate.content.cloneNode(true);
                const subBlock = fragment.querySelector('[data-submodule-block]');
                subBlock.dataset.submoduleIndex = nextIndex;

                subContainer.appendChild(subBlock);

                wireProgressRange(subBlock);
                wireSubCollapse(subBlock);
                subBlock.querySelector('[data-field="sub_module_name"]').addEventListener('input', () => {
                    updateSubModuleBadge(subBlock);
                    refreshDashboard();
                });
                subBlock.querySelector('select[data-field="status"]').addEventListener('change', () => {
                    updateSubModuleBadge(subBlock);
                    refreshDashboard();
                });
                subBlock.querySelector('select[data-field="priority"]').addEventListener('change', () => {
                    updateSubModuleBadge(subBlock);
                    refreshDashboard();
                });
                subBlock.querySelector('[data-delete-submodule]').addEventListener('click', () => {
                    subBlock.remove();
                    renumberSubModules(moduleBlock);
                    reindexAll();
                    updateModuleHeaderBadges(moduleBlock);
                    refreshDashboard();
                    logActivity('Sub Module Removed', moduleBlock.querySelector(
                        '[data-module-name-preview]').textContent);
                });

                renumberSubModules(moduleBlock);
                reindexAll();
                updateModuleHeaderBadges(moduleBlock);
                updateSubModuleBadge(subBlock);
                refreshDashboard();

                return subBlock;
            }

            /* ============================================================ */
            /* Module add / delete / duplicate                                */
            /* ============================================================ */
            function createModuleBlock() {
                const fragment = moduleTemplate.content.cloneNode(true);
                const moduleBlock = fragment.querySelector('[data-module-block]');
                moduleBlock.dataset.moduleIndex = moduleCounter++;
                moduleBlock.dataset.subCounter = 0;

                modulesContainer.appendChild(moduleBlock);

                wireProgressRange(moduleBlock, () => updateModuleHeaderBadges(moduleBlock));
                wirePillGroup(moduleBlock, 'priority', () => updateModuleHeaderBadges(moduleBlock));
                wirePillGroup(moduleBlock, 'status', () => updateModuleHeaderBadges(moduleBlock));
                wireTagsInput(moduleBlock);
                wireColorSwatches(moduleBlock);
                wireDropzone(moduleBlock);
                wireHeaderPreview(moduleBlock);
                wireCollapse(moduleBlock);

                moduleBlock.querySelectorAll('[data-add-submodule], [data-add-submodule-link]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        addSubModule(moduleBlock);
                        logActivity('Sub Module Added', moduleBlock.querySelector(
                            '[data-module-name-preview]').textContent);
                    });
                });
                moduleBlock.querySelector('[data-delete-module]').addEventListener('click', () => deleteModule(
                    moduleBlock));
                moduleBlock.querySelector('[data-duplicate-module]').addEventListener('click', () =>
                    duplicateModule(moduleBlock));

                toggleEmptyState();
                reindexAll();
                updateModuleHeaderBadges(moduleBlock);
                refreshDashboard();

                return moduleBlock;
            }

            function deleteModule(moduleBlock) {
                const name = moduleBlock.querySelector('[data-module-name-preview]').textContent;
                if (modulesContainer.querySelectorAll('[data-module-block]').length <= 1) {
                    if (!confirm('This is the last module. Delete it anyway?')) return;
                }
                moduleBlock.remove();
                toggleEmptyState();
                reindexAll();
                refreshDashboard();
                logActivity('Module Removed', name);
            }

            function duplicateModule(sourceBlock) {
                const newBlock = createModuleBlock();

                sourceBlock.querySelectorAll(':scope > .module-body [data-field]').forEach((sourceEl) => {
                    if (sourceEl.closest('[data-submodule-block]')) return;
                    if (sourceEl.type === 'file') return;
                    const field = sourceEl.dataset.field;
                    const targetEl = newBlock.querySelector(
                    `:scope > .module-body [data-field="${field}"]`);
                    if (!targetEl || targetEl.closest('[data-submodule-block]')) return;
                    targetEl.value = sourceEl.value;
                });

                // Sync visual pieces derived from the copied values.
                newBlock.querySelector(':scope > .module-body [data-field="module_name"]').dispatchEvent(new Event(
                    'input'));
                newBlock.querySelector(':scope > .module-body [data-field="progress_range"]').dispatchEvent(
                    new Event('input'));

                ['priority', 'status'].forEach((groupName) => {
                    const value = newBlock.querySelector(`select[data-field="${groupName}"]`).value;
                    const group = newBlock.querySelector(`[data-pill-group="${groupName}"]`);
                    group.querySelectorAll('.pill-btn').forEach(b => b.classList.toggle('active', b.dataset
                        .value === value));
                });

                const sourceColor = sourceBlock.querySelector('[data-field="color"]').value;
                const targetDot = newBlock.querySelector(`.color-dot[data-color="${sourceColor}"]`);
                if (targetDot) targetDot.click();

                const sourceTags = sourceBlock.querySelector('[data-field="tags"]').value;
                if (sourceTags) {
                    const targetInput = newBlock.querySelector('[data-tags-input]');
                    sourceTags.split(',').forEach((tag) => {
                        if (!tag.trim()) return;
                        targetInput.value = tag;
                        targetInput.dispatchEvent(new KeyboardEvent('keydown', {
                            key: 'Enter'
                        }));
                    });
                }

                sourceBlock.querySelectorAll('[data-submodule-block]').forEach((sourceSub) => {
                    const targetSub = addSubModule(newBlock);
                    sourceSub.querySelectorAll('[data-field]').forEach((sourceEl) => {
                        const field = sourceEl.dataset.field;
                        const targetEl = targetSub.querySelector(`[data-field="${field}"]`);
                        if (!targetEl) return;
                        targetEl.value = sourceEl.value;
                    });
                    targetSub.querySelector('[data-field="sub_module_name"]').dispatchEvent(new Event(
                        'input'));
                    targetSub.querySelector('[data-field="progress_range"]').dispatchEvent(new Event(
                        'input'));
                    targetSub.querySelector('select[data-field="status"]').dispatchEvent(new Event(
                        'change'));
                    targetSub.querySelector('select[data-field="priority"]').dispatchEvent(new Event(
                        'change'));
                });

                updateModuleHeaderBadges(newBlock);
                reindexAll();
                refreshDashboard();
                logActivity('Module Duplicated', newBlock.querySelector('[data-module-name-preview]').textContent);
            }

            /* ============================================================ */
            /* Dashboard refresh: tree + stats + donut                       */
            /* ============================================================ */
            function refreshDashboard() {
                const moduleBlocks = Array.from(modulesContainer.querySelectorAll('[data-module-block]'));

                let totalModules = moduleBlocks.length;
                let completedModules = 0,
                    pendingModules = 0;
                let totalSub = 0,
                    completedSub = 0;
                let estHoursTotal = 0,
                    remainingHoursTotal = 0;
                const developerIds = new Set();
                let progressSum = 0;

                structureTree.innerHTML = '';

                if (totalModules === 0) {
                    structureTree.innerHTML =
                        '<li class="tree-empty">Add a module to see the project structure here.</li>';
                }

                moduleBlocks.forEach((moduleBlock) => {
                    const name = moduleBlock.querySelector('[data-module-name-preview]').textContent ||
                        'Untitled Module';
                    const status = moduleBlock.querySelector('select[data-field="status"]').value;
                    const progress = parseInt(moduleBlock.querySelector('[data-field="progress"]').value ||
                        '0', 10);
                    const estHours = parseFloat(moduleBlock.querySelector('[data-field="estimated_hours"]')
                        .value || '0');
                    const dev = moduleBlock.querySelector('select[data-field="assigned_to"]').value;
                    // Additive read (visual-only) for the premium hierarchy node — does not
                    // affect any submitted field or existing calculation.
                    const priorityEl = moduleBlock.querySelector(
                        ':scope > .module-body select[data-field="priority"]');
                    const priority = priorityEl ? priorityEl.value : 'medium';
                    const subCountForNode = moduleBlock.querySelectorAll('[data-submodule-block]').length;

                    if (status === 'completed') completedModules++;
                    if (status === 'pending') pendingModules++;
                    if (dev) developerIds.add(dev);
                    estHoursTotal += estHours;
                    remainingHoursTotal += estHours * (1 - progress / 100);
                    progressSum += progress;

                    const li = document.createElement('li');
                    li.innerHTML =
                        `<div class="tree-row"><span class="tree-icon"><i class="bi bi-folder2"></i></span><span class="tree-name">${escapeHtml(name)}</span><span class="tree-meta badge-status-${status}">${STATUS_LABELS[status]}</span><span class="tree-meta badge-priority-${priority}">${PRIORITY_LABELS[priority]}</span><span class="tree-pct">${progress}%</span></div>`;
                    const subUl = document.createElement('ul');
                    subUl.className = 'tree-node';

                    moduleBlock.querySelectorAll('[data-submodule-block]').forEach((subBlock) => {
                        totalSub++;
                        const subName = subBlock.querySelector('[data-submodule-name-preview]')
                            .textContent || 'Untitled Sub Module';
                        const subStatus = subBlock.querySelector('select[data-field="status"]')
                            .value;
                        const subProgress = parseInt(subBlock.querySelector(
                            '[data-field="progress"]').value || '0', 10);
                        const subEstHours = parseFloat(subBlock.querySelector(
                            '[data-field="estimated_hours"]').value || '0');
                        const subDev = subBlock.querySelector('select[data-field="assigned_to"]')
                            .value;

                        if (subStatus === 'completed') completedSub++;
                        if (subDev) developerIds.add(subDev);
                        estHoursTotal += subEstHours;
                        remainingHoursTotal += subEstHours * (1 - subProgress / 100);

                        const subLi = document.createElement('li');
                        subLi.innerHTML =
                            `<div class="tree-row"><span class="tree-icon"><i class="bi bi-diagram-2"></i></span><span class="tree-name">${escapeHtml(subName)}</span><span class="tree-meta badge-status-${subStatus}">${STATUS_LABELS[subStatus]}</span><span class="tree-pct">${subProgress}%</span></div>`;
                        subUl.appendChild(subLi);
                    });

                    if (subCountForNode > 0) {
                        li.appendChild(subUl);
                    }
                    structureTree.appendChild(li);
                });

                structureCount.textContent = '\u00B7 ' + totalModules + (totalModules === 1 ? ' module' :
                    ' modules');

                document.getElementById('statTotalModules').textContent = totalModules;
                document.getElementById('statCompletedModules').textContent = completedModules;
                document.getElementById('statPendingModules').textContent = pendingModules;
                document.getElementById('statTotalSub').textContent = totalSub;
                document.getElementById('statCompletedSub').textContent = completedSub;
                document.getElementById('statDevelopers').textContent = developerIds.size;
                document.getElementById('statEstHours').textContent = Math.round(estHoursTotal) + ' hrs';
                document.getElementById('statRemainingHours').textContent = Math.max(0, Math.round(
                    remainingHoursTotal)) + ' hrs';

                const overallPct = totalModules > 0 ? Math.round(progressSum / totalModules) : 0;
                const circumference = 364.4;
                const offset = circumference - (overallPct / 100) * circumference;
                document.getElementById('donutArc').setAttribute('stroke-dashoffset', offset);
                document.getElementById('donutPercent').textContent = overallPct + '%';
            }

            /* ============================================================ */
            /* Quick actions                                                  */
            /* ============================================================ */
            document.getElementById('qaAddModule').addEventListener('click', () => {
                createModuleBlock();
                logActivity('Module Created', 'New module added');
            });
            document.getElementById('qaExpandAll').addEventListener('click', () => {
                modulesContainer.querySelectorAll('[data-module-block]').forEach(b => setCollapsed(b,
                    false));
            });
            document.getElementById('qaCollapseAll').addEventListener('click', () => {
                modulesContainer.querySelectorAll('[data-module-block]').forEach(b => setCollapsed(b,
                true));
            });

            addModuleBtn.addEventListener('click', () => {
                createModuleBlock();
                logActivity('Module Created', 'New module added');
            });

            /* ============================================================ */
            /* Submit safeguards                                              */
            /* ============================================================ */
            moduleForm.addEventListener('submit', function(e) {
                const moduleCount = modulesContainer.querySelectorAll('[data-module-block]').length;
                if (moduleCount === 0) {
                    e.preventDefault();
                    alert('Please add at least one module before saving.');
                    return;
                }

                let invalid = false;
                modulesContainer.querySelectorAll('[data-module-block], [data-submodule-block]').forEach((
                    block) => {
                    const start = block.querySelector('[data-field="start_date"]');
                    const end = block.querySelector('[data-field="deadline"]');
                    if (start && end && start.value && end.value && end.value < start.value) {
                        invalid = true;
                    }
                });

                if (invalid) {
                    e.preventDefault();
                    alert(
                        'Deadline cannot be earlier than the start date for one or more modules/sub modules.');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';
            });

            // Start with one empty module so the page isn't blank on load.
            createModuleBlock();
            logActivity('Module Created', 'New module added');

            /* ============================================================ */
            /* Entrance animation (lightweight CSS, no new dependency)       */
            /* ============================================================ */
            const workspace = document.querySelector('.arch-workspace');
            if (workspace) {
                const reduced = window.matchMedia && window.matchMedia(
                    '(prefers-reduced-motion: reduce)').matches;
                const anims = workspace.querySelectorAll('[data-mb-anim]');
                if (reduced || !('animate' in Element.prototype)) {
                    workspace.setAttribute('data-mb-ready', '1');
                } else {
                    anims.forEach((el, i) => {
                        el.animate([
                            { opacity: 0, transform: 'translateY(10px)' },
                            { opacity: 1, transform: 'translateY(0)' }
                        ], {
                            duration: 420,
                            delay: i * 60,
                            easing: 'cubic-bezier(.16,.84,.44,1)',
                            fill: 'both'
                        });
                    });
                    workspace.setAttribute('data-mb-ready', '1');
                }
            }
        });



       $(document).on('change', '.department-select', function () {

    let departmentId = $(this).val();

    let developerSelect = $(this)
        .closest('[data-module-block]')
        .find('.assigned-select');

    developerSelect.html('<option>Loading...</option>');

    if (departmentId == '') {
        developerSelect.html('<option value="">Select Lead Developer</option>');
        return;
    }

    $.ajax({
        url: '/admin/projects/get-developers/' + departmentId,
        type: 'GET',
        success: function(response) {

            let option = '<option value="">Select Developer</option>';

            $.each(response, function(index, developer) {
                option +=
                    '<option value="' + developer.id + '">' +
                    developer.name +
                    '</option>';
            });

            developerSelect.html(option);
        }
    });

});
    </script>
@endpush
