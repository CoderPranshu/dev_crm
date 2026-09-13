<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>400 — Bad Request | ERP System</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background:#f4f6f9; font-family:"Inter",sans-serif;
      display:flex; align-items:center; justify-content:center; min-height:100vh; padding:20px; }
    .erp-card{
      background:#fff; padding:45px 40px; border-radius:16px;
      box-shadow:0 6px 25px rgba(0,0,0,0.08); max-width:650px; width:100%;
      border:1px solid #e5e7eb; text-align:center;
    }
    .badge-erp{ padding:8px 16px; border-radius:50px; font-weight:600;
      background:rgba(255,193,7,0.15); color:#c78f00; margin-bottom:20px; }
    .error-code{ font-size:90px; font-weight:900; color:#c78f00; margin-bottom:10px; }
    .title{ font-size:28px; font-weight:700; margin-bottom:12px; color:#1e293b; }
    .desc{ color:#6c757d; margin-bottom:25px; }
    .btn-custom{ padding:10px 20px; border-radius:10px; font-weight:600; }
    .info-box{ background:#f8fafc; padding:15px; border-radius:12px;
      border:1px solid #e5e7eb; text-align:left; margin-top:25px; }
  </style>
</head>
<body>

<div class="erp-card">
  <div class="badge-erp">Invalid Request</div>
  <div class="error-code">400</div>
  <div class="title">Bad Request</div>

  <p class="desc">The system couldn't process your request due to invalid input or parameters.<br>
  Please verify your data and try again.</p>

  <div class="d-flex justify-content-center gap-2 flex-wrap">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-custom">Return to Dashboard</a>
    <button onclick="location.reload()" class="btn btn-outline-secondary btn-custom">Retry</button>
  </div>

  <div class="info-box mt-4">
    <strong>Details:</strong><br>
    • Reason: Invalid or malformed request<br>
    • Status: 400-BAD-REQ
  </div>
</div>

</body>
</html>
