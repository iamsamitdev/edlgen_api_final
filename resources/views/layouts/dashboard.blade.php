<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')  EDL-GEN</title>
    <link rel="icon" href="{{ asset('images/logo-edl-gen.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --surface-1:      #fcfcfb;
            --page-plane:     #f4f5f3;
            --text-primary:   #0b0b0b;
            --text-secondary: #52514e;
            --text-muted:     #898781;
            --gridline:       #e1e0d9;
            --border:         rgba(11,11,11,0.10);
            --card-shadow:    0 1px 2px rgba(11,11,11,0.04), 0 1px 8px rgba(11,11,11,0.04);

            --series-1: #2a78d6; /* blue   - low */
            --series-2: #1baf7a; /* green  - resolved / medium */
            --series-3: #eda100; /* amber  - high */
            --series-4: #4a3aa7; /* violet */
            --series-5: #c9463c; /* terracotta - critical */

            --good: #0ca30c;
            --bad:  #c9463c;
            --accent-wash: rgba(42,120,214,0.12);
            --accent-wash-strong: rgba(42,120,214,0.2);
            --accent-border: rgba(42,120,214,0.28);
            --good-wash: rgba(27,175,122,0.12);
            --bad-wash: rgba(201,70,60,0.12);
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --surface-1:      #1a1a19;
                --page-plane:     #0d0d0d;
                --text-primary:   #ffffff;
                --text-secondary: #c3c2b7;
                --text-muted:     #898781;
                --gridline:       #2c2c2a;
                --border:         rgba(255,255,255,0.10);
                --card-shadow:    0 1px 2px rgba(0,0,0,0.3), 0 1px 8px rgba(0,0,0,0.3);
                --series-1: #3987e5;
                --series-2: #199e70;
                --series-3: #c98500;
                --series-4: #9085e9;
                --series-5: #e2695f;
                --good: #199e70;
                --bad:  #e2695f;
                --accent-wash: rgba(57,135,229,0.16);
                --accent-wash-strong: rgba(57,135,229,0.26);
                --accent-border: rgba(57,135,229,0.35);
                --good-wash: rgba(25,158,112,0.16);
                --bad-wash: rgba(226,105,95,0.16);
            }
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: var(--page-plane);
            color: var(--text-primary);
            font-family: 'Inter', 'Anuphan', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3 { font-family: 'Inter', 'Anuphan', sans-serif; margin: 0; }
        a { color: inherit; }

        .topnav {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 64px;
            background: var(--surface-1);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 100;
            gap: 16px;
        }
        .topnav .brand { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 16px; white-space: nowrap; }
        .topnav .brand img { width: 32px; height: 32px; border-radius: 50%; }
        .topnav .brand .sub { font-weight: 400; color: var(--text-muted); font-size: 12px; }
        .topnav nav { display: flex; gap: 4px; overflow-x: auto; scrollbar-width: none; }
        .topnav nav::-webkit-scrollbar { display: none; }
        .topnav nav a {
            text-decoration: none; padding: 8px 12px; border-radius: 8px;
            font-size: 13.5px; font-weight: 600; color: var(--text-secondary);
        }
        .topnav nav a.active, .topnav nav a:hover { background: var(--accent-wash); color: var(--series-1); }
        .topnav .user { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-secondary); }
        .topnav .logout-btn {
            font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer;
            background: var(--bad-wash); color: var(--bad); border: 1px solid var(--bad-wash);
            padding: 7px 14px; border-radius: 8px;
        }
        .topnav .logout-btn:hover { filter: brightness(0.95); }

        main { max-width: 1200px; margin: 0 auto; padding: 88px 24px 64px; }

        .card {
            background: var(--surface-1);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            padding: 20px;
        }

        .kpi-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 20px; }
        .kpi-card { display: flex; flex-direction: column; gap: 6px; }
        .kpi-card .label { font-size: 12.5px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .03em; }
        .kpi-card .value { font-size: 28px; font-weight: 700; }

        .chart-row { display: grid; grid-template-columns: 1.4fr 1fr; gap: 16px; margin-bottom: 20px; }

        .slicer-panel {
            background: var(--surface-1);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 14px 16px;
            display: flex; align-items: flex-end; gap: 14px; flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .slicer-field { display: flex; flex-direction: column; gap: 4px; }
        .slicer-field label { font-size: 11.5px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .03em; }
        .slicer-field select, .slicer-field input {
            font-family: inherit; font-size: 12.5px; font-weight: 500;
            color: var(--text-primary); background: var(--page-plane);
            border: 1px solid var(--border); border-radius: 8px; padding: 7px 10px; min-width: 128px;
        }
        .slicer-actions { display: flex; gap: 8px; }
        .btn {
            font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer;
            border-radius: 8px; padding: 8px 16px; border: 1px solid var(--accent-border);
            background: var(--series-1); color: #fff;
        }
        .btn.secondary { background: transparent; color: var(--text-secondary); border-color: var(--border); }

        table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        thead th {
            text-align: left; font-size: 11.5px; text-transform: uppercase; letter-spacing: .03em;
            color: var(--text-muted); border-bottom: 1px solid var(--gridline); padding: 10px 12px;
        }
        tbody td { padding: 12px; border-bottom: 1px solid var(--gridline); vertical-align: top; }
        tbody tr:last-child td { border-bottom: none; }
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11.5px; font-weight: 700;
        }
        .badge.open { background: var(--bad-wash); color: var(--bad); }
        .badge.investigating { background: rgba(237,161,0,0.14); color: var(--series-3); }
        .badge.resolved { background: var(--good-wash); color: var(--good); }
        .badge.low { background: var(--accent-wash); color: var(--series-1); }
        .badge.medium { background: rgba(27,175,122,0.14); color: var(--series-2); }
        .badge.high { background: rgba(237,161,0,0.14); color: var(--series-3); }
        .badge.critical { background: var(--bad-wash); color: var(--bad); }

        .legend { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 12px; }
        .legend .item { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--text-secondary); }
        .legend .dot { width: 10px; height: 10px; border-radius: 50%; }

        .pagination { display: flex; gap: 6px; justify-content: flex-end; margin-top: 16px; flex-wrap: wrap; }
        .pagination a, .pagination span {
            padding: 6px 12px; border-radius: 8px; font-size: 12.5px; text-decoration: none;
            border: 1px solid var(--border); color: var(--text-secondary);
        }
        .pagination a:hover { background: var(--accent-wash); color: var(--series-1); }
        .pagination .active { background: var(--series-1); color: #fff; border-color: var(--series-1); }

        .empty-state { text-align: center; padding: 40px 20px; color: var(--text-muted); }

        @media (max-width: 900px) {
            .chart-row { grid-template-columns: 1fr; }
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 520px) {
            .kpi-grid { grid-template-columns: 1fr 1fr; }
            .topnav { padding: 0 12px; }
            main { padding: 80px 14px 48px; }
            .slicer-field select, .slicer-field input { min-width: 0; width: 100%; }
            .topnav .user span.email { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="topnav">
        <div class="brand">
            <img src="{{ asset('images/logo-edl-gen.jpg') }}" alt="EDL-GEN">
            <div>
                EDL-GEN
                <div class="sub">Incident Dashboard</div>
            </div>
        </div>
        <nav>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ url('/') }}">Home</a>
        </nav>
        <div class="user">
            @auth
                <span class="email">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn">ออกจากระบบ</button>
                </form>
            @endauth
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
