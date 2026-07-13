@extends('layouts.app')

@section('title', 'Book an Appointment — OrthoCore Clinic')

@push('styles')
<style>
    .book-hero {
        padding: 80px 0 60px;
        background: linear-gradient(135deg, rgba(18, 83, 200, 0.95), rgba(11, 161, 153, 0.9));
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .book-hero::after {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        top: -100px;
        right: -100px;
        pointer-events: none;
    }

    .book-hero .wrap {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 40px;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .book-hero h1 {
        font-size: clamp(2.5rem, 4vw, 3.8rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        letter-spacing: -0.02em;
    }

    .book-hero p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
        line-height: 1.7;
    }

    .hero-banner {
        padding: 30px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(12px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }

    .hero-banner h3 {
        margin: 0 0 12px;
        font-size: 1.2rem;
        font-weight: 700;
        color: #fff;
    }

    .hero-banner p {
        margin: 0;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.6;
    }

    .section-header {
        text-align: center;
        max-width: 680px;
        margin: 0 auto 48px;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 16px;
        background: var(--blue-lt);
        color: var(--blue);
        border-radius: 100px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .doctor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-top: 20px;
    }

    .doctor-profile-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--sh-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .doctor-profile-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--sh-md);
        border-color: rgba(18, 83, 200, 0.25);
    }

    .card-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: linear-gradient(135deg, #f5f8fe 0%, #eaf1fd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .doctor-avatar-graphic {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--blue), var(--teal));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2.2rem;
        font-weight: 800;
        box-shadow: 0 10px 25px rgba(18, 83, 200, 0.2);
        border: 4px solid #fff;
        z-index: 2;
    }

    .card-image-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.06;
        background-image: radial-gradient(circle at 1px 1px, var(--blue) 1px, transparent 0);
        background-size: 16px 16px;
    }

    .doctor-meta-info {
        padding: 28px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    }

    .doctor-name {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--ink);
        margin: 0 0 6px;
    }

    .doctor-specialty {
        font-size: 1rem;
        font-weight: 600;
        color: var(--teal);
        margin: 0 0 20px;
        background: var(--teal-lt);
        padding: 4px 14px;
        border-radius: 100px;
        display: inline-block;
    }

    .action-btn-wrapper {
        width: 100%;
    }

    .action-btn-wrapper .btn {
        width: 100%;
        justify-content: center;
        padding: 14px 24px;
        border-radius: 16px;
        font-size: 0.95rem;
    }

    .empty-state-card {
        grid-column: 1 / -1;
        background: var(--white);
        border: 1px dashed var(--border);
        border-radius: 24px;
        padding: 60px 40px;
        text-align: center;
        color: var(--ink-lt);
    }

    .empty-state-card h3 {
        color: var(--ink);
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 12px;
    }

    .features-grid {
        margin-top: 80px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 30px;
    }

    .feature-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 30px;
        box-shadow: var(--sh-sm);
        transition: transform 0.2s;
    }

    .feature-card:hover {
        transform: translateY(-4px);
    }

    .feature-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--blue-lt);
        color: var(--blue);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 1.4rem;
    }

    .feature-card h3 {
        margin: 0 0 12px;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--ink);
    }

    .feature-card p {
        margin: 0;
        color: var(--ink-lt);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    @media (max-width: 1024px) {
        .book-hero .wrap {
            grid-template-columns: 1fr;
        }
        .features-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    /* ─── PAGINATION ─── */
    .pagination { display: flex; gap: 8px; align-items: center; justify-content: center; margin-top: 36px; }
    .page-btn {
        font-family: inherit; font-size: 14px; font-weight: 700;
        width: 40px; height: 40px; border-radius: 10px; border: 1.5px solid var(--border);
        background: var(--white); color: var(--ink-md); cursor: pointer;
        display: grid; place-items: center; transition: all .15s; text-decoration: none;
    }
    .page-btn:hover  { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
    .page-btn.active { border-color: var(--blue); background: var(--blue); color: #fff; }
    .page-btn.disabled { opacity: 0.5; cursor: not-allowed; }
    .page-btn.disabled:hover { border-color: var(--border); color: var(--ink-md); background: var(--white); }
</style>
@endpush

@section('content')
<section class="book-hero" aria-label="Book appointment hero">
    <div class="wrap">
        <div>
            <span class="section-badge" style="background: rgba(255,255,255,0.18); color: #fff; border: 1px solid rgba(255,255,255,0.3);">Premium Scheduling</span>
            <h1>Book Your Clinical Consultation</h1>
            <p>Select an orthopedic specialist from our roster, view real-time date availability, and request a booked appointment coordinate with our clinic operations team.</p>
        </div>
        <div class="hero-banner">
            <h3>Direct Patient Portal</h3>
            <p>Every schedule is updated dynamically. Choose a specialist below to access their profile calendar and book your slots instantly.</p>
        </div>
    </div>
</section>

<section class="sec" aria-label="Doctor selection">
    <div class="wrap">
        <div class="section-header">
            <span class="section-badge">Step 1 of 2</span>
            <h2 class="sec-title">Select a Specialist</h2>
            <p class="sec-sub">Browse our board-certified orthopedic surgeons and rehabilitation specialists to book your surgical or clinical consultation.</p>
        </div>

        <div class="doctor-grid">
            @forelse($doctors as $doctor)
                <article class="doctor-profile-card">
                    <div class="card-image-wrapper">
                        <div class="card-image-bg-pattern"></div>
                        <div class="doctor-avatar-graphic">
                            {{ strtoupper(substr(optional($doctor->user)->name ?? 'DR', 0, 2)) }}
                        </div>
                    </div>
                    <div class="doctor-meta-info">
                        <div>
                            <h3 class="doctor-name">{{ optional($doctor->user)->name ?? 'Doctor' }}</h3>
                            <span class="doctor-specialty">{{ $doctor->specialization ?? 'Orthopedic Specialist' }}</span>
                        </div>
                        <div class="action-btn-wrapper">
                            <a href="{{ route('doctor.view.schedule', $doctor) }}" class="btn btn-solid">
                                View Profile &amp; Book
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state-card">
                    <h3>No Doctors Available</h3>
                    <p>There are currently no orthopedic specialists available for scheduling. Please contact our care coordination desk directly for immediate assistance.</p>
                </div>
            @endforelse
        </div>

        @if($doctors->hasPages())
            <nav class="pagination" aria-label="Pagination Navigation">
                {{-- Previous Page Link --}}
                @if($doctors->onFirstPage())
                    <span class="page-btn disabled">&lsaquo;</span>
                @else
                    <a href="{{ $doctors->previousPageUrl() }}" class="page-btn">&lsaquo;</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($doctors->getUrlRange(1, $doctors->lastPage()) as $page => $url)
                    @if ($page == $doctors->currentPage())
                        <span class="page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($doctors->hasMorePages())
                    <a href="{{ $doctors->nextPageUrl() }}" class="page-btn">&rsaquo;</a>
                @else
                    <span class="page-btn disabled">&rsaquo;</span>
                @endif
            </nav>
        @endif

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </div>
                <h3>Real-Time Availability</h3>
                <p>Instantly browse available consultation days and time slots. Fully synced with our surgeons' clinical calendars.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <h3>Surgical Care Roster</h3>
                <p>All doctors on the portal are fully board-certified orthopedic surgeons, specializing in arthroplasty, trauma, and sports medicine.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                </div>
                <h3>Seamless Confirmation</h3>
                <p>Fill out symptoms, request your slot, and receive email/SMS confirmation immediately once finalized by our coordinators.</p>
            </div>
        </div>
    </div>
</section>
@endsection
