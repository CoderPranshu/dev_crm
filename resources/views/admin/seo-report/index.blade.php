@extends('index')

@push('title', get_phrase('SEO Report Management'))

@section('content')

<form action="{{ route('admin.seo-report.generate') }}" method="POST">
    @csrf

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center">

            <h4>
                SEO Report Management
            </h4>

            <button class="btn btn-danger">
                <i class="fi-rr-file-pdf"></i>
                Generate PDF
            </button>

        </div>
    </div>

    <div class="eSection-wrap">

        <div class="row">

            <div class="col-md-4 mb-3">

                <label class="form-label fw-bold">
                    Company
                </label>

                <select class="form-select" name="company_id" required>

                    <option value="">
                        Select Company
                    </option>

                    @foreach($companies as $company)

                        <option value="{{ $company->id }}">
                            {{ $company->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label fw-bold">
                    Start Date
                </label>

                <input type="date"
                       class="form-control"
                       name="start_date"
                       required>

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label fw-bold">
                    End Date
                </label>

                <input type="date"
                       class="form-control"
                       name="end_date"
                       required>

            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-12">

                <label class="form-label fw-bold">
                    Additional Remarks
                </label>

                <textarea class="form-control"
                          rows="8"
                          name="report_remarks"
                          placeholder="Write report summary..."></textarea>

            </div>

        </div>

    </div>

</form>

@endsection