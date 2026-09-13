@php
    $task_type = isset($_GET['task_type']) ? $_GET['task_type'] : 'daily';
@endphp

<ul class="nav nav-tabs eNav-Tabs-custom p-0" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($task_type == 'daily') active @endif" onclick="redirectTo('{{ route('admin.staff.profile',['tab' => 'task', 'user_id' => $user->id, 'task_type' => 'daily']) }}')">
            {{get_phrase('Daily')}}
            <span></span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($task_type == 'weekly') active @endif" onclick="redirectTo('{{ route('admin.staff.profile',['tab' => 'task', 'user_id' => $user->id, 'task_type' => 'weekly']) }}')">
            {{get_phrase('Weekly')}}
            <span></span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($task_type == 'monthly') active @endif" onclick="redirectTo('{{ route('admin.staff.profile',['tab' => 'task', 'user_id' => $user->id, 'task_type' => 'monthly']) }}')">
            {{get_phrase('monthly')}}
            <span></span>
        </button>
    </li>
</ul>
<div class="tab-content eNav-Tabs-content profile-tab-content p-0" id="kra-container">

    @php
        if ($task_type == 'daily') {
            $kras = App\Models\Kra::where('department_id', $user->department)
                ->where('time', 'daily')
                ->orderBy('created_at')
                ->get();
        } elseif ($task_type == 'weekly') {
            $kras = App\Models\Kra::where('department_id', $user->department)
                ->where('time', 'weekly')
                ->orderBy('created_at')
                ->get();
        } else {
            $kras = App\Models\Kra::where('department_id', $user->department)
                ->where('time', 'monthly')
                ->orderBy('created_at')
                ->get();
        }
    @endphp

    <ul class="task-list sortable" id="user-task-list{{ $user->id }}">
        @foreach ($kras as $sorting_positions => $kra)
            @include('admin.staff.tasks')
        @endforeach
    </ul>

</div>


<script>
    "use strict";

    $(function() {
        $('#user-task-list{{ $user->id }}').sortable({
            axis: "y",
            start: function(event, ui) {},
            change: function(event, ui) {},
            update: function(event, ui) {
                let item_id = ui.item.attr('id');
                let sort_value = '';
                $.each($('#user-task-list{{ $user->id }} .sorting_values'), function(index, value) {
                    sort_value = sort_value + $(value).val() + ',';
                });
                console.log(sort_value);
                $.ajax({
                    type: 'post',
                    url: "{{ route('admin.task.sort') }}",
                    data: {
                        sort_value: sort_value
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        distributeServerResponse(response);
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }
        });
    });

    var time = 0;

    function setTimeoutAwait(e) {
        clearTimeout(time);
        time = setTimeout(() => {
            $(e).parent().submit();
        }, 1000);
    }

    function tab_toggle(e) {
        $('.expand-btn').removeClass('d-hidden');
        $('.collapse-btn').removeClass('d-hidden');
        $('.accordion-button').removeClass('collapsed');
        $('.accordion-collapse').removeClass('show');

        if ($(e).hasClass('expand-btn')) {
            $('.accordion-button').addClass('collapsed');
            $('.accordion-collapse').addClass('show');
            $(e).addClass('d-hidden');
        } else {
            $('.collapse-btn').addClass('d-hidden');
        }

    }

    function taskExpandToggler(taskId) {
        let taskArea = document.querySelector('#task-list' + taskId + ' textarea');
        let scrollHeight = taskArea.scrollHeight;
        let outerHeight = $('#task-list' + taskId + ' textarea').outerHeight();
        if (outerHeight <= 35) {
            taskArea.style.height = scrollHeight + 'px';
        } else {
            taskArea.style.height = '32px';
        }
    }
</script>
