@extends('index')

@push('title', 'Create Sub Module')

@push('css')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">


<style>
/* ============================================================
   Code Sparrow — Submodule Creation Workspace
   Fully scoped under .cs-workspace. Bootstrap left untouched
   outside this subtree.
   ============================================================ */

.cs-workspace{
    --cs-primary:#0F7F89;
    --cs-secondary:#18A6B5;
    --cs-accent:#55C8D2;
    --cs-dark:#151A1D;
    --cs-bg:#F5F8FA;
    --cs-white:#FFFFFF;
    --cs-border:#E7EBEF;
    --cs-muted:#8A94A6;

    --cs-low:#9AA5B1;
    --cs-medium:#0F7F89;
    --cs-high:#C2790A;
    --cs-critical:#D64545;

    position:relative;
    min-height:100vh;
    background:
        radial-gradient(720px 420px at 8% -6%, rgba(15,127,137,.07), transparent 60%),
        radial-gradient(620px 420px at 100% 8%, rgba(85,200,210,.08), transparent 55%),
        var(--cs-bg);
    color:var(--cs-dark);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;
    padding-bottom:88px;
}

.cs-workspace *{ box-sizing:border-box; }

.cs-workspace[data-cs-ready="0"] .cs-anim{ opacity:0; }

@media (prefers-reduced-motion:reduce){
    .cs-workspace .cs-anim{ opacity:1 !important; transform:none !important; }
    .cs-workspace *{ animation:none !important; transition:none !important; }
}

@keyframes csPulse{ 0%,100%{opacity:.35;} 50%{opacity:1;} }
@keyframes csSpin{ to{ transform:rotate(360deg); } }
@keyframes csDash{ to{ stroke-dashoffset:0; } }

/* ---------------- Top bar ---------------- */
.cs-topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:20px 32px;
    border-bottom:1px solid var(--cs-border);
    background:rgba(255,255,255,.7);
    backdrop-filter:blur(6px);
    position:sticky;
    top:0;
    z-index:20;
}

.cs-topbar-eyebrow{
    font-size:10.5px;
    font-weight:700;
    letter-spacing:.1em;
    text-transform:uppercase;
    color:var(--cs-primary);
    margin-bottom:3px;
    display:flex;
    align-items:center;
    gap:7px;
}

.cs-topbar-eyebrow i{ font-size:9px; }

.cs-topbar h1{
    font-size:19px;
    font-weight:700;
    margin:0;
    letter-spacing:-.01em;
}

.cs-btn-back{
    display:inline-flex;
    align-items:center;
    gap:8px;
    height:36px;
    padding:0 15px;
    border-radius:8px;
    border:1px solid var(--cs-border);
    background:var(--cs-white);
    color:var(--cs-dark);
    font-size:12.5px;
    font-weight:600;
    text-decoration:none;
    white-space:nowrap;
    transition:border-color .18s ease, color .18s ease, transform .18s ease;
}

.cs-btn-back:hover{
    border-color:var(--cs-primary);
    color:var(--cs-primary);
    transform:translateX(-2px);
    text-decoration:none;
}

/* ---------------- Grid ---------------- */
.cs-grid{
    display:grid;
    grid-template-columns:272px 1fr 296px;
    gap:0;
    align-items:start;
    max-width:1440px;
    margin:0 auto;
}

.cs-col{
    padding:26px 24px;
}

.cs-col-map{
    border-right:1px solid var(--cs-border);
    position:sticky;
    top:73px;
    align-self:start;
    height:calc(100vh - 73px);
    overflow-y:auto;
}

.cs-col-intel{
    border-left:1px solid var(--cs-border);
    position:sticky;
    top:73px;
    align-self:start;
    height:calc(100vh - 73px);
    overflow-y:auto;
}

/* ============================================================
   LEFT — Project / Module Map
   ============================================================ */

.cs-map{
    position:relative;
}

.cs-map-canvas-wrap{
    position:absolute;
    inset:-10px -10px auto -10px;
    height:260px;
    pointer-events:none;
    opacity:.5;
    overflow:hidden;
    border-radius:16px;
}

.cs-map-canvas-wrap canvas{
    display:block;
    width:100% !important;
    height:100% !important;
}

.cs-map-head{
    font-size:10.5px;
    font-weight:700;
    letter-spacing:.09em;
    text-transform:uppercase;
    color:var(--cs-muted);
    margin-bottom:16px;
    position:relative;
    z-index:2;
}

.cs-node-track{
    position:relative;
    z-index:2;
}

.cs-node{
    position:relative;
    display:flex;
    align-items:flex-start;
    gap:10px;
    padding:11px 12px;
    border-radius:10px;
    background:var(--cs-white);
    border:1px solid var(--cs-border);
    margin-bottom:0;
}

.cs-node-icon{
    flex:0 0 auto;
    width:26px;
    height:26px;
    border-radius:7px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    background:rgba(15,127,137,.08);
    color:var(--cs-primary);
}

.cs-node.is-project .cs-node-icon{ background:var(--cs-dark); color:var(--cs-white); }
.cs-node.is-module .cs-node-icon{ background:var(--cs-primary); color:var(--cs-white); }
.cs-node.is-new .cs-node-icon{ background:var(--cs-secondary); color:var(--cs-white); }

.cs-node-label{
    font-size:9.5px;
    font-weight:700;
    letter-spacing:.07em;
    text-transform:uppercase;
    color:var(--cs-muted);
    margin-bottom:2px;
}

.cs-node-title{
    font-size:13px;
    font-weight:700;
    color:var(--cs-dark);
    line-height:1.25;
}

.cs-node-sub{
    font-size:11px;
    color:var(--cs-muted);
    margin-top:2px;
}

.cs-node.is-new{
    border-color:var(--cs-secondary);
    box-shadow:0 0 0 3px rgba(85,200,210,.14);
}

.cs-node.is-new .cs-node-title{ color:var(--cs-secondary); }

/* connector */
.cs-connector{
    width:2px;
    margin-left:23px;
    height:20px;
    background:linear-gradient(var(--cs-border), var(--cs-border));
    position:relative;
    z-index:2;
}

.cs-connector svg{
    display:block;
    height:100%;
    overflow:visible;
}

.cs-connector path{
    stroke:var(--cs-secondary);
    stroke-width:2;
    fill:none;
    stroke-dasharray:24;
    stroke-dashoffset:24;
}

