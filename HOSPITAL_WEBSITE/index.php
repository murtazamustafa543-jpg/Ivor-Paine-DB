<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IVOR PAINE MEMORIAL HOSPITAL — Management System</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>

:root {
  --bg:        #0a0e1a;
  --bg2:       #0f1424;
  --bg3:       #141929;
  --surface:   #1a2035;
  --surface2:  #212840;
  --border:    rgba(255,255,255,0.07);
  --border2:   rgba(255,255,255,0.13);

  --text:      #e8eaf6;
  --text2:     #8b93b8;
  --text3:     #555e7a;

  --accent:    #e8a045;  
  --accent2:   #c97d28;
  --blue:      #4a9eff;
  --teal:      #2dd4bf;
  --rose:      #f87171;
  --green:     #4ade80;
  --purple:    #a78bfa;

  --font-head: 'DM Serif Display', Georgia, serif;
  --font-body: 'DM Sans', system-ui, sans-serif;
  --font-mono: 'JetBrains Mono', monospace;

  --radius:    8px;
  --radius-lg: 14px;
  --shadow:    0 4px 24px rgba(0,0,0,0.5);
  --shadow-lg: 0 12px 48px rgba(0,0,0,0.7);

  --sidebar-w: 240px;
  --anim:      0.25s cubic-bezier(0.4,0,0.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: var(--font-body);
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  overflow-x: hidden;
}


::-webkit-scrollbar { width: 5px; height: 5px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: var(--surface2); border-radius: 4px; }


#app { display: flex; min-height: 100vh; }


#sidebar {
  width: var(--sidebar-w);
  min-height: 100vh;
  background: var(--bg2);
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
  transition: transform var(--anim);
}

.sidebar-logo {
  padding: 24px 20px 20px;
  border-bottom: 1px solid var(--border);
}
.sidebar-logo .cross {
  width: 36px; height: 36px;
  background: var(--accent);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 12px;
  font-size: 20px; font-weight: 700; color: var(--bg);
  box-shadow: 0 0 20px rgba(232,160,69,0.3);
}
.sidebar-logo h1 {
  font-family: var(--font-head);
  font-size: 14px;
  line-height: 1.4;
  color: var(--text);
  letter-spacing: 0.02em;
}
.sidebar-logo p {
  font-size: 10px;
  color: var(--text3);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-top: 2px;
}

.sidebar-section {
  padding: 16px 12px 6px;
  font-size: 9.5px;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--text3);
  font-weight: 600;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 16px;
  margin: 1px 8px;
  border-radius: var(--radius);
  cursor: pointer;
  transition: all var(--anim);
  font-size: 13.5px;
  color: var(--text2);
  font-weight: 400;
  user-select: none;
}
.nav-item:hover { background: var(--surface); color: var(--text); }
.nav-item.active {
  background: linear-gradient(135deg, rgba(232,160,69,0.18) 0%, rgba(232,160,69,0.06) 100%);
  color: var(--accent);
  font-weight: 500;
  border: 1px solid rgba(232,160,69,0.2);
}
.nav-item .icon {
  width: 16px; height: 16px;
  opacity: 0.8;
  flex-shrink: 0;
}
.nav-item.active .icon { opacity: 1; }


#main {
  margin-left: var(--sidebar-w);
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}


#topbar {
  height: 56px;
  background: var(--bg2);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  padding: 0 28px;
  gap: 12px;
  position: sticky; top: 0; z-index: 50;
}
#topbar h2 {
  font-family: var(--font-head);Montserrat
  font-size: 18px;
  
  color: var(--text);
  flex: 1;
}
.topbar-badge {
  background: var(--surface);
  border: 1px solid var(--border2);
  border-radius: 20px;
  padding: 4px 12px;
  font-size: 11px;
  color: var(--text2);
  font-family: var(--font-mono);
}


#content {
  flex: 1;
  padding: 28px;
  overflow-y: auto;
}




.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 14px;
  margin-bottom: 28px;
}
.stat-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 18px 16px;
  transition: border-color var(--anim), transform var(--anim);
  position: relative;
  overflow: hidden;
}
.stat-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: var(--accent-var, var(--accent));
  opacity: 0.7;
}
.stat-card:hover { border-color: var(--border2); transform: translateY(-2px); }
.stat-card .label {
  font-size: 11px;
  color: var(--text3);
  text-transform: uppercase;
  letter-spacing: 0.08em;
  margin-bottom: 8px;
}
.stat-card .value {
  font-size: 32px;
  font-weight: 600;
  font-family: var(--font-mono);
  color: var(--text);
  line-height: 1;
}
.stat-card .sub {
  font-size: 11px;
  color: var(--text3);
  margin-top: 4px;
}

/* ── SECTION HEADER ── */
.section-header {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 20px;
}
.section-header h3 {
  font-family: var(--font-head);
  font-size: 22px;
  
  color: var(--text);
}
.section-header .pill {
  background: rgba(232,160,69,0.1);
  border: 1px solid rgba(232,160,69,0.25);
  color: var(--accent);
  font-size: 10px;
  font-family: var(--font-mono);
  padding: 3px 10px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}
.section-desc {
  font-size: 13px;
  color: var(--text2);
  margin-bottom: 20px;
  line-height: 1.6;
}


.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  margin-bottom: 20px;
}
.card-header {
  padding: 14px 20px;
  border-bottom: 1px solid var(--border);
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text3);
  display: flex; align-items: center; gap: 8px;
}
.card-body { padding: 20px; }


.tbl-wrap { overflow-x: auto; border-radius: var(--radius); }
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}
thead tr {
  background: var(--bg3);
}
thead th {
  padding: 10px 14px;
  text-align: left;
  font-size: 10.5px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text3);
  font-weight: 600;
  white-space: nowrap;
  border-bottom: 1px solid var(--border);
}
tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background var(--anim);
}
tbody tr:hover { background: var(--surface2); }
tbody tr:last-child { border-bottom: none; }
td {
  padding: 10px 14px;
  color: var(--text2);
  vertical-align: top;
}
td strong { color: var(--text); font-weight: 500; }
td .mono { font-family: var(--font-mono); font-size: 12px; color: var(--text3); }


