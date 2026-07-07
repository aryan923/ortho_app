@extends('layouts.app')

@section('title', 'Book an Appointment — OrthoCore Clinic')

@push('styles')
<style>
    /* ─── BOOK-APPT: PAGE HERO ─── */
    .page-hero {
        background: linear-gradient(140deg, var(--blue-dk) 0%, var(--blue) 50%, var(--teal) 100%);
        color: #fff; padding: 56px 0 52px;
    }
    .page-hero .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: center; }
    .page-hero-text h1 { font-size: clamp(1.9rem, 3.5vw, 2.9rem); font-weight: 800; letter-spacing: -.025em; line-height: 1.08; margin-bottom: 14px; color: #fff; }
    .page-hero-text p  { color: rgba(255,255,255,.85); font-size: 15.5px; max-width: 480px; margin-bottom: 22px; }
    .hero-trust-row { display: flex; gap: 20px; flex-wrap: wrap; }
    .hero-trust-item { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 600; color: rgba(255,255,255,.9); }
    .htick { width: 18px; height: 18px; border-radius: 999px; background: rgba(255,255,255,.25); display: grid; place-items: center; font-size: 10px; flex-shrink: 0; }

    /* ─── STEPS STRIP ─── */
    .steps-strip { background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 32px 0; }
    .steps-grid  { display: grid; grid-template-columns: repeat(4,1fr); gap: 0; }
    .step { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 16px 20px; position: relative; }
    .step:not(:last-child)::after { content: ''; position: absolute; top: 28px; right: 0; width: 50%; height: 2px; background: var(--border); }
    .step-num { width: 40px; height: 40px; border-radius: 999px; background: linear-gradient(135deg, var(--blue), var(--teal)); color: #fff; font-size: 15px; font-weight: 800; display: grid; place-items: center; margin-bottom: 10px; box-shadow: 0 6px 16px rgba(18,83,200,.25); }
    .step h4 { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
    .step p  { font-size: 12.5px; color: var(--ink-lt); }

    /* ─── BOOKING LAYOUT ─── */
    .booking-wrap { display: grid; grid-template-columns: 1fr 360px; gap: 28px; align-items: flex-start; }

    /* ─── DOCTOR SELECTOR ─── */
    .doctor-selector h3 { font-size: 17px; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .step-badge { width: 24px; height: 24px; border-radius: 999px; background: var(--blue); color: #fff; font-size: 12px; font-weight: 800; display: grid; place-items: center; flex-shrink: 0; }
    .doc-cards-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
    .doc-sel-card {
        border: 2px solid var(--border); border-radius: var(--r-md);
        padding: 14px; cursor: pointer; transition: border-color .18s, box-shadow .18s, transform .18s;
        background: var(--white); text-align: center;
    }
    .doc-sel-card:hover  { border-color: #93bfe8; box-shadow: var(--sh-sm); transform: translateY(-2px); }
    .doc-sel-card.selected { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(18,83,200,.12), var(--sh-sm); }
    .doc-ava { width: 60px; height: 60px; border-radius: 999px; display: grid; place-items: center; font-size: 17px; font-weight: 800; margin: 0 auto 10px; border: 2.5px solid rgba(255,255,255,.7); }
    .da-blue  { background: linear-gradient(145deg,#cfe3fc,#93bfff); color: var(--blue-dk); }
    .da-teal  { background: linear-gradient(145deg,#c9f0ee,#7dd8d3); color: #057972; }
    .da-coral { background: linear-gradient(145deg,#fde8d8,#f9b68c); color: #b84a35; }
    .doc-sel-name { font-size: 13.5px; font-weight: 700; margin-bottom: 3px; }
    .doc-sel-spec { font-size: 11.5px; color: var(--blue); font-weight: 600; margin-bottom: 6px; }
    .doc-avail-badge { font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 999px; display: inline-block; }
    .avail-green { background: var(--green-lt); color: var(--green); }
    .avail-amber { background: #fef3c7; color: #92400e; }

    /* ─── SCHEDULE PANEL ─── */
    .schedule-panel {
        background: var(--bg-soft); border: 1px solid var(--border);
        border-radius: var(--r-lg); padding: 20px; margin-bottom: 28px; margin-top: 20px;
        display: none;
    }
    .schedule-panel.visible { display: block; }
    .schedule-panel h4 { font-size: 15px; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .schedule-table { width: 100%; border-collapse: collapse; }
    .schedule-table th, .schedule-table td { padding: 9px 12px; font-size: 13px; text-align: left; border-bottom: 1px solid var(--border); }
    .schedule-table th { font-weight: 700; color: var(--ink-md); background: rgba(255,255,255,.7); }
    .schedule-table tr:last-child td { border-bottom: none; }
    .slot-tag { font-size: 11.5px; font-weight: 700; padding: 3px 9px; border-radius: 999px; display: inline-block; margin: 2px 2px 2px 0; }
    .slot-am  { background: var(--blue-lt); color: var(--blue-dk); }
    .slot-pm  { background: var(--teal-lt); color: #057972; }
    .slot-off { background: #f1f5f9; color: var(--ink-lt); }

    /* ─── DATE & TIME ─── */
    .date-time-section h3 { font-size: 17px; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .date-time-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .dt-box { border: 1.5px solid var(--border); border-radius: var(--r-md); padding: 16px; background: var(--white); }
    .dt-box label { font-size: 13px; font-weight: 700; color: var(--ink-md); display: block; margin-bottom: 8px; }
    .dt-box input[type="date"], .dt-box select {
        font-family: inherit; font-size: 14px; font-weight: 500;
        border: 1.5px solid var(--border); border-radius: 9px;
        padding: 10px 12px; width: 100%; color: var(--ink); background: var(--bg-soft);
    }
    .dt-box input[type="date"]:focus, .dt-box select:focus { outline: 2px solid var(--blue); border-color: transparent; }
    .time-slots-box { border: 1.5px solid var(--border); border-radius: var(--r-md); padding: 16px; background: var(--white); margin-top: 14px; }
    .time-slots-box label { font-size: 13px; font-weight: 700; color: var(--ink-md); display: block; margin-bottom: 10px; }
    .slots-grid { display: flex; flex-wrap: wrap; gap: 8px; }
    .time-slot-btn { font-family: inherit; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 9px; border: 1.5px solid var(--border); background: var(--white); cursor: pointer; color: var(--ink-md); transition: all .15s; }
    .time-slot-btn:hover  { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
    .time-slot-btn.active { border-color: var(--blue); background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(18,83,200,.25); }
    .time-slot-btn.booked { border-color: #e2e8f0; background: #f8fafc; color: #cbd5e1; cursor: not-allowed; text-decoration: line-through; }
    .slots-hint { font-size: 12px; color: var(--ink-lt); margin-top: 10px; display: flex; gap: 14px; flex-wrap: wrap; }
    .hint-dot { display: inline-block; width: 10px; height: 10px; border-radius: 3px; margin-right: 4px; vertical-align: middle; }

    /* ─── PATIENT FORM ─── */
    .patient-form-section h3 { font-size: 17px; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group.full { grid-column: 1/-1; }
    .form-group label { font-size: 13px; font-weight: 700; color: var(--ink-md); }
    .form-group input, .form-group select, .form-group textarea {
        font-family: inherit; font-size: 14px;
        border: 1.5px solid var(--border); border-radius: 9px;
        padding: 11px 13px; width: 100%; color: var(--ink); background: var(--bg-soft); transition: border-color .15s;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--blue); background: var(--white); }
    .form-group textarea { resize: vertical; min-height: 80px; }
    .submit-row { margin-top: 18px; }
    .submit-btn {
        font-family: inherit; font-size: 15px; font-weight: 800; border: none; border-radius: 999px; cursor: pointer;
        padding: 14px 32px; width: 100%;
        background: linear-gradient(135deg, var(--coral) 0%, var(--amber) 100%);
        color: #fff; box-shadow: 0 10px 26px rgba(233,93,68,.3); transition: filter .18s, transform .18s;
    }
    .submit-btn:hover { filter: brightness(1.07); transform: translateY(-2px); }
    .form-note { font-size: 12px; color: var(--ink-lt); text-align: center; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 5px; }

    /* ─── SIDEBAR ─── */
    .sidebar { display: flex; flex-direction: column; gap: 16px; }
    .sidebar-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--r-md); padding: 18px; }
    .sidebar-card h4 { font-size: 14px; font-weight: 800; margin-bottom: 12px; color: var(--ink); }
    .info-row { display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px; }
    .info-row:last-child { margin-bottom: 0; }
    .info-ico { width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0; display: grid; place-items: center; font-size: 14px; }
    .ico-b { background: var(--blue-lt); }
    .ico-t { background: var(--teal-lt); }
    .ico-c { background: #fff1ee; }
    .info-row p      { font-size: 13px; color: var(--ink-md); line-height: 1.55; }
    .info-row strong { color: var(--ink); font-weight: 700; display: block; font-size: 13px; }
    .booking-summary { background: linear-gradient(135deg, var(--blue-dk), var(--blue)); color: #fff; border-radius: var(--r-md); padding: 18px; }
    .booking-summary h4 { font-size: 14px; font-weight: 800; color: #fff; margin-bottom: 14px; }
    .sum-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; margin-bottom: 8px; }
    .sum-label { color: rgba(255,255,255,.7); }
    .sum-value { font-weight: 700; color: #fff; text-align: right; }
    .sum-value.empty { color: rgba(255,255,255,.4); font-style: italic; font-weight: 500; }
    .sum-divider { border: none; border-top: 1px solid rgba(255,255,255,.18); margin: 10px 0; }

    /* ─── FAQ ─── */
    .faq-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 24px; }
    .faq-item { background: var(--bg-soft); border: 1px solid var(--border); border-radius: var(--r-md); padding: 16px; }
    .faq-item h4 { font-size: 14px; font-weight: 700; margin-bottom: 6px; color: var(--ink); }
    .faq-item p  { font-size: 13.5px; color: var(--ink-lt); line-height: 1.6; }

    /* ─── SUCCESS STATE ─── */
    .success-overlay { display: none; text-align: center; padding: 40px 24px; border: 2px solid var(--green); border-radius: var(--r-lg); background: var(--green-lt); margin-bottom: 24px; }
    .success-overlay.show { display: block; }
    .success-icon { width: 64px; height: 64px; border-radius: 999px; background: var(--green); color: #fff; font-size: 28px; display: grid; place-items: center; margin: 0 auto 16px; }
    .success-overlay h3 { font-size: 20px; font-weight: 800; color: var(--green); margin-bottom: 8px; }
    .success-overlay p  { font-size: 15px; color: #166534; max-width: 400px; margin: 0 auto 20px; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1024px) {
        .booking-wrap { grid-template-columns: 1fr; }
        .sidebar { flex-direction: row; flex-wrap: wrap; }
        .sidebar-card, .booking-summary { flex: 1 1 280px; }
        .page-hero .wrap { grid-template-columns: 1fr; }
        .page-hero-img { display: none; }
        .doc-cards-grid { grid-template-columns: repeat(2,1fr); }
        .steps-grid { grid-template-columns: repeat(2,1fr); }
        .faq-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .doc-cards-grid, .date-time-grid, .form-grid { grid-template-columns: 1fr; }
        .steps-grid { grid-template-columns: 1fr 1fr; }
        .form-group.full { grid-column: 1; }
    }
</style>
@endpush

@section('content')

{{-- ════ PAGE HERO ════ --}}
<section class="page-hero" aria-label="Book appointment hero">
    <div class="wrap">
        <div class="page-hero-text">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="/">Home</a>
                <span>›</span>
                <span>{{ config('page.book_appointment.hero_label', 'Book Appointment') }}</span>
            </nav>
            <span class="tag white">{{ config('page.book_appointment.hero_label', 'Book Appointment') }}</span>
            <h1>{{ config('page.book_appointment.hero_title', 'Book Your Appointment in Minutes') }}</h1>
            <p>{{ config('page.book_appointment.hero_subtitle', 'Choose your specialist, pick a date that works for you, and select an available time slot. We\'ll confirm within 2 hours.') }}</p>
            <div class="hero-trust-row">
                <div class="hero-trust-item"><span class="htick">✓</span> No hidden fees</div>
                <div class="hero-trust-item"><span class="htick">✓</span> Same-day slots available</div>
                <div class="hero-trust-item"><span class="htick">✓</span> Confirmed in 2 hrs</div>
            </div>
        </div>
        <div class="page-hero-img">
            <img
                src="{{ config('page.book_appointment.hero_image', 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?auto=format&fit=crop&w=800&q=85') }}"
                alt="{{ config('page.book_appointment.hero_title', 'Book Your Appointment in Minutes') }}"
                loading="eager"
                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=85';">
        </div>
    </div>
</section>

{{-- ════ HOW IT WORKS ════ --}}
<div class="steps-strip" aria-label="How to book">
    <div class="wrap">
        <div class="steps-grid">
            <div class="step"><div class="step-num">1</div><h4>Choose a Doctor</h4><p>Select your preferred specialist from our team of 12 experts.</p></div>
            <div class="step"><div class="step-num">2</div><h4>Pick a Date</h4><p>View real-time availability and choose a convenient date.</p></div>
            <div class="step"><div class="step-num">3</div><h4>Select a Time Slot</h4><p>Browse open slots and pick the time that works best.</p></div>
            <div class="step"><div class="step-num">4</div><h4>Confirm &amp; Done</h4><p>Submit your details and we'll send a confirmation shortly.</p></div>
        </div>
    </div>
</div>

{{-- ════ BOOKING FORM ════ --}}
<section class="sec" aria-label="Appointment booking form">
    <div class="wrap">
        <div class="booking-wrap">

            {{-- LEFT: Main Form --}}
            <div class="booking-main">

                <div class="success-overlay" id="successOverlay" role="alert">
                    <div class="success-icon">✓</div>
                    <h3>Appointment Requested!</h3>
                    <p id="successMessage">Our care coordinator will call you within 2 hours to confirm your appointment details.</p>
                    <a href="/" class="btn btn-solid">Back to Home</a>
                </div>

                {{-- Step 1: Doctor --}}
                <div class="doctor-selector" id="doctorStep">
                    <h3><span class="step-badge">1</span> Select Your Doctor</h3>
                    <div class="doc-cards-grid">
                        <div class="doc-sel-card" data-doctor="mitchell" onclick="selectDoctor(this)" tabindex="0" role="button" aria-pressed="false">
                            <div class="doc-ava da-blue">JM</div>
                            <div class="doc-sel-name">Dr. James Mitchell</div>
                            <div class="doc-sel-spec">Joint Replacement &amp; Sports Medicine</div>
                            <span class="doc-avail-badge avail-green">Available Today</span>
                        </div>
                        <div class="doc-sel-card" data-doctor="okafor" onclick="selectDoctor(this)" tabindex="0" role="button" aria-pressed="false">
                            <div class="doc-ava da-teal">AO</div>
                            <div class="doc-sel-name">Dr. Amara Okafor</div>
                            <div class="doc-sel-spec">Sports Medicine &amp; Arthroscopy</div>
                            <span class="doc-avail-badge avail-green">Available Today</span>
                        </div>
                        <div class="doc-sel-card" data-doctor="sharma" onclick="selectDoctor(this)" tabindex="0" role="button" aria-pressed="false">
                            <div class="doc-ava da-coral">PS</div>
                            <div class="doc-sel-name">Dr. Priya Sharma</div>
                            <div class="doc-sel-spec">Spine Surgery &amp; Pain Management</div>
                            <span class="doc-avail-badge avail-amber">Next slot: Tomorrow</span>
                        </div>
                    </div>
                </div>

                {{-- Schedule Panel --}}
                <div class="schedule-panel" id="schedulePanel">
                    <h4 id="schedulePanelTitle">Weekly Schedule</h4>
                    <table class="schedule-table" aria-label="Doctor weekly schedule">
                        <thead><tr><th>Day</th><th>Morning</th><th>Afternoon</th><th>Status</th></tr></thead>
                        <tbody id="scheduleBody"></tbody>
                    </table>
                </div>

                {{-- Step 2: Date & Time --}}
                <div class="date-time-section" id="dateTimeStep">
                    <h3><span class="step-badge">2</span> Choose Date &amp; Time</h3>
                    <div class="date-time-grid">
                        <div class="dt-box">
                            <label for="apptDate">Appointment Date</label>
                            <input type="date" id="apptDate" name="apptDate" onchange="loadTimeSlots()" aria-label="Select appointment date">
                        </div>
                        <div class="dt-box">
                            <label for="apptType">Appointment Type</label>
                            <select id="apptType" name="apptType">
                                <option value="" disabled selected>Select type…</option>
                                <option value="initial">Initial Consultation</option>
                                <option value="followup">Follow-Up Visit</option>
                                <option value="procedure">Procedure / Treatment</option>
                                <option value="physio">Physiotherapy Session</option>
                                <option value="imaging">Imaging Review</option>
                            </select>
                        </div>
                    </div>
                    <div class="time-slots-box" id="timeSlotsBox">
                        <label>Available Time Slots <span id="slotsDateLabel" style="font-weight:500;color:var(--ink-lt);"></span></label>
                        <div class="slots-grid" id="slotsGrid">
                            <p style="font-size:13px;color:var(--ink-lt);font-style:italic;">Please select a doctor and a date to see available slots.</p>
                        </div>
                        <div class="slots-hint">
                            <span><span class="hint-dot" style="background:var(--blue);"></span> Available</span>
                            <span><span class="hint-dot" style="background:#e2e8f0;border:1px solid #cbd5e1;"></span> Booked</span>
                        </div>
                    </div>
                </div>

                {{-- Step 3: Patient Details --}}
                <div class="patient-form-section" id="patientStep">
                    <h3><span class="step-badge">3</span> Your Details</h3>
                    <form id="bookingForm" onsubmit="submitBooking(event)" novalidate>
                        <div class="form-grid">
                            <div class="form-group"><label for="firstName">First Name *</label><input type="text" id="firstName" name="firstName" placeholder="e.g. Robert" required></div>
                            <div class="form-group"><label for="lastName">Last Name *</label><input type="text" id="lastName" name="lastName" placeholder="e.g. Kane" required></div>
                            <div class="form-group"><label for="phone">Phone Number *</label><input type="tel" id="phone" name="phone" placeholder="+1 (212) 000-0000" required></div>
                            <div class="form-group"><label for="email">Email Address</label><input type="email" id="email" name="email" placeholder="you@example.com"></div>
                            <div class="form-group"><label for="dob">Date of Birth</label><input type="date" id="dob" name="dob"></div>
                            <div class="form-group"><label for="gender">Gender</label>
                                <select id="gender" name="gender"><option value="" disabled selected>Select…</option><option>Male</option><option>Female</option><option>Non-binary</option><option>Prefer not to say</option></select>
                            </div>
                            <div class="form-group"><label for="insurance">Insurance Provider</label>
                                <select id="insurance" name="insurance"><option value="" disabled selected>Select provider…</option><option>Aetna</option><option>BlueCross BlueShield</option><option>Cigna</option><option>Humana</option><option>Medicare</option><option>UnitedHealth</option><option>Self-pay / No insurance</option><option>Other</option></select>
                            </div>
                            <div class="form-group"><label for="referral">Referred By</label>
                                <select id="referral" name="referral"><option value="" disabled selected>How did you hear about us?</option><option>Primary Care Physician</option><option>Family / Friend</option><option>Google Search</option><option>Social Media</option><option>Hospital Referral</option><option>Other</option></select>
                            </div>
                            <div class="form-group full"><label for="symptoms">Describe Your Symptoms / Reason for Visit</label><textarea id="symptoms" name="symptoms" placeholder="e.g. Sharp knee pain for 3 weeks after jogging, worse when climbing stairs…"></textarea></div>
                        </div>
                        <div class="submit-row">
                            <button type="submit" class="submit-btn">Confirm Appointment Request →</button>
                            <p class="form-note">🔒 Your information is encrypted and never shared with third parties.</p>
                        </div>
                    </form>
                </div>

            </div>{{-- /booking-main --}}

            {{-- RIGHT: Sidebar --}}
            <aside class="sidebar" aria-label="Booking details sidebar">
                <div class="booking-summary" id="bookingSummary" aria-live="polite">
                    <h4>Your Booking Summary</h4>
                    <div class="sum-row"><span class="sum-label">Doctor</span><span class="sum-value empty" id="sumDoctor">Not selected</span></div>
                    <div class="sum-row"><span class="sum-label">Speciality</span><span class="sum-value empty" id="sumSpec">—</span></div>
                    <hr class="sum-divider">
                    <div class="sum-row"><span class="sum-label">Date</span><span class="sum-value empty" id="sumDate">Not selected</span></div>
                    <div class="sum-row"><span class="sum-label">Time</span><span class="sum-value empty" id="sumTime">Not selected</span></div>
                    <div class="sum-row"><span class="sum-label">Type</span><span class="sum-value empty" id="sumType">Not selected</span></div>
                    <hr class="sum-divider">
                    <div class="sum-row"><span class="sum-label">Consultation Fee</span><span class="sum-value" id="sumFee">$150</span></div>
                    <p style="font-size:11px;color:rgba(255,255,255,.55);margin-top:8px;">Fee may vary by insurance. Our coordinator will confirm before billing.</p>
                </div>
                <div class="sidebar-card">
                    <h4>Need Help Booking?</h4>
                    <div class="info-row">
                        <div class="info-ico ico-b">📞</div>
                        <div><strong>Call Us Directly</strong><p><a href="tel:+12125550192" style="color:var(--blue);font-weight:600;">+1 (212) 555-0192</a><br>Mon–Sat: 8 AM – 7 PM</p></div>
                    </div>
                    <div class="info-row">
                        <div class="info-ico ico-t">📧</div>
                        <div><strong>Email Us</strong><p>appointments@orthocore.com</p></div>
                    </div>
                    <div class="info-row">
                        <div class="info-ico ico-c">📍</div>
                        <div><strong>Visit Us</strong><p>24 Harley Medical Plaza, Suite 300<br>New York, NY 10016</p></div>
                    </div>
                </div>
                <div class="sidebar-card">
                    <h4>What to Bring</h4>
                    <ul style="font-size:13px;color:var(--ink-md);line-height:2;list-style:disc;padding-left:16px;">
                        <li>Government-issued photo ID</li>
                        <li>Insurance card (front &amp; back)</li>
                        <li>Referral letter (if applicable)</li>
                        <li>List of current medications</li>
                        <li>Prior X-rays / MRI scans</li>
                        <li>Medical history summary</li>
                    </ul>
                </div>
                <div class="sidebar-card">
                    <h4>Clinic Hours</h4>
                    <table style="width:100%;font-size:13px;color:var(--ink-md);">
                        <tbody>
                            @foreach(array_filter(array_map('trim', explode("\n", config('site.clinic_hours')))) as $line)
                                @php
                                    $parts = explode(':', $line, 2);
                                @endphp
                                <tr>
                                    <td style="padding:4px 0;">{{ trim($parts[0] ?? $line) }}</td>
                                    <td style="font-weight:700;color:var(--ink);text-align:right;">{{ trim($parts[1] ?? '') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="margin-top:12px;padding:10px;background:var(--blue-lt);border-radius:9px;font-size:12.5px;color:var(--blue-dk);font-weight:600;">
                        Emergency line available 24/7 — call <a href="tel:+12125550192" style="color:var(--blue-dk);text-decoration:underline;">+1 (212) 555-0192</a>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>

{{-- ════ FAQ ════ --}}
<section class="sec" style="background:var(--bg-soft);border-top:1px solid var(--border);" aria-label="FAQs">
    <div class="wrap">
        <span class="tag teal">FAQs</span>
        <h2 class="sec-title">Common Questions About Booking</h2>
        <div class="faq-grid">
            <div class="faq-item"><h4>How long does an initial consultation take?</h4><p>Initial consultations are typically 30–45 minutes. Follow-up visits are usually 15–20 minutes depending on the complexity of your case.</p></div>
            <div class="faq-item"><h4>Can I book for someone else?</h4><p>Yes. Fill in the patient's details in the form. If booking for a minor, a parent or legal guardian must accompany them at the appointment.</p></div>
            <div class="faq-item"><h4>What if I need to cancel or reschedule?</h4><p>Call us at least 24 hours before your appointment. Cancellations within 24 hours may incur a $25 rescheduling fee unless medically urgent.</p></div>
            <div class="faq-item"><h4>Do you accept walk-ins?</h4><p>We do accept same-day walk-ins, subject to availability. Booking online guarantees your slot and minimises waiting time.</p></div>
            <div class="faq-item"><h4>Is parking available at the clinic?</h4><p>Yes — free validated parking is available in our building garage for all patients. Enter via Harley Street entrance and collect a validation ticket at reception.</p></div>
            <div class="faq-item"><h4>Are telehealth appointments available?</h4><p>Telehealth consultations are available for follow-ups and imaging reviews. Select "Follow-Up Visit" when booking and note your preference in the symptoms field.</p></div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const DOCTORS = {
    mitchell: {
        name: 'Dr. James Mitchell, MD', spec: 'Joint Replacement & Sports Medicine', fee: '$150',
        schedule: [
            { day: 'Monday',    morning: '9:00 AM – 12:30 PM', afternoon: '1:30 PM – 5:00 PM', status: 'open' },
            { day: 'Tuesday',   morning: '9:00 AM – 12:30 PM', afternoon: '1:30 PM – 5:00 PM', status: 'open' },
            { day: 'Wednesday', morning: '9:00 AM – 12:30 PM', afternoon: '1:30 PM – 5:00 PM', status: 'open' },
            { day: 'Thursday',  morning: '9:00 AM – 12:00 PM', afternoon: '—',                 status: 'limited' },
            { day: 'Friday',    morning: '9:00 AM – 12:30 PM', afternoon: '1:30 PM – 5:00 PM', status: 'open' },
            { day: 'Saturday',  morning: 'By appointment',     afternoon: '—',                 status: 'limited' },
            { day: 'Sunday',    morning: '—',                  afternoon: '—',                 status: 'closed' },
        ],
        slots: { morning: ['9:00 AM','9:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM'], afternoon: ['1:30 PM','2:00 PM','2:30 PM','3:00 PM','3:30 PM','4:00 PM','4:30 PM'] },
        bookedSlots: ['10:00 AM','2:30 PM','4:00 PM'],
    },
    okafor: {
        name: 'Dr. Amara Okafor, MD', spec: 'Sports Medicine & Arthroscopy', fee: '$175',
        schedule: [
            { day: 'Monday',    morning: '10:00 AM – 1:00 PM', afternoon: '2:00 PM – 6:00 PM', status: 'open' },
            { day: 'Tuesday',   morning: '9:00 AM – 12:00 PM', afternoon: '1:00 PM – 3:00 PM', status: 'open' },
            { day: 'Wednesday', morning: '10:00 AM – 1:00 PM', afternoon: '2:00 PM – 6:00 PM', status: 'open' },
            { day: 'Thursday',  morning: '9:00 AM – 12:00 PM', afternoon: '1:00 PM – 3:00 PM', status: 'open' },
            { day: 'Friday',    morning: '10:00 AM – 1:00 PM', afternoon: '2:00 PM – 6:00 PM', status: 'open' },
            { day: 'Saturday',  morning: '9:00 AM – 1:00 PM',  afternoon: '—',                 status: 'limited' },
            { day: 'Sunday',    morning: '—',                   afternoon: '—',                 status: 'closed' },
        ],
        slots: { morning: ['10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM'], afternoon: ['2:00 PM','2:30 PM','3:00 PM','3:30 PM','4:00 PM','4:30 PM','5:00 PM','5:30 PM'] },
        bookedSlots: ['10:30 AM','3:00 PM','5:00 PM'],
    },
    sharma: {
        name: 'Dr. Priya Sharma, MD', spec: 'Spine Surgery & Pain Management', fee: '$200',
        schedule: [
            { day: 'Monday',    morning: '9:00 AM – 1:00 PM',  afternoon: '—',                 status: 'limited' },
            { day: 'Tuesday',   morning: '9:00 AM – 12:30 PM', afternoon: '1:30 PM – 5:00 PM', status: 'open' },
            { day: 'Wednesday', morning: '10:00 AM – 1:00 PM', afternoon: '2:00 PM – 4:00 PM', status: 'open' },
            { day: 'Thursday',  morning: '9:00 AM – 12:30 PM', afternoon: '1:30 PM – 5:00 PM', status: 'open' },
            { day: 'Friday',    morning: '10:00 AM – 1:00 PM', afternoon: '2:00 PM – 4:00 PM', status: 'open' },
            { day: 'Saturday',  morning: '—',                  afternoon: '—',                 status: 'closed' },
            { day: 'Sunday',    morning: '—',                  afternoon: '—',                 status: 'closed' },
        ],
        slots: { morning: ['9:00 AM','9:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM'], afternoon: ['1:30 PM','2:00 PM','2:30 PM','3:00 PM','3:30 PM'] },
        bookedSlots: ['9:30 AM','2:00 PM'],
    },
};

let selectedDoctor = null;
let selectedTime   = null;

function selectDoctor(card) {
    document.querySelectorAll('.doc-sel-card').forEach(c => { c.classList.remove('selected'); c.setAttribute('aria-pressed', 'false'); });
    card.classList.add('selected');
    card.setAttribute('aria-pressed', 'true');
    selectedDoctor = card.dataset.doctor;
    const doc = DOCTORS[selectedDoctor];
    updateSummary();
    const tbody = document.getElementById('scheduleBody');
    tbody.innerHTML = '';
    doc.schedule.forEach(row => {
        const statusMap = { open: '<span class="slot-tag slot-am">Open</span>', limited: '<span class="slot-tag slot-pm">Limited</span>', closed: '<span class="slot-tag slot-off">Closed</span>' };
        tbody.insertAdjacentHTML('beforeend', `<tr>
            <td style="font-weight:600;">${row.day}</td>
            <td>${row.morning !== '—' ? '<span class="slot-tag slot-am">' + row.morning + '</span>' : '<span style="color:var(--ink-lt)">—</span>'}</td>
            <td>${row.afternoon !== '—' ? '<span class="slot-tag slot-pm">' + row.afternoon + '</span>' : '<span style="color:var(--ink-lt)">—</span>'}</td>
            <td>${statusMap[row.status]}</td>
        </tr>`);
    });
    document.getElementById('schedulePanelTitle').textContent = doc.name + ' — Weekly Schedule';
    document.getElementById('schedulePanel').classList.add('visible');
    document.getElementById('sumFee').textContent = doc.fee;
    loadTimeSlots();
}

function loadTimeSlots() {
    const dateVal = document.getElementById('apptDate').value;
    const grid    = document.getElementById('slotsGrid');
    const label   = document.getElementById('slotsDateLabel');
    if (dateVal) {
        const d = new Date(dateVal + 'T00:00:00');
        const formatted = d.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
        label.textContent = '— ' + formatted;
        document.getElementById('sumDate').textContent = formatted;
        document.getElementById('sumDate').classList.remove('empty');
    }
    const typeEl = document.getElementById('apptType');
    if (typeEl.value) {
        document.getElementById('sumType').textContent = typeEl.options[typeEl.selectedIndex].text;
        document.getElementById('sumType').classList.remove('empty');
    }
    if (!selectedDoctor || !dateVal) {
        grid.innerHTML = '<p style="font-size:13px;color:var(--ink-lt);font-style:italic;">Please select a doctor and a date to see available slots.</p>';
        return;
    }
    const doc      = DOCTORS[selectedDoctor];
    const dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const dayName  = dayNames[new Date(dateVal + 'T00:00:00').getDay()];
    const dayInfo  = doc.schedule.find(s => s.day === dayName);
    if (!dayInfo || dayInfo.status === 'closed') {
        grid.innerHTML = '<p style="font-size:13px;color:var(--coral);font-weight:600;">Not available on ' + dayName + 's. Please choose another date.</p>';
        return;
    }
    if (dayInfo.morning === 'By appointment') {
        grid.innerHTML = '<p style="font-size:13px;color:var(--ink-md);font-weight:600;">Saturdays are by appointment only. Please call <a href="tel:+12125550192" style="color:var(--blue);">+1 (212) 555-0192</a> to book.</p>';
        return;
    }
    let allSlots = [];
    if (dayInfo.morning !== '—') allSlots = allSlots.concat(doc.slots.morning);
    if (dayInfo.afternoon !== '—') allSlots = allSlots.concat(doc.slots.afternoon);
    grid.innerHTML = '';
    selectedTime = null;
    document.getElementById('sumTime').textContent = 'Not selected';
    document.getElementById('sumTime').classList.add('empty');
    allSlots.forEach(slot => {
        const isBooked = doc.bookedSlots.includes(slot);
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'time-slot-btn' + (isBooked ? ' booked' : '');
        btn.textContent = slot;
        btn.disabled = isBooked;
        btn.setAttribute('aria-label', slot + (isBooked ? ' — booked' : ' — available'));
        if (!isBooked) btn.onclick = () => selectTimeSlot(btn, slot);
        grid.appendChild(btn);
    });
}

function selectTimeSlot(btn, time) {
    document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedTime = time;
    const el = document.getElementById('sumTime');
    el.textContent = time;
    el.classList.remove('empty');
}

function updateSummary() {
    if (!selectedDoctor) return;
    const doc = DOCTORS[selectedDoctor];
    ['sumDoctor','sumSpec'].forEach((id, i) => {
        const el = document.getElementById(id);
        el.textContent = i === 0 ? doc.name : doc.spec;
        el.classList.remove('empty');
    });
}

function submitBooking(e) {
    e.preventDefault();
    const form = e.target;
    if (!selectedDoctor) { alert('Please select a doctor.'); return; }
    if (!document.getElementById('apptDate').value) { alert('Please select a date.'); return; }
    if (!selectedTime) { alert('Please select a time slot.'); return; }
    if (!form.firstName.value.trim()) { alert('Please enter your first name.'); return; }
    if (!form.lastName.value.trim())  { alert('Please enter your last name.'); return; }
    if (!form.phone.value.trim())     { alert('Please enter your phone number.'); return; }
    const doc = DOCTORS[selectedDoctor];
    const d = new Date(document.getElementById('apptDate').value + 'T00:00:00');
    const formattedDate = d.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
    document.getElementById('successMessage').textContent =
        'Your appointment with ' + doc.name + ' on ' + formattedDate + ' at ' + selectedTime +
        ' has been requested. Our care coordinator will call ' + form.phone.value + ' within 2 hours to confirm.';
    document.getElementById('bookingForm').style.display = 'none';
    document.getElementById('successOverlay').classList.add('show');
    document.getElementById('successOverlay').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

document.querySelectorAll('.doc-sel-card').forEach(card => {
    card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); selectDoctor(card); } });
});

document.getElementById('apptType').addEventListener('change', function() {
    const el = document.getElementById('sumType');
    el.textContent = this.options[this.selectedIndex].text;
    el.classList.remove('empty');
});

(function() {
    const today = new Date();
    const pad = n => String(n).padStart(2,'0');
    const min = today.getFullYear() + '-' + pad(today.getMonth()+1) + '-' + pad(today.getDate());
    const future = new Date(today); future.setMonth(future.getMonth()+3);
    const max = future.getFullYear() + '-' + pad(future.getMonth()+1) + '-' + pad(future.getDate());
    const el = document.getElementById('apptDate');
    el.min = min; el.max = max;
})();
</script>
@endpush
