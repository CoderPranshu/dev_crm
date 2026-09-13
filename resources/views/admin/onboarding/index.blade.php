@extends('index')
@push('title', get_phrase('Recreitment Stages'))
@push('meta')
@endpush
@push('css')
    <style>
        .ck-editor__editable,
        .ck-editor__editable_inline {
            min-height: 300px !important;
            /* Set your height */
        }
    </style>


    <style>
        .stage-column {
            width: 160px;
            min-width: 160px;
            max-width: 160px;
            white-space: nowrap;
        }

        .stage-column select {
            width: 100%;
        }


        /* Tabs */
        .nav-tabs .nav-link {
            border: none;
            background: #f8f9fa;
            color: #495057;
            margin-right: 6px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            background: #e9ecef;
        }

        .nav-tabs .nav-link.active {
            background: #0d6efd;
            color: white;
            box-shadow: 0 2px 6px rgba(13, 110, 253, 0.3);
        }

        /* Accordion */
        .accordion-button {
            background-color: #f8f9fa;
            color: #212529;
            transition: all 0.3s ease;
        }

        .accordion-button:hover {
            background-color: #e9ecef;
        }

        .accordion-button:not(.collapsed) {
            color: #0d6efd;
            background-color: #e7f1ff;
            box-shadow: none;
        }

        /* Accordion Body */
        .accordion-body {
            background-color: #ffffff;
            border-radius: 0 0 0.5rem 0.5rem;
        }

        /* Card-like spacing for tab content */
        .tab-pane {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Onboarding') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Onboarding') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/onboarding/add']) }}', '{{ get_phrase('Add new stage') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new stage') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">


            {{-- Tabs Content --}}
            <div class="tab-content mt-2" id="recruitmentTabsContent">

                @php
                    $stages = \App\Models\OnBoarding::orderBy('created_at', 'asc')->get();
                @endphp

                <div class="tab-pane fade show active p-3 rounded bg-white shadow-sm">

                    @if ($stages->count())
                        <div class="accordion" id="stagesAccordion">

                            @foreach ($stages as $index => $stage)
                                <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
                                    <h2 class="accordion-header" id="heading{{ $stage->id }}">
                                        <button
                                            class="accordion-button fw-semibold @if ($index > 0) collapsed @endif"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $stage->id }}"
                                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $stage->id }}">
                                            {{ $stage->title }}
                                        </button>
                                    </h2>

                                    <div id="collapse{{ $stage->id }}"
                                        class="accordion-collapse collapse @if ($index == 0) show @endif"
                                        aria-labelledby="heading{{ $stage->id }}" data-bs-parent="#stagesAccordion">

                                        <div class="accordion-body bg-light-subtle p-3">

                                            <div class="eSection-wrap">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <p class="column-title mb-0 fw-bold">{{ get_phrase('Stage') }}</p>

                                                        <div class="dropdown-center ps-3">
                                                            <button class="btn btn-sm btn-primary dropdown-toggle"
                                                                type="button" data-bs-toggle="dropdown">
                                                                Actions
                                                            </button>



                                                            <ul class="dropdown-menu shadow">
                                                                <li>
                                                                    <a class="dropdown-item send-mail-btn" href="#"
                                                                        data-stage="{{ $stage->id }}">
                                                                        <i class="fi-rr-paper-plane pe-1"></i>
                                                                        Send Mail to Selected
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('admin.onboarding.stage.export', $stage->id) }}"
                                                        class="export_btn_success btn-sm mb-2">
                                                        Export CSV
                                                    </a>
                                                    <div class="mb-3">
                                                        <input type="text" id="candidateSearch"
                                                            class="form-control eForm-control"
                                                            placeholder="{{ get_phrase('Search candidate by name, email, phone, source, country, type...') }}">
                                                    </div>
                                                </div>

                                                {{-- Candidates Table --}}
                                                <div class="table-responsive">
                                                    <table class="table eTable">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox"
                                                                        id="selectAll{{ $stage->id }}"></th>
                                                                <th>#</th>
                                                                <th>{{ get_phrase('Name') }}</th>
                                                                <th>{{ get_phrase('Email') }}</th>
                                                                <th>{{ get_phrase('Phone') }}</th>
                                                                <th>{{ get_phrase('Address') }}</th>
                                                                <th>{{ get_phrase('Source') }}</th>
                                                                <th>{{ get_phrase('Country') }}</th>
                                                                <th>{{ get_phrase('State') }}</th>
                                                                <th>{{ get_phrase('DOB') }}</th>
                                                                <th>{{ get_phrase('Resume') }}</th>
                                                                <th>{{ get_phrase('Recruitment') }}</th>
                                                                <th>{{ get_phrase('Short List') }}</th>
                                                                <th class="stage-column">{{ get_phrase('Stage') }}</th>
                                                                <th>{{ get_phrase('Candi Type') }}</th>
                                                                <th class="text-center">{{ get_phrase('Action') }}</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="candidateTableBody">
                                                            @forelse ($stage->candidates as $i => $candi)
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" class="candidate-checkbox"
                                                                            value="{{ $candi->id }}"
                                                                            data-email="{{ $candi->email }}">
                                                                    </td>

                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td class="c-name">{{ $candi->name }}</td>
                                                                    <td class="c-email">{{ $candi->email }}</td>
                                                                    <td class="c-phone">{{ $candi->phone }}</td>
                                                                    <td class="c-address">{{ $candi->address }}</td>
                                                                    <td class="c-source">{{ $candi->source }}</td>
                                                                    <td class="c-country">{{ $candi->country }}</td>
                                                                    <td class="c-state">{{ $candi->state }}</td>
                                                                    <td class="c-dob">{{ $candi->dob }}</td>

                                                                    <td class="c-resume">
                                                                        <a href="{{ asset('uploads/resume/' . $candi->resume) }}"
                                                                            target="_blank" class="text-info">
                                                                            Download Resume
                                                                        </a>
                                                                    </td>

                                                                    <td class="c-recruitment">
                                                                        {{ $candi->recruitment->title ?? '' }}</td>

                                                                    <td class="c-final">
                                                                        <input type="checkbox"
                                                                            class="candidate-final-checkbox"
                                                                            data-id="{{ $candi->id }}"
                                                                            {{ $candi->is_final == 'yes' ? 'checked' : '' }}>
                                                                    </td>

                                                                    <td class="stage-column c-stage">
                                                                        <select name="onboarding"
                                                                            class="form-control eForm-control candidate-stage"
                                                                            data-id="{{ $candi->id }}"
                                                                            data-url="{{ route('admin.onboarding.updateStage', $candi->id) }}">
                                                                            @foreach (\App\Models\OnBoarding::orderBy('created_at')->get() as $s)
                                                                                <option value="{{ $s->id }}"
                                                                                    @if ($candi->onboarding == $s->id) selected @endif>
                                                                                    {{ $s->title }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td class="c-type">
                                                                        <form
                                                                            action="{{ route('admin.candidate.updateTypeAndRedirect', $candi->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <select name="cand_type"
                                                                                class="form-control eForm-control"
                                                                                onchange="this.form.submit()" style="width:90px;">
                                                                                <option value="awaiting"
                                                                                    {{ $candi->cand_type == 'awaiting' ? 'selected' : '' }}>
                                                                                    Awaiting</option>
                                                                                <option value="rejected"
                                                                                    {{ $candi->cand_type == 'rejected' ? 'selected' : '' }}>
                                                                                    Rejected</option>
                                                                                <option value="selected"
                                                                                    {{ $candi->cand_type == 'selected' ? 'selected' : '' }}>
                                                                                    Selected</option>
                                                                            </select>
                                                                        </form>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <a href="#"
                                                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/stage/editemp', 'id' => $candi->id]) }}', 'Edit Candidate')"
                                                                            class="btn btn p-0 px-1">
                                                                            <i class="fi-rr-pencil"></i>
                                                                        </a>

                                                                        <a href="#"
                                                                            onclick="confirmModal('{{ route('admin.candidate.delete', $candi->id) }}')"
                                                                            class="btn btn p-0 px-1">
                                                                            <i class="fi-rr-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="16" class="text-center">
                                                                        {{ get_phrase('No employees/Candidates in this stage') }}
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div> <!-- eSection-wrap -->

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            {{ get_phrase('No stages found') }}
                        </div>
                    @endif

                </div>


            </div>
        </div>
    </div>

    <!-- Custom Mail Modal -->
    <div class="modal fade" id="customMailModal" tabindex="-1" aria-labelledby="customMailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="customMailForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Custom Mail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            onclick="location.reload()"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="candidate_ids" id="mailCandidateIds">
                        <input type="hidden" name="stage_id" id="mailStageId">

                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" id="mailSubject" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea id="mailMessage" name="message"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" onclick="location.reload()" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>

                        <button type="submit" class="btn btn-primary">
                            Send Mail
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(document).on('change', '.candidate-stage', function() {
            var $select = $(this);
            var onboarding_id = $select.val();
            var url = $select.data('url');

            // Disable select and show spinner text
            $select.prop('disabled', true);
            var originalText = $select.find('option:selected').text();
            $select.find('option:selected').text('Updating...');

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    onboarding: onboarding_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.message || 'Stage updated successfully');

                    // Highlight update visually without reloading the page
                    window.location.reload();
                    
                    $select.addClass('border border-success');
                    setTimeout(() => {
                        $select.removeClass('border border-success');
                    }, 2000);
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    toastr.error(xhr.responseJSON?.message || 'Failed to update onboarding stage');
                    $select.val($select.data('previous'));
                },
                complete: function() {
                    $select.prop('disabled', false);
                    $select.find('option:selected').text(originalText);
                    $select.data('previous', $select.val());
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ✅ Select All functionality
            document.querySelectorAll('[id^="selectAll"]').forEach(function(selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const stageId = this.id.replace('selectAll', '');
                    const checkboxes = document.querySelectorAll(
                        `#collapse${stageId} .candidate-checkbox`);
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });
            });

            // ✅ Open modal and prefill selected candidate IDs
            document.querySelectorAll('.send-mail-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const stageId = this.dataset.stage;
                    const selected = Array.from(
                        document.querySelectorAll(
                            `#collapse${stageId} .candidate-checkbox:checked`)
                    ).map(cb => cb.value);

                    if (selected.length === 0) {
                        alert('Please select at least one candidate.');
                        return;
                    }

                    document.getElementById('mailCandidateIds').value = selected.join(',');

                    // Prefill message template with placeholder
                    // document.getElementById('mailMessage').value =
                    //     "Hello @{{ candidate_name }},\n\n";

                    // Show the modal
                    let mailModal = new bootstrap.Modal(document.getElementById('customMailModal'));
                    mailModal.show();
                });
            });

            // ✅ Handle modal form submit
            document.getElementById('customMailForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const sendBtn = document.getElementById('sendMailBtn');
                const spinner = document.getElementById('sendMailSpinner');

                const formData = new FormData(this);
                const candidateIds = formData.get('candidate_ids').split(',');
                const subject = formData.get('subject');
                const messageTemplate = formData.get('message');

                if (!subject || !messageTemplate) {
                    alert('Please fill subject and message.');
                    return;
                }

                try {
                    // ✅ Show spinner and disable button
                    spinner.classList.remove('d-none');
                    sendBtn.disabled = true;

                    const res = await fetch("{{ route('admin.candidate.sendMail') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            candidate_ids: candidateIds,
                            subject: subject,
                            message: messageTemplate
                        })
                    });

                    if (!res.ok) {
                        const errorText = await res.text();
                        console.error('AJAX Error:', res.status, res.statusText);
                        console.error('Response:', errorText);
                        alert('Server Error (' + res.status + '): ' + res.statusText);
                        return;
                    }

                    const data = await res.json();
                    alert(data.message || 'Mail sent successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('customMailModal')).hide();

                } catch (error) {
                    console.error('Catch Error:', error);
                    alert('Something went wrong. Check console for details.');
                } finally {
                    // ✅ Hide spinner and enable button
                    spinner.classList.add('d-none');
                    sendBtn.disabled = false;
                }
            });


        });
    </script>


    <script>
        $(document).on('change', '.candidate-final-checkbox', function() {
            var candidateId = $(this).data('id');
            var isFinal = $(this).is(':checked') ? 'yes' : 'no';

            $.ajax({
                url: "{{ route('admin.candidate.updateIsFinal') }}",
                method: 'POST',
                data: {
                    candidate_id: candidateId,
                    is_final: isFinal,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.message || 'Shortlist status updated successfully');
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    toastr.error('Failed to update shortlist status');
                }
            });
        });
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#email_template')).catch(error => console.error(error));
    </script>

    <script>
        let mailEditor;

        ClassicEditor
            .create(document.querySelector('#mailMessage'), {
                height: '300px' // custom height
            })
            .then(editor => {
                mailEditor = editor;
            })
            .catch(error => console.error(error));
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Handle click on send mail button
            document.querySelectorAll('.send-mail-btn').forEach(btn => {

                btn.addEventListener('click', function() {

                    let stageId = this.dataset.stage;
                    let candidateIds = [];

                    // collect selected candidate IDs
                    document.querySelectorAll(`#collapse${stageId} .candidate-checkbox:checked`)
                        .forEach(cb => {
                            candidateIds.push(cb.value);
                        });

                    if (candidateIds.length === 0) {
                        alert("Please select at least one candidate");
                        return;
                    }

                    // Set hidden inputs
                    document.getElementById('mailCandidateIds').value = candidateIds.join(',');
                    document.getElementById('mailStageId').value = stageId;

                    // Fetch email template using AJAX
                    fetch(`/admin/get-stage-template/${stageId}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('mailSubject').value = data.subject ?? '';
                            mailEditor.setData(data.template ?? '');
                        });

                    // Show modal
                    let modal = new bootstrap.Modal(document.getElementById('customMailModal'));
                    modal.show();
                });
            });


            // Submit Send Mail Form
            document.getElementById('customMailForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.set('message', mailEditor.getData());

                fetch(`/admin/send-stage-mail`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);

                        // close modal
                        bootstrap.Modal.getInstance(document.getElementById('customMailModal')).hide();
                    });
            });

        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("candidateSearch");
            const tableBody = document.getElementById("candidateTableBody");

            if (!searchInput || !tableBody) return;

            searchInput.addEventListener("keyup", function() {
                const value = this.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll("tr");
                let visibleCount = 0;

                rows.forEach(row => {
                    if (row.querySelector("td[colspan]")) return;

                    const name = row.querySelector(".c-name")?.innerText.toLowerCase() || "";
                    const email = row.querySelector(".c-email")?.innerText.toLowerCase() || "";
                    const phone = row.querySelector(".c-phone")?.innerText.toLowerCase() || "";
                    const address = row.querySelector(".c-address")?.innerText.toLowerCase() || "";
                    const source = row.querySelector(".c-source")?.innerText.toLowerCase() || "";
                    const country = row.querySelector(".c-country")?.innerText.toLowerCase() || "";
                    const state = row.querySelector(".c-state")?.innerText.toLowerCase() || "";
                    const dob = row.querySelector(".c-dob")?.innerText.toLowerCase() || "";
                    const recruitment = row.querySelector(".c-recruitment")?.innerText
                        .toLowerCase() || "";
                    const stage = row.querySelector(".c-stage")?.innerText.toLowerCase() || "";
                    const type = row.querySelector(".c-type")?.innerText.toLowerCase() || "";
                    const resume = row.querySelector(".c-resume")?.innerText.toLowerCase() || "";

                    const match =
                        name.includes(value) ||
                        email.includes(value) ||
                        phone.includes(value) ||
                        address.includes(value) ||
                        source.includes(value) ||
                        country.includes(value) ||
                        state.includes(value) ||
                        dob.includes(value) ||
                        recruitment.includes(value) ||
                        stage.includes(value) ||
                        type.includes(value) ||
                        resume.includes(value);

                    if (match) {
                        row.style.display = "";
                        visibleCount++;
                    } else {
                        row.style.display = "none";
                    }
                });

                let noResultRow = document.getElementById("candidateNoResultRow");

                if (visibleCount === 0) {
                    if (!noResultRow) {
                        noResultRow = document.createElement("tr");
                        noResultRow.id = "candidateNoResultRow";
                        noResultRow.innerHTML = `
                    <td colspan="16" class="text-center text-muted">
                        No matching candidates found
                    </td>
                `;
                        tableBody.appendChild(noResultRow);
                    }
                } else {
                    if (noResultRow) {
                        noResultRow.remove();
                    }
                }
            });
        });
    </script>
@endpush
