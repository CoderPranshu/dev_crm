@extends('index')
@push('title', get_phrase('Expense Manager'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Expense Managers') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Expense Managers') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#" onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.expense_manager.add']) }}', '{{ get_phrase('Add New Expense') }}')" class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add New Expense') }}</span>
                </a>
            </div>
        </div>
    </div>



      {{-- expense manager index --}}

      <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{get_phrase('Expense Managers')}}</p>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Title') }}</th>
                                <th class="">{{ get_phrase('Amount') }}</th>
                                <th class="">{{ get_phrase('Expense Category') }}</th>
                                <th class="">{{ get_phrase('User') }}</th>
                                <th class="">{{ get_phrase('Note') }}</th>
                                <th class="">{{ get_phrase('Date') }}</th>

                                <th class="text-center">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expense_managers as $key => $expense_manager)
                            @php
                                $user_data = App\Models\User::where('id', $expense_manager->user_id)->first();
                                $expense_category = DB::table('expense_categories')->where('id', $expense_manager->expense_category)->first();
                            @endphp
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $expense_manager->title }}
                                    </td>
                                    <td>
                                        {{ $expense_manager->amount }}
                                    </td>
                                    <td>

                                      {{$expense_category->name}}

                                    </td>
                                    <td>
                                        @if($user_data)
                                            {{$user_data->name}}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $expense_manager->note }}
                                    </td>
                                    <td>
                                        {{ date('D, d-M-Y', strtotime($expense_manager->date)) }}
                                    </td>

                                    <td class="text-center">
                                        <a href="#"
                                            onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin.expense_manager.edit', 'id' => $expense_manager->id]) }}', '{{ get_phrase('Edit Expense Manager') }}')"
                                            class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="#" onclick="confirmModal('{{ route('admin.exp.manager.delete', $expense_manager->id) }}')" class="btn btn p-0 px-1"
                                            title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
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
