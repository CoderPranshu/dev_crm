@extends('index')

@push('title', get_phrase('Assign SEO Team Task'))

@section('content')

<div class="mainSection-title">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h4>{{ get_phrase('Assign SEO Team Task') }}</h4>
        </div>

        <div>
            <a href="{{ route('admin.seo-team-tasks.index') }}" class="btn btn-secondary">
                <i class="fi-rr-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
</div>

<div class="eSection-wrap">

<form action="{{ route('admin.seo-team-tasks.store') }}" method="POST">
@csrf

<div class="row">

    <!-- Client -->

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Client <span class="text-danger">*</span>
        </label>

        <select name="seo_plan_client_id"
                id="seo_plan_client_id"
                class="form-select"
                required>

            <option value="">Select Client</option>

            @foreach($clients as $client)

                <option value="{{ $client->id }}">
                    {{ $client->company->name ?? '-' }}
                    -
                    {{ $client->seoPlan->name ?? '-' }}
                </option>

            @endforeach

        </select>

    </div>


    <!-- Team Name -->

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Team Name <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="team_name"
               class="form-control"
               placeholder="Enter Team Name"
               required>

    </div>

</div>

<hr>

<h5>Weekly Tasks</h5>

<div id="taskContainer">

<div class="alert alert-info">

Please select client first.

</div>

</div>

<div class="mt-4">

<button class="btn btn-primary">

<i class="fi-rr-disk"></i>

Save

</button>

<a href="{{ route('admin.seo-team-tasks.index') }}"
class="btn btn-light">

Cancel

</a>

</div>

</form>

</div>

@endsection


@push('js')

<script>

$(document).ready(function(){

$("#seo_plan_client_id").change(function(){

    let id=$(this).val();

    if(id=="")
    {
        $("#taskContainer").html('<div class="alert alert-info">Please select client first.</div>');
        return;
    }

    $.ajax({

        url:"{{ url('admin/seo-team-tasks/get-tasks') }}/"+id,
        type:"GET",

        success:function(response){

            let html='';

            if(response.length==0){

                html='<div class="alert alert-danger">No Weekly Tasks Found.</div>';

            }else{

                $.each(response,function(index,row){

                    html+=`

                    <div class="card mb-3">

                        <div class="card-header">

                            <strong>${row.day.toUpperCase()}</strong>

                        </div>

                        <div class="card-body">

                            <label class="d-block">

                                <input type="checkbox"
                                       name="week_days[]"
                                       value="${row.day}"
                                       checked>

                                ${row.task_title}

                            </label>

                        </div>

                    </div>

                    `;

                });

            }

            $("#taskContainer").html(html);

        }

    });

});

});

</script>

@endpush