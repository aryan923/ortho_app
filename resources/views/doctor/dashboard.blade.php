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
        margin-bottom: 24px;
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

    .profile-menu {
        position: relative;
        display: inline-block;
    }

    .profile-menu summary {
        list-style: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255,255,255,0.25);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.4);
        cursor: pointer;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .profile-menu summary::-webkit-details-marker {
        display: none;
    }

    .profile-menu[open] summary {
        background: rgba(255,255,255,0.35);
        border-color: rgba(255,255,255,0.6);
    }

    .profile-menu .dropdown-panel {
        position: absolute;
        left: 0;
        top: calc(100% + 8px);
        min-width: 200px;
        background: #fff;
        border: 1px solid rgba(15,31,58,0.12);
        border-radius: 18px;
        box-shadow: 0 18px 40px rgba(15,31,58,0.12);
        padding: 8px 0;
        z-index: 20;
    }

    .profile-menu .dropdown-item,
    .profile-menu .dropdown-item button {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
        padding: 10px 18px;
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
        margin: 20px auto 0;
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

    .status-pill.confirmed,
    .status-pill.completed { background: #dcfce7; color: #166534; }
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
        width: min(540px, 100%);
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(15,31,58,0.15);
        border: 1px solid rgba(15,31,58,0.08);
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
    <div class="wrap hero-grid" style="grid-template-columns: 1fr;">
        <div class="hero-copy">
            <span class="eyebrow" style="opacity: 0.85;">Doctor Dashboard</span>
            <h1 style="margin-bottom: 8px;">Welcome back, {{ auth()->user()->name }}</h1>
            <div class="hero-meta">
                <span class="meta-pill">Specialty: {{ $doctor->specialization ?? 'General' }}</span>
                <span class="meta-pill">Clinic: {{ $doctor->clinic_address ?? 'Not set' }}</span>
                <details class="profile-menu">
                    <summary>⚙ Profile</summary>
                    <div class="dropdown-panel">
                        <a href="{{ route('doctor.profile.edit') }}" class="dropdown-item">Edit Profile</a>
                        <form method="POST" action="{{ route('logout.submit') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: var(--coral); font-weight: 700; border: none; background: transparent; width: 100%; text-align: left; padding: 10px 18px; cursor: pointer;">Logout</button>
                        </form>
                    </div>
                </details>
            </div>
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

<section class="sec" aria-label="Doctor bookings" style="padding-top: 24px; padding-bottom: 48px;">
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
                <table class="booking-table" aria-label="Doctor bookings table" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 20%; text-align: left;">Patient</th>
                            <th style="width: 25%; text-align: left;">Email</th>
                            <th style="width: 22%; text-align: left;">Appointment</th>
                            <th style="width: 13%; text-align: left;">Status</th>
                            <th style="width: 15%; text-align: left;">Symptoms</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="booking-row" tabindex="0"
                                data-booking-id="{{ $booking->id }}"
                                data-booking-patient-id="{{ $booking->patient_id ?? ($booking->user_id ?? '') }}"
                                data-booking-patient="{{ e(optional($booking->user)->name) }}"
                                data-booking-email="{{ e(optional($booking->user)->email) }}"
                                data-booking-time="{{ $booking->appointment_time?->format('M j, Y @ g:i A') }}"
                                data-booking-status="{{ ucfirst($booking->status) }}"
                                data-booking-symptoms="{{ e($booking->symptoms ?: 'No notes provided') }}">
                                <td style="font-weight: 700; color: var(--ink); text-align: left; vertical-align: middle;">{{ optional($booking->user)->name ?? 'Unknown Patient' }}</td>
                                <td style="color: var(--ink-lt); text-align: left; vertical-align: middle; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ optional($booking->user)->email ?? '-' }}</td>
                                <td style="text-align: left; vertical-align: middle;">{{ $booking->appointment_time->format('D, M j, Y \a\t g:i A') }}</td>
                                <td style="text-align: left; vertical-align: middle;"><span class="status-pill {{ Str::slug($booking->status) }}">{{ ucfirst($booking->status) }}</span></td>
                                <td style="max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; text-align: left; vertical-align: middle; color: var(--ink-lt);">{{ $booking->symptoms ?: 'No notes provided' }}</td>
                                <td style="text-align: right; vertical-align: middle; padding-right: 14px;"></td>
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
                <div id="history-loading" style="padding: 16px; text-align: center; color: var(--ink-lt);">Loading history...</div>
                <div id="history-content" style="display: none; max-height: 380px; overflow-y: auto; padding-right: 4px;">
                    <div id="history-bookings-list" style="margin-bottom: 24px;">
                        <h4 style="font-size: 13.5px; font-weight: 700; color: var(--blue); margin-bottom: 10px; border-bottom: 1px solid var(--border); padding-bottom: 6px;">Appointment History</h4>
                        <div class="history-list-items" style="display: grid; gap: 10px;"></div>
                    </div>
                    <div>
                        <h4 style="font-size: 13.5px; font-weight: 700; color: var(--blue); margin-bottom: 10px; border-bottom: 1px solid var(--border); padding-bottom: 6px;">Prescriptions &amp; Diagnoses</h4>
                        <div class="prescription-list-items" style="display: grid; gap: 10px;"></div>
                    </div>
                </div>
            </section>
            <section class="booking-section" data-tab-panel="prescription">
                <form id="prescription-form" novalidate>
                    @csrf
                    <input type="hidden" id="prescription-patient-id" name="patient_id">
                    <input type="hidden" id="prescription-booking-id" name="appointment_id">
                    <div class="form-field">
                        <label for="medication-name">Diagnosis</label>
                        <input id="medication-name" name="diagnosis" type="text" placeholder="e.g., Left knee osteoarthritis" required>
                    </div>
                    <div class="form-field">
                        <label for="medication-details">Medicines (Rx)</label>
                        <textarea id="medication-details" name="prescription" placeholder="e.g., Celecoxib 200mg once daily after meal for 14 days" required style="height: 80px; min-height: 80px;"></textarea>
                    </div>
                    <div class="form-field">
                        <label for="medication-instructions">Notes / Special Instructions</label>
                        <textarea id="medication-instructions" name="notes" placeholder="e.g., Avoid heavy lifting, apply cold pack daily" style="height: 80px; min-height: 80px;"></textarea>
                    </div>
                    <div style="margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                        <span id="prescription-status-message" style="align-self: center; font-size: 13px; font-weight: 600;"></span>
                        <button type="submit" class="btn btn-solid btn-sm" style="padding: 10px 22px; font-weight: 700;">Save Prescription</button>
                    </div>
                </form>
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

        let activePatientId = null;
        let activeBookingId = null;

        function openModal(row) {
            activePatientId = row.dataset.bookingPatientId;
            activeBookingId = row.dataset.bookingId;

            document.getElementById('prescription-patient-id').value = activePatientId;
            document.getElementById('prescription-booking-id').value = activeBookingId;
            document.getElementById('prescription-form').reset();
            document.getElementById('prescription-status-message').textContent = '';

            fields.patient.textContent = row.dataset.bookingPatient || 'Unknown';
            fields.email.textContent = row.dataset.bookingEmail || '-';
            fields.time.textContent = row.dataset.bookingTime || '-';
            fields.status.textContent = row.dataset.bookingStatus || '-';
            fields.symptoms.textContent = row.dataset.bookingSymptoms || 'No notes provided';

            // Reset tabs to overview
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            document.querySelector('[data-tab="overview"]').classList.add('active');
            document.querySelector('[data-tab-panel="overview"]').classList.add('active');

            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');

            loadPatientHistory(activePatientId);
        }

        function loadPatientHistory(patientId) {
            const loadingEl = document.getElementById('history-loading');
            const contentEl = document.getElementById('history-content');
            const bookingsList = document.querySelector('.history-list-items');
            const prescriptionsList = document.querySelector('.prescription-list-items');

            loadingEl.style.display = 'block';
            contentEl.style.display = 'none';
            bookingsList.innerHTML = '';
            prescriptionsList.innerHTML = '';

            fetch(`/patients/${patientId}/history`)
                .then(response => response.json())
                .then(data => {
                    loadingEl.style.display = 'none';
                    contentEl.style.display = 'block';

                    // Render bookings
                    if (data.bookings && data.bookings.length > 0) {
                        data.bookings.forEach(b => {
                            const dateStr = new Date(b.appointment_time).toLocaleDateString(undefined, {
                                weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
                            });
                            const div = document.createElement('div');
                            div.style.padding = '10px 14px';
                            div.style.background = '#f8fafc';
                            div.style.borderRadius = '10px';
                            div.style.border = '1px solid rgba(15,31,58,0.06)';
                            div.innerHTML = `
                                <div style="display:flex; justify-content:space-between; font-weight:700; font-size:13px; color:#0f1f3a;">
                                    <span>${dateStr}</span>
                                    <span style="font-size:11px; text-transform:uppercase;" class="status-pill ${b.status}">${b.status}</span>
                                </div>
                                <div style="font-size:12.5px; color:#64748b; margin-top:4px;">Symptoms: ${b.symptoms || 'None recorded'}</div>
                            `;
                            bookingsList.appendChild(div);
                        });
                    } else {
                        bookingsList.innerHTML = '<p style="font-size:13px; color:#64748b; font-style:italic;">No past appointments found.</p>';
                    }

                    // Render prescriptions
                    if (data.prescriptions && data.prescriptions.length > 0) {
                        data.prescriptions.forEach(p => {
                            const dateStr = new Date(p.created_at).toLocaleDateString(undefined, {
                                year: 'numeric', month: 'short', day: 'numeric'
                            });
                            const div = document.createElement('div');
                            div.style.padding = '12px 14px';
                            div.style.background = '#f0fdf4';
                            div.style.borderRadius = '10px';
                            div.style.border = '1px solid rgba(22,163,74,0.1)';
                            div.innerHTML = `
                                <div style="font-weight:700; font-size:13px; color:#166534; display:flex; justify-content:space-between;">
                                    <span>Diagnosis: ${p.diagnosis}</span>
                                    <span style="font-weight:600; color:#5f6f85; font-size:11px;">${dateStr}</span>
                                </div>
                                <div style="font-size:12.5px; color:#1b4332; margin-top:4px; font-weight:600;">Rx: ${p.prescription}</div>
                                ${p.notes ? `<div style="font-size:11.5px; color:#5f6f85; margin-top:4px; font-style:italic;">Notes: ${p.notes}</div>` : ''}
                            `;
                            prescriptionsList.appendChild(div);
                        });
                    } else {
                        prescriptionsList.innerHTML = '<p style="font-size:13px; color:#64748b; font-style:italic;">No prescriptions found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching history:', error);
                    loadingEl.textContent = 'Failed to load patient history.';
                });
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

        // Close profile menu dropdown when clicking outside
        const profileMenu = document.querySelector('.profile-menu');
        if (profileMenu) {
            document.addEventListener('click', function (event) {
                if (!profileMenu.contains(event.target)) {
                    profileMenu.removeAttribute('open');
                }
            });
        }

        // Prescription Form Submit Handler
        const prescriptionForm = document.getElementById('prescription-form');
        prescriptionForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const statusMsg = document.getElementById('prescription-status-message');
            statusMsg.textContent = 'Saving...';
            statusMsg.style.color = 'var(--ink-lt)';

            const formData = new FormData(prescriptionForm);
            
            fetch('/prescriptions', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMsg.textContent = '✓ Saved successfully';
                    statusMsg.style.color = 'var(--green)';
                    prescriptionForm.reset();
                    
                    // Reload patient history tab to include new prescription
                    loadPatientHistory(activePatientId);

                    // Reload page to reflect updated booking status in the dashboard queue
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    statusMsg.textContent = 'Error: ' + (data.message || 'Could not save');
                    statusMsg.style.color = 'var(--coral)';
                }
            })
            .catch(error => {
                console.error('Error saving prescription:', error);
                statusMsg.textContent = 'Failed to connect to server.';
                statusMsg.style.color = 'var(--coral)';
            });
        });
    });
</script>
@endpush

