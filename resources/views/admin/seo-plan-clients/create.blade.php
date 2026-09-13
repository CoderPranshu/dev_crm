@extends('index')

@push('title', get_phrase('Assign SEO Plan to Client'))

@section('content')
    <div class="mainSection-title">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <div>
                <h4>{{ get_phrase('Assign SEO Plan to Client') }}</h4>
            </div>

            <div>
                <a href="{{ route('admin.seo-plan-clients.index') }}" class="btn btn-secondary">
                    <i class="fi-rr-arrow-left"></i>
                    Back
                </a>
            </div>

        </div>

    </div>

    <div class="eSection-wrap">

        <form action="{{ route('admin.seo-plan-clients.store') }}" method="POST">
            @csrf

            <div class="row">

                <!-- SEO PLAN -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        SEO Plan <span class="text-danger">*</span>
                    </label>

                    <select name="seo_plan_id" class="form-select @error('seo_plan_id') is-invalid @enderror" required>

                        <option value="">Select SEO Plan</option>

                        {{-- @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}"
                            {{ old('seo_plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }}
                        </option>
                    @endforeach --}}

                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}" data-duration="{{ $plan->duration }}"
                                {{ old('seo_plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('seo_plan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <!-- CLIENT -->
                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Client <span class="text-danger">*</span>
                    </label>

                    <select name="client_id" class="form-select @error('client_id') is-invalid @enderror" required>

                        <option value="">Select Client</option>

                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Team <span class="text-danger">*</span>
                    </label>
                    <select name="team_id" class="form-control" required>
                        <option value="">
                            Select Team
                        </option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}">
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- START DATE -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Start Date
                    </label>

                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date') }}">

                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <!-- END DATE -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        End Date
                    </label>

                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                        value="{{ old('end_date') }}" readonly>

                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                {{--  --}}

               

                {{--  --}}

                <!-- STATUS -->
                <div class="col-md-12 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status" class="form-select @error('status') is-invalid @enderror">

                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>
                            Paused
                        </option>

                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                    </select>

                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

            </div>

            <!-- BUTTONS -->
            <div class="mt-3">

                <button type="submit" class="btn btn-primary">
                    <i class="fi-rr-disk"></i>
                    Save
                </button>

                <a href="{{ route('admin.seo-plan-clients.index') }}" class="btn btn-light">
                    Cancel
                </a>

            </div>

        </form>

    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const planSelect = document.querySelector('select[name="seo_plan_id"]');
            const startDate = document.querySelector('input[name="start_date"]');
            const endDate = document.querySelector('input[name="end_date"]');

            function calculateEndDate() {

                const selectedOption = planSelect.options[planSelect.selectedIndex];
                const duration = parseInt(selectedOption.getAttribute('data-duration') || 0);

                if (!startDate.value || !duration) return;

                let start = new Date(startDate.value);
                start.setMonth(start.getMonth() + duration);

                let year = start.getFullYear();
                let month = String(start.getMonth() + 1).padStart(2, '0');
                let day = String(start.getDate()).padStart(2, '0');

                endDate.value = `${year}-${month}-${day}`;
            }

            planSelect.addEventListener('change', calculateEndDate);
            startDate.addEventListener('change', calculateEndDate);

        });
    </script>
@endpush
