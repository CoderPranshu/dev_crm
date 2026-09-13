@extends('index')

@section('title', 'Create Detailed Quotation')

@push('css')
<style>
    :root {
        --dq-blue: #1496d4;
        --dq-blue-dark: #087fba;
        --dq-blue-soft: #eaf7fd;
        --dq-blue-border: #bfe7f7;
        --dq-red: #f12617;
        --dq-red-dark: #d81b0e;
        --dq-red-soft: #fff0ee;
        --dq-red-border: #ffd2cd;
        --dq-text: #121820;
        --dq-muted: #65727c;
        --dq-border: #e3e9ed;
        --dq-bg: #f5f8fa;
        --dq-shadow: 0 10px 30px rgba(20, 150, 212, .07);
    }

    .dq-page {
        min-height: 100vh;
        padding: 24px;
        background: var(--dq-bg);
    }

    .dq-shell {
        max-width: 1200px;
        margin: 0 auto;
    }

    .dq-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 16px;
        color: var(--dq-muted);
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .dq-back:hover { color: var(--dq-blue); }

    .dq-header {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        overflow: hidden;
        margin-bottom: 22px;
        padding: 24px;
        border: 1px solid var(--dq-blue-border);
        border-radius: 18px;
        background: linear-gradient(120deg, #fff 0%, #f4fbfe 55%, #eef9fd 100%);
        box-shadow: var(--dq-shadow);
    }

    .dq-header::after {
        position: absolute;
        top: -100px;
        right: -70px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(241, 38, 23, .06);
        content: '';
    }

    .dq-header-left {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .dq-header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        flex-shrink: 0;
        border-bottom: 3px solid var(--dq-red);
        border-radius: 15px;
        background: linear-gradient(135deg, var(--dq-blue), var(--dq-blue-dark));
        box-shadow: 0 8px 18px rgba(20, 150, 212, .20);
        color: #fff;
        font-size: 22px;
    }

    .dq-header h1 {
        margin: 0;
        color: var(--dq-text);
        font-size: 25px;
        font-weight: 800;
    }

    .dq-header p {
        margin: 5px 0 0;
        color: var(--dq-muted);
        font-size: 13px;
    }

    .dq-card {
        overflow: hidden;
        border: 1px solid var(--dq-border);
        border-radius: 18px;
        background: #fff;
        box-shadow: var(--dq-shadow);
    }

    .dq-tabs {
        position: sticky;
        top: 0;
        z-index: 20;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 18px;
        padding: 10px;
        border: 1px solid var(--dq-border);
        border-radius: 16px;
        background: rgba(255, 255, 255, .96);
        box-shadow: var(--dq-shadow);
        backdrop-filter: blur(8px);
    }

    .dq-tab {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 50px;
        border: 1px solid var(--dq-border);
        border-radius: 11px;
        background: #fff;
        color: var(--dq-muted);
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
    }

    .dq-tab.active {
        border-color: var(--dq-blue);
        background: linear-gradient(135deg, var(--dq-blue), var(--dq-blue-dark));
        color: #fff;
    }

    .dq-tab[data-type="uploaded"].active {
        border-color: var(--dq-red);
        background: linear-gradient(135deg, var(--dq-red), var(--dq-red-dark));
    }

    .dq-source-panel { display: none; }
    .dq-source-panel.active { display: block; }

    .dq-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 20px 23px;
        border-bottom: 1px solid var(--dq-border);
    }

    .dq-card-head-left {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .dq-card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--dq-blue-soft);
        color: var(--dq-blue);
        font-size: 16px;
    }

    .dq-card-head h3 {
        margin: 0;
        color: var(--dq-text);
        font-size: 16px;
        font-weight: 800;
    }

    .dq-card-head p {
        margin: 3px 0 0;
        color: var(--dq-muted);
        font-size: 12px;
    }

    .dq-card-body { padding: 24px; }

    .dq-section { margin-bottom: 28px; }
    .dq-section:last-child { margin-bottom: 0; }

    .dq-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        color: var(--dq-text);
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .35px;
        text-transform: uppercase;
    }

    .dq-section-title i { color: var(--dq-blue); }

    .dq-section-line {
        height: 1px;
        flex: 1;
        margin-left: 8px;
        background: var(--dq-border);
    }

    .dq-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .dq-field.full { grid-column: 1 / -1; }

    .dq-label {
        display: block;
        margin-bottom: 7px;
        color: var(--dq-text);
        font-size: 12px;
        font-weight: 800;
    }

    .dq-required { color: var(--dq-red); }

    .dq-input,
    .dq-select,
    .dq-textarea {
        width: 100%;
        border: 1px solid var(--dq-border);
        border-radius: 10px;
        outline: none;
        background: #fff;
        color: var(--dq-text);
        font-size: 13px;
        transition: .2s ease;
    }

    .dq-input,
    .dq-select {
        height: 45px;
        padding: 0 12px;
    }

    .dq-textarea {
        min-height: 280px;
        padding: 12px;
        resize: vertical;
    }

    .dq-input:focus,
    .dq-select:focus,
    .dq-textarea:focus {
        border-color: var(--dq-blue);
        box-shadow: 0 0 0 3px rgba(20, 150, 212, .10);
    }

    .dq-select:disabled {
        background: #f5f7f9;
        color: #9aa5ad;
        cursor: not-allowed;
    }

    .dq-help {
        margin-top: 5px;
        color: var(--dq-muted);
        font-size: 11px;
        font-weight: 400;
    }

    .dq-error {
        margin-top: 5px;
        color: var(--dq-red);
        font-size: 11px;
        font-weight: 600;
    }

    .dq-price-panel {
        padding: 18px;
        border: 1px solid var(--dq-blue-border);
        border-radius: 14px;
        background: linear-gradient(135deg, #f8fcfe, #fff);
    }

    .dq-upload-or {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 25px 0;
        color: var(--dq-muted);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .dq-upload-or::before,
    .dq-upload-or::after {
        height: 1px;
        flex: 1;
        background: var(--dq-border);
        content: '';
    }

    .dq-dropzone {
        display: block;
        padding: 38px 20px;
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        background: #fbfdff;
        text-align: center;
        cursor: pointer;
        transition: .2s ease;
    }

    .dq-dropzone:hover,
    .dq-dropzone.dragover {
        border-color: var(--dq-red);
        background: var(--dq-red-soft);
    }

    .dq-drop-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        margin: 0 auto 12px;
        border: 1px solid var(--dq-red-border);
        border-radius: 15px;
        background: var(--dq-red-soft);
        color: var(--dq-red);
        font-size: 27px;
    }

    .dq-dropzone strong {
        display: block;
        margin-bottom: 5px;
        color: var(--dq-text);
        font-size: 14px;
    }

    .dq-dropzone small {
        color: var(--dq-muted);
        font-size: 12px;
    }

    .dq-file-input { display: none; }

    .dq-file-preview {
        display: none;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
        padding: 13px;
        border: 1px solid var(--dq-red-border);
        border-radius: 10px;
        background: #fffafa;
    }

    .dq-file-preview.active { display: flex; }
    .dq-file-icon { color: var(--dq-red); font-size: 23px; }
    .dq-file-info { min-width: 0; flex: 1; }

    .dq-file-name {
        overflow: hidden;
        color: var(--dq-text);
        font-size: 12px;
        font-weight: 800;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dq-file-size {
        margin-top: 2px;
        color: var(--dq-muted);
        font-size: 11px;
    }

    .dq-remove-file {
        border: 0;
        background: transparent;
        color: var(--dq-red);
        font-size: 18px;
        cursor: pointer;
    }

    .dq-card-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 23px;
        border-top: 1px solid var(--dq-border);
        background: #fbfcfe;
    }

    .dq-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 42px;
        padding: 0 17px;
        border: 1px solid var(--dq-border);
        border-radius: 9px;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
    }

    .dq-btn-secondary { background: #fff; color: #4b5563; }

    .dq-btn-primary {
        border-color: var(--dq-blue);
        background: linear-gradient(135deg, var(--dq-blue), var(--dq-blue-dark));
        box-shadow: 0 6px 15px rgba(20, 150, 212, .18);
        color: #fff;
    }

    .dq-btn-primary:hover { background: var(--dq-blue-dark); color: #fff; }

    .dq-alert {
        margin-bottom: 18px;
        padding: 12px 14px;
        border: 1px solid #fecdd3;
        border-radius: 10px;
        background: #fff1f2;
        color: #b4232d;
        font-size: 12px;
        font-weight: 600;
    }

    .tox-tinymce { border-color: var(--dq-border) !important; border-radius: 10px !important; }

    @media (max-width: 767.98px) {
        .dq-page { padding: 14px; }
        .dq-header { padding: 18px; }
        .dq-header-icon { width: 48px; height: 48px; }
        .dq-header h1 { font-size: 21px; }
        .dq-grid { grid-template-columns: 1fr; }
        .dq-card-body { padding: 17px; }
        .dq-card-footer { flex-direction: column-reverse; }
        .dq-btn { width: 100%; }
    }
</style>
@endpush

@section('content')
<div class="dq-page">
    <div class="dq-shell">
        <a href="{{ route('admin.detailed-quotations.index') }}" class="dq-back">
            <i class="bi bi-arrow-left"></i>
            Back to Quotations
        </a>

        <div class="dq-header">
            <div class="dq-header-left">
                <div class="dq-header-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <div>
                    <h1>Create Detailed Quotation</h1>
                    <p>Upload an existing PDF or enter content to generate a proposal PDF.</p>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="dq-alert">
                <i class="bi bi-exclamation-circle me-1"></i>
                Please review the highlighted fields and try again.
            </div>
        @endif

        <form
            action="{{ route('admin.detailed-quotations.store') }}"
            method="POST"
            enctype="multipart/form-data"
            id="detailedQuotationForm"
        >
            @csrf

            <input
                type="hidden"
                name="quotation_type"
                id="quotationType"
                value="{{ old('quotation_type', 'manual') }}"
            >

            <div class="dq-tabs" role="tablist" aria-label="Quotation creation type">
                <button type="button" class="dq-tab" id="manualTab" data-type="manual" role="tab">
                    <i class="bi bi-pencil-square"></i>
                    1. Manual
                </button>

                <button type="button" class="dq-tab" id="uploadTab" data-type="uploaded" role="tab">
                    <i class="bi bi-cloud-arrow-up"></i>
                    2. Upload PDF
                </button>
            </div>

            <div class="dq-card">
                <div class="dq-card-head">
                    <div class="dq-card-head-left">
                        <div class="dq-card-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>

                        <div>
                            <h3>Create Proposal</h3>
                            <p>Complete the details, then use the Manual or Upload PDF tab.</p>
                        </div>
                    </div>
                </div>

                <div class="dq-card-body">
                    <div class="dq-section">
                        <div class="dq-section-title">
                            <i class="bi bi-file-text"></i>
                            Proposal Information
                            <span class="dq-section-line"></span>
                        </div>

                        <div class="dq-grid">
                            <div class="dq-field full">
                                <label for="proposalName" class="dq-label">
                                    Proposal Name <span class="dq-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="proposalName"
                                    value="{{ old('name') }}"
                                    class="dq-input"
                                    placeholder="e.g. Website Development Proposal"
                                    maxlength="255"
                                    required
                                >

                                @error('name')
                                    <div class="dq-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="dq-section">
                        <div class="dq-section-title">
                            <i class="bi bi-diagram-3"></i>
                            Category and Service
                            <span class="dq-section-line"></span>
                        </div>

                        <div class="dq-grid">
                            <div class="dq-field">
                                <label for="quotationCategory" class="dq-label">
                                    Category <span class="dq-required">*</span>
                                </label>

                                <select
                                    name="category_id"
                                    id="quotationCategory"
                                    class="dq-select"
                                    required
                                >
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="dq-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="dq-field">
                                <label for="quotationService" class="dq-label">
                                    Quotation Service <span class="dq-required">*</span>
                                </label>

                                <select
                                    name="service_id"
                                    id="quotationService"
                                    class="dq-select"
                                    required
                                    disabled
                                >
                                    <option value="">Select Category First</option>
                                </select>

                                <div class="dq-help">Only services from the selected category will appear.</div>

                                @error('service_id')
                                    <div class="dq-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="dq-section">
                        <div class="dq-section-title">
                            <i class="bi bi-currency-rupee"></i>
                            Proposal Price
                            <span class="dq-section-line"></span>
                        </div>

                        <div class="dq-price-panel">
                            <div class="dq-grid">
                                <div class="dq-field full">
                                    <label for="quotationPrice" class="dq-label">
                                        Price <span class="dq-required">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        name="price"
                                        id="quotationPrice"
                                        value="{{ old('price') }}"
                                        class="dq-input"
                                        placeholder="Enter proposal price"
                                        step="0.01"
                                        min="0"
                                        required
                                    >

                                    @error('price')
                                        <div class="dq-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dq-section dq-source-panel" id="manualPanel">
                        <div class="dq-section-title">
                            <i class="bi bi-pencil-square"></i>
                            Manual Proposal Content
                            <span class="dq-section-line"></span>
                        </div>

                        <div class="dq-field full">
                            <label for="proposalContent" class="dq-label">
                                Proposal Content <span class="dq-required">*</span>
                            </label>

                            <textarea
                                name="content"
                                id="proposalContent"
                                class="dq-textarea"
                                rows="18"
                                placeholder="Enter complete proposal content here..."
                            >{{ old('content') }}</textarea>

                            <div class="dq-help">
                                This editor content will be converted into a PDF automatically.
                            </div>

                            @error('content')
                                <div class="dq-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="dq-section dq-source-panel" id="uploadPanel">
                        <div class="dq-section-title">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Upload Existing PDF
                            <span class="dq-section-line"></span>
                        </div>

                        <div class="dq-field full">
                            <label for="pdf" class="dq-label">
                                Proposal PDF <span class="dq-required">*</span>
                            </label>

                            <label for="pdf" class="dq-dropzone" id="dqDropzone">
                                <div class="dq-drop-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                                <strong>Click to select PDF or drag and drop here</strong>
                                <small>PDF only • Maximum 10 MB</small>
                            </label>

                            <input type="file" name="pdf" id="pdf" class="dq-file-input" accept="application/pdf,.pdf">

                            <div class="dq-file-preview" id="dqFilePreview">
                                <div class="dq-file-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                                <div class="dq-file-info">
                                    <div class="dq-file-name" id="dqFileName"></div>
                                    <div class="dq-file-size" id="dqFileSize"></div>
                                </div>
                                <button type="button" class="dq-remove-file" id="dqRemoveFile" aria-label="Remove selected PDF">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            @error('pdf')
                                <div class="dq-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="dq-card-footer">
                    <a
                        href="{{ route('admin.detailed-quotations.index') }}"
                        class="dq-btn dq-btn-secondary"
                    >
                        Cancel
                    </a>

                    <button type="submit" class="dq-btn dq-btn-primary" id="saveProposalButton">
                        <i class="bi bi-check-circle"></i>
                        Save Proposal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
{{-- Free GPL build: no Tiny Cloud account or API key required. --}}
<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryServices = @json(
        $categories->mapWithKeys(function ($category) {
            return [
                $category->id => $category->services->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'name' => $service->name,
                    ];
                })->values()
            ];
        })
    );

    const categorySelect = document.getElementById('quotationCategory');
    const serviceSelect = document.getElementById('quotationService');
    const oldServiceId = @json(old('service_id'));

    function loadServices(categoryId, selectedServiceId) {
        const services = categoryServices[categoryId] || [];
        serviceSelect.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = !categoryId
            ? 'Select Category First'
            : (services.length ? 'Select Quotation Service' : 'No Quotation Services Available');
        serviceSelect.appendChild(defaultOption);

        services.forEach(function (service) {
            const option = document.createElement('option');
            option.value = service.id;
            option.textContent = service.name;
            option.selected = String(service.id) === String(selectedServiceId || '');
            serviceSelect.appendChild(option);
        });

        serviceSelect.disabled = !categoryId || services.length === 0;
    }

    categorySelect.addEventListener('change', function () {
        loadServices(this.value, null);
    });

    if (categorySelect.value) {
        loadServices(categorySelect.value, oldServiceId);
    }

    const pdfInput = document.getElementById('pdf');
    const dropzone = document.getElementById('dqDropzone');
    const filePreview = document.getElementById('dqFilePreview');
    const fileName = document.getElementById('dqFileName');
    const fileSize = document.getElementById('dqFileSize');
    const removeFile = document.getElementById('dqRemoveFile');
    const typeInput = document.getElementById('quotationType');
    const manualTab = document.getElementById('manualTab');
    const uploadTab = document.getElementById('uploadTab');
    const manualPanel = document.getElementById('manualPanel');
    const uploadPanel = document.getElementById('uploadPanel');
    const contentInput = document.getElementById('proposalContent');
    const submitButton = document.getElementById('saveProposalButton');

    function setMode(type) {
        const isUpload = type === 'uploaded';

        typeInput.value = isUpload ? 'uploaded' : 'manual';
        manualTab.classList.toggle('active', !isUpload);
        uploadTab.classList.toggle('active', isUpload);
        manualPanel.classList.toggle('active', !isUpload);
        uploadPanel.classList.toggle('active', isUpload);
        manualTab.setAttribute('aria-selected', String(!isUpload));
        uploadTab.setAttribute('aria-selected', String(isUpload));

        contentInput.disabled = isUpload;
        // Do not use native required on TinyMCE's hidden textarea.
        // Manual editor content is checked below before submit and on the server.
        contentInput.required = false;
        pdfInput.disabled = !isUpload;
        pdfInput.required = isUpload;

        submitButton.classList.toggle('dq-btn-primary', !isUpload);
        submitButton.classList.toggle('dq-btn-upload', isUpload);
        submitButton.innerHTML = isUpload
            ? '<i class="bi bi-cloud-arrow-up"></i> Upload Proposal PDF'
            : '<i class="bi bi-file-earmark-pdf"></i> Generate Proposal PDF';
    }

    manualTab.addEventListener('click', function () { setMode('manual'); });
    uploadTab.addEventListener('click', function () { setMode('uploaded'); });

    function clearPdf() {
        pdfInput.value = '';
        filePreview.classList.remove('active');
        fileName.textContent = '';
        fileSize.textContent = '';
    }

    function formatBytes(bytes) {
        if (!bytes) return '0 Bytes';

        const units = ['Bytes', 'KB', 'MB', 'GB'];
        const unitIndex = Math.floor(Math.log(bytes) / Math.log(1024));
        const size = bytes / Math.pow(1024, unitIndex);

        return parseFloat(size.toFixed(2)) + ' ' + units[unitIndex];
    }

    function showPdf(file) {
        if (!file) {
            clearPdf();
            return false;
        }

        const isPdf = file.type === 'application/pdf'
            || file.name.toLowerCase().endsWith('.pdf');

        if (!isPdf) {
            alert('Please select a PDF file only.');
            clearPdf();
            return false;
        }

        if (file.size > (10 * 1024 * 1024)) {
            alert('PDF must not exceed 10 MB.');
            clearPdf();
            return false;
        }

        fileName.textContent = file.name;
        fileSize.textContent = formatBytes(file.size);
        filePreview.classList.add('active');
        return true;
    }

    pdfInput.addEventListener('change', function () {
        showPdf(this.files[0]);
    });

    dropzone.addEventListener('dragover', function (event) {
        event.preventDefault();
        this.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', function () {
        this.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', function (event) {
        event.preventDefault();
        this.classList.remove('dragover');

        if (!event.dataTransfer.files.length) return;

        const droppedFile = event.dataTransfer.files[0];

        if (!showPdf(droppedFile)) return;

        const transfer = new DataTransfer();
        transfer.items.add(droppedFile);
        pdfInput.files = transfer.files;
    });

    removeFile.addEventListener('click', clearPdf);

    if (window.tinymce) {
        tinymce.init({
            selector: '#proposalContent',
            license_key: 'gpl',
            base_url: 'https://cdn.jsdelivr.net/npm/tinymce@7',
            suffix: '.min',
            height: 430,
            menubar: false,
            plugins: 'lists link table code fullscreen',
            toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | alignleft aligncenter alignright | link table | removeformat | code fullscreen',
            branding: false,
            promotion: false
        });
    }

    document.getElementById('detailedQuotationForm').addEventListener('submit', function (event) {
        if (window.tinymce) {
            tinymce.triggerSave();
        }

        if (typeInput.value === 'uploaded' && pdfInput.files.length === 0) {
            event.preventDefault();
            alert('Please upload a PDF file.');
            return;
        }

        if (typeInput.value === 'manual') {
            const temporary = document.createElement('div');
            temporary.innerHTML = contentInput.value || '';
            const hasContent = temporary.textContent.replace(/\u00a0/g, ' ').trim() !== '';

            if (!hasContent) {
                event.preventDefault();
                alert('Please add proposal content in the editor.');

                if (window.tinymce && tinymce.get('proposalContent')) {
                    tinymce.get('proposalContent').focus();
                } else {
                    contentInput.focus();
                }
            }
        }
    });

    setMode(typeInput.value === 'uploaded' ? 'uploaded' : 'manual');
});
</script>
@endpush




