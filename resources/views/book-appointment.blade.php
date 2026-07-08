@extends('layouts.app')

@section('title', 'Book an Appointment — OrthoCore Clinic')

@push('styles')
<style>
    .book-hero {
        padding: 72px 0 46px;
        background: linear-gradient(135deg, rgba(18,83,200,0.92), rgba(31,141,116,0.78));
        color: #fff;
    }

    .book-hero .wrap {
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        gap: 32px;
        align-items: center;
    }

    .book-hero h1 {
        font-size: clamp(2.8rem, 3.4vw, 4rem);
        line-height: 1.02;
        margin-bottom: 22px;
    }

    .book-hero p {
        max-width: 580px;
        font-size: 1.05rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 28px;
        line-height: 1.7;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .hero-banner {
        padding: 26px;
        border-radius: 28px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 26px 60px rgba(8,24,56,0.16);
    }

    .hero-banner h3 {
        margin: 0 0 12px;
        font-size: 1rem;
        font-weight: 700;
    }

    .hero-banner p {
        margin: 0;
        color: rgba(255,255,255,0.8);
        line-height: 1.8;
    }

    .section-label {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        background: rgba(31, 141, 116, 0.12);
        border-radius: 999px;
        color: var(--emerald);
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .doctor-list {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
        margin-top: 28px;
    }

    .doctor-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-soft);
        display: grid;
        grid-template-rows: auto 1fr auto;
        transition: transform var(--transition), box-shadow var(--transition);
    }

    .doctor-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 28px 60px rgba(15,31,58,0.12);
    }

    .doctor-card-header {
        padding: 26px;
        display: grid;
        gap: 16px;
        background: linear-gradient(180deg, rgba(18,83,200,0.08), rgba(255,255,255,0.92));
        border-bottom: 1px solid var(--border);
    }

    .doctor-card-core {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .doctor-avatar {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, var(--blue), var(--emerald));
        color: #fff;
        font-size: 1.1rem;
        font-weight: 800;
    }

    .doctor-card-header h3 {
        margin: 0;
        font-size: 1.1rem;
    }

    .doctor-card-header p {
        margin: 0;
        color: var(--ink-muted);
        line-height: 1.6;
    }

    .doctor-card-body {
        padding: 24px;
        display: grid;
        gap: 16px;
    }

    .doctor-card-body ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 12px;
    }

    .doctor-card-body li {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 18px;
        background: var(--surface-soft);
        color: var(--ink-muted);
    }

    .doctor-card-body strong {
        color: var(--ink);
        font-weight: 700;
    }

    .doctor-card-footer {
        padding: 0 24px 24px;
    }

    .doctor-card-footer .btn-secondary {
        width: 100%;
        justify-content: center;
        color: var(--blue);
        background: rgba(18,83,200,0.08);
        border-color: rgba(18,83,200,0.18);
    }

    .doctor-callouts {
        margin-top: 40px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .callout-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 24px;
        box-shadow: var(--shadow-soft);
    }

    .callout-card h3 {
        margin: 0 0 10px;
        font-size: 1rem;
        color: var(--ink);
    }

    .callout-card p {
        margin: 0;
        color: var(--ink-muted);
        line-height: 1.7;
    }

    @media (max-width: 1024px) {
        .book-hero .wrap,
        .doctor-list,
        .doctor-callouts {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<section class="book-hero" aria-label="Book appointment hero">
    <div class="wrap">
        <div>
            <span class="section-label">Premium Scheduling</span>
            <h1>{{ config('page.book_appointment.hero_title', 'Book Your Surgical Consultation in Minutes') }}</h1>
            <p>{{ config('page.book_appointment.hero_subtitle', 'Choose a specialist, review availability, and request a clinically curated appointment with our surgical care team.') }}</p>
            <div class="hero-actions">
                <a href="{{ route('doctor.schedule') }}" class="btn btn-solid">Browse Doctor Schedules</a>
                <a href="/contact" class="btn btn-secondary">Contact Care Support</a>
            </div>
        </div>
        <div class="hero-banner">
            <h3>Advanced care coordination</h3>
            <p>Every appointment request is screened by our clinical operations team for surgical clarity and optimal scheduling.</p>
        </div>
    </div>
</section>

<section class="sec" aria-label="Doctor selection">
    <div class="wrap">
        <div class="section-label">Step 1</div>
        <div class="doctor-list">
            @forelse($doctors as $doctor)
                <article class="doctor-card">
                    <div class="doctor-card-header">
                        <div class="doctor-card-core">
                            <div class="doctor-avatar">{{ strtoupper(substr(optional($doctor->user)->name ?? 'Dr',0,2)) }}</div>
                            <div>
                                <h3>{{ optional($doctor->user)->name ?? 'Doctor' }}</h3>
                                <p>{{ $doctor->specialization ?? 'Orthopedic Specialist' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="doctor-card-body">
                        <ul>
                            <li><span>Clinic</span><strong>{{ $doctor->clinic_address ?: 'Not available' }}</strong></li>
                            <li><span>License</span><strong>{{ $doctor->license_number ?: 'Pending' }}</strong></li>
                            <li><span>Experience</span><strong>{{ $doctor->experience ?? '10+ years' }}</strong></li>
                        </ul>
                    </div>
                    <div class="doctor-card-footer">
                        <a href="{{ route('doctor.view.schedule', $doctor) }}" class="btn btn-secondary">View Schedule</a>
                    </div>
                </article>
            @empty
                <article class="doctor-card" style="text-align:center;padding:40px;">
                    <h3>No doctors available</h3>
                    <p>Please check back later or contact our clinic support team for immediate assistance.</p>
                </article>
            @endforelse
        </div>

        <div class="doctor-callouts">
            <div class="callout-card">
                <h3>Clinical clarity</h3>
                <p>Our interface is built for surgical teams with crisp doctor profiles and transparent scheduling workflows.</p>
            </div>
            <div class="callout-card">
                <h3>Smooth booking</h3>
                <p>Request a consultation with confidence — the care team reviews every submission before confirmation.</p>
            </div>
            <div class="callout-card">
                <h3>Priority support</h3>
                <p>Need a second opinion? Contact our clinical concierge for faster specialist matching and follow-up coordination.</p>
            </div>
        </div>
    </div>
</section>
@endsection
