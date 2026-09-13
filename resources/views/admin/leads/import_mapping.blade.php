@extends('index')

@section('content')

<style>
.lead-map-studio {
    --lms-bg: #0b1017;
    --lms-bg-2: #0f151e;
    --lms-panel: #141b25;
    --lms-panel-2: #18212d;
    --lms-panel-3: #1e2937;
    --lms-line: #263244;
    --lms-line-soft: rgba(142, 160, 184, .14);
    --lms-text: #eef3f9;
    --lms-muted: #9aa8ba;
    --lms-muted-2: #6e7b8d;
    --lms-primary: #6672ff;
    --lms-primary-soft: rgba(102, 114, 255, .16);
    --lms-success: #2fd49a;
    --lms-success-soft: rgba(47, 212, 154, .14);
    --lms-warning: #f5b84c;
    --lms-warning-soft: rgba(245, 184, 76, .14);
    --lms-danger: #ff6476;
    --lms-danger-soft: rgba(255, 100, 118, .14);
    --lms-shadow: 0 18px 50px rgba(0,0,0,.28);

    position: relative;
    isolation: isolate;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.04);
    border-radius: 18px;
    background:
        radial-gradient(circle at 18% 0%, rgba(102,114,255,.08), transparent 28%),
        radial-gradient(circle at 92% 12%, rgba(47,212,154,.05), transparent 24%),
        var(--lms-bg);
    color: var(--lms-text);
    min-height: 760px;
    box-shadow: var(--lms-shadow);
}

.lead-map-studio * { box-sizing: border-box; }

.lead-map-studio::before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    opacity: .5;
    background-image:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 28px 28px;
    mask-image: linear-gradient(to bottom, #000 0%, rgba(0,0,0,.75) 48%, transparent 90%);
}

.lms-form { position: relative; z-index: 2; }

/* Notifications */
.lms-notifications {
    display: grid;
    gap: 10px;
    padding: 14px 18px 0;
}

.lms-notice {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    padding: 12px 14px;
    border: 1px solid var(--lms-line);
    border-radius: 12px;
    background: rgba(20,27,37,.92);
    font-size: 13px;
    line-height: 1.5;
}

