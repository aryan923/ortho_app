@extends('layouts.app')

@section('title', isset($doctor) ? 'Book Consultation with ' . optional($doctor->user)->name : 'Doctor Schedules — OrthoCore Clinic')

@push('styles')
<style>
    /* Hero Section */
    .schedule-hero {
        padding: 50px 0 40px;
        background: var(--bg-soft);
        border-bottom: 1px solid var(--border);
    }

    .schedule-hero .wrap {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: var(--ink-lt);
        font-weight: 600;
    }

    .breadcrumb-nav a {
        color: var(--ink-lt);
        transition: color 0.15s;
    }

    .breadcrumb-nav a:hover {
        color: var(--blue);
    }

    .breadcrumb-nav span {
        opacity: 0.5;
    }

    .schedule-hero h1 {
        margin: 0;
        font-size: clamp(2rem, 3.2vw, 2.8rem);
        font-weight: 800;
        color: var(--ink);
        letter-spacing: -0.02em;
    }

    .schedule-hero p {
        margin: 0;
        color: var(--ink-lt);
        font-size: 1.05rem;
        max-width: 720px;
        line-height: 1.6;
    }

    /* Booking Container */
    .booking-container {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 40px;
        margin-top: 40px;
    }

    /* Doctor Details Card */
    .doctor-details-sidebar {
        align-self: start;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 32px;
        box-shadow: var(--sh-sm);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .doctor-avatar-large {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue), var(--teal));
        color: var(--white);
        font-size: 2.8rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid var(--white);
        box-shadow: 0 10px 25px rgba(18, 83, 200, 0.15);
        margin-bottom: 24px;
    }

    .doctor-details-sidebar h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--ink);
        margin: 0 0 6px;
    }

    .doctor-details-sidebar .specialty-badge {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--teal);
        background: var(--teal-lt);
        padding: 4px 14px;
        border-radius: 100px;
        margin-bottom: 24px;
        display: inline-block;
    }

    .doctor-info-list {
        width: 100%;
        text-align: left;
        border-top: 1px solid var(--border);
        padding-top: 24px;
        margin-bottom: 24px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-bottom: 18px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-item span {
        font-size: 0.8rem;
        color: var(--ink-lt);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-item strong {
        font-size: 0.95rem;
        color: var(--ink);
        font-weight: 600;
    }

    .doctor-bio-box {
        text-align: left;
        width: 100%;
        border-top: 1px solid var(--border);
        padding-top: 24px;
    }

    .doctor-bio-box h4 {
        margin: 0 0 8px;
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--ink);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .doctor-bio-box p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--ink-md);
        line-height: 1.6;
    }

    /* Scheduler Main Box */
    .scheduler-main {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 40px;
        box-shadow: var(--sh-sm);
    }

    .step-section {
        margin-bottom: 36px;
    }

    .step-section:last-child {
        margin-bottom: 0;
    }

    .step-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--ink);
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: var(--blue-lt);
        color: var(--blue);
        font-size: 0.85rem;
        font-weight: 800;
        border-radius: 50%;
    }

    /* Date Selector */
    .date-scroll-container {
        position: relative;
    }

    .date-selector-row {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 4px 4px 16px;
        scrollbar-width: thin;
        -webkit-overflow-scrolling: touch;
    }

    .date-pill-btn {
        flex: 0 0 90px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 16px 10px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: inherit;
    }

    .date-pill-btn:hover {
        border-color: var(--blue);
        transform: translateY(-2px);
        box-shadow: var(--sh-sm);
    }

    .date-pill-btn.active {
        background: var(--blue);
        border-color: var(--blue);
        color: var(--white);
        box-shadow: 0 8px 20px rgba(18, 83, 200, 0.25);
    }

    .date-pill-btn .day-lbl {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        opacity: 0.8;
    }

    .date-pill-btn.active .day-lbl {
        opacity: 1;
    }

    .date-pill-btn .day-num-lbl {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1.1;
        margin: 4px 0;
    }

    .date-pill-btn .month-lbl {
        font-size: 0.75rem;
        font-weight: 700;
        opacity: 0.8;
    }

    .date-pill-btn.active .month-lbl {
        opacity: 1;
    }

    /* Slots Grid */
    .slots-grid-wrapper {
        min-height: 120px;
        position: relative;
    }

    .slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
    }

    .time-slot-btn {
        padding: 14px 10px;
        background: var(--white);
        border: 1.5px solid var(--border);
        border-radius: 14px;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--ink-md);
        cursor: pointer;
        text-align: center;
        transition: all 0.18s ease;
        font-family: inherit;
    }

    .time-slot-btn:hover:not(.slot-booked):not(.active) {
        border-color: var(--teal);
        color: var(--teal);
        background: var(--teal-lt);
        transform: translateY(-1px);
    }

    .time-slot-btn.active {
        background: var(--teal);
        border-color: var(--teal);
        color: var(--white);
        box-shadow: 0 6px 15px rgba(11, 161, 153, 0.25);
    }

    .time-slot-btn.slot-booked {
        opacity: 0.35;
        background: var(--bg-soft);
        border-color: var(--border);
        color: var(--ink-lt);
        text-decoration: line-through;
        cursor: not-allowed;
    }

    /* Loading Spinner */
    .slots-loader {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        z-index: 5;
        font-weight: 600;
        color: var(--blue);
        gap: 8px;
    }

    .spinner-icon {
        width: 20px;
        height: 20px;
        border: 3px solid rgba(18, 83, 200, 0.1);
        border-top-color: var(--blue);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Symptoms */
    .symptoms-textarea {
        width: 100%;
        min-height: 110px;
        padding: 16px;
        border: 1.5px solid var(--border);
        border-radius: 16px;
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--ink);
        resize: vertical;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .symptoms-textarea:focus {
        outline: none;
        border-color: var(--blue);
        box-shadow: var(--sh-sm);
    }

    /* Form Actions */
    .booking-actions {
        margin-top: 36px;
        border-top: 1px solid var(--border);
        padding-top: 28px;
        display: flex;
        justify-content: flex-end;
    }

    .booking-actions .btn {
        padding: 16px 36px;
        border-radius: 16px;
        font-size: 1rem;
        font-weight: 700;
        min-width: 200px;
        justify-content: center;
    }

    /* Roster Grid (No Doctor State) */
    .roster-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-top: 30px;
    }

    .roster-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 24px;
        box-shadow: var(--sh-sm);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .roster-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--sh-md);
    }

    .roster-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue), var(--teal));
        color: var(--white);
        font-size: 1.8rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }

    .roster-card h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--ink);
        margin: 0 0 4px;
    }

    .roster-card p {
        font-size: 0.95rem;
        color: var(--teal);
        font-weight: 600;
        margin: 0 0 20px;
    }

    .roster-card .btn {
        width: 100%;
        justify-content: center;
    }

    /* Modal Styling */
    .booking-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 24, 39, 0.6);
        backdrop-filter: blur(8px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .booking-modal-content {
        background: var(--white);
        border-radius: 28px;
        padding: 40px;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 30px 70px rgba(11, 24, 39, 0.25);
        text-align: center;
        transform: scale(0.9);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid var(--border);
    }

    .booking-modal-overlay.open {
        display: flex;
    }

    .booking-modal-overlay.open .booking-modal-content {
        transform: scale(1);
    }

    .success-icon-box {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--green-lt);
        color: var(--green);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 2.2rem;
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.15);
    }

    .booking-modal-content h2 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--ink);
        margin: 0 0 10px;
    }

    .booking-modal-content p {
        color: var(--ink-lt);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0 0 28px;
    }

    .summary-box {
        background: var(--bg-soft);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 20px;
        text-align: left;
        margin-bottom: 30px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
        align-items: center;
    }

    .summary-row span {
        color: var(--ink-lt);
        font-weight: 600;
    }

    .summary-row strong {
        color: var(--ink);
        font-weight: 700;
    }

    .status-badge-pending {
        background: var(--blue-lt);
        color: var(--blue);
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    @media (max-width: 1024px) {
        .booking-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="schedule-hero" aria-label="Schedule hero">
    <div class="wrap">
        <nav class="breadcrumb-nav" aria-label="Breadcrumb">
            <a href="/">Home</a>
            <span>›</span>
            <a href="{{ route('book-appointment') }}">Book Appointment</a>
            @isset($doctor)
                <span>›</span>
                <span>{{ optional($doctor->user)->name }}</span>
            @endisset
        </nav>
        <div>
            <h1>{{ isset($doctor) ? 'Configure Consultation Schedule' : 'Doctor schedules' }}</h1>
            <p>{{ isset($doctor) ? 'Select your preferred date, choose an available time slot, and describe your symptoms to submit your booking.' : 'Select a specialist below to view their calendar details and book an appointment.' }}</p>
        </div>
    </div>
</section>

<section class="sec" aria-label="Schedule contents">
    <div class="wrap">
        @isset($doctor)
            <div class="booking-container">
                <!-- Left: Doctor Profile Summary -->
                <aside class="doctor-details-sidebar">
                    <div class="doctor-avatar-large">
                        {{ strtoupper(substr(optional($doctor->user)->name ?? 'DR', 0, 2)) }}
                    </div>
                    <h2>{{ optional($doctor->user)->name }}</h2>
                    <span class="specialty-badge">{{ $doctor->specialization ?? 'Orthopedic Specialist' }}</span>

                    <div class="doctor-info-list">
                        <div class="info-item">
                            <span>Clinic Address</span>
                            <strong>{{ $doctor->clinic_address ?: 'OrthoCore Center' }}</strong>
                        </div>
                        <div class="info-item">
                            <span>License Number</span>
                            <strong>{{ $doctor->license_number ?: 'MED-9812A' }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Clinical Experience</span>
                            <strong>{{ $doctor->experience ?? '10+ Years' }}</strong>
                        </div>
                    </div>

                    @if($doctor->biography)
                        <div class="doctor-bio-box">
                            <h4>About Specialist</h4>
                            <p>{{ $doctor->biography }}</p>
                        </div>
                    @endif
                </aside>

                <!-- Right: Interactive Scheduler -->
                <main class="scheduler-main">
                    @php
                        $dates = [];
                        $today = \Carbon\Carbon::today();
                        for ($i = 0; $i < 7; $i++) {
                            $date = $today->copy()->addDays($i);
                            $dates[] = [
                                'date_string' => $date->format('Y-m-d'),
                                'day_name' => $date->format('D'),
                                'day_num' => $date->format('d'),
                                'month' => $date->format('M'),
                                'formatted' => $date->isoFormat('dddd, MMMM D, YYYY'),
                            ];
                        }

                        $timeSlots = [
                            '09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM',
                            '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM',
                            '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM'
                        ];
                    @endphp

                    <!-- Step 1: Select Date -->
                    <div class="step-section">
                        <h3 class="step-title">
                            <span class="step-number">1</span>
                            Choose Appointment Date
                        </h3>
                        <div class="date-scroll-container">
                            <div class="date-selector-row" id="dateSelectorRow">
                                @foreach($dates as $index => $d)
                                    <button type="button" 
                                            class="date-pill-btn {{ $index === 0 ? 'active' : '' }}" 
                                            data-date="{{ $d['date_string'] }}" 
                                            data-formatted="{{ $d['formatted'] }}">
                                        <span class="day-lbl">{{ $d['day_name'] }}</span>
                                        <span class="day-num-lbl">{{ $d['day_num'] }}</span>
                                        <span class="month-lbl">{{ $d['month'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Select Time Slot -->
                    <div class="step-section">
                        <h3 class="step-title">
                            <span class="step-number">2</span>
                            Select Available Time Slot
                        </h3>
                        <div class="slots-grid-wrapper">
                            <div class="slots-loader" id="slotsLoader">
                                <div class="spinner-icon"></div>
                                <span>Checking availability...</span>
                            </div>
                            <div class="slots-grid" id="slotsGrid">
                                <!-- Dynamically loaded -->
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Input Symptoms -->
                    <div class="step-section">
                        <h3 class="step-title">
                            <span class="step-number">3</span>
                            Clinical Notes &amp; Symptoms
                        </h3>
                        <textarea class="symptoms-textarea" 
                                  id="symptomsInput" 
                                  placeholder="Describe your symptoms (e.g. joint pain, duration, prior treatments) or medical reasons for this consultation..."></textarea>
                    </div>

                    <!-- Submit / Book CTA -->
                    <div class="booking-actions">
                        @auth
                            <button type="button" class="btn btn-solid" id="submitBookingBtn">
                                Confirm &amp; Request Booking
                            </button>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-solid">
                                Sign In to Book Appointment
                            </a>
                        @endguest
                    </div>
                </main>
            </div>
        @else
            <!-- Roster View if No Doctor Selected -->
            <div class="section-header" style="text-align:center;margin-bottom:40px;">
                <span class="section-badge">Doctor Schedules</span>
                <h2 class="sec-title">Select a Specialist to View Schedule</h2>
                <p class="sec-sub">Click on a specialist below to open their available dates, time slots, and schedule a consultation.</p>
            </div>
            <div class="roster-grid">
                @forelse($doctors as $doc)
                    <div class="roster-card">
                        <div class="roster-avatar">
                            {{ strtoupper(substr(optional($doc->user)->name ?? 'DR', 0, 2)) }}
                        </div>
                        <h3>{{ optional($doc->user)->name }}</h3>
                        <p>{{ $doc->specialization ?? 'Orthopedic Specialist' }}</p>
                        <a href="{{ route('doctor.view.schedule', $doc) }}" class="btn btn-ghost btn-sm">
                            View Calendar &amp; Slots
                        </a>
                    </div>
                @empty
                    <div class="empty-state-card" style="grid-column: 1/-1;">
                        <h3>No doctors found</h3>
                        <p>There are no doctor schedule profiles active at this time.</p>
                    </div>
                @endforelse
            </div>
        @endisset
    </div>
</section>

<!-- Success Modal -->
<div class="booking-modal-overlay" id="successModalOverlay">
    <div class="booking-modal-content">
        <div class="success-icon-box">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h2>Request Received!</h2>
        <p>Your appointment has been successfully requested. Below is a summary of your consultation booking details:</p>
        
        <div class="summary-box">
            <div class="summary-row">
                <span>Specialist:</span>
                <strong id="modalDoctorName">Dr. Name</strong>
            </div>
            <div class="summary-row">
                <span>Date:</span>
                <strong id="modalDate">Date</strong>
            </div>
            <div class="summary-row">
                <span>Time:</span>
                <strong id="modalTime">Time</strong>
            </div>
            <div class="summary-row">
                <span>Status:</span>
                <span class="status-badge-pending">Pending Review</span>
            </div>
        </div>

        <button type="button" class="btn btn-solid" style="width:100%;justify-content:center;" id="modalCloseBtn">
            Return to Doctor List
        </button>
    </div>
</div>
@endsection

@push('scripts')
@isset($doctor)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Date options and time slots config
        const doctorId = @json($doctor->id);
        const doctorName = @json(optional($doctor->user)->name ?? 'Doctor');
        const timeSlots = @json($timeSlots);
        
        let selectedDate = document.querySelector('.date-pill-btn.active').dataset.date;
        let selectedTime = null;

        const dateButtons = document.querySelectorAll('.date-pill-btn');
        const slotsGrid = document.getElementById('slotsGrid');
        const slotsLoader = document.getElementById('slotsLoader');
        const submitBtn = document.getElementById('submitBookingBtn');
        const symptomsInput = document.getElementById('symptomsInput');

        // Modal elements
        const modalOverlay = document.getElementById('successModalOverlay');
        const modalDocName = document.getElementById('modalDoctorName');
        const modalDate = document.getElementById('modalDate');
        const modalTime = document.getElementById('modalTime');
        const modalCloseBtn = document.getElementById('modalCloseBtn');

        // Helper to format slot times for checking booked state
        function formatToCompare(slot) {
            if (slot.startsWith('0')) {
                return slot.substring(1);
            }
            return slot;
        }

        // Fetch Booked Slots & Render Grid
        async function loadAvailability() {
            slotsLoader.style.display = 'flex';
            slotsGrid.innerHTML = '';
            selectedTime = null;
            if (submitBtn) submitBtn.disabled = true;

            try {
                const response = await fetch(`/doctors/${doctorId}/booked-slots?date=${selectedDate}`);
                const data = await response.json();
                const bookedSlots = data.booked_slots || [];

                slotsLoader.style.display = 'none';

                timeSlots.forEach(slot => {
                    const compareTime = formatToCompare(slot);
                    const isBooked = bookedSlots.includes(compareTime);

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `time-slot-btn ${isBooked ? 'slot-booked' : ''}`;
                    btn.textContent = slot;
                    btn.dataset.time = slot;
                    
                    if (isBooked) {
                        btn.disabled = true;
                    } else {
                        btn.addEventListener('click', function () {
                            document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('active'));
                            btn.classList.add('active');
                            selectedTime = slot;
                            if (submitBtn) submitBtn.disabled = false;
                        });
                    }

                    slotsGrid.appendChild(btn);
                });
            } catch (error) {
                console.error("Error loading slots:", error);
                slotsLoader.innerHTML = '<span style="color: var(--coral);">Failed to load schedule. Please try again.</span>';
            }
        }

        // Handle Date Click
        dateButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                dateButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedDate = btn.dataset.date;
                loadAvailability();
            });
        });

        // Initialize availability check
        loadAvailability();

        // Handle Booking Submission
        if (submitBtn) {
            submitBtn.addEventListener('click', async function () {
                if (!selectedDate || !selectedTime) {
                    alert("Please select a date and time slot first.");
                    return;
                }

                // Prepare date/time in the format 'Y-m-d h:i A'
                const formattedTime = `${selectedDate} ${selectedTime}`;
                const symptoms = symptomsInput.value;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting Request...';

                try {
                    const response = await fetch(`/doctors/${doctorId}/bookings`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            appointment_time: formattedTime,
                            symptoms: symptoms
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Set Modal Details
                        modalDocName.textContent = doctorName;
                        
                        const activeDatePill = document.querySelector('.date-pill-btn.active');
                        modalDate.textContent = activeDatePill.dataset.formatted;
                        modalTime.textContent = selectedTime;

                        // Open Modal
                        modalOverlay.classList.add('open');
                    } else {
                        alert(result.message || "An error occurred while booking. Please try again.");
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Confirm & Request Booking';
                    }
                } catch (error) {
                    console.error("Booking submission error:", error);
                    alert("An error occurred. Please try again.");
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Confirm & Request Booking';
                }
            });
        }

        // Modal Close Button
        modalCloseBtn.addEventListener('click', function () {
            window.location.href = "{{ route('book-appointment') }}";
        });
    });
</script>
@endisset
@endpush
