<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Klinik Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:   #1a6db5;
            --primary-dk:#0f4c81;
            --sidebar-w: 240px;
            --header-h:  60px;
            --bg:        #f0f4f8;
            --sidebar-bg:#0f2942;
            --text:      #1a202c;
            --muted:     #718096;
        }

        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sidebar-w); height: 100vh;
            background: var(--sidebar-bg);
            display: flex; flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; gap: 0.75rem;
        }
        .sidebar-brand .icon { font-size: 1.4rem; }
        .sidebar-brand span {
            font-size: 0.9rem; font-weight: 700;
            color: #fff; line-height: 1.2;
        }
        .sidebar-brand small { font-size: 0.7rem; opacity: 0.55; font-weight: 400; }

        .sidebar-menu {
            flex: 1; padding: 1rem 0; overflow-y: auto;
            list-style: none;
        }
        .sidebar-menu .menu-label {
            padding: 0.75rem 1.25rem 0.25rem;
            font-size: 0.68rem; font-weight: 600;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase; letter-spacing: 0.08em;
        }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 0.7rem;
            padding: 0.55rem 1.25rem;
            font-size: 0.875rem; color: rgba(255,255,255,0.65);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: #fff;
            background: rgba(255,255,255,0.07);
            border-left-color: var(--primary);
        }
        .sidebar-menu .menu-icon { font-size: 1rem; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .user-info {
            display: flex; align-items: center; gap: 0.65rem;
            margin-bottom: 0.75rem;
        }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; font-weight: 700; color: #fff;
        }
        .user-info .meta { flex: 1; min-width: 0; }
        .user-info .meta strong {
            display: block; font-size: 0.82rem; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-info .meta span {
            font-size: 0.72rem; color: rgba(255,255,255,0.45);
        }
        .btn-logout {
            display: flex; align-items: center; gap: 0.5rem;
            width: 100%; padding: 0.45rem 0.75rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 6px;
            color: rgba(255,255,255,0.65);
            font-size: 0.82rem; font-family: inherit;
            cursor: pointer; text-align: left;
            transition: background 0.15s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.14); color: #fff; }

        /* ── Main ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .topbar {
            height: var(--header-h);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center;
            padding: 0 1.5rem;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar h2 {
            font-size: 1rem; font-weight: 600; color: var(--text);
        }
        .topbar .breadcrumb {
            font-size: 0.78rem; color: var(--muted);
            margin-top: 1px;
        }

        .page-content { padding: 1.5rem; flex: 1; }

        /* ── Kartu stat ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            display: flex; align-items: center; gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07);
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-card .info strong { display: block; font-size: 1.4rem; font-weight: 700; }
        .stat-card .info span  { font-size: 0.8rem; color: var(--muted); }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07);
            margin-bottom: 1rem;
        }
        .card-title {
            font-size: 0.95rem; font-weight: 600;
            margin-bottom: 1rem; color: var(--text);
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <span class="icon">🏥</span>
        <div>
            <span>Klinik Management<br><small>v1.0</small></span>
        </div>
    </div>

    <ul class="sidebar-menu">
        @yield('sidebar-menu')
    </ul>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="meta">
                <strong>{{ Auth::user()->name }}</strong>
                <span>{{ ucfirst(Auth::user()->role->name) }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">⏻ &nbsp;Logout</button>
        </form>
    </div>
</aside>

{{-- Konten utama --}}
<div class="main-wrap">
    <header class="topbar">
        <div>
            <h2>@yield('page-title', 'Dashboard')</h2>
            <div class="breadcrumb">@yield('breadcrumb', 'Home')</div>
        </div>
    </header>

    <main class="page-content">
        @if (session('success'))
            <div style="background:#f0fff4;border:1px solid #9ae6b4;border-radius:8px;padding:.75rem 1rem;color:#276749;font-size:.875rem;margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
