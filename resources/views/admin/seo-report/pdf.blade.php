<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>SEO Report</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:13px;
            color:#333;
        }

        .header{
            text-align:center;
            border-bottom:2px solid #0d6efd;
            padding-bottom:10px;
            margin-bottom:20px;
        }

        .header h2{
            margin:0;
            color:#0d6efd;
        }

        .info{
            width:100%;
            margin-bottom:20px;
        }

        .info td{
            padding:6px;
            border:1px solid #ddd;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#0d6efd;
            color:#fff;
            padding:8px;
            border:1px solid #ddd;
        }

        table td{
            padding:8px;
            border:1px solid #ddd;
            vertical-align:top;
        }

        .remarks-box{

            margin-top:25px;

            border:1px solid #ddd;

            padding:15px;

            min-height:80px;

        }

        .footer{

            margin-top:40px;

            text-align:right;

        }

        img{

            max-width:120px;

            max-height:80px;

        }

    </style>

</head>

<body>

<div class="header">

    <h2>SEO WORK REPORT</h2>

    <small>Generated On : {{ now()->format('d M Y h:i A') }}</small>

</div>

<table class="info">

    <tr>

        <td width="25%"><strong>Company</strong></td>

        <td>{{ $company->name }}</td>

    </tr>

    <tr>

        <td><strong>Report From</strong></td>

        <td>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</td>

    </tr>

    <tr>

        <td><strong>Report To</strong></td>

        <td>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</td>

    </tr>

</table>

<table>

    <thead>

        <tr>

            <th width="10%">Date</th>

            <th width="10%">Day</th>

            <th width="20%">Task</th>

            <th width="15%">Team</th>

            <th width="20%">Remarks</th>

            <th width="10%">Link</th>

            <th width="15%">Attachment</th>

        </tr>

    </thead>

    <tbody>

    @forelse($works as $work)

        <tr>

            <td>

                {{ \Carbon\Carbon::parse($work->work_date)->format('d-m-Y') }}

            </td>

            <td>

                {{ \Carbon\Carbon::parse($work->work_date)->format('l') }}

            </td>

            <td>

                {{ $work->planTask->task_title ?? '-' }}

            </td>

            <td>

                {{ $work->team->name ?? '-' }}

            </td>

            <td>

                {{ $work->remarks ?? '-' }}

            </td>

            <td>

                @if($work->link)

                    <a href="{{ $work->link }}">

                        {{ $work->link }}

                    </a>

                @else

                    -

                @endif

            </td>

            <td>

                {{-- @if($work->attachment)

                    <img src="{{ public_path('storage/'.$work->attachment) }}">

                @else

                    -

                @endif --}}

                {{-- @if($work->attachment && file_exists(public_path($work->attachment)))

                    <img src="{{ public_path($work->attachment) }}"
                        width="120"
                        height="120">

                @else

                    No Image

                @endif --}}

                {{ file_exists(public_path($work->attachment)) ? 'YES' : 'NO' }}

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="7" align="center">

                No Work Found

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

<div class="remarks-box">

    <strong>Additional Remarks</strong>

    <br><br>

    {{ $reportRemarks }}

</div>

<div class="footer">

    _______________________

    <br>

    SEO Team

</div>

</body>

</html>