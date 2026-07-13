@extends('layouts.app')

@section('title', 'OrthoCore Clinic — Orthopedic & Physiotherapy Specialists')

@push('styles')
<style>
    /* ─── HOME: HERO ─── */
    .hero { padding: 48px 0 56px; }
    .hero .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: center; }

    .hero-text .tag { margin-bottom: 14px; }
    .hero-text h1 {
        font-size: clamp(2rem, 4vw, 3.3rem);
        font-weight: 800; letter-spacing: -.025em; line-height: 1.05; margin-bottom: 14px;
    }
    .hero-text h1 em  { font-style: normal; color: var(--blue); }
    .hero-text h1 strong { font-style: normal; color: var(--teal); }
    .hero-text p { color: var(--ink-lt); font-size: 15.5px; margin-bottom: 22px; max-width: 520px; }
    .hero-btns { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px; }

    .hero-trust {
        display: flex; gap: 18px; flex-wrap: wrap;
        border-top: 1px solid var(--border); padding-top: 16px;
    }
    .trust-item { display: flex; align-items: center; gap: 7px; font-size: 13px; font-weight: 600; color: var(--ink-md); }
    .trust-dot  { width: 8px; height: 8px; border-radius: 999px; background: var(--teal); flex-shrink: 0; }

    .hero-visual { position: relative; }
    .hero-card {
        position: relative; border-radius: var(--r-lg); overflow: hidden;
        box-shadow: var(--sh-md); aspect-ratio: 4/3;
        background: linear-gradient(145deg, #cfe3fc 0%, #9cc4ff 100%);
        display: flex; align-items: flex-end; justify-content: flex-start;
    }
    .hero-card img {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
        object-fit: cover; object-position: top center;
    }
    .hero-caption {
        position: relative; z-index: 2;
        margin: 16px; background: rgba(10,20,38,.8);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff; padding: 8px 14px;
        border-radius: 999px; font-size: 12.5px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 7px;
    }
    .pulse { width: 8px; height: 8px; border-radius: 999px; background: #38f8be; flex-shrink: 0; }

    .stat-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 10px; margin-top: 22px; }
    .stat-chip {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--r-sm); padding: 12px 10px; text-align: center;
        box-shadow: var(--sh-sm);
    }
    .stat-chip strong { display: block; font-size: 22px; font-weight: 800; color: var(--blue-dk); line-height: 1; }
    .stat-chip span   { font-size: 12px; color: var(--ink-lt); margin-top: 2px; display: block; }

    /* ─── CONDITIONS STRIP ─── */
    .conditions-strip {
        background: var(--bg-soft);
        border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
    }
    .conditions-strip .wrap {
        padding: 18px 0; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
    }
    .conditions-strip strong { font-size: 13px; color: var(--ink-md); margin-right: 4px; }
    .cond-pill {
        background: var(--white); border: 1px solid var(--border);
        border-radius: 999px; padding: 6px 14px; font-size: 13px; font-weight: 600; color: var(--ink-md);
        transition: background .15s, color .15s;
    }
    .cond-pill:hover { background: var(--blue-lt); color: var(--blue); }

    /* ─── SERVICES ─── */
    .services { background: var(--bg-soft); }
    .services-header { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap; margin-bottom: 24px; }
    .services-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
    .srv-card {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--r-md); padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .srv-card:hover { transform: translateY(-6px) scale(1.01); box-shadow: var(--sh-md); border-color: rgba(18, 83, 200, 0.2); }
    .srv-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: grid; place-items: center;
        font-size: 18px; font-weight: 900; margin-bottom: 12px; color: var(--white);
    }
    .c1 { background: linear-gradient(135deg,#1253c8,#5d90f8); }
    .c2 { background: linear-gradient(135deg,#0ba199,#4fd3cc); }
    .c3 { background: linear-gradient(135deg,#e95d44,#f39584); }
    .c4 { background: linear-gradient(135deg,#f59b1a,#f8c66f); }
    .c5 { background: linear-gradient(135deg,#7c3aed,#a78bfa); }
    .c6 { background: linear-gradient(135deg,#0f7b5e,#34d399); }
    .srv-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
    .srv-card p  { font-size: 13.5px; color: var(--ink-lt); line-height: 1.6; }
    .srv-link { display: inline-flex; align-items: center; gap: 5px; margin-top: 10px; font-size: 13px; font-weight: 700; color: var(--blue); }
    .srv-link:hover { text-decoration: underline; }

    /* ─── WHY US ─── */
    .why .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 28px; align-items: center; }
    .why-img {
        border-radius: var(--r-lg); overflow: hidden; box-shadow: var(--sh-md);
        aspect-ratio: 1/1;
        background: linear-gradient(145deg, #d6e9ff, #9cc4ff);
        display: flex; align-items: center; justify-content: center;
    }
    .feat-list { display: grid; gap: 14px; margin-top: 18px; }
    .feat {
        display: flex; gap: 12px; align-items: flex-start;
        background: var(--bg-soft); border: 1px solid var(--border);
        border-radius: var(--r-sm); padding: 14px; transition: box-shadow .2s;
    }
    .feat:hover { box-shadow: var(--sh-sm); }
    .feat-ico { flex-shrink: 0; width: 36px; height: 36px; border-radius: 9px; display: grid; place-items: center; font-size: 15px; }
    .feat-ico.b { background: var(--blue-lt); color: var(--blue); }
    .feat-ico.t { background: var(--teal-lt); color: var(--teal); }
    .feat h4 { font-size: 14.5px; font-weight: 700; margin-bottom: 3px; }
    .feat p   { font-size: 13px; color: var(--ink-lt); }

    /* ─── DOCTORS (HOME) ─── */
    .doctors { background: var(--bg-soft); }
    .doctor-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-top: 24px; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1024px) {
        .hero .wrap, .why .wrap { grid-template-columns: 1fr; }
        .services-grid, .doctor-grid { grid-template-columns: repeat(2,1fr); }
        .stat-row { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 640px) {
        .services-grid, .doctor-grid { grid-template-columns: 1fr; }
        .stat-row { grid-template-columns: repeat(2,1fr); }
        .hero-card { aspect-ratio: 5/4; }
    }
</style>
@endpush

@section('content')

{{-- ════ HERO ════ --}}
<section class="hero" aria-label="Hero section">
    <div class="wrap">
        <div class="hero-text">
            <span class="tag">Orthopedic &amp; Physiotherapy Care · New York</span>
            <h1>Get Back to <em>Moving</em> the Way You <strong>Love</strong></h1>
            <p>Whether it's a sports injury, chronic joint pain, or post-surgery recovery — our specialists build a treatment plan around your body, your goals, and your life.</p>
            <div class="hero-btns">
                <a href="/book-appointment" class="btn btn-solid">Book Free Consultation</a>
                <a href="#services" class="btn btn-ghost">See All Treatments</a>
            </div>
            <div class="hero-trust">
                <div class="trust-item"><span class="trust-dot"></span> 15,000+ patients treated</div>
                <div class="trust-item"><span class="trust-dot"></span> Same-day appointments</div>
                <div class="trust-item"><span class="trust-dot"></span> 12 specialist doctors</div>
            </div>
            <div class="stat-row" aria-label="Key clinic statistics">
                <div class="stat-chip"><strong>25+</strong><span>Years of Practice</span></div>
                <div class="stat-chip"><strong>98%</strong><span>Patient Satisfaction</span></div>
                <div class="stat-chip"><strong>12</strong><span>Specialists</span></div>
                <div class="stat-chip"><strong>24/7</strong><span>Emergency Care</span></div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card">
                <img
                    src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=900&q=85"
                    alt="Female orthopedic doctor in a white coat with stethoscope"
                    loading="eager"
                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=900&q=85';"
                    style="object-position: center top;">
                <div class="hero-caption">
                    <span class="pulse"></span>
                    Our orthopedic specialist team, New York
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ CONDITIONS STRIP ════ --}}
<div class="conditions-strip" aria-label="Conditions we treat">
    <div class="wrap">
        <strong>We treat:</strong>
        <a href="#services" class="cond-pill">Back Pain</a>
        <a href="#services" class="cond-pill">Knee Pain</a>
        <a href="#services" class="cond-pill">Frozen Shoulder</a>
        <a href="#services" class="cond-pill">ACL / Sports Injury</a>
        <a href="#services" class="cond-pill">Hip Replacement</a>
        <a href="#services" class="cond-pill">Arthritis</a>
        <a href="#services" class="cond-pill">Fractures</a>
        <a href="#services" class="cond-pill">Post-Surgery Rehab</a>
        <a href="#services" class="cond-pill">Scoliosis</a>
    </div>
</div>

{{-- ════ SERVICES ════ --}}
<section class="services sec" id="services" aria-label="Our services">
    <div class="wrap">
        <div class="services-header">
            <div>
                <span class="tag">Our Services</span>
                <h2 class="sec-title">Complete Orthopedic &amp; Physio Solutions</h2>
                <p class="sec-sub">Every treatment plan is built around your exact condition, lifestyle, and recovery goal.</p>
            </div>
            <a href="/services" class="btn btn-ghost">View All Services</a>
        </div>
        <div class="services-grid">
            <article class="srv-card">
                <div class="srv-icon c1">JR</div>
                <h3>Joint Replacement</h3>
                <p>Minimally invasive hip, knee, and shoulder replacement with guided post-op recovery for faster return to normal.</p>
                <a href="/services#joint" class="srv-link">Learn more →</a>
            </article>
            <article class="srv-card">
                <div class="srv-icon c2">SM</div>
                <h3>Sports Medicine</h3>
                <p>Injury assessment and performance rehabilitation for athletes — ACL, rotator cuff, tendon injuries, and more.</p>
                <a href="/services#sports" class="srv-link">Learn more →</a>
            </article>
            <article class="srv-card">
                <div class="srv-icon c3">SC</div>
                <h3>Spine &amp; Neck Care</h3>
                <p>Evidence-based treatment for herniated discs, sciatica, spondylitis, and chronic back and neck pain.</p>
                <a href="/services#spine" class="srv-link">Learn more →</a>
            </article>
            <article class="srv-card">
                <div class="srv-icon c4">FT</div>
                <h3>Fracture &amp; Trauma</h3>
                <p>Rapid fracture assessment and immobilization care with 24-hour emergency consultation coverage.</p>
                <a href="/services#fracture" class="srv-link">Learn more →</a>
            </article>
            <article class="srv-card">
                <div class="srv-icon c5">PR</div>
                <h3>Physiotherapy &amp; Rehab</h3>
                <p>Goal-driven physio programs that rebuild strength, restore range of motion, and reduce chronic pain.</p>
                <a href="/services#physio" class="srv-link">Learn more →</a>
            </article>
            <article class="srv-card">
                <div class="srv-icon c6">AM</div>
                <h3>Arthritis Management</h3>
                <p>Long-term mobility and pain management for rheumatoid and osteoarthritis using injections and lifestyle plans.</p>
                <a href="/services#arthritis" class="srv-link">Learn more →</a>
            </article>
        </div>
    </div>
</section>

{{-- ════ WHY US ════ --}}
<section class="why sec" id="why-us" aria-label="Why choose us">
    <div class="wrap">
        <div class="why-img">
            <svg viewBox="0 0 440 440" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="width:70%;opacity:.85;">
                <rect x="20" y="200" width="400" height="220" rx="8" fill="#e2ecfb"/>
                <rect x="20" y="200" width="400" height="8" fill="#b6cef5"/>
                <rect x="60" y="260" width="200" height="50" rx="10" fill="#fff" stroke="#b6cef5" stroke-width="3"/>
                <rect x="60" y="250" width="200" height="18" rx="8" fill="#e9f2ff"/>
                <rect x="75" y="310" width="12" height="30" rx="4" fill="#9ab8e0"/>
                <rect x="233" y="310" width="12" height="30" rx="4" fill="#9ab8e0"/>
                <rect x="295" y="220" width="16" height="140" rx="6" fill="#9ab8e0"/>
                <circle cx="303" cy="218" r="22" fill="#fff" stroke="#b6cef5" stroke-width="3"/>
                <rect x="293" y="360" width="36" height="10" rx="4" fill="#7aa2d0"/>
                <rect x="300" y="40" width="100" height="80" rx="8" fill="#dff1ff" stroke="#b6cef5" stroke-width="3"/>
                <line x1="350" y1="40" x2="350" y2="120" stroke="#b6cef5" stroke-width="2"/>
                <line x1="300" y1="80" x2="400" y2="80" stroke="#b6cef5" stroke-width="2"/>
                <circle cx="90" cy="80" r="36" fill="#1253c8"/>
                <rect x="81" y="64" width="18" height="32" rx="6" fill="#fff"/>
                <rect x="74" y="71" width="32" height="18" rx="6" fill="#fff"/>
            </svg>
        </div>
        <div>
            <span class="tag teal">Why OrthoCore</span>
            <h2 class="sec-title">Care That's Built Around You, Not a Protocol</h2>
            <p class="sec-sub">We skip the cookie-cutter approach. Every patient gets a direct conversation with their specialist before any treatment begins.</p>
            <div class="feat-list">
                <div class="feat">
                    <div class="feat-ico b">✓</div>
                    <div>
                        <h4>Fellowship-Trained Surgeons &amp; Physios</h4>
                        <p>Every clinician is subspecialty trained — you'll never see a generalist for an ortho problem.</p>
                    </div>
                </div>
                <div class="feat">
                    <div class="feat-ico t">⟳</div>
                    <div>
                        <h4>Same-Week Appointments, Always</h4>
                        <p>Pain shouldn't wait. We keep capacity open for rapid access, including walk-ins.</p>
                    </div>
                </div>
                <div class="feat">
                    <div class="feat-ico b">◎</div>
                    <div>
                        <h4>On-Site Diagnostics &amp; Imaging</h4>
                        <p>X-ray, MRI, and ultrasound — no referrals to external labs, no wasted days.</p>
                    </div>
                </div>
                <div class="feat">
                    <div class="feat-ico t">♡</div>
                    <div>
                        <h4>Follow-Up Included in Every Plan</h4>
                        <p>We track your recovery milestones and adjust your plan as you heal — not just at discharge.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ DOCTORS ════ --}}
<section class="doctors sec" id="doctors" aria-label="Our specialist doctors">
    <div class="wrap">
        <span class="tag">Meet the Team</span>
        <h2 class="sec-title">Your Specialists</h2>
        <p class="sec-sub">Real doctors, real conversations. Every patient meets their specialist directly — no nurse-only appointments.</p>
        <div class="doctor-grid">
            <article class="doc-card">
                <div class="doc-top d1"><div class="doc-avatar">SM</div></div>
                <div class="doc-body">
                    <h3>Dr. Sarah Mitchell, MD</h3>
                    <p class="doc-spec">Joint Replacement &amp; Reconstruction</p>
                    <p class="doc-meta">18 years · Harvard Medical School · 6,000+ surgeries</p>
                </div>
            </article>
            <article class="doc-card">
                <div class="doc-top d2"><div class="doc-avatar">JO</div></div>
                <div class="doc-body">
                    <h3>Dr. James Okafor, MD</h3>
                    <p class="doc-spec">Sports Medicine &amp; Arthroscopy</p>
                    <p class="doc-meta">14 years · Johns Hopkins · Team physician for NY clubs</p>
                </div>
            </article>
            <article class="doc-card">
                <div class="doc-top d3"><div class="doc-avatar">PS</div></div>
                <div class="doc-body">
                    <h3>Dr. Priya Sharma, MD</h3>
                    <p class="doc-spec">Spine Surgery &amp; Pain Management</p>
                    <p class="doc-meta">20 years · Mayo Clinic Fellowship · Spinal deformity specialist</p>
                </div>
            </article>
        </div>
        <div style="margin-top:20px;text-align:center;">
            <a href="/doctors" class="btn btn-ghost">View All Doctors</a>
        </div>
    </div>
</section>

{{-- ════ TESTIMONIALS ════ --}}
<section class="sec" id="testimonials" style="background:var(--bg-soft);border-top:1px solid var(--border);border-bottom:1px solid var(--border);" aria-label="Patient reviews">
    <div class="wrap">
        <span class="tag">Patient Reviews</span>
        <h2 class="sec-title">Heard Directly From Our Patients</h2>
        <p class="sec-sub">We let our patients do the talking — unedited, genuine recovery stories.</p>
        <div class="testi-grid">
            <div class="testi">
                <div class="stars">★★★★★</div>
                <blockquote>"After my knee replacement, I was hiking again in three months. Dr. Mitchell's team explained every step clearly — no surprises, just results."</blockquote>
                <div class="testi-author">
                    <div class="testi-ava ta1">RK</div>
                    <div><div class="testi-name">Robert K.</div><div class="testi-role">Total Knee Replacement Patient</div></div>
                </div>
            </div>
            <div class="testi">
                <div class="stars">★★★★★</div>
                <blockquote>"I tore my ACL mid-season and genuinely thought it was over. Dr. Okafor had me back on the field two weeks ahead of schedule. Truly exceptional."</blockquote>
                <div class="testi-author">
                    <div class="testi-ava ta2">AJ</div>
                    <div><div class="testi-name">Amara J.</div><div class="testi-role">ACL Reconstruction Patient</div></div>
                </div>
            </div>
            <div class="testi">
                <div class="stars">★★★★★</div>
                <blockquote>"Twelve months of back pain solved in six weeks. Dr. Sharma listened properly, diagnosed correctly, and my recovery has been night-and-day different."</blockquote>
                <div class="testi-author">
                    <div class="testi-ava ta3">TW</div>
                    <div><div class="testi-name">Thomas W.</div><div class="testi-role">Spinal Decompression Patient</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ APPOINTMENT BAND ════ --}}
<section class="appt-band sec" id="appointment" aria-label="Book an appointment">
    <div class="wrap">
        <div>
            <span class="tag white">Book an Appointment</span>
            <h2 class="sec-title">Start Your Recovery Today</h2>
            <p class="sec-sub">Share your details. Our care coordinator will call you within 2 hours to confirm a convenient time.</p>
        </div>
        <form method="POST" action="{{ route('enquiries.store') }}" class="appt-form" novalidate>
            @csrf
            <input name="name" type="text" placeholder="Full Name" required aria-label="Full name">
            <input name="phone" type="tel" placeholder="Phone Number" required aria-label="Phone number">
            <input name="email" type="email" placeholder="Email Address" aria-label="Email address">
            <select name="service" required aria-label="Select a service">
                <option value="" disabled selected>Select a Service</option>
                <option>Joint Replacement</option>
                <option>Sports Medicine</option>
                <option>Spine &amp; Neck Care</option>
                <option>Fracture &amp; Trauma</option>
                <option>Physiotherapy &amp; Rehab</option>
                <option>Arthritis Management</option>
            </select>
            <textarea name="message" placeholder="Tell us about your concern" required aria-label="Your message"></textarea>
            <button type="submit">Request My Appointment →</button>
        </form>
    </div>
</section>

@endsection
