@extends('layouts.app')

@section('title', 'Admin Dashboard | OrthoCore Clinic')

@push('styles')
<style>
    .admin-page {
        padding: 32px 0 70px;
        background: linear-gradient(180deg, #f6fbff 0%, #ffffff 100%);
    }

    .admin-shell {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
        align-items: start;
    }

    .admin-shell > .admin-sidebar {
        align-self: stretch;
        min-height: 100%;
    }

    .admin-sidebar {
        background: #0f1f3a;
        color: #fff;
        border-radius: 24px;
        padding: 20px;
        min-height: 70vh;
        height: 100%;
        box-shadow: 0 16px 38px rgba(15, 31, 58, 0.12);
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        margin-bottom: 18px;
    }

    .brand-mark {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        font-weight: 800;
        background: linear-gradient(135deg, #1253c8, #4fd3cc);
        color: white;
    }

    .brand-name {
        font-size: 15px;
        font-weight: 700;
        margin: 0;
    }

    .brand-subtitle {
        color: #9db2cf;
        font-size: 12px;
    }

    .sidebar-nav {
        display: grid;
        gap: 8px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 12px;
        border-radius: 12px;
        color: #dce8f7;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.2s, color 0.2s;
    }

    .nav-item:hover,
    .nav-item.active {
        background: rgba(255,255,255,0.12);
        color: #fff;
    }

    .nav-dropdown {
        display: grid;
        gap: 6px;
    }

    .nav-toggle {
        width: 100%;
        justify-content: space-between;
        border: 0;
        background: transparent;
        cursor: pointer;
        font: inherit;
        text-align: left;
    }

    .nav-caret {
        margin-left: auto;
        color: #8fd7d1;
        font-size: 12px;
    }

    .nav-dropdown-menu {
        display: none;
        gap: 4px;
        padding-left: 22px;
        margin-top: 4px;
    }

    .nav-dropdown.open .nav-dropdown-menu {
        display: grid;
    }

    .nav-dropdown.open .nav-caret {
        transform: rotate(180deg);
    }

    .nav-subitem {
        padding: 8px 10px;
        border-radius: 10px;
        color: #cfe0f3;
        text-decoration: none;
        font-size: 13px;
    }

    .nav-subitem:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }

    .admin-content {
        display: grid;
        gap: 20px;
    }

    .admin-hero {
        background: #fff;
        border: 1px solid #dde8f7;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 16px 38px rgba(15, 31, 58, 0.08);
    }

    .admin-hero h1 {
        font-size: clamp(1.6rem, 2.2vw, 2.1rem);
        font-weight: 800;
        color: #0f1f3a;
        margin-bottom: 8px;
    }

    .admin-hero p {
        color: #5f6f85;
        margin-bottom: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #dde8f7;
        border-radius: 20px;
        padding: 18px;
        box-shadow: 0 10px 28px rgba(15, 31, 58, 0.06);
    }

    .stat-card .label {
        color: #5f6f85;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .stat-card .value {
        font-size: 1.4rem;
        font-weight: 800;
        color: #0f1f3a;
    }

    .panel-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 20px;
    }

    .panel-card {
        background: #fff;
        border: 1px solid #dde8f7;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 28px rgba(15, 31, 58, 0.06);
    }

    .panel-card h3 {
        font-size: 1.02rem;
        font-weight: 800;
        color: #0f1f3a;
        margin-bottom: 8px;
    }

    .panel-card p {
        color: #5f6f85;
        font-size: 14px;
        line-height: 1.7;
    }

    .list-block {
        display: grid;
        gap: 10px;
        margin-top: 14px;
    }

    .list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 11px 0;
        border-bottom: 1px solid #eef4fb;
        font-size: 14px;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .pill {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        background: #eaf4ff;
        color: #1253c8;
    }

    @media (max-width: 920px) {
        .admin-shell,
        .panel-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="wrap admin-shell">
        @include('partials.admin-sidebar')

        <div class="admin-content">
            <section class="admin-hero" id="overview">
                <h1>Admin overview</h1>
                <p>Monitor your clinic operations, manage staff access, and keep permissions aligned with your team structure.</p>
            </section>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="label">Registered users</div>
                    <div class="value" id="user-count">Loading...</div>
                </div>
                <div class="stat-card">
                    <div class="label">Active roles</div>
                    <div class="value">4</div>
                </div>
                <div class="stat-card">
                    <div class="label">Permissions</div>
                    <div class="value">18</div>
                </div>
            </div>

            <div class="panel-grid">
                <section class="panel-card" id="users">
                    <h3>User management</h3>
                    <p>Review account activity and manage access for administrators, doctors, and support staff.</p>
                    <div class="list-block">
                        <div class="list-item"><span>Dr. Amelia Brooks</span><span class="pill">Admin</span></div>
                        <div class="list-item"><span>Marcus Lee</span><span class="pill">Staff</span></div>
                        <div class="list-item"><span>Jasmine Patel</span><span class="pill">Doctor</span></div>
                    </div>
                </section>

                <section class="panel-card" id="roles">
                    <h3>Role controls</h3>
                    <p>Create and update team roles to reflect responsibilities across the clinic.</p>
                    <div class="list-block">
                        <div class="list-item"><span>Super Admin</span><span class="pill">Full access</span></div>
                        <div class="list-item"><span>Clinic Manager</span><span class="pill">Scheduling</span></div>
                        <div class="list-item"><span>Reception</span><span class="pill">Booking</span></div>
                    </div>
                </section>
            </div>

            <section class="panel-card" id="permissions">
                <h3>Permission overview</h3>
                <p>Control what each role can view, edit, or approve across your patient portal and admin tools.</p>
                <div class="list-block">
                    <div class="list-item"><span>Appointments</span><span class="pill">Manage</span></div>
                    <div class="list-item"><span>Patient records</span><span class="pill">Read / Write</span></div>
                    <div class="list-item"><span>Billing access</span><span class="pill">Restricted</span></div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route("count-users") }}')
            .then(response => response.json())
            .then(data => {
                const count = document.getElementById('user-count');
                if (count) {
                    count.textContent = data.userCount ?? 0;
                }
            })
            .catch(() => {
                const count = document.getElementById('user-count');
                if (count) {
                    count.textContent = '0';
                }
            });
    });
</script>
@endpush