/* existing submodules mini list */
.cs-sub-nodes{
    margin-left:23px;
    padding-left:22px;
    border-left:2px solid var(--cs-border);
    display:flex;
    flex-direction:column;
    gap:8px;
    position:relative;
    z-index:2;
    margin-top:4px;
    margin-bottom:4px;
}

.cs-sub-node{
    display:flex;
    align-items:center;
    gap:9px;
    padding:8px 10px;
    border-radius:8px;
    background:var(--cs-white);
    border:1px solid var(--cs-border);
    font-size:11.5px;
}

.cs-sub-node-idx{
    flex:0 0 auto;
    font-size:10px;
    font-weight:700;
    color:var(--cs-muted);
}

.cs-sub-node-name{
    flex:1 1 auto;
    font-weight:600;
    color:var(--cs-dark);
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    min-width:0;
}

.cs-sub-node-status{
    flex:0 0 auto;
    font-size:9px;
    font-weight:700;
    letter-spacing:.03em;
    text-transform:uppercase;
    padding:3px 7px;
    border-radius:20px;
    background:var(--cs-bg);
    color:var(--cs-muted);
}

.cs-sub-node-status.is-completed{ background:rgba(15,127,137,.1); color:var(--cs-primary); }
.cs-sub-node-status.is-progress{ background:rgba(85,200,210,.16); color:#0B7C87; }
.cs-sub-node-status.is-review{ background:rgba(194,121,10,.1); color:var(--cs-high); }

.cs-map-more{
    font-size:10.5px;
    color:var(--cs-muted);
    margin-left:45px;
    margin-top:-2px;
    margin-bottom:6px;
}

.cs-map-empty{
    margin-left:23px;
    padding-left:22px;
    border-left:2px dashed var(--cs-border);
    font-size:11.5px;
    color:var(--cs-muted);
    padding-top:2px;
    padding-bottom:10px;
    line-height:1.5;
}

.cs-map-count-pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-top:14px;
    margin-left:2px;
    font-size:11px;
    font-weight:700;
    color:var(--cs-muted);
    position:relative;
    z-index:2;
}

.cs-map-count-pill .cs-count-num{
    font-size:15px;
    color:var(--cs-dark);
}

/* ============================================================
   CENTER — Creation Workspace
   ============================================================ */

.cs-col-center{
    padding:26px 40px 40px;
    max-width:760px;
}

.cs-workspace-head{
    margin-bottom:26px;
}

.cs-workspace-head h2{
    font-size:22px;
    font-weight:700;
    margin:0 0 4px;
    letter-spacing:-.01em;
}

.cs-workspace-head p{
    font-size:13px;
    color:var(--cs-muted);
    margin:0;
}

.cs-flow{
    display:flex;
    gap:32px;
    align-items:flex-start;
}

/* stepper rail */
.cs-rail{
    flex:0 0 auto;
    width:150px;
    position:sticky;
    top:110px;
}

.cs-step{
    display:flex;
    align-items:flex-start;
    gap:10px;
    padding:9px 0;
    cursor:pointer;
    text-decoration:none;
    color:inherit;
}

.cs-step-dot{
    flex:0 0 auto;
    width:22px;
    height:22px;
    border-radius:50%;
    border:2px solid var(--cs-border);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:9.5px;
    font-weight:700;
    color:var(--cs-muted);
    background:var(--cs-white);
    transition:border-color .2s ease, background .2s ease, color .2s ease;
}

.cs-step-rule{
    width:2px;
    flex:1;
    min-height:18px;
    background:var(--cs-border);
    margin-left:10px;
}

.cs-step-label{
    font-size:12px;
    font-weight:600;
    color:var(--cs-muted);
    padding-top:2px;
    transition:color .2s ease;
}

.cs-step.is-active .cs-step-dot{
    border-color:var(--cs-primary);
    background:var(--cs-primary);
    color:var(--cs-white);
}

.cs-step.is-active .cs-step-label{ color:var(--cs-dark); }

.cs-step.is-done .cs-step-dot{
    border-color:var(--cs-primary);
    color:var(--cs-primary);
    background:rgba(15,127,137,.08);
}

/* section content */
.cs-sections{
    flex:1 1 auto;
    min-width:0;
}

.cs-section{
    padding-bottom:34px;
    margin-bottom:34px;
    border-bottom:1px solid var(--cs-border);
    scroll-margin-top:100px;
}

.cs-section:last-of-type{ border-bottom:none; margin-bottom:0; }

.cs-section-eyebrow{
    display:flex;
    align-items:baseline;
    gap:10px;
    margin-bottom:4px;
}

.cs-section-num{
    font-size:11px;
    font-weight:800;
    color:var(--cs-primary);
    letter-spacing:.04em;
}

.cs-section-eyebrow h3{
    font-size:14px;
    font-weight:700;
    margin:0;
    letter-spacing:.01em;
}

.cs-section-desc{
    font-size:12px;
    color:var(--cs-muted);
    margin:0 0 18px;
}

/* fields */
.cs-field{ margin-bottom:16px; }
.cs-field:last-child{ margin-bottom:0; }

.cs-field label{
    display:block;
    font-size:12px;
    font-weight:600;
    color:var(--cs-dark);
    margin-bottom:7px;
}

.cs-field label .cs-req{ color:var(--cs-critical); margin-left:2px; }

.cs-field .cs-help{
    font-size:11.5px;
    color:var(--cs-muted);
    margin-top:6px;
}

.cs-workspace .form-control{
    height:44px;
    border-radius:9px;
    border:1px solid var(--cs-border);
    font-size:14px;
    padding:8px 14px;
    background:var(--cs-white);
    box-shadow:none;
    color:var(--cs-dark);
    transition:border-color .18s ease, box-shadow .18s ease;
    width:100%;
}

.cs-workspace .form-control:focus{
    border-color:var(--cs-primary);
    box-shadow:0 0 0 3px rgba(15,127,137,.14);
    outline:none;
}

.cs-workspace textarea.form-control{
    min-height:150px;
    padding-top:12px;
    resize:vertical;
    line-height:1.6;
}

.cs-workspace .invalid-feedback{
    display:block;
    font-size:11.5px;
    margin-top:5px;
    color:var(--cs-critical);
}

.cs-workspace .is-invalid{ border-color:var(--cs-critical) !important; }

.cs-field-primary input{
    height:52px;
    font-size:17px;
    font-weight:600;
    border-width:1.5px;
}

