<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            background: #f1f5fb;
            color: #212529;
            overflow-x: hidden;
        }
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 250px;
            height: 100vh;
            background: #1e2e7e;
            display: flex;
            flex-direction: column;
            z-index: 200;
            overflow-y: auto;
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-logo .logo-box {
            width: 36px; height: 36px;
            background: #4070f4;
            border-radius: 10px;
            display: grid; place-items: center;
            color: #fff; font-size: 18px;
        }
        .sidebar-logo .logo-text {
            font-size: 1.1rem; font-weight: 700; color: #fff;
        }
        .sidebar-nav {
            padding: 14px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .nav-item, .nav-toggle {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: rgba(255,255,255,0.72);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            background: transparent;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background 160ms ease, color 160ms ease;
        }
        .nav-item:hover, .nav-toggle:hover { background: rgba(255,255,255,0.11); color: #fff; }
        .nav-item.active { background: #4070f4; color: #fff; }
        .nav-caret { margin-left: auto; font-size: 10px; transition: transform 160ms ease; }
        .nav-dropdown.open .nav-caret { transform: rotate(180deg); }
        .nav-dropdown-menu { display: none; flex-direction: column; gap: 2px; padding-left: 16px; margin-top: 2px; }
        .nav-dropdown.open .nav-dropdown-menu { display: flex; }
        .nav-subitem {
            display: block;
            padding: 9px 14px;
            border-radius: 8px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.9rem;
        }
        .nav-subitem:hover, .nav-subitem.active { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-help {
            margin: 12px 12px 20px;
            padding: 14px 16px;
            border-radius: 12px;
            background: rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
        }
        .sidebar-help:hover { background: rgba(255,255,255,0.13); color: #fff; }
        .main-wrapper { margin-left: 250px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e3e9f3;
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f1f5fb;
            border: 1px solid #dce4f0;
            border-radius: 50px;
            padding: 8px 16px;
            width: 300px;
        }
        .topbar-search input { border: none; background: transparent; outline: none; font-size: 0.92rem; color: #3d4a6b; width: 100%; }
        .topbar-search .icon { color: #8896ad; font-size: 15px; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .topbar-icon {
            position: relative;
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 1px solid #dce4f0;
            background: #f1f5fb;
            display: grid; place-items: center;
            color: #5a6a85; cursor: pointer; font-size: 16px;
        }
        .topbar-icon .badge {
            position: absolute; top: 4px; right: 4px;
            width: 8px; height: 8px;
            background: #e74c3c; border-radius: 50%; border: 2px solid #fff;
        }
        .topbar-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .topbar-profile .avatar {
            width: 38px; height: 38px;
            background: #4070f4; border-radius: 50%;
            display: grid; place-items: center;
            color: #fff; font-weight: 700; font-size: 0.88rem;
        }
        .topbar-profile .profile-name { font-weight: 600; font-size: 0.92rem; color: #1e2e7e; }
        .topbar-profile .profile-role { font-size: 0.8rem; color: #8896ad; }
        .page-content { padding: 28px; flex: 1; }
        @media (max-width: 680px) {
            .sidebar { display: none; }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="sidebar">
    @include('partials.admin-sidebar')
</div>
<div class="main-wrapper">
    <header class="topbar">
        <div class="topbar-search">
            <span class="icon">&#128269;</span>
            <input type="search" placeholder="Search patients, doctors..." aria-label="Search">
        </div>
        <div class="topbar-right">
            <div class="topbar-icon">
                &#128276;
                <span class="badge"></span>
            </div>
            <div class="topbar-profile">
                <div class="avatar">AU</div>
                <div>
                    <div class="profile-name">System Admin</div>
                    <div class="profile-role">System Administrator</div>
                </div>
                <span style="color:#8896ad;font-size:11px;margin-left:4px;">&#9660;</span>
            </div>
        </div>
    </header>
    <main class="page-content">
        @yield('content')
    </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
