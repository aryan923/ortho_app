@extends('layouts.admin')

@section('title', 'Dashboard Overview | Admin')

@push('styles')
<style>
    .page-heading { margin-bottom: 24px; }
    .page-heading h1 { font-size: 1.7rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .page-heading p { font-size: 0.93rem; color: #6b7a99; margin: 0; }

    .stat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #e3e9f3;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .stat-card .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: grid; place-items: center;
        font-size: 1.2rem;
    }
    .stat-card .stat-icon.blue   { background: #eef3ff; color: #4070f4; }
    .stat-card .stat-icon.purple { background: #f3eeff; color: #7c3aed; }
    .stat-card .stat-icon.amber  { background: #fff8e6; color: #d97706; }
    .stat-card .stat-icon.green  { background: #e8faf2; color: #059669; }
    .stat-card .stat-value { font-size: 1.9rem; font-weight: 700; color: #1a2550; margin: 0; }
    .stat-card .stat-label { font-size: 0.88rem; color: #6b7a99; margin: 0; }

    .bottom-row {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 18px;
    }

    .panel {
        background: #fff;
        border: 1px solid #e3e9f3;
        border-radius: 14px;
        padding: 20px;
    }
    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    .panel-head h3 { font-size: 1rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .panel-head p { font-size: 0.85rem; color: #6b7a99; margin: 0; }
    .panel-btn {
        background: #eef3ff;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        color: #4070f4;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }
    .panel-btn:hover { background: #dde7ff; }

    .chart-container {
        height: 260px;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
    }

    #chart-loading {
        height: 260px;
        background: #f8faff;
        border: 1px solid #e3e9f3;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9aa5be;
        font-size: 0.9rem;
    }

    .reg-table { width: 100%; border-collapse: collapse; }
    .reg-table th {
        text-align: left;
        padding: 8px 10px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #9aa5be;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid #e3e9f3;
    }
    .reg-table td {
        padding: 12px 10px;
        border-bottom: 1px solid #f1f5fb;
        vertical-align: middle;
    }
    .reg-table tr:last-child td { border-bottom: none; }

    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-av {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: #4070f4;
        color: #fff;
        display: grid; place-items: center;
        font-size: 0.82rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .user-name { font-weight: 600; font-size: 0.9rem; color: #1a2550; }
    .user-email { font-size: 0.8rem; color: #9aa5be; }

    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .badge-status.active  { background: #e8faf2; color: #059669; }
    .badge-status.admin   { background: #eef3ff; color: #4070f4; }
    .badge-status.doctor  { background: #f3eeff; color: #7c3aed; }
    .badge-status.user    { background: #f1f5fb; color: #6b7a99; }

    @media (max-width: 1100px) {
        .stat-row { grid-template-columns: repeat(2, 1fr); }
        .bottom-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .stat-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="page-heading">
    <h1>Dashboard Overview</h1>
    <p>Welcome back! Here&apos;s what is happening across the platform today.</p>
</div>

<div class="stat-row">
    <div class="stat-card">
        <div class="stat-icon blue">&#128100;</div>
        <p class="stat-value">{{ $userCount }}</p>
        <p class="stat-label">Total Patients</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">&#129658;</div>
        <p class="stat-value">{{ $doctorCount }}</p>
        <p class="stat-label">Total Doctors</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">&#128197;</div>
        <p class="stat-value">{{ $appointmentCount }}</p>
        <p class="stat-label">Pending Appointments</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">&#128196;</div>
        <p class="stat-value">{{ $roleCount }}</p>
        <p class="stat-label">Total Prescriptions</p>
    </div>
</div>

<div class="bottom-row">
    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Registered Users (Last 7 Days)</h3>
                <p>Daily count of new patients and doctors joining the platform.</p>
            </div>
        </div>
        <div id="chart-loading">Loading chart&hellip;</div>
        <div id="chart-container" class="chart-container" style="display:none;"></div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Recent Registrations</h3>
                <p>Latest users who joined the platform.</p>
            </div>
            <button class="panel-btn" type="button">View All</button>
        </div>
        <table class="reg-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-av">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php $role = strtolower(optional($user->roles->first())->name ?? 'user'); @endphp
                        <span class="badge-status {{ $role }}">{{ strtoupper($role) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" style="color:#9aa5be; padding:16px 10px;">No recent registrations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.setOnLoadCallback(fetchAndDraw);

    function fetchAndDraw() {
        fetch('{{ route("graph.data") }}')
            .then(function(res) { return res.json(); })
            .then(function(rows) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Users');
                data.addColumn('number', 'Doctors');

                // rows[0] is the header — skip it
                for (var i = 1; i < rows.length; i++) {
                    data.addRow([rows[i][0], rows[i][1], rows[i][2]]);
                }

                var options = {
                    chartArea: { left: 48, right: 24, top: 16, bottom: 40, width: '100%', height: '100%' },
                    height: 260,
                    colors: ['#4070f4', '#7c3aed'],
                    curveType: 'function',
                    legend: { position: 'bottom', textStyle: { color: '#6b7a99', fontSize: 12 } },
                    hAxis: {
                        textStyle: { color: '#9aa5be', fontSize: 11 },
                        gridlines: { color: 'transparent' }
                    },
                    vAxis: {
                        minValue: 0,
                        format: '0',
                        textStyle: { color: '#9aa5be', fontSize: 11 },
                        gridlines: { color: '#f1f5fb' },
                        baselineColor: '#e3e9f3'
                    },
                    series: {
                        0: { lineWidth: 2.5, pointSize: 5, pointShape: 'circle' },
                        1: { lineWidth: 2.5, pointSize: 5, pointShape: 'circle' }
                    },
                    tooltip: { isHtml: false },
                    backgroundColor: 'transparent',
                    fontName: 'Inter, system-ui, sans-serif'
                };

                var loading = document.getElementById('chart-loading');
                var container = document.getElementById('chart-container');
                if (loading) loading.style.display = 'none';
                if (container) container.style.display = 'block';

                var chart = new google.visualization.LineChart(container);
                chart.draw(data, options);

                // Redraw on resize
                window.addEventListener('resize', function() { chart.draw(data, options); });
            })
            .catch(function() {
                var loading = document.getElementById('chart-loading');
                if (loading) loading.textContent = 'Could not load chart data.';
            });
    }
</script>
@endpush
@endsection
