<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>500 — Server Error | ERP</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

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

/* LEFT SIDE */
.left {
  flex: 1;
  background: radial-gradient(circle at 30% 30%, #f59e0b, transparent),
              radial-gradient(circle at 70% 70%, #f97316, transparent),
              #0f172a;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.left::before {
  content: "";
  position: absolute;
  width: 400px;
  height: 400px;
  background: #f97316;
  filter: blur(120px);
  opacity: 0.25;
  border-radius: 50%;
}

.error-big {
  font-size: 150px;
  font-weight: 900;
  letter-spacing: -5px;
  background: linear-gradient(135deg, #fff, #fdba74);
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
  max-width: 500px;
  width: 100%;
}

.badge {
  background: rgba(245,158,11,0.15);
  color: #fbbf24;
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
  margin-bottom: 25px;
}

/* Alert Box */
.alert-box {
  background: rgba(245,158,11,0.1);
  border: 1px solid rgba(245,158,11,0.2);
  padding: 12px;
  border-radius: 10px;
  font-size: 14px;
  color: #fcd34d;
  margin-bottom: 25px;
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
  background: linear-gradient(135deg, #f59e0b, #f97316);
  color: #fff;
  box-shadow: 0 10px 25px rgba(245,158,11,0.3);
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

/* Loader Animation */
.loader {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(255,255,255,0.1);
  border-top: 4px solid #f59e0b;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 20px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
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
  <div class="error-big">500</div>
</div>

<div class="right">
  <div class="card">

    <div class="loader"></div>

    <div class="badge">SYSTEM ERROR</div>

    <div class="title">Something went wrong</div>

    <div class="desc">
      We're experiencing a temporary issue on our server.<br>
      Our system is working to fix this automatically.
    </div>

    <div class="alert-box">
      ⚠️ This is not your fault. Please try again or contact support if the issue persists.
    </div>

    <div>
      <a href="javascript:location.reload()" class="btn btn-primary">
        Retry
      </a>

      <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
        Go Dashboard
      </a>
    </div>

    <div class="info">
      Error Code: 500 • Internal Server Error • ERP System<br>
      Ref ID: {{ uniqid('ERR-') }}
    </div>

  </div>
</div>

</body>
</html>
