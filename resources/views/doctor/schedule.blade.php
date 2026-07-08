@extends('layouts.app')

@section('title', 'Doctor Schedule — OrthoCore Clinic')

@push('styles')
<style>
    .schedule-hero {
        padding: 68px 0 42px;
    }

    .schedule-hero .wrap {
        display: grid;
        gap: 20px;
    }

    .schedule-hero h1 {
        margin: 0;
        font-size: clamp(2.6rem, 3vw, 3.3rem);
    }

    .schedule-hero p {
        color: var(--ink-muted);
        line-height: 1.8;
        max-width: 720px;
    }

    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        margin-top: 28px;
    }

    .schedule-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-soft);
        display: grid;
        grid-template-rows: auto 1fr auto;
        transition: transform var(--transition), box-shadow var(--transition);
    }

    .schedule-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 28px 60px rgba(15,31,58,0.1);
    }

    .schedule-head {
        padding: 24px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(180deg, rgba(18,83,200,0.08), rgba(255,255,255,0.96));
    }

    .schedule-head h3 {
        margin: 0 0 8px;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .schedule-head p {
        margin: 0;
        color: var(--ink-muted);
    }

    .schedule-body {
        padding: 24px;
        display: grid;
        gap: 14px;
    }

    .schedule-list {
        margin: 0;
        padding: 0;
        list-style: none;
        display: grid;
        gap: 12px;
    }

    .schedule-list li {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        padding: 14px 16px;
        border-radius: 18px;
        background: var(--surface-soft);
        color: var(--ink-muted);
    }

    .schedule-list strong {
        color: var(--ink);
        font-weight: 700;
    }

    .detail-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .schedule-footer {
        padding: 0 24px 24px;
    }

    .btn-secondary {
        background: rgba(255,255,255,0.92);
        border-color: var(--border);
        color: var(--blue);
    }

    .empty-state {
        grid-column: 1/-1;
        text-align: center;
        padding: 40px 28px;
        color: var(--ink-muted);
        border-radius: var(--r-lg);
        background: var(--surface);
        box-shadow: var(--shadow-soft);
    }

    .empty-state h3 {
        margin-bottom: 12px;
    }

    @media (max-width: 980px) {
        .schedule-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<section class="schedule-hero" aria-label="Doctor schedule hero">
    <div class="wrap">
        <nav aria-label="Breadcrumb" style="display:flex;gap:10px;color:var(--ink-muted);font-size:0.95rem;">
            <a href="/">Home</a>
            <span>›</span>
            <a href="{{ route('doctor.schedule') }}">Doctor Schedule</a>
            @isset($doctor)
                <span>›</span>
                <span>{{ optional($doctor->user)->name ?? 'Doctor' }}</span>
            @endisset
        </nav>
        <div>
            <h1>{{ isset($doctor) ? optional($doctor->user)->name . ' — Specialist Profile' : 'Doctor Schedule' }}</h1>
            <p>{{ isset($doctor) ? 'Review the selected doctor’s profile, clinic details, and scheduling actions.' : 'Explore our doctor roster and open schedule profiles for clinical clarity.' }}</p>
        </div>
    </div>
</section>

<section class="sec" aria-label="Doctor schedule content">
    <div class="wrap">
        @isset($doctor)
            <article class="schedule-card" style="margin-bottom:24px;">
                <div class="schedule-head">
                    <h3>{{ optional($doctor->user)->name ?? 'Doctor' }}</h3>
                    <p>{{ $doctor->specialization ?? 'Orthopedic Specialist' }}</p>
                </div>
                <div class="schedule-body">
                    <ul class="schedule-list">
                        <li><span>Clinic</span><strong>{{ $doctor->clinic_address ?: 'Not available' }}</strong></li>
                        <li><span>License</span><strong>{{ $doctor->license_number ?: 'Pending' }}</strong></li>
                        <li><span>Email</span><strong>{{ optional($doctor->user)->email ?? 'No email' }}</strong></li>
                        <li><span>Phone</span><strong>{{ optional($doctor->user)->Contact_Number ?: 'No phone' }}</strong></li>
                        <li><span>About</span><strong>{{ $doctor->biography ?: 'No biography provided.' }}</strong></li>
                    </ul>
                </div>
                <div class="schedule-footer">
                    <div class="detail-actions">
                        <a href="{{ route('book-appointment') }}" class="btn btn-solid">Book Appointment</a>
                        <a href="{{ route('doctor.schedule') }}" class="btn btn-secondary">Back to doctors</a>
                    </div>
                </div>
            </article>
        @endisset

        <div class="schedule-grid">
            @forelse($doctors as $doc)
                <article class="schedule-card">
                    <div class="schedule-head">
                        <h3>{{ optional($doc->user)->name ?? 'Doctor' }}</h3>
                        <p>{{ $doc->specialization ?? 'Orthopedic Specialist' }}</p>
                    </div>
                    <div class="schedule-body">
                        <ul class="schedule-list">
                            <li><span>Clinic</span><strong>{{ $doc->clinic_address ?: 'Not available' }}</strong></li>
                            <li><span>Email</span><strong>{{ optional($doc->user)->email ?? 'No email' }}</strong></li>
                        </ul>
                    </div>
                    <div class="schedule-footer">
                        <a href="{{ route('doctor.view.schedule', $doc) }}" class="btn btn-secondary">View Schedule</a>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <h3>No doctors found</h3>
                    <p>There are no doctor profiles available at this time. Please contact the clinic for assistance.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
