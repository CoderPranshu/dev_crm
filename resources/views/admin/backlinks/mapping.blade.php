@extends('index')
@push('title', get_phrase('Advanced Backlink Mapping'))
@section('content')
<style>
.bm{--ink:#172842;--muted:#778397;--line:#e6ebf1;--accent:#3657dc;--soft:#f4f6fb;color:var(--ink);font-family:inherit;padding:24px 10px}.bm *{box-sizing:border-box}.bm button,.bm select,.bm input{font:inherit}.bm .eyebrow{font-size:11px;text-transform:uppercase;letter-spacing:1.6px;font-weight:700;color:var(--muted)}.bm h2{font-size:27px;font-weight:750;letter-spacing:-.8px;margin:8px 0}.bm p{color:var(--muted);font-size:13px;margin:0;line-height:1.6}.bm-top{display:flex;justify-content:space-between;align-items:center;gap:20px;margin-bottom:24px}.bm-file{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-top:12px}.bm-pill{border:1px solid var(--line);border-radius:8px;padding:5px 10px;background:white;font-size:11px;color:#57657b}.bm-step{font-size:12px;color:var(--muted)}.bm-step strong{color:var(--accent)}.bm-grid{display:grid;grid-template-columns:315px minmax(0,1fr);gap:22px;align-items:start}.bm-panel{border:1px solid var(--line);border-radius:17px;background:#fff;box-shadow:0 5px 20px #17284204;overflow:hidden}.bm-panel-head{padding:22px 24px;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;gap:12px}.bm-panel-head h3{font-size:16px;letter-spacing:-.3px;font-weight:700;margin:0 0 4px}.bm-schema{position:sticky;top:18px}.bm-schema-head{background:#f8faff}.bm-schema-head code{font-size:13px;color:var(--accent)}.bm-fields{padding:10px 20px}.bm-schema-field{padding:16px 0;border-bottom:1px solid var(--line)}.bm-schema-field:last-child{border:0}.bm-field-name{display:flex;justify-content:space-between;align-items:center;gap:8px;font-size:12px}.bm-field-name code{font-size:12px;color:var(--ink)}.bm-type{font-size:10px;color:var(--muted);background:var(--soft);border-radius:5px;padding:3px 6px}.bm-schema-field p{font-size:11px;margin:6px 0}.bm-state{font-size:11px;display:flex;align-items:center;gap:6px;color:var(--muted);word-break:break-word}.bm-dot{width:6px;height:6px;border-radius:50%;background:#c4cddd;flex-shrink:0}.bm-state.mapped{color:#1e8a67}.bm-state.mapped .bm-dot{background:#1e8a67}.bm-fixed{padding:18px 20px;background:#f8faff;border-top:1px solid var(--line)}.bm-fixed h4{font-size:11px;font-weight:700;margin:0 0 12px;text-transform:uppercase;letter-spacing:1px}.bm-fixed-row{display:flex;justify-content:space-between;gap:12px;font-size:11px;color:var(--muted);padding:5px 0}.bm-fixed-row strong{color:#4a5970;max-width:155px;text-align:right;word-break:break-word}.bm-category{padding:20px 24px;border-bottom:1px solid var(--line);background:#fcfdff}.bm label{font-size:12px;font-weight:650;display:block;margin-bottom:8px}.bm select{width:100%;background:#fff;border:1px solid #dce3ed;border-radius:9px;padding:11px 12px;font-size:12px;color:var(--ink);min-height:42px}.bm select:focus,.bm input:focus{outline:3px solid #3657dc18;border-color:var(--accent)}.bm-category-note{font-size:11px;color:var(--muted);margin-top:7px}.bm-source-zone{padding:20px 24px;border-bottom:1px solid var(--line)}.bm-section-top{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:12px}.bm-section-top h4{font-size:12px;font-weight:700;margin:0}.bm-search{border:1px solid var(--line);border-radius:7px;padding:6px 10px;font-size:11px;width:175px;max-width:100%}.bm-source-list{display:flex;flex-wrap:wrap;gap:8px}.bm-source{border:1px solid var(--line);background:#fff;border-radius:8px;padding:8px 11px;font-size:11px;cursor:grab;display:flex;align-items:center;gap:8px;color:#516077;max-width:100%}.bm-source .source-name{word-break:break-word}.bm-source .source-no{font-size:10px;background:var(--soft);padding:2px 4px;border-radius:4px;color:var(--muted)}.bm-source.used{background:#f0f4ff;border-color:#d5defb;color:var(--accent)}.bm-source:active{cursor:grabbing}.bm-targets{padding:20px 24px;display:grid;gap:13px}.bm-target{border:1px solid var(--line);border-radius:12px;padding:16px 18px;transition:border-color .15s,background .15s}.bm-target.drag-over{border-color:var(--accent);background:#f3f6ff}.bm-target.has-mapping{border-color:#dce3f8}.bm-target-top{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:11px}.bm-target-top label{margin:0;font-size:13px}.bm-required{color:#cb5a69;font-size:10px;margin-left:5px}.bm-optional{font-size:10px;color:var(--muted);margin-left:5px}.bm-target-code{font-size:10px;color:var(--muted)}.bm-target-bottom{margin-top:10px;display:flex;justify-content:space-between;align-items:start;gap:12px}.bm-sample{font-size:11px;color:var(--muted);overflow-wrap:anywhere;min-width:0}.bm-sample strong{font-weight:500;color:#45556d}.bm-clear{border:0;background:none;color:var(--accent);font-size:10px;cursor:pointer;padding:0;white-space:nowrap}.bm-field-error{font-size:11px;color:#b44353;margin-top:7px;min-height:0}.bm-actions{display:flex;gap:8px}.bm-btn{border:1px solid var(--line);background:#fff;padding:8px 12px;border-radius:8px;font-size:11px;font-weight:600;cursor:pointer;color:#53617a;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px}.bm-btn:hover{background:#f5f7fc}.bm-btn.primary{background:var(--accent);border-color:var(--accent);color:#fff;padding:11px 20px;font-size:12px;box-shadow:0 4px 8px #3657dc18}.bm-btn.primary:disabled{opacity:.45;cursor:not-allowed;box-shadow:none}.bm-summary{padding:0 24px 22px}.bm-health{background:#f7f9fc;border:1px solid var(--line);border-radius:9px;padding:12px 14px;display:flex;gap:10px;align-items:start;font-size:11px;color:#617087}.bm-health strong{color:#2f4364}.bm-footer{padding:18px 24px;border-top:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;gap:14px;background:#fcfdff}.bm-progress-label{font-size:11px;color:var(--muted);margin-bottom:6px}.bm-progress{height:4px;width:125px;background:#e7ecf6;border-radius:5px;overflow:hidden}.bm-progress span{display:block;background:var(--accent);height:100%;transition:width .2s}.bm-preview{margin-top:22px}.bm-tabs{display:flex;background:var(--soft);border-radius:8px;padding:3px;gap:2px}.bm-tab{background:none;border:0;font-size:11px;padding:7px 10px;border-radius:6px;color:var(--muted);cursor:pointer}.bm-tab.active{background:#fff;color:var(--accent);box-shadow:0 1px 4px #17284212}.bm-table-wrap{overflow:auto;max-height:360px}.bm-table{width:100%;border-collapse:collapse;font-size:11px;white-space:nowrap}.bm-table th{padding:14px 20px;background:#f8faff;color:#68778e;font-size:10px;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid var(--line);position:sticky;top:0}.bm-table td{padding:13px 20px;border-bottom:1px solid var(--line);max-width:300px;overflow:hidden;text-overflow:ellipsis;color:#42546f}.bm-table tr:last-child td{border:0}.bm-table tr.warning td{background:#fff9ed}.bm-row-badge{font-size:10px;padding:4px 7px;border-radius:5px;display:inline-block}.bm-row-badge.ok{background:#eaf7f1;color:#258763}.bm-row-badge.bad{background:#fff0d4;color:#a5711c}.bm-preview-foot{padding:13px 24px;border-top:1px solid var(--line);font-size:11px;color:var(--muted)}.bm-server-errors{border:1px solid #f3ccd4;background:#fff4f6;border-radius:10px;padding:12px 18px;color:#a13c52;font-size:12px;margin-bottom:18px}.bm-server-errors ul{margin:0;padding-left:18px}.bm-right{min-width:0}.bm-noscript{margin:15px;padding:15px;background:#fff4d9;font-size:13px}.bm :focus-visible{outline:3px solid #3657dc30;outline-offset:2px}@media(max-width:1100px){.bm-grid{grid-template-columns:260px minmax(0,1fr)}.bm-panel-head,.bm-category,.bm-source-zone,.bm-targets{padding-left:18px;padding-right:18px}.bm-panel-head{flex-wrap:wrap}.bm-target-code{display:none}}@media(max-width:760px){.bm{padding:16px 0}.bm-grid{grid-template-columns:1fr}.bm-schema{position:static}.bm-top{align-items:start;flex-wrap:wrap}.bm-step{display:none}.bm-fields{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;padding:10px 15px}.bm-schema-field{border:0}.bm-field-name{display:block}.bm-type{display:inline-block;margin-top:5px}.bm-field-name code{font-size:10px;overflow-wrap:anywhere}.bm-fixed{padding:12px 16px}.bm-section-top{flex-wrap:wrap}.bm-footer{flex-wrap:wrap}.bm-tabs{max-width:100%}.bm h2{font-size:23px}}
</style>
@php($initialMapping = old('mapping', $upload->mapping ?? []))
<div class="bm" id="backlink-mapper">
    <div class="bm-top">
        <div><div class="eyebrow">Backlink import / Column configuration</div><h2>Connect your data.</h2><p>Match your file columns to the backlink schema before importing.</p>
            <div class="bm-file"><span class="bm-pill">{{ $upload->original_name }}</span><span class="bm-pill">{{ strtoupper($upload->extension) }} · {{ count($headers) }} columns</span><span class="bm-pill">First worksheet · Row 1 is header</span></div>
        </div>
        <div class="bm-step">01 Upload &nbsp; / &nbsp; <strong>02 Map columns</strong> &nbsp; / &nbsp; 03 Import</div>
    </div>
    @if($errors->any())<div class="bm-server-errors" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @if(session('error'))<div class="bm-server-errors" role="alert">{{ session('error') }}</div>@endif
    <form action="{{ route('admin.backlinks.import-mapped', ['upload' => $upload->id]) }}" method="POST" id="bm-form">
        @csrf
        <div class="bm-grid">
            <aside class="bm-panel bm-schema" aria-label="Database schema">
                <div class="bm-panel-head bm-schema-head"><div><div class="eyebrow">Destination schema</div><h3 style="margin-top:8px"><code>backlinks</code></h3><p>3 mappable fields · 3 fixed values</p></div><span class="bm-pill">Database</span></div>
                <div class="bm-fields" id="bm-schema-fields"></div>
                <div class="bm-fixed"><h4>Values set on import</h4>
                    <div class="bm-fixed-row"><span>backlink_category_id</span><strong id="bm-schema-category">—</strong></div>
                    <div class="bm-fixed-row"><span>status</span><strong>available</strong></div>
                    <div class="bm-fixed-row"><span>created_by</span><strong>Current user</strong></div>
                    <p style="font-size:11px;margin-top:12px">Username and password can be added by your SEO team later.</p>
                </div>
            </aside>
            <div class="bm-right">
                <section class="bm-panel" aria-label="Column mapping">
                    <div class="bm-panel-head"><div><h3>Column mapping</h3><p>Choose a source column or drag its chip onto a field.</p></div><div class="bm-actions"><button class="bm-btn" type="button" id="bm-auto">Auto-map</button><button class="bm-btn" type="button" id="bm-reset">Reset</button></div></div>
                    <div class="bm-category"><label for="bm-category">Import category <span class="bm-required">Required</span></label>
                        <select name="backlink_category_id" id="bm-category" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('backlink_category_id', $upload->backlink_category_id) === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="bm-category-note">Your upload category is preselected. All imported backlinks use this category.</div>
                        @error('backlink_category_id')<div class="bm-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="bm-source-zone"><div class="bm-section-top"><h4>Source columns <span class="bm-optional" id="bm-unused"></span></h4><input type="search" class="bm-search" id="bm-search" placeholder="Search columns…" aria-label="Search source columns"></div><div class="bm-source-list" id="bm-sources"></div></div>
                    <div class="bm-targets" id="bm-targets"></div>
                    <div class="bm-summary"><div class="bm-health" id="bm-health" role="status" aria-live="polite"></div></div>
                    <div class="bm-footer"><div><div class="bm-progress-label" id="bm-progress-label">0 of 3 fields mapped</div><div class="bm-progress"><span id="bm-progress-bar" style="width:0"></span></div></div><div class="bm-actions"><a href="{{ route('admin.backlinks.index') }}" class="bm-btn">Back</a><button type="submit" class="bm-btn primary" id="bm-import" disabled>Import backlinks →</button></div></div>
                </section>
                <section class="bm-panel bm-preview" aria-label="File preview"><div class="bm-panel-head"><div><h3>Live data preview</h3><p>First {{ count($preview) }} data rows · updates as you map</p></div><div class="bm-tabs" role="group" aria-label="Preview mode"><button class="bm-tab active" id="bm-tab-mapped" type="button" aria-pressed="true">Mapped data</button><button class="bm-tab" id="bm-tab-raw" type="button" aria-pressed="false">Original file</button></div></div><div class="bm-table-wrap"><table class="bm-table"><thead id="bm-table-head"></thead><tbody id="bm-table-body"></tbody></table></div><div class="bm-preview-foot">Preview checks this sample only. The server validates all rows and checks existing database URLs on import.</div></section>
            </div>
        </div>
        <noscript><div class="bm-noscript">Enable JavaScript to configure and preview your column mapping.</div></noscript>
    </form>
</div>
<script>
(function () {
'use strict';
const headers = @json($headers);
const preview = @json($preview);
const initial = @json($initialMapping);
const hasOldMapping = @json(session()->hasOldInput('mapping'));
const fields = [
    {key:'website_url',label:'Website URL',type:'varchar(255)',required:true,rule:'HTTP / HTTPS URL · max 255 bytes',aliases:['websiteurl','website','url','domain','site','siteurl','backlinkurl']},
    {key:'domain_authority',label:'Domain Authority',type:'integer / null',required:false,rule:'Whole number · 0–100 · nullable',aliases:['domainauthority','da']},
    {key:'page_authority',label:'Page Authority',type:'integer / null',required:false,rule:'Whole number · 0–100 · nullable',aliases:['pageauthority','pa']}
];
const $ = id => document.getElementById(id);
const escape = v => String(v ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const header = i => headers[i] || '(Unnamed column)';
const selected = {};
let mode = 'mapped';
let busy = false;
fields.forEach(f => { const value = initial[f.key]; selected[f.key] = value !== '' && value != null && Number.isInteger(Number(value)) && Number(value) >= 0 && Number(value) < headers.length ? String(value) : ''; });
$('bm-schema-fields').innerHTML = fields.map(f => `<div class="bm-schema-field"><div class="bm-field-name"><code>${f.key}</code><span class="bm-type">${f.type}</span></div><p>${f.rule}</p><div class="bm-state" id="schema-${f.key}"><span class="bm-dot"></span><span>Awaiting mapping</span></div></div>`).join('');
$('bm-targets').innerHTML = fields.map(f => `<div class="bm-target" data-key="${f.key}" id="target-${f.key}"><div class="bm-target-top"><label for="select-${f.key}">${f.label}<span class="${f.required ? 'bm-required' : 'bm-optional'}">${f.required ? 'Required' : 'Optional'}</span></label><span class="bm-target-code">${f.key}</span></div><select name="mapping[${f.key}]" id="select-${f.key}" ${f.required ? 'required' : ''}><option value="">${f.required ? 'Choose a source column' : 'Do not import this field'}</option>${headers.map((h,i) => `<option value="${i}">Column ${i+1} · ${escape(header(i))}</option>`).join('')}</select><div class="bm-target-bottom"><div class="bm-sample" id="sample-${f.key}">Sample: —</div><button class="bm-clear" type="button" data-clear="${f.key}">Clear</button></div><div class="bm-field-error" id="error-${f.key}" role="status"></div></div>`).join('');
function autoMap() {
    const used = new Set();
    fields.forEach(f => {
        const index = headers.findIndex((h,i) => !used.has(i) && f.aliases.includes(String(h).toLowerCase().replace(/[^a-z0-9]/g,'')));
        selected[f.key] = index >= 0 ? String(index) : '';
        if (index >= 0) used.add(index);
    });
}
function value(row, key) { return selected[key] === '' ? null : row[Number(selected[key])] ?? null; }
function rowProblems(row, seen) {
    const problems = [];
    const url = String(value(row,'website_url') ?? '').trim();
    if (selected.website_url === '') problems.push('URL unmapped');
    else {
        try {
            const parsed = new URL(url);
            const bytes = new TextEncoder().encode(url).length;
            if (!/^https?:\/\//i.test(url) || !['http:','https:'].includes(parsed.protocol) || !parsed.hostname || bytes > 255) throw new Error();
        } catch (_) { problems.push('Invalid URL'); }
        if (url && seen.has(url)) problems.push('Duplicate in sample');
        if (url) seen.add(url);
    }
    fields.slice(1).forEach(f => {
        const v = String(value(row,f.key) ?? '').trim();
        if (selected[f.key] !== '' && v !== '' && (!Number.isFinite(Number(v)) || !Number.isInteger(Number(v)) || Number(v) < 0 || Number(v) > 100 || /^0x/i.test(v))) problems.push(f.key === 'domain_authority' ? 'Invalid DA' : 'Invalid PA');
    });
    return problems;
}
function renderSources() {
    const used = new Set(Object.values(selected).filter(v => v !== ''));
    const query = $('bm-search').value.toLowerCase();
    $('bm-unused').textContent = `${headers.length - used.size} unused`;
    $('bm-sources').innerHTML = headers.map((h,i) => ({name:header(i),i})).filter(x => x.name.toLowerCase().includes(query)).map(x => `<div class="bm-source ${used.has(String(x.i)) ? 'used' : ''}" draggable="true" data-column="${x.i}" title="Drag onto a destination field"><span aria-hidden="true">⠿</span><span class="source-name">${escape(x.name)}</span><span class="source-no">${x.i+1}</span></div>`).join('') || '<p>No matching columns.</p>';
}
function renderPreview() {
    const seen = new Set();
    const columns = mode === 'raw' ? headers.map((h,i) => ({title:header(i),get:row => row[i] ?? ''})) : fields.map(f => ({title:f.label,get:row => {const v=value(row,f.key);return v===null || String(v).trim()==='' ? '—' : v;}}));
    $('bm-table-head').innerHTML = `<tr><th>#</th>${columns.map(c => `<th>${escape(c.title)}</th>`).join('')}${mode === 'mapped' ? '<th>Sample check</th>' : ''}</tr>`;
    let warnings = 0;
    $('bm-table-body').innerHTML = preview.map((row,i) => {
        const problems = rowProblems(row,seen);
        if (problems.length) warnings++;
        return `<tr class="${mode==='mapped' && problems.length ? 'warning' : ''}"><td>${i+1}</td>${columns.map(c => `<td title="${escape(c.get(row))}">${escape(c.get(row))}</td>`).join('')}${mode==='mapped' ? `<td><span class="bm-row-badge ${problems.length ? 'bad' : 'ok'}">${escape(problems.join(' · ') || 'Looks valid')}</span></td>` : ''}</tr>`;
    }).join('') || `<tr><td colspan="${columns.length+2}">No data rows to preview.</td></tr>`;
    return warnings;
}
function update() {
    const values = Object.values(selected).filter(v => v !== '');
    const duplicates = values.filter((v,i) => values.indexOf(v)!==i);
    fields.forEach(f => {
        const select = $('select-'+f.key);
        select.value = selected[f.key];
        Array.from(select.options).forEach(option => { option.disabled = option.value !== '' && option.value !== selected[f.key] && values.includes(option.value); });
        const mapped = selected[f.key] !== '';
        $('target-'+f.key).classList.toggle('has-mapping',mapped);
        const state = $('schema-'+f.key);
        state.classList.toggle('mapped',mapped);
        state.lastElementChild.textContent = mapped ? `← ${header(Number(selected[f.key]))}` : (f.required ? 'Required · not mapped' : 'Not mapped · saves NULL');
        const sample = mapped ? preview.map(row => row[Number(selected[f.key])]).find(v => v != null && String(v).trim() !== '') : null;
        $('sample-'+f.key).innerHTML = `Sample: <strong>${escape(sample ?? '—')}</strong>`;
        $('error-'+f.key).textContent = duplicates.includes(selected[f.key]) ? 'This source column is already mapped to another field.' : '';
    });
    const category = $('bm-category');
    $('bm-schema-category').textContent = category.value ? `${category.selectedOptions[0].textContent} (#${category.value})` : 'Select category';
    $('bm-progress-label').textContent = `${values.length} of 3 fields mapped`;
    $('bm-progress-bar').style.width = `${values.length/3*100}%`;
    renderSources();
    const warnings = renderPreview();
    let message;
    if (!category.value) message = '<strong>Choose an import category.</strong> Your selected category will be submitted with the mapping.';
    else if (selected.website_url === '') message = '<strong>Map Website URL to continue.</strong> DA and PA can be left unmapped.';
    else if (duplicates.length) message = '<strong>Resolve duplicate mappings.</strong> Each destination needs a different source column.';
    else message = `<strong>Mapping ready.</strong> ${warnings ? `${warnings} of ${preview.length} sample rows need review; invalid or duplicate rows are skipped by the server.` : 'Sample values look valid. Database duplicates are checked on import.'}`;
    $('bm-health').innerHTML = message;
    $('bm-import').disabled = busy || !category.value || selected.website_url === '' || duplicates.length > 0;
}
$('bm-targets').addEventListener('change', e => { const target=e.target.closest('.bm-target'); if(target && e.target.tagName==='SELECT'){selected[target.dataset.key]=e.target.value;update();} });
$('bm-targets').addEventListener('click', e => { const button=e.target.closest('[data-clear]'); if(button){selected[button.dataset.clear]='';update();} });
$('bm-category').addEventListener('change',update);
$('bm-search').addEventListener('input',renderSources);
$('bm-auto').addEventListener('click',() => {autoMap();update();});
$('bm-reset').addEventListener('click',() => {fields.forEach(f => selected[f.key]='');update();});
$('bm-sources').addEventListener('dragstart',e => {const chip=e.target.closest('[data-column]');if(chip){e.dataTransfer.setData('text/plain',chip.dataset.column);e.dataTransfer.effectAllowed='move';}});
$('bm-targets').addEventListener('dragover',e => {const target=e.target.closest('.bm-target');if(target){e.preventDefault();target.classList.add('drag-over');}});
$('bm-targets').addEventListener('dragleave',e => {const target=e.target.closest('.bm-target');if(target && !target.contains(e.relatedTarget))target.classList.remove('drag-over');});
$('bm-targets').addEventListener('drop',e => {const target=e.target.closest('.bm-target');if(!target)return;e.preventDefault();target.classList.remove('drag-over');const column=e.dataTransfer.getData('text/plain');if(!/^\d+$/.test(column) || Number(column)>=headers.length)return;fields.forEach(f => {if(selected[f.key]===column)selected[f.key]='';});selected[target.dataset.key]=column;update();});
function setMode(next){mode=next;['raw','mapped'].forEach(m=>{$('bm-tab-'+m).classList.toggle('active',m===mode);$('bm-tab-'+m).setAttribute('aria-pressed',String(m===mode));});renderPreview();}
$('bm-tab-raw').addEventListener('click',()=>setMode('raw'));
$('bm-tab-mapped').addEventListener('click',()=>setMode('mapped'));
$('bm-form').addEventListener('submit',e => {
    if($('bm-import').disabled){e.preventDefault();return;}
    busy=true;$('bm-import').disabled=true;$('bm-import').textContent='Importing…';
});
window.addEventListener('pageshow',()=>{busy=false;$('bm-import').textContent='Import backlinks →';update();});
if(!hasOldMapping && !Object.values(selected).some(v => v!==''))autoMap();
update();
})();
</script>
@endsection
