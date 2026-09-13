@extends('index')
@push('title', get_phrase('Stock Movement'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Stock Movement') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Stock Movement') }}</a></li>
                </ul>
            </div>
            @can('stockmovement-list')
                <div class="export-btn-area">
                    <a href="#"
                        onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/stockmovement/add']) }}', '{{ get_phrase('Add new Stock Movement') }}')"
                        class="export_btn">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline-block">{{ get_phrase('Add new Stock Movement') }}</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="column-title mb-0">{{ get_phrase('Stock Movements') }}</p>

                    <div style="min-width: 320px;">
                        <input type="text" id="movementSearch" class="form-control eForm-control"
                            placeholder="{{ get_phrase('Search product / warehouse / type / note...') }}"
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div id="movementTableWrapper">
                    @include('admin.stockmovement.partials.table', ['movements' => $movements])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("movementSearch");
            const wrapper = document.getElementById("movementTableWrapper");
            let debounceTimer;

            function loadMovements(url = null) {
                const search = searchInput.value.trim();
                const fetchUrl = url ? url :
                    `{{ route('admin.stockmovement.index') }}?search=${encodeURIComponent(search)}`;

                wrapper.style.opacity = "0.6";

                fetch(fetchUrl, {
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        wrapper.innerHTML = html;
                        wrapper.style.opacity = "1";

                        const tooltipTriggerList = [].slice.call(wrapper.querySelectorAll(
                            '[data-bs-toggle="tooltip"]'));
                        tooltipTriggerList.map(function(tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    })
                    .catch(error => {
                        console.error("AJAX load error:", error);
                        wrapper.style.opacity = "1";
                    });
            }

            searchInput.addEventListener("keyup", function() {
                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(() => {
                    loadMovements();
                }, 400);
            });

            document.addEventListener("click", function(e) {
                const link = e.target.closest(".ajax-pagination a");

                if (link) {
                    e.preventDefault();
                    loadMovements(link.href);
                }
            });
        });
    </script>
@endpush
