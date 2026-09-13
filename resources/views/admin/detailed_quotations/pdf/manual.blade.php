<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>{{ $proposalName }}</title>

    <style>
        @page {
            margin: 35px 40px;
        }

        body {
            margin: 0;
            color: #17202a;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.65;
        }

        .proposal-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #f12617;
        }

        .proposal-header h1 {
            margin: 0;
            color: #087fba;
            font-size: 25px;
        }

        .proposal-meta {
            margin-bottom: 25px;
            padding: 14px;
            border: 1px solid #bfe7f7;
            background: #eaf7fd;
        }

        .proposal-meta p {
            margin: 3px 0;
        }

        .proposal-content {
            overflow-wrap: break-word;
        }

        .proposal-content h1,
        .proposal-content h2 {
            color: #087fba;
        }

        .proposal-content p {
            margin: 0 0 11px;
        }

        .proposal-content table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }

        .proposal-content th,
        .proposal-content td {
            padding: 8px;
            border: 1px solid #dfe7ec;
            text-align: left;
        }

        .proposal-content th {
            background: #eaf7fd;
        }

        .proposal-content img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <div class="proposal-header">
        <h1>{{ $proposalName }}</h1>
    </div>

    <div class="proposal-meta">
        @if(isset($category) && $category)
            <p>
                <strong>Category:</strong>
                {{ $category->name }}
            </p>
        @endif

        <p>
            <strong>Price:</strong>
            ₹{{ number_format((float) $price, 2) }}
        </p>
    </div>

    <div class="proposal-content">
        {!! $content !!}
    </div>

</body>
</html>




