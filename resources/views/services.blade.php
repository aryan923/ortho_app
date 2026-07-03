@extends('layouts.app')

@section('title', 'Services — OrthoCore Clinic')

@push('styles')
<style>
    /* ─── SERVICES: PAGE HERO ─── */
    .page-hero {
        background: linear-gradient(140deg, var(--blue-dk) 0%, var(--blue) 50%, var(--teal) 100%);
        padding: 56px 0 48px; color: #fff;
    }
    .page-hero .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
    .page-hero h1 { font-size: clamp(1.9rem, 3.5vw, 2.8rem); font-weight: 800; letter-spacing: -.025em; line-height: 1.1; margin-bottom: 12px; color: #fff; }
    .page-hero p  { color: rgba(255,255,255,.85); font-size: 15.5px; max-width: 560px; margin-bottom: 24px; }

    /* ─── SERVICE NAV ─── */
    .service-nav {
        background: var(--white); border-bottom: 1px solid var(--border);
        padding: 16px 0; position: sticky; top: 70px; z-index: 100;
        box-shadow: 0 4px 14px rgba(18,83,200,.06); overflow-x: auto;
    }
    .service-nav .wrap { display: flex; gap: 10px; align-items: center; flex-wrap: nowrap; }
    .snav-pill {
        font-family: inherit; font-size: 13px; font-weight: 700;
        padding: 8px 18px; border-radius: 999px; white-space: nowrap;
        border: 1.5px solid var(--border); background: var(--white); color: var(--ink-md);
        cursor: pointer; transition: all .15s; text-decoration: none; display: inline-block;
    }
    .snav-pill:hover  { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
    .snav-pill.active { border-color: var(--blue); background: var(--blue); color: #fff; box-shadow: 0 4px 12px rgba(18,83,200,.22); }

    /* ─── SERVICE SECTIONS ─── */
    .srv-section { padding: 64px 0; }
    .srv-section:nth-child(even) { background: var(--bg-soft); }
    .srv-section-head { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: center; margin-bottom: 40px; }
    .srv-section-head.reverse { direction: rtl; }
    .srv-section-head.reverse > * { direction: ltr; }
    .srv-img { border-radius: var(--r-lg); overflow: hidden; aspect-ratio: 16/10; box-shadow: var(--sh-md); }
    .srv-img img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }

    /* condition pills */
    .conditions { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 20px; }
    .cond-pill { font-size: 12.5px; font-weight: 700; padding: 5px 13px; border-radius: 999px; border: 1.5px solid var(--border); background: var(--white); color: var(--ink-md); }
    .theme-blue   .cond-pill { border-color: #b6cef5; background: var(--blue-lt);   color: var(--blue-dk); }
    .theme-teal   .cond-pill { border-color: #9ce3df; background: var(--teal-lt);   color: #057972; }
    .theme-coral  .cond-pill { border-color: #f8c8c0; background: #fff1ee;           color: #b84a35; }
    .theme-purple .cond-pill { border-color: #c4b5fd; background: var(--purple-lt); color: #5b21b6; }
    .theme-green  .cond-pill { border-color: #86efac; background: var(--green-lt);  color: var(--green); }
    .theme-amber  .cond-pill { border-color: #fcd34d; background: #fef3c7;           color: #92400e; }

    /* sub-cards */
    .sub-cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
    .sub-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--r-md); padding: 16px; transition: transform .2s, box-shadow .2s; }
    .sub-card:hover { transform: translateY(-3px); box-shadow: var(--sh-sm); }
    .sub-icon { width: 38px; height: 38px; border-radius: 10px; display: grid; place-items: center; margin-bottom: 10px; }
    .sub-card h4 { font-size: 14px; font-weight: 700; margin-bottom: 5px; color: var(--ink); }
    .sub-card p  { font-size: 13px; color: var(--ink-lt); line-height: 1.6; }
    .theme-blue   .sub-icon { background: var(--blue-lt); color: var(--blue); }
    .theme-teal   .sub-icon { background: var(--teal-lt); color: var(--teal); }
    .theme-coral  .sub-icon { background: #fff1ee;         color: var(--coral); }
    .theme-purple .sub-icon { background: var(--purple-lt);color: var(--purple); }
    .theme-green  .sub-icon { background: var(--green-lt); color: var(--green); }
    .theme-amber  .sub-icon { background: #fef3c7;         color: #92400e; }

    .srv-section-cta { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 28px; align-items: center; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1024px) {
        .page-hero .wrap { grid-template-columns: 1fr; }
        .page-hero-img { display: none; }
        .srv-section-head, .srv-section-head.reverse { grid-template-columns: 1fr; direction: ltr; }
        .srv-img { aspect-ratio: 16/9; }
    }
    @media (max-width: 640px) {
        .srv-section { padding: 48px 0; }
        .sub-cards { grid-template-columns: 1fr; }
        .service-nav { display: none; }
    }
</style>
@endpush

@section('content')

{{-- ════ PAGE HERO ════ --}}
<section class="page-hero" aria-label="Services page hero">
    <div class="wrap">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="/">Home</a>
                <span>›</span>
                <span>Services</span>
            </nav>
            <span class="tag white">What We Treat</span>
            <h1>Comprehensive Orthopedic &amp; Physiotherapy Services</h1>
            <p>From joint replacements and spine surgery to sports rehabilitation and physiotherapy — every treatment plan at OrthoCore is built around you.</p>
            <div class="hero-features">
                <div class="hero-feat"><span class="feat-dot"></span> 12 specialist doctors</div>
                <div class="hero-feat"><span class="feat-dot"></span> 7 subspecialties</div>
                <div class="hero-feat"><span class="feat-dot"></span> Same-day consultations</div>
                <div class="hero-feat"><span class="feat-dot"></span> Insurance accepted</div>
            </div>
        </div>
        <div class="page-hero-img">
            <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=900&q=85"
                alt="Orthopedic specialists reviewing patient care in a modern clinic"
                loading="eager"
                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=80';">
        </div>
    </div>
</section>

{{-- ════ SERVICE NAV ════ --}}
<nav class="service-nav" aria-label="Jump to service">
    <div class="wrap">
        <a href="#joint"    class="snav-pill active">Joint Replacement</a>
        <a href="#sports"   class="snav-pill">Sports Medicine</a>
        <a href="#spine"    class="snav-pill">Spine &amp; Neck</a>
        <a href="#physio"   class="snav-pill">Physiotherapy</a>
        <a href="#fracture" class="snav-pill">Fracture &amp; Trauma</a>
        <a href="#arthritis"class="snav-pill">Arthritis</a>
        <a href="#pediatric"class="snav-pill">Pediatric Ortho</a>
    </div>
</nav>

{{-- ════ SERVICE 1 — JOINT REPLACEMENT ════ --}}
<section id="joint" class="srv-section theme-blue" aria-labelledby="joint-title">
    <div class="wrap">
        <div class="srv-section-head">
            <div class="srv-img">
                <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=900&q=80"
                    alt="Surgeon performing knee replacement surgery" loading="lazy"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1530026405186-ed1f139313f8?auto=format&fit=crop&w=900&q=80';">
            </div>
            <div class="srv-text">
                <span class="tag">Joint Replacement</span>
                <h2 class="sec-title" id="joint-title">Hip &amp; Knee Replacement Surgery</h2>
                <p class="sec-sub">Our board-certified joint replacement surgeons perform over 600 procedures a year using the latest robotic-assisted and minimally invasive techniques, reducing recovery time and improving long-term outcomes.</p>
                <div class="conditions">
                    <span class="cond-pill">Knee Osteoarthritis</span>
                    <span class="cond-pill">Hip Arthritis</span>
                    <span class="cond-pill">Avascular Necrosis</span>
                    <span class="cond-pill">Revision Arthroplasty</span>
                    <span class="cond-pill">Implant Failure</span>
                </div>
                <div class="srv-section-cta">
                    <a href="/book-appointment" class="btn btn-solid">Book Consultation</a>
                    <a href="/doctors" class="btn btn-ghost">Meet Our Surgeons</a>
                </div>
            </div>
        </div>
        <div class="sub-cards">
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div><h4>Total Knee Replacement</h4><p>Full resurfacing using precision-fitted titanium and polyethylene implants. Average hospital stay: 1–2 days.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h4>Total Hip Replacement</h4><p>Anterior approach hip replacement for faster recovery, less pain, and reduced risk of dislocation.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div><h4>Partial &amp; Unicompartmental</h4><p>When only part of the joint is affected, a partial replacement preserves healthy bone with faster recovery.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div><h4>Robotic-Assisted Surgery</h4><p>Our Mako robotic system delivers sub-millimetre precision for implant placement, optimising alignment and longevity.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg></div><h4>Revision Arthroplasty</h4><p>Complex revision procedures for failed or worn implants, restoring mobility when prior surgery hasn't achieved expected results.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><h4>Pre-op Optimisation</h4><p>Comprehensive pre-surgical conditioning including nutrition guidance, physiotherapy, and pain management to ensure peak readiness.</p></div>
        </div>
    </div>
</section>

{{-- ════ SERVICE 2 — SPORTS MEDICINE ════ --}}
<section id="sports" class="srv-section theme-teal" aria-labelledby="sports-title">
    <div class="wrap">
        <div class="srv-section-head reverse">
            <div class="srv-img">
                <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=900&q=80"
                    alt="Sports medicine physician treating an athlete's knee" loading="lazy"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=900&q=80';">
            </div>
            <div class="srv-text">
                <span class="tag teal">Sports Medicine</span>
                <h2 class="sec-title" id="sports-title">Sports Injury Treatment &amp; Athletic Recovery</h2>
                <p class="sec-sub">Whether you're a weekend runner or a professional athlete, our sports medicine team provides cutting-edge diagnosis and treatment to get you back performing at your peak — faster.</p>
                <div class="conditions">
                    <span class="cond-pill">ACL / PCL Tears</span>
                    <span class="cond-pill">Meniscus Injury</span>
                    <span class="cond-pill">Rotator Cuff Tear</span>
                    <span class="cond-pill">Tennis / Golfer's Elbow</span>
                    <span class="cond-pill">Stress Fractures</span>
                    <span class="cond-pill">Ankle Sprains</span>
                </div>
                <div class="srv-section-cta">
                    <a href="/book-appointment" class="btn btn-solid">Book Consultation</a>
                    <a href="/doctors" class="btn btn-ghost">Meet Our Surgeons</a>
                </div>
            </div>
        </div>
        <div class="sub-cards">
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h4>ACL Reconstruction</h4><p>Anatomic single and double-bundle ACL reconstruction using autograft or allograft tissue with accelerated rehab protocols.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div><h4>Arthroscopic Surgery</h4><p>Minimally invasive keyhole procedures for knee, shoulder, hip, and ankle injuries — less scarring, faster return to sport.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div><h4>PRP &amp; Regenerative Therapy</h4><p>Platelet-rich plasma injections and biologics to accelerate natural healing in tendons, ligaments, and cartilage.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div><h4>Return-to-Sport Programme</h4><p>Structured sport-specific conditioning and functional testing to ensure safe, confident return to training and competition.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><h4>Biomechanical Analysis</h4><p>3D movement screening and gait analysis to identify injury risk factors and refine athletic mechanics to prevent re-injury.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><h4>Concussion Management</h4><p>Evidence-based assessment and graded return-to-play protocols for contact sport athletes following head injuries.</p></div>
        </div>
    </div>
</section>

{{-- ════ SERVICE 3 — SPINE & NECK ════ --}}
<section id="spine" class="srv-section theme-coral" aria-labelledby="spine-title">
    <div class="wrap">
        <div class="srv-section-head">
            <div class="srv-img">
                <img src="https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=900&q=80"
                    alt="Doctor reviewing spinal MRI scan" loading="lazy"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=900&q=80';">
            </div>
            <div class="srv-text">
                <span class="tag" style="background:#fff1ee;color:#b84a35;">Spine &amp; Neck</span>
                <h2 class="sec-title" id="spine-title">Spine Surgery &amp; Chronic Back Pain Relief</h2>
                <p class="sec-sub">Our spine specialists tackle everything from a herniated disc to complex spinal deformities — with a conservative-first philosophy that means surgery only when it's truly necessary.</p>
                <div class="conditions">
                    <span class="cond-pill">Herniated Disc</span>
                    <span class="cond-pill">Spinal Stenosis</span>
                    <span class="cond-pill">Scoliosis</span>
                    <span class="cond-pill">Cervical Disc Disease</span>
                    <span class="cond-pill">Sciatica</span>
                    <span class="cond-pill">Degenerative Disc</span>
                </div>
                <div class="srv-section-cta">
                    <a href="/book-appointment" class="btn btn-solid">Book Consultation</a>
                    <a href="/doctors" class="btn btn-ghost">Meet Our Surgeons</a>
                </div>
            </div>
        </div>
        <div class="sub-cards">
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h4>Lumbar Decompression</h4><p>Minimally invasive laminectomy and discectomy to relieve nerve compression causing leg pain, weakness, and numbness.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div><h4>Cervical Disc Replacement</h4><p>Motion-preserving disc replacement as an alternative to fusion for cervical disc disease, maintaining natural neck movement.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><h4>Spinal Fusion</h4><p>Instrumented fusion to stabilise painful spinal segments using lateral, posterior, or anterior approaches depending on the pathology.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><h4>Scoliosis Correction</h4><p>Spinal deformity correction for adolescent and adult scoliosis, tailored to curve severity and patient functional goals.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div><h4>Epidural Injections</h4><p>Image-guided corticosteroid and nerve block injections to provide rapid, targeted relief for disc-related and facet joint pain.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><h4>Non-Surgical Management</h4><p>Physiotherapy, bracing, activity modification, and pain management programmes before considering any surgical intervention.</p></div>
        </div>
    </div>
</section>

{{-- ════ SERVICE 4 — PHYSIOTHERAPY ════ --}}
<section id="physio" class="srv-section theme-green" aria-labelledby="physio-title">
    <div class="wrap">
        <div class="srv-section-head reverse">
            <div class="srv-img">
                <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=900&q=80"
                    alt="Physiotherapist assisting patient with rehabilitation" loading="lazy"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=80';">
            </div>
            <div class="srv-text">
                <span class="tag" style="background:var(--green-lt);color:var(--green);">Physiotherapy &amp; Rehab</span>
                <h2 class="sec-title" id="physio-title">Physiotherapy &amp; Post-Surgical Rehabilitation</h2>
                <p class="sec-sub">Our physiotherapy team designs evidence-based recovery programmes for post-surgical patients, chronic pain sufferers, and anyone looking to regain full function and independence.</p>
                <div class="conditions">
                    <span class="cond-pill">Post-Op Recovery</span>
                    <span class="cond-pill">Frozen Shoulder</span>
                    <span class="cond-pill">Chronic Joint Pain</span>
                    <span class="cond-pill">Balance Disorders</span>
                    <span class="cond-pill">Muscle Weakness</span>
                    <span class="cond-pill">Work Injuries</span>
                </div>
                <div class="srv-section-cta">
                    <a href="/book-appointment" class="btn btn-solid">Book a Session</a>
                    <a href="/doctors" class="btn btn-ghost">Meet Our Physios</a>
                </div>
            </div>
        </div>
        <div class="sub-cards">
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div><h4>Post-Surgical Rehab</h4><p>Structured, milestone-based recovery protocols after joint replacement, spine surgery, and arthroscopic procedures.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div><h4>Manual Therapy</h4><p>Hands-on joint mobilisation, soft-tissue manipulation, and myofascial release to restore range of motion and reduce pain.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h4>Exercise Prescription</h4><p>Personalised exercise programmes designed to rebuild strength, flexibility, and endurance at a safe, progressive pace.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div><h4>Electrotherapy</h4><p>TENS, ultrasound therapy, and interferential current to reduce pain, swelling, and accelerate tissue healing.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><h4>Gait &amp; Movement Retraining</h4><p>Analysis and correction of abnormal movement patterns to eliminate compensatory habits that cause secondary injury.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div><h4>Home Exercise Programmes</h4><p>Custom take-home exercise plans with video guidance so patients can continue progress between clinic visits.</p></div>
        </div>
    </div>
</section>

{{-- ════ SERVICE 5 — FRACTURE & TRAUMA ════ --}}
<section id="fracture" class="srv-section theme-amber" aria-labelledby="fracture-title">
    <div class="wrap">
        <div class="srv-section-head">
            <div class="srv-img">
                <img src="https://images.unsplash.com/photo-1530026405186-ed1f139313f8?auto=format&fit=crop&w=900&q=80"
                    alt="Orthopedic surgeon examining X-ray of fractured bone" loading="lazy"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1581595219315-a187dd40c322?auto=format&fit=crop&w=900&q=80';">
            </div>
            <div class="srv-text">
                <span class="tag" style="background:#fef3c7;color:#92400e;">Fracture &amp; Trauma</span>
                <h2 class="sec-title" id="fracture-title">Fracture Management &amp; Trauma Surgery</h2>
                <p class="sec-sub">Our 24/7 orthopedic trauma team handles everything from simple breaks to complex multi-fracture injuries, using the most advanced fixation techniques to restore full function.</p>
                <div class="conditions">
                    <span class="cond-pill">Wrist &amp; Hand Fractures</span>
                    <span class="cond-pill">Hip Fractures</span>
                    <span class="cond-pill">Tibial Plateau</span>
                    <span class="cond-pill">Ankle Fractures</span>
                    <span class="cond-pill">Pelvic Injuries</span>
                    <span class="cond-pill">Compound Fractures</span>
                </div>
                <div class="srv-section-cta">
                    <a href="/book-appointment" class="btn btn-solid">Book Consultation</a>
                    <a href="tel:+12125550192" class="btn btn-ghost">Emergency: Call Now</a>
                </div>
            </div>
        </div>
        <div class="sub-cards">
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div><h4>Internal Fixation (ORIF)</h4><p>Open reduction and internal fixation using plates, screws, and nails to anatomically restore fractured bone fragments.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><h4>External Fixation</h4><p>Temporary external frames used for complex open fractures and polytrauma cases to stabilise bone while soft tissue heals.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h4>Intramedullary Nailing</h4><p>Minimally invasive nailing of long bone fractures (femur, tibia, humerus) allowing early weight bearing and mobilisation.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><h4>Fracture Casting &amp; Splinting</h4><p>Expert application and monitoring of casts and splints for stable fractures, with follow-up imaging to confirm healing.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.1 19.79 19.79 0 0 1 1.6 4.55 2 2 0 0 1 3.57 2.37h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.1 6.1l1.63-1.63a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7a2 2 0 0 1 1.72 2.02z"/></svg></div><h4>24 / 7 Emergency Response</h4><p>On-call orthopedic surgeons available around the clock for urgent trauma assessments and emergency procedures.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg></div><h4>Post-Fracture Rehabilitation</h4><p>Structured physiotherapy to rebuild strength, restore function, and prevent long-term stiffness or deformity after fracture.</p></div>
        </div>
    </div>
</section>

{{-- ════ SERVICE 6 — ARTHRITIS ════ --}}
<section id="arthritis" class="srv-section theme-purple" aria-labelledby="arthritis-title">
    <div class="wrap">
        <div class="srv-section-head reverse">
            <div class="srv-img">
                <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=900&q=80"
                    alt="Doctor consulting with elderly patient about arthritis" loading="lazy"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=900&q=80';">
            </div>
            <div class="srv-text">
                <span class="tag" style="background:var(--purple-lt);color:#5b21b6;">Arthritis Management</span>
                <h2 class="sec-title" id="arthritis-title">Arthritis &amp; Joint Inflammation Care</h2>
                <p class="sec-sub">Arthritis doesn't have to mean a life limited by pain. Our multidisciplinary team combines medical management, physiotherapy, and surgical options to keep you moving comfortably.</p>
                <div class="conditions">
                    <span class="cond-pill">Osteoarthritis</span>
                    <span class="cond-pill">Rheumatoid Arthritis</span>
                    <span class="cond-pill">Psoriatic Arthritis</span>
                    <span class="cond-pill">Gout</span>
                    <span class="cond-pill">Ankylosing Spondylitis</span>
                </div>
                <div class="srv-section-cta">
                    <a href="/book-appointment" class="btn btn-solid">Book Consultation</a>
                    <a href="/doctors" class="btn btn-ghost">Meet Our Specialists</a>
                </div>
            </div>
        </div>
        <div class="sub-cards">
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div><h4>Corticosteroid Injections</h4><p>Precise intra-articular steroid injections for rapid, targeted relief of inflammatory joint pain — often effective within 48 hours.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div><h4>Hyaluronic Acid</h4><p>Gel injections that supplement natural joint fluid, reducing friction and pain in arthritic knees and hips for 6–12 months.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></div><h4>Medical Management</h4><p>Evidence-based pharmacological treatment plans including NSAIDs, DMARDs, and biologics in collaboration with rheumatology.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h4>Arthritis Physiotherapy</h4><p>Low-impact strengthening and aquatic therapy programmes specifically designed to maintain joint health and reduce flare-ups.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg></div><h4>Surgical Intervention</h4><p>When conservative treatment is no longer sufficient, our surgeons offer joint replacement, synovectomy, and osteotomy options.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div><h4>Lifestyle &amp; Diet Coaching</h4><p>Personalised guidance on anti-inflammatory nutrition, weight management, and activity modification to slow disease progression.</p></div>
        </div>
    </div>
</section>

{{-- ════ SERVICE 7 — PEDIATRIC ORTHOPEDICS ════ --}}
<section id="pediatric" class="srv-section theme-teal" aria-labelledby="pediatric-title">
    <div class="wrap">
        <div class="srv-section-head">
            <div class="srv-img">
                <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?auto=format&fit=crop&w=900&q=80"
                    alt="Pediatric orthopedic doctor examining a young child" loading="lazy"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=900&q=80';">
            </div>
            <div class="srv-text">
                <span class="tag teal">Pediatric Orthopedics</span>
                <h2 class="sec-title" id="pediatric-title">Children's Bone &amp; Growth Disorder Care</h2>
                <p class="sec-sub">Children's bones require specialist knowledge. Our pediatric orthopedic team provides gentle, family-centred care for every stage of development.</p>
                <div class="conditions">
                    <span class="cond-pill">Clubfoot</span>
                    <span class="cond-pill">Developmental Hip Dysplasia</span>
                    <span class="cond-pill">Scoliosis (Adolescent)</span>
                    <span class="cond-pill">Growth Plate Fractures</span>
                    <span class="cond-pill">Cerebral Palsy Ortho</span>
                    <span class="cond-pill">Flat Feet</span>
                </div>
                <div class="srv-section-cta">
                    <a href="/book-appointment" class="btn btn-solid">Book Consultation</a>
                    <a href="/doctors" class="btn btn-ghost">Meet Dr. Reyes</a>
                </div>
            </div>
        </div>
        <div class="sub-cards">
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><h4>Clubfoot (Ponseti Method)</h4><p>Non-surgical serial casting and bracing for congenital clubfoot, achieving excellent long-term outcomes when started early.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><h4>Developmental Hip Dysplasia</h4><p>Pavlik harness, casting, and surgical correction depending on age and severity, with regular ultrasound and X-ray monitoring.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><h4>Adolescent Idiopathic Scoliosis</h4><p>Observation, Rigo Chêneau bracing, and surgical correction with spinal fusion for progressive curves above 45°.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><h4>Growth Plate Injuries</h4><p>Careful management of physeal fractures in growing children to protect future bone growth and avoid leg length discrepancy.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><h4>Neuromuscular Conditions</h4><p>Orthopedic management for children with cerebral palsy, spina bifida, and muscular dystrophy to maximise mobility.</p></div>
            <div class="sub-card"><div class="sub-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div><h4>Limb Deformity Correction</h4><p>Guided growth techniques and osteotomies to correct bowlegs, knock-knees, and leg length discrepancies during childhood.</p></div>
        </div>
    </div>
</section>

{{-- ════ TREATMENT PROCESS ════ --}}
<section class="process-strip" aria-label="Our treatment process">
    <div class="wrap">
        <span class="tag white">Our Approach</span>
        <h2>How We Deliver Your Care</h2>
        <p>Every patient journey at OrthoCore follows a structured, evidence-based pathway — from first contact to full recovery.</p>
        <div class="process-grid">
            <div class="process-card"><div class="process-num">1</div><h4>Initial Consultation</h4><p>Thorough history and physical exam. We listen first — then we diagnose. Appointments are never rushed.</p></div>
            <div class="process-card"><div class="process-num">2</div><h4>Diagnosis &amp; Imaging</h4><p>On-site X-ray and MRI reporting. Results reviewed the same day where possible, with a clear explanation to the patient.</p></div>
            <div class="process-card"><div class="process-num">3</div><h4>Personalised Treatment Plan</h4><p>A tailored plan built around your diagnosis, goals, lifestyle, and preferences — surgical or non-surgical, we explain every option.</p></div>
            <div class="process-card"><div class="process-num">4</div><h4>Treatment &amp; Follow-Up</h4><p>Continuous monitoring through your recovery with regular check-ins and physiotherapy support until you reach your goals.</p></div>
        </div>
    </div>
</section>

{{-- ════ INSURANCE STRIP ════ --}}
<div class="insurance-strip" aria-label="Insurance providers accepted">
    <div class="wrap">
        <strong>Insurance accepted:</strong>
        <span class="ins-pill">Aetna</span>
        <span class="ins-pill">BlueCross BlueShield</span>
        <span class="ins-pill">Cigna</span>
        <span class="ins-pill">Humana</span>
        <span class="ins-pill">Medicare</span>
        <span class="ins-pill">UnitedHealth</span>
        <span class="ins-pill">Self-pay welcome</span>
    </div>
</div>

{{-- ════ CTA BAND ════ --}}
<section class="cta-band" aria-label="Book appointment call to action">
    <div class="wrap">
        <div>
            <span class="tag white">Get Started Today</span>
            <h2>Ready to Take the First Step?</h2>
            <p>Same-day appointments available. Our care coordinator will confirm your booking within 2 hours of your request.</p>
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
    const sections = document.querySelectorAll('.srv-section[id]');
    const pills    = document.querySelectorAll('.snav-pill');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                pills.forEach(p => { p.classList.toggle('active', p.getAttribute('href') === '#' + id); });
            }
        });
    }, { rootMargin: '-40% 0px -50% 0px' });
    sections.forEach(s => observer.observe(s));
</script>
@endpush
