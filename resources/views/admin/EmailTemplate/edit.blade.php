@extends('index')
@push('title', get_phrase('Edit Email Template'))
@push('meta')
@endpush

@push('css')
    <style>
        :root {
            --gjs-left-width: 25% !important;
        }

        .gjs-pn-views-container {
            height: 100%;
            padding: 42px 0 0;
            right: 0;
            width: 25%;
            overflow: auto;
            box-shadow: 0 0 5px var(--gjs-main-dark-color);
        }

        .gjs-pn-panel {
            height: 35px;
        }
    </style>
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>Edit Email Template</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.emailtemplate.index') }}">{{ get_phrase('Email Templates') }}</a></li>
                    <li><a href="#">Edit Email Templates</a></li>
                </ul>
            </div>

            <div class="export-btn-area">
                <a href="{{ route('admin.emailtemplate.index') }}" class="export_btn">
                    <i class="bi bi-arrow-left"></i>
                    <span class="d-none d-sm-inline-block">Back</span>
                </a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">Edit Template</p>

                <form id="templateForm" action="{{ route('admin.emailtemplate.update', $template->id) }}" method="post">
                    @Csrf

                    <input type="hidden" name="body" id="template_body">

                    <div class="row">

                        <div class="col-md-12">
                            <label class="eForm-label">Title</label>
                            <input type="text" name="title" class="form-control eForm-control"
                                value="{{ $template->title }}" required>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label class="eForm-label">Subject</label>
                            <input type="text" name="subject" class="form-control eForm-control"
                                value="{{ $template->subject }}" required>
                        </div>

                    @php
                        $branches = App\Models\Branch::get();
                    @endphp
                    <div class="col-md-12 mt-2">
                        <label class="eForm-label">Branches</label>
                        @if(auth()->user()->hasRole('Admin'))
                            <select name="branch_id" class="form-control eForm-control" required>
                                <option value="">{{ get_phrase('Select Branch') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $template->branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->title }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                            <p class="eForm-control">{{ auth()->user()->branch->title }}</p>
                        @endif
                    </div>

                        <div class="col-md-12 mt-3">
                            <label class="eForm-label">Email Template Builder</label>

                            <!-- GrapesJS Container -->
                            <div id="gjs" style="border:1px solid #ddd; height:650px;"></div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <button type="button" onclick="saveTemplate()" class="btn-form my-2 w-100">
                                Update Template
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
    <link rel="stylesheet" href="https://unpkg.com/grapesjs-mjml/dist/grapesjs-mjml.css">

    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-mjml"></script>

    <script>
        // ------------------------------
        // INIT EDITOR
        // ------------------------------
        var editor = grapesjs.init({
            container: '#gjs',
            height: '600px',
            fromElement: false,
            storageManager: false,
            plugins: ['gjs-mjml'],
        });

        // LOAD EXISTING TEMPLATE BODY
        let existingHtml = `{!! $template->body !!}`;
        editor.setComponents(existingHtml);

        // ------------------------------
        // CUSTOM BLOCKS
        // ------------------------------
        const blockManager = editor.BlockManager;

        blockManager.add('custom-heading', {
            label: 'Heading',
            category: 'Custom',
            content: `
        <mj-section padding="10px 0">
            <mj-column>
                <mj-text font-size="28px" font-weight="700" align="center" padding="10px 0">
                    Your Heading Title
                </mj-text>
            </mj-column>
        </mj-section>
    `
        });

        blockManager.add('custom-paragraph', {
            label: 'Paragraph',
            category: 'Custom',
            content: `
        <mj-section padding="10px 0">
            <mj-column>
                <mj-text font-size="16px" line-height="1.6" color="#444">
                    This is a clean paragraph block. Click here to edit text.
                </mj-text>
            </mj-column>
        </mj-section>
    `
        });

        blockManager.add('custom-button', {
            label: 'Button',
            category: 'Custom',
            content: `
        <mj-section padding="20px 0">
            <mj-column>
                <mj-button background-color="#4a90e2"
                           color="#fff"
                           font-size="16px"
                           border-radius="6px"
                           padding="12px 25px"
                           align="center">
                    Click Here
                </mj-button>
            </mj-column>
        </mj-section>
    `
        });

        blockManager.add('custom-image', {
            label: 'Image',
            category: 'Custom',
            content: `
        <mj-section>
            <mj-column>
                <mj-image src="https://via.placeholder.com/600x250" alt="Image Block" />
            </mj-column>
        </mj-section>
    `
        });

        blockManager.add('two-column', {
            label: 'Two Column Layout',
            category: 'Custom',
            content: `
        <mj-section padding="10px 0">
            <mj-column width="50%">
                <mj-text font-size="16px" color="#444">Left column content</mj-text>
            </mj-column>
            <mj-column width="50%">
                <mj-text font-size="16px" color="#444">Right column content</mj-text>
            </mj-column>
        </mj-section>
    `
        });

        blockManager.add('footer-block', {
            label: 'Footer',
            category: 'Custom',
            content: `
        <mj-section background-color="#f1f1f1" padding="20px 0">
            <mj-column>
                <mj-text align="center" font-size="12px" color="#777">
                    © 2025 Your Company. All Rights Reserved.<br>
                    Unsubscribe | Privacy Policy
                </mj-text>
            </mj-column>
        </mj-section>
    `
        });

        // ------------------------------
        // SAVE TEMPLATE
        // ------------------------------
        function saveTemplate() {
            let htmlOutput = editor.getHtml();
            let cssOutput = editor.getCss();

            let finalOutput = htmlOutput + `<style>${cssOutput}</style>`;

            document.getElementById('template_body').value = finalOutput;

            document.getElementById('templateForm').submit();
        }
    </script>
@endpush
