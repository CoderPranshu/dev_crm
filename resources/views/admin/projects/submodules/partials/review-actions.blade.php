{{--
|--------------------------------------------------------------------------
| Review Actions
|--------------------------------------------------------------------------
| Usage:
| @include(
|     'admin.projects.submodules.partials.review-actions',
|     ['submodule' => $submodule]
| )
|--------------------------------------------------------------------------
--}}

@php
    $canReview = auth()->user()->hasRole('Admin')
        || ($submodule->module->project->assigned_to ?? null) == auth()->id();
@endphp


@if($canReview && $submodule->status === 'Ready For Review')

    <div class="d-flex align-items-center gap-2 flex-wrap">

        {{-- =========================================================
             APPROVE
        ========================================================== --}}
        <form
            action="{{ route('admin.project-submodules.review.store', $submodule->id) }}"
            method="POST"
            class="d-inline"
        >
            @csrf

            <input
                type="hidden"
                name="decision"
                value="Approved"
            >

            <button
                type="submit"
                class="btn btn-sm btn-success"
                onclick="return confirm('Approve this sub module? Once approved it will be locked.')"
            >
                <i class="bi bi-check-lg me-1"></i>
                Approve
            </button>
        </form>


        {{-- =========================================================
             REQUEST CHANGES
        ========================================================== --}}
        <button
            type="button"
            class="btn btn-sm btn-danger"
            data-bs-toggle="modal"
            data-bs-target="#changesModal-{{ $submodule->id }}"
        >
            <i class="bi bi-x-lg me-1"></i>
            Request Changes
        </button>

    </div>


    {{-- =========================================================
         REQUEST CHANGES MODAL
         Unique modal ID for every submodule
    ========================================================== --}}
    <div
        class="modal fade"
        id="changesModal-{{ $submodule->id }}"
        tabindex="-1"
        aria-labelledby="changesModalLabel-{{ $submodule->id }}"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content cs-request-modal">

                <form
                    action="{{ route('admin.project-submodules.review.store', $submodule->id) }}"
                    method="POST"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="decision"
                        value="Changes Requested"
                    >


                    {{-- =================================================
                         HEADER
                    ================================================== --}}
                    <div class="modal-header cs-request-modal-header">

                        <div>

                            <div class="cs-modal-eyebrow">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Developer Review
                            </div>

                            <h5
                                class="modal-title"
                                id="changesModalLabel-{{ $submodule->id }}"
                            >
                                Request Changes
                            </h5>

                            <p class="cs-modal-subtitle mb-0">
                                {{ $submodule->sub_module_name }}
                            </p>

                        </div>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>


                    {{-- =================================================
                         BODY
                    ================================================== --}}
                    <div class="modal-body cs-request-modal-body">

                        <div class="cs-request-info">

                            <div class="cs-request-info-icon">
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </div>

                            <div>

                                <div class="cs-request-info-title">
                                    Changes are required
                                </div>

                                <div class="cs-request-info-text">
                                    Explain clearly what the developer needs to update.
                                </div>

                            </div>

                        </div>


                        <div>

                            <label
                                for="changeRemarks-{{ $submodule->id }}"
                                class="form-label cs-request-label"
                            >
                                What needs to change?
                                <span class="text-danger">*</span>
                            </label>


                            <textarea
                                id="changeRemarks-{{ $submodule->id }}"
                                name="remarks"
                                rows="5"
                                class="form-control cs-request-textarea"
                                required
                                placeholder="e.g. Notification badge alignment incorrect."
                            ></textarea>


                            <div class="cs-request-help">

                                <i class="fa-regular fa-circle-question"></i>

                                <span>
                                    This remark is visible to the developer and
                                    saved permanently in the review history.
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         FOOTER
                    ================================================== --}}
                    <div class="modal-footer cs-request-modal-footer">

                        <button
                            type="button"
                            class="btn cs-btn-cancel"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>


                        <button
                            type="submit"
                            class="btn cs-btn-request"
                        >
                            <i class="fa-solid fa-arrow-turn-down me-1"></i>
                            Send Back for Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


@elseif($submodule->status === 'Approved')

    <span
        class="small fw-semibold"
        style="color: var(--cs-success, #16A34A);"
    >
        <i class="bi bi-check-circle-fill me-1"></i>
        Approved · Locked
    </span>


@elseif($submodule->status === 'Changes Requested')

    <span
        class="small fw-semibold"
        style="color: var(--cs-warning, #D97706);"
    >
        <i class="bi bi-hourglass-split me-1"></i>
        Waiting on developer
    </span>

@endif