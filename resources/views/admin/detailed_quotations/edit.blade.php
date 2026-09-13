@extends('index')

@section('title', 'Edit Detailed Quotation')

@push('css')
<style>
    :root {
        --dq-blue: #0b74c4;
        --dq-blue-dark: #075a99;
        --dq-blue-soft: #eef7ff;
        --dq-text: #172033;
        --dq-muted: #6b7280;
        --dq-border: #e5e7eb;
        --dq-bg: #f7f9fc;
        --dq-white: #ffffff;
        --dq-red: #d73a49;
    }

    .dq-form-page {
        min-height: 100vh;
        padding: 24px;
        background: var(--dq-bg);
    }

    .dq-form-shell {
        max-width: 850px;
        margin: 0 auto;
    }

    .dq-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 16px;
        color: var(--dq-muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .dq-back:hover {
        color: var(--dq-blue);
    }

    .dq-form-card {
        background: #fff;
        border: 1px solid var(--dq-border);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .06);
    }

    .dq-form-head {
        padding: 24px 26px;
        border-bottom: 1px solid var(--dq-border);
    }

    .dq-form-head h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        color: var(--dq-text);
    }

    .dq-form-head p {
        margin: 6px 0 0;
        color: var(--dq-muted);
        font-size: 14px;
    }

    .dq-form-body {
        padding: 26px;
    }

    .dq-field {
        margin-bottom: 22px;
    }

    .dq-label {
        display: block;
        margin-bottom: 8px;
        color: var(--dq-text);
        font-size: 13px;
        font-weight: 800;
    }

    .dq-required {
        color: var(--dq-red);
    }

    .dq-input {
        width: 100%;
        height: 46px;
        padding: 0 13px;
        border: 1px solid var(--dq-border);
        border-radius: 10px;
        outline: none;
        font-size: 14px;
        color: var(--dq-text);
        background: #fff;
        transition: .2s ease;
    }

    .dq-input:focus {
        border-color: var(--dq-blue);
        box-shadow: 0 0 0 3px rgba(11,116,196,.09);
    }

    .dq-current-pdf {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #dce6ef;
        background: #f8fbfe;
        margin-bottom: 14px;
    }

    .dq-current-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #fff1f2;
        color: #c52233;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .dq-current-meta {
        flex: 1;
        min-width: 0;
    }

    .dq-current-meta strong {
        display: block;
        color: var(--dq-text);
        font-size: 13px;
        margin-bottom: 3px;
    }

    .dq-current-meta small {
        color: var(--dq-muted);
    }

    .dq-current-view {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 10px;
        border-radius: 8px;
        text-decoration: none;
        background: var(--dq-blue-soft);
        color: var(--dq-blue-dark);
        font-size: 12px;
        font-weight: 800;
    }

    .dq-dropzone {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        background: #fbfdff;
        transition: .2s ease;
    }

    .dq-dropzone:hover,
    .dq-dropzone.dragover {
        border-color: var(--dq-blue);
        background: var(--dq-blue-soft);
    }

    .dq-drop-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        background: #fff1f2;
        color: #c52233;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 11px;
        font-size: 27px;
    }

    .dq-dropzone strong {
        display: block;
        color: var(--dq-text);
        font-size: 14px;
        margin-bottom: 5px;
    }

    .dq-dropzone small {
        color: var(--dq-muted);
    }

    .dq-file-input {
        display: none;
    }

    .dq-file-preview {
        display: none;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
        padding: 12px 14px;
        border: 1px solid #dbe6ef;
        border-radius: 10px;
        background: #f8fbfe;
    }

    .dq-file-preview.active {
        display: flex;
    }

    .dq-file-icon {
        color: #c52233;
        font-size: 24px;
    }

    .dq-file-meta {
        flex: 1;
        min-width: 0;
    }

    .dq-file-name {
        font-weight: 800;
        font-size: 13px;
        color: var(--dq-text);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dq-file-size {
        font-size: 12px;
        color: var(--dq-muted);
    }

    .dq-remove-file {
        border: 0;
        background: transparent;
        color: var(--dq-red);
        font-size: 19px;
    }

    .dq-error {
        color: var(--dq-red);
        font-size: 12px;
        margin-top: 6px;
    }

    .dq-form-footer {
        padding: 18px 26px;
        border-top: 1px solid var(--dq-border);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #fbfcfe;
    }

    .dq-btn {
        min-height: 42px;
        padding: 0 17px;
        border-radius: 9px;
        border: 1px solid var(--dq-border);
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
    }

    .dq-btn.secondary {
        background: #fff;
        color: #4b5563;
    }

    .dq-btn.primary {
        background: var(--dq-blue);
        border-color: var(--dq-blue);
        color: #fff;
    }

    .dq-btn.primary:hover {
        background: var(--dq-blue-dark);
    }

    @media(max-width:767.98px) {

        .dq-form-page {
            padding: 14px;
        }

        .dq-form-head,
        .dq-form-body,
        .dq-form-footer {
            padding-left: 17px;
            padding-right: 17px;
        }

        .dq-current-pdf {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .dq-current-view {
            width: 100%;
            justify-content: center;
        }

        .dq-form-footer {
            flex-direction: column-reverse;
        }

        .dq-btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="dq-form-page">

    <div class="dq-form-shell">

        <a
            href="{{ route('admin.detailed-quotations.index') }}"
            class="dq-back"
        >
            <i class="bi bi-arrow-left"></i>
            Back to Quotations
        </a>


        <form
            action="{{ route('admin.detailed-quotations.update', $detailedQuotation->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="dq-form-card">

                <div class="dq-form-head">

                    <h1>Edit Detailed Quotation</h1>

                    <p>
                        Update the quotation name or replace its PDF.
                    </p>

                </div>


                <div class="dq-form-body">

                    <div class="dq-field">

                        <label class="dq-label">
                            Quotation Name
                            <span class="dq-required">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="dq-input"
                            value="{{ old('name', $detailedQuotation->name) }}"
                            required
                        >

                        @error('name')
                            <div class="dq-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="dq-field">

                        <label class="dq-label">
                            Current PDF
                        </label>


                        <div class="dq-current-pdf">

                            <div class="dq-current-icon">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </div>


                            <div class="dq-current-meta">

                                <strong>
                                    {{ $detailedQuotation->name }}.pdf
                                </strong>

                                <small>
                                    Current uploaded quotation file
                                </small>

                            </div>


                            <a
                                href="{{ route('admin.detailed-quotations.show', $detailedQuotation->id) }}"
                                target="_blank"
                                class="dq-current-view"
                            >
                                <i class="bi bi-eye"></i>
                                View PDF
                            </a>

                        </div>

                    </div>


                    <div class="dq-field">

                        <label class="dq-label">
                            Replace PDF
                        </label>


                        <label
                            for="pdf"
                            class="dq-dropzone"
                            id="dqDropzone"
                        >

                            <div class="dq-drop-icon">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>

                            <strong>
                                Select a new PDF only if you want to replace the current file
                            </strong>

                            <small>
                                Optional • PDF only • Maximum 10 MB
                            </small>

                        </label>


                        <input
                            type="file"
                            name="pdf"
                            id="pdf"
                            class="dq-file-input"
                            accept="application/pdf,.pdf"
                        >


                        <div
                            class="dq-file-preview"
                            id="dqFilePreview"
                        >

                            <div class="dq-file-icon">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </div>


                            <div class="dq-file-meta">

                                <div
                                    class="dq-file-name"
                                    id="dqFileName"
                                ></div>

                                <div
                                    class="dq-file-size"
                                    id="dqFileSize"
                                ></div>

                            </div>


                            <button
                                type="button"
                                class="dq-remove-file"
                                id="dqRemoveFile"
                            >
                                <i class="bi bi-x-lg"></i>
                            </button>

                        </div>


                        @error('pdf')
                            <div class="dq-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                <div class="dq-form-footer">

                    <a
                        href="{{ route('admin.detailed-quotations.index') }}"
                        class="dq-btn secondary"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="dq-btn primary"
                    >
                        <i class="bi bi-check2-circle"></i>
                        Update Quotation
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection


@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('pdf');
    const dropzone = document.getElementById('dqDropzone');
    const preview = document.getElementById('dqFilePreview');
    const fileName = document.getElementById('dqFileName');
    const fileSize = document.getElementById('dqFileSize');
    const removeButton = document.getElementById('dqRemoveFile');

    function showFile(file) {

        if (!file) {
            clearFile();
            return;
        }

        if (
            file.type !== 'application/pdf' &&
            !file.name.toLowerCase().endsWith('.pdf')
        ) {
            alert('Please select a PDF file only.');

            input.value = '';

            clearFile();

            return;
        }

        const maxSize = 10 * 1024 * 1024;

        if (file.size > maxSize) {

            alert('PDF must not exceed 10 MB.');

            input.value = '';

            clearFile();

            return;
        }

        fileName.textContent = file.name;

        fileSize.textContent =
            formatBytes(file.size);

        preview.classList.add('active');
    }


    function clearFile() {

        input.value = '';

        preview.classList.remove('active');

        fileName.textContent = '';

        fileSize.textContent = '';
    }


    function formatBytes(bytes) {

        if (bytes === 0) {
            return '0 Bytes';
        }

        const k = 1024;

        const sizes = [
            'Bytes',
            'KB',
            'MB',
            'GB'
        ];

        const i = Math.floor(
            Math.log(bytes) / Math.log(k)
        );

        return (
            parseFloat(
                (bytes / Math.pow(k, i)).toFixed(2)
            ) +
            ' ' +
            sizes[i]
        );
    }


    input.addEventListener(
        'change',
        function () {
            showFile(this.files[0]);
        }
    );


    dropzone.addEventListener(
        'dragover',
        function (e) {

            e.preventDefault();

            this.classList.add('dragover');
        }
    );


    dropzone.addEventListener(
        'dragleave',
        function () {

            this.classList.remove('dragover');
        }
    );


    dropzone.addEventListener(
        'drop',
        function (e) {

            e.preventDefault();

            this.classList.remove('dragover');

            const files =
                e.dataTransfer.files;

            if (!files.length) {
                return;
            }

            const transfer =
                new DataTransfer();

            transfer.items.add(
                files[0]
            );

            input.files =
                transfer.files;

            showFile(
                files[0]
            );
        }
    );


    removeButton.addEventListener(
        'click',
        function () {
            clearFile();
        }
    );

});
</script>
@endpush