@extends('index')
@push('title', get_phrase('Recreitment Stages'))
@push('meta')
@endpush
@push('css')
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
            @can('stage-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal(
        '{{ route('right_modal', ['view_path' => 'admin/stage/add']) }}?recruitment_id=' + getActiveRecruitmentId(),
        '{{ get_phrase('Add new stage') }}'
    )"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new stage') }}</span>
                    </a>


                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (isset($recruitments) && $recruitments->count())
                {{-- Stylish Tabs Navigation --}}
                <ul class="nav nav-tabs border-0 mb-3" id="recruitmentTabs" role="tablist">
                    @foreach ($recruitments as $key => $rec)
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link fw-semibold px-4 py-2 rounded-top
    @if ($key == 0) active @endif"
                                id="tab-{{ $rec->id }}" data-bs-toggle="tab"
                                data-bs-target="#recruitment-{{ $rec->id }}" type="button" role="tab"
                                aria-controls="recruitment-{{ $rec->id }}"
                                aria-selected="{{ $key == 0 ? 'true' : 'false' }}"
                                onclick="setActiveRecruitment({{ $rec->id }})">
                                {{ $rec->title ?? 'Recruitment ' . $rec->id }}
                            </button>

                        </li>
                    @endforeach
                </ul>

                {{-- Tabs Content --}}
                <div class="tab-content mt-2" id="recruitmentTabsContent">
                    @foreach ($recruitments as $key => $rec)
                        <div class="tab-pane fade @if ($key == 0) show active @endif p-3 rounded bg-white shadow-sm"
                            id="recruitment-{{ $rec->id }}" role="tabpanel"
                            aria-labelledby="tab-{{ $rec->id }}">

                            @php
                                $stages = $rec->stages ?? collect();
                            @endphp

                            @if (isset($stages) && $stages->count())
                                <div class="accordion" id="stagesAccordion{{ $rec->id }}">
                                    @foreach ($stages as $index => $stage)
                                        <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
                                            <h2 class="accordion-header" id="heading{{ $stage->id }}">
                                                <button
                                                    class="accordion-button fw-semibold
                                                @if ($index > 0) collapsed @endif"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $stage->id }}"
                                                    aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                                    aria-controls="collapse{{ $stage->id }}">
                                                    {{ $stage->title }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $stage->id }}"
                                                class="accordion-collapse collapse @if ($index == 0) show @endif"
                                                aria-labelledby="heading{{ $stage->id }}"
                                                data-bs-parent="#stagesAccordion{{ $rec->id }}">
                                                <div class="accordion-body bg-light-subtle p-3">
                                                    {{-- Keep table section untouched --}}
                                                    <div class="eSection-wrap">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <p class="column-title mb-0 fw-bold">
                                                                    {{ get_phrase('Stage') }}
                                                                </p>
                                                                <div class="dropdown-center ps-3">
                                                                    <button class="btn btn-sm btn-primary dropdown-toggle"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        Actions
                                                                    </button>
                                                                    <ul class="dropdown-menu shadow">
                                                                        <li>
                                                                            <a class="dropdown-item send-mail-btn"
                                                                                href="#"
                                                                                data-stage="{{ $stage->id }}">
                                                                                <i class="fi-rr-paper-plane pe-1"></i>
                                                                                Send Mail to Selected
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('admin.stage.candidates.export', $stage->id) }}"
                                                                class="export_btn_success mb-2">
                                                                Export CSV
                                                            </a>
                                                            <div class="mb-3">
                                                                <input type="text" id="candidateSearch"
                                                                    class="form-control eForm-control"
                                                                    placeholder="{{ get_phrase('Search name / email / phone / source / country / state / stage...') }}">
                                                            </div>
                                                        </div>
                                                        {{-- table remains same --}}
                                                        <div class="table-responsive">
                                                            <table class="table eTable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <input type="checkbox"
                                                                                id="selectAll{{ $stage->id }}">
                                                                        </th>
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
                                                                        <th class="stage-column">{{ get_phrase('Stage') }}
                                                                        </th>
                                                                        <th class="text-center">{{ get_phrase('Action') }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="candidateTableBody">

                                                                    @forelse($stage->candi as $i => $candi)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox"
                                                                                    class="candidate-checkbox"
                                                                                    value="{{ $candi->id }}"
                                                                                    data-email="{{ $candi->email }}">
                                                                            </td>

                                                                            <td>{{ $loop->iteration }}</td>

                                                                            <td class="c-name">{{ $candi->name }}</td>
                                                                            <td class="c-email">{{ $candi->email }}</td>
                                                                            <td class="c-phone">{{ $candi->phone }}</td>
                                                                            <td class="c-address">{{ $candi->address }}
                                                                            </td>
                                                                            <td class="c-source">{{ $candi->source }}</td>
                                                                            <td class="c-country">{{ $candi->country }}
                                                                            </td>
                                                                            <td class="c-state">{{ $candi->state }}</td>
                                                                            <td class="c-dob">{{ $candi->dob }}</td>

                                                                            <td>
                                                                                <a href="{{ asset('uploads/resume/' . $candi->resume) }}"
                                                                                    target="_blank"
                                                                                    class="text-info">Download Resume</a>
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
                                                                                <form>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <select name="stage_id"
                                                                                                class="form-control eForm-control candidate-stage"
                                                                                                data-id="{{ $candi->id }}"
                                                                                                data-url="{{ route('admin.candidate.updateStage', $candi->id) }}">
                                                                                                @if ($candi->recruitment && $candi->recruitment->stages)
                                                                                                    @foreach ($candi->recruitment->stages as $stage)
                                                                                                        <option
                                                                                                            value="{{ $stage->id }}"
                                                                                                            @if ($candi->stage_id == $stage->id) selected @endif>
                                                                                                            {{ $stage->title }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </td>

                                                                            <td class="text-center">
                                                                                <a href="#"
                                                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/stage/editemp', 'id' => $candi->id]) }}', '{{ get_phrase('Edit branch') }}')"
                                                                                    class="btn btn p-0 px-1"
                                                                                    title="{{ get_phrase('Edit') }}"
                                                                                    data-bs-toggle="tooltip">
                                                                                    <i class="fi-rr-pencil"></i>
                                                                                </a>

                                                                                <a href="#"
                                                                                    onclick="confirmModal('{{ route('admin.candidate.delete', $candi->id) }}')"
                                                                                    class="btn btn p-0 px-1"
                                                                                    title="{{ get_phrase('Delete') }}"
                                                                                    data-bs-toggle="tooltip">
                                                                                    <i class="fi-rr-trash"></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="15" class="text-center">
                                                                                {{ get_phrase('No employees in this stage') }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforelse

                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info mt-3">
                                    {{ get_phrase('No stages found for this recruitment') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">{{ get_phrase('No recruitments found') }}</div>
            @endif
        </div>
    </div>

    <!-- Custom Mail Modal -->
    <div class="modal fade" id="customMailModal" tabindex="-1" aria-labelledby="customMailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="customMailForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customMailModalLabel eForm-label">Send Custom Mail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="candidate_ids" id="mailCandidateIds">
                        <div class="mb-3">
                            <label for="mailSubject" class="form-label eForm-label">Subject</label>
                            <input type="text" class="form-control eForm-control" name="subject" id="mailSubject"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="mailMessage" class="form-label eForm-label">Message</label>
                            <textarea class="form-control eForm-control" name="message" id="mailMessage" rows="6" required>
                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="sendMailBtn">
                            <span class="spinner-border spinner-border-sm me-2 d-none" id="sendMailSpinner"
                                role="status" aria-hidden="true"></span>
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
            var stage_id = $select.val();
            var candidate_id = $select.data('id');
            var url = $select.data('url');

            // Disable select and show spinner
            $select.prop('disabled', true);
            var originalText = $select.find('option:selected').text();
            $select.find('option:selected').text('Updating...');

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    stage_id: stage_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    toastr.success(response.message || 'Stage updated successfully');

                    setTimeout(function() {
                        location.reload();
                    }, 700); // Let the success toast show before reload
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                    toastr.error(xhr.responseJSON?.message || 'Failed to update stage');

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



    {{-- Custom js for the add button --}}
    <script>
        let activeRecruitmentId = null;

        function setActiveRecruitment(id) {
            activeRecruitmentId = id;
            localStorage.setItem('activeRecruitmentTab', id);
            // console.log("Active Recruitment:", id);
        }
    </script>

    <script>
        function getActiveRecruitmentId() {
            let activeTab = document.querySelector('.nav-link.active');
            return activeTab ? activeTab.id.replace('tab-', '') : null;
        }
    </script>


    @if (session('active_recruitment_id'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let id = "{{ session('active_recruitment_id') }}";
                let targetTab = document.getElementById('tab-' + id);

                if (targetTab) {
                    // Bootstrap activate tab
                    let tabObj = new bootstrap.Tab(targetTab);
                    tabObj.show();
                }
            });
        </script>
    @endif



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
                        stage.includes(value);

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
                    <td colspan="15" class="text-center text-muted">
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
