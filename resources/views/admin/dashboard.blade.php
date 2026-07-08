@extends('layouts.app')

@section('title', 'Admin Dashboard | OrthoCore Clinic')

@push('styles')
<style>
    .admin-hero {
        padding: 54px 0 36px;
        background: linear-gradient(135deg, rgba(18,83,200,0.12), rgba(255,255,255,0.98));
        border: 1px solid rgba(18,83,200,0.12);
        box-shadow: var(--shadow-soft);
        border-radius: var(--r-lg);
    }

    .admin-hero h1 {
        margin: 0 0 14px;
        font-size: clamp(2.4rem, 3vw, 2.9rem);
    }

    .admin-hero p {
        color: var(--ink-muted);
        font-size: 1rem;
        max-width: 720px;
        line-height: 1.75;
    }

    .admin-shell {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 24px;
        align-items: start;
    }

    .admin-content {
        display: grid;
        gap: 24px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 26px;
        box-shadow: var(--shadow-soft);
    }

    .stat-card .label {
        color: var(--ink-muted);
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .stat-card .value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--ink);
    }

    .panel-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 22px;
    }

    .panel-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 26px;
        box-shadow: var(--shadow-soft);
    }

    .panel-card h3 {
        margin: 0 0 14px;
        color: var(--ink);
        font-size: 1.05rem;
        font-weight: 800;
    }

    .panel-card p {
        color: var(--ink-muted);
        line-height: 1.8;
        margin: 0;
    }

    .list-block {
        margin-top: 18px;
        display: grid;
        gap: 12px;
    }

    .list-item {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid rgba(15,31,58,0.06);
        color: var(--ink);
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .pill {
        background: rgba(18,83,200,0.08);
        color: var(--blue);
        padding: 6px 12px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    @media (max-width: 960px) {
        .admin-shell,
        .stats-grid,
        .panel-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="admin-hero" id="overview">
    <div class="wrap">
        <h1>Admin overview</h1>
        <p>Monitor clinic operations, staff access, and permissions through a polished administrative workspace designed for clinical clarity.</p>
    </div>
</section>

<div class="wrap admin-shell">
    @include('partials.admin-sidebar')

    <div class="admin-content">
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
                <p>Review account activity and manage access for administrators, doctors, and clinical support staff.</p>
                <div class="list-block">
                    <div class="list-item"><span>Dr. Amelia Brooks</span><span class="pill">Admin</span></div>
                    <div class="list-item"><span>Marcus Lee</span><span class="pill">Staff</span></div>
                    <div class="list-item"><span>Jasmine Patel</span><span class="pill">Doctor</span></div>
                </div>
            </section>

            <section class="panel-card" id="roles">
                <h3>Role controls</h3>
                <p>Create and update team roles to reflect responsibilities across the clinic and care coordination teams.</p>
                <div class="list-block">
                    <div class="list-item"><span>Super Admin</span><span class="pill">Full access</span></div>
                    <div class="list-item"><span>Clinic Manager</span><span class="pill">Scheduling</span></div>
                    <div class="list-item"><span>Reception</span><span class="pill">Booking</span></div>
                </div>
            </section>
        </div>

        <section class="panel-card" id="permissions">
            <h3>Permission overview</h3>
            <p>Manage what each role can view, edit, and approve across your patient portal and administrative tools.</p>
            <div class="list-block">
                <div class="list-item"><span>Appointments</span><span class="pill">Manage</span></div>
                <div class="list-item"><span>Patient records</span><span class="pill">Read / Write</span></div>
                <div class="list-item"><span>Billing access</span><span class="pill">Restricted</span></div>
            </div>
        </section>
    </div>
</div>
@endsection
