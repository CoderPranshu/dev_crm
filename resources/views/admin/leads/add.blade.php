@php
    $currentUser = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    */

    $categories = DB::table('lead_categories')
        ->orderBy('title')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | BRANCHES
    |--------------------------------------------------------------------------
    */

    $branches = DB::table('branches')
        ->orderBy('title')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | SALES USERS
    |--------------------------------------------------------------------------
    */

    $salesUsersQuery = \App\Models\User::role('Sales');

    // Admin = all Sales users
    // Other users = only own branch Sales users
    if (!$currentUser->hasRole('Admin')) {

        $salesUsersQuery->where(
            'branch_id',
            $currentUser->branch_id
        );
    }

    $salesUsers = $salesUsersQuery
        ->orderBy('name')
        ->get();
@endphp


<form
    action="{{ route('admin.leads.store') }}"
    method="post"
>

    @csrf


    <div class="row">

        {{-- NAME --}}
        <div class="col-md-12">

            <label
                for="name"
                class="eForm-label"
            >
                {{ get_phrase('Name') }}
                <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="form-control eForm-control"
                id="name"
                required
            />

        </div>


        {{-- PHONE --}}
        <div class="col-md-12 mt-2">

            <label
                for="phone"
                class="eForm-label"
            >
                {{ get_phrase('Phone no') }}
                <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                class="form-control eForm-control"
                id="phone"
                maxlength="10"
                required
            />

        </div>


        {{-- EMAIL --}}
        <div class="col-md-12 mt-2">

            <label
                for="email"
                class="eForm-label"
            >
                {{ get_phrase('Email address') }}
                <span class="text-danger">*</span>
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="form-control eForm-control"
                id="email"
                required
            />

        </div>


        {{-- REQUIREMENT --}}
        <div class="col-md-12 mt-2">

            <label
                for="requirement"
                class="eForm-label"
            >
                {{ get_phrase('Requirement') }}
                <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="requirement"
                value="{{ old('requirement') }}"
                class="form-control eForm-control"
                id="requirement"
                required
            />

        </div>


        {{-- ADDRESS --}}
        <div class="col-md-12 mt-2">

            <label
                for="address"
                class="eForm-label"
            >
                {{ get_phrase('Address') }}
            </label>

            <input
                type="text"
                name="address"
                value="{{ old('address') }}"
                class="form-control eForm-control"
                id="address"
            />

        </div>


        {{-- BRANCH --}}
        @if ($currentUser->hasRole('Admin'))

            <div class="col-md-12 mt-2">

                <label
                    for="branch_id"
                    class="eForm-label"
                >
                    {{ get_phrase('Branch') }}
                    <span class="text-danger">*</span>
                </label>

                <select
                    name="branch_id"
                    id="branch_id"
                    class="form-control eForm-select select2"
                    required
                >

                    <option value="" disabled selected>
                        {{ get_phrase('Select a branch') }}
                    </option>

                    @foreach ($branches as $row)

                        <option
                            value="{{ $row->id }}"
                            {{ old('branch_id') == $row->id ? 'selected' : '' }}
                        >
                            {{ $row->title }}
                        </option>

                    @endforeach

                </select>

            </div>

        @else

            <input
                type="hidden"
                name="branch_id"
                value="{{ $currentUser->branch_id }}"
            >

        @endif


        {{-- SALES PERSON --}}
        <div class="col-md-12 mt-2">

            <label
                for="sales_user_id"
                class="eForm-label"
            >
                {{ get_phrase('Assign To Sales Person') }}
                <span class="text-danger">*</span>
            </label>

            <select
                name="sales_user_id"
                id="sales_user_id"
                class="form-control eForm-select select2"
                required
            >

                <option value="" disabled selected>
                    {{ get_phrase('Select Sales Person') }}
                </option>

                @foreach ($salesUsers as $salesUser)

                    <option
                        value="{{ $salesUser->id }}"
                        data-branch="{{ $salesUser->branch_id }}"
                        {{ old('sales_user_id') == $salesUser->id ? 'selected' : '' }}
                    >
                        {{ $salesUser->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- CATEGORY --}}
        <div class="col-md-12 mt-2">

            <label
                for="categories_id"
                class="eForm-label"
            >
                {{ get_phrase('Category') }}
                <span class="text-danger">*</span>
            </label>

            <select
                class="form-select eForm-select select2"
                id="categories_id"
                name="categories_id"
                required
            >

                <option value="" disabled selected>
                    {{ get_phrase('Select a category') }}
                </option>

                @foreach ($categories as $row)

                    <option
                        value="{{ $row->id }}"
                        {{ old('categories_id') == $row->id ? 'selected' : '' }}
                    >
                        {{ $row->title }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- SUBMIT --}}
        <div class="col-md-12 mt-3">

            <button
                type="submit"
                class="btn-form my-2 w-100"
            >
                {{ get_phrase('Add Lead') }}
            </button>

        </div>

    </div>

</form>


@include('init')
