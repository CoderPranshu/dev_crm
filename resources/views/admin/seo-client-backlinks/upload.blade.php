@extends('index')

@push('title', get_phrase('Upload Client Backlinks'))

@push('css')
<style>
    .cbu-page { --cbu-primary:#0f8ea3; --cbu-border:#e4eaf0; --cbu-muted:#6b7280; }
    .cbu-head { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:22px; }
    .cbu-title { margin:0; font-size:25px; font-weight:800; color:#1f2937; }
    .cbu-subtitle { margin:6px 0 0; color:var(--cbu-muted); font-size:13px; }
    .cbu-grid { display:grid; grid-template-columns:minmax(0, 2fr) minmax(280px, 1fr); gap:20px; }
    .cbu-card { border:1px solid var(--cbu-border); border-radius:15px; background:#fff; box-shadow:0 7px 22px rgba(15,23,42,.05); }
    .cbu-body { padding:23px; }
    .cbu-footer { padding:16px 23px; border-top:1px solid var(--cbu-border); text-align:right; }
    .cbu-client { display:flex; gap:11px; align-items:center; padding:14px; margin-bottom:21px; border-radius:11px; background:#eef9fb; color:#246474; }
    .cbu-client i { font-size:18px; }
    .cbu-label { display:block; margin-bottom:8px; color:#273244; font-size:13px; font-weight:750; }
    .cbu-control { width:100%; min-height:45px; padding:10px 12px; border:1px solid var(--cbu-border); border-radius:10px; background:#fff; }
    .cbu-field { margin-bottom:20px; }
    .cbu-help { display:block; margin-top:7px; color:var(--cbu-muted); font-size:11.5px; }
    .cbu-note { padding:13px 15px; border:1px solid #cce9ee; border-radius:10px; background:#f3fbfc; color:#246474; font-size:12px; }
    .cbu-btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:42px; padding:9px 15px; border:1px solid var(--cbu-border); border-radius:10px; background:#fff; color:#273244; font-size:13px; font-weight:700; text-decoration:none; }
    .cbu-btn-primary { border-color:var(--cbu-primary); background:var(--cbu-primary); color:#fff; }
    .cbu-list { margin:0; padding-left:19px; color:#566173; font-size:12.5px; line-height:1.9; }
    @media(max-width:850px){ .cbu-grid{grid-template-columns:1fr}.cbu-head{flex-direction:column} }
</style>
@endpush

@section('content')
<div class="cbu-page">
    @include('admin.backlinks.partials.alerts')

    <div class="cbu-head">
        <div>
            <h1 class="cbu-title">Upload Client Backlinks</h1>
            <p class="cbu-subtitle">Upload a CSV or Excel file, then map its columns.</p>
        </div>
        <a href="{{ route('admin.seo-client-backlinks.index', $seoPlanClient) }}" class="cbu-btn">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('admin.seo-client-backlinks.prepare', $seoPlanClient) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="cbu-grid">
            <div class="cbu-card">
                <div class="cbu-body">
                    <div class="cbu-client">
                        <i class="fa-solid fa-building-shield"></i>
                        <div>
                            <strong>{{ $seoPlanClient->company->name ?? 'SEO Client' }}</strong><br>
                            <small>Everything imported from this file will belong only to this client.</small>
                        </div>
                    </div>

                    <div class="cbu-field">
                        <label for="file" class="cbu-label">
                            CSV / Excel File <span class="text-danger">*</span>
                        </label>
                        <input id="file" type="file" name="file" accept=".csv,.xlsx,.xls" class="cbu-control" required>
                        <small class="cbu-help">Allowed: CSV, XLSX, XLS · Maximum 50 MB · First row must contain headings.</small>
                        @error('file')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="cbu-note">
                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i>
                        Upload the file downloaded from Global Backlinks after filling its Username and Password columns.
                        You will map the columns on the next screen.
                    </div>
                </div>

                <div class="cbu-footer">
                    <button type="submit" class="cbu-btn cbu-btn-primary">
                        Next: Map Columns <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <aside class="cbu-card">
                <div class="cbu-body">
                    <h5 class="mb-3">Import rules</h5>
                    <ul class="cbu-list">
                        <li>Only backlinks already present in Global Backlinks can be assigned.</li>
                        <li>Website URL, Username and Password are required.</li>
                        <li>DA and PA are optional and are used only for file validation.</li>
                        <li>Invalid rows are skipped and counted.</li>
                        <li>A backlink already assigned to this client is skipped.</li>
                        <li>The same backlink may belong to another client separately.</li>
                        <li>Excel uses the first worksheet.</li>
                    </ul>
                </div>
            </aside>
        </div>
    </form>
</div>
@endsection
