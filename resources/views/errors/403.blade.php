<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>403 — Access Denied | ERP</title>

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
  background: radial-gradient(circle at 30% 30%, #ef4444, transparent),
              radial-gradient(circle at 70% 70%, #f59e0b, transparent),
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
  background: #ef4444;
  filter: blur(120px);
  opacity: 0.25;
  border-radius: 50%;
}

.error-big {
  font-size: 150px;
  font-weight: 900;
  letter-spacing: -5px;
  background: linear-gradient(135deg, #fff, #fca5a5);
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
  background: rgba(239,68,68,0.15);
  color: #f87171;
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
  background: rgba(239,68,68,0.1);
  border: 1px solid rgba(239,68,68,0.2);
  padding: 12px;
  border-radius: 10px;
  font-size: 14px;
  color: #fca5a5;
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
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: #fff;
  box-shadow: 0 10px 25px rgba(239,68,68,0.3);
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
  <div class="error-big">403</div>
</div>

<div class="right">
  <div class="card">

    <div class="badge">ACCESS RESTRICTED</div>

    <div class="title">Permission Denied</div>

    <div class="desc">
      You do not have permission to access this resource.<br>
      This action is restricted based on your role or access level.
    </div>

    <div class="alert-box">
      🚫 You are not authorized to view this module or perform this action.
    </div>

    <div>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
        Go Dashboard
      </a>

      <a href="javascript:history.back()" class="btn btn-secondary">
        Go Back
      </a>
    </div>

    <div class="info">
      Error Code: 403 • Forbidden • Access Control Enabled
    </div>

  </div>
</div>

</body>
</html>