/* priority pills */
.cs-priority-pills{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:8px;
}

.cs-pill{
    border:1px solid var(--cs-border);
    background:var(--cs-white);
    border-radius:10px;
    padding:10px 10px;
    text-align:left;
    cursor:pointer;
    transition:border-color .16s ease, background .16s ease, transform .12s ease;
}

.cs-pill:hover{ transform:translateY(-1px); }

.cs-pill-dot{
    width:8px;
    height:8px;
    border-radius:50%;
    display:inline-block;
    margin-bottom:7px;
}

.cs-pill-label{
    display:block;
    font-size:12px;
    font-weight:700;
    color:var(--cs-dark);
    letter-spacing:.02em;
}

.cs-pill-desc{
    display:block;
    font-size:10px;
    color:var(--cs-muted);
    margin-top:2px;
}

.cs-pill[data-value="Low"] .cs-pill-dot{ background:var(--cs-low); }
.cs-pill[data-value="Medium"] .cs-pill-dot{ background:var(--cs-medium); }
.cs-pill[data-value="High"] .cs-pill-dot{ background:var(--cs-high); }
.cs-pill[data-value="Critical"] .cs-pill-dot{ background:var(--cs-critical); }

.cs-pill.is-selected{
    border-color:var(--cs-primary);
    background:rgba(15,127,137,.06);
    box-shadow:0 0 0 3px rgba(15,127,137,.1);
}

.cs-priority-native{
    position:absolute;
    width:1px;
    height:1px;
    overflow:hidden;
    clip:rect(0 0 0 0);
    white-space:nowrap;
}

/* timeline */
.cs-timeline{
    display:flex;
    align-items:center;
    gap:10px;
    padding:14px 16px;
    background:var(--cs-white);
    border:1px solid var(--cs-border);
    border-radius:11px;
    margin-bottom:18px;
}

.cs-timeline-point{
    display:flex;
    flex-direction:column;
    gap:2px;
    white-space:nowrap;
}

.cs-timeline-point .cs-tl-label{
    font-size:9.5px;
    font-weight:700;
    letter-spacing:.06em;
    text-transform:uppercase;
    color:var(--cs-muted);
    display:flex;
    align-items:center;
    gap:5px;
}

.cs-timeline-point .cs-tl-label i{ color:var(--cs-primary); font-size:10px; }

.cs-timeline-point .cs-tl-date{
    font-size:12.5px;
    font-weight:700;
    color:var(--cs-dark);
}

.cs-timeline-track{
    flex:1;
    position:relative;
    height:2px;
    background:var(--cs-border);
    border-radius:2px;
    min-width:40px;
}

.cs-timeline-track-fill{
    position:absolute;
    inset:0;
    width:0%;
    background:linear-gradient(90deg, var(--cs-primary), var(--cs-accent));
    border-radius:2px;
    transition:width .35s ease;
}

.cs-timeline-hours-pill{
    position:absolute;
    top:-24px;
    left:50%;
    transform:translateX(-50%);
    font-size:10px;
    font-weight:700;
    color:var(--cs-secondary);
    background:var(--cs-white);
    border:1px solid var(--cs-border);
    border-radius:20px;
    padding:2px 9px;
    white-space:nowrap;
}

/* review */
.cs-review-card{
    border:1px solid var(--cs-border);
    border-radius:12px;
    padding:18px 20px;
    background:linear-gradient(180deg, rgba(15,127,137,.04), transparent);
}

.cs-review-title{
    font-size:9.5px;
    font-weight:700;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:var(--cs-muted);
    margin-bottom:6px;
}

.cs-review-name{
    font-size:17px;
    font-weight:700;
    color:var(--cs-dark);
    margin-bottom:14px;
    min-height:24px;
}

.cs-review-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:14px;
}

.cs-review-item span{
    display:block;
}

.cs-review-item .cs-review-label{
    font-size:9.5px;
    font-weight:700;
    letter-spacing:.06em;
    text-transform:uppercase;
    color:var(--cs-muted);
    margin-bottom:3px;
}

.cs-review-item .cs-review-value{
    font-size:13px;
    font-weight:700;
    color:var(--cs-dark);
}

/* ============================================================
   RIGHT — Live Module Intelligence
   ============================================================ */

.cs-intel-head{
    font-size:10.5px;
    font-weight:700;
    letter-spacing:.09em;
    text-transform:uppercase;
    color:var(--cs-muted);
    margin-bottom:16px;
}

.cs-intel-block{
    padding:13px 0;
    border-bottom:1px solid var(--cs-border);
}

.cs-intel-block:last-of-type{ border-bottom:none; }

.cs-intel-label{
    font-size:10px;
    font-weight:700;
    letter-spacing:.06em;
    text-transform:uppercase;
    color:var(--cs-muted);
    margin-bottom:5px;
}

.cs-intel-value{
    font-size:14px;
    font-weight:700;
    color:var(--cs-dark);
}

.cs-intel-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 10px;
    border-radius:20px;
    font-size:10.5px;
    font-weight:700;
    letter-spacing:.02em;
    text-transform:uppercase;
    background:rgba(15,127,137,.08);
    color:var(--cs-primary);
}