.lms-notice svg { width: 18px; height: 18px; flex: 0 0 auto; margin-top: 1px; }
.lms-notice--danger { border-color: rgba(255,100,118,.35); color: #ffd9de; background: rgba(255,100,118,.08); }
.lms-notice--success { border-color: rgba(47,212,154,.35); color: #d4fff0; background: rgba(47,212,154,.08); }
.lms-notice ul { margin: 4px 0 0; padding-left: 18px; }

/* Command ribbon */
.lms-ribbon {
    position: sticky;
    top: 0;
    z-index: 12;
    display: grid;
    grid-template-columns: minmax(220px, 1.1fr) auto minmax(290px, .9fr);
    align-items: center;
    gap: 18px;
    padding: 16px 18px;
    border-bottom: 1px solid var(--lms-line);
    background: rgba(11,16,23,.92);
    backdrop-filter: blur(18px);
}

.lms-ribbon__brand {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.lms-brand-icon {
    width: 38px;
    height: 38px;
    display: grid;
    place-items: center;
    border-radius: 11px;
    background: linear-gradient(145deg, rgba(102,114,255,.22), rgba(102,114,255,.08));
    border: 1px solid rgba(102,114,255,.26);
    color: #9da5ff;
    box-shadow: inset 0 1px rgba(255,255,255,.05);
}

.lms-brand-icon svg { width: 19px; height: 19px; }
.lms-brand-copy { min-width: 0; }
.lms-kicker { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #818cff; }
.lms-title { margin-top: 2px; font-size: 15px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lms-subtitle { margin-top: 2px; font-size: 11px; color: var(--lms-muted-2); }

.lms-session-meta {
    display: flex;
    align-items: stretch;
    border: 1px solid var(--lms-line);
    border-radius: 12px;
    overflow: hidden;
    background: rgba(20,27,37,.74);
}

.lms-meta {
    min-width: 92px;
    padding: 9px 13px;
    border-right: 1px solid var(--lms-line);
}
.lms-meta:last-child { border-right: 0; }
.lms-meta span { display: block; font-size: 9px; text-transform: uppercase; letter-spacing: .08em; color: var(--lms-muted-2); }
.lms-meta strong { display: block; margin-top: 2px; font-size: 12px; font-weight: 650; color: var(--lms-text); white-space: nowrap; max-width: 120px; overflow: hidden; text-overflow: ellipsis; }

.lms-steps {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    min-width: 0;
}
.lms-step { display: flex; align-items: center; gap: 7px; color: var(--lms-muted-2); font-size: 10px; font-weight: 650; }
.lms-step__dot { width: 9px; height: 9px; border-radius: 50%; background: var(--lms-panel-3); border: 2px solid #344154; }
.lms-step.is-done { color: #86e9c7; }
.lms-step.is-done .lms-step__dot { background: var(--lms-success); border-color: var(--lms-success); box-shadow: 0 0 0 4px rgba(47,212,154,.08); }
.lms-step.is-active { color: #c9cdff; }
.lms-step.is-active .lms-step__dot { background: var(--lms-primary); border-color: var(--lms-primary); box-shadow: 0 0 0 4px var(--lms-primary-soft); }
.lms-step__line { width: 24px; height: 1px; margin: 0 7px; background: #303b4d; }
.lms-step__line.is-done { background: rgba(47,212,154,.55); }

/* Main mapper */
.lms-map-shell { padding: 16px 18px 12px; }

.lms-map-toolbar {
    display: grid;
    grid-template-columns: minmax(0,1fr) auto;
    align-items: center;
    gap: 14px;
    margin-bottom: 12px;
}

.lms-toolbar-title h3 { margin: 0; font-size: 14px; font-weight: 700; }
.lms-toolbar-title p { margin: 3px 0 0; font-size: 11px; color: var(--lms-muted-2); }

.lms-health-hud {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 300px;
    padding: 9px 11px;
    border: 1px solid var(--lms-line);
    border-radius: 12px;
    background: rgba(20,27,37,.86);
}

.lms-health-ring {
    --p: 0deg;
    position: relative;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: conic-gradient(var(--lms-success) var(--p), #263244 0);
    flex: 0 0 auto;
}
.lms-health-ring::before {
    content: "";
    position: absolute;
    inset: 5px;
    border-radius: 50%;
    background: var(--lms-panel);
}
.lms-health-ring strong {
    position: absolute;
    inset: 0;
    display: grid;
    place-items: center;
    font-size: 10px;
    z-index: 1;
}
.lms-health-copy { min-width: 0; }
.lms-health-copy span { display: block; font-size: 9px; text-transform: uppercase; letter-spacing: .08em; color: var(--lms-muted-2); }
.lms-health-copy strong { display: block; margin-top: 1px; font-size: 12px; }
.lms-health-copy small { display: block; margin-top: 2px; font-size: 10px; color: var(--lms-muted); }

.lms-filter-set {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-left: auto;
}
.lms-filter-btn {
    border: 1px solid var(--lms-line);
    background: var(--lms-panel);
    color: var(--lms-muted);
    padding: 6px 9px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 650;
    cursor: pointer;
}
.lms-filter-btn:hover { color: var(--lms-text); border-color: #38475d; }
.lms-filter-btn.is-active { color: #d8dbff; border-color: rgba(102,114,255,.45); background: var(--lms-primary-soft); }

.lms-map-grid {
    position: relative;
    display: grid;
    grid-template-columns: 240px minmax(260px, 360px) minmax(330px, 390px);
    gap: 0;
    align-items: start;
    border: 1px solid var(--lms-line);
    border-radius: 14px;
    overflow: hidden;
    background: rgba(13,18,26,.76);
}

.lms-edge-layer {
    position: absolute;
    inset: 0;
    z-index: 3;
    pointer-events: none;
    overflow: visible;
}

.lms-column {
    position: relative;
    z-index: 4;
    min-width: 0;
}

.lms-source-col { border-right: 1px solid var(--lms-line); background: rgba(16,22,31,.82); }
.lms-dest-col { border-left: 1px solid var(--lms-line); background: rgba(16,22,31,.82); }
.lms-graph-col {
    min-height: 100%;
    background:
        radial-gradient(circle at center, rgba(102,114,255,.045), transparent 60%),
        linear-gradient(rgba(255,255,255,.018) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.018) 1px, transparent 1px);
    background-size: auto, 22px 22px, 22px 22px;
}

.lms-col-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    height: 56px;
    padding: 0 14px;
    border-bottom: 1px solid var(--lms-line);
}
.lms-col-head strong { display: block; font-size: 11px; letter-spacing: .04em; text-transform: uppercase; }
.lms-col-head span { display: block; margin-top: 2px; font-size: 9px; color: var(--lms-muted-2); }
.lms-count-badge { padding: 4px 7px; border: 1px solid var(--lms-line); border-radius: 999px; color: var(--lms-muted); font-size: 9px; background: var(--lms-panel); }

.lms-source-list, .lms-dest-list { padding: 10px; display: grid; gap: 8px; }

.lms-source-token {
    position: relative;
    display: grid;
    grid-template-columns: 30px minmax(0,1fr) auto;
    align-items: center;
    gap: 9px;
    min-height: 58px;
    padding: 9px 10px;
    border: 1px solid var(--lms-line);
    border-radius: 10px;
    background: var(--lms-panel);
    transition: border-color .18s ease, background .18s ease, transform .18s ease, box-shadow .18s ease;
}
.lms-source-token:hover { transform: translateY(-1px); border-color: #3a485c; }
.lms-source-token.is-connected { border-color: rgba(47,212,154,.34); background: linear-gradient(90deg, rgba(47,212,154,.09), rgba(20,27,37,.95)); }
.lms-source-token.is-highlight { border-color: rgba(102,114,255,.7); box-shadow: 0 0 0 3px rgba(102,114,255,.09); }
.lms-source-icon { width: 30px; height: 30px; display: grid; place-items: center; border-radius: 8px; background: var(--lms-panel-3); color: var(--lms-muted); }
.lms-source-token.is-connected .lms-source-icon { color: var(--lms-success); background: rgba(47,212,154,.11); }
.lms-source-icon svg { width: 14px; height: 14px; }
.lms-source-copy { min-width: 0; }
.lms-source-name { font-size: 11px; font-weight: 650; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lms-source-type { margin-top: 2px; font-size: 9px; text-transform: uppercase; letter-spacing: .07em; color: var(--lms-muted-2); }
.lms-source-state { font-size: 8px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--lms-muted-2); }
.lms-source-token.is-connected .lms-source-state { color: var(--lms-success); }
.lms-source-socket {
    position: absolute;
    right: -5px;
    top: 50%;
    transform: translateY(-50%);
    width: 9px;
    height: 9px;
    border: 2px solid #435168;
    border-radius: 50%;
    background: var(--lms-bg-2);
    z-index: 6;
}
.lms-source-token.is-connected .lms-source-socket { border-color: var(--lms-success); background: var(--lms-success); box-shadow: 0 0 0 4px rgba(47,212,154,.08); }

.lms-graph-stage {
    position: sticky;
    top: 76px;
    min-height: 360px;
    height: calc(100vh - 235px);
    max-height: 620px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 18px 20px;
    pointer-events: none;
}
.lms-graph-label { display: flex; align-items: center; gap: 8px; font-size: 9px; text-transform: uppercase; letter-spacing: .11em; color: var(--lms-muted-2); }
.lms-graph-label::before { content:""; width: 24px; height: 1px; background: #39475a; }
.lms-graph-center {
    margin: auto 0;
    display: grid;
    place-items: center;
    text-align: center;
}
.lms-graph-orb {
    width: 94px;
    height: 94px;
    border-radius: 50%;
    position: relative;
    display: grid;
    place-items: center;
    border: 1px solid rgba(102,114,255,.34);
    background: radial-gradient(circle, rgba(102,114,255,.14), rgba(102,114,255,.04) 58%, transparent 60%);
    box-shadow: 0 0 0 14px rgba(102,114,255,.025), 0 0 45px rgba(102,114,255,.08);
}
.lms-graph-orb::before,
.lms-graph-orb::after {
    content:"";
    position:absolute;
    border-radius:50%;
    border:1px dashed rgba(102,114,255,.22);
}
.lms-graph-orb::before { inset:-12px; }
.lms-graph-orb::after { inset:12px; border-color: rgba(47,212,154,.16); }
.lms-graph-orb svg { width: 28px; height: 28px; color: #a5acff; }
.lms-graph-center strong { display:block; margin-top: 16px; font-size: 11px; }
.lms-graph-center span { display:block; margin-top: 3px; font-size: 9px; color: var(--lms-muted-2); }
.lms-graph-hint { font-size: 9px; color: var(--lms-muted-2); text-align: center; }

.lms-dest-node {
    position: relative;
    min-height: 78px;
    padding: 9px 10px 10px 13px;
    border: 1px solid var(--lms-line);
    border-radius: 10px;
    background: var(--lms-panel);
    transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease, background .18s ease;
}
.lms-dest-node.is-hidden { display: none; }
.lms-dest-node.is-highlight { border-color: rgba(102,114,255,.72); box-shadow: 0 0 0 3px rgba(102,114,255,.09); }
.lms-dest-node.is-flash { animation: lmsShake .34s ease; box-shadow: 0 0 0 3px var(--lms-danger-soft); border-color: var(--lms-danger); }
@keyframes lmsShake { 0%,100%{transform:translateX(0)} 25%{transform:translateX(-4px)} 50%{transform:translateX(4px)} 75%{transform:translateX(-2px)} }

.lms-dest-socket {
    position: absolute;
    left: -5px;
    top: 50%;
    transform: translateY(-50%);
    width: 9px;
    height: 9px;
    border: 2px solid #435168;
    border-radius: 50%;
    background: var(--lms-bg-2);
    z-index: 6;
}
.lms-dest-node[data-status="auto"] .lms-dest-socket,
.lms-dest-node[data-status="manual"] .lms-dest-socket { border-color: var(--lms-success); background: var(--lms-success); }
.lms-dest-node[data-status="missing"] .lms-dest-socket { border-color: var(--lms-danger); background: var(--lms-danger); }

.lms-dest-head { display:flex; align-items:center; gap:8px; margin-bottom:7px; }
.lms-dest-label { font-size: 11px; font-weight:700; flex:1; min-width:0; }
.lms-dest-tag { font-size:8px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:var(--lms-muted-2); }
.lms-dest-tag.is-required { color:#ff9ba7; }
.lms-dest-body { display:grid; grid-template-columns:minmax(0,1fr) auto; align-items:center; gap:8px; }
.lms-select-wrap { position:relative; min-width:0; }
.lms-select-wrap::before {
    content:"";
    position:absolute;
    left:10px;
    top:50%;
    width:12px;
    height:12px;
    transform:translateY(-50%);
    opacity:.7;
    background-repeat:no-repeat;
    background-size:12px 12px;
    pointer-events:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none'%3E%3Cpath d='M3 2.5h6l4 4v7H3z' stroke='%239aa8ba' stroke-width='1.2'/%3E%3Cpath d='M9 2.5v4h4' stroke='%239aa8ba' stroke-width='1.2'/%3E%3C/svg%3E");
}
.lms-select {
    width:100%;
    min-width:0;
    appearance:none;
    -webkit-appearance:none;
    border:1px solid #2d3a4d;
    border-radius:8px;
    background-color:var(--lms-panel-2);
    color:var(--lms-text);
    font-size:10.5px;
    padding:8px 28px 8px 28px;
    line-height:1.25;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%239aa8ba' stroke-width='1.4' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat:no-repeat;
    background-position:right 10px center;
    transition:border-color .18s ease, box-shadow .18s ease;
}
.lms-select:focus { outline:none; border-color:var(--lms-primary); box-shadow:0 0 0 3px var(--lms-primary-soft); }
.lms-status {
    display:inline-flex;
    align-items:center;
    gap:5px;
    white-space:nowrap;
    font-size:9px;
    font-weight:700;
    color:var(--lms-muted-2);
}
.lms-status::before { content:""; width:6px; height:6px; border-radius:50%; background:#5d6a7d; }
.lms-dest-node[data-status="auto"] .lms-status { color:var(--lms-success); }
.lms-dest-node[data-status="auto"] .lms-status::before { background:var(--lms-success); box-shadow:0 0 0 3px rgba(47,212,154,.08); }
.lms-dest-node[data-status="manual"] .lms-status { color:#8fa2ff; }
.lms-dest-node[data-status="manual"] .lms-status::before { background:var(--lms-primary); }
.lms-dest-node[data-status="missing"] .lms-status { color:var(--lms-danger); }
.lms-dest-node[data-status="missing"] .lms-status::before { background:var(--lms-danger); }

.lms-edge { fill:none; stroke-width:2; opacity:.78; transition:opacity .18s ease, stroke-width .18s ease, filter .18s ease; }
.lms-edge--auto { stroke:var(--lms-success); }
.lms-edge--manual { stroke:var(--lms-primary); }
.lms-edge--missing { stroke:var(--lms-danger); stroke-dasharray:5 6; opacity:.45; }
.lms-edge--optional { stroke:#526078; stroke-dasharray:3 7; opacity:.32; }
.lms-edge.is-highlight { opacity:1; stroke-width:3; filter:drop-shadow(0 0 5px currentColor); }
.lms-edge.is-pulse { stroke-dasharray:10 8; animation:lmsEdgePulse .65s ease; }
@keyframes lmsEdgePulse { from{stroke-dashoffset:24} to{stroke-dashoffset:0} }

/* Inspector */
.lms-inspector {
    margin: 0 18px 14px;
    border: 1px solid var(--lms-line);
    border-radius: 14px;
    overflow: hidden;
    background: var(--lms-panel);
    box-shadow: 0 12px 32px rgba(0,0,0,.2);
}
.lms-inspector__bar {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px 12px;
    border-bottom:1px solid var(--lms-line);
    background:var(--lms-panel-2);
}
.lms-inspector__title { font-size:11px; font-weight:700; }
.lms-inspector__sub { font-size:9px; color:var(--lms-muted-2); }
.lms-live { margin-left:auto; display:flex; align-items:center; gap:5px; font-size:9px; font-weight:700; color:var(--lms-success); }
.lms-live::before { content:""; width:6px; height:6px; border-radius:50%; background:var(--lms-success); box-shadow:0 0 0 4px rgba(47,212,154,.08); }
.lms-tool-btn {
    width:28px; height:28px; display:grid; place-items:center;
    border:1px solid var(--lms-line); border-radius:8px;
    background:var(--lms-panel); color:var(--lms-muted); cursor:pointer;
}
.lms-tool-btn:hover { color:var(--lms-text); border-color:#3b4a60; }
.lms-tool-btn svg { width:14px; height:14px; }
.lms-inspector__meta {
    display:flex; align-items:center; justify-content:space-between; gap:10px;
    padding:8px 12px; border-bottom:1px solid var(--lms-line);
    font-size:9px; color:var(--lms-muted-2);
}
.lms-inspector__body { height:310px; transition:height .22s ease; background:#fff; }
.lms-inspector__body iframe { width:100%; height:100%; border:0; display:block; background:#fff; }
.lms-inspector.is-collapsed .lms-inspector__body,
.lms-inspector.is-collapsed .lms-inspector__meta { height:0; padding-top:0; padding-bottom:0; overflow:hidden; border:0; }
.lms-inspector.is-expanded {
    position:fixed;
    inset:76px 28px 28px;
    z-index:9998;
    margin:0;
    box-shadow:0 30px 90px rgba(0,0,0,.62);
}
.lms-inspector.is-expanded .lms-inspector__body { height:calc(100vh - 170px); }

/* Command dock */
.lms-command-dock {
    position:sticky;
    bottom:10px;
    z-index:20;
    margin:0 18px 14px;
    display:grid;
    grid-template-columns:auto auto auto auto 1fr auto;
    align-items:center;
    gap:16px;
    padding:11px 12px;
    border:1px solid var(--lms-line);
    border-radius:14px;
    background:rgba(20,27,37,.94);
    backdrop-filter:blur(16px);
    box-shadow:0 18px 42px rgba(0,0,0,.38);
}
.lms-command-stat span { display:block; font-size:8px; text-transform:uppercase; letter-spacing:.08em; color:var(--lms-muted-2); }
.lms-command-stat strong { display:block; margin-top:2px; font-size:10.5px; }
.lms-command-stat strong.is-good { color:var(--lms-success); }
.lms-command-stat strong.is-bad { color:var(--lms-danger); }
.lms-segments { display:flex; gap:3px; align-items:center; }
.lms-seg { width:11px; height:5px; border-radius:3px; background:#2b3647; }
.lms-seg.is-filled { background:var(--lms-success); box-shadow:0 0 8px rgba(47,212,154,.2); }
.lms-command-ready { justify-self:end; font-size:9px; color:var(--lms-muted-2); }
.lms-command-ready strong { display:block; margin-top:1px; font-size:11px; color:var(--lms-danger); }
.lms-command-ready.is-ready strong { color:var(--lms-success); }
.lms-import-btn {
    display:inline-flex; align-items:center; gap:8px;
    border:0; border-radius:10px; padding:10px 16px;
    background:linear-gradient(135deg, #6d75ff, #5964f5);
    color:#fff; font-size:11px; font-weight:750; cursor:pointer;
    box-shadow:0 9px 22px rgba(89,100,245,.28);
    transition:transform .15s ease, opacity .15s ease, filter .15s ease;
}
.lms-import-btn:hover:not(:disabled){ transform:translateY(-1px); filter:brightness(1.05); }
.lms-import-btn:disabled { opacity:.45; cursor:not-allowed; box-shadow:none; }
.lms-import-btn svg { width:15px; height:15px; }

/* Swal */
.lms-swal-popup { background:#141b25 !important; border:1px solid #2b3748 !important; border-radius:16px !important; color:#eef3f9 !important; }
.lms-swal-title { color:#eef3f9 !important; font-size:18px !important; }
.lms-swal-html { color:#9aa8ba !important; font-size:13px !important; line-height:1.6 !important; }
.lms-swal-confirm { background:#6672ff !important; border-radius:9px !important; box-shadow:none !important; }

@media (max-width: 1280px) {
    .lms-ribbon { grid-template-columns: minmax(200px,1fr) auto; }
    .lms-session-meta { order: 3; grid-column: 1 / -1; justify-self: start; }
    .lms-map-grid { grid-template-columns: 215px minmax(200px,300px) minmax(310px,360px); }
}

@media (max-width: 1024px) {
    .lms-map-toolbar { grid-template-columns:1fr; }
    .lms-health-hud { min-width:0; justify-self:start; }
    .lms-map-grid { grid-template-columns:190px minmax(150px,230px) minmax(290px,1fr); }
    .lms-source-state { display:none; }
    .lms-command-dock { grid-template-columns:repeat(3,1fr) auto; }
    .lms-command-ready { grid-column:1 / 3; justify-self:start; }
}

@media (max-width: 768px) {
    .lead-map-studio { border-radius:12px; }
    .lms-ribbon { position:relative; grid-template-columns:1fr; gap:10px; padding:14px; }
    .lms-steps { justify-content:flex-start; overflow-x:auto; padding-bottom:2px; }
    .lms-session-meta { width:100%; overflow-x:auto; }
    .lms-map-shell { padding:12px; }
    .lms-map-grid { grid-template-columns:1fr; }
    .lms-source-col { border-right:0; border-bottom:1px solid var(--lms-line); }
    .lms-source-list { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .lms-source-socket, .lms-dest-socket, .lms-edge-layer, .lms-graph-col { display:none; }
    .lms-dest-col { border-left:0; }
    .lms-dest-list { gap:9px; }
    .lms-dest-node { min-height:0; }
    .lms-inspector { margin-left:12px; margin-right:12px; }
    .lms-inspector.is-expanded { inset:14px; }
    .lms-inspector.is-expanded .lms-inspector__body { height:calc(100vh - 110px); }
    .lms-command-dock { margin:0 12px 12px; grid-template-columns:repeat(2,1fr); gap:10px; }
    .lms-command-ready { grid-column:1 / 2; }
    .lms-import-btn { width:100%; justify-content:center; }
}

@media (max-width: 430px) {
    .lms-source-list { grid-template-columns:1fr; }
    .lms-health-hud { width:100%; }
    .lms-filter-set { width:100%; overflow-x:auto; padding-bottom:2px; }
    .lms-map-toolbar { align-items:stretch; }
    .lms-dest-body { grid-template-columns:1fr; }
    .lms-status { margin-top:2px; }
    .lms-command-dock { position:relative; bottom:auto; grid-template-columns:1fr 1fr; }
    .lms-command-ready { grid-column:1 / -1; }
    .lms-import-btn { grid-column:1 / -1; }
}


/* ============================================================
   CODE SPARROW LIGHT THEME OVERRIDES
   Brand palette sampled from supplied logo:
   charcoal #2B2A29 · teal #197A83 · aqua #15AFBD
============================================================ */
.lead-map-studio {
    --lms-bg: #f4f8f9;
    --lms-bg-2: #ffffff;
    --lms-panel: #ffffff;
    --lms-panel-2: #f8fbfb;
    --lms-panel-3: #edf6f7;
    --lms-line: #d9e5e7;
    --lms-line-soft: rgba(25,122,131,.10);
    --lms-text: #2b2a29;
    --lms-muted: #65777a;
    --lms-muted-2: #8a999c;
    --lms-primary: #197a83;
    --lms-primary-soft: rgba(25,122,131,.11);
    --lms-success: #15afbd;
    --lms-success-soft: rgba(21,175,189,.11);
    --lms-warning: #d89222;
    --lms-warning-soft: rgba(216,146,34,.11);
    --lms-danger: #e25563;
    --lms-danger-soft: rgba(226,85,99,.10);
    --lms-shadow: 0 18px 46px rgba(31,55,59,.10);

    border-color: #e0eaec;
    background:
        radial-gradient(circle at 16% 0%, rgba(21,175,189,.09), transparent 26%),
        radial-gradient(circle at 94% 8%, rgba(25,122,131,.055), transparent 22%),
        #f7fafb;
    color: var(--lms-text);
    box-shadow: var(--lms-shadow);
}

.lead-map-studio::before {
    opacity: .75;
    background-image:
        linear-gradient(rgba(25,122,131,.045) 1px, transparent 1px),
        linear-gradient(90deg, rgba(25,122,131,.045) 1px, transparent 1px);
    mask-image: linear-gradient(to bottom, #000 0%, rgba(0,0,0,.58) 48%, transparent 92%);
}

.lms-notice {
    background: rgba(255,255,255,.96);
    border-color: #dbe7e9;
    color: #39484a;
    box-shadow: 0 8px 20px rgba(36,70,74,.05);
}
.lms-notice--danger { color:#9f3340; background:#fff6f7; border-color:#f0c5ca; }
.lms-notice--success { color:#126f78; background:#f1fbfc; border-color:#bfe8ec; }

.lms-ribbon {
    border-bottom-color: #dce7e9;
    background: rgba(255,255,255,.94);
    box-shadow: 0 8px 26px rgba(30,66,70,.045);
}
.lms-brand-icon {
    background: linear-gradient(145deg, rgba(21,175,189,.16), rgba(25,122,131,.07));
    border-color: rgba(25,122,131,.19);
    color: #197a83;
    box-shadow: inset 0 1px rgba(255,255,255,.8);
}
.lms-kicker { color:#197a83; }
.lms-title { color:#2b2a29; }
.lms-subtitle { color:#7f9093; }

.lms-session-meta {
    background: #ffffff;
    border-color: #d9e5e7;
    box-shadow: 0 6px 18px rgba(35,73,77,.04);
}
.lms-meta { border-right-color:#dfe9eb; }
.lms-meta span { color:#8a999c; }
.lms-meta strong { color:#2b2a29; }

.lms-step { color:#8d9a9d; }
.lms-step__dot { background:#eef3f4; border-color:#cbd9dc; }
.lms-step.is-done { color:#197a83; }
.lms-step.is-done .lms-step__dot { background:#15afbd; border-color:#15afbd; box-shadow:0 0 0 4px rgba(21,175,189,.10); }
.lms-step.is-active { color:#2b2a29; }
.lms-step.is-active .lms-step__dot { background:#197a83; border-color:#197a83; box-shadow:0 0 0 4px rgba(25,122,131,.12); }
.lms-step__line { background:#d5e1e3; }
.lms-step__line.is-done { background:rgba(21,175,189,.55); }

.lms-toolbar-title h3 { color:#2b2a29; }
.lms-toolbar-title p { color:#7f9093; }
.lms-health-hud {
    background:#ffffff;
    border-color:#d9e5e7;
    box-shadow:0 7px 18px rgba(38,73,77,.045);
}
.lms-health-ring { background:conic-gradient(var(--lms-success) var(--p), #dfe9eb 0); }
.lms-health-ring::before { background:#ffffff; }

.lms-filter-btn {
    background:#ffffff;
    border-color:#d8e4e6;
    color:#667679;
}
.lms-filter-btn:hover { color:#197a83; border-color:#9fc7cc; background:#f7fbfb; }
.lms-filter-btn.is-active { color:#197a83; border-color:rgba(25,122,131,.32); background:rgba(25,122,131,.08); }

.lms-map-grid {
    border-color:#d8e4e6;
    background:#ffffff;
    box-shadow:0 15px 36px rgba(29,68,73,.065);
}
.lms-source-col,
.lms-dest-col { background:#fbfdfd; }
.lms-graph-col {
    background:
        radial-gradient(circle at center, rgba(21,175,189,.055), transparent 60%),
        linear-gradient(rgba(25,122,131,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(25,122,131,.04) 1px, transparent 1px);
    background-size:auto,22px 22px,22px 22px;
}
.lms-col-head { border-bottom-color:#dce7e9; background:#ffffff; }
.lms-col-head strong { color:#2b2a29; }
.lms-count-badge { background:#f4f8f9; border-color:#d7e4e6; color:#68787b; }

.lms-source-token {
    background:#ffffff;
    border-color:#dce7e9;
    box-shadow:0 4px 12px rgba(36,73,77,.03);
}
.lms-source-token:hover { border-color:#9fc7cc; box-shadow:0 7px 16px rgba(35,90,96,.07); }
.lms-source-token.is-connected {
    border-color:rgba(21,175,189,.36);
    background:linear-gradient(90deg, rgba(21,175,189,.09), #ffffff 78%);
}
.lms-source-token.is-highlight { border-color:#197a83; box-shadow:0 0 0 3px rgba(25,122,131,.10),0 8px 18px rgba(25,122,131,.07); }
.lms-source-icon { background:#eef6f7; color:#6f8083; }
.lms-source-token.is-connected .lms-source-icon { color:#197a83; background:rgba(21,175,189,.12); }
.lms-source-name { color:#2b2a29; }
.lms-source-type { color:#8a999c; }
.lms-source-state { color:#8a999c; }
.lms-source-token.is-connected .lms-source-state { color:#197a83; }
.lms-source-socket,
.lms-dest-socket { border-color:#a9bcc0; background:#ffffff; }
.lms-source-token.is-connected .lms-source-socket { border-color:#15afbd; background:#15afbd; box-shadow:0 0 0 4px rgba(21,175,189,.10); }

.lms-graph-label { color:#89989b; }
.lms-graph-label::before { background:#cbd9dc; }
.lms-graph-orb {
    border-color:rgba(25,122,131,.25);
    background:radial-gradient(circle, rgba(21,175,189,.12), rgba(25,122,131,.035) 58%, transparent 60%);
    box-shadow:0 0 0 14px rgba(21,175,189,.025),0 0 34px rgba(25,122,131,.08);
}
.lms-graph-orb::before { border-color:rgba(25,122,131,.20); }
.lms-graph-orb::after { border-color:rgba(21,175,189,.20); }
.lms-graph-orb svg { color:#197a83; }

.lms-dest-node {
    background:#ffffff;
    border-color:#dce7e9;
    box-shadow:0 4px 12px rgba(34,70,75,.028);
}
.lms-dest-node.is-highlight { border-color:#197a83; box-shadow:0 0 0 3px rgba(25,122,131,.10),0 8px 18px rgba(25,122,131,.06); }
.lms-dest-label { color:#2b2a29; }
.lms-dest-tag { color:#8a999c; }
.lms-dest-tag.is-required { color:#d94f5e; }
.lms-dest-node[data-status="auto"] .lms-dest-socket,
.lms-dest-node[data-status="manual"] .lms-dest-socket { border-color:#15afbd; background:#15afbd; }

.lms-select-wrap::before {
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none'%3E%3Cpath d='M3 2.5h6l4 4v7H3z' stroke='%2365777a' stroke-width='1.2'/%3E%3Cpath d='M9 2.5v4h4' stroke='%2365777a' stroke-width='1.2'/%3E%3C/svg%3E");
}
.lms-select {
    border-color:#d4e1e3;
    background-color:#f9fbfb;
    color:#2b2a29;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2365777a' stroke-width='1.4' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
}
.lms-select:hover { border-color:#aec9cd; background-color:#ffffff; }
.lms-select:focus { border-color:#197a83; box-shadow:0 0 0 3px rgba(25,122,131,.11); background-color:#ffffff; }
.lms-status::before { background:#a6b4b7; }
.lms-dest-node[data-status="manual"] .lms-status { color:#197a83; }
.lms-dest-node[data-status="manual"] .lms-status::before { background:#197a83; }
.lms-edge--manual { stroke:#197a83; }
.lms-edge--optional { stroke:#9fb1b5; }
.lms-edge.is-highlight { filter:drop-shadow(0 0 4px rgba(25,122,131,.28)); }

.lms-inspector {
    background:#ffffff;
    border-color:#d8e4e6;
    box-shadow:0 14px 34px rgba(30,68,73,.085);
}
.lms-inspector__bar { background:#f8fbfb; border-bottom-color:#dde8ea; }
.lms-inspector__title { color:#2b2a29; }
.lms-inspector__sub { color:#87979a; }
.lms-tool-btn { background:#ffffff; color:#6f8083; border-color:#d8e4e6; }
.lms-tool-btn:hover { color:#197a83; border-color:#9fc7cc; background:#f7fbfb; }
.lms-inspector__meta { border-bottom-color:#e0eaec; color:#829295; }
.lms-inspector.is-expanded { box-shadow:0 28px 80px rgba(27,58,62,.20); }

.lms-command-dock {
    border-color:#d7e3e5;
    background:rgba(255,255,255,.95);
    box-shadow:0 18px 42px rgba(31,70,75,.12);
}
.lms-command-stat span { color:#849396; }
.lms-command-stat strong { color:#2b2a29; }
.lms-seg { background:#dce7e9; }
.lms-seg.is-filled { background:#15afbd; box-shadow:0 0 8px rgba(21,175,189,.18); }
.lms-command-ready { color:#87979a; }
.lms-import-btn {
    background:linear-gradient(135deg,#197a83,#15afbd);
    color:#ffffff;
    box-shadow:0 10px 24px rgba(25,122,131,.20);
}
.lms-import-btn:hover:not(:disabled) { filter:brightness(1.035); box-shadow:0 12px 28px rgba(25,122,131,.24); }

.lms-swal-popup { background:#ffffff !important; border:1px solid #d9e5e7 !important; color:#2b2a29 !important; box-shadow:0 24px 70px rgba(28,63,67,.16) !important; }
.lms-swal-title { color:#2b2a29 !important; }
.lms-swal-html { color:#65777a !important; }
.lms-swal-confirm { background:linear-gradient(135deg,#197a83,#15afbd) !important; color:#ffffff !important; }

/* Better native dropdown contrast in light mode */
.lead-map-studio select option { background:#ffffff; color:#2b2a29; }



/* ==========================================================
   CODE SPARROW ULTRA WHITE — DATA STUDIO V3
   Structural refinement layer. Backend contracts untouched.
   ========================================================== */
.lead-map-studio {
    --lms-bg:#f4f8f9;
    --lms-bg-2:#eef5f6;
    --lms-panel:#ffffff;
    --lms-panel-2:#f8fbfb;
    --lms-panel-3:#edf5f6;
    --lms-line:#dce8ea;
    --lms-line-soft:rgba(25,122,131,.10);
    --lms-text:#242424;
    --lms-muted:#68777a;
    --lms-muted-2:#91a0a3;
    --lms-primary:#197a83;
    --lms-primary-soft:rgba(25,122,131,.10);
    --lms-success:#159d83;
    --lms-success-soft:rgba(21,157,131,.10);
    --lms-warning:#c8872e;
    --lms-warning-soft:rgba(200,135,46,.10);
    --lms-danger:#d94d5d;
    --lms-danger-soft:rgba(217,77,93,.09);
    --lms-sparrow:#12a9b7;
    --lms-charcoal:#292929;
    --lms-shadow:0 18px 55px rgba(22,65,70,.10);
    background:
      radial-gradient(circle at 8% 0%, rgba(18,169,183,.08), transparent 24%),
      radial-gradient(circle at 92% 12%, rgba(25,122,131,.06), transparent 22%),
      linear-gradient(180deg,#fbfdfd 0%,#f3f8f8 100%);
    border-color:#dbe8ea;
    box-shadow:0 18px 60px rgba(27,74,80,.10);
}
.lead-map-studio::before {
    opacity:.72;
    background-image:
      radial-gradient(circle, rgba(25,122,131,.10) 1px, transparent 1.2px);
    background-size:22px 22px;
    mask-image:linear-gradient(to bottom,#000 0%,rgba(0,0,0,.55) 55%,transparent 94%);
}
.lms-ribbon {
    top:0;
    padding:14px 18px;
    background:rgba(255,255,255,.92);
    border-bottom:1px solid #dce8ea;
    box-shadow:0 8px 26px rgba(35,78,83,.05);
}
.lms-brand-icon {
    background:linear-gradient(145deg,#e7f8fa,#f7ffff);
    border-color:#bfe3e7;
    color:#1497a4;
    box-shadow:0 8px 20px rgba(18,169,183,.12), inset 0 1px #fff;
}
.lms-kicker { color:#1597a3; }
.lms-title { color:#252525; letter-spacing:-.015em; }
.lms-subtitle { color:#7d8c8f; }
.lms-session-meta { background:#f8fbfb; border-color:#dce8ea; }
.lms-meta { border-right-color:#dce8ea; }
.lms-meta span { color:#8b999c; }
.lms-meta strong { color:#252525; }
.lms-step { color:#9aa7aa; }
.lms-step__dot { background:#eef3f4; border-color:#d5e1e3; }
.lms-step.is-done { color:#167d70; }
.lms-step.is-active { color:#197a83; }
.lms-step__line { background:#d8e3e5; }

.lms-map-shell { padding:18px; }
.lms-map-toolbar {
    margin-bottom:14px;
    padding:15px 16px;
    border:1px solid #dce8ea;
    border-radius:16px;
    background:rgba(255,255,255,.82);
    box-shadow:0 10px 28px rgba(27,78,83,.05);
}
.lms-toolbar-title h3 { color:#252525; font-size:15px; }
.lms-toolbar-title p { color:#829194; }
.lms-health-hud { background:#fff; border-color:#d8e6e8; box-shadow:0 7px 20px rgba(28,79,84,.05); }
.lms-health-ring { background:conic-gradient(var(--lms-success) var(--p),#dce9eb 0); }
.lms-health-ring::before { background:#fff; }
.lms-health-ring strong,.lms-health-copy strong { color:#252525; }
.lms-health-copy span,.lms-health-copy small { color:#819093; }
.lms-filter-btn { background:#fff; border-color:#dce7e9; color:#738285; }
.lms-filter-btn:hover { color:#197a83; border-color:#a9cfd4; background:#f7fbfb; }
.lms-filter-btn.is-active { color:#fff; border-color:#197a83; background:#197a83; box-shadow:0 6px 16px rgba(25,122,131,.16); }

.lms-map-grid {
    position:relative;
    display:grid;
    grid-template-columns:235px minmax(170px,250px) minmax(390px,1fr);
    gap:0;
    align-items:stretch;
    min-height:560px;
    border:1px solid #d8e5e7;
    border-radius:18px;
    overflow:hidden;
    background:rgba(255,255,255,.94);
    box-shadow:0 16px 44px rgba(25,78,84,.07);
}
.lms-column { background:rgba(255,255,255,.86); }
.lms-source-col { border-right:1px solid #e2ecee; }
.lms-graph-col {
    border-right:1px solid #e2ecee;
    background:
      linear-gradient(90deg,rgba(25,122,131,.025),rgba(18,169,183,.04)),
      radial-gradient(circle at 50% 50%,rgba(18,169,183,.05),transparent 60%);
}
.lms-dest-col { background:#fbfdfd; }
.lms-col-head {
    min-height:68px;
    padding:14px 16px;
    background:linear-gradient(180deg,#ffffff,#f9fcfc);
    border-bottom:1px solid #e1ebed;
}
.lms-col-head strong { color:#252525; font-size:12px; }
.lms-col-head span { color:#8a999c; }
.lms-count-badge { background:#eff7f8!important; color:#197a83!important; border:1px solid #d4e9eb; }

.lms-source-list,.lms-dest-list { padding:12px; }
.lms-source-token {
    min-height:58px;
    border:1px solid #dce7e9;
    border-radius:12px;
    background:#fff;
    box-shadow:0 3px 12px rgba(29,79,84,.035);
    position:relative;
    overflow:visible;
}
.lms-source-token::before {
    content:attr(data-col-no);
    position:absolute;
    left:-7px;
    top:50%;
    transform:translate(-100%,-50%);
    width:23px;height:23px;
    display:grid;place-items:center;
    border-radius:50%;
    color:#8b999c;
    font-size:9px;font-weight:700;
    background:#f4f8f9;
    border:1px solid #d9e6e8;
}
.lms-source-token:hover,.lms-source-token.is-highlight { border-color:#8fc5cb; box-shadow:0 10px 22px rgba(25,122,131,.10); transform:translateY(-1px); }
.lms-source-token.is-connected { border-color:rgba(21,157,131,.35); background:linear-gradient(90deg,#f7fffc,#fff); }
.lms-source-icon { background:#ecf8f9; color:#168b96; }
.lms-source-name { color:#292929; }
.lms-source-type { color:#97a3a6; }
.lms-source-state { background:#f0f5f6; color:#829194; border:1px solid #e0eaec; }
.lms-source-token.is-connected .lms-source-state { background:#e8f8f3; color:#147d69; border-color:#cfece3; }
.lms-source-socket,.lms-dest-socket { box-shadow:0 0 0 4px #fff; }

.lms-graph-stage { min-height:490px; }
.lms-graph-label { color:#88a0a3; letter-spacing:.12em; }
.lms-graph-center {
    width:128px;height:128px;
    border:1px solid #cae2e5;
    background:radial-gradient(circle at 32% 28%,#ffffff,#edf8f9 72%);
    box-shadow:0 18px 42px rgba(25,122,131,.10), inset 0 0 0 8px rgba(18,169,183,.035);
}
.lms-graph-orb { color:#168b96; background:#e8f6f7; border-color:#c9e7e9; }
.lms-graph-center strong { color:#252525; }
.lms-graph-center span,.lms-graph-hint { color:#839396; }
.lms-edge--auto { stroke:#159d83; }
.lms-edge--manual { stroke:#197a83; }
.lms-edge--missing { stroke:#d94d5d; }
.lms-edge--optional { stroke:#b7c4c6; }

.lms-dest-node {
    border:1px solid #dce7e9;
    border-radius:14px;
    background:#fff;
    box-shadow:0 4px 14px rgba(31,79,84,.035);
}
.lms-dest-node:hover,.lms-dest-node.is-highlight { border-color:#9fc9ce; box-shadow:0 12px 28px rgba(25,122,131,.08); transform:translateY(-1px); }
.lms-dest-label { color:#262626; }
.lms-dest-tag { background:#f2f6f7; color:#89979a; border-color:#e0e9eb; }
.lms-dest-tag.is-required { background:#fff2f3; color:#c44b58; border-color:#f0d7da; }
.lms-select { background-color:#fbfdfd; border-color:#d9e5e7; color:#292929; }
.lms-select:focus-visible { border-color:#197a83; box-shadow:0 0 0 3px rgba(25,122,131,.10); }
.lms-status { color:#78888b; }
.lms-dest-node[data-status="auto"] { border-color:#bfe5d9; background:linear-gradient(90deg,#fbfffd,#fff); }
.lms-dest-node[data-status="manual"] { border-color:#b9dfe3; background:linear-gradient(90deg,#f7fcfd,#fff); }
.lms-dest-node[data-status="missing"] { border-color:#efd5d8; background:linear-gradient(90deg,#fffafa,#fff); }

.lms-review-deck {
    display:grid;
    grid-template-columns:280px minmax(0,1fr);
    gap:14px;
    margin:0 18px 14px;
    align-items:stretch;
}
.lms-intelligence-rail {
    border:1px solid #d9e6e8;
    border-radius:16px;
    background:linear-gradient(180deg,#ffffff,#f8fbfb);
    padding:16px;
    box-shadow:0 12px 30px rgba(26,78,84,.06);
}
.lms-intel-kicker { display:block; font-size:9px; font-weight:800; letter-spacing:.13em; color:#1597a3; margin-bottom:5px; }
.lms-intel-head strong { display:block; color:#252525; font-size:15px; }
.lms-intel-head small { display:block; margin-top:4px; color:#87979a; line-height:1.45; }
.lms-intel-grid { display:grid; gap:9px; margin-top:16px; }
.lms-intel-card { display:flex; align-items:center; gap:10px; padding:11px; border:1px solid #e0eaec; border-radius:12px; background:#fff; }
.lms-intel-card small { display:block; color:#8b999c; font-size:9px; text-transform:uppercase; letter-spacing:.07em; }
.lms-intel-card strong { display:block; margin-top:2px; color:#292929; font-size:12px; }
.lms-intel-icon { width:29px;height:29px; display:grid;place-items:center; border-radius:9px; background:#e9f7f8; color:#168b96; font-weight:800; }
.lms-intel-rule { margin-top:14px; padding-top:13px; border-top:1px dashed #d9e6e8; display:flex; gap:8px; }
.lms-intel-rule span { width:8px;height:8px;border-radius:50%;background:#12a9b7;margin-top:5px;box-shadow:0 0 0 4px rgba(18,169,183,.08); }
.lms-intel-rule p { margin:0; color:#7f8f92; font-size:10px; line-height:1.5; }
.lms-inspector { margin:0; border-color:#d9e6e8; border-radius:16px; background:#fff; box-shadow:0 12px 30px rgba(26,78,84,.06); }
.lms-inspector__bar { background:#f8fbfb; border-bottom-color:#dde8ea; }
.lms-inspector__title { color:#252525; }
.lms-inspector__sub,.lms-inspector__meta { color:#87979a; }
.lms-live { color:#147d69!important; background:#e8f8f3!important; border-color:#cce9e0!important; }
.lms-tool-btn { background:#fff; color:#617174; border-color:#dbe7e9; }
.lms-tool-btn:hover { color:#197a83; border-color:#9fc7cc; background:#f7fbfb; }

.lms-command-dock {
    margin:0 18px 16px;
    border:1px solid #cfe0e3;
    background:rgba(255,255,255,.94);
    backdrop-filter:blur(18px);
    box-shadow:0 18px 44px rgba(27,78,83,.10);
}
.lms-command-stat span,.lms-command-ready { color:#849396; }
.lms-command-stat strong { color:#292929; }
.lms-import-btn {
    background:linear-gradient(135deg,#197a83,#12a9b7);
    color:#fff;
    box-shadow:0 10px 24px rgba(25,122,131,.22);
}
.lms-import-btn:hover { filter:none; transform:translateY(-1px); box-shadow:0 14px 28px rgba(25,122,131,.27); }
.lms-import-btn:disabled { background:#d6e2e4; color:#94a2a5; box-shadow:none; }

.lms-swal-popup { background:#fff!important; border-color:#d7e5e7!important; color:#292929!important; box-shadow:0 26px 70px rgba(24,70,75,.16)!important; }
.lms-swal-title { color:#292929!important; }
.lms-swal-html { color:#718184!important; }
.lms-swal-confirm { background:#197a83!important; box-shadow:0 8px 20px rgba(25,122,131,.18)!important; }

@media (max-width:1200px) {
  .lms-map-grid { grid-template-columns:210px minmax(130px,190px) minmax(340px,1fr); }
  .lms-review-deck { grid-template-columns:240px minmax(0,1fr); }
}
@media (max-width:1024px) {
  .lms-review-deck { grid-template-columns:1fr; }
  .lms-intel-grid { grid-template-columns:repeat(3,1fr); }
}
@media (max-width:768px) {
  .lms-map-grid { grid-template-columns:1fr; }
  .lms-graph-col { display:none; }
  .lms-source-token::before { display:none; }
  .lms-review-deck { margin-left:12px; margin-right:12px; }
  .lms-intel-grid { grid-template-columns:1fr; }
}
</style>


<style>
/* ==========================================================
   CODE SPARROW ENTERPRISE PLATINUM — V4
   Pure frontend refinement. No backend contracts changed.
   ========================================================== */
.lead-map-studio {
    --ep-teal:#0d8d99;
    --ep-cyan:#13b6c4;
    --ep-ink:#17191a;
    --ep-soft:#f3f8f9;
    --ep-line:#d9e7e9;
    --ep-shadow:0 28px 80px rgba(18,71,77,.11);
    border-radius:24px;
    border:1px solid #d8e7e9;
    background:
        radial-gradient(circle at 4% 0%, rgba(19,182,196,.11), transparent 25%),
        radial-gradient(circle at 96% 7%, rgba(13,141,153,.07), transparent 22%),
        linear-gradient(180deg,#ffffff 0%,#f7fbfb 55%,#f2f7f8 100%);
    box-shadow:var(--ep-shadow);
}
.lead-map-studio::after{
    content:"";
    position:absolute;
    inset:0;
    pointer-events:none;
    border-radius:inherit;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.9);
}

/* Executive command ribbon */
.lms-ribbon{
    grid-template-columns:minmax(260px,1.15fr) auto minmax(320px,.95fr);
    padding:17px 22px;
    background:rgba(255,255,255,.965);
    border-bottom:1px solid #dbe8ea;
    box-shadow:0 10px 34px rgba(17,75,82,.055);
}
.lms-brand-icon{
    width:44px;height:44px;border-radius:13px;
    background:linear-gradient(145deg,#e9fbfc,#ffffff);
    border:1px solid #bae4e8;
    box-shadow:0 10px 26px rgba(13,141,153,.13), inset 0 1px 0 #fff;
}
.lms-kicker{font-size:9px;letter-spacing:.16em;font-weight:800;color:var(--ep-teal)}
.lms-title{font-size:16px;font-weight:780;color:var(--ep-ink)}
.lms-session-meta{border-radius:14px;background:linear-gradient(180deg,#fff,#f8fbfb);box-shadow:0 8px 24px rgba(28,77,82,.045)}
.lms-meta{padding:10px 15px;min-width:98px}
.lms-meta strong{font-size:12.5px}

/* Enterprise policy / governance bar */
.lms-governance-strip{
    position:relative;z-index:3;
    display:grid;
    grid-template-columns:minmax(220px,1.15fr) repeat(4,minmax(145px,.72fr));
    gap:8px;
    padding:12px 18px 0;
}
.lms-governance-intro,
.lms-governance-item{
    min-height:62px;
    border:1px solid #dde9eb;
    border-radius:15px;
    background:rgba(255,255,255,.9);
    box-shadow:0 8px 24px rgba(26,72,77,.04);
}
.lms-governance-intro{padding:12px 14px;display:flex;align-items:center;gap:11px}
.lms-governance-mark{
    width:34px;height:34px;display:grid;place-items:center;border-radius:11px;
    color:#fff;background:linear-gradient(135deg,var(--ep-teal),var(--ep-cyan));
    box-shadow:0 8px 20px rgba(13,141,153,.18);font-weight:800;font-size:13px
}
.lms-governance-intro small,.lms-governance-item small{display:block;text-transform:uppercase;letter-spacing:.10em;font-size:8px;font-weight:800;color:#97a5a8}
.lms-governance-intro strong{display:block;margin-top:3px;font-size:12px;color:#202526}
.lms-governance-item{padding:11px 12px;display:flex;align-items:center;gap:9px}
.lms-governance-dot{width:8px;height:8px;border-radius:50%;background:#18ae9a;box-shadow:0 0 0 5px rgba(24,174,154,.09);flex:0 0 auto}
.lms-governance-dot.is-warn{background:#d89b30;box-shadow:0 0 0 5px rgba(216,155,48,.09)}
.lms-governance-item strong{display:block;margin-top:3px;font-size:11px;color:#2a3031;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

/* Blueprint shell */
.lms-map-shell{padding:14px 18px 12px}
.lms-map-toolbar{
    border-radius:18px;
    padding:15px 16px;
    background:linear-gradient(180deg,rgba(255,255,255,.98),rgba(249,252,252,.96));
    border:1px solid #d9e7e9;
    box-shadow:0 12px 34px rgba(22,73,79,.055);
}
.lms-toolbar-title h3{font-size:16px;letter-spacing:-.02em}
.lms-toolbar-title p{font-size:11.5px}
.lms-health-hud{border-radius:15px;padding:10px 12px;min-width:320px}
.lms-health-ring{width:48px;height:48px;box-shadow:0 0 0 6px rgba(19,182,196,.045)}

/* True enterprise mapper frame */
.lms-map-grid{
    grid-template-columns:230px minmax(170px,250px) minmax(390px,1fr);
    border-radius:22px;
    border:1px solid #d7e6e8;
    overflow:hidden;
    background:#fff;
    box-shadow:0 22px 58px rgba(23,72,78,.085);
}
.lms-map-grid::before{
    content:"STRICT 1:1 ROUTING";
    position:absolute;left:50%;top:11px;transform:translateX(-50%);
    z-index:5;padding:4px 9px;border-radius:999px;
    border:1px solid #d6e6e8;background:rgba(255,255,255,.92);
    font-size:7.5px;font-weight:850;letter-spacing:.13em;color:#819194;
}
.lms-col-head{min-height:58px;padding:13px 14px;background:linear-gradient(180deg,#fff,#fbfdfd)}
.lms-col-head strong{font-size:12px;font-weight:800;letter-spacing:-.01em}
.lms-col-head span{font-size:9.5px}
.lms-count-badge{border-radius:999px;padding:4px 8px;font-size:8px;font-weight:800;letter-spacing:.04em}

/* Source inventory */
.lms-source-list,.lms-dest-list{padding:12px}
.lms-source-token{
    min-height:58px;border-radius:14px;padding:10px 12px;
    background:linear-gradient(180deg,#ffffff,#fbfdfd);
    border:1px solid #dce8ea;
    box-shadow:0 6px 16px rgba(27,72,77,.035);
}
.lms-source-token::before{
    content:attr(data-col-no);
    position:absolute;left:-7px;top:50%;transform:translateY(-50%);
    width:18px;height:18px;border-radius:7px;display:grid;place-items:center;
    background:#f0f7f8;border:1px solid #d5e6e8;color:#839397;font-size:7px;font-weight:850
}
.lms-source-token:hover{transform:translateY(-1px);box-shadow:0 12px 26px rgba(25,88,95,.075)}
.lms-source-token.is-connected{
    background:linear-gradient(90deg,rgba(19,182,196,.10),#fff 64%);
    border-color:rgba(13,141,153,.30)
}
.lms-source-name{font-weight:760}
.lms-source-state{border:1px solid #dfe9eb;border-radius:999px;padding:3px 7px;background:#f9fbfb;font-size:7.5px;font-weight:800;letter-spacing:.05em}
.lms-source-token.is-connected .lms-source-state{background:#eaf9f7;border-color:#bfe9e3;color:#128576}

/* Routing engine */
.lms-graph-col{
    position:relative;
    background:
      radial-gradient(circle at 50% 44%, rgba(19,182,196,.09), transparent 31%),
      radial-gradient(circle,rgba(13,141,153,.10) 1px,transparent 1.2px);
    background-size:auto,20px 20px;
}
.lms-graph-stage{min-height:100%;padding:30px 14px 22px}
.lms-graph-center{gap:6px}
.lms-graph-orb{
    width:96px;height:96px;
    border-color:#b9dfe3;
    background:radial-gradient(circle,#ffffff 0 34%,rgba(19,182,196,.10) 35% 58%,transparent 59%);
    box-shadow:0 0 0 18px rgba(19,182,196,.035),0 18px 44px rgba(13,141,153,.10)
}
.lms-graph-orb::before{inset:11px;border-style:dashed;animation:ep-spin 14s linear infinite}
.lms-graph-orb::after{inset:24px;animation:ep-spin-rev 9s linear infinite}
@keyframes ep-spin{to{transform:rotate(360deg)}}
@keyframes ep-spin-rev{to{transform:rotate(-360deg)}}
.lms-graph-center strong{font-size:9px;letter-spacing:.16em;color:#20595f}
.lms-graph-center span{max-width:155px;text-align:center;font-size:9px;color:#849397}
.lms-graph-hint{font-size:8.5px}

/* Destination cartridges */
.lms-dest-node{
    border-radius:15px;padding:11px 12px;
    background:linear-gradient(180deg,#fff,#fbfdfd);
    border:1px solid #dce8ea;
    box-shadow:0 6px 16px rgba(27,72,77,.035)
}
.lms-dest-node[data-status="auto"],.lms-dest-node[data-status="manual"]{
    border-color:rgba(13,141,153,.28);
    background:linear-gradient(90deg,rgba(19,182,196,.035),#fff 32%)
}
.lms-dest-head{margin-bottom:8px}
.lms-dest-label{font-size:12px;font-weight:800}
.lms-dest-tag{font-size:7.5px;font-weight:850;letter-spacing:.06em;text-transform:uppercase;border-radius:999px;padding:3px 7px;background:#f1f5f5;border:1px solid #e0eaeb}
.lms-dest-tag.is-required{background:#fff3f4;border-color:#f3d4d8;color:#c84a59}
.lms-select{height:38px;border-radius:10px;font-weight:650;padding-left:34px}
.lms-status{font-size:9px;font-weight:720}

/* Review command theatre */
.lms-review-deck{
    display:grid;grid-template-columns:minmax(260px,320px) 1fr;gap:12px;
    padding:0 18px 12px
}
.lms-intelligence-rail,.lms-inspector{
    border-radius:18px;border:1px solid #d8e6e8;
    background:linear-gradient(180deg,#fff,#fbfdfd);
    box-shadow:0 16px 42px rgba(26,72,77,.065)
}
.lms-intelligence-rail{padding:15px}
.lms-intel-kicker{color:var(--ep-teal);letter-spacing:.15em}
.lms-intel-card{border-radius:13px;background:linear-gradient(180deg,#fff,#f8fbfb);box-shadow:0 6px 16px rgba(30,72,77,.035)}
.lms-intel-icon{background:linear-gradient(145deg,#e7f8fa,#f6ffff);color:var(--ep-teal);border:1px solid #cce9ec}
.lms-inspector__bar{min-height:54px;padding:11px 13px}
.lms-live{border:1px solid #bde8e2;background:#eefaf8;color:#128674;border-radius:999px;padding:4px 8px;font-size:8px;font-weight:850;letter-spacing:.08em}
.lms-inspector__body{height:330px}

/* Executive command dock */
.lms-command-dock{
    margin:0 18px 16px;
    border-radius:17px;
    padding:11px 13px;
    border:1px solid #d4e4e6;
    background:rgba(255,255,255,.97);
    box-shadow:0 22px 56px rgba(22,68,74,.13)
}
.lms-command-stat{padding-right:14px;border-right:1px solid #e1ebec}
.lms-command-stat:last-of-type{border-right:0}
.lms-import-btn{
    min-height:44px;border-radius:12px;padding:0 20px;
    background:linear-gradient(135deg,#17191a 0%,#26383a 42%,#0d8d99 100%);
    box-shadow:0 12px 30px rgba(13,141,153,.20),inset 0 1px rgba(255,255,255,.12);
    letter-spacing:.01em
}
.lms-import-btn:hover:not(:disabled){transform:translateY(-1px);box-shadow:0 16px 34px rgba(13,141,153,.25)}

/* Premium focus and hover tracing */
.lms-source-token.is-highlight,.lms-dest-node.is-highlight{
    border-color:#0d8d99;
    box-shadow:0 0 0 4px rgba(13,141,153,.08),0 16px 34px rgba(18,91,99,.10)
}
.lms-edge.is-highlight{filter:drop-shadow(0 0 5px rgba(13,141,153,.30))}

/* Enterprise SweetAlert */
.lms-swal-popup{border-radius:20px!important;border-color:#d6e7e9!important;box-shadow:0 34px 90px rgba(17,61,67,.18)!important}
.lms-swal-confirm{border-radius:10px!important;background:linear-gradient(135deg,#17191a,#0d8d99)!important}

@media(max-width:1280px){
    .lms-governance-strip{grid-template-columns:1fr repeat(2,1fr)}
    .lms-governance-intro{grid-column:1 / -1}
    .lms-map-grid{grid-template-columns:210px minmax(140px,190px) minmax(340px,1fr)}
}
@media(max-width:1024px){
    .lms-governance-strip{grid-template-columns:1fr 1fr}
    .lms-ribbon{grid-template-columns:1fr;gap:10px}
    .lms-review-deck{grid-template-columns:1fr}
}
@media(max-width:768px){
    .lead-map-studio{border-radius:16px}
    .lms-governance-strip{grid-template-columns:1fr;padding:10px 12px 0}
    .lms-governance-intro{grid-column:auto}
    .lms-map-shell{padding:12px}
    .lms-map-grid{grid-template-columns:1fr}
    .lms-map-grid::before{display:none}
    .lms-review-deck{padding:0 12px 12px}
    .lms-command-dock{margin:0 12px 12px}
}
</style>


<style>
/* ==========================================================
   CODE SPARROW QUANTUM ENTERPRISE — V5
   Frontend-only visual/UX refinement. Backend contract intact.
   ========================================================== */

.lead-map-studio{
    --q-teal:#0d8f99;
    --q-cyan:#15b8c6;
    --q-ink:#15191a;
    --q-muted:#748589;
    --q-soft:#f5fafb;
    --q-panel:#ffffff;
    --q-line:#d8e6e8;
    --q-green:#159b82;
    --q-red:#d84f60;
    --q-amber:#c68b32;
    border-radius:26px;
    background:
      radial-gradient(circle at 8% -4%, rgba(21,184,198,.12), transparent 25%),
      radial-gradient(circle at 96% 4%, rgba(13,143,153,.08), transparent 20%),
      linear-gradient(180deg,#ffffff 0%,#f8fbfc 48%,#f2f7f8 100%);
    box-shadow:0 30px 90px rgba(25,73,78,.13);
}
.lead-map-studio::before{
    opacity:.42;
    background-image:
      linear-gradient(rgba(13,143,153,.035) 1px,transparent 1px),
      linear-gradient(90deg,rgba(13,143,153,.035) 1px,transparent 1px),
      radial-gradient(circle,rgba(21,184,198,.11) 1px,transparent 1.1px);
    background-size:34px 34px,34px 34px,17px 17px;
}

/* Header upgrade */
.lms-ribbon{
    min-height:82px;
    border-bottom-color:#d9e7e9;
    background:rgba(255,255,255,.94);
    box-shadow:0 14px 40px rgba(27,76,81,.06);
}
.lms-brand-icon{
    position:relative;
    overflow:hidden;
}
.lms-brand-icon::after{
    content:"";
    position:absolute;
    width:24px;height:24px;
    border-radius:50%;
    right:-9px;top:-8px;
    background:rgba(21,184,198,.16);
}
.lms-title{font-size:17px}
.lms-subtitle{font-size:11.5px}

/* Executive cockpit */
.lms-enterprise-cockpit{
    position:relative;
    z-index:5;
    display:grid;
    grid-template-columns:minmax(250px,1.15fr) repeat(4,minmax(135px,.7fr)) minmax(170px,.8fr);
    gap:9px;
    padding:12px 18px 0;
}
.lms-cockpit-main,
.lms-cockpit-metric,
.lms-cockpit-visual{
    border:1px solid var(--q-line);
    background:rgba(255,255,255,.94);
    border-radius:16px;
    box-shadow:0 10px 28px rgba(24,73,78,.045);
}
.lms-cockpit-main{
    padding:13px 14px;
    display:flex;
    align-items:center;
    gap:12px;
}
.lms-cockpit-brand{
    width:38px;height:38px;border-radius:12px;
    display:grid;place-items:center;
    color:#fff;font-size:10px;font-weight:900;letter-spacing:.08em;
    background:linear-gradient(135deg,#0d8f99,#15b8c6);
    box-shadow:0 10px 24px rgba(13,143,153,.22);
}
.lms-cockpit-main small,
.lms-cockpit-metric small,
.lms-cockpit-visual small{
    display:block;
    font-size:8px;
    font-weight:850;
    letter-spacing:.12em;
    text-transform:uppercase;
    color:#95a4a7;
}
.lms-cockpit-main strong{
    display:block;
    margin-top:3px;
    font-size:12.5px;
    color:#202526;
}
.lms-cockpit-main p{
    margin:3px 0 0;
    font-size:9.5px;
    color:#87979a;
}
.lms-cockpit-metric{
    position:relative;
    padding:11px 12px;
    overflow:hidden;
}
.lms-cockpit-metric::after{
    content:"";
    position:absolute;
    right:-14px;bottom:-18px;
    width:52px;height:52px;border-radius:50%;
    background:rgba(21,184,198,.055);
}
.lms-cockpit-metric strong{
    display:block;
    margin-top:4px;
    font-size:15px;
    letter-spacing:-.02em;
    color:#1e2526;
}
.lms-cockpit-metric span{
    display:flex;
    align-items:center;
    gap:6px;
    margin-top:4px;
    font-size:8.5px;
    color:#87979a;
}
.lms-cockpit-dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--q-green);
    box-shadow:0 0 0 4px rgba(21,155,130,.08);
}
.lms-cockpit-dot.is-warn{
    background:var(--q-amber);
    box-shadow:0 0 0 4px rgba(198,139,50,.08);
}
.lms-cockpit-visual{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:11px;
    padding:9px 12px;
}
.lms-cockpit-gauge{
    --v:0deg;
    width:46px;height:46px;border-radius:50%;
    position:relative;flex:0 0 auto;
    background:conic-gradient(var(--q-teal) var(--v),#e4edef 0);
}
.lms-cockpit-gauge::before{
    content:"";
    position:absolute;inset:6px;border-radius:50%;background:#fff;
}
.lms-cockpit-gauge b{
    position:absolute;inset:0;display:grid;place-items:center;
    z-index:1;font-size:9px;color:#243032;
}
.lms-cockpit-visual strong{
    display:block;margin-top:3px;font-size:10.5px;color:#22292a;
}

/* Mapping toolbar upgrades */
.lms-map-toolbar{
    grid-template-columns:minmax(0,1fr) auto;
}
.lms-toolbar-actions{
    display:flex;
    gap:7px;
    align-items:center;
    flex-wrap:wrap;
}
.lms-schema-search{
    position:relative;
    min-width:190px;
}
.lms-schema-search input{
    width:100%;
    border:1px solid #d9e6e8;
    border-radius:10px;
    background:#fff;
    color:#252a2b;
    font-size:10.5px;
    padding:8px 30px 8px 10px;
    outline:none;
}
.lms-schema-search input:focus{
    border-color:#8fc8ce;
    box-shadow:0 0 0 3px rgba(13,143,153,.08);
}
.lms-schema-search svg{
    position:absolute;right:9px;top:50%;transform:translateY(-50%);
    width:13px;height:13px;color:#91a0a3;pointer-events:none;
}
.lms-density-switch{
    display:flex;
    padding:3px;
    border:1px solid #d9e6e8;
    border-radius:10px;
    background:#f8fbfb;
}
.lms-density-btn{
    border:0;background:transparent;color:#87979a;
    font-size:9px;font-weight:800;
    padding:6px 8px;border-radius:7px;cursor:pointer;
}
.lms-density-btn.is-active{
    background:#fff;color:#0d8f99;
    box-shadow:0 4px 12px rgba(21,93,101,.09);
}

/* Graph superstructure */
.lms-map-grid{
    grid-template-columns:245px minmax(190px,270px) minmax(400px,1fr);
    border-radius:24px;
    box-shadow:0 24px 66px rgba(25,74,80,.095);
}
.lms-map-grid::after{
    content:"LIVE ROUTING FABRIC";
    position:absolute;
    left:50%;bottom:8px;transform:translateX(-50%);
    z-index:3;
    padding:4px 9px;
    border-radius:999px;
    border:1px solid #d7e7e9;
    background:rgba(255,255,255,.92);
    font-size:7px;
    font-weight:900;
    letter-spacing:.14em;
    color:#8ba0a3;
}
.lms-graph-col{
    background:
      radial-gradient(circle at 50% 48%,rgba(21,184,198,.10),transparent 28%),
      linear-gradient(180deg,rgba(13,143,153,.028),rgba(21,184,198,.015)),
      radial-gradient(circle,rgba(13,143,153,.10) 1px,transparent 1.15px);
    background-size:auto,auto,18px 18px;
}
.lms-graph-center{
    position:relative;
}
.lms-graph-center::before,
.lms-graph-center::after{
    content:"";
    position:absolute;
    inset:-16px;
    border:1px solid rgba(13,143,153,.10);
    border-radius:50%;
}
.lms-graph-center::after{inset:-30px;opacity:.5}
.lms-edge-layer{filter:drop-shadow(0 2px 2px rgba(13,143,153,.08))}
.lms-edge--auto{stroke-width:2.2}
.lms-edge--manual{stroke-width:2.2}

/* Nodes */
.lms-source-token,
.lms-dest-node{
    transition:transform .18s ease,border-color .18s ease,box-shadow .18s ease,background .18s ease;
}
.lms-source-token:hover,
.lms-dest-node:hover{
    transform:translateY(-2px);
    box-shadow:0 15px 32px rgba(24,83,90,.09);
}
.lms-source-token.is-highlight,
.lms-dest-node.is-highlight{
    border-color:#74c4cb!important;
    box-shadow:0 0 0 3px rgba(21,184,198,.075),0 16px 34px rgba(21,91,99,.10);
}
.lms-source-token.is-connected::after{
    content:"";
    position:absolute;
    left:0;top:9px;bottom:9px;width:3px;
    border-radius:0 3px 3px 0;
    background:linear-gradient(#0d8f99,#15b8c6);
}

/* Data review cockpit */
.lms-review-deck{
    grid-template-columns:320px minmax(0,1fr);
    gap:16px;
}
.lms-intelligence-rail{
    position:relative;
    overflow:hidden;
}
.lms-intelligence-rail::after{
    content:"";
    position:absolute;
    width:130px;height:130px;border-radius:50%;
    right:-55px;bottom:-60px;
    background:radial-gradient(circle,rgba(21,184,198,.10),transparent 68%);
    pointer-events:none;
}
.lms-intel-grid{grid-template-columns:1fr}
.lms-intel-card{
    min-height:58px;
}
.lms-intel-card strong{font-size:12px}
.lms-inspector{
    border-radius:18px;
}
.lms-inspector__bar{
    min-height:54px;
}
.lms-inspector__body{
    height:340px;
}

/* Sticky action deck */
.lms-command-dock{
    border-radius:16px;
    padding:11px 13px;
    box-shadow:0 20px 54px rgba(24,73,78,.12);
}
.lms-import-btn{
    min-width:150px;
    justify-content:center;
    border-radius:11px;
    background:linear-gradient(135deg,#0d8f99,#15b8c6);
    box-shadow:0 12px 28px rgba(13,143,153,.22);
}

/* Compact density */
.lead-map-studio.is-compact .lms-source-token{min-height:48px;padding:8px 10px}
.lead-map-studio.is-compact .lms-dest-node{padding:9px 10px}
.lead-map-studio.is-compact .lms-dest-head{margin-bottom:6px}
.lead-map-studio.is-compact .lms-select{padding-top:7px;padding-bottom:7px}
.lead-map-studio.is-compact .lms-source-list,
.lead-map-studio.is-compact .lms-dest-list{gap:7px}

/* Search hiding */
.lms-source-token.is-search-hidden,
.lms-dest-node.is-search-hidden{display:none!important}

/* Responsive */
@media(max-width:1380px){
  .lms-enterprise-cockpit{grid-template-columns:minmax(220px,1fr) repeat(2,minmax(130px,.7fr)) minmax(150px,.75fr)}
  .lms-enterprise-cockpit .lms-cockpit-metric:nth-of-type(4),
  .lms-enterprise-cockpit .lms-cockpit-metric:nth-of-type(5){display:none}
}
@media(max-width:1180px){
  .lms-enterprise-cockpit{grid-template-columns:1fr 1fr 1fr}
  .lms-cockpit-main{grid-column:1 / -1}
  .lms-map-grid{grid-template-columns:215px minmax(145px,200px) minmax(330px,1fr)}
  .lms-review-deck{grid-template-columns:260px minmax(0,1fr)}
}
@media(max-width:900px){
  .lms-enterprise-cockpit{grid-template-columns:1fr 1fr}
  .lms-cockpit-main,.lms-cockpit-visual{grid-column:1 / -1}
  .lms-review-deck{grid-template-columns:1fr}
  .lms-toolbar-actions{width:100%;justify-content:flex-start}
  .lms-schema-search{flex:1;min-width:180px}
}
@media(max-width:768px){
  .lms-enterprise-cockpit{padding:10px 12px 0}
  .lms-map-grid{grid-template-columns:1fr}
  .lms-graph-col{display:none}
  .lms-toolbar-actions{display:grid;grid-template-columns:1fr}
  .lms-density-switch{width:max-content}
  .lms-review-deck{margin-left:12px;margin-right:12px}
}
@media(max-width:520px){
  .lms-enterprise-cockpit{grid-template-columns:1fr}
  .lms-cockpit-main,.lms-cockpit-visual{grid-column:auto}
  .lms-command-dock{grid-template-columns:1fr 1fr}
  .lms-import-btn{grid-column:1 / -1;width:100%}
}

/* ==========================================================
   V5.1 — TRUE ROW-LOCKED SCHEMA ALIGNMENT
   Source nodes are visually locked to their CRM destination row.
   ========================================================== */

@media (min-width: 769px) {
    .lms-source-list,
    .lms-dest-list {
        display: grid !important;
        grid-template-columns: 1fr;
        grid-auto-rows: 92px;
        gap: 8px !important;
        align-content: start;
    }

    .lms-source-token,
    .lms-dest-node {
        min-height: 92px !important;
        height: 92px;
        margin: 0 !important;
    }

    .lms-source-token {
        align-self: stretch;
        display: grid;
        grid-template-columns: 34px minmax(0, 1fr);
        grid-template-rows: auto auto;
        align-content: center;
    }

    .lms-dest-node {
        align-self: stretch;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .lms-source-list {
        position: relative;
    }

    .lms-source-token.is-unassigned-tail {
        opacity: .78;
        border-style: dashed;
        background: #fbfdfd;
    }

    .lms-source-token.is-row-locked {
        opacity: 1;
    }

    .lms-source-token.is-row-locked::before {
        content: "SYNC";
        position: absolute;
        right: 8px;
        bottom: 7px;
        font-size: 6.5px;
        font-weight: 900;
        letter-spacing: .11em;
        color: #8aa5a8;
    }

    .lms-source-token.is-row-locked.is-connected::before {
        color: #168879;
    }

    .lms-graph-col {
        position: relative;
    }

    .lms-graph-col::before {
        content: "";
        position: absolute;
        inset: 12px 0;
        pointer-events: none;
        background:
            repeating-linear-gradient(
                to bottom,
                transparent 0,
                transparent 91px,
                rgba(13,143,153,.085) 91px,
                rgba(13,143,153,.085) 92px,
                transparent 92px,
                transparent 100px
            );
        opacity: .7;
    }

    .lms-edge {
        stroke-linecap: round;
    }

    .lms-edge.is-horizontal {
        stroke-width: 2.35px;
    }
}

/* Small visual lane labels */
.lms-lane-index {
    position: absolute;
    left: -7px;
    top: 50%;
    transform: translate(-100%, -50%);
    width: 17px;
    height: 17px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    border: 1px solid #d7e7e9;
    background: #fff;
    color: #8ba0a3;
    font-size: 6.5px;
    font-weight: 900;
    box-shadow: 0 4px 10px rgba(25,74,80,.05);
}

.lms-dest-node {
    overflow: visible;
}

</style>

<div class="lead-map-studio">

    <div class="lms-notifications">
        @if ($errors->any())
            <div class="lms-notice lms-notice--danger">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 8v5m0 3h.01M10.3 4.8 2.8 18a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 4.8a2 2 0 0 0-3.4 0Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                <div>
                    <strong>Upload Error</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('error_message'))
            <div class="lms-notice lms-notice--danger">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 8v5m0 3h.01M10.3 4.8 2.8 18a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 4.8a2 2 0 0 0-3.4 0Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                <div>{{ session('error_message') }}</div>
            </div>
        @endif

        @if (session('success_message'))
            <div class="lms-notice lms-notice--success">
                <svg viewBox="0 0 24 24" fill="none"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div>{{ session('success_message') }}</div>
            </div>
        @endif
    </div>

    <form action="{{ route('admin.leads.import') }}" method="POST" id="leadMappingForm" class="lms-form">
        @csrf

        <header class="lms-ribbon">
            <div class="lms-ribbon__brand">
                <div class="lms-brand-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3h7L20 9.5V18a3 3 0 0 1-3 3H6a2 2 0 0 1-2-2V5.5Z" stroke="currentColor" stroke-width="1.7"/><path d="M13 3v7h7M8 14h8M8 17h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                </div>
                <div class="lms-brand-copy">
                    <div class="lms-kicker">Code Sparrow Data Studio</div>
                    <div class="lms-title">Lead Import Mapping Command Center</div>
                    <div class="lms-subtitle">Visually route uploaded data into your CRM schema with live validation.</div>
                </div>
            </div>

            <div class="lms-session-meta">
                <div class="lms-meta"><span>Sales</span><strong>{{ $salesUser->name }}</strong></div>
                <div class="lms-meta"><span>Category</span><strong>{{ $leadCategory->title }}</strong></div>
                <div class="lms-meta"><span>Columns</span><strong>{{ count($headers) }}</strong></div>
                <div class="lms-meta"><span>CRM Fields</span><strong>{{ count($fields) }}</strong></div>
            </div>

            <div class="lms-steps" aria-label="Import progress">
                <div class="lms-step is-done"><span class="lms-step__dot"></span><span>Upload</span></div>
                <span class="lms-step__line is-done"></span>
                <div class="lms-step is-active"><span class="lms-step__dot"></span><span>Map</span></div>
                <span class="lms-step__line"></span>
                <div class="lms-step"><span class="lms-step__dot"></span><span>Verify</span></div>
                <span class="lms-step__line"></span>
                <div class="lms-step"><span class="lms-step__dot"></span><span>Import</span></div>
            </div>
        </header>

        <section class="lms-enterprise-cockpit" aria-label="Enterprise mapping telemetry">
            <div class="lms-cockpit-main">
                <div class="lms-cockpit-brand">CS</div>
                <div>
                    <small>Enterprise Data Mission</small>
                    <strong>Lead Schema Transformation Session</strong>
                    <p>Live 1:1 routing, validation and import readiness telemetry.</p>
                </div>
            </div>
            <div class="lms-cockpit-metric">
                <small>Connected Fields</small>
                <strong id="cockpitConnected">0 / {{ count($fields) }}</strong>
                <span><i class="lms-cockpit-dot"></i> Live schema coverage</span>
            </div>
            <div class="lms-cockpit-metric">
                <small>Required Gate</small>
                <strong id="cockpitRequired">Checking</strong>
                <span><i class="lms-cockpit-dot is-warn" id="cockpitRequiredDot"></i> Import policy</span>
            </div>
            <div class="lms-cockpit-metric">
                <small>Source Utilization</small>
                <strong id="cockpitSource">0 / {{ count($headers) }}</strong>
                <span><i class="lms-cockpit-dot"></i> Columns in use</span>
            </div>
            <div class="lms-cockpit-metric">
                <small>Conflict Monitor</small>
                <strong>Strict 1:1</strong>
                <span><i class="lms-cockpit-dot"></i> Duplicate lock</span>
            </div>
            <div class="lms-cockpit-visual">
                <div class="lms-cockpit-gauge" id="cockpitGauge"><b id="cockpitPercent">0%</b></div>
                <div><small>Schema Confidence</small><strong id="cockpitConfidence">Initializing</strong></div>
            </div>
        </section>

        <section class="lms-governance-strip" aria-label="Import governance">
            <div class="lms-governance-intro">
                <span class="lms-governance-mark">CS</span>
                <div>
                    <small>Enterprise Mapping Policy</small>
                    <strong>Code Sparrow Data Integrity Guard</strong>
                </div>
            </div>
            <div class="lms-governance-item">
                <span class="lms-governance-dot"></span>
                <div><small>Schema Guard</small><strong>Active</strong></div>
            </div>
            <div class="lms-governance-item">
                <span class="lms-governance-dot"></span>
                <div><small>Duplicate Lock</small><strong>Strict 1:1</strong></div>
            </div>
            <div class="lms-governance-item">
                <span class="lms-governance-dot is-warn" id="governanceRequiredDot"></span>
                <div><small>Required Gate</small><strong id="governanceRequired">Checking</strong></div>
            </div>
            <div class="lms-governance-item">
                <span class="lms-governance-dot"></span>
                <div><small>Preview Channel</small><strong>Live</strong></div>
            </div>
        </section>

        <section class="lms-map-shell">
            <div class="lms-map-toolbar">
                <div class="lms-toolbar-title">
                    <h3>Data Flow Blueprint</h3>
                    <p>Source schema on the left, validated CRM destinations on the right, live mapping intelligence in between.</p>
                </div>

                <div class="lms-toolbar-actions">
                    <div class="lms-schema-search">
                        <input type="search" id="schemaSearch" placeholder="Search source or CRM field…" autocomplete="off">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.7"/><path d="m16 16 4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                    </div>
                    <div class="lms-density-switch" aria-label="Mapping density">
                        <button type="button" class="lms-density-btn is-active" data-density="comfortable">Comfort</button>
                        <button type="button" class="lms-density-btn" data-density="compact">Compact</button>
                    </div>
                    <div class="lms-health-hud">
                        <div class="lms-health-ring" id="healthRing"><strong id="healthPercent">0%</strong></div>
                        <div class="lms-health-copy">
                            <span>Mapping Health</span>
                            <strong id="healthConnected">0 / {{ count($fields) }} connected</strong>
                            <small id="healthRequired">Required fields checking…</small>
                        </div>
                    </div>

                    <div class="lms-filter-set" aria-label="Mapping filters">
                        <button type="button" class="lms-filter-btn is-active" data-filter="all">All</button>
                        <button type="button" class="lms-filter-btn" data-filter="required">Required</button>
                        <button type="button" class="lms-filter-btn" data-filter="unmapped">Unmapped</button>
                    </div>
                </div>
            </div>

            <div class="lms-map-grid" id="mapGrid">
                <svg class="lms-edge-layer" id="edgeLayer" aria-hidden="true"></svg>

                <section class="lms-column lms-source-col">
                    <div class="lms-col-head">
                        <div><strong>Source Schema</strong><span>Uploaded file columns</span></div>
                        <span class="lms-count-badge">{{ count($headers) }} columns</span>
                    </div>
                    <div class="lms-source-list" id="sourceList">
                        @foreach($headers as $index => $header)
                            @if(trim((string) $header) !== '')
                                <div class="lms-source-token" data-col-no="{{ $loop->iteration }}" data-source-index="{{ $index }}" id="source-token-{{ $index }}" tabindex="0">
                                    <span class="lms-source-icon" aria-hidden="true">
                                        <svg viewBox="0 0 16 16" fill="none"><path d="M3 3h10M3 8h10M3 13h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                    </span>
                                    <span class="lms-source-copy">
                                        <span class="lms-source-name" title="{{ $header }}">{{ $header }}</span>
                                        <span class="lms-source-type">Source Field</span>
                                    </span>
                                    <span class="lms-source-state">Available</span>
                                    <span class="lms-source-socket" aria-hidden="true"></span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>

                <section class="lms-column lms-graph-col">
                    <div class="lms-col-head">
                        <div><strong>Flow Router</strong><span>Live schema connections</span></div>
                        <span class="lms-count-badge" id="graphConnectedBadge">0 live</span>
                    </div>
                    <div class="lms-graph-stage">
                        <div class="lms-graph-label">Schema pipeline</div>
                        <div class="lms-graph-center">
                            <div class="lms-graph-orb" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M6 7h5m2 0h5M6 17h5m2 0h5M8.5 7v10m7-10v10" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                            </div>
                            <strong>SPARROW ROUTER</strong>
                            <span id="graphCenterStatus">Waiting for required mappings</span>
                        </div>
                        <div class="lms-graph-hint">Hover a connected field to trace its mapping.</div>
                    </div>
                </section>

                <section class="lms-column lms-dest-col">
                    <div class="lms-col-head">
                        <div><strong>CRM Destination</strong><span>Lead fields</span></div>
                        <span class="lms-count-badge">{{ count($fields) }} fields</span>
                    </div>
                    <div class="lms-dest-list" id="destList">
                        @foreach($fields as $field => $config)
                            @php
                                $mapped = $autoMapping[$field] ?? '';
                                $isMatched = $mapped !== '';
                            @endphp

                            <div class="lms-dest-node"
                                 data-field="{{ $field }}"
                                 data-required="{{ $config['required'] ? '1' : '0' }}"
                                 id="dest-node-{{ $field }}">
                                <span class="lms-dest-socket" aria-hidden="true"></span>
                                <div class="lms-dest-head">
                                    <span class="lms-dest-label">{{ $config['label'] }}</span>
                                    <span class="lms-dest-tag {{ $config['required'] ? 'is-required' : '' }}">
                                        {{ $config['required'] ? 'Required' : 'Optional' }}
                                    </span>
                                </div>
                                <div class="lms-dest-body">
                                    <div class="lms-select-wrap">
                                        <select
                                            name="mapping[{{ $field }}]"
                                            class="mapping-select lms-select"
                                            data-field="{{ $field }}"
                                            data-initial-exact="{{ $isMatched ? '1' : '0' }}"
                                            {{ $config['required'] ? 'required' : '' }}
                                        >
                                            <option value="">— Do Not Import —</option>
                                            @foreach($headers as $index => $header)
                                                @if(trim((string) $header) !== '')
                                                    <option value="{{ $index }}" {{ (string) $mapped === (string) $index ? 'selected' : '' }}>
                                                        {{ $header }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="lms-status"><span class="lms-status-text">Checking…</span></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </section>

        <section class="lms-review-deck">
            <aside class="lms-intelligence-rail" aria-label="Import intelligence">
                <div class="lms-intel-head">
                    <span class="lms-intel-kicker">LIVE INTELLIGENCE</span>
                    <strong>Import Readiness</strong>
                    <small>Frontend-only analysis of your current mapping.</small>
                </div>
                <div class="lms-intel-grid">
                    <div class="lms-intel-card">
                        <span class="lms-intel-icon">✓</span>
                        <div><small>Connected</small><strong id="intelConnected">0 / {{ count($fields) }}</strong></div>
                    </div>
                    <div class="lms-intel-card">
                        <span class="lms-intel-icon">!</span>
                        <div><small>Required</small><strong id="intelRequired">Checking</strong></div>
                    </div>
                    <div class="lms-intel-card">
                        <span class="lms-intel-icon">⇄</span>
                        <div><small>Source Coverage</small><strong id="intelCoverage">0 / {{ count($headers) }}</strong></div>
                    </div>
                </div>
                <div class="lms-intel-rule">
                    <span></span>
                    <p>Each uploaded source column can be connected to only one CRM field.</p>
                </div>
            </aside>

            <section class="lms-inspector" id="dataInspector">
            <div class="lms-inspector__bar">
                <div>
                    <div class="lms-inspector__title">Live Data Inspector</div>
                    <div class="lms-inspector__sub">Raw uploaded source file preview</div>
                </div>
                <span class="lms-live">LIVE</span>
                <button type="button" class="lms-tool-btn" id="inspectorExpand" aria-label="Expand inspector" title="Expand">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M8 3H3v5M16 3h5v5M8 21H3v-5M16 21h5v-5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="lms-tool-btn" id="inspectorToggle" aria-label="Collapse inspector" title="Collapse">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M6 12h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                </button>
            </div>
            <div class="lms-inspector__meta">
                <span>{{ count($headers) }} source columns detected</span>
                <span id="inspectorMappedMeta">0 mapped</span>
            </div>
            <div class="lms-inspector__body">
                <iframe src="{{ route('admin.leads.import.preview') }}" title="CSV / Excel Preview"></iframe>
            </div>
            </section>
        </section>

        <div class="lms-command-dock">
            <div class="lms-command-stat">
                <span>Schema Health</span>
                <div class="lms-segments" id="schemaSegments"></div>
            </div>
            <div class="lms-command-stat"><span>Connected</span><strong id="connectedValue">0 / {{ count($fields) }}</strong></div>
            <div class="lms-command-stat"><span>Required</span><strong class="is-bad" id="requiredValue">Checking</strong></div>
            <div class="lms-command-stat"><span>Source Used</span><strong id="sourceUsedValue">0 / {{ count($headers) }}</strong></div>
            <div class="lms-command-ready" id="commandReady"><span>Import Status</span><strong>Not Ready</strong></div>
            <button type="submit" class="lms-import-btn" id="importLeadsBtn">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 4v11m0 0 4-4m-4 4-4-4M5 20h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Import Leads
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('leadMappingForm');
    if (!form) return;

    const selects = Array.from(form.querySelectorAll('.mapping-select'));
    const mapGrid = document.getElementById('mapGrid');
    const edgeLayer = document.getElementById('edgeLayer');
    const sourceList = document.getElementById('sourceList');
    const studio = document.querySelector('.lead-map-studio');
    const schemaSearch = document.getElementById('schemaSearch');
    const densityButtons = Array.from(document.querySelectorAll('.lms-density-btn'));
    const cockpitConnected = document.getElementById('cockpitConnected');
    const cockpitRequired = document.getElementById('cockpitRequired');
    const cockpitRequiredDot = document.getElementById('cockpitRequiredDot');
    const cockpitSource = document.getElementById('cockpitSource');
    const cockpitGauge = document.getElementById('cockpitGauge');
    const cockpitPercent = document.getElementById('cockpitPercent');
    const cockpitConfidence = document.getElementById('cockpitConfidence');
    const filterButtons = Array.from(document.querySelectorAll('.lms-filter-btn'));
    const healthRing = document.getElementById('healthRing');
    const healthPercent = document.getElementById('healthPercent');
    const healthConnected = document.getElementById('healthConnected');
    const healthRequired = document.getElementById('healthRequired');
    const graphConnectedBadge = document.getElementById('graphConnectedBadge');
    const graphCenterStatus = document.getElementById('graphCenterStatus');
    const connectedValue = document.getElementById('connectedValue');
    const requiredValue = document.getElementById('requiredValue');
    const sourceUsedValue = document.getElementById('sourceUsedValue');
    const commandReady = document.getElementById('commandReady');
    const importBtn = document.getElementById('importLeadsBtn');
    const segmentsWrap = document.getElementById('schemaSegments');
    const inspector = document.getElementById('dataInspector');
    const inspectorToggle = document.getElementById('inspectorToggle');
    const inspectorExpand = document.getElementById('inspectorExpand');
    const inspectorMappedMeta = document.getElementById('inspectorMappedMeta');
    const intelConnected = document.getElementById('intelConnected');
    const intelRequired = document.getElementById('intelRequired');
    const intelCoverage = document.getElementById('intelCoverage');
    const governanceRequired = document.getElementById('governanceRequired');
    const governanceRequiredDot = document.getElementById('governanceRequiredDot');

    const totalHeaders = {{ count($headers) }};

    selects.forEach(function () {
        const seg = document.createElement('span');
        seg.className = 'lms-seg';
        segmentsWrap.appendChild(seg);
    });
    const segments = Array.from(segmentsWrap.querySelectorAll('.lms-seg'));

    function destNode(select) {
        return select.closest('.lms-dest-node');
    }

    function sourceToken(index) {
        return document.getElementById('source-token-' + index);
    }

    function getFieldLabel(select) {
        const node = destNode(select);
        const label = node ? node.querySelector('.lms-dest-label') : null;
        return label ? label.textContent.trim() : 'another field';
    }

    function getColumnName(select) {
        if (!select || select.value === '') return '';
        const option = select.options[select.selectedIndex];
        return option ? option.text.trim() : '';
    }

    function findDuplicate(current) {
        if (!current || current.value === '') return null;
        return selects.find(function (other) {
            return other !== current && other.value !== '' && other.value === current.value;
        }) || null;
    }

    function isExact(select) {
        if (select.dataset.initialExact !== '1' || select.value === '') return false;
        const original = Array.from(select.options).find(function (option) {
            return option.defaultSelected;
        });
        return !!original && original.value === select.value;
    }

    function stateOf(select) {
        if (select.value === '') {
            return select.hasAttribute('required') ? 'missing' : 'optional';
        }
        return isExact(select) ? 'auto' : 'manual';
    }

    function updateNode(select) {
        const node = destNode(select);
        if (!node) return;
        const state = stateOf(select);
        node.dataset.status = state;
        const statusText = node.querySelector('.lms-status-text');
        const labels = {
            auto: 'Correct',
            manual: 'Mapped',
            missing: 'Mapping Required',
            optional: 'Optional'
        };
        if (statusText) statusText.textContent = labels[state];
    }


    function normalizeLabel(value) {
        return String(value || '')
            .trim()
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();
    }

    /*
     * Row-lock source schema nodes to destination rows.
     * This is visual only; request names/values are untouched.
     *
     * Priority:
     * 1. A source column currently mapped to a destination.
     * 2. If unmapped, a source heading whose name exactly matches the CRM label.
     * 3. Remaining source columns are placed after the destination rows.
     */
    function syncSourceRows() {
        if (window.innerWidth <= 768 || !sourceList) return;

        const nodes = selects.map(function (select) {
            return {
                select: select,
                node: destNode(select),
                label: getFieldLabel(select)
            };
        });

        const occupiedRows = new Set();
        const assignedTokens = new Set();

        sourceList.querySelectorAll('.lms-source-token').forEach(function (token) {
            token.style.gridRow = '';
            token.classList.remove('is-row-locked', 'is-unassigned-tail');
            token.querySelectorAll('.lms-lane-index').forEach(function (el) { el.remove(); });
        });

        /* Mapped columns get first priority. */
        nodes.forEach(function (item, destinationIndex) {
            if (!item.select || item.select.value === '') return;
            const token = sourceToken(item.select.value);
            if (!token || assignedTokens.has(token)) return;

            const row = destinationIndex + 1;
            token.style.gridRow = String(row);
            token.classList.add('is-row-locked');
            occupiedRows.add(row);
            assignedTokens.add(token);
        });

        /* Exact heading-name suggestion fills an otherwise empty lane. */
        nodes.forEach(function (item, destinationIndex) {
            const row = destinationIndex + 1;
            if (occupiedRows.has(row)) return;

            const target = normalizeLabel(item.label);
            const token = Array.from(sourceList.querySelectorAll('.lms-source-token')).find(function (candidate) {
                if (assignedTokens.has(candidate)) return false;
                const name = candidate.querySelector('.lms-source-name');
                return normalizeLabel(name ? name.textContent : '') === target;
            });

            if (token) {
                token.style.gridRow = String(row);
                token.classList.add('is-row-locked');
                occupiedRows.add(row);
                assignedTokens.add(token);
            }
        });

        /* Remaining source columns live beneath the mapped lanes. */
        let tailRow = selects.length + 1;
        sourceList.querySelectorAll('.lms-source-token').forEach(function (token) {
            if (assignedTokens.has(token)) return;
            while (occupiedRows.has(tailRow)) tailRow++;
            token.style.gridRow = String(tailRow);
            token.classList.add('is-unassigned-tail');
            occupiedRows.add(tailRow);
            tailRow++;
        });

        /* Add lane numbers to destination nodes for faster scanning. */
        nodes.forEach(function (item, index) {
            if (!item.node) return;
            item.node.querySelectorAll('.lms-lane-index').forEach(function (el) { el.remove(); });
            const badge = document.createElement('span');
            badge.className = 'lms-lane-index';
            badge.textContent = String(index + 1).padStart(2, '0');
            item.node.appendChild(badge);
        });
    }

    function updateSourceStates() {
        const used = selects.map(function (s) { return s.value; }).filter(Boolean);
        sourceList.querySelectorAll('.lms-source-token').forEach(function (token) {
            const connected = used.includes(token.dataset.sourceIndex);
            token.classList.toggle('is-connected', connected);
            const state = token.querySelector('.lms-source-state');
            if (state) state.textContent = connected ? 'Connected' : 'Available';
        });
    }

    function updateHealth() {
        let connected = 0;
        let missingRequired = 0;
        let used = 0;

        selects.forEach(function (select) {
            const state = stateOf(select);
            if (state === 'auto' || state === 'manual') connected++;
            if (state === 'missing') missingRequired++;
            if (select.value !== '') used++;
        });

        const percent = selects.length ? Math.round((connected / selects.length) * 100) : 0;
        healthRing.style.setProperty('--p', (percent * 3.6) + 'deg');
        healthPercent.textContent = percent + '%';
        healthConnected.textContent = connected + ' / ' + selects.length + ' connected';
        healthRequired.textContent = missingRequired ? (missingRequired + ' required field' + (missingRequired > 1 ? 's' : '') + ' missing') : 'Required fields ready';
        graphConnectedBadge.textContent = connected + ' live';
        graphCenterStatus.textContent = missingRequired ? 'Waiting for required mappings' : 'Schema ready for import';
        connectedValue.textContent = connected + ' / ' + selects.length;
        sourceUsedValue.textContent = used + ' / ' + totalHeaders;
        inspectorMappedMeta.textContent = connected + ' mapped';
        if (intelConnected) intelConnected.textContent = connected + ' / ' + selects.length;
        if (intelRequired) intelRequired.textContent = missingRequired ? (missingRequired + ' missing') : 'Ready';
        if (intelCoverage) intelCoverage.textContent = used + ' / ' + totalHeaders;
        if (governanceRequired) governanceRequired.textContent = missingRequired ? (missingRequired + ' field' + (missingRequired > 1 ? 's' : '') + ' missing') : 'Ready';
        if (governanceRequiredDot) governanceRequiredDot.classList.toggle('is-warn', missingRequired > 0);

        requiredValue.textContent = missingRequired ? ('Action Required (' + missingRequired + ')') : 'Ready';
        requiredValue.classList.toggle('is-bad', missingRequired > 0);
        requiredValue.classList.toggle('is-good', missingRequired === 0);

        commandReady.classList.toggle('is-ready', missingRequired === 0);
        commandReady.querySelector('strong').textContent = missingRequired ? 'Not Ready' : 'Ready to Import';

        importBtn.disabled = missingRequired > 0;

        segments.forEach(function (seg, i) {
            seg.classList.toggle('is-filled', i < connected);
        });
    }

    function edgeClass(state) {
        return 'lms-edge ' + ({
            auto: 'lms-edge--auto',
            manual: 'lms-edge--manual',
            missing: 'lms-edge--missing',
            optional: 'lms-edge--optional'
        }[state]);
    }

    function drawEdges(pulseField) {
        if (window.innerWidth <= 768) {
            edgeLayer.innerHTML = '';
            return;
        }

        const gridRect = mapGrid.getBoundingClientRect();
        const width = gridRect.width;
        const height = gridRect.height;
        edgeLayer.setAttribute('viewBox', '0 0 ' + width + ' ' + height);
        edgeLayer.setAttribute('width', width);
        edgeLayer.setAttribute('height', height);

        let markup = '<defs>' +
            '<filter id="edgeGlow" x="-30%" y="-30%" width="160%" height="160%"><feGaussianBlur stdDeviation="2.2" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter>' +
            '</defs>';

        selects.forEach(function (select) {
            const node = destNode(select);
            if (!node) return;

            const nodeSocket = node.querySelector('.lms-dest-socket');
            const nodeRect = nodeSocket.getBoundingClientRect();
            const endX = nodeRect.left + nodeRect.width / 2 - gridRect.left;
            const endY = nodeRect.top + nodeRect.height / 2 - gridRect.top;

            let startX = endX - 190;
            let startY = endY;

            if (select.value !== '') {
                const token = sourceToken(select.value);
                if (token) {
                    const sourceSocket = token.querySelector('.lms-source-socket');
                    const sourceRect = sourceSocket.getBoundingClientRect();
                    startX = sourceRect.left + sourceRect.width / 2 - gridRect.left;
                    startY = sourceRect.top + sourceRect.height / 2 - gridRect.top;
                }
            } else {
                const sourceColumn = mapGrid.querySelector('.lms-source-col');
                const sourceRect = sourceColumn.getBoundingClientRect();
                startX = sourceRect.right - gridRect.left + 10;
            }

            const dx = Math.max(70, (endX - startX) * .42);
            const c1x = startX + dx;
            const c2x = endX - dx;
            const path = 'M ' + startX + ' ' + startY + ' C ' + c1x + ' ' + startY + ', ' + c2x + ' ' + endY + ', ' + endX + ' ' + endY;
            const state = stateOf(select);
            const pulse = select.dataset.field === pulseField ? ' is-pulse' : '';
            const horizontal = Math.abs(startY - endY) < 7 ? ' is-horizontal' : '';
            markup += '<path class="' + edgeClass(state) + pulse + horizontal + '" data-edge-field="' + select.dataset.field + '" d="' + path + '"></path>';
        });

        edgeLayer.innerHTML = markup;
    }

    function refreshAll(pulseField) {
        selects.forEach(updateNode);
        updateSourceStates();
        syncSourceRows();
        updateHealth();
        requestAnimationFrame(function () { drawEdges(pulseField); });
    }

    function clearHighlight() {
        sourceList.querySelectorAll('.lms-source-token').forEach(function (token) { token.classList.remove('is-highlight'); });
        document.querySelectorAll('.lms-dest-node').forEach(function (node) { node.classList.remove('is-highlight'); });
        edgeLayer.querySelectorAll('.lms-edge').forEach(function (edge) { edge.classList.remove('is-highlight'); });
    }

    function highlightMapping(select) {
        clearHighlight();
        const node = destNode(select);
        if (node) node.classList.add('is-highlight');
        if (select.value !== '') {
            const token = sourceToken(select.value);
            if (token) token.classList.add('is-highlight');
        }
        const edge = edgeLayer.querySelector('[data-edge-field="' + select.dataset.field + '"]');
        if (edge) edge.classList.add('is-highlight');
    }

    selects.forEach(function (select) {
        select.addEventListener('change', function () {
            const duplicate = findDuplicate(this);
            if (duplicate) {
                const columnName = getColumnName(this);
                const existingField = getFieldLabel(duplicate);
                const currentField = getFieldLabel(this);
                const node = destNode(this);

                this.value = '';
                if (node) {
                    node.classList.add('is-flash');
                    setTimeout(function () { node.classList.remove('is-flash'); }, 360);
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Column Already Connected',
                    text: '"' + columnName + '" is already connected to "' + existingField + '". Choose another source column for "' + currentField + '".',
                    confirmButtonText: 'Choose Another Column',
                    customClass: {
                        popup: 'lms-swal-popup',
                        title: 'lms-swal-title',
                        htmlContainer: 'lms-swal-html',
                        confirmButton: 'lms-swal-confirm'
                    }
                }).then(() => this.focus());

                refreshAll();
                return;
            }

            refreshAll(this.dataset.field);
        });

        select.addEventListener('focus', function () { highlightMapping(this); });
        select.addEventListener('blur', function () { setTimeout(clearHighlight, 120); });

        const node = destNode(select);
        if (node) {
            node.addEventListener('mouseenter', function () { highlightMapping(select); });
            node.addEventListener('mouseleave', clearHighlight);
        }
    });

    sourceList.querySelectorAll('.lms-source-token').forEach(function (token) {
        const activate = function () {
            const linked = selects.find(function (select) { return select.value === token.dataset.sourceIndex; });
            if (linked) highlightMapping(linked);
        };
        token.addEventListener('mouseenter', activate);
        token.addEventListener('focus', activate);
        token.addEventListener('mouseleave', clearHighlight);
        token.addEventListener('blur', clearHighlight);
    });

    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            filterButtons.forEach(function (b) { b.classList.remove('is-active'); });
            this.classList.add('is-active');
            const filter = this.dataset.filter;

            selects.forEach(function (select) {
                const node = destNode(select);
                let show = true;
                if (filter === 'required') show = select.hasAttribute('required');
                if (filter === 'unmapped') show = select.value === '';
                node.classList.toggle('is-hidden', !show);
            });

            requestAnimationFrame(function () { drawEdges(); });
        });
    });

    form.addEventListener('submit', function (event) {
        const missingRequired = selects.find(function (select) {
            return select.hasAttribute('required') && select.value === '';
        });

        if (missingRequired) {
            event.preventDefault();
            const node = destNode(missingRequired);
            if (node) {
                node.classList.add('is-flash');
                node.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(function () { node.classList.remove('is-flash'); }, 360);
            }
            Swal.fire({
                icon: 'warning',
                title: 'Required Mapping Missing',
                text: 'Please map all required CRM fields before importing leads.',
                confirmButtonText: 'Review Mapping',
                customClass: {
                    popup: 'lms-swal-popup',
                    title: 'lms-swal-title',
                    htmlContainer: 'lms-swal-html',
                    confirmButton: 'lms-swal-confirm'
                }
            }).then(() => missingRequired.focus());
            return;
        }

        const used = {};
        for (const select of selects) {
            if (select.value === '') continue;
            if (Object.prototype.hasOwnProperty.call(used, select.value)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Column Mapping',
                    text: 'Column "' + getColumnName(select) + '" has been mapped more than once. Each uploaded column can only be used once.',
                    confirmButtonText: 'Fix Mapping',
                    customClass: {
                        popup: 'lms-swal-popup',
                        title: 'lms-swal-title',
                        htmlContainer: 'lms-swal-html',
                        confirmButton: 'lms-swal-confirm'
                    }
                }).then(() => select.focus());
                return;
            }
            used[select.value] = true;
        }
    });

    inspectorToggle.addEventListener('click', function () {
        const collapsed = inspector.classList.toggle('is-collapsed');
        this.setAttribute('aria-label', collapsed ? 'Expand inspector' : 'Collapse inspector');
        this.title = collapsed ? 'Expand' : 'Collapse';
    });

    inspectorExpand.addEventListener('click', function () {
        const expanded = inspector.classList.toggle('is-expanded');
        document.body.style.overflow = expanded ? 'hidden' : '';
        this.setAttribute('aria-label', expanded ? 'Exit full screen inspector' : 'Expand inspector');
        this.title = expanded ? 'Exit Fullscreen' : 'Expand';
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && inspector.classList.contains('is-expanded')) {
            inspector.classList.remove('is-expanded');
            document.body.style.overflow = '';
        }
    });

    let resizeFrame = null;
    function scheduleRedraw() {
        if (resizeFrame) cancelAnimationFrame(resizeFrame);
        resizeFrame = requestAnimationFrame(function () { drawEdges(); });
    }

    window.addEventListener('resize', scheduleRedraw);
    window.addEventListener('scroll', scheduleRedraw, true);

    if ('ResizeObserver' in window) {
        const observer = new ResizeObserver(scheduleRedraw);
        observer.observe(mapGrid);
        document.querySelectorAll('.lms-source-token, .lms-dest-node').forEach(function (el) { observer.observe(el); });
    }

    
    if (schemaSearch) {
        schemaSearch.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();

            document.querySelectorAll('.lms-source-token').forEach(function (token) {
                const name = (token.querySelector('.lms-source-name')?.textContent || '').toLowerCase();
                token.classList.toggle('is-search-hidden', q && !name.includes(q));
            });

            document.querySelectorAll('.lms-dest-node').forEach(function (node) {
                const label = (node.querySelector('.lms-dest-label')?.textContent || '').toLowerCase();
                const selectText = (node.querySelector('.mapping-select')?.selectedOptions?.[0]?.textContent || '').toLowerCase();
                node.classList.toggle('is-search-hidden', q && !label.includes(q) && !selectText.includes(q));
            });

            drawEdges();
        });
    }

    densityButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            densityButtons.forEach(function (b) { b.classList.remove('is-active'); });
            this.classList.add('is-active');
            if (studio) studio.classList.toggle('is-compact', this.dataset.density === 'compact');
            setTimeout(drawEdges, 60);
        });
    });

    refreshAll();
});
</script>

@endsection

