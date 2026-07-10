@extends('layouts.doctor')

@section('title', 'Doctor Dashboard — OrthoCore Clinic')

@push('styles')
<style>
    .doctor-dashboard-hero {
        padding: 60px 0 42px;
        background: linear-gradient(135deg, rgba(18,83,200,0.95), rgba(31,141,116,0.78));
        color: #fff;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        align-items: center;
    }

    .hero-copy h1 {
        margin: 0 0 14px;
        font-size: clamp(2.6rem, 3vw, 3.2rem);
        line-height: 1.02;
    }

    .hero-copy p {
        margin: 0;
        max-width: 680px;
        font-size: 1rem;
        color: rgba(255,255,255,0.92);
        line-height: 1.75;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        margin-top: 16px;
    }

    .meta-pill {
        display: inline-flex;
        align-items: center;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255,255,255,0.16);
        color: rgba(255,255,255,0.94);
        font-weight: 700;
        font-size: 0.95rem;
    }

    .hero-actions {
        display: grid;
        gap: 12px;
        justify-content: end;
    }

    .hero-actions .btn,
    .hero-actions summary {
        min-width: 160px;
    }

    .profile-menu {
        position: relative;
    }

    .profile-menu summary {
        list-style: none;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 12px 18px;
        border-radius: 16px;
        background: #fff;
        color: #0f1f3a;
        border: 1px solid rgba(15,31,58,0.12);
        cursor: pointer;
        font-weight: 700;
    }

    .profile-menu summary::-webkit-details-marker {
        display: none;
    }

    .profile-menu[open] summary {
        border-color: rgba(18,83,200,0.35);
        box-shadow: 0 10px 20px rgba(18,83,200,0.12);
    }

    .profile-menu .dropdown-panel {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        min-width: 220px;
        background: #fff;
        border: 1px solid rgba(15,31,58,0.12);
        border-radius: 18px;
        box-shadow: 0 18px 40px rgba(15,31,58,0.12);
        padding: 10px 0;
        z-index: 20;
    }

    .profile-menu .dropdown-item,
    .profile-menu .dropdown-item button {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
        padding: 12px 18px;
        background: transparent;
        border: none;
        color: #0f1f3a;
        text-align: left;
        text-decoration: none;
        font-size: 0.95rem;
        cursor: pointer;
    }

    .profile-menu .dropdown-item:hover,
    .profile-menu .dropdown-item button:hover {
        background: rgba(18,83,200,0.08);
        color: #1253c8;
    }

    .dashboard-summary {
        margin: -36px auto 0;
        max-width: 1180px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        padding: 0 16px;
    }

    .summary-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(15,31,58,0.08);
        box-shadow: 0 18px 40px rgba(15,31,58,0.08);
        padding: 24px;
    }

    .summary-card h3 {
        margin: 0 0 10px;
        color: #5f6f85;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .summary-card p {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: #0f1f3a;
    }

    .schedule-panel {
        margin: 48px auto 0;
        background: #fff;
        border: 1px solid rgba(15,31,58,0.08);
        border-radius: 28px;
        box-shadow: 0 18px 40px rgba(15,31,58,0.08);
    }

    .schedule-panel header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 26px 28px;
        border-bottom: 1px solid rgba(15,31,58,0.08);
    }

    .schedule-panel header h2 {
        margin: 0;
        font-size: 1.25rem;
        color: #0f1f3a;
    }

    .schedule-panel header p {
        margin: 4px 0 0;
        color: #64748b;
    }

    .booking-table {
        width: 100%;
        border-collapse: collapse;
    }

    .booking-table th,
    .booking-table td {
        padding: 18px 22px;
        border-bottom: 1px solid rgba(15,31,58,0.08);
        color: #28304d;
        font-size: 0.95rem;
    }

    .booking-table th {
        background: #f6faff;
        color: #5f6f85;
        font-weight: 700;
        text-align: left;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    .booking-row {
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .booking-row:hover {
        background: rgba(18,83,200,0.06);
    }

    .booking-row:hover td:last-child {
        color: #1253c8;
    }

    .booking-row td:last-child {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
        color: #8392ac;
        font-weight: 700;
    }

    .booking-row td:last-child::after {
        content: '›';
        display: inline-block;
        font-size: 1.2rem;
        transition: transform 0.2s ease;
    }

    .booking-row:hover td:last-child::after {
        transform: translateX(4px);
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .status-pill.confirmed { background: #dcfce7; color: #166534; }
    .status-pill.pending { background: #eff6ff; color: #1d4ed8; }
    .status-pill.cancelled { background: #fee2e2; color: #991b1b; }

    .empty-state {
        padding: 44px 32px;
        text-align: center;
        color: #5f6f85;
    }

    .empty-state h3 {
        margin-bottom: 10px;
        color: #0f1f3a;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 60;
        padding: 24px;
    }

    .modal-overlay.active {
        display: flex;
    }

    .booking-modal {
        width: min(760px, 100%);
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 28px 70px rgba(15,31,58,0.18);
    }

    .booking-modal header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 24px 28px;
        border-bottom: 1px solid rgba(15,31,58,0.08);
    }

    .booking-modal header h3 {
        margin: 0;
        font-size: 1.35rem;
        color: #0f1f3a;
    }

    .booking-modal header p {
        margin: 0;
        color: #64748b;
    }

    .modal-close {
        border: none;
        background: transparent;
        font-size: 1.6rem;
        color: #64748b;
        cursor: pointer;
        line-height: 1;
    }

    .booking-tabs {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-bottom: 1px solid rgba(15,31,58,0.08);
    }

    .booking-tab {
        background: transparent;
        border: none;
        padding: 18px 20px;
        color: #64748b;
        font-weight: 700;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .booking-tab.active {
        color: #1253c8;
        border-bottom: 3px solid #1253c8;
    }

    .booking-body {
        padding: 26px 28px 32px;
    }

    .booking-section {
        display: none;
    }

    .booking-section.active {
        display: block;
    }

    .booking-detail {
        display: grid;
        gap: 16px;
    }

    .booking-detail dt {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 4px;
    }

    .booking-detail dd {
        margin: 0;
        color: #0f1f3a;
        font-size: 1rem;
    }

    .form-field {
        display: grid;
        gap: 8px;
        margin-top: 18px;
    }

    .form-field label {
        color: #324152;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .form-field input,
    .form-field textarea {
        width: 100%;
        padding: 14px 16px;
        border-radius: 16px;
        border: 1px solid rgba(15,31,58,0.12);
        background: #f8fafc;
        color: #0f1f3a;
        font-size: 0.95rem;
    }

    .form-field textarea {
        min-height: 140px;
        resize: vertical;
    }

    @media (max-width: 980px) {
        .hero-grid,
        .dashboard-summary,
        .booking-tabs {
            grid-template-columns: 1fr;
        }

        .hero-actions {
            justify-content: stretch;
        }
    }
</style>
@endpush

@section('content')
<section class="doctor-dashboard-hero" aria-label="Doctor dashboard hero">
    <div class="wrap hero-grid">
        <div class="hero-copy">
            <span class="eyebrow">Doctor dashboard</span>
            <h1>Welcome back, {{ auth()->user()->name }}</h1>
            <p>Monitor your patients, upcoming appointments, and clinical notes from a polished care workspace.</p>
            <div class="hero-meta">
                <span class="meta-pill">Specialty: {{ $doctor->specialization ?? 'General' }}</span>
                <span class="meta-pill">Clinic: {{ $doctor->clinic_address ?? 'Not set' }}</span>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('doctor.schedule') }}" class="btn btn-secondary">Schedule</a>
            <details class="profile-menu">
                <summary>Profile</summary>
                <div class="dropdown-panel">
                    <a href="{{ route('doctor.profile.edit') }}" class="dropdown-item">Edit profile</a>
                    <form method="POST" action="{{ route('logout.submit') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </div>
            </details>
        </div>
    </div>
</section>

<div class="dashboard-summary wrap">
    <article class="summary-card">
        <h3>Total appointments</h3>
        <p>{{ $totalBookings }}</p>
    </article>
    <article class="summary-card">
        <h3>Upcoming visits</h3>
        <p>{{ $upcomingBookings }}</p>
    </article>
    <article class="summary-card">
        <h3>Recent requests</h3>
        <p>{{ $bookings->count() }}</p>
    </article>
</div>

<section class="sec" aria-label="Doctor bookings">
    <div class="wrap schedule-panel">
        <header>
            <div>
                <h2>Appointment queue</h2>
                <p>Tap any appointment row to review visit details.</p>
            </div>
            <span class="meta-pill">Click to expand</span>
        </header>

        @if($bookings->count())
            <div style="overflow-x:auto;">
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
                            <tr class="booking-row" tabindex="0"
                                data-booking-patient="{{ e(optional($booking->user)->name) }}"
                                data-booking-email="{{ e(optional($booking->user)->email) }}"
                                data-booking-time="{{ $booking->appointment_time?->format('M j, Y @ g:i A') }}"
                                data-booking-status="{{ ucfirst($booking->status) }}"
                                data-booking-symptoms="{{ e($booking->symptoms ?: 'No notes provided') }}">
                                <td>{{ optional($booking->user)->name ?? 'Unknown Patient' }}<br><small>{{ optional($booking->user)->email ?? '' }}</small></td>
                                <td>{{ $booking->appointment_time->format('D, M j, Y \a\t g:i A') }}</td>
                                <td><span class="status-pill {{ Str::slug($booking->status) }}">{{ ucfirst($booking->status) }}</span></td>
                                <td>{{ $booking->symptoms ?: 'No notes provided' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding: 20px 28px 28px; display:flex; justify-content:flex-end;">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="empty-state">
                <h3>No bookings found</h3>
                <p>Patient visits will appear here once new appointments are confirmed.</p>
            </div>
        @endif
    </div>
</section>

<div id="booking-modal" class="modal-overlay" aria-hidden="true">
    <div class="booking-modal" role="dialog" aria-modal="true" aria-labelledby="booking-modal-title">
        <header>
            <div>
                <h3 id="booking-modal-title">Appointment details</h3>
                <p id="booking-modal-subtitle">Review the patient visit and clinical notes.</p>
            </div>
            <button type="button" class="modal-close" aria-label="Close appointment details" data-modal-close>&times;</button>
        </header>
        <div class="booking-tabs" role="tablist">
            <button type="button" class="booking-tab active" data-tab="overview">Overview</button>
            <button type="button" class="booking-tab" data-tab="history">Patient history</button>
            <button type="button" class="booking-tab" data-tab="prescription">Prescription</button>
        </div>
        <div class="booking-body">
            <section class="booking-section active" data-tab-panel="overview">
                <dl class="booking-detail">
                    <dt>Patient</dt>
                    <dd id="modal-patient-name"></dd>
                    <dt>Email</dt>
                    <dd id="modal-patient-email"></dd>
                    <dt>Appointment</dt>
                    <dd id="modal-appointment-time"></dd>
                    <dt>Status</dt>
                    <dd id="modal-appointment-status"></dd>
                    <dt>Symptoms</dt>
                    <dd id="modal-appointment-symptoms"></dd>
                </dl>
            </section>
            <section class="booking-section" data-tab-panel="history">
                <p>Previous visits are not available in this preview, but this area can display past encounters, notes, and diagnoses.</p>
            </section>
            <section class="booking-section" data-tab-panel="prescription">
                <div class="form-field">
                    <label for="medication-name">Diagnosis</label>
                    <input id="medication-name" type="text" placeholder="e.g., Viral pharyngitis" disabled>
                </div>
                <div class="form-field">
                    <label for="medication-details">Medicines (Rx)</label>
                    <textarea id="medication-details" placeholder="e.g., Amoxicillin 500mg" disabled></textarea>
                </div>
                <div class="form-field">
                    <label for="medication-instructions">Instructions</label>
                    <textarea id="medication-instructions" placeholder="Take 1 tablet twice a day after meals" disabled></textarea>
                </div>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.booking-row');
        const modal = document.getElementById('booking-modal');
        const modalClose = document.querySelector('[data-modal-close]');
        const tabs = document.querySelectorAll('.booking-tab');
        const panels = document.querySelectorAll('[data-tab-panel]');

        const fields = {
            patient: document.getElementById('modal-patient-name'),
            email: document.getElementById('modal-patient-email'),
            time: document.getElementById('modal-appointment-time'),
            status: document.getElementById('modal-appointment-status'),
            symptoms: document.getElementById('modal-appointment-symptoms'),
        };

        function openModal(row) {
            fields.patient.textContent = row.dataset.bookingPatient || 'Unknown';
            fields.email.textContent = row.dataset.bookingEmail || '-';
            fields.time.textContent = row.dataset.bookingTime || '-';
            fields.status.textContent = row.dataset.bookingStatus || '-';
            fields.symptoms.textContent = row.dataset.bookingSymptoms || 'No notes provided';
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
        }

        rows.forEach(function (row) {
            row.addEventListener('click', function () {
                openModal(row);
            });
        });

        if (modalClose) {
            modalClose.addEventListener('click', closeModal);
        }

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));
                tab.classList.add('active');
                document.querySelector(`[data-tab-panel="${tab.dataset.tab}"]`).classList.add('active');
            });
        });
    });
</script>
@endpush

