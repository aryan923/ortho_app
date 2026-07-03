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
</style>
@endpush

@section('content')

{{-- ════ PAGE HERO ════ --}}
<section class="page-hero" aria-label="Doctors page hero">
    <div class="wrap">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="/">Home</a>
            <span>›</span>
            <span>Our Doctors</span>
        </nav>
        <span class="tag white">Meet the Team</span>
        <h1>World-Class Orthopedic Specialists</h1>
        <p>Our team of board-certified orthopedic surgeons, sports medicine physicians, and physiotherapists brings decades of combined expertise to every patient.</p>
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
            <span class="results-count" id="resultsCount" aria-live="polite">9 doctors</span>
        </div>
    </div>
</div>

{{-- ════ DOCTORS GRID ════ --}}
<section class="doctors-section sec" aria-label="Doctor profiles">
    <div class="wrap">
        <div class="doctors-grid" id="doctorsGrid">

            <article class="doc-card" data-name="james mitchell" data-filter="joint sports" data-keywords="joint replacement hip knee sports medicine arthroscopy">
                <div class="doc-card-top bg-blue">
                    <div class="doc-avatar ava-blue">JM</div>
                    <span class="avail-badge avail-open">Available Today</span>
                    <span class="spec-tag">Joint Replacement</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. James Mitchell, MD</div>
                    <div class="doc-title">Chief of Orthopedic Surgery</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 28 yrs experience</span>
                        <span class="meta-chip">🎓 Harvard Medical</span>
                        <span class="meta-chip">⭐ 4.9 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Mitchell is a nationally recognized joint replacement specialist with over 2,800 successful hip and knee surgeries. He trained at Harvard and completed a fellowship at Hospital for Special Surgery (HSS), New York.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-blue">Hip Replacement</span>
                        <span class="dtag dtag-blue">Knee Replacement</span>
                        <span class="dtag dtag-teal">Arthroscopy</span>
                        <span class="dtag dtag-teal">Sports Injuries</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="amara okafor" data-filter="sports" data-keywords="sports medicine acl ligament arthroscopy shoulder elbow">
                <div class="doc-card-top bg-teal">
                    <div class="doc-avatar ava-teal">AO</div>
                    <span class="avail-badge avail-open">Available Today</span>
                    <span class="spec-tag">Sports Medicine</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Amara Okafor, MD</div>
                    <div class="doc-title">Sports Medicine &amp; Arthroscopy</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 15 yrs experience</span>
                        <span class="meta-chip">🎓 Johns Hopkins</span>
                        <span class="meta-chip">⭐ 4.8 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Okafor specialises in minimally invasive arthroscopic procedures and ACL reconstruction. She is the team physician for two professional sports organisations and has treated Olympic-level athletes.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-teal">ACL Reconstruction</span>
                        <span class="dtag dtag-teal">Rotator Cuff</span>
                        <span class="dtag dtag-blue">Meniscus Repair</span>
                        <span class="dtag dtag-purple">Arthroscopy</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="priya sharma" data-filter="spine" data-keywords="spine neck back pain decompression disc scoliosis">
                <div class="doc-card-top bg-coral">
                    <div class="doc-avatar ava-coral">PS</div>
                    <span class="avail-badge avail-limited">Next: Tomorrow</span>
                    <span class="spec-tag">Spine Surgery</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Priya Sharma, MD</div>
                    <div class="doc-title">Spine Surgery &amp; Pain Management</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 20 yrs experience</span>
                        <span class="meta-chip">🎓 Mayo Clinic</span>
                        <span class="meta-chip">⭐ 4.9 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Sharma is a fellowship-trained spinal deformity specialist from Mayo Clinic. She has pioneered minimally invasive techniques for lumbar decompression and cervical disc replacement, reducing recovery time by up to 40%.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-coral">Spinal Decompression</span>
                        <span class="dtag dtag-coral">Disc Replacement</span>
                        <span class="dtag dtag-amber">Scoliosis</span>
                        <span class="dtag dtag-amber">Neck Pain</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="leon carter" data-filter="physio" data-keywords="physiotherapy rehabilitation post surgery recovery exercise therapy">
                <div class="doc-card-top bg-green">
                    <div class="doc-avatar ava-green">LC</div>
                    <span class="avail-badge avail-open">Available Today</span>
                    <span class="spec-tag">Physiotherapy</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Leon Carter, DPT</div>
                    <div class="doc-title">Lead Physiotherapist &amp; Rehab Specialist</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 12 yrs experience</span>
                        <span class="meta-chip">🎓 Columbia University</span>
                        <span class="meta-chip">⭐ 4.7 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Carter leads our post-surgical rehabilitation programme, combining manual therapy, exercise prescription, and biomechanical analysis to achieve the fastest safe recovery for each patient.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-green">Post-Op Rehab</span>
                        <span class="dtag dtag-green">Manual Therapy</span>
                        <span class="dtag dtag-teal">Gait Analysis</span>
                        <span class="dtag dtag-blue">Sports Physio</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="sofia reyes" data-filter="pediatric" data-keywords="pediatric children orthopedic clubfoot scoliosis growth">
                <div class="doc-card-top bg-purple">
                    <div class="doc-avatar ava-purple">SR</div>
                    <span class="avail-badge avail-open">Available Today</span>
                    <span class="spec-tag">Pediatric Ortho</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Sofia Reyes, MD</div>
                    <div class="doc-title">Pediatric Orthopedic Surgeon</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 17 yrs experience</span>
                        <span class="meta-chip">🎓 Stanford Medicine</span>
                        <span class="meta-chip">⭐ 5.0 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Reyes is one of the region's most sought-after pediatric orthopedic surgeons. Her gentle, family-centred approach has made her the first choice for parents seeking care for children with bone and growth disorders.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-purple">Clubfoot Correction</span>
                        <span class="dtag dtag-purple">Pediatric Scoliosis</span>
                        <span class="dtag dtag-blue">Growth Plate</span>
                        <span class="dtag dtag-teal">Hip Dysplasia</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="nathan brooks" data-filter="trauma" data-keywords="fracture trauma emergency broken bone surgery fixation">
                <div class="doc-card-top bg-amber">
                    <div class="doc-avatar ava-amber">NB</div>
                    <span class="avail-badge avail-limited">Next: Tomorrow</span>
                    <span class="spec-tag">Fracture &amp; Trauma</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Nathan Brooks, MD</div>
                    <div class="doc-title">Orthopedic Trauma &amp; Fracture Surgeon</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 22 yrs experience</span>
                        <span class="meta-chip">🎓 NYU Langone</span>
                        <span class="meta-chip">⭐ 4.8 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Brooks has managed over 4,000 complex fracture cases, from simple breaks to multi-trauma polytrauma. He is the lead surgeon on our 24/7 emergency orthopedic response team and an instructor at NYU.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-amber">Complex Fractures</span>
                        <span class="dtag dtag-amber">Internal Fixation</span>
                        <span class="dtag dtag-coral">Polytrauma</span>
                        <span class="dtag dtag-blue">Emergency Ortho</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="rachel kim" data-filter="joint" data-keywords="hip replacement revision arthroplasty joint">
                <div class="doc-card-top bg-teal">
                    <div class="doc-avatar ava-teal">RK</div>
                    <span class="avail-badge avail-open">Available Today</span>
                    <span class="spec-tag">Hip Arthroplasty</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Rachel Kim, MD</div>
                    <div class="doc-title">Hip &amp; Revision Arthroplasty</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 18 yrs experience</span>
                        <span class="meta-chip">🎓 Cleveland Clinic</span>
                        <span class="meta-chip">⭐ 4.9 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Kim is a specialist in primary and revision hip arthroplasty, with particular expertise in complex revision cases where prior implants have failed. She uses cutting-edge robotic-assisted navigation systems.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-teal">Hip Replacement</span>
                        <span class="dtag dtag-teal">Revision Surgery</span>
                        <span class="dtag dtag-purple">Robotic Assisted</span>
                        <span class="dtag dtag-blue">Arthritis</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="marcus webb" data-filter="sports spine" data-keywords="shoulder rotator cuff labrum sports neck cervical">
                <div class="doc-card-top bg-purple">
                    <div class="doc-avatar ava-purple">MW</div>
                    <span class="avail-badge avail-booked">Fully Booked</span>
                    <span class="spec-tag">Shoulder &amp; Elbow</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Marcus Webb, MD</div>
                    <div class="doc-title">Shoulder, Elbow &amp; Upper Limb Surgeon</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 14 yrs experience</span>
                        <span class="meta-chip">🎓 Duke University</span>
                        <span class="meta-chip">⭐ 4.7 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Webb has a distinguished reputation for shoulder reconstruction and labrum repair. He is the preferred surgeon for overhead athletes — including professional baseball and tennis players — throughout the northeast.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-purple">Rotator Cuff Repair</span>
                        <span class="dtag dtag-purple">Labrum Surgery</span>
                        <span class="dtag dtag-teal">Shoulder Replacement</span>
                        <span class="dtag dtag-blue">Elbow Injuries</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <article class="doc-card" data-name="ingrid holt" data-filter="physio" data-keywords="physiotherapy arthritis chronic pain elderly geriatric rehabilitation">
                <div class="doc-card-top bg-blue">
                    <div class="doc-avatar ava-blue">IH</div>
                    <span class="avail-badge avail-open">Available Today</span>
                    <span class="spec-tag">Geriatric Rehab</span>
                </div>
                <div class="doc-body">
                    <div class="doc-name">Dr. Ingrid Holt, DPT</div>
                    <div class="doc-title">Geriatric &amp; Chronic Pain Physiotherapy</div>
                    <div class="doc-meta-row">
                        <span class="meta-chip">🏥 10 yrs experience</span>
                        <span class="meta-chip">🎓 NYU Steinhardt</span>
                        <span class="meta-chip">⭐ 4.9 / 5.0</span>
                    </div>
                    <p class="doc-bio">Dr. Holt specialises in restoring mobility and independence for elderly patients living with chronic musculoskeletal pain. Her holistic programmes integrate physiotherapy, pain education, and strength training.</p>
                    <div class="doc-tags">
                        <span class="dtag dtag-blue">Chronic Pain</span>
                        <span class="dtag dtag-blue">Arthritis Rehab</span>
                        <span class="dtag dtag-green">Fall Prevention</span>
                        <span class="dtag dtag-teal">Mobility Training</span>
                    </div>
                    <div class="doc-footer">
                        <a href="/book-appointment" class="btn btn-solid btn-sm">Book Now</a>
                        <a href="#" class="btn btn-ghost btn-sm">View Profile</a>
                    </div>
                </div>
            </article>

            <div class="empty-state" id="emptyState" role="status">
                <div class="empty-icon">🔍</div>
                <h3>No doctors found</h3>
                <p>Try a different search term or clear the filters to see all specialists.</p>
            </div>

        </div>
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
