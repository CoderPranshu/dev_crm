@php
    $currentUser = auth()->user();

    $salesUsersQuery = \App\Models\User::role('Sales');

    // Admin ko sab Sales users dikhaye
    // Non-admin ko sirf apni branch ke Sales users
    if (!$currentUser->hasRole('Admin')) {
        $salesUsersQuery->where('branch_id', $currentUser->branch_id);
    }

    $salesUsers = $salesUsersQuery
        ->orderBy('name')
        ->get();


     /*
    |--------------------------------------------------------------------------
    | LEAD CATEGORIES
    |--------------------------------------------------------------------------
    */

    $leadCategories = \App\Models\LeadCategory::query()
        ->orderBy('title')
        ->get();
        
        
@endphp

<a href="{{ asset('leads_sample.csv') }}"
   download
   class="export_btn_primary">
    Download Sample CSV
</a>

<div class="bg-warning mt-3 p-2 rounded">
    <small class="eForm-label">
        *Note: CSV status column should contain only:
        pending / accept / reject / call
    </small>
</div>

<form action="{{ route('admin.leads.import.prepare') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    

    <div class="pt-4">

        {{-- SALES ASSIGNMENT --}}
        <div class="mb-3">

            <label class="eForm-label">
                Assign Leads To Sales Person
                <span class="text-danger">*</span>
            </label>

            <select name="sales_user_id"
                    class="form-control eForm-control"
                    required>

                <option value="">
                    Select Sales Person
                </option>

                @foreach($salesUsers as $salesUser)

                    <option value="{{ $salesUser->id }}">
                        {{ $salesUser->name }}
                    </option>

                @endforeach

            </select>

        </div>

        {{-- LEAD CATEGORY --}}
        <div class="mb-3">

            <label class="eForm-label">
                Lead Category
                <span class="text-danger">*</span>
            </label>

            <select
                name="category_id"
                class="form-control eForm-control"
                required
            >

                <option value="">
                    Select Lead Category
                </option>

                @foreach($leadCategories as $category)

                    <option value="{{ $category->id }}">
                        {{ $category->title }}
                    </option>

                @endforeach

            </select>

        </div>



        {{-- CSV FILE --}}
        <div class="mb-3">

            <label class="eForm-label">
                Choose CSV / Excel File
                <span class="text-danger">*</span>
            </label>

            <input type="file"
                name="file"
                class="form-control eForm-control"
                accept=".csv,.xlsx,.xls"
                required>

        </div>


        <div class="bg-light border rounded p-3 mb-3">

            <small class="text-muted">

                Imported leads will automatically be marked as
                <strong>CSV / Bulk Upload</strong>
                and assigned to the selected sales person.

            </small>

        </div>

    </div>


   <button class="btn-form py-2 w-100" type="submit">
        Continue to Column Mapping
    </button>

</form>