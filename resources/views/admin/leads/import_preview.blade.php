<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Lead Import Preview</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 15px;
            font-family: Arial, sans-serif;
            background: #ffffff;
            color: #333;
        }

        .preview-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 12px;
        }

        .preview-title {
            font-size: 15px;
            font-weight: 600;
        }

        .preview-info {
            font-size: 12px;
            color: #666;
        }

        .table-wrapper {
            width: 100%;
            overflow: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        table {
            width: 100%;
            min-width: max-content;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead th {
            position: sticky;
            top: 0;
            background: #f4f5f7;
            z-index: 2;
            font-weight: 600;
        }

        th,
        td {
            padding: 9px 12px;
            border-right: 1px solid #e5e5e5;
            border-bottom: 1px solid #e5e5e5;
            text-align: left;
            white-space: nowrap;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th:last-child,
        td:last-child {
            border-right: none;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        .row-number {
            width: 50px;
            text-align: center;
            background: #fafafa;
            color: #777;
        }

        .preview-note {
            margin-top: 10px;
            font-size: 12px;
            color: #777;
        }

        .empty {
            padding: 30px;
            text-align: center;
            color: #777;
        }

    </style>

</head>


<body>


<div class="preview-header">

    <div>

        <div class="preview-title">
            Uploaded File Preview
        </div>

        <div class="preview-info">
            {{ $fileName }}
        </div>

    </div>


    <div class="preview-info">

        Total Rows:
        <strong>{{ $totalRows }}</strong>

    </div>

</div>


@if(count($previewRows) > 0)

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th class="row-number">
                        #
                    </th>

                    @foreach($headers as $header)

                        <th>
                            {{ $header !== '' ? $header : 'Unnamed Column' }}
                        </th>

                    @endforeach

                </tr>

            </thead>


            <tbody>

                @foreach($previewRows as $rowIndex => $row)

                    <tr>

                        <td class="row-number">
                            {{ $rowIndex + 1 }}
                        </td>


                        @foreach($headers as $columnIndex => $header)

                            <td
                                title="{{ (string) ($row[$columnIndex] ?? '') }}"
                            >
                                {{ $row[$columnIndex] ?? '' }}
                            </td>

                        @endforeach

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>


    <div class="preview-note">

        Showing first
        <strong>{{ min(30, $totalRows) }}</strong>
        of
        <strong>{{ $totalRows }}</strong>
        data rows.

    </div>

@else

    <div class="empty">
        No data rows found in this file.
    </div>

@endif


</body>
</html>

