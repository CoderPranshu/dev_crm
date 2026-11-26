@extends('index')

@push('title', get_phrase('Map Client Backlink Columns'))

@push('css')

<style>

    .cbm-map { --map-primary:#3157d5; --map-success:#119d68; --map-border:#e2e8f0; --map-muted:#718096; color:#1e293b; }

    .map-head { display:flex; justify-content:space-between; align-items:flex-end; gap:18px; margin-bottom:20px; }

    .map-kicker { margin-bottom:10px; color:#77839a; font-size:11px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }

    .map-title { margin:0; font-size:27px; font-weight:850; }

    .map-subtitle { margin:7px 0 0; color:var(--map-muted); font-size:13px; }

    .map-steps { color:#8590a3; font-size:12px; white-space:nowrap; }

    .map-steps strong { color:var(--map-primary); }

    .map-meta { display:flex; gap:9px; flex-wrap:wrap; margin:18px 0; }

    .map-pill { padding:8px 12px; border:1px solid var(--map-border); border-radius:9px; background:#fff; font-size:11.5px; }

    .map-grid { display:grid; grid-template-columns:minmax(260px, 330px) minmax(0, 1fr); gap:20px; align-items:start; }

    .map-card { overflow:hidden; border:1px solid var(--map-border); border-radius:15px; background:#fff; box-shadow:0 7px 24px rgba(15,23,42,.045); }

    .map-schema-head { padding:21px; background:#f7f9fc; border-bottom:1px solid var(--map-border); }

    .map-overline { color:#77839a; font-size:10.5px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }

    .map-schema-name { display:flex; justify-content:space-between; align-items:center; margin-top:17px; color:var(--map-primary); font-weight:800; }

    .map-db { padding:6px 9px; border:1px solid var(--map-border); border-radius:8px; color:#667085; background:#fff; font-size:10px; font-weight:500; }

    .map-schema-field { padding:18px 20px; border-bottom:1px solid var(--map-border); }

    .map-schema-field:last-child { border-bottom:0; }

    .map-field-line { display:flex; justify-content:space-between; gap:10px; align-items:center; }

    .map-field-name { font-family:ui-monospace,SFMono-Regular,Menlo,monospace; font-size:12px; }

    .map-type { padding:5px 7px; border-radius:7px; background:#f2f5fb; color:#768399; font-size:9.5px; }

    .map-rule { margin-top:10px; color:#8190a7; font-size:10.5px; }

    .map-required { color:#e34e5f; }

    .map-main-head { display:flex; justify-content:space-between; gap:12px; padding:20px 22px; border-bottom:1px solid var(--map-border); }

    .map-main-head h4 { margin:0; font-size:17px; font-weight:800; }

    .map-main-head p { margin:5px 0 0; color:var(--map-muted); font-size:11.5px; }

    .map-buttons { display:flex; gap:8px; }

    .map-btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:40px; padding:8px 14px; border:1px solid var(--map-border); border-radius:9px; background:#fff; color:#475569; font-size:12px; font-weight:700; text-decoration:none; }

    .map-btn-primary { border-color:var(--map-success); background:var(--map-success); color:#fff; }

    .map-category { padding:17px 22px; border-bottom:1px solid var(--map-border); background:#fcfdfd; }

    .map-category-label { color:#475569; font-size:11px; font-weight:750; }

    .map-category-value { margin-top:7px; padding:10px 12px; border:1px solid var(--map-border); border-radius:9px; background:#f7f9fb; font-size:12px; }

    .map-rows { padding:4px 22px 20px; }

    .map-row { display:grid; grid-template-columns:minmax(170px,.8fr) minmax(230px,1.2fr); gap:18px; padding:18px 0; border-bottom:1px solid var(--map-border); align-items:center; }

    .map-row:last-child { border-bottom:0; }

    .map-destination strong { display:block; font-size:12px; }

    .map-destination small { color:var(--map-muted); font-size:10.5px; }

    .map-select { width:100%; min-height:43px; padding:9px 11px; border:1px solid #d9e0e9; border-radius:9px; background:#fff; font-size:12px; }

    .map-source-area { padding:18px 22px; border-top:1px solid var(--map-border); background:#fafbfd; }

    .map-source-title { margin-bottom:11px; color:#667085; font-size:10.5px; font-weight:800; text-transform:uppercase; letter-spacing:.08em; }

    .map-chips { display:flex; gap:8px; flex-wrap:wrap; }

    .map-chip { padding:8px 10px; border:1px solid #dce3ee; border-radius:8px; background:#fff; color:#476079; font-size:10.5px; }

    .map-chip span { margin-left:6px; color:#a0a8b5; }

    .map-footer { display:flex; justify-content:space-between; gap:12px; padding:16px 22px; border-top:1px solid var(--map-border); }

    .map-preview { margin-top:20px; }

    .map-preview-head { padding:15px 18px; border-bottom:1px solid var(--map-border); font-size:13px; font-weight:800; }

    .map-table-wrap { overflow:auto; max-height:330px; }

    .map-table { width:100%; min-width:700px; border-collapse:collapse; }

    .map-table th,.map-table td { padding:10px 12px; border-right:1px solid var(--map-border); border-bottom:1px solid var(--map-border); font-size:11px; text-align:left; white-space:nowrap; }

    .map-table th { position:sticky; top:0; z-index:1; background:#f5f7fa; font-weight:800; }

    .map-errors { margin-bottom:18px; padding:13px 16px; border:1px solid #f5c7cd; border-radius:10px; background:#fff1f3; color:#b42336; font-size:12px; }

    @media(max-width:900px){ .map-grid{grid-template-columns:1fr}.map-head{align-items:flex-start;flex-direction:column}.map-row{grid-template-columns:1fr}.map-steps{white-space:normal} }

    @media(max-width:600px){ .map-main-head,.map-footer{flex-direction:column}.map-buttons{flex-wrap:wrap}.map-btn{flex:1} }

</style>

@endpush

@section('content')

@php

    $selectedMapping = [

        'website_url' => old('mapping.website_url', $defaultMapping['website_url']),

        'domain_authority' => old('mapping.domain_authority', $defaultMapping['domain_authority']),

        'page_authority' => old('mapping.page_authority', $defaultMapping['page_authority']),

        'username' => old('mapping.username', $defaultMapping['username']),

        'password' => old('mapping.password', $defaultMapping['password']),

    ];

@endphp

<div class="cbm-map">

    @include('admin.backlinks.partials.alerts')

    <div class="map-head">

        <div>

            <div class="map-kicker">Client Backlink Import / Column Configuration</div>

            <h1 class="map-title">Connect your data.</h1>

            <p class="map-subtitle">

                Match file columns to the backlink schema for

                <strong>{{ $seoPlanClient->company->name ?? 'this SEO client' }}</strong>.

            </p>

        </div>

        <div class="map-steps">01 Upload  /  <strong>02 Map columns</strong>  /  03 Import</div>

    </div>

    <div class="map-meta">

        <span class="map-pill"><i class="fa-regular fa-file me-1"></i>{{ $clientBacklinkImport->original_name }}</span>

        <span class="map-pill">{{ strtoupper($clientBacklinkImport->extension) }} · {{ count($headers) }} columns</span>

        <span class="map-pill">Source: Global Backlinks</span>

        <span class="map-pill"><i class="fa-solid fa-lock me-1"></i>Client ID {{ $seoPlanClient->id }}</span>

    </div>

    @if($errors->any())

        <div class="map-errors">

            @foreach($errors->all() as $error)

                <div>{{ $error }}</div>

            @endforeach

        </div>

    @endif

    <form action="{{ route('admin.seo-client-backlinks.process', [$seoPlanClient, $clientBacklinkImport]) }}" method="POST" id="mapping-form">

        @csrf

        <div class="map-grid">

            <aside class="map-card">

                <div class="map-schema-head">

                    <div class="map-overline">Destination Schema</div>

                    <div class="map-schema-name">

                        <span>backlink_assignments</span>

                        <span class="map-db">Database</span>

                    </div>

                    <div class="map-rule">5 mappable fields · selected client is fixed</div>

                </div>

                <div class="map-schema-field">

                    <div class="map-field-line">

                        <span class="map-field-name">website_url <span class="map-required">*</span></span>

                        <span class="map-type">varchar(255)</span>

                    </div>

                    <div class="map-rule">HTTP / HTTPS URL · required</div>

                </div>

                <div class="map-schema-field">

                    <div class="map-field-line">

                        <span class="map-field-name">domain_authority</span>

                        <span class="map-type">integer / null</span>

                    </div>

                    <div class="map-rule">Whole number · 0–100 · optional</div>

                </div>

                <div class="map-schema-field">

                    <div class="map-field-line">

                        <span class="map-field-name">page_authority</span>

                        <span class="map-type">integer / null</span>

                    </div>

                    <div class="map-rule">Whole number · 0–100 · optional</div>

                </div>

                <div class="map-schema-field">

                    <div class="map-field-line">

                        <span class="map-field-name">username <span class="map-required">*</span></span>

                        <span class="map-type">varchar / required</span>

                    </div>

                    <div class="map-rule">Login username filled by the SEO team</div>

                </div>

                <div class="map-schema-field">

                    <div class="map-field-line">

                        <span class="map-field-name">password <span class="map-required">*</span></span>

                        <span class="map-type">varchar / required</span>

                    </div>

                    <div class="map-rule">Login password filled by the SEO team</div>

                </div>

            </aside>

            <section class="map-card">

                <div class="map-main-head">

                    <div>

                        <h4>Column mapping</h4>

                        <p>Choose one source column for each destination field.</p>

                    </div>

                    <div class="map-buttons">

                        <button type="button" class="map-btn" id="auto-map">Auto-map</button>

                        <button type="button" class="map-btn" id="reset-map">Reset</button>

                    </div>

                </div>

                <div class="map-category">

                    <div class="map-category-label">Fixed import destination</div>

                    <div class="map-category-value">

                        <i class="fa-solid fa-building me-1"></i>

{{ $seoPlanClient->company->name ?? 'SEO Client' }}

                    </div>

                    <small class="text-muted">All imported assignments will belong only to this selected client.</small>

                </div>

                <div class="map-category">
                    <label class="map-category-label" for="backlink_category_id">Backlink category <span class="map-required">*</span></label>
                    <select name="backlink_category_id" id="backlink_category_id" class="map-select" required>
                        <option value="">Choose category for new URLs</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('backlink_category_id') === (string) $category->id)>
                                {{ $category->title ?? $category->name ?? 'Category #'.$category->id }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Existing URLs retain their current category.</small>
                </div>

                <div class="map-rows">

                    @foreach([

                        'website_url' => ['Website URL', 'Required destination field'],

                        'domain_authority' => ['Domain Authority (DA)', 'Optional · 0 to 100'],

                        'page_authority' => ['Page Authority (PA)', 'Optional · 0 to 100'],

                        'username' => ['Username', 'Required · filled by SEO team'],

                        'password' => ['Password', 'Required · filled by SEO team'],

                    ] as $field => [$label, $help])

                        <div class="map-row">

                            <div class="map-destination">

                                <strong>{{ $label }} @if(in_array($field, ['website_url', 'username', 'password'], true))<span class="map-required">*</span>@endif</strong>

                                <small>{{ $help }}</small>

                            </div>

                            <select name="mapping[{{ $field }}]" class="map-select mapping-select" data-field="{{ $field }}" @required(in_array($field, ['website_url', 'username', 'password'], true))>

                                <option value="">{{ in_array($field, ['website_url', 'username', 'password'], true) ? 'Choose source column' : 'Do not import' }}</option>

                                @foreach($headers as $index => $header)

                                    <option value="{{ $index }}" @selected((string) $selectedMapping[$field] === (string) $index)>

                                        Column {{ $index + 1 }}: {{ $header ?: '(Unnamed)' }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    @endforeach

                </div>

                <div class="map-source-area">

                    <div class="map-source-title">Source columns</div>

                    <div class="map-chips">

                        @foreach($headers as $index => $header)

                            <span class="map-chip">{{ $header ?: '(Unnamed)' }} <span>{{ $index + 1 }}</span></span>

                        @endforeach

                    </div>

                </div>

                <div class="map-footer">

                    <a href="{{ route('admin.seo-client-backlinks.upload', $seoPlanClient) }}" class="map-btn">

                        <i class="fa-solid fa-arrow-left"></i> Back

                    </a>

                    <button type="submit" class="map-btn map-btn-primary" id="import-button">

                        <i class="fa-solid fa-file-import"></i> Import for this client

                    </button>

                </div>

            </section>

        </div>

    </form>

    <section class="map-card map-preview">

        <div class="map-preview-head">File preview · first {{ count($preview) }} data rows</div>

        <div class="map-table-wrap">

            <table class="map-table">

                <thead>

                    <tr>

                        <th>#</th>

                        @foreach($headers as $index => $header)

                            <th>{{ $index + 1 }}. {{ $header ?: '(Unnamed)' }}</th>

                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @forelse($preview as $row)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            @foreach($headers as $index => $header)

                                <td>{{ $row[$index] ?? '' }}</td>

                            @endforeach

                        </tr>

                    @empty

                        <tr><td colspan="{{ count($headers) + 1 }}">No data rows found.</td></tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</div>

@push('js')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const defaults = @json($defaultMapping);

    const selects = Array.from(document.querySelectorAll('.mapping-select'));

    document.getElementById('auto-map').addEventListener('click', function () {

        selects.forEach(function (select) {

            const value = defaults[select.dataset.field];

            select.value = value === null ? '' : String(value);

        });

    });

    document.getElementById('reset-map').addEventListener('click', function () {

        selects.forEach(function (select) { select.value = ''; });

    });

    document.getElementById('mapping-form').addEventListener('submit', function () {

        const button = document.getElementById('import-button');

        button.disabled = true;

        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Importing...';

    });

});

</script>

@endpush

@endsection