.cs-intel-badge.is-low{ background:rgba(154,165,177,.14); color:#67707D; }
.cs-intel-badge.is-medium{ background:rgba(15,127,137,.1); color:var(--cs-primary); }
.cs-intel-badge.is-high{ background:rgba(194,121,10,.1); color:var(--cs-high); }
.cs-intel-badge.is-critical{ background:rgba(214,69,69,.1); color:var(--cs-critical); }

.cs-progress-block{
    display:flex;
    align-items:center;
    gap:14px;
}

.cs-progress-ring{ width:60px; height:60px; flex:0 0 auto; }

.cs-progress-meta .cs-intel-value{ margin-bottom:2px; }
.cs-progress-meta span{ font-size:11px; color:var(--cs-muted); }

/* ============================================================
   Floating action bar
   ============================================================ */

.cs-actionbar{
    position:fixed;
    left:0;
    right:0;
    bottom:0;
    z-index:30;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:14px 32px;
    background:rgba(255,255,255,.85);
    backdrop-filter:blur(8px);
    border-top:1px solid var(--cs-border);
}

.cs-actionbar-status{
    display:flex;
    align-items:center;
    gap:7px;
    font-size:12px;
    color:var(--cs-muted);
    font-weight:600;
}

.cs-actionbar-status .cs-dot-live{
    width:7px;
    height:7px;
    border-radius:50%;
    background:var(--cs-secondary);
    animation:csPulse 1.8s ease-in-out infinite;
}

.cs-actionbar-actions{ display:flex; gap:10px; }

.cs-workspace .btn-cs-light{
    height:42px;
    padding:0 18px;
    border-radius:9px;
    border:1px solid var(--cs-border);
    background:var(--cs-white);
    color:var(--cs-dark);
    font-size:13px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    transition:border-color .18s ease, background .18s ease;
}

.cs-workspace .btn-cs-light:hover{
    border-color:var(--cs-muted);
    background:var(--cs-bg);
    color:var(--cs-dark);
    text-decoration:none;
}

.cs-workspace .btn-cs-primary{
    height:42px;
    padding:0 20px;
    border-radius:9px;
    border:1px solid var(--cs-primary);
    background:var(--cs-primary);
    color:var(--cs-white);
    font-size:13px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:background .18s ease, border-color .18s ease, transform .15s ease, opacity .15s ease;
    cursor:pointer;
}

.cs-workspace .btn-cs-primary:hover{
    background:#0C6B73;
    border-color:#0C6B73;
    transform:translateY(-1px);
}

.cs-workspace .btn-cs-primary:disabled{ opacity:.75; cursor:default; transform:none; }

.cs-btn-spinner{
    width:13px;
    height:13px;
    border-radius:50%;
    border:2px solid rgba(255,255,255,.4);
    border-top-color:var(--cs-white);
    display:none;
    animation:csSpin .7s linear infinite;
}

.cs-workspace .btn-cs-primary.is-loading .cs-btn-spinner{ display:inline-block; }

/* ============================================================
   Empty state (left map, zero submodules)
   ============================================================ */

.cs-map-empty-state{
    display:flex;
    align-items:flex-start;
    gap:9px;
}

.cs-map-empty-state i{
    color:var(--cs-secondary);
    font-size:13px;
    margin-top:1px;
}

/* ============================================================
   Responsive
   ============================================================ */

@media (max-width:1180px){
    .cs-grid{ grid-template-columns:240px 1fr; }
    .cs-col-intel{ display:none; }
    .cs-intel-mobile{ display:block !important; }
}

@media (min-width:1181px){
    .cs-intel-mobile{ display:none; }
}

@media (max-width:900px){
    .cs-grid{ grid-template-columns:1fr; }
    .cs-col-map{
        position:static;
        height:auto;
        border-right:none;
        border-bottom:1px solid var(--cs-border);
    }
    .cs-map-canvas-wrap{ display:none; }
    .cs-col-center{ padding:22px 20px 30px; max-width:none; }
    .cs-flow{ flex-direction:column; gap:20px; }
    .cs-rail{
        width:100%;
        position:static;
        display:flex;
        overflow-x:auto;
        gap:4px;
        padding-bottom:4px;
    }
    .cs-step{ flex-direction:column; align-items:center; gap:6px; padding:4px 10px; }
    .cs-step-rule{ display:none; }
    .cs-step-label{ font-size:10.5px; white-space:nowrap; }
    .cs-priority-pills{ grid-template-columns:repeat(2,1fr); }
    .cs-review-grid{ grid-template-columns:repeat(2,1fr); }
    .cs-topbar{ padding:16px 18px; }
    .cs-actionbar{ padding:12px 18px; flex-direction:column; align-items:stretch; gap:10px; }
    .cs-actionbar-actions{ justify-content:stretch; }
    .cs-actionbar-actions a, .cs-actionbar-actions button{ flex:1; justify-content:center; }
    .cs-intel-mobile-panel{
        border:1px solid var(--cs-border);
        border-radius:12px;
        padding:18px;
        background:var(--cs-white);
        margin-bottom:24px;
    }
}

.main_content{
    padding: 0px;
}
</style>

@endpush

@section('content')

@php
    // Defensive, read-only lookups only. Accessing an undefined Eloquent
    // relationship/attribute returns null instead of throwing, so every
    // block below degrades gracefully instead of fabricating data.
    $csSubmodules   = $module->submodules ?? null;
    $csHasSubs      = $csSubmodules && $csSubmodules->count() > 0;
    $csSubCount     = $csHasSubs ? $csSubmodules->count() : 0;

    $csCompleted    = $csHasSubs
        ? $csSubmodules->filter(function($s){
            return strtolower((string)($s->status ?? '')) === 'completed';
        })->count()
        : 0;

    $csProgress     = $csSubCount > 0 ? (int) round(($csCompleted / $csSubCount) * 100) : null;

    $csModuleStatus   = $module->status ?? null;
    $csModulePriority = $module->priority ?? null;
    $csAssignee       = $module->developer->name ?? ($module->assignee->name ?? null);
@endphp

<div class="cs-workspace" data-cs-ready="0">

    <!-- Top bar -->
    <div class="cs-topbar cs-anim" data-cs-anim="top">
        <div>
            <div class="cs-topbar-eyebrow"><i class="fas fa-diagram-project"></i> Project Engineering Workspace</div>
            <h1>Create Submodule</h1>
        </div>

        <a href="{{ route('admin.modules.show',$module->id) }}" class="cs-btn-back">
            <i class="fas fa-arrow-left"></i>
            Back to Module
        </a>
    </div>

    <div class="cs-grid">

        <!-- ===================== LEFT — Project / Module Map ===================== -->
        <div class="cs-col cs-col-map cs-anim" data-cs-anim="map">

            <div class="cs-map">

                <div class="cs-map-canvas-wrap" id="csMapCanvas"></div>

                <div class="cs-map-head">Project Map</div>

                <div class="cs-node-track">

                    <div class="cs-node is-project">
                        <div class="cs-node-icon"><i class="fas fa-diamond"></i></div>
                        <div>
                            <div class="cs-node-label">Project</div>
                            <div class="cs-node-title">{{ $module->project->project_name ?? 'N/A' }}</div>
                            <div class="cs-node-sub">Project workspace</div>
                        </div>
                    </div>

                    <div class="cs-connector">
                        <svg viewBox="0 0 2 20" preserveAspectRatio="none"><path d="M1,0 L1,20"/></svg>
                    </div>

                    <div class="cs-node is-module">
                        <div class="cs-node-icon"><i class="fas fa-layer-group"></i></div>
                        <div>
                            <div class="cs-node-label">Module</div>
                            <div class="cs-node-title">{{ $module->module_name }}</div>
                            @if($csHasSubs || !is_null($csModuleStatus) || !is_null($csModulePriority))
                                <div class="cs-node-sub">
                                    @if($csHasSubs){{ $csSubCount }} submodule{{ $csSubCount === 1 ? '' : 's' }}@endif
                                    @if($csHasSubs && (!is_null($csModulePriority) || !is_null($csModuleStatus))) &middot; @endif
                                    @if(!is_null($csModulePriority)){{ $csModulePriority }}@endif
                                    @if(!is_null($csModulePriority) && !is_null($csModuleStatus)) &middot; @endif
                                    @if(!is_null($csModuleStatus)){{ $csModuleStatus }}@endif
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($csHasSubs)

                        <div class="cs-connector">
                            <svg viewBox="0 0 2 20" preserveAspectRatio="none"><path d="M1,0 L1,20"/></svg>
                        </div>

                        <div class="cs-sub-nodes">
                            @foreach($csSubmodules->take(4) as $csIndex => $csSub)
                                @php
                                    $csStatusRaw = strtolower((string)($csSub->status ?? 'pending'));
                                    $csStatusClass = match(true){
                                        str_contains($csStatusRaw,'complet') => 'is-completed',
                                        str_contains($csStatusRaw,'progress') => 'is-progress',
                                        str_contains($csStatusRaw,'review') => 'is-review',
                                        default => '',
                                    };
                                @endphp
                                <div class="cs-sub-node">
                                    <span class="cs-sub-node-idx">{{ str_pad($csIndex + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="cs-sub-node-name">{{ $csSub->sub_module_name ?? ('Sub Module #'.$csSub->id) }}</span>
                                    <span class="cs-sub-node-status {{ $csStatusClass }}">{{ $csSub->status ?? 'Pending' }}</span>
                                </div>
                            @endforeach
                        </div>

                        @if($csSubCount > 4)
                            <div class="cs-map-more">+ {{ $csSubCount - 4 }} more</div>
                        @endif

                    @elseif(!is_null($csSubmodules))

                        <div class="cs-connector">
                            <svg viewBox="0 0 2 20" preserveAspectRatio="none"><path d="M1,0 L1,20"/></svg>
                        </div>

                        <div class="cs-map-empty">
                            <div class="cs-map-empty-state">
                                <i class="fas fa-circle-info"></i>
                                <span>No submodules yet — you're creating the first one.</span>
                            </div>
                        </div>

                    @endif

                    <div class="cs-connector">
                        <svg viewBox="0 0 2 20" preserveAspectRatio="none"><path d="M1,0 L1,20"/></svg>
                    </div>

                    <div class="cs-node is-new">
                        <div class="cs-node-icon"><i class="fas fa-plus"></i></div>
                        <div>
                            <div class="cs-node-label">Creating Now</div>
                            <div class="cs-node-title" id="csMapNewName">New Submodule</div>
                            <div class="cs-node-sub">Being added to this module</div>
                        </div>
                    </div>

                </div>

                @if($csHasSubs)
                    <div class="cs-map-count-pill">
                        <span class="cs-count-num">{{ $csSubCount }}</span> existing &middot; +1 being created
                    </div>
                @endif

            </div>

        </div>

        <!-- ===================== CENTER — Creation Workspace ===================== -->
        <div class="cs-col cs-col-center cs-anim" data-cs-anim="center">

            <div class="cs-workspace-head">
                <h2>New Submodule</h2>
                <p>Adding the next work item inside <strong>{{ $module->module_name }}</strong>.</p>
            </div>

            <!-- Mobile-only intelligence panel -->
            <div class="cs-intel-mobile" style="display:none;">
                <div class="cs-intel-mobile-panel">

                    <div class="cs-intel-head">Module Intelligence</div>

                    <div class="cs-intel-block">
                        <div class="cs-intel-label">Project</div>
                        <div class="cs-intel-value">{{ $module->project->project_name ?? 'N/A' }}</div>
                    </div>

                    <div class="cs-intel-block">
                        <div class="cs-intel-label">Module</div>
                        <div class="cs-intel-value">{{ $module->module_name }}</div>
                    </div>

                    @if($csHasSubs)
                        <div class="cs-intel-block">
                            <div class="cs-intel-label">Submodules</div>
                            <div class="cs-intel-value">{{ $csSubCount }}</div>
                        </div>
                    @endif

                    @if(!is_null($csModuleStatus))
                        <div class="cs-intel-block">
                            <div class="cs-intel-label">Status</div>
                            <span class="cs-intel-badge">{{ $csModuleStatus }}</span>
                        </div>
                    @endif

                    @if(!is_null($csModulePriority))
                        @php
                            $csPClassM = match(strtolower((string)$csModulePriority)){
                                'low' => 'is-low', 'high' => 'is-high', 'critical' => 'is-critical', default => 'is-medium',
                            };
                        @endphp
                        <div class="cs-intel-block">
                            <div class="cs-intel-label">Priority</div>
                            <span class="cs-intel-badge {{ $csPClassM }}">{{ $csModulePriority }}</span>
                        </div>
                    @endif

                    @if(!is_null($csAssignee))
                        <div class="cs-intel-block">
                            <div class="cs-intel-label">Assigned To</div>
                            <div class="cs-intel-value">{{ $csAssignee }}</div>
                        </div>
                    @endif

                    @if(!is_null($csProgress))
                        <div class="cs-intel-block">
                            <div class="cs-intel-label">Progress</div>
                            <div class="cs-progress-block">
                                <div id="csProgressRingMobile" class="cs-progress-ring" data-progress="{{ $csProgress }}"></div>
                                <div class="cs-progress-meta">
                                    <div class="cs-intel-value">{{ $csProgress }}%</div>
                                    <span>{{ $csCompleted }} of {{ $csSubCount }} complete</span>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="cs-flow">

                <!-- Step rail -->
                <div class="cs-rail" id="csRail">
                    <a href="#cs-sec-basic" class="cs-step is-active" data-step="basic">
                        <span class="cs-step-dot">01</span>
                        <span class="cs-step-label">Basic Information</span>
                    </a>
                    <div class="cs-step-rule"></div>

                    <a href="#cs-sec-planning" class="cs-step" data-step="planning">
                        <span class="cs-step-dot">02</span>
                        <span class="cs-step-label">Planning &amp; Timeline</span>
                    </a>
                    <div class="cs-step-rule"></div>

                    <a href="#cs-sec-description" class="cs-step" data-step="description">
                        <span class="cs-step-dot">03</span>
                        <span class="cs-step-label">Description</span>
                    </a>
                    <div class="cs-step-rule"></div>

                    <a href="#cs-sec-review" class="cs-step" data-step="review">
                        <span class="cs-step-dot">04</span>
                        <span class="cs-step-label">Review &amp; Create</span>
                    </a>
                </div>

                <!-- Form -->
                <form
                    action="{{ route('submodules.store',$module->id) }}"
                    method="POST"
                    id="csCreateForm"
                    class="cs-sections">

                    @csrf

                    <!-- 01 Basic Information -->
                    <div class="cs-section" id="cs-sec-basic" data-section="basic">
                        <div class="cs-section-eyebrow">
                            <span class="cs-section-num">01</span>
                            <h3>Basic Information</h3>
                        </div>
                        <p class="cs-section-desc">Define what this submodule is responsible for.</p>

                        <div class="cs-field cs-field-primary">
                            <label>Submodule Name <span class="cs-req">*</span></label>
                            <input
                                type="text"
                                name="sub_module_name"
                                id="csNameInput"
                                class="form-control @error('sub_module_name') is-invalid @enderror"
                                value="{{ old('sub_module_name') }}"
                                placeholder='e.g. "User Authentication API"'>
                            @error('sub_module_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="cs-help">Give this submodule a clear and actionable name.</div>
                        </div>

                        <div class="cs-field">
                            <label>Priority</label>

                            <div class="cs-priority-pills" id="csPriorityPills">
                                <button type="button" class="cs-pill" data-value="Low">
                                    <span class="cs-pill-dot"></span>
                                    <span class="cs-pill-label">Low</span>
                                    <span class="cs-pill-desc">Routine work</span>
                                </button>
                                <button type="button" class="cs-pill is-selected" data-value="Medium">
                                    <span class="cs-pill-dot"></span>
                                    <span class="cs-pill-label">Medium</span>
                                    <span class="cs-pill-desc">Normal priority</span>
                                </button>
                                <button type="button" class="cs-pill" data-value="High">
                                    <span class="cs-pill-dot"></span>
                                    <span class="cs-pill-label">High</span>
                                    <span class="cs-pill-desc">Important</span>
                                </button>
                                <button type="button" class="cs-pill" data-value="Critical">
                                    <span class="cs-pill-dot"></span>
                                    <span class="cs-pill-label">Critical</span>
                                    <span class="cs-pill-desc">Urgent</span>
                                </button>
                            </div>

                            <select name="priority" id="csPrioritySelect" class="cs-priority-native" aria-hidden="true" tabindex="-1">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>
                    </div>

                    <!-- 02 Planning & Timeline -->
                    <div class="cs-section" id="cs-sec-planning" data-section="planning">
                        <div class="cs-section-eyebrow">
                            <span class="cs-section-num">02</span>
                            <h3>Planning &amp; Timeline</h3>
                        </div>
                        <p class="cs-section-desc">Set the effort estimate and schedule.</p>

                        <div class="cs-timeline">
                            <div class="cs-timeline-point">
                                <span class="cs-tl-label"><i class="fas fa-calendar"></i> Start</span>
                                <span class="cs-tl-date" id="csStartLabel">—</span>
                            </div>
                            <div class="cs-timeline-track">
                                <div class="cs-timeline-hours-pill" id="csHoursPill">0h</div>
                                <div class="cs-timeline-track-fill" id="csTrackFill"></div>
                            </div>
                            <div class="cs-timeline-point">
                                <span class="cs-tl-label"><i class="fas fa-flag"></i> Deadline</span>
                                <span class="cs-tl-date" id="csDeadlineLabel">—</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="cs-field">
                                    <label><i class="fas fa-clock"></i> Estimated Hours</label>
                                    <input
                                        type="number"
                                        step="0.5"
                                        min="0"
                                        name="estimated_hours"
                                        id="csHoursInput"
                                        class="form-control"
                                        value="{{ old('estimated_hours',0) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="cs-field">
                                    <label><i class="fas fa-calendar"></i> Start Date</label>
                                    <input type="date" name="start_date" id="csStartDate" class="form-control" value="{{ old('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="cs-field">
                                    <label><i class="fas fa-flag"></i> Deadline</label>
                                    <input type="date" name="deadline" id="csDeadlineDate" class="form-control" value="{{ old('deadline') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 03 Description -->
                    <div class="cs-section" id="cs-sec-description" data-section="description">
                        <div class="cs-section-eyebrow">
                            <span class="cs-section-num">03</span>
                            <h3>Description</h3>
                        </div>
                        <p class="cs-section-desc">Explain the scope and expectations.</p>

                        <div class="cs-field">
                            <textarea
                                name="description"
                                id="csDescInput"
                                rows="6"
                                class="form-control"
                                placeholder="Write Sub Module Description...">{{ old('description') }}</textarea>
                            <div class="cs-help">Describe what this submodule should accomplish, including important implementation details or acceptance expectations.</div>
                        </div>
                    </div>

                    <!-- 04 Review -->
                    <div class="cs-section" id="cs-sec-review" data-section="review">
                        <div class="cs-section-eyebrow">
                            <span class="cs-section-num">04</span>
                            <h3>Review &amp; Create</h3>
                        </div>
                        <p class="cs-section-desc">Confirm the details before adding this submodule.</p>

                        <div class="cs-review-card">
                            <div class="cs-review-title">New Submodule</div>
                            <div class="cs-review-name" id="csReviewName">Untitled submodule</div>

                            <div class="cs-review-grid">
                                <div class="cs-review-item">
                                    <span class="cs-review-label">Priority</span>
                                    <span class="cs-review-value" id="csReviewPriority">Medium</span>
                                </div>
                                <div class="cs-review-item">
                                    <span class="cs-review-label">Estimated</span>
                                    <span class="cs-review-value" id="csReviewHours">0 hours</span>
                                </div>
                                <div class="cs-review-item">
                                    <span class="cs-review-label">Schedule</span>
                                    <span class="cs-review-value" id="csReviewSchedule">—</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <!-- ===================== RIGHT — Live Module Intelligence ===================== -->
        <div class="cs-col cs-col-intel cs-anim" data-cs-anim="intel">

            <div class="cs-intel-head">Module Intelligence</div>

            <div class="cs-intel-block">
                <div class="cs-intel-label">Project</div>
                <div class="cs-intel-value">{{ $module->project->project_name ?? 'N/A' }}</div>
            </div>

            <div class="cs-intel-block">
                <div class="cs-intel-label">Module</div>
                <div class="cs-intel-value">{{ $module->module_name }}</div>
            </div>

            @if($csHasSubs)
                <div class="cs-intel-block">
                    <div class="cs-intel-label">Submodules</div>
                    <div class="cs-intel-value">{{ $csSubCount }}</div>
                </div>
            @endif

            @if(!is_null($csModuleStatus))
                <div class="cs-intel-block">
                    <div class="cs-intel-label">Status</div>
                    <span class="cs-intel-badge">{{ $csModuleStatus }}</span>
                </div>
            @endif

            @if(!is_null($csModulePriority))
                @php
                    $csPClass = match(strtolower((string)$csModulePriority)){
                        'low' => 'is-low', 'high' => 'is-high', 'critical' => 'is-critical', default => 'is-medium',
                    };
                @endphp
                <div class="cs-intel-block">
                    <div class="cs-intel-label">Priority</div>
                    <span class="cs-intel-badge {{ $csPClass }}">{{ $csModulePriority }}</span>
                </div>
            @endif

            @if(!is_null($csAssignee))
                <div class="cs-intel-block">
                    <div class="cs-intel-label">Assigned To</div>
                    <div class="cs-intel-value">{{ $csAssignee }}</div>
                </div>
            @endif

            @if(!is_null($csProgress))
                <div class="cs-intel-block">
                    <div class="cs-intel-label">Progress</div>
                    <div class="cs-progress-block">
                        <div id="csProgressRing" class="cs-progress-ring" data-progress="{{ $csProgress }}"></div>
                        <div class="cs-progress-meta">
                            <div class="cs-intel-value">{{ $csProgress }}%</div>
                            <span>{{ $csCompleted }} of {{ $csSubCount }} complete</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>

    <!-- Floating action bar -->
    <div class="cs-actionbar">
        <div class="cs-actionbar-status">
            <span class="cs-dot-live"></span>
            Draft &middot; Unsaved
        </div>
        <div class="cs-actionbar-actions">
            <a href="{{ route('admin.modules.show',$module->id) }}" class="btn-cs-light">Cancel</a>
            <button type="submit" form="csCreateForm" id="csSubmitBtn" class="btn-cs-primary">
                <span class="cs-btn-spinner"></span>
                <span class="cs-btn-label">Create Submodule</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<script>
(function(){
    var root = document.querySelector('.cs-workspace');
    if(!root) return;

    var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var hasGsap = typeof gsap !== 'undefined';

    /* ---------------- Entrance animation ---------------- */
    var anims = root.querySelectorAll('[data-cs-anim]');
    if(prefersReduced || !hasGsap){
        root.setAttribute('data-cs-ready','1');
        anims.forEach(function(el){ el.style.opacity = 1; });
    } else {
        gsap.set(anims, { opacity:0, y:12 });
        root.setAttribute('data-cs-ready','1');
        gsap.to(anims, { opacity:1, y:0, duration:.5, ease:'power3.out', stagger:.07 });

        var connectorPaths = root.querySelectorAll('.cs-connector path');
        if(connectorPaths.length){
            gsap.fromTo(connectorPaths,
                { strokeDashoffset:24 },
                { strokeDashoffset:0, duration:.5, ease:'power2.out', stagger:.06, delay:.15 }
            );
        }

        var subNodes = root.querySelectorAll('.cs-sub-node');
        if(subNodes.length){
            gsap.fromTo(subNodes,
                { opacity:0, x:-8 },
                { opacity:1, x:0, duration:.4, ease:'power2.out', stagger:.05, delay:.25 }
            );
        }
    }

    /* ---------------- Priority pills <-> real select ---------------- */
    var pills = root.querySelectorAll('.cs-pill');
    var nativeSelect = document.getElementById('csPrioritySelect');

    function selectPill(value, animate){
        pills.forEach(function(p){
            var active = p.getAttribute('data-value') === value;
            p.classList.toggle('is-selected', active);
            if(active && animate && hasGsap && !prefersReduced){
                gsap.fromTo(p, { scale:.96 }, { scale:1, duration:.25, ease:'power2.out' });
            }
        });
        if(nativeSelect) nativeSelect.value = value;
        syncReview();
    }

    pills.forEach(function(p){
        p.addEventListener('click', function(){
            selectPill(p.getAttribute('data-value'), true);
        });
    });

    /* ---------------- Stepper: active state via scroll ---------------- */
    var steps = root.querySelectorAll('.cs-step');
    var sections = root.querySelectorAll('.cs-section');

    steps.forEach(function(step){
        step.addEventListener('click', function(e){
            e.preventDefault();
            var target = document.querySelector(step.getAttribute('href'));
            if(target){
                target.scrollIntoView({ behavior: prefersReduced ? 'auto' : 'smooth', block:'start' });
            }
        });
    });

    function setActiveStep(name, markDoneBefore){
        var seenActive = false;
        steps.forEach(function(step){
            var isThis = step.getAttribute('data-step') === name;
            step.classList.toggle('is-active', isThis);
            if(isThis){ seenActive = true; }
            if(!isThis){
                step.classList.toggle('is-done', markDoneBefore && !seenActive);
            }
        });
    }

    if('IntersectionObserver' in window && sections.length){
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
                if(entry.isIntersecting){
                    setActiveStep(entry.target.getAttribute('data-section'), true);
                }
            });
        }, { rootMargin:'-35% 0px -55% 0px', threshold:0 });

        sections.forEach(function(sec){ io.observe(sec); });
    }

    /* ---------------- Timeline + review live sync ---------------- */
    var startInput = document.getElementById('csStartDate');
    var deadlineInput = document.getElementById('csDeadlineDate');
    var hoursInput = document.getElementById('csHoursInput');
    var startLabel = document.getElementById('csStartLabel');
    var deadlineLabel = document.getElementById('csDeadlineLabel');
    var hoursPill = document.getElementById('csHoursPill');
    var trackFill = document.getElementById('csTrackFill');
    var nameInput = document.getElementById('csNameInput');
    var descInput = document.getElementById('csDescInput');

    var reviewName = document.getElementById('csReviewName');
    var reviewPriority = document.getElementById('csReviewPriority');
    var reviewHours = document.getElementById('csReviewHours');
    var reviewSchedule = document.getElementById('csReviewSchedule');
    var mapNewName = document.getElementById('csMapNewName');

    function formatDate(value){
        if(!value) return '';
        var d = new Date(value + 'T00:00:00');
        if(isNaN(d.getTime())) return '';
        return d.toLocaleDateString(undefined, { month:'short', day:'numeric' });
    }

    function syncTimeline(){
        var sv = startInput ? startInput.value : '';
        var dv = deadlineInput ? deadlineInput.value : '';
        var hv = hoursInput ? parseFloat(hoursInput.value || '0') : 0;

        if(startLabel) startLabel.textContent = formatDate(sv) || '—';
        if(deadlineLabel) deadlineLabel.textContent = formatDate(dv) || '—';
        if(hoursPill) hoursPill.textContent = (isNaN(hv) ? 0 : hv) + 'h';

        var fillPct = (sv && dv) ? 100 : (sv || dv) ? 45 : 0;
        if(trackFill){
            if(hasGsap && !prefersReduced){
                gsap.to(trackFill, { width: fillPct + '%', duration:.4, ease:'power2.out' });
            } else {
                trackFill.style.width = fillPct + '%';
            }
        }
    }

    function syncReview(){
        if(reviewName) reviewName.textContent = (nameInput && nameInput.value.trim()) || 'Untitled submodule';
        if(reviewPriority && nativeSelect) reviewPriority.textContent = nativeSelect.value;
        if(reviewHours && hoursInput){
            var hv = parseFloat(hoursInput.value || '0');
            reviewHours.textContent = (isNaN(hv) ? 0 : hv) + (hv === 1 ? ' hour' : ' hours');
        }
        if(reviewSchedule){
            var sv = startInput ? formatDate(startInput.value) : '';
            var dv = deadlineInput ? formatDate(deadlineInput.value) : '';
            reviewSchedule.textContent = (sv || dv) ? ((sv || '—') + ' → ' + (dv || '—')) : '—';
        }
        if(mapNewName){
            mapNewName.textContent = (nameInput && nameInput.value.trim()) || 'New Submodule';
        }
    }

    [startInput, deadlineInput, hoursInput].forEach(function(el){
        if(el){
            el.addEventListener('input', function(){ syncTimeline(); syncReview(); });
            el.addEventListener('change', function(){ syncTimeline(); syncReview(); });
        }
    });
    if(nameInput) nameInput.addEventListener('input', syncReview);

    syncTimeline();
    syncReview();

    /* ---------------- Submit loading state ---------------- */
    var form = document.getElementById('csCreateForm');
    var submitBtn = document.getElementById('csSubmitBtn');
    if(form && submitBtn){
        form.addEventListener('submit', function(){
            submitBtn.classList.add('is-loading');
            submitBtn.disabled = true;
        });
    }

    /* ---------------- Progress rings (ApexCharts, real data only) ---------------- */
    function renderRing(id){
        var el = document.getElementById(id);
        if(!el || typeof ApexCharts === 'undefined') return;
        var progress = parseInt(el.getAttribute('data-progress'), 10) || 0;
        new ApexCharts(el, {
            chart: { type:'radialBar', width:60, height:60, sparkline:{ enabled:true } },
            series:[progress],
            colors:['#0F7F89'],
            plotOptions:{
                radialBar:{
                    hollow:{ size:'52%' },
                    track:{ background:'#E7EBEF' },
                    dataLabels:{
                        show:true,
                        name:{ show:false },
                        value:{ show:true, fontSize:'10px', fontWeight:700, offsetY:4, formatter:function(v){ return v + '%'; } }
                    }
                }
            }
        }).render();
    }
    renderRing('csProgressRing');
    renderRing('csProgressRingMobile');

    /* ---------------- Subtle Three.js architecture visualization ---------------- */
    var mapCanvasWrap = document.getElementById('csMapCanvas');
    if(mapCanvasWrap && !prefersReduced && typeof THREE !== 'undefined' && window.innerWidth > 900){
        try{
            var width = mapCanvasWrap.clientWidth || 260;
            var height = mapCanvasWrap.clientHeight || 260;

            var scene = new THREE.Scene();
            var camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 100);
            camera.position.z = 9;

            var renderer = new THREE.WebGLRenderer({ alpha:true, antialias:true });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
            mapCanvasWrap.appendChild(renderer.domElement);
            renderer.domElement.style.pointerEvents = 'none';

            var group = new THREE.Group();
            scene.add(group);

            var nodeCount = 16;
            var nodePositions = [];
            var nodeGeo = new THREE.SphereGeometry(0.045, 8, 8);
            var nodeMat = new THREE.MeshBasicMaterial({ color:0x55C8D2, transparent:true, opacity:.55 });

            for(var i = 0; i < nodeCount; i++){
                var x = (Math.random() - 0.5) * 8;
                var y = (Math.random() - 0.5) * 5;
                var z = (Math.random() - 0.5) * 4;
                nodePositions.push(new THREE.Vector3(x, y, z));
                var mesh = new THREE.Mesh(nodeGeo, nodeMat);
                mesh.position.set(x, y, z);
                group.add(mesh);
            }

            var lineMat = new THREE.LineBasicMaterial({ color:0x0F7F89, transparent:true, opacity:.18 });
            for(var a = 0; a < nodePositions.length; a++){
                for(var b = a + 1; b < nodePositions.length; b++){
                    if(nodePositions[a].distanceTo(nodePositions[b]) < 2.6){
                        var lineGeo = new THREE.BufferGeometry().setFromPoints([nodePositions[a], nodePositions[b]]);
                        group.add(new THREE.Line(lineGeo, lineMat));
                    }
                }
            }

            var frameId;
            function animate(){
                frameId = requestAnimationFrame(animate);
                group.rotation.y += 0.0009;
                group.rotation.x += 0.0003;
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', function(){
                if(window.innerWidth <= 900){
                    cancelAnimationFrame(frameId);
                    if(renderer.domElement.parentNode) renderer.domElement.parentNode.removeChild(renderer.domElement);
                    return;
                }
                var w = mapCanvasWrap.clientWidth || 260;
                var h = mapCanvasWrap.clientHeight || 260;
                camera.aspect = w / h;
                camera.updateProjectionMatrix();
                renderer.setSize(w, h);
            });
        } catch(e){
            /* Three.js failed to initialize — the UI works fully without it. */
        }
    }
})();
</script>

@endsection