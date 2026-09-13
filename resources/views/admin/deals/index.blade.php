@extends('index')
@push('title', get_phrase('Deals'))
@push('meta')
@endpush
@push('css')
    <style>
        /* Classic ERP Kanban Styling */
        .kanban-wrapper {
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding-bottom: 1rem;
        }

        .kanban-column {
            min-width: 260px;
            background-color: #f9f9f9;
            border: 1px solid #00a3ff;
            border-radius: 6px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .kanban-header {
            background-color: #00a3ff;
            border-bottom: 1px solid #00a3ff;
            padding: 8px 10px;
            font-weight: 600;
            text-align: center;
            font-size: 0.9rem;
            text-transform: capitalize;
            color: #ffffff;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .kanban-body {
            padding: 8px;
            flex-grow: 1;
            overflow-y: auto;
            max-height: 75vh;
        }

        .deal-card {
            position: relative;
            background-color: #fff;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            margin-bottom: 8px;
            padding: 8px 10px 10px 10px;
            cursor: grab;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            transition: background 0.2s;
        }

        .deal-card:hover {
            background-color: #f7f7f7;
        }

        .deal-title {
            font-weight: 600;
            color: #212529;
            font-size: 0.9rem;
            margin-bottom: 3px;
            padding-left: 20px;
        }

        .deal-meta {
            font-size: 0.8rem;
            color: #666;
            margin: 0;
        }

        .deal-btns {
            display: flex;
            gap: 6px;
            margin-top: 6px;
        }

        .deal-btns button {
            flex: 1;
            font-size: 0.75rem;
            border-radius: 4px;
            padding: 3px 4px;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .deal-edit-btn {
            background: #00a3ff;
            color: white;
        }

        .deal-datetime-btn {
            background: #ffc107;
            color: #000;
        }

        .deal-edit-btn:hover {
            background: #007acc;
        }

        .deal-datetime-btn:hover {
            background: #e0a800;
        }

        .empty-text {
            text-align: center;
            color: #999;
            font-size: 0.85rem;
            margin-top: 10px;
        }

        ::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Deals') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Deals') }}</a></li>
                </ul>
            </div>
            @can('deal-create')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/deals/add']) }}', '{{ get_phrase('Add new deals') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new deals') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    {{-- 🔹 Filter Section --}}
    <div class="mb-3 d-flex justify-content-end align-items-center gap-2">
        <label for="dealFilter" class="fw-bold text-secondary eForm-label">Filter:</label>
        <select id="dealFilter" class="form-select w-auto">
            {{-- <option value="">All</option> --}}
            <option value="call_again" class="deal-meta">Call Again</option>
            <option value="others" class="deal-meta">All</option>
        </select>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Sales Pipeline') }}</p>

                <div class="container-fluid py-3">
                    <div class="kanban-wrapper">
                        @foreach ($stages as $stage)
                            <div class="kanban-column">
                                <div class="kanban-header">{{ str_replace('_', ' ', $stage) }}</div>
                                <div class="kanban-body" id="stage-{{ $stage }}">
                                    @forelse ($dealsByStage[$stage] as $deal)
                                        <div class="deal-card" draggable="true" data-id="{{ $deal->id }}"
                                            data-type="{{ $deal->type ?? 'others' }}">
                                            <div class="deal-title">{{ $deal->title ?? 'Untitled Deal' }}</div>
                                            <p class="deal-meta">Contact: {{ $deal->leads->phone ?? 'N/A' }}</p>
                                            <p class="deal-meta">Assigned: {{ $deal->userAssign->name ?? 'N/A' }}</p>
                                            <p class="deal-meta">Close Date: {{ $deal->close_date ?? '—' }}</p>
                                            <p class="deal-meta">Requirement: {{ $deal->leads->requirement ?? 'N/A' }}</p>

                                            @can('deal-update')
                                                <div class="deal-btns">
                                                <button class="deal-edit-btn"
                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/deals/edit', 'id' => $deal->id]) }}', '{{ get_phrase('Edit Deal') }}')">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="deal-datetime-btn"
                                                    onclick="openDatetimeModal({{ $deal->id }})">
                                                    <i class="bi bi-calendar-event"></i> Set Time
                                                </button>
                                            </div>
                                            @endcan
                                        </div>
                                        <div class="deal-card" draggable="true" data-id="{{ $deal->id }}"
                                            data-type="{{ $deal->type ?? 'call_again' }}">
                                            <div class="deal-title">{{ $deal->title ?? 'Untitled Deal' }}</div>
                                            <p class="deal-meta">Contact: {{ $deal->leads->phone ?? 'N/A' }}</p>
                                            <p class="deal-meta">Assigned: {{ $deal->userAssign->name ?? 'N/A' }}</p>
                                            <p class="deal-meta">Close Date: {{ $deal->close_date ?? '—' }}</p>
                                            <p class="deal-meta">Requirement: {{ $deal->leads->requirement ?? 'N/A' }}</p>
                                            <p class="deal-meta">Call Again: <span
                                                    class="bg-danger p-1 rounded text-white">{{ $deal->call_again ?? 'N/A' }}</span>
                                            </p>

                                            <div class="deal-btns">
                                                <button class="deal-edit-btn"
                                                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/deals/edit', 'id' => $deal->id]) }}', '{{ get_phrase('Edit Deal') }}')">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <button class="deal-datetime-btn"
                                                    onclick="openDatetimeModal({{ $deal->id }})">
                                                    <i class="bi bi-calendar-event"></i> Set Time
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="empty-text">No deals</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- 🔹 Modal for setting custom stage date-time --}}
    <div class="modal fade" id="datetimeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <h6 class="fw-bold mb-2 eForm-label">Set Stage Changed Date & Time</h6>
                <input type="datetime-local" id="stageDatetime" class="form-control eForm-control mb-3">
                <div class="d-flex justify-content-end">
                    <button class="btn-form my-2 w-50 me-2" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn-form my-2 w-50" onclick="saveDatetime()">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let currentDealId = null;

        // ✅ DateTime Modal
        function openDatetimeModal(dealId) {
            currentDealId = dealId;
            const modal = new bootstrap.Modal(document.getElementById('datetimeModal'));
            modal.show();
        }

        function saveDatetime() {
            const datetime = document.getElementById('stageDatetime').value;
            if (!datetime) {
                alert('Please select a date and time.');
                return;
            }

            fetch(`/admin/deals/update-stage-time/${currentDealId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        stage_changed: datetime
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert('Date & time updated successfully!');
                    bootstrap.Modal.getInstance(document.getElementById('datetimeModal')).hide();
                })
                .catch(err => console.error(err));
        }

        // ✅ Kanban Drag & Drop
        document.querySelectorAll('.deal-card').forEach(el => {
            el.addEventListener('dragstart', e => {
                e.dataTransfer.setData('id', e.target.dataset.id);
                e.dataTransfer.setData('from', e.target.closest('.kanban-body').id);
            });
        });

        document.querySelectorAll('[id^="stage-"]').forEach(container => {
            container.addEventListener('dragover', e => e.preventDefault());
            container.addEventListener('drop', e => {
                e.preventDefault();

                const id = e.dataTransfer.getData('id');
                const fromStageId = e.dataTransfer.getData('from');
                const deal = document.querySelector(`[data-id="${id}"]`);
                container.appendChild(deal);

                const emptyText = container.querySelector('.empty-text');
                if (emptyText) emptyText.remove();

                const fromStage = document.getElementById(fromStageId);
                if (fromStage && fromStage.querySelectorAll('.deal-card').length === 0) {
                    const emptyMsg = document.createElement('p');
                    emptyMsg.classList.add('empty-text');
                    emptyMsg.textContent = 'No deals';
                    fromStage.appendChild(emptyMsg);
                }

                const newStage = container.id.replace('stage-', '');
                fetch(`/admin/deals/update-stage/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            stage: newStage
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        deal.style.borderColor = '#28a745';
                        setTimeout(() => deal.style.borderColor = '#dcdcdc', 800);
                    })
                    .catch(err => console.error(err));
            });
        });

        // ✅ Filter for "Call Again" & "Others"
        // Set default filter to "others" on page load
        window.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('dealFilter');
            filterSelect.value = 'others'; // set default selection

            applyDealFilter('others'); // apply the filter immediately
        });

        // Listen for filter change
        document.getElementById('dealFilter').addEventListener('change', function() {
            applyDealFilter(this.value);
        });

        // Function to filter deals
        function applyDealFilter(filter) {
            document.querySelectorAll('.deal-card').forEach(card => {
                if (!filter || card.dataset.type === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endpush
