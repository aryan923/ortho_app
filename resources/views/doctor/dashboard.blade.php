@extends('layouts.app')

@section('title', 'Doctor Dashboard — OrthoCore Clinic')

@push('styles')
<style>
    .doctor-dashboard-hero {
        padding: 60px 0 46px;
        background: linear-gradient(135deg, rgba(18,83,200,0.95), rgba(31,141,116,0.78));
        color: #fff;
    }

    .doctor-dashboard-hero .wrap {
        display: grid;
        gap: 20px;
    }

    .doctor-dashboard-hero h1 {
        font-size: clamp(2.6rem, 3vw, 3.2rem);
        margin: 0;
    }

    .doctor-dashboard-hero p {
        max-width: 660px;
        font-size: 1.05rem;
        color: rgba(255,255,255,0.88);
    }

    .meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
    }

    .meta-pill {
        display: inline-flex;
        align-items: center;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.92);
        font-weight: 700;
        font-size: 0.95rem;
    }

    .dash-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-soft);
        padding: 28px;
    }

    .dash-panel h2 {
        margin: 0 0 18px;
        font-size: 1.2rem;
        color: var(--ink);
    }

    .booking-table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    .booking-table th,
    .booking-table td {
        padding: 16px 14px;
        border-bottom: 1px solid var(--border);
        text-align: left;
        font-size: 0.95rem;
        color: var(--ink);
    }

    .booking-table th {
        background: rgba(246,249,255,0.9);
        color: var(--ink-md);
        font-weight: 700;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .status-pending { background: #eef2ff; color: #4338ca; }
    .status-confirmed { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    .empty-state {
        padding: 48px 24px;
        text-align: center;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-soft);
        color: var(--ink-muted);
    }

    .empty-state h3 {
        margin-bottom: 12px;
        font-size: 1.4rem;
        color: var(--ink);
    }

    .empty-state p {
        margin: 0;
        max-width: 540px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.8;
    }

    .btn-secondary {
        background: rgba(255,255,255,0.92);
        color: var(--ink);
        border: 1px solid var(--border);
        padding: 12px 20px;
    }

    @media (max-width: 980px) {
        .doctor-dashboard-hero .wrap,
        .meta-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .booking-table th,
        .booking-table td {
            padding: 12px 10px;
        }
    }
</style>
@endpush

@section('content')
<section class="doctor-dashboard-hero" aria-label="Doctor dashboard hero">
    <div class="wrap">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="display:flex;gap:10px;color:rgba(255,255,255,0.85);font-size:0.95rem;">
            <a href="/" style="color:inherit;opacity:.9;">Home</a>
            <span>›</span>
            <span>Doctor Dashboard</span>
        </nav>
        <div>
            <h1>Welcome back, {{ auth()->user()->name }}</h1>
            <p>Review your upcoming appointments, patient notes, and clinic activity in a refined care coordination workspace.</p>
        </div>
        <div class="meta-row">
            <span class="meta-pill">Specialty: {{ $doctor->specialization ?? 'General' }}</span>
            <span class="meta-pill">Clinic: {{ $doctor->clinic_address ?? 'Not set' }}</span>
            <a href="{{ route('doctor.schedule') }}" class="btn btn-secondary">View Doctor Schedule</a>
        </div>
    </div>
</section>

<section class="sec" aria-label="Doctor bookings">
    <div class="wrap">
        <div class="dash-panel">
            <h2>Recent Appointment Requests</h2>
            @if($bookings->count())
                <table class="booking-table" aria-label="Doctor bookings table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Appointment</th>
                            <th>Status</th>
                            <th>Symptoms</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ optional($booking->user)->name ?? 'Unknown Patient' }}<br><small>{{ optional($booking->user)->email ?? '' }}</small></td>
                                <td>{{ $booking->appointment_time->format('D, M j, Y \a\t g:i A') }}</td>
                                <td><span class="status-pill status-{{ Str::slug($booking->status) }}">{{ ucfirst($booking->status) }}</span></td>
                                <td>{{ $booking->symptoms ?: 'No notes provided' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top:18px; display:flex; justify-content:flex-end;">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="empty-state">
                    <h3>No bookings yet</h3>
                    <p>Once patients request appointments, they will appear here with time, status, and clinical notes.</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
