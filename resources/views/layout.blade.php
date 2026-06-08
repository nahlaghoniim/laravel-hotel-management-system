<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin Portal') · Grand Horizon Hotels</title>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════
           GRAND HORIZON HOTELS — Master Layout
           Luxury editorial · Warm parchment · Gold accents
        ═══════════════════════════════════════════════ */
 
        /* ── Variables ── */
        :root {
            --ink:       #1a1208;
            --ink-mid:   #3d2a0c;
            --ink-light: #888070;
            --ink-muted: #b0a898;
            --gold:      #c9a84c;
            --gold-pale: #e8d48a;
            --gold-dim:  rgba(201,168,76,0.15);
            --cream:     #f5f0e8;
            --cream-mid: #faf5ec;
            --white:     #ffffff;
            --green:     #2e7d4f;
            --green-bg:  #f2faf5;
            --red:       #8b3a2a;
            --red-bg:    #fdf3f2;
            --blue:      #2e6da4;
            --blue-bg:   #f0f8ff;
            --amber:     #9a751c;
            --amber-bg:  #fff8e8;
            --radius:    10px;
            --shadow-sm: 0 1px 8px rgba(26,18,8,0.06);
            --shadow-md: 0 4px 20px rgba(26,18,8,0.09);
            --shadow-lg: 0 12px 40px rgba(26,18,8,0.12);
            --font-serif: 'Cormorant Garamond', serif;
            --font-sans:  'DM Sans', sans-serif;
        }
 
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font-sans); background: var(--cream); }
 
        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        #wrapper { display: flex; }
 
        #sidebar {
            width: 240px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1208 0%, #2e1f08 60%, #3d2a0c 100%);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: width 0.25s ease;
            overflow: hidden;
        }
 
        #sidebar.toggled { width: 0; }
 
        /* Star pattern overlay */
        #sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M30 5 L35 20 L50 20 L38 29 L43 44 L30 35 L17 44 L22 29 L10 20 L25 20Z' fill='none' stroke='%23c9a84c' stroke-width='0.5' opacity='0.15'/%3E%3C/svg%3E") repeat;
            pointer-events: none;
        }
 
        /* Brand */
        .sidebar-brand {
            padding: 1.75rem 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(201,168,76,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }
 
        .brand-monogram {
            font-family: var(--font-serif);
            font-size: 28px;
            font-weight: 300;
            color: var(--gold);
            letter-spacing: 3px;
            line-height: 1;
            min-width: 40px;
        }
 
        .brand-text { display: flex; flex-direction: column; }
 
        .brand-name {
            font-family: var(--font-serif);
            font-size: 15px;
            font-weight: 500;
            color: #f5e6c8;
            white-space: nowrap;
        }
 
        .brand-sub {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(201,168,76,0.5);
            margin-top: 1px;
        }
 
        /* Nav section heading */
        .nav-section-label {
            font-size: 9.5px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(201,168,76,0.4);
            padding: 1.25rem 1.5rem 0.4rem;
            position: relative;
            z-index: 1;
        }
 
        /* Nav items */
        .sidebar-nav { flex: 1; padding: 0.5rem 0; position: relative; z-index: 1; overflow-y: auto; }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.2); border-radius: 2px; }
 
        .nav-item { list-style: none; }
 
        .nav-link-main {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.65rem 1.5rem;
            color: rgba(245,230,200,0.7);
            font-size: 13px;
            font-weight: 400;
            text-decoration: none;
            transition: color 0.2s, background 0.2s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
 
        .nav-link-main:hover, .nav-link-main.active {
            color: var(--gold);
            background: rgba(201,168,76,0.06);
        }
 
        .nav-link-main i { width: 16px; font-size: 13px; opacity: 0.8; }
 
        .nav-link-main .arrow {
            margin-left: auto;
            font-size: 10px;
            transition: transform 0.2s;
            opacity: 0.5;
        }
 
        .nav-link-main[aria-expanded="true"] .arrow { transform: rotate(180deg); }
 
        /* Sub-menu */
        .sub-menu { background: rgba(0,0,0,0.2); overflow: hidden; }
 
        .sub-menu a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.5rem 1.5rem 0.5rem 2.75rem;
            font-size: 12px;
            color: rgba(245,230,200,0.5);
            text-decoration: none;
            transition: color 0.2s;
        }
 
        .sub-menu a::before {
            content: '';
            width: 4px; height: 4px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.5;
            flex-shrink: 0;
        }
 
        .sub-menu a:hover, .sub-menu a.active { color: var(--gold); }
 
        /* Sidebar footer */
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(201,168,76,0.12);
            position: relative;
            z-index: 1;
        }
 
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: rgba(245,230,200,0.4);
            text-decoration: none;
            transition: color 0.2s;
        }
 
        .sidebar-footer a:hover { color: var(--gold); }
 
        /* ══════════════════════════════════════
           MAIN CONTENT AREA
        ══════════════════════════════════════ */
        #content-wrapper {
            margin-left: 240px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s ease;
        }
 
        #content-wrapper.expanded { margin-left: 0; }
 
        /* ══════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════ */
        #topbar {
            height: 64px;
            background: var(--white);
            border-bottom: 1px solid rgba(201,168,76,0.15);
            display: flex;
            align-items: center;
            padding: 0 1.75rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 1px 12px rgba(30,18,4,0.06);
        }
 
        .topbar-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--ink-light);
            font-size: 16px;
            padding: 6px;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
        }
 
        .topbar-toggle:hover { color: var(--gold); background: rgba(201,168,76,0.08); }
 
        .topbar-search {
            flex: 1;
            max-width: 320px;
            display: flex;
            align-items: center;
            background: var(--cream);
            border-radius: 8px;
            padding: 0 12px;
            gap: 8px;
            height: 36px;
        }
 
        .topbar-search input {
            border: none;
            background: transparent;
            font-family: var(--font-sans);
            font-size: 13px;
            color: var(--ink);
            outline: none;
            flex: 1;
        }
 
        .topbar-search input::placeholder { color: var(--ink-muted); }
        .topbar-search i { color: var(--ink-muted); font-size: 13px; }
 
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 4px; }
 
        .topbar-icon-btn {
            position: relative;
            background: none;
            border: none;
            width: 36px; height: 36px;
            border-radius: 8px;
            cursor: pointer;
            color: var(--ink-light);
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s, background 0.2s;
            text-decoration: none;
        }
 
        .topbar-icon-btn:hover { color: var(--gold); background: rgba(201,168,76,0.08); }
 
        .topbar-badge {
            position: absolute;
            top: 4px; right: 4px;
            width: 7px; height: 7px;
            background: var(--gold);
            border-radius: 50%;
            border: 1.5px solid var(--white);
        }
 
        .topbar-divider {
            width: 1px; height: 24px;
            background: rgba(201,168,76,0.2);
            margin: 0 8px;
        }
 
        /* User dropdown */
        .user-menu { position: relative; }
 
        .user-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 8px;
            transition: background 0.2s;
        }
 
        .user-btn:hover { background: rgba(201,168,76,0.08); }
 
        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2e1f08, #c9a84c);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-serif);
            font-size: 13px;
            color: #f5e6c8;
            font-weight: 500;
        }
 
        .user-name { font-size: 13px; color: var(--ink); font-weight: 500; }
        .user-role { font-size: 10px; color: var(--ink-light); display: block; text-align: left; }
 
        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px); right: 0;
            background: var(--white);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 10px;
            min-width: 180px;
            box-shadow: 0 8px 32px rgba(30,18,4,0.12);
            display: none;
            z-index: 999;
            overflow: hidden;
        }
 
        .user-dropdown.open { display: block; }
 
        .user-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 13px;
            color: var(--ink-mid);
            text-decoration: none;
            transition: background 0.15s;
        }
 
        .user-dropdown a:hover { background: var(--cream-mid); }
        .user-dropdown a i { width: 14px; color: var(--gold); font-size: 13px; }
        .user-dropdown hr { margin: 4px 0; border-color: rgba(201,168,76,0.15); }
        .user-dropdown .logout-link { color: var(--red); }
        .user-dropdown .logout-link i { color: var(--red); }
 
        /* ══════════════════════════════════════
           PAGE CONTENT
        ══════════════════════════════════════ */
        #page-content { flex: 1; padding: 2rem 2rem 3rem; }
 
        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */
        #footer {
            padding: 1rem 1.75rem;
            border-top: 1px solid rgba(201,168,76,0.12);
            background: var(--white);
            font-size: 11px;
            color: var(--ink-muted);
            letter-spacing: 0.3px;
        }
 
        /* ══════════════════════════════════════
           LOGOUT MODAL
        ══════════════════════════════════════ */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26,18,8,0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
 
        .modal-overlay.open { display: flex; }
 
        .modal-box {
            background: var(--white);
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            box-shadow: 0 24px 80px rgba(26,18,8,0.2);
        }
 
        .modal-header-gold {
            background: linear-gradient(135deg, #1a1208, #2e1f08);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
 
        .modal-header-gold h5 {
            font-family: var(--font-serif);
            font-size: 18px;
            font-weight: 400;
            color: #f5e6c8;
            margin: 0;
        }
 
        .modal-close {
            background: none;
            border: none;
            color: rgba(245,230,200,0.5);
            font-size: 18px;
            cursor: pointer;
            line-height: 1;
            transition: color 0.2s;
        }
 
        .modal-close:hover { color: var(--gold); }
        .modal-body-text { padding: 1.5rem; font-size: 14px; color: #5a4a35; }
 
        .modal-footer-btns {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid rgba(201,168,76,0.15);
        }
 
        /* ══════════════════════════════════════
           UTILITY / SHARED
        ══════════════════════════════════════ */
        .gold-line { width: 32px; height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }
 
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }
 
        .page-title { font-family: var(--font-serif); font-size: 26px; font-weight: 400; color: var(--ink); }
        .page-title-sub { font-size: 12px; color: var(--ink-light); margin-top: 2px; letter-spacing: 0.3px; }
 
        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            background: var(--ink);
            color: var(--gold);
            border: none;
            border-radius: 6px;
            font-family: var(--font-sans);
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
 
        .btn-gold:hover { background: var(--gold); color: var(--ink); }
 
        .btn-muted {
            padding: 9px 18px; background: none;
            border: 1px solid #ddd5c8; border-radius: 6px;
            font-family: var(--font-sans); font-size: 11px;
            letter-spacing: 1px; color: var(--ink-light); cursor: pointer;
            text-decoration: none; transition: border-color 0.2s, color 0.2s;
        }
 
        .btn-muted:hover { border-color: var(--gold); color: var(--ink); }
 
        .btn-danger-outline {
            padding: 9px 18px; background: none;
            border: 1px solid rgba(180,60,40,0.3); border-radius: 6px;
            font-family: var(--font-sans); font-size: 11px;
            letter-spacing: 1px; color: var(--red); cursor: pointer;
            text-decoration: none; transition: background 0.2s, color 0.2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
 
        .btn-danger-outline:hover { background: var(--red-bg); border-color: #c0392b; }
 
        .btn-outline-muted {
            padding: 8px 16px;
            background: none;
            border: 1px solid #ddd5c8;
            border-radius: 6px;
            font-family: var(--font-sans);
            font-size: 12px;
            color: var(--ink-light);
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s;
        }
 
        .btn-outline-muted:hover { border-color: var(--gold); color: var(--ink); }
 
        /* Alerts */
        .alert-gold-danger {
            display: flex; align-items: flex-start; gap: 10px;
            background: var(--red-bg); border: 1px solid rgba(180,60,40,0.2);
            border-left: 3px solid #c0392b;
            border-radius: 8px; padding: 0.9rem 1.1rem;
            font-size: 13px; color: var(--red); margin-bottom: 1.5rem;
        }
 
        .alert-gold-success {
            display: flex; align-items: center; gap: 10px;
            background: var(--green-bg); border: 1px solid rgba(40,140,80,0.2);
            border-left: 3px solid var(--green);
            border-radius: 8px; padding: 0.9rem 1.1rem;
            font-size: 13px; color: var(--green); margin-bottom: 1.5rem;
        }
 
        /* Status Pills */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 999px;
            padding: 4px 10px;
            border: 1px solid rgba(201,168,76,0.24);
            background: var(--cream-mid);
            color: var(--amber);
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 500;
            white-space: nowrap;
        }
 
        .status-pill::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
        }
 
        .status-active, .status-paid, .status-checked-in, .status-completed {
            background: var(--green-bg);
            border-color: rgba(46,125,79,0.2);
            color: var(--green);
        }
 
        .status-pending, .status-reserved {
            background: var(--amber-bg);
            border-color: rgba(201,168,76,0.28);
            color: var(--amber);
        }
 
        .status-cancelled, .status-refunded {
            background: var(--red-bg);
            border-color: rgba(192,57,43,0.2);
            color: var(--red);
        }
 
        .status-checked-out {
            background: var(--blue-bg);
            border-color: rgba(46,109,164,0.2);
            color: var(--blue);
        }
 
        /* ══════════════════════════════════════
           DASHBOARD — KPI CARDS
        ══════════════════════════════════════ */
        .dash-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }
 
        .dash-header-left { display: flex; flex-direction: column; gap: 4px; }
 
        .dash-eyebrow {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 500;
            font-family: var(--font-sans);
        }
 
        .dash-title {
            font-family: var(--font-serif);
            font-size: 32px;
            font-weight: 300;
            color: var(--ink);
            line-height: 1.1;
        }
 
        .dash-subtitle { font-size: 13px; color: var(--ink-light); margin-top: 2px; }
 
        /* Date Filter Toolbar */
        .dash-toolbar {
            background: var(--white);
            border: 1px solid var(--gold-dim);
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
        }
 
        .filter-label-tag {
            font-size: 9.5px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 600;
            padding: 4px 10px;
            background: rgba(201,168,76,0.08);
            border-radius: 4px;
            white-space: nowrap;
            font-family: var(--font-sans);
        }
 
        .filter-group { display: flex; flex-direction: column; gap: 4px; }
 
        .filter-group label {
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--ink-muted);
            font-weight: 500;
            font-family: var(--font-sans);
        }
 
        .filter-group select,
        .filter-group input[type="date"] {
            border: none;
            border-bottom: 1.5px solid #e0d8cc;
            background: transparent;
            font-family: var(--font-sans);
            font-size: 13px;
            color: var(--ink);
            padding: 4px 0;
            outline: none;
            transition: border-color 0.2s;
            min-width: 130px;
        }
 
        .filter-group select:focus,
        .filter-group input[type="date"]:focus { border-bottom-color: var(--gold); }
 
        .filter-divider { width: 1px; height: 32px; background: var(--gold-dim); flex-shrink: 0; }
 
        .filter-summary-text { font-size: 12.5px; color: var(--ink-light); font-family: var(--font-sans); }
        .filter-summary-text strong { color: var(--ink); font-weight: 600; }
 
        .btn-apply {
            padding: 8px 20px;
            background: var(--ink);
            color: var(--gold);
            border: none;
            border-radius: 6px;
            font-family: var(--font-sans);
            font-size: 10.5px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
            white-space: nowrap;
        }
 
        .btn-apply:hover { background: var(--gold); color: var(--ink); }
 
        /* Section Divider */
        .section-label { display: flex; align-items: center; gap: 12px; margin: 2rem 0 1rem; }
 
        .section-label-text {
            font-size: 9.5px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--ink-muted);
            font-weight: 500;
            white-space: nowrap;
            font-family: var(--font-sans);
        }
 
        .section-label-line {
            flex: 1; height: 1px;
            background: linear-gradient(90deg, var(--gold-dim), transparent);
        }
 
        /* KPI Grid */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }
 
        .kpi-grid-2 { grid-template-columns: repeat(2, 1fr); }
        .kpi-grid-3 { grid-template-columns: repeat(3, 1fr); }
 
        @media (max-width: 1200px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px)  { .kpi-grid { grid-template-columns: 1fr; } }
 
        .kpi-card {
            background: var(--white);
            border: 1px solid var(--gold-dim);
            border-radius: var(--radius);
            padding: 1.25rem 1.25rem 1rem;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
            box-shadow: var(--shadow-sm);
        }
 
        .kpi-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
 
        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }
 
        .kpi-card:hover::before { opacity: 1; }
 
        .kpi-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 0.9rem;
        }
 
        .kpi-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: var(--cream-mid);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold);
            font-size: 14px;
            border: 1px solid var(--gold-dim);
        }
 
        .kpi-label {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--ink-light);
            font-weight: 500;
            font-family: var(--font-sans);
            text-align: right;
            line-height: 1.3;
            max-width: 120px;
        }
 
        .kpi-value {
            font-family: var(--font-serif);
            font-size: 34px;
            font-weight: 400;
            color: var(--ink);
            line-height: 1;
            letter-spacing: -0.5px;
        }
 
        .kpi-value.kpi-value-sm { font-size: 26px; }
 
        .kpi-note {
            font-size: 11.5px;
            color: var(--ink-muted);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
 
        .kpi-note i { font-size: 8px; }
 
        /* KPI Highlight */
        .kpi-card.kpi-highlight {
            background: linear-gradient(135deg, var(--ink) 0%, var(--ink-mid) 100%);
            border-color: rgba(201,168,76,0.25);
        }
 
        .kpi-card.kpi-highlight .kpi-icon { background: rgba(201,168,76,0.12); border-color: rgba(201,168,76,0.2); }
        .kpi-card.kpi-highlight .kpi-label { color: rgba(245,230,200,0.5); }
        .kpi-card.kpi-highlight .kpi-value { color: var(--gold); }
        .kpi-card.kpi-highlight .kpi-note  { color: rgba(245,230,200,0.4); }
 
        /* Alert Strip */
        .alert-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
 
        @media (max-width: 900px) { .alert-strip { grid-template-columns: repeat(2,1fr); } }
        @media (max-width: 500px) { .alert-strip { grid-template-columns: 1fr; } }
 
        .alert-chip {
            background: var(--white);
            border: 1px solid var(--gold-dim);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-sm);
        }
 
        .alert-chip-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .alert-chip-dot.info    { background: var(--blue); }
        .alert-chip-dot.warning { background: var(--gold); }
        .alert-chip-dot.danger  { background: var(--red); }
        .alert-chip-dot.neutral { background: var(--ink-muted); }
 
        .alert-chip-count { font-family: var(--font-serif); font-size: 22px; color: var(--ink); line-height: 1; }
        .alert-chip-desc { font-size: 11px; color: var(--ink-light); font-family: var(--font-sans); line-height: 1.3; }
 
        /* Quick Actions */
        .quick-grid { display: flex; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 1rem; }
 
        .quick-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            background: var(--white);
            border: 1px solid var(--gold-dim);
            border-radius: 999px;
            font-family: var(--font-sans);
            font-size: 12px;
            color: var(--ink-mid);
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: var(--shadow-sm);
            white-space: nowrap;
        }
 
        .quick-pill i { color: var(--gold); font-size: 11px; }
 
        .quick-pill:hover {
            background: var(--ink);
            border-color: var(--ink);
            color: var(--gold);
            box-shadow: var(--shadow-md);
        }
 
        .quick-pill:hover i { color: var(--gold); }
 
        /* Content Panels */
        .content-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
 
        .content-row.row-3   { grid-template-columns: 1fr 1fr 1fr; }
        .content-row.row-wide { grid-template-columns: 1.6fr 1fr; }
 
        @media (max-width: 900px) {
            .content-row,
            .content-row.row-3,
            .content-row.row-wide { grid-template-columns: 1fr; }
        }
 
        .panel {
            background: var(--white);
            border: 1px solid var(--gold-dim);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
 
        .panel-head {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(201,168,76,0.08);
            background: linear-gradient(135deg, var(--cream-mid), var(--white));
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
 
        .panel-head-left { display: flex; align-items: center; gap: 10px; }
 
        .panel-icon {
            width: 32px; height: 32px;
            border-radius: 7px;
            background: var(--ink);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold);
            font-size: 12px;
            flex-shrink: 0;
        }
 
        .panel-title { font-family: var(--font-serif); font-size: 16px; font-weight: 500; color: var(--ink); }
        .panel-sub { font-size: 11px; color: var(--ink-muted); margin-top: 1px; }
 
        .panel-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            background: rgba(201,168,76,0.1);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 999px;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--amber);
            font-weight: 500;
            white-space: nowrap;
            text-decoration: none;
            font-family: var(--font-sans);
        }
 
        a.panel-badge:hover { background: var(--ink); border-color: var(--ink); color: var(--gold); }
 
        .panel-body { padding: 1.25rem; }
        .panel-body-flush { padding: 0; }
 
        /* Activity List */
        .activity-list { display: flex; flex-direction: column; }
 
        .activity-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid rgba(201,168,76,0.07);
            transition: background 0.15s;
        }
 
        .activity-row:last-child { border-bottom: none; }
        .activity-row:hover { background: var(--cream-mid); }
 
        .activity-guest { display: flex; align-items: center; gap: 10px; min-width: 0; }
 
        .guest-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--ink-mid), var(--gold));
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-serif);
            font-size: 12px;
            color: #f5e6c8;
            letter-spacing: 0.5px;
            flex-shrink: 0;
            border: 1.5px solid rgba(201,168,76,0.2);
        }
 
        .activity-name { font-size: 13px; font-weight: 500; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .activity-room { font-size: 11px; color: var(--ink-muted); margin-top: 1px; }
        .activity-date { font-size: 11px; color: var(--ink-muted); white-space: nowrap; flex-shrink: 0; }
        .activity-dates-span { font-size: 12px; color: var(--ink-light); font-weight: 500; white-space: nowrap; flex-shrink: 0; }
 
        /* Chart wrapper */
        .chart-wrap { position: relative; height: 220px; }
        .chart-wrap-sm { height: 180px; }
 
        /* Doughnut chart layout */
        .chart-with-legend { display: flex; flex-direction: column; gap: 1rem; }
 
        .pie-legend { display: flex; flex-wrap: wrap; gap: 8px 16px; padding-top: 0.25rem; }
 
        .legend-item { display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: var(--ink-light); font-family: var(--font-sans); }
        .legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
 
        /* Progress Tasks */
        .task-list { display: flex; flex-direction: column; gap: 1.1rem; }
 
        .task-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px; }
        .task-name { font-size: 12.5px; color: var(--ink); font-family: var(--font-sans); font-weight: 500; }
        .task-pct { font-size: 11px; color: var(--ink-muted); font-family: var(--font-sans); }
 
        .progress-track { height: 4px; background: rgba(201,168,76,0.12); border-radius: 999px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--ink-mid), var(--gold)); transition: width 0.6s ease; }
 
        /* Occupancy bar */
        .occ-bar-wrap { margin-top: 0.5rem; display: flex; flex-direction: column; gap: 8px; }
 
        .occ-bar-row { display: flex; align-items: center; gap: 10px; }
        .occ-bar-label { font-size: 11px; color: var(--ink-light); width: 80px; flex-shrink: 0; font-family: var(--font-sans); }
        .occ-bar-track { flex: 1; height: 6px; background: rgba(201,168,76,0.1); border-radius: 999px; overflow: hidden; }
        .occ-bar-fill { height: 100%; border-radius: 999px; }
        .occ-bar-pct { font-size: 11px; color: var(--ink-muted); width: 36px; text-align: right; flex-shrink: 0; font-family: var(--font-sans); }
 
        /* Revenue highlight */
        .rev-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 4px; }
        .rev-big { font-family: var(--font-serif); font-size: 36px; color: var(--gold); line-height: 1; }
        .rev-currency { font-family: var(--font-serif); font-size: 18px; color: rgba(201,168,76,0.6); }
        .rev-label { font-size: 10.5px; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(245,230,200,0.45); margin-top: 4px; font-family: var(--font-sans); }
 
        /* ══════════════════════════════════════
           FORM & TABLE STYLES
        ══════════════════════════════════════ */
        .form-panel {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid rgba(201,168,76,0.15);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }
 
        .form-panel-header {
            display: flex; align-items: center; gap: 14px;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(201,168,76,0.1);
            background: linear-gradient(135deg, var(--cream-mid), var(--white));
        }
 
        .form-panel-icon {
            width: 40px; height: 40px; border-radius: 8px;
            background: var(--ink);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 15px; flex-shrink: 0;
        }
 
        .form-panel-title { font-family: var(--font-serif); font-size: 18px; font-weight: 500; color: var(--ink); }
        .form-panel-sub { font-size: 12px; color: var(--ink-light); margin-top: 2px; }
 
        .field-group { padding: 1.25rem 1.5rem 0; }
 
        .field-label {
            display: block;
            font-size: 10.5px; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--ink-light);
            font-weight: 500; margin-bottom: 8px;
        }
 
        .field-input {
            width: 100%; border: none;
            border-bottom: 1.5px solid #e0d8cc;
            border-radius: 0; background: transparent;
            padding: 10px 0; font-size: 14px;
            color: var(--ink); font-family: var(--font-sans);
            outline: none; transition: border-color 0.2s;
        }
 
        .field-input:focus { border-bottom-color: var(--gold); }
        .field-input::placeholder { color: #c0b8a8; }
        .field-input.is-invalid { border-bottom-color: #c0392b; }
        .field-textarea { resize: vertical; min-height: 110px; }
        .field-error { font-size: 12px; color: #c0392b; margin-top: 5px; }
 
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 1.25rem 1.5rem;
            border-top: 1px solid rgba(201,168,76,0.1);
            margin-top: 1.25rem;
            background: var(--cream-mid);
        }
 
        .form-actions .results-summary { color: #6b5f4d; font-size: 13px; line-height: 1.4; }
 
        .form-actions .pagination { display: flex; flex-wrap: wrap; gap: 6px; margin: 0; padding: 0; list-style: none; }
        .form-actions .pagination .page-item { margin: 0; }
        .form-actions .pagination .page-link {
            border-radius: 6px;
            border: 1px solid rgba(201,168,76,0.2);
            color: var(--ink);
            min-width: 38px;
            padding: 0.55rem 0.85rem;
            font-size: 13px;
            background: var(--white);
        }
 
        .form-actions .pagination .page-item.active .page-link { background: var(--gold); border-color: var(--gold); color: var(--ink); }
        .form-actions .pagination .page-link:hover { background: var(--cream-mid); }
 
        /* Table */
        .hotel-table { width: 100%; border-collapse: collapse; font-family: var(--font-sans); }
 
        .hotel-table thead tr {
            border-bottom: 1px solid rgba(201,168,76,0.15);
            background: linear-gradient(135deg, var(--cream-mid), var(--white));
        }
 
        .hotel-table th {
            padding: 0.85rem 1.5rem;
            font-size: 10px; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--ink-light);
            font-weight: 500; text-align: left;
        }
 
        .hotel-table tbody tr { border-bottom: 1px solid rgba(201,168,76,0.08); transition: background 0.15s; }
        .hotel-table tbody tr:last-child { border-bottom: none; }
        .hotel-table tbody tr:hover { background: var(--cream-mid); }
        .hotel-table td { padding: 0.9rem 1.5rem; vertical-align: middle; }
 
        .row-num { font-size: 12px; color: var(--ink-muted); font-weight: 500; }
        .row-title { font-size: 13.5px; font-weight: 500; color: var(--ink); }
        .row-desc { font-size: 12.5px; color: var(--ink-light); max-width: 260px; }
        .row-date { font-size: 12px; color: var(--ink-muted); white-space: nowrap; }
 
        /* Action buttons */
        .action-btns { display: flex; justify-content: flex-end; gap: 6px; }
 
        .action-btn {
            width: 30px; height: 30px; border-radius: 6px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 12px; text-decoration: none; cursor: pointer;
            border: none; transition: background 0.15s, color 0.15s;
        }
 
        .action-btn.view   { background: var(--blue-bg); color: var(--blue); }
        .action-btn.view:hover  { background: #d0e8f8; }
        .action-btn.edit   { background: var(--cream-mid); color: var(--gold); }
        .action-btn.edit:hover  { background: #f0e4c0; }
        .action-btn.delete { background: var(--red-bg); color: #c0392b; }
        .action-btn.delete:hover { background: #f8d7d3; }
 
        /* Detail view */
        .detail-row {
            display: grid; grid-template-columns: 180px 1fr;
            gap: 1rem; padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(201,168,76,0.08);
            align-items: start;
        }
 
        .detail-label {
            font-size: 11px; letter-spacing: 1px;
            text-transform: uppercase; color: var(--ink-light);
            font-weight: 500; padding-top: 2px;
            display: flex; align-items: center; gap: 6px;
        }
 
        .detail-label i { color: var(--gold); font-size: 12px; }
        .detail-value { font-size: 14px; color: var(--ink); line-height: 1.6; }
 
        /* Empty state */
        .empty-state {
            padding: 4rem 2rem; text-align: center;
            display: flex; flex-direction: column; align-items: center;
        }
 
        .empty-icon {
            width: 56px; height: 56px; border-radius: 12px;
            background: var(--cream-mid);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 22px; margin-bottom: 1rem;
            border: 1px solid var(--gold-dim);
        }
 
        .empty-title { font-family: var(--font-serif); font-size: 20px; color: var(--ink); margin-bottom: 0.25rem; }
        .empty-sub { font-size: 13px; color: var(--ink-light); }
 
        /* Layout helpers */
        .content-grid { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 1.25rem; align-items: start; }
        .content-grid-wide { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.25rem; align-items: start; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 1.25rem; }
        .grid-full { grid-column: 1 / -1; }
        .table-wrap { width: 100%; overflow-x: auto; }
        .hotel-table .cell-actions { width: 1%; white-space: nowrap; }
 
        .guest-cell { display: flex; align-items: center; gap: 10px; min-width: 180px; }
 
        .metric-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem; }
        .metric-item { border: 1px solid rgba(201,168,76,0.12); border-radius: 8px; background: var(--white); padding: 1rem; }
        .metric-label { font-size: 10px; letter-spacing: 1.4px; text-transform: uppercase; color: var(--ink-light); margin-bottom: 6px; }
        .metric-value { font-family: var(--font-serif); font-size: 24px; color: var(--ink); line-height: 1; }
 
        .soft-note { font-size: 12px; color: var(--ink-light); line-height: 1.7; }
 
        .account-hero {
            display: flex; align-items: center; gap: 14px;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, var(--ink), var(--ink-mid));
            color: #f5e6c8;
        }
 
        .account-hero .guest-avatar { width: 48px; height: 48px; border: 1px solid rgba(201,168,76,0.4); }
        .account-hero-title { font-family: var(--font-serif); font-size: 22px; color: #f5e6c8; }
        .account-hero-sub { font-size: 12px; color: rgba(245,230,200,0.65); margin-top: 2px; }
 
        @media (max-width: 900px) {
            .content-grid,
            .content-grid-wide,
            .form-grid { grid-template-columns: 1fr; }
            .grid-full { grid-column: auto; }
            .page-header { align-items: flex-start; gap: 1rem; flex-direction: column; }
        }
 
        /* ══════════════════════════════════════
           RESPONSIVE SIDEBAR
        ══════════════════════════════════════ */
        @media (max-width: 768px) {
            #sidebar { width: 0; }
            #sidebar.toggled { width: 240px; }
            #content-wrapper { margin-left: 0; }
            #content-wrapper.expanded { margin-left: 0; }
        }
 
    </style>

    @yield('extra_css')
</head>
<body>

<div id="wrapper">

    {{-- ── Sidebar ── --}}
    <nav id="sidebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <div class="brand-monogram">GH</div>
            <div class="brand-text">
                <span class="brand-name">Grand Horizon</span>
                <span class="brand-sub">Management Portal</span>
            </div>
        </a>

        <div class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            <ul style="list-style:none;padding:0;margin:0">
                <li class="nav-item">
                    <a class="nav-link-main {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-fw fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <div class="nav-section-label">Masters</div>
            <ul style="list-style:none;padding:0;margin:0">

                {{-- Room Types --}}
                <li class="nav-item">
                    <button class="nav-link-main {{ request()->is('admin/roomtypes*') ? 'active' : '' }}"
                            onclick="toggleMenu('menuRoomTypes', this)"
                            aria-expanded="{{ request()->is('admin/roomtypes*') ? 'true' : 'false' }}">
                        <i class="fas fa-fw fa-layer-group"></i>
                        <span>Room Types</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </button>
                    <div class="sub-menu {{ request()->is('admin/roomtypes*') ? '' : 'collapsed-menu' }}"
                         id="menuRoomTypes"
                         style="{{ request()->is('admin/roomtypes*') ? '' : 'display:none' }}">
                        <a href="{{ route('roomtypes.create') }}"
                           class="{{ request()->routeIs('roomtypes.create') ? 'active' : '' }}">Add Room Type</a>
                        <a href="{{ route('roomtypes.index') }}"
                           class="{{ request()->routeIs('roomtypes.index') ? 'active' : '' }}">View Room Types</a>
                    </div>
                </li>

                {{-- Rooms --}}
                <li class="nav-item">
                    <button class="nav-link-main {{ request()->is('admin/rooms*') ? 'active' : '' }}"
                            onclick="toggleMenu('menuRooms', this)"
                            aria-expanded="{{ request()->is('admin/rooms*') ? 'true' : 'false' }}">
                        <i class="fas fa-fw fa-bed"></i>
                        <span>Rooms</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </button>
                    <div class="sub-menu" id="menuRooms"
                         style="{{ request()->is('admin/rooms*') ? '' : 'display:none' }}">
                        <a href="{{ route('rooms.create') }}"
                           class="{{ request()->routeIs('rooms.create') ? 'active' : '' }}">Add Room</a>
                        <a href="{{ route('rooms.index') }}"
                           class="{{ request()->routeIs('rooms.index') ? 'active' : '' }}">View Rooms</a>
                    </div>
                </li>

                {{-- Customers --}}
                <li class="nav-item">
                    <button class="nav-link-main {{ request()->is('admin/customers*') ? 'active' : '' }}"
                            onclick="toggleMenu('menuCustomers', this)"
                            aria-expanded="{{ request()->is('admin/customers*') ? 'true' : 'false' }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Customers</span>
                        <i class="fas fa-chevron-down arrow"></i>
                    </button>
                    <div class="sub-menu" id="menuCustomers"
                         style="{{ request()->is('admin/customers*') ? '' : 'display:none' }}">
                        <a href="{{ route('customers.create') }}"
                           class="{{ request()->routeIs('customers.create') ? 'active' : '' }}">Add Customer</a>
                        <a href="{{ route('customers.index') }}"
                           class="{{ request()->routeIs('customers.index') ? 'active' : '' }}">View Customers</a>
                    </div>
                </li>
{{-- Departments --}}
<li class="nav-item">
    <button class="nav-link-main {{ request()->routeIs('departments.*') ? 'active' : '' }}"
            onclick="toggleMenu('menuDepartments', this)"
            aria-expanded="{{ request()->routeIs('departments.*') ? 'true' : 'false' }}">
        <i class="fas fa-fw fa-building"></i>
        <span>Departments</span>
        <i class="fas fa-chevron-down arrow"></i>
    </button>
    <div class="sub-menu" id="menuDepartments"
         style="{{ request()->routeIs('departments.*') ? '' : 'display:none' }}">
        <a href="{{ route('departments.create') }}"
           class="{{ request()->routeIs('departments.create') ? 'active' : '' }}">Add Department</a>
        <a href="{{ route('departments.index') }}"
           class="{{ request()->routeIs('departments.index') ? 'active' : '' }}">View Departments</a>
    </div>
</li>

{{-- Staff --}}
<li class="nav-item">
    <button class="nav-link-main {{ request()->routeIs('staff.*') ? 'active' : '' }}"
            onclick="toggleMenu('menuStaff', this)"
            aria-expanded="{{ request()->routeIs('staff.*') ? 'true' : 'false' }}">
        <i class="fas fa-fw fa-id-badge"></i>
        <span>Staff</span>
        <i class="fas fa-chevron-down arrow"></i>
    </button>
    <div class="sub-menu" id="menuStaff"
         style="{{ request()->routeIs('staff.*') ? '' : 'display:none' }}">
        <a href="{{ route('staff.create') }}"
           class="{{ request()->routeIs('staff.create') ? 'active' : '' }}">Add Staff</a>
        <a href="{{ route('staff.index') }}"
           class="{{ request()->routeIs('staff.index') ? 'active' : '' }}">View Staff</a>
    </div>
</li>
            </ul>

            <div class="nav-section-label">Operations</div>
            <ul style="list-style:none;padding:0;margin:0">
                <li class="nav-item">
                    <a class="nav-link-main {{ request()->is('admin/bookings*') ? 'active' : '' }}"
                       href="{{ route('bookings.index') }}">
                        <i class="fas fa-fw fa-calendar-check"></i>
                        <span>Bookings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-main {{ request()->is('admin/check-ins*') ? 'active' : '' }}"
                       href="{{ route('checkins.index') }}">
                        <i class="fas fa-fw fa-door-open"></i>
                        <span>Check-ins</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="#" onclick="document.getElementById('logoutModal').classList.add('open')">
                <i class="fas fa-sign-out-alt" style="width:14px; color:rgba(201,168,76,0.4)"></i>
                Sign out
            </a>
        </div>
    </nav>

    {{-- ── Content Wrapper ── --}}
    <div id="content-wrapper">

        {{-- Topbar --}}
        <header id="topbar">
            <button class="topbar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <form class="topbar-search" action="{{ route('admin.search') }}" method="GET">
                <i class="fas fa-search"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search bookings, rooms, customers...">
            </form>

            <div class="topbar-right">
                <a href="#" class="topbar-icon-btn" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="topbar-badge"></span>
                </a>

                <div class="topbar-divider"></div>

                <div class="user-menu">
                    <button class="user-btn" onclick="toggleUserMenu()">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 2)) }}
                        </div>
                        <div>
                            <div class="user-name">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</div>
                            <span class="user-role">Administrator</span>
                        </div>
                        <i class="fas fa-chevron-down" style="font-size:9px;color:#b0a898;margin-left:4px"></i>
                    </button>

                    <div class="user-dropdown" id="userDropdown">
                        <a href="{{ route('admin.profile') }}"><i class="fas fa-user"></i> My Profile</a>
                        <a href="{{ route('admin.settings') }}"><i class="fas fa-cog"></i> Settings</a>
                        <hr>
                        <a href="#" class="logout-link"
                           onclick="document.getElementById('logoutModal').classList.add('open')">
                            <i class="fas fa-sign-out-alt"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main id="page-content">
            @yield('content')
        </main>

        <footer id="footer">
            &copy; {{ date('Y') }} Grand Horizon Hotels &middot; All rights reserved
        </footer>
    </div>

</div>

{{-- Logout Modal --}}
<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">
        <div class="modal-header-gold">
            <h5>Ready to leave?</h5>
            <button class="modal-close" onclick="document.getElementById('logoutModal').classList.remove('open')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-text">
            You are about to sign out of the management portal. Any unsaved changes will be lost.
        </div>
        <div class="modal-footer-btns">
            <button class="btn-outline-muted"
                    onclick="document.getElementById('logoutModal').classList.remove('open')">
                Cancel
            </button>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn-gold">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

@yield('extra_js')

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('toggled');
        document.getElementById('content-wrapper').classList.toggle('expanded');
    }

    function toggleMenu(id, btn) {
        const menu = document.getElementById(id);
        const isOpen = menu.style.display !== 'none';
        menu.style.display = isOpen ? 'none' : 'block';
        btn.setAttribute('aria-expanded', !isOpen);
        const arrow = btn.querySelector('.arrow');
        if (arrow) arrow.style.transform = isOpen ? '' : 'rotate(180deg)';
    }

    function toggleUserMenu() {
        document.getElementById('userDropdown').classList.toggle('open');
    }

    // Close user dropdown on outside click
    document.addEventListener('click', function(e) {
        const menu = document.querySelector('.user-menu');
        if (menu && !menu.contains(e.target)) {
            document.getElementById('userDropdown').classList.remove('open');
        }
    });
</script>
</body>
</html>