.badge {
  display: inline-flex;
  align-items: center;
  padding: 2px 8px;
  border-radius: 4px;
  font-size: 10.5px;
  font-weight: 600;
  white-space: nowrap;
}
.badge-amber  { background: rgba(232,160,69,.15); color: #f5b95a; border: 1px solid rgba(232,160,69,.25); }
.badge-blue   { background: rgba(74,158,255,.15); color: #6ab4ff; border: 1px solid rgba(74,158,255,.25); }
.badge-teal   { background: rgba(45,212,191,.15); color: #2dd4bf; border: 1px solid rgba(45,212,191,.25); }
.badge-rose   { background: rgba(248,113,113,.15); color: #f87171; border: 1px solid rgba(248,113,113,.25); }
.badge-green  { background: rgba(74,222,128,.15); color: #4ade80; border: 1px solid rgba(74,222,128,.25); }
.badge-purple { background: rgba(167,139,250,.15); color: #a78bfa; border: 1px solid rgba(167,139,250,.25); }
.badge-gray   { background: rgba(139,147,184,.1);  color: #8b93b8; border: 1px solid rgba(139,147,184,.2); }


.form-row {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: flex-end;
  margin-bottom: 20px;
}
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-group label {
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.07em;
  color: var(--text3);
  font-weight: 600;
}
input, select {
  background: var(--bg3);
  border: 1px solid var(--border2);
  border-radius: var(--radius);
  color: var(--text);
  padding: 8px 12px;
  font-size: 13px;
  font-family: var(--font-body);
  outline: none;
  transition: border-color var(--anim);
  min-width: 160px;
}
input:focus, select:focus { border-color: var(--accent); }
input[type="date"] { color-scheme: dark; }
select option { background: var(--bg2); }

.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 18px;
  border-radius: var(--radius);
  border: none;
  font-size: 13px;
  font-family: var(--font-body);
  font-weight: 500;
  cursor: pointer;
  transition: all var(--anim);
  white-space: nowrap;
}
.btn-primary {
  background: var(--accent);
  color: var(--bg);
}
.btn-primary:hover { background: #f0b05a; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(232,160,69,0.3); }
.btn-ghost {
  background: var(--surface);
  color: var(--text2);
  border: 1px solid var(--border2);
}
.btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

.loading {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 48px;
  color: var(--text3);
  font-size: 13px;
  gap: 10px;
}
.spinner {
  width: 18px; height: 18px;
  border: 2px solid var(--border2);
  border-top-color: var(--accent);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.empty {
  padding: 40px;
  text-align: center;
  color: var(--text3);
  font-size: 13px;
}


.detail-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 14px;
  margin-bottom: 24px;
}
.detail-item .key {
  font-size: 10.5px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--text3);
  font-weight: 600;
  margin-bottom: 3px;
}
.detail-item .val {
  font-size: 14px;
  color: var(--text);
  font-weight: 400;
}


.timeline { position: relative; padding-left: 24px; }
.timeline::before {
  content: '';
  position: absolute;
  left: 7px; top: 6px; bottom: 6px;
  width: 1px;
  background: var(--border2);
}
.timeline-item {
  position: relative;
  margin-bottom: 20px;
}
.timeline-item::before {
  content: '';
  position: absolute;
  left: -20px; top: 5px;
  width: 8px; height: 8px;
  border-radius: 50%;
  background: var(--accent);
  box-shadow: 0 0 8px rgba(232,160,69,0.5);
}
.timeline-date {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--text3);
  margin-bottom: 4px;
}
.timeline-grade {
  font-size: 20px;
  font-weight: 700;
  font-family: var(--font-head);
  color: var(--accent);
  display: inline-block;
  margin-right: 8px;
}


.tabs {
  display: flex;
  gap: 4px;
  background: var(--bg3);
  padding: 4px;
  border-radius: var(--radius);
  margin-bottom: 20px;
  flex-wrap: wrap;
}
.tab {
  padding: 7px 16px;
  border-radius: 6px;
  font-size: 12.5px;
  cursor: pointer;
  color: var(--text2);
  transition: all var(--anim);
  user-select: none;
}
.tab:hover { color: var(--text); }
.tab.active {
  background: var(--surface2);
  color: var(--accent);
  font-weight: 500;
  box-shadow: var(--shadow);
}


.alert {
  padding: 12px 16px;
  border-radius: var(--radius);
  font-size: 13px;
  margin-bottom: 16px;
  border: 1px solid;
}
.alert-error { background: rgba(248,113,113,.1); border-color: rgba(248,113,113,.3); color: #f87171; }
.alert-info  { background: rgba(74,158,255,.1);  border-color: rgba(74,158,255,.3);  color: #6ab4ff; }


.page-title {
  margin-bottom: 28px;
  padding-bottom: 20px;
  border-bottom: 1px solid var(--border);
}
.page-title .query-no {
  font-family: var(--font-mono);
  font-size: 11px;
  color: var(--accent);
  margin-bottom: 6px;
  opacity: 0.8;
}
.page-title h2 {
  font-family: var(--font-head);
  font-size: 26px;

  color: var(--text);
  line-height: 1.2;
}
.page-title p {
  font-size: 13px;
  color: var(--text2);
  margin-top: 6px;
}


.ward-meta {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}
.bed-bar {
  background: var(--bg3);
  border-radius: 4px;
  height: 6px;
  flex: 1;
  overflow: hidden;
  margin-top: 6px;
}
.bed-bar-fill {
  height: 100%;
  border-radius: 4px;
  background: linear-gradient(90deg, var(--rose), var(--accent));
  transition: width 0.6s ease;
}


[data-theme="light"] {
  --bg:        #edf0cc;
  --bg2:       #f0f1b7;
  --bg3:       #eae4b5;
  --surface:   #ffffff;
  --surface2:  #e8eaf4;
  --border:    rgba(0,0,0,0.08);
  --border2:   rgba(0,0,0,0.14);
  --text:      #1a1e30;
  --text2:     #4a5068;
  --text3:     #8b93b8;
  --accent:    #c97d28;
  --accent2:   #a85f10;
  --shadow:    0 4px 24px rgba(0,0,0,0.1);
  --shadow-lg: 0 12px 48px rgba(0,0,0,0.18);
}
[data-theme="light"] input, [data-theme="light"] select { background: #fff; color: var(--text); }
[data-theme="light"] thead tr { background: #eef0f7; }
[data-theme="light"] input[type="date"] { color-scheme: light; }
[data-theme="light"] ::-webkit-scrollbar-track { background: #f0f1f8; }
[data-theme="light"] ::-webkit-scrollbar-thumb { background: #c8ccde; }

#theme-toggle {
  width: 34px; height: 34px; border-radius: 50%;
  border: 1px solid var(--border2); background: var(--surface);
  color: var(--text2); cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px; transition: all var(--anim); flex-shrink: 0;
}
#theme-toggle:hover { border-color: var(--accent); color: var(--accent); transform: rotate(20deg); }

.search-wrap { position: relative; }
.search-dropdown {
  position: absolute; top: calc(100% + 4px); left: 0; right: 0;
  background: var(--bg2); border: 1px solid var(--border2);
  border-radius: var(--radius); box-shadow: var(--shadow-lg);
  z-index: 200; max-height: 220px; overflow-y: auto;
}
.search-option {
  padding: 9px 14px; font-size: 13px; color: var(--text2);
  cursor: pointer; transition: background var(--anim);
  display: flex; gap: 10px; align-items: center;
}
.search-option:hover, .search-option.focused { background: var(--surface2); color: var(--text); }
.search-option .s-id { font-family: var(--font-mono); font-size: 11px; color: var(--text3); }
.search-no-results { padding: 12px 14px; font-size: 12px; color: var(--text3); text-align: center; }


@media (max-width: 768px) {
  #sidebar { transform: translateX(-100%); }
  #sidebar.open { transform: translateX(0); }
  #main { margin-left: 0; }
}

.page { animation: fadeIn 0.25s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
</style>
</head>
<body>
<div id="app">

  <!-- ══ SIDEBAR ══ -->
  <nav id="sidebar">
    <div class="sidebar-logo">
      <div class="cross">✚</div>
      <h1>Ivor Paine Memorial Hospital</h1>
      <p>Database System</p>
    </div>

    <div class="sidebar-section">Overview</div>
    <div class="nav-item active" onclick="navigate('dashboard')">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dashboard
    </div>

    <div class="sidebar-section">Manual Records</div>
    <div class="nav-item" onclick="navigate('form_patient')">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Patient Record
    </div>
    <div class="nav-item" onclick="navigate('form_ward')">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Ward Record
    </div>
    <div class="nav-item" onclick="navigate('form_consultant')">
      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      Consultant Team
    </div>


  </nav>

  <!-- ══ MAIN ══ -->
  <div id="main">
    <div id="topbar">
      <h2 id="topbar-title">Dashboard</h2>
      <span class="topbar-badge">HospitalDB_v2</span>
      <span class="topbar-badge" id="topbar-date"></span>
      <button id="theme-toggle" onclick="toggleTheme()" title="Toggle light/dark mode">&#127769;</button>
    </div>
    <div id="content">
      <div class="loading"><div class="spinner"></div> Loading…</div>
    </div>
  </div>

</div>

<script>

//  HospitalDB SPA  Frontend JavaScript


const API = 'api.php';
let currentPage = '';


async function api(params) {
  const url = API + '?' + new URLSearchParams(params);
  const res = await fetch(url);
  return res.json();
}

function el(id) { return document.getElementById(id); }
function setContent(html) { el('content').innerHTML = `<div class="page">${html}</div>`; }
function setTitle(t) { el('topbar-title').textContent = t; }

function loading() {
  return `<div class="loading"><div class="spinner"></div> Loading data…</div>`;
}

function errorHtml(msg) {
  return `<div class="alert alert-error">⚠ ${msg}</div>`;
}

function badge(text, type = 'gray') {
  const map = {
    'Available': 'green', 'Occupied': 'rose', 'Under Maintenance': 'amber',
    'Morning': 'blue', 'Afternoon': 'teal', 'Night': 'purple',
    'Low': 'teal', 'Medium': 'blue', 'High': 'amber', 'Critical': 'rose',
    'A': 'green', 'B': 'blue', 'C': 'amber', 'D': 'rose', 'F': 'rose',
  };
  const t = map[text] || type;
  return `<span class="badge badge-${t}">${text}</span>`;
}

function fmtDate(d) {
  if (!d) return '—';
  return new Date(d).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function nav(page) { navigate(page); }


(function() {
  const now = new Date();
  el('topbar-date').textContent = now.toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' });
})();


function navigate(page) {
  currentPage = page;
 
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => {
    if (n.getAttribute('onclick') === `navigate('${page}')`) n.classList.add('active');
  });

  const pages = {
    'dashboard':       renderDashboard,
    'form_patient':    renderFormPatient,
    'form_ward':       renderFormWard,
    'form_consultant': renderFormConsultant,
    'q1':  renderQ1, 'q2':  renderQ2, 'q3':  renderQ3, 'q4':  renderQ4,
    'q5':  renderQ5, 'q6':  renderQ6, 'q7':  renderQ7, 'q8':  renderQ8,
    'q9':  renderQ9, 'q10': renderQ10, 'q11': renderQ11, 'q12': renderQ12,
  };
  if (pages[page]) pages[page]();
}




async function renderDashboard() {
  setTitle('Dashboard');
  setContent(loading());
  const d = await api({ action: 'dashboard' });
  if (d.error) { setContent(errorHtml(d.error)); return; }

  const occRate = d.beds_occupied + d.beds_available > 0
    ? Math.round(d.beds_occupied / (d.beds_occupied + d.beds_available) * 100) : 0;

  const stats = [
    { label: 'Patients',  value: d.patients,        sub: 'admitted', color: '#4a9eff' },
    { label: 'Doctors',   value: d.doctors,          sub: 'on staff', color: '#a78bfa' },
    { label: 'Nurses',    value: d.nurses,           sub: 'on duty',  color: '#2dd4bf' },
    { label: 'Wards',     value: d.wards,            sub: 'active',   color: '#e8a045' },
    { label: 'Available Beds', value: d.beds_available, sub: 'free',  color: '#4ade80' },
    { label: 'Occupied Beds',  value: d.beds_occupied,  sub: `${occRate}% rate`, color: '#f87171' },
    { label: 'Complaints',     value: d.complaints,  sub: 'recorded', color: '#f87171' },
    { label: 'Treatments',     value: d.treatments,  sub: 'given',    color: '#2dd4bf' },
  ];

  let statCards = stats.map(s => `
    <div class="stat-card" style="--accent-var:${s.color}">
      <div class="label">${s.label}</div>
      <div class="value">${s.value ?? 0}</div>
      <div class="sub">${s.sub}</div>
    </div>
  `).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">OVERVIEW</div>
      <h2>Hospital at a Glance</h2>
      
    </div>

    <div class="stats-grid">${statCards}</div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
      <div class="card">
        <div class="card-header">📋 Manual Record Forms</div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
          <button class="btn btn-ghost" style="justify-content:flex-start" onclick="navigate('form_patient')">
            👤 Patient Record — Input by Patient No
          </button>
          <button class="btn btn-ghost" style="justify-content:flex-start" onclick="navigate('form_ward')">
            🏥 Ward Record — Input by Ward Name
          </button>
          <button class="btn btn-ghost" style="justify-content:flex-start" onclick="navigate('form_consultant')">
            👨‍⚕️ Consultant Team Record — Input by Staff No
          </button>
        </div>
      </div>
      <div class="card">
        <div class="card-header">📊 Required Reports</div>
        <div class="card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
          ${[1,2,3,4,5,6,7,8,9,10,11,12].map(n => `
            <button class="btn btn-ghost" style="font-size:12px;padding:6px 12px" onclick="navigate('q${n}')">
              <span style="font-family:var(--font-mono);color:var(--accent);margin-right:4px">Q${n}</span>
              ${queryTitle(n)}
            </button>
          `).join('')}
        </div>
      </div>
    </div>
  `);
}

function queryTitle(n) {
  const t = ['Consultant Teams','Ward Details','Patient Treatments','Junior Housemen',
    'Unique Specialities','Complaint + Experience','Multi-Complaint Patients',
    'By Treatment/Complaint','Performance History','Full Patient Details',
    'Treatments by Dates','Staff Positions'];
  return t[n-1];
}

// FORM 1 — PATIENT RECORD

async function renderFormPatient() {
  setTitle('Patient Record');
  setContent(`
    <div class="page-title">
      <div class="query-no">MANUAL RECORD · FORM 1</div>
      <h2>Patient Record</h2>
      <p>Search by name (live autocomplete) or enter a Patient No directly, then click Load Record.</p>
    </div>
    <div class="form-row" style="align-items:flex-end">
      <div class="form-group" style="flex:1;max-width:360px">
        <label>Search by Name</label>
        <div class="search-wrap">
          <input type="text" id="inp-patient-search" placeholder="Type patient name…"
            autocomplete="off"
            oninput="patientSearchInput(this.value)"
            onkeydown="patientSearchKey(event)"
            style="width:100%">
          <div id="patient-search-dropdown" class="search-dropdown" style="display:none"></div>
        </div>
      </div>
      <div class="form-group">
        <label>or Patient No</label>
        <input type="number" id="inp-patient-id" placeholder="e.g. 42" style="width:130px"
          onkeydown="if(event.key==='Enter') loadPatientRecord()">
      </div>
      <button class="btn btn-primary" onclick="loadPatientRecord()">Load Record</button>
    </div>
    <div id="patient-result"></div>
  `);
}

// ── Patient name search logic ────────────────
let _patSearchTimer = null;
let _patSearchFocus = -1;
let _patSearchResults = [];

async function patientSearchInput(q) {
  clearTimeout(_patSearchTimer);
  const dd = el('patient-search-dropdown');
  if (!q || q.length < 2) { dd.style.display = 'none'; return; }
  _patSearchTimer = setTimeout(async () => {
    const results = await api({ action: 'search_patients', q });
    _patSearchResults = Array.isArray(results) ? results : [];
    _patSearchFocus = -1;
    if (_patSearchResults.length === 0) {
      dd.innerHTML = '<div class="search-no-results">No patients found</div>';
    } else {
      dd.innerHTML = _patSearchResults.map((p, i) =>
        `<div class="search-option" data-id="${p.patientNo}" data-idx="${i}"
          onmousedown="selectPatient(${p.patientNo}, '${p.patientName.replace(/'/g,"\\'")}')" >
          <span class="s-id">#${p.patientNo}</span>
          <span>${p.patientName}</span>
        </div>`
      ).join('');
    }
    dd.style.display = 'block';
  }, 280);
}

function patientSearchKey(e) {
  const dd = el('patient-search-dropdown');
  const items = dd.querySelectorAll('.search-option');
  if (e.key === 'ArrowDown') {
    e.preventDefault();
    _patSearchFocus = Math.min(_patSearchFocus + 1, items.length - 1);
    items.forEach((item, i) => item.classList.toggle('focused', i === _patSearchFocus));
  } else if (e.key === 'ArrowUp') {
    e.preventDefault();
    _patSearchFocus = Math.max(_patSearchFocus - 1, 0);
    items.forEach((item, i) => item.classList.toggle('focused', i === _patSearchFocus));
  } else if (e.key === 'Enter') {
    if (_patSearchFocus >= 0 && _patSearchResults[_patSearchFocus]) {
      const p = _patSearchResults[_patSearchFocus];
      selectPatient(p.patientNo, p.patientName);
    } else {
      loadPatientRecord();
    }
  } else if (e.key === 'Escape') {
    dd.style.display = 'none';
  }
}

function selectPatient(id, name) {
  const si = el('inp-patient-search');
  const ni = el('inp-patient-id');
  if (si) si.value = name;
  if (ni) ni.value = id;
  const dd = el('patient-search-dropdown');
  if (dd) dd.style.display = 'none';
  loadPatientRecord();
}

document.addEventListener('click', (e) => {
  const dd1 = el('patient-search-dropdown');
  if (dd1 && !e.target.closest('.search-wrap')) dd1.style.display = 'none';
  const dd2 = el('q10-search-dropdown');
  if (dd2 && !e.target.closest('.search-wrap')) dd2.style.display = 'none';
});

async function loadPatientRecord() {
  const idEl = el('inp-patient-id');
  const id = idEl ? idEl.value : '';
  if (!id) return;
  el('patient-result').innerHTML = loading();
  const d = await api({ action: 'get_patient_record', patient_id: id });
  if (!d || d.error) { el('patient-result').innerHTML = errorHtml(d?.error || 'Not found'); return; }
  const { patient: p, doctor: doc, history: h } = d;

  el('patient-result').innerHTML = `
    <div class="card" style="border-color:rgba(74,158,255,0.2)">
      <div class="card-header" style="background:rgba(74,158,255,0.05)">
        🏥 IVOR PAINE MEMORIAL HOSPITAL — PATIENT RECORD
        <span class="badge badge-blue" style="margin-left:auto">Patient #${p.patientNo}</span>
      </div>
      <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
          <div>
            <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Patient Information</div>
            <div class="detail-grid" style="grid-template-columns:1fr 1fr">
              <div class="detail-item"><div class="key">Patient No</div><div class="val mono">${p.patientNo}</div></div>
              <div class="detail-item"><div class="key">Name</div><div class="val"><strong>${p.patientName}</strong></div></div>
              <div class="detail-item"><div class="key">Date of Birth</div><div class="val">${fmtDate(p.dateOfBirth)}</div></div>
              <div class="detail-item"><div class="key">Age</div><div class="val">${p.age} yrs</div></div>
              <div class="detail-item"><div class="key">Date Admitted</div><div class="val">${fmtDate(p.dateadmit)}</div></div>
              <div class="detail-item"><div class="key">Location</div><div class="val">${p.location}</div></div>
            </div>
          </div>
          <div>
            <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Medical Team</div>
            <div class="detail-grid" style="grid-template-columns:1fr 1fr">
              <div class="detail-item"><div class="key">Doctor No</div><div class="val mono">${doc?.DoctorID || '—'}</div></div>
              <div class="detail-item"><div class="key">Doctor Name</div><div class="val">${doc?.doctor_name || '—'}</div></div>
              <div class="detail-item"><div class="key">Consultant</div><div class="val">${doc?.consultant_name || '—'}</div></div>
              <div class="detail-item"><div class="key">Nurse</div><div class="val">${p.nurse_name || '—'}</div></div>
              <div class="detail-item"><div class="key">Nurse Type</div><div class="val">${badge(p.nurseType || '—', 'purple')}</div></div>
              <div class="detail-item"><div class="key">Care Unit</div><div class="val">${p.UnitName || '—'}</div></div>
            </div>
          </div>
        </div>
        <div style="border-top:1px solid var(--border);padding-top:16px">
          <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Medical History</div>
          ${h.length === 0 ? '<div class="empty">No treatment history recorded.</div>' : `
          <div class="tbl-wrap"><table>
            <thead><tr>
              <th>Complaint</th><th>Treatment</th><th>Doctor</th><th>Date Reported</th><th>Duration (days)</th>
            </tr></thead>
            <tbody>
              ${h.map(r => `
                <tr>
                  <td><span class="mono">#${r.complaintno}</span> ${r.complaint}</td>
                  <td><strong>${r.treatmentname}</strong></td>
                  <td>${r.doctor}</td>
                  <td>${fmtDate(r.dateReported)}</td>
                  <td><span class="mono">${r.duration}</span></td>
                </tr>
              `).join('')}
            </tbody>
          </table></div>`}
        </div>
      </div>
    </div>
  `;
}


// FORM 2 — WARD RECORD

async function renderFormWard() {
  setTitle('Ward Record');
  const wards = await api({ action: 'list_wards' });
  const opts = wards.map(w => `<option value="${w.Ward_Name}">${w.Ward_Name}</option>`).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">MANUAL RECORD · FORM 2</div>
      <h2>Ward Record</h2>
      <p>View ward details including sisters, care units, staff nurses, and admitted patients.</p>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Select Ward</label>
        <select id="sel-ward" style="min-width:260px">
          <option value="">— choose ward —</option>
          ${opts}
        </select>
      </div>
      <button class="btn btn-primary" onclick="loadWardRecord()">Load Ward</button>
    </div>
    <div id="ward-result"></div>
  `);
}

async function loadWardRecord() {
  const name = el('sel-ward').value;
  if (!name) return;
  el('ward-result').innerHTML = loading();
  const d = await api({ action: 'get_ward_record', ward_name: name });
  if (!d || d.error) { el('ward-result').innerHTML = errorHtml(d?.error || 'Not found'); return; }
  const { ward: w, nurses, patients } = d;

  const daySister    = nurses.filter(n => n.nurseType?.toLowerCase().includes('day'));
  const nightSister  = nurses.filter(n => n.nurseType?.toLowerCase().includes('night'));
  const staffNurses  = nurses.filter(n => n.nurseType?.toLowerCase().includes('staff'));
  const nonReg       = nurses.filter(n => n.nurseType?.toLowerCase().includes('non'));
  const occupied     = w.Total_Beds > 0 ? Math.round(w.Occupied_Beds / w.Total_Beds * 100) : 0;

  el('ward-result').innerHTML = `
    <div class="card" style="border-color:rgba(232,160,69,0.2)">
      <div class="card-header" style="background:rgba(232,160,69,0.05)">
        🏥 IVOR PAINE MEMORIAL HOSPITAL — WARD RECORD
        <span class="badge badge-amber" style="margin-left:auto">Ward: ${w.Ward_Name}</span>
      </div>
      <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
          <div>
            <div class="detail-grid" style="grid-template-columns:1fr 1fr">
              <div class="detail-item"><div class="key">Ward Name</div><div class="val"><strong>${w.Ward_Name}</strong></div></div>
              <div class="detail-item"><div class="key">Speciality</div><div class="val">${w.speciality_name}</div></div>
              <div class="detail-item"><div class="key">Block</div><div class="val">${w.Block}</div></div>
              <div class="detail-item"><div class="key">Floor</div><div class="val">${w.Floor}</div></div>
              <div class="detail-item"><div class="key">Contact</div><div class="val mono">${w.Contact_No}</div></div>
              <div class="detail-item"><div class="key">Location</div><div class="val">${w.Location}</div></div>
            </div>
          </div>
          <div>
            <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px">Bed Occupancy — ${occupied}%</div>
            <div class="bed-bar"><div class="bed-bar-fill" style="width:${occupied}%"></div></div>
            <div style="display:flex;gap:16px;margin-top:10px">
              <div class="detail-item"><div class="key">Total</div><div class="val">${w.Total_Beds}</div></div>
              <div class="detail-item"><div class="key">Occupied</div><div class="val" style="color:var(--rose)">${w.Occupied_Beds}</div></div>
              <div class="detail-item"><div class="key">Available</div><div class="val" style="color:var(--green)">${w.Available_Beds}</div></div>
            </div>
            <div style="margin-top:14px;display:grid;grid-template-columns:1fr 1fr;gap:8px">
              <div class="detail-item"><div class="key">Day Sisters</div><div class="val">${daySister.map(n=>n.nurse_name).join(', ') || '—'}</div></div>
              <div class="detail-item"><div class="key">Night Sisters</div><div class="val">${nightSister.map(n=>n.nurse_name).join(', ') || '—'}</div></div>
              <div class="detail-item"><div class="key">Staff Nurses</div><div class="val">${staffNurses.length}</div></div>
              <div class="detail-item"><div class="key">Non-Reg. Nurses</div><div class="val">${nonReg.length}</div></div>
            </div>
          </div>
        </div>

        <div style="border-top:1px solid var(--border);padding-top:16px;margin-bottom:16px">
          <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Care Units & Nurses</div>
          <div class="tbl-wrap"><table>
            <thead><tr><th>Care Unit</th><th>Nurse Name</th><th>Type</th><th>Shift</th></tr></thead>
            <tbody>
              ${nurses.length === 0 ? '<tr><td colspan="4" style="text-align:center;color:var(--text3)">No nurses assigned</td></tr>' :
              nurses.map(n => `<tr>
                <td><strong>${n.UnitName}</strong></td>
                <td>${n.nurse_name}</td>
                <td><span class="badge badge-purple">${n.nurseType}</span></td>
                <td>${badge(n.shift)}</td>
              </tr>`).join('')}
            </tbody>
          </table></div>
        </div>

        <div style="border-top:1px solid var(--border);padding-top:16px">
          <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Patient Information</div>
          <div class="tbl-wrap"><table>
            <thead><tr><th>Patient No</th><th>Name</th><th>Care Unit</th><th>Bed No</th><th>Consultant</th><th>Date Admitted</th></tr></thead>
            <tbody>
              ${patients.length === 0 ? '<tr><td colspan="6" style="text-align:center;color:var(--text3)">No patients in this ward</td></tr>' :
              patients.map(p => `<tr>
                <td class="mono">${p.patientNo}</td>
                <td><strong>${p.patientName}</strong></td>
                <td>${p.UnitName}</td>
                <td class="mono">${p.bedID || '—'}</td>
                <td>${p.consultant || '—'}</td>
                <td>${fmtDate(p.dateadmit)}</td>
              </tr>`).join('')}
            </tbody>
          </table></div>
        </div>
      </div>
    </div>
  `;
}

// FORM 3 — CONSULTANT TEAM RECORD

async function renderFormConsultant() {
  setTitle('Consultant Team Record');
  const doctors = await api({ action: 'list_doctors' });
  const opts = doctors.map(d => `<option value="${d.DoctorID}">${d.DoctorID} — ${d.name} (${d.position})</option>`).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">MANUAL RECORD · FORM 3</div>
      <h2>Consultant Team Record</h2>
      <p>View doctor profile, previous experience, and performance review history.</p>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Select Staff Member</label>
        <select id="sel-consultant" style="min-width:300px">
          <option value="">— choose staff —</option>
          ${opts}
        </select>
      </div>
      <button class="btn btn-primary" onclick="loadConsultantRecord()">Load Record</button>
    </div>
    <div id="consultant-result"></div>
  `);
}

async function loadConsultantRecord() {
  const id = el('sel-consultant').value;
  if (!id) return;
  el('consultant-result').innerHTML = loading();
  const d = await api({ action: 'get_consultant_team', staff_id: id });
  if (!d || d.error) { el('consultant-result').innerHTML = errorHtml(d?.error || 'Not found'); return; }
  const { doctor: doc, experience: exp, performance: perf } = d;

  el('consultant-result').innerHTML = `
    <div class="card" style="border-color:rgba(167,139,250,0.2)">
      <div class="card-header" style="background:rgba(167,139,250,0.05)">
        🏥 IVOR PAINE MEMORIAL HOSPITAL — CONSULTANT TEAM RECORD
        <span class="badge badge-purple" style="margin-left:auto">Staff #${doc.DoctorID}</span>
      </div>
      <div class="card-body">
        <div class="detail-grid" style="margin-bottom:20px">
          <div class="detail-item"><div class="key">Staff No</div><div class="val mono">${doc.DoctorID}</div></div>
          <div class="detail-item"><div class="key">Full Name</div><div class="val"><strong>${doc.FName} ${doc.MName||''} ${doc.LName}</strong></div></div>
          <div class="detail-item"><div class="key">Position</div><div class="val">${badge(doc.position,'purple')}</div></div>
          <div class="detail-item"><div class="key">Date Joined</div><div class="val">${fmtDate(doc.datejoined)}</div></div>
          <div class="detail-item"><div class="key">Speciality</div><div class="val">${doc.speciality_name}</div></div>
          <div class="detail-item"><div class="key">CNIC</div><div class="val mono">${doc.CNIC}</div></div>
          <div class="detail-item"><div class="key">Phone</div><div class="val mono">${doc.phoneNumber}</div></div>
          <div class="detail-item"><div class="key">Salary</div><div class="val">PKR ${Number(doc.salary).toLocaleString()}</div></div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
          <div>
            <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Previous Experience</div>
            ${exp.length === 0 ? '<div class="empty">No experience records.</div>' : `
            <div class="tbl-wrap"><table>
              <thead><tr><th>Establishment</th><th>Position</th><th>From</th><th>To</th></tr></thead>
              <tbody>
                ${exp.map(e => `<tr>
                  <td><strong>${e.establishment}</strong></td>
                  <td>${e.position_held}</td>
                  <td class="mono">${fmtDate(e.from_date)}</td>
                  <td class="mono">${e.to_date ? fmtDate(e.to_date) : badge('Present','green')}</td>
                </tr>`).join('')}
              </tbody>
            </table></div>`}
          </div>
          <div>
            <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Performance Reviews</div>
            ${perf.length === 0 ? '<div class="empty">No performance records.</div>' : `
            <div class="timeline">
              ${perf.map(r => `
                <div class="timeline-item">
                  <div class="timeline-date">${fmtDate(r.review_date)}</div>
                  <span class="timeline-grade">${r.grade}</span>
                  ${badge(r.grade)}
                </div>
              `).join('')}
            </div>`}
          </div>
        </div>
      </div>
    </div>
  `;
}


// QUERIES Q1 – Q12


async function renderQ1() {
  setTitle('Q1 — Consultant Teams');
  setContent(loading());
  const rows = await api({ action: 'q1_consultant_teams' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  // Group by consultant
  const consultants = {};
  rows.forEach(r => {
    if (!consultants[r.consultant_id]) {
      consultants[r.consultant_id] = { name: r.consultant_name, speciality: r.speciality, members: [] };
    }
    consultants[r.consultant_id].members.push(r);
  });

  const cards = Object.entries(consultants).map(([id, c]) => `
    <div class="card" style="margin-bottom:16px">
      <div class="card-header">
        <span style="color:var(--accent)">👨‍⚕️ ${c.name}</span>
        <span class="badge badge-teal" style="margin-left:8px">${c.speciality}</span>
        <span class="badge badge-gray" style="margin-left:auto">${c.members.length} team member${c.members.length!==1?'s':''}</span>
      </div>
      <div class="tbl-wrap"><table>
        <thead><tr><th>ID</th><th>Doctor Name</th><th>Position</th><th>Date Joined</th></tr></thead>
        <tbody>
          ${c.members.map(m => `<tr>
            <td class="mono">${m.doctor_id}</td>
            <td><strong>${m.doctor_name}</strong></td>
            <td>${badge(m.doctor_position,'purple')}</td>
            <td>${fmtDate(m.datejoined)}</td>
          </tr>`).join('')}
        </tbody>
      </table></div>
    </div>
  `).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 01</div>
      <h2>Consultants and their Doctor Teams</h2>
      <p>Each consultant grouped with the doctors in their team, showing position and joining date.</p>
    </div>
    ${rows.length === 0 ? '<div class="empty">No data found.</div>' : cards}
  `);
}

async function renderQ2() {
  setTitle('Q2 — Ward Details');
  setContent(loading());
  const rows = await api({ action: 'q2_ward_details' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  const wards = {};
  rows.forEach(r => {
    if (!wards[r.wardID]) {
      wards[r.wardID] = { ...r, units: {} };
    }
    if (!wards[r.wardID].units[r.unitID]) {
      wards[r.wardID].units[r.unitID] = { name: r.UnitName, type: r.unit_type, cost: r.CostPerDay, nurses: [] };
    }
    wards[r.wardID].units[r.unitID].nurses.push({ id: r.NurseID, name: r.nurse_name, type: r.nurseType, shift: r.shift });
  });

  const cards = Object.values(wards).map(w => `
    <div class="card" style="margin-bottom:16px">
      <div class="card-header">
        🏥 <strong>${w.Ward_Name}</strong>
        <span class="badge badge-amber" style="margin-left:8px">${w.speciality}</span>
        <span style="margin-left:auto;font-size:11px;color:var(--text3)">Block ${w.Block} · Floor ${w.Floor}</span>
      </div>
      <div class="card-body">
        <div style="display:flex;gap:16px;margin-bottom:16px;flex-wrap:wrap">
          <div class="detail-item"><div class="key">Total Beds</div><div class="val">${w.Total_Beds}</div></div>
          <div class="detail-item"><div class="key">Available</div><div class="val" style="color:var(--green)">${w.Available_Beds}</div></div>
          <div class="detail-item"><div class="key">Occupied</div><div class="val" style="color:var(--rose)">${w.Occupied_Beds}</div></div>
          <div class="detail-item"><div class="key">Contact</div><div class="val mono">${w.Contact_No}</div></div>
        </div>
        ${Object.values(w.units).map(u => `
          <div style="background:var(--bg3);border-radius:var(--radius);padding:12px 16px;margin-bottom:10px">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
              <strong>${u.name}</strong>
              <span class="badge badge-blue">${u.type}</span>
              <span class="badge badge-gray" style="margin-left:auto">PKR ${Number(u.cost).toLocaleString()}/day</span>
            </div>
            <div class="tbl-wrap"><table>
              <thead><tr><th>Nurse ID</th><th>Name</th><th>Type</th><th>Shift</th></tr></thead>
              <tbody>
                ${u.nurses.map(n => `<tr>
                  <td class="mono">${n.id}</td><td><strong>${n.name}</strong></td>
                  <td>${badge(n.type,'purple')}</td><td>${badge(n.shift)}</td>
                </tr>`).join('')}
              </tbody>
            </table></div>
          </div>
        `).join('')}
      </div>
    </div>
  `).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 02</div>
      <h2>Wards — Sisters, Care Units & Staff Nurses</h2>
      <p>Each ward with its nursing staff, care unit breakdown, and bed occupancy.</p>
    </div>
    ${rows.length === 0 ? '<div class="empty">No data found.</div>' : cards}
  `);
}

async function renderQ3() {
  setTitle('Q3 — Patient Treatments');
  setContent(loading());
  const rows = await api({ action: 'q3_patient_treatments' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 03</div>
      <h2>Patients — Complaints, Treatments & Dates</h2>
      <p>Full treatment history for every patient including complaint severity and treating doctor.</p>
    </div>
    <div class="card">
      <div class="tbl-wrap"><table>
        <thead><tr><th>Patient</th><th>Complaint</th><th>Severity</th><th>Treatment</th><th>Type</th><th>Doctor</th><th>Duration</th><th>Date Reported</th></tr></thead>
        <tbody>
          ${rows.length === 0 ? '<tr><td colspan="8" style="text-align:center;color:var(--text3)">No records</td></tr>' :
          rows.map(r => `<tr>
            <td><strong>${r.patientName}</strong><br><span class="mono">#${r.patientNo}</span></td>
            <td>${r.complaint_desc?.substring(0,45)}…</td>
            <td>${badge(r.severity)}</td>
            <td><strong>${r.treatmentname}</strong></td>
            <td>${badge(r.treatment_type,'blue')}</td>
            <td>${r.doctor_name}</td>
            <td class="mono">${r.duration}d</td>
            <td>${fmtDate(r.dateReported)}</td>
          </tr>`).join('')}
        </tbody>
      </table></div>
    </div>
  `);
}

async function renderQ4() {
  setTitle('Q4 — Junior Housemen');
  setContent(loading());
  const rows = await api({ action: 'q4_junior_housemen' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 04</div>
      <h2>Junior Housemen — Patients & Staff Nurses</h2>
      <p>Every junior houseman doctor with their assigned patients and the staff nurse of that patient's care unit.</p>
    </div>
    <div class="card">
      <div class="tbl-wrap"><table>
        <thead><tr><th>Doctor</th><th>Position</th><th>Patient</th><th>Admitted</th><th>Care Unit</th><th>Staff Nurse</th><th>Shift</th></tr></thead>
        <tbody>
          ${rows.length === 0 ? '<tr><td colspan="7" style="text-align:center;color:var(--text3)">No junior housemen found</td></tr>' :
          rows.map(r => `<tr>
            <td><strong>${r.doctor_name}</strong><br><span class="mono">#${r.DoctorID}</span></td>
            <td>${badge(r.position,'purple')}</td>
            <td><strong>${r.patientName}</strong><br><span class="mono">#${r.patientNo}</span></td>
            <td>${fmtDate(r.dateadmit)}</td>
            <td>${r.UnitName}</td>
            <td>${r.staff_nurse || '—'}</td>
            <td>${badge(r.shift)}</td>
          </tr>`).join('')}
        </tbody>
      </table></div>
    </div>
  `);
}

async function renderQ5() {
  setTitle('Q5 — Unique Specialities');
  setContent(loading());
  const rows = await api({ action: 'q5_unique_speciality' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 05</div>
      <h2>Consultants with a Unique Speciality</h2>
      <p>Doctors assigned to specialities that no other doctor shares.</p>
    </div>
    <div class="card">
      <div class="tbl-wrap"><table>
        <thead><tr><th>Doctor ID</th><th>Consultant Name</th><th>Speciality</th><th>Symbol</th><th>Position</th><th>Date Joined</th></tr></thead>
        <tbody>
          ${rows.length === 0 ? '<tr><td colspan="6" style="text-align:center;color:var(--text3)">None found</td></tr>' :
          rows.map(r => `<tr>
            <td class="mono">${r.DoctorID}</td>
            <td><strong>${r.consultant_name}</strong></td>
            <td>${badge(r.speciality,'teal')}</td>
            <td class="mono">${r.speciality_symbol}</td>
            <td>${badge(r.position,'purple')}</td>
            <td>${fmtDate(r.datejoined)}</td>
          </tr>`).join('')}
        </tbody>
      </table></div>
    </div>
  `);
}

async function renderQ6() {
  setTitle('Q6 — Complaints + Experience');
  setContent(loading());
  const rows = await api({ action: 'q6_complaint_treatment_exp' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 06</div>
      <h2>Complaints, Treatments & Doctor Experience</h2>
      <p>Each complaint with the treatments given, and the complete experience history of the treating doctor.</p>
    </div>
    <div class="card">
      <div class="tbl-wrap"><table>
        <thead><tr><th>Complaint</th><th>Severity</th><th>Treatment</th><th>Doctor</th><th>Experience — Establishment</th><th>Position Held</th><th>From</th><th>To</th></tr></thead>
        <tbody>
          ${rows.length === 0 ? '<tr><td colspan="8" style="text-align:center;color:var(--text3)">No records</td></tr>' :
          rows.map(r => `<tr>
            <td><span class="mono">#${r.complaintno}</span><br>${r.complaint_desc?.substring(0,35)}…</td>
            <td>${badge(r.severity)}</td>
            <td><strong>${r.treatmentname}</strong></td>
            <td>${r.doctor_name}</td>
            <td>${r.establishment || '—'}</td>
            <td>${r.position_held || '—'}</td>
            <td class="mono">${r.from_date ? fmtDate(r.from_date) : '—'}</td>
            <td class="mono">${r.to_date ? fmtDate(r.to_date) : badge('Present','green')}</td>
          </tr>`).join('')}
        </tbody>
      </table></div>
    </div>
  `);
}

async function renderQ7() {
  setTitle('Q7 — Multi-Complaint Patients');
  setContent(loading());
  const rows = await api({ action: 'q7_multi_complaint' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 07</div>
      <h2>Patients with More than One Complaint</h2>
      <p>Patients presenting multiple complaints simultaneously with all associated treatments.</p>
    </div>
    <div class="card">
      <div class="tbl-wrap"><table>
        <thead><tr><th>Patient</th><th>Age</th><th>Complaints</th><th>Count</th><th>Treatments</th></tr></thead>
        <tbody>
          ${rows.length === 0 ? '<tr><td colspan="5" style="text-align:center;color:var(--text3)">No multi-complaint patients</td></tr>' :
          rows.map(r => `<tr>
            <td><strong>${r.patientName}</strong><br><span class="mono">#${r.patientNo}</span></td>
            <td>${r.age} yrs</td>
            <td style="max-width:280px;font-size:12px">${r.complaints}</td>
            <td><span class="badge badge-rose">${r.total_complaints ?? 0}</span></td>
            <td style="font-size:12px">${r.treatments}</td>
          </tr>`).join('')}
        </tbody>
      </table></div>
    </div>
  `);
}

async function renderQ8() {
  setTitle('Q8 — By Treatment/Complaint');
  setContent(loading());
  const rows = await api({ action: 'q8_grouped_by_treatment' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  // Group by complaint then treatment
  const grouped = {};
  rows.forEach(r => {
    const ck = r.complaintno;
    if (!grouped[ck]) grouped[ck] = { desc: r.complaint_desc, treatments: {} };
    const tk = r.treatmentno;
    if (!grouped[ck].treatments[tk]) grouped[ck].treatments[tk] = { name: r.treatmentname, type: r.treatment_type, patients: [] };
    grouped[ck].treatments[tk].patients.push(r);
  });

  const html = Object.entries(grouped).map(([cno, c]) => `
    <div class="card" style="margin-bottom:16px">
      <div class="card-header">Complaint #${cno} — ${(c.desc||'').replace(/</g,'&lt;').replace(/>/g,'&gt;')}</div>
      <div class="card-body">
        ${Object.values(c.treatments).map(t => `
          <div style="margin-bottom:12px">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
              <strong>${t.name}</strong>${badge(t.type,'blue')}
              <span class="badge badge-gray">${t.patients.length} patient${t.patients.length!==1?'s':''}</span>
            </div>
            <div class="tbl-wrap"><table>
              <thead><tr><th>Patient No</th><th>Patient Name</th><th>Doctor</th><th>Duration</th></tr></thead>
              <tbody>
                ${t.patients.map(p => `<tr>
                  <td class="mono">${p.patientNo}</td>
                  <td><strong>${p.patientName}</strong></td>
                  <td>${p.doctor_name}</td>
                  <td class="mono">${p.duration}d</td>
                </tr>`).join('')}
              </tbody>
            </table></div>
          </div>
        `).join('')}
      </div>
    </div>
  `).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 08</div>
      <h2>Patients Grouped by Treatment within Complaint</h2>
      <p>Each complaint broken down by treatment type, showing which patients received each.</p>
    </div>
    ${rows.length === 0 ? '<div class="empty">No data found.</div>' : html}
  `);
}

async function renderQ9() {
  setTitle('Q9 — Performance History');
  const doctors = await api({ action: 'list_doctors' });
  const opts = doctors.map(d => `<option value="${d.DoctorID}">${d.DoctorID} — ${d.name} (${d.position})</option>`).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 09</div>
      <h2>Performance History for a Doctor</h2>
      <p>Select a doctor to view their full performance review timeline.</p>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Select Doctor</label>
        <select id="sel-doc-perf" style="min-width:280px">
          <option value="">— choose doctor —</option>
          ${opts}
        </select>
      </div>
      <button class="btn btn-primary" onclick="loadPerformance()">Load History</button>
    </div>
    <div id="perf-result"></div>
  `);
}

async function loadPerformance() {
  const id = el('sel-doc-perf').value;
  if (!id) return;
  el('perf-result').innerHTML = loading();
  const rows = await api({ action: 'q9_performance', doctor_id: id });
  if (!Array.isArray(rows)) { el('perf-result').innerHTML = errorHtml(rows.error); return; }
  if (rows.length === 0) { el('perf-result').innerHTML = '<div class="empty">No performance records found.</div>'; return; }

  const doc = rows[0];
  el('perf-result').innerHTML = `
    <div class="card">
      <div class="card-header">
        👨‍⚕️ ${doc.doctor_name} — ${doc.position} — ${doc.speciality}
        <span class="badge badge-gray" style="margin-left:auto">${rows.length} review${rows.length!==1?'s':''}</span>
      </div>
      <div class="card-body">
        <div class="timeline">
          ${rows.map(r => `
            <div class="timeline-item">
              <div class="timeline-date">${fmtDate(r.review_date)}</div>
              <span class="timeline-grade">${r.grade}</span>
              ${badge(r.grade)}
            </div>
          `).join('')}
        </div>
      </div>
    </div>
  `;
}

async function renderQ10() {
  setTitle('Q10 — Full Patient Details');
  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 10</div>
      <h2>Full Medical Details for a Patient</h2>
      <p>Complete medical record: demographics, ward/bed assignment, all complaints and treatments.</p>
    </div>
    <div class="form-row" style="align-items:flex-end">
      <div class="form-group" style="flex:1;max-width:360px">
        <label>Search by Name</label>
        <div class="search-wrap">
          <input type="text" id="inp-q10-search" placeholder="Type patient name…"
            autocomplete="off"
            oninput="q10SearchInput(this.value)"
            onkeydown="q10SearchKey(event)"
            style="width:100%">
          <div id="q10-search-dropdown" class="search-dropdown" style="display:none"></div>
        </div>
      </div>
      <div class="form-group">
        <label>or Patient No</label>
        <input type="number" id="inp-q10-id" placeholder="e.g. 42" style="width:130px"
          onkeydown="if(event.key==='Enter') loadQ10()">
      </div>
      <button class="btn btn-primary" onclick="loadQ10()">Load Details</button>
    </div>
    <div id="q10-result"></div>
  `);
}

let _q10SearchTimer = null;
let _q10SearchFocus = -1;
let _q10SearchResults = [];

async function q10SearchInput(q) {
  clearTimeout(_q10SearchTimer);
  const dd = el('q10-search-dropdown');
  if (!q || q.length < 2) { dd.style.display = 'none'; return; }
  _q10SearchTimer = setTimeout(async () => {
    const results = await api({ action: 'search_patients', q });
    _q10SearchResults = Array.isArray(results) ? results : [];
    _q10SearchFocus = -1;
    if (_q10SearchResults.length === 0) {
      dd.innerHTML = '<div class="search-no-results">No patients found</div>';
    } else {
      dd.innerHTML = _q10SearchResults.map((p, i) =>
        `<div class="search-option" data-idx="${i}"
          onmousedown="selectQ10Patient(${p.patientNo}, '${p.patientName.replace(/'/g,"\'")}')">
          <span class="s-id">#${p.patientNo}</span>
          <span>${p.patientName}</span>
        </div>`
      ).join('');
    }
    dd.style.display = 'block';
  }, 280);
}

function q10SearchKey(e) {
  const dd = el('q10-search-dropdown');
  const items = dd.querySelectorAll('.search-option');
  if (e.key === 'ArrowDown') {
    e.preventDefault();
    _q10SearchFocus = Math.min(_q10SearchFocus + 1, items.length - 1);
    items.forEach((item, i) => item.classList.toggle('focused', i === _q10SearchFocus));
  } else if (e.key === 'ArrowUp') {
    e.preventDefault();
    _q10SearchFocus = Math.max(_q10SearchFocus - 1, 0);
    items.forEach((item, i) => item.classList.toggle('focused', i === _q10SearchFocus));
  } else if (e.key === 'Enter') {
    if (_q10SearchFocus >= 0 && _q10SearchResults[_q10SearchFocus]) {
      const p = _q10SearchResults[_q10SearchFocus];
      selectQ10Patient(p.patientNo, p.patientName);
    } else { loadQ10(); }
  } else if (e.key === 'Escape') { dd.style.display = 'none'; }
}

function selectQ10Patient(id, name) {
  const si = el('inp-q10-search'); if (si) si.value = name;
  const ni = el('inp-q10-id');     if (ni) ni.value = id;
  const dd = el('q10-search-dropdown'); if (dd) dd.style.display = 'none';
  loadQ10();
}

async function loadQ10() {
  const idEl = el('inp-q10-id');
  const id = idEl ? idEl.value : '';
  if (!id) return;
  el('q10-result').innerHTML = loading();
  const d = await api({ action: 'q10_patient_details', patient_id: id });
  if (!d || d.error) { el('q10-result').innerHTML = errorHtml(d?.error || 'Not found'); return; }
  const { patient: p, complaints: c, bed: b } = d;
  if (!p) { el('q10-result').innerHTML = '<div class="empty">Patient not found.</div>'; return; }

  el('q10-result').innerHTML = `
    <div class="card">
      <div class="card-header">Full Medical Record — ${p.patientName} <span class="badge badge-blue" style="margin-left:auto">#${p.patientNo}</span></div>
      <div class="card-body">
        <div class="detail-grid" style="margin-bottom:20px">
          <div class="detail-item"><div class="key">Patient No</div><div class="val mono">${p.patientNo}</div></div>
          <div class="detail-item"><div class="key">Name</div><div class="val"><strong>${p.patientName}</strong></div></div>
          <div class="detail-item"><div class="key">Age</div><div class="val">${p.age} yrs</div></div>
          <div class="detail-item"><div class="key">DOB</div><div class="val">${fmtDate(p.dateOfBirth)}</div></div>
          <div class="detail-item"><div class="key">Date Admitted</div><div class="val">${fmtDate(p.dateadmit)}</div></div>
          <div class="detail-item"><div class="key">Location</div><div class="val">${p.location}</div></div>
          <div class="detail-item"><div class="key">Ward</div><div class="val">${p.Ward_Name || '—'}</div></div>
          <div class="detail-item"><div class="key">Care Unit</div><div class="val">${p.UnitName || '—'}</div></div>
          <div class="detail-item"><div class="key">Nurse</div><div class="val">${p.nurse_name || '—'}</div></div>
          <div class="detail-item"><div class="key">Bed</div><div class="val mono">${b ? '#'+b.bedID+' ('+b.bedType+')' : '— unassigned'}</div></div>
          <div class="detail-item"><div class="key">Address</div><div class="val">${[p.house,p.street,p.region,p.zipcode].filter(Boolean).join(', ') || p.location}</div></div>
        </div>
        <div style="border-top:1px solid var(--border);padding-top:16px">
          <div style="font-size:11px;color:var(--text3);text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px">Complaints & Treatments</div>
          ${c.length === 0 ? '<div class="empty">No complaints on record.</div>' : `
          <div class="tbl-wrap"><table>
            <thead><tr><th>Complaint No</th><th>Description</th><th>Severity</th><th>Date</th><th>Treatment</th><th>Doctor</th><th>Duration</th></tr></thead>
            <tbody>
              ${c.map(r => `<tr>
                <td class="mono">${r.complaintno}</td>
                <td>${r.description?.substring(0,50)}</td>
                <td>${badge(r.severity)}</td>
                <td>${fmtDate(r.dateReported)}</td>
                <td><strong>${r.treatmentname}</strong></td>
                <td>${r.doctor_name}</td>
                <td class="mono">${r.duration}d</td>
              </tr>`).join('')}
            </tbody>
          </table></div>`}
        </div>
      </div>
    </div>
  `;
}



async function renderQ11() {
  setTitle('Q11 — Treatments by Dates');
  const complaints = await api({ action: 'list_complaints' });
  const opts = complaints.map(c => `<option value="${c.complaintno}">${c.complaintno} — ${c.label}</option>`).join('');

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 11</div>
      <h2>Treatments for a Complaint between Two Dates</h2>
      <p>Filter treatments by complaint and date range, ordered by treatment name.</p>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Complaint</label>
        <select id="sel-comp" style="min-width:260px">
          <option value="">— choose complaint —</option>
          ${opts}
        </select>
      </div>
      <div class="form-group">
        <label>From Date</label>
        <input type="date" id="inp-from">
      </div>
      <div class="form-group">
        <label>To Date</label>
        <input type="date" id="inp-to">
      </div>
      <button class="btn btn-primary" onclick="loadQ11()">Run Query</button>
    </div>
    <div id="q11-result"></div>
  `);
}

async function loadQ11() {
  const cid  = el('sel-comp').value;
  const from = el('inp-from').value;
  const to   = el('inp-to').value;
  if (!cid)  { alert('Please select a complaint.');   return; }
  if (!from) { alert('Please select a From date.');   return; }
  if (!to)   { alert('Please select a To date.');     return; }
  if (!cid) return;
  el('q11-result').innerHTML = loading();
  const rows = await api({ action: 'q11_treatments_by_dates', complaint_id: cid, from, to });
  if (!Array.isArray(rows)) { el('q11-result').innerHTML = errorHtml(rows.error); return; }

  el('q11-result').innerHTML = `
    <div class="card">
      <div class="card-header">
        ${rows.length} treatment${rows.length!==1?'s':''} found
        ${from ? `<span class="badge badge-gray" style="margin-left:8px">${from} → ${to||'now'}</span>` : ''}
      </div>
      <div class="tbl-wrap"><table>
        <thead><tr>
          <th>Treatment</th>
          <th>Type</th>
          <th>Treatment Desc</th>
          <th>Complaint</th>
          <th>Patient</th>
          <th>Doctor</th>
          <th>Duration</th>
          <th>Date Reported</th>
        </tr></thead>
        <tbody>
          ${rows.length === 0 ? '<tr><td colspan="8" style="text-align:center;color:var(--text3)">No results</td></tr>' :
          rows.map(r => `<tr>
            <td><strong>${r.treatmentname}</strong></td>
            <td>${badge(r.treatment_type, 'blue')}</td>
            <td class="text-muted">${r.treatment_desc ?? '—'}</td>
            <td class="text-muted">${r.complaint_desc ?? '—'}</td>
            <td>${r.patientName}</td>
            <td>${r.doctor_name}</td>
            <td class="mono">${r.duration}d</td>
            <td>${fmtDate(r.dateReported)}</td>
          </tr>`).join('')}
        </tbody>
      </table></div>
    </div>
  `;
}

async function renderQ12() {
  setTitle('Q12 — Staff Positions');
  setContent(loading());
  const rows = await api({ action: 'q12_staff_positions' });
  if (!Array.isArray(rows)) { setContent(errorHtml(rows.error)); return; }

  const max = rows.reduce((m, r) => Math.max(m, r.staff_count), 0);
  const colors = ['#e8a045','#4a9eff','#2dd4bf','#a78bfa','#f87171','#4ade80'];

  setContent(`
    <div class="page-title">
      <div class="query-no">QUERY 12</div>
      <h2>Staff Positions — Count per Role</h2>
      <p>All distinct positions held by hospital staff with total headcount for each role.</p>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
      <div class="card">
        <div class="card-header">Visual Breakdown</div>
        <div class="card-body">
          ${rows.map((r,i) => `
            <div style="margin-bottom:12px">
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                <span style="font-size:13px;color:var(--text)">${r.position}</span>
                <span style="font-family:var(--font-mono);font-size:13px;color:${colors[i%colors.length]};font-weight:600">${r.staff_count}</span>
              </div>
              <div class="bed-bar">
                <div style="height:100%;border-radius:4px;background:${colors[i%colors.length]};width:${Math.round(r.staff_count/max*100)}%;transition:width .6s ease"></div>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
      <div class="card">
        <div class="card-header">Full Table</div>
        <div class="tbl-wrap"><table>
          <thead><tr><th>#</th><th>Position</th><th>Staff Count</th></tr></thead>
          <tbody>
            ${rows.map((r,i) => `<tr>
              <td class="mono">${i+1}</td>
              <td><strong>${r.position}</strong></td>
              <td><span class="badge" style="background:rgba(255,255,255,0.06);color:${colors[i%colors.length]};border:1px solid rgba(255,255,255,0.1);font-size:14px;padding:3px 12px">${r.staff_count}</span></td>
            </tr>`).join('')}
          </tbody>
        </table></div>
      </div>
    </div>
  `);
}

function toggleTheme() {
  const html = document.documentElement;
  const btn = el('theme-toggle');
  const isDark = html.getAttribute('data-theme') !== 'light';
  if (isDark) {
    html.setAttribute('data-theme', 'light');
    if (btn) btn.textContent = '☀️';
    try { localStorage.setItem('hms-theme', 'light'); } catch(e) {}
  } else {
    html.removeAttribute('data-theme');
    if (btn) btn.textContent = '🌙';
    try { localStorage.setItem('hms-theme', 'dark'); } catch(e) {}
  }
}


(function() {
  try {
    const saved = localStorage.getItem('hms-theme');
    const btn = el('theme-toggle');
    if (saved === 'light') {
      document.documentElement.setAttribute('data-theme', 'light');
      if (btn) btn.textContent = '☀️';
    }
  } catch(e) {}
})();
navigate('dashboard');
</script>
</body>
</html>