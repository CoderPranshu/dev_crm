@extends('index')
@push('title', get_phrase('User'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Users') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('User') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('User') }}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Name') }}</th>
                                <th class="">{{ get_phrase('Role') }}</th>
                                <th class="">{{ get_phrase('Email') }}</th>
                                <th class="">{{ get_phrase('Phone') }}</th>
                                <th class="">{{ get_phrase('Status') }}</th>
                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $u)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $u->name }}
                                    </td>
                                    <td>
                                        @if (!empty($u->getRoleNames()))
                                            @foreach ($u->getRoleNames() as $v)
                                                <label class="bg-success px-1 text-white rounded">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        {{ $u->email }}
                                    </td>
                                    <td>
                                        {{ $u->phone ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $u->status ?? 'active' }}
                                    </td>

                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/users/edit', 'id' => $u->id]) }}', '{{ get_phrase('Edit vendor') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#"
                                            onclick="confirmModal('{{ route('admin.vendor.delete', $u->id) }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}"
                                            data-bs-toggle="tooltip">
                                            <i class="fi-rr-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
