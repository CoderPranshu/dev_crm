<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>404 — ERP</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            height: 100vh;
            background: #0f172a;
            color: #fff;
            display: flex;
        }

        /* LEFT SIDE (Visual) */
        .left {
            flex: 1;
            background: radial-gradient(circle at 20% 30%, #6366f1, transparent),
                radial-gradient(circle at 80% 70%, #06b6d4, transparent),
                #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .left::before {
            content: "";
            position: absolute;
            width: 400px;
            height: 400px;
            background: #6366f1;
            filter: blur(120px);
            opacity: 0.3;
            border-radius: 50%;
            top: 10%;
            left: 20%;
        }

        .error-big {
            font-size: 160px;
            font-weight: 900;
            letter-spacing: -5px;
            background: linear-gradient(135deg, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* RIGHT SIDE */
        .right {
            flex: 1;
            background: #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .card {
            max-width: 480px;
            width: 100%;
        }

        .badge {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .desc {
            color: #9ca3af;
            font-size: 15px;
            margin-bottom: 30px;
        }

        /* Buttons */
        .btn {
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            border: 1px solid #374151;
            color: #cbd5f5;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #1f2937;
        }

        /* Search box */
        .search {
            margin-top: 25px;
        }

        .search input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #1f2937;
            color: white;
        }

        /* Footer info */
        .info {
            margin-top: 25px;
            font-size: 13px;
            color: #6b7280;
        }
    </style>
</head>

<body>

    <div class="left">
        <div class="error-big">404</div>
    </div>

    <div class="right">
        <div class="card">

            <div class="badge">ERP SYSTEM</div>

            <div class="title">Page not found</div>

            <div class="desc">
                The page you're looking for doesn’t exist or has been moved.<br>
                Try searching or go back to your dashboard.
            </div>

            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    Go Dashboard
                </a>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    Go Back
                </a>
            </div>

            <!-- Optional Search -->

            <div class="info">
                Error Code: 404 • Resource Missing • ERP System
            </div>

        </div>
    </div>

</body>

</html>
