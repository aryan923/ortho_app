@extends('layouts.app')

@section('title', 'Our Doctors — OrthoCore Clinic')

@push('styles')
<style>
    /* ─── DOCTORS: PAGE HERO ─── */
    .page-hero {
        background: linear-gradient(140deg, var(--blue-dk) 0%, var(--blue) 50%, var(--teal) 100%);
        padding: 56px 0 48px; color: #fff;
    }
    .page-hero h1 { font-size: clamp(1.9rem, 3.5vw, 2.8rem); font-weight: 800; letter-spacing: -.025em; line-height: 1.1; margin-bottom: 12px; color: #fff; }
    .page-hero p  { color: rgba(255,255,255,.85); font-size: 15.5px; max-width: 560px; margin-bottom: 24px; }

    /* ─── SEARCH & FILTER BAR ─── */
    .search-bar-section {
        background: var(--white); border-bottom: 1px solid var(--border);
        padding: 20px 0; position: sticky; top: 70px; z-index: 100;
        box-shadow: 0 4px 14px rgba(18,83,200,.07);
    }
    .search-bar-inner { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .search-input-wrap { position: relative; flex: 1 1 280px; }
    .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--ink-lt); font-size: 16px; pointer-events: none; }
    #doctorSearch {
        font-family: inherit; font-size: 14px; font-weight: 500;
        width: 100%; padding: 12px 14px 12px 42px;
        border: 1.5px solid var(--border); border-radius: 999px;
        background: var(--bg-soft); color: var(--ink);
        transition: border-color .15s, box-shadow .15s;
    }
    #doctorSearch:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(18,83,200,.1); background: #fff; }
    #doctorSearch::placeholder { color: var(--ink-lt); }
    .filter-chips { display: flex; gap: 8px; flex-wrap: wrap; }
    .chip {
        font-family: inherit; font-size: 13px; font-weight: 600;
        padding: 8px 16px; border-radius: 999px; cursor: pointer;
        border: 1.5px solid var(--border); background: var(--white); color: var(--ink-md);
        transition: all .15s;
    }
    .chip:hover  { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
    .chip.active { border-color: var(--blue); background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(18,83,200,.22); }
    .results-count { font-size: 13.5px; font-weight: 600; color: var(--ink-lt); white-space: nowrap; }

    /* ─── DOCTORS GRID ─── */
    .doctors-section { background: var(--bg-soft); }
    .doctors-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; margin-top: 28px; }

    /* ─── DOCTOR CARD (extended) ─── */
    .doc-card-top {
        height: 180px; position: relative;
        display: flex; align-items: center; justify-content: center;
    }
    .bg-blue   { background: linear-gradient(145deg, #cfe3fc, #93bfff); }
    .bg-teal   { background: linear-gradient(145deg, #c9f0ee, #7dd8d3); }
    .bg-coral  { background: linear-gradient(145deg, #fde8d8, #f9b68c); }
    .bg-purple { background: linear-gradient(145deg, #ede9fe, #c4b5fd); }
    .bg-green  { background: linear-gradient(145deg, #dcfce7, #86efac); }
    .bg-amber  { background: linear-gradient(145deg, #fef3c7, #fcd34d); }

    .doc-avatar {
        width: 88px; height: 88px; border-radius: 999px;
        display: grid; place-items: center; font-size: 24px; font-weight: 800;
        border: 3px solid rgba(255,255,255,.75);
        box-shadow: 0 8px 20px rgba(0,0,0,.12);
    }
    .ava-blue   { background: rgba(18,83,200,.15);  color: var(--blue-dk); }
    .ava-teal   { background: rgba(11,161,153,.18); color: #057972; }
    .ava-coral  { background: rgba(233,93,68,.18);  color: #b84a35; }
    .ava-purple { background: rgba(124,58,237,.15); color: #5b21b6; }
    .ava-green  { background: rgba(22,163,74,.15);  color: #15803d; }
    .ava-amber  { background: rgba(245,155,26,.18); color: #92400e; }

    .avail-badge { position: absolute; top: 12px; right: 12px; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 999px; }
    .avail-open    { background: var(--green-lt);  color: var(--green); }
    .avail-limited { background: #fef3c7; color: #92400e; }
    .avail-booked  { background: #fee2e2; color: #991b1b; }

    .spec-tag {
        position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);
        background: rgba(255,255,255,.9); backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,.7);
        font-size: 11px; font-weight: 800; color: var(--blue-dk);
        padding: 3px 12px; border-radius: 999px; white-space: nowrap;
        letter-spacing: .04em; text-transform: uppercase;
    }

    .doc-body { padding: 18px; flex: 1; display: flex; flex-direction: column; }
    .doc-name  { font-size: 17px; font-weight: 800; color: var(--ink); margin-bottom: 3px; }
    .doc-title { font-size: 13px; font-weight: 600; color: var(--blue); margin-bottom: 10px; }

    .doc-meta-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }
    .meta-chip {
        font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 999px;
        background: var(--bg-soft); border: 1px solid var(--border); color: var(--ink-md);
        display: inline-flex; align-items: center; gap: 5px;
    }
    .doc-bio { font-size: 13.5px; color: var(--ink-lt); line-height: 1.65; margin-bottom: 14px; flex: 1; }
    .doc-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
    .dtag { font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 999px; }
    .dtag-blue   { background: var(--blue-lt);   color: var(--blue-dk); }
    .dtag-teal   { background: var(--teal-lt);   color: #057972; }
    .dtag-purple { background: var(--purple-lt); color: #5b21b6; }
    .dtag-green  { background: var(--green-lt);  color: var(--green); }
    .dtag-coral  { background: #fff1ee;           color: #b84a35; }
    .dtag-amber  { background: #fef3c7;           color: #92400e; }

    .doc-footer { display: flex; gap: 8px; border-top: 1px solid var(--border); padding-top: 14px; }
    .doc-footer .btn { flex: 1; justify-content: center; }

    /* ─── EMPTY STATE ─── */
    .empty-state { grid-column: 1/-1; text-align: center; padding: 60px 20px; display: none; }
    .empty-state.show { display: block; }
    .empty-icon { font-size: 48px; margin-bottom: 12px; }
    .empty-state h3 { font-size: 20px; font-weight: 800; margin-bottom: 8px; }
    .empty-state p  { font-size: 14.5px; color: var(--ink-lt); }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1024px) {
        .doctors-grid { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 640px) {
        .doctors-grid { grid-template-columns: 1fr; }
        .filter-chips { display: none; }
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

{{-- ════ PAGE HERO ════ --}}
<section class="page-hero" aria-label="Doctors page hero">
    <div class="wrap">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a>
            <span>›</span>
            <span>{{ config('page.doctors.hero_label', 'Our Doctors') }}</span>
        </nav>
        <span class="tag white">{{ config('page.doctors.hero_label', 'Our Doctors') }}</span>
        <h1>{{ config('page.doctors.hero_title', 'Meet the specialists who guide your recovery') }}</h1>
        <p>{{ config('page.doctors.hero_subtitle', 'Our team blends world-class orthopedic skill with compassionate care to deliver treatment plans tailored to you.') }}</p>
        <div class="hero-stats">
            <div class="hero-stat"><strong>12</strong><span>Specialists</span></div>
            <div class="hero-stat"><strong>25+</strong><span>Years Avg. Experience</span></div>
            <div class="hero-stat"><strong>98%</strong><span>Patient Satisfaction</span></div>
            <div class="hero-stat"><strong>7</strong><span>Subspecialties</span></div>
        </div>
    </div>
</section>

{{-- ════ SEARCH & FILTER BAR ════ --}}
<div class="search-bar-section" role="search" aria-label="Search and filter doctors">
    <div class="wrap">
        <div class="search-bar-inner">
            <div class="search-input-wrap">
                <span class="search-icon" aria-hidden="true">🔍</span>
                <input type="search" id="doctorSearch"
                    placeholder="Search by name, speciality, or condition…"
                    autocomplete="off" aria-label="Search doctors"
                    oninput="filterDoctors()">
            </div>
            <div class="filter-chips" role="group" aria-label="Filter by speciality">
                <button class="chip active" data-filter="all"       onclick="setFilter(this)">All</button>
                <button class="chip"        data-filter="joint"     onclick="setFilter(this)">Joint &amp; Hip</button>
                <button class="chip"        data-filter="sports"    onclick="setFilter(this)">Sports Medicine</button>
                <button class="chip"        data-filter="spine"     onclick="setFilter(this)">Spine &amp; Neck</button>
                <button class="chip"        data-filter="physio"    onclick="setFilter(this)">Physiotherapy</button>
                <button class="chip"        data-filter="pediatric" onclick="setFilter(this)">Pediatric</button>
                <button class="chip"        data-filter="trauma"    onclick="setFilter(this)">Fracture &amp; Trauma</button>
            </div>
            <span class="results-count" id="resultsCount" aria-live="polite">{{ $doctors->total() }} {{ $doctors->total() === 1 ? 'doctor' : 'doctors' }}</span>
        </div>
    </div>
</div>

{{-- ════ DOCTORS GRID ════ --}}
<section class="doctors-section sec" aria-label="Doctor profiles">
    <div class="wrap">
        <div class="doctors-grid" id="doctorsGrid">

            @forelse($doctors as $doctor)
                @php
                    $nameLower = strtolower($doctor->user->name ?? '');
                    $specLower = strtolower($doctor->specialization ?? '');
                    
                    // Determine filter categories
                    $filters = [];
                    if (str_contains($specLower, 'joint') || str_contains($specLower, 'hip') || str_contains($specLower, 'knee')) $filters[] = 'joint';
                    if (str_contains($specLower, 'sports') || str_contains($specLower, 'injury')) $filters[] = 'sports';
                    if (str_contains($specLower, 'spine') || str_contains($specLower, 'neck')) $filters[] = 'spine';
                    if (str_contains($specLower, 'physio') || str_contains($specLower, 'rehab')) $filters[] = 'physio';
                    if (str_contains($specLower, 'pediatric')) $filters[] = 'pediatric';
                    if (str_contains($specLower, 'trauma') || str_contains($specLower, 'fracture')) $filters[] = 'trauma';
                    if (empty($filters)) $filters[] = 'joint'; // fallback
                    
                    $filterStr = implode(' ', $filters);
                    $keywords = $specLower . ' ' . strtolower($doctor->biography ?? '');
                    
                    // Consistent fake stats based on doctor ID
                    $exp = 8 + (($doctor->id * 3) % 15);
                    $rating = 4.6 + (($doctor->id * 2) % 4) / 10;
                    $reviews = 35 + (($doctor->id * 13) % 120);
                    
                    // Color classes based on ID
                    $colorIndex = ($doctor->id % 6);
                    $bgClasses = ['bg-blue', 'bg-teal', 'bg-coral', 'bg-purple', 'bg-green', 'bg-amber'];
                    $avaClasses = ['ava-blue', 'ava-teal', 'ava-coral', 'ava-purple', 'ava-green', 'ava-amber'];
                    $bgClass = $bgClasses[$colorIndex];
                    $avaClass = $avaClasses[$colorIndex];
                    
                    // Availability status
                    $availStatus = ($doctor->id % 3 == 0) ? 'avail-limited' : (($doctor->id % 3 == 1) ? 'avail-booked' : 'avail-open');
                    $availText = ($availStatus == 'avail-open') ? 'Available Today' : (($availStatus == 'avail-limited') ? 'Next: Tomorrow' : 'Fully Booked');
                @endphp
                <article class="doc-card" data-name="{{ $nameLower }}" data-filter="{{ $filterStr }}" data-keywords="{{ $keywords }}">
                    <div class="doc-card-top {{ $bgClass }}">
                        <div class="doc-avatar {{ $avaClass }}">
                            {{ strtoupper(substr($doctor->user->name ?? 'DR', 0, 2)) }}
                        </div>
                        <span class="avail-badge {{ $availStatus }}">{{ $availText }}</span>
                        <span class="spec-tag">{{ $doctor->specialization ?? 'Orthopedic Specialist' }}</span>
                    </div>
                    <div class="doc-body">
                        <div class="doc-name">{{ $doctor->user->name ?? 'Doctor' }}, MD</div>
                        <div class="doc-title">{{ $doctor->specialization ?? 'Orthopedic Specialist' }}</div>
                        <div class="doc-meta-row">
                            <span class="meta-chip">🏥 {{ $exp }} yrs experience</span>
                            <span class="meta-chip">⭐ {{ number_format($rating, 1) }} ({{ $reviews }} reviews)</span>
                        </div>
                        <p class="doc-bio">{{ $doctor->biography ?? 'Dedicated orthopedic clinical specialist committed to state-of-the-art musculoskeletal care and rapid recovery.' }}</p>
                        <div class="doc-footer">
                            <a href="{{ route('doctor.view.schedule', $doctor) }}" class="btn btn-solid btn-sm">Book Now</a>
                            <a href="{{ route('doctor.view.schedule', $doctor) }}" class="btn btn-ghost btn-sm">View Profile</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state show" id="emptyState" role="status">
                    <div class="empty-icon">🔍</div>
                    <h3>No doctors found</h3>
                    <p>Try a different search term or check back later.</p>
                </div>
            @endforelse

        </div>

        @if($doctors->hasPages())
            <nav class="pagination" aria-label="Pagination Navigation" style="margin-top: 36px;">
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

    </div>
</section>

{{-- ════ CTA BAND ════ --}}
<section class="cta-band" aria-label="Book appointment call to action">
    <div class="wrap">
        <div>
            <span class="tag white">Ready to Get Started?</span>
            <h2>Book with Any of Our Specialists Today</h2>
            <p>Same-day appointments available. Our care coordinator will confirm your booking within 2 hours.</p>
        </div>
        <div class="cta-btns">
            <a href="/book-appointment" class="btn btn-fire">Book an Appointment →</a>
            <a href="tel:+12125550192" class="btn btn-ghost" style="border-color:rgba(255,255,255,.4);color:#fff;background:rgba(255,255,255,.12);">Call +1 (212) 555-0192</a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    let activeFilter = 'all';

    function setFilter(chip) {
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        activeFilter = chip.dataset.filter;
        filterDoctors();
    }

    function filterDoctors() {
        const query  = document.getElementById('doctorSearch').value.toLowerCase().trim();
        const cards  = document.querySelectorAll('.doc-card');
        let visible  = 0;

        cards.forEach(card => {
            const name     = card.dataset.name     || '';
            const filter   = card.dataset.filter   || '';
            const keywords = card.dataset.keywords || '';
            const matchesFilter = activeFilter === 'all' || filter.includes(activeFilter);
            const matchesSearch = !query || name.includes(query) || keywords.includes(query) || filter.includes(query);
            const show = matchesFilter && matchesSearch;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('resultsCount').textContent = visible + (visible === 1 ? ' doctor' : ' doctors');
        document.getElementById('emptyState').classList.toggle('show', visible === 0);
    }
</script>
@endpush
