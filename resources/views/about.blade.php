@extends('layouts.app')

@section('title', 'About Us — OrthoCore Clinic')

@push('styles')
<style>
    /* ─── ABOUT: PAGE HERO ─── */
    .page-hero {
        background:
            radial-gradient(circle at 0% 50%, rgba(11,161,153,.18), transparent 35%),
            radial-gradient(circle at 100% 0%, rgba(18,83,200,.18), transparent 32%),
            linear-gradient(135deg, #0d3e9c 0%, #1253c8 55%, #0ba199 100%);
        color: #fff; padding: 52px 0 48px;
    }
    .page-hero .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
    .page-hero h1 {
        font-size: clamp(1.9rem, 3.5vw, 3rem);
        font-weight: 800; letter-spacing: -.02em; line-height: 1.1; margin-bottom: 14px;
    }
    .page-hero p { color: rgba(255,255,255,.85); font-size: 15.5px; max-width: 500px; margin-bottom: 22px; }

    /* ─── MISSION STRIP ─── */
    .mission-strip { background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
    .mission-strip .wrap { display: grid; grid-template-columns: repeat(4,1fr); padding: 0; }
    .mission-item { padding: 28px 24px; border-right: 1px solid var(--border); display: flex; flex-direction: column; gap: 6px; }
    .mission-item:last-child { border-right: none; }
    .mission-num { font-size: 28px; font-weight: 800; line-height: 1; }
    .mission-num.blue  { color: var(--blue); }
    .mission-num.teal  { color: var(--teal); }
    .mission-num.coral { color: var(--coral); }
    .mission-num.amber { color: var(--amber); }
    .mission-label { font-size: 13px; color: var(--ink-lt); font-weight: 600; }

    /* ─── STORY ─── */
    .story .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 52px; align-items: center; }
    .story-img { border-radius: var(--r-lg); overflow: hidden; box-shadow: var(--sh-md); aspect-ratio: 1; }
    .story-img img { width: 100%; height: 100%; object-fit: cover; }
    .story-text p { color: var(--ink-lt); font-size: 15px; margin-bottom: 14px; line-height: 1.75; }
    .story-text p:last-of-type { margin-bottom: 22px; }

    /* ─── VALUES ─── */
    .values { background: var(--bg-soft); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
    .values-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-top: 28px; }
    .val-card {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--r-md); padding: 22px;
        transition: transform .2s, box-shadow .2s;
    }
    .val-card:hover { transform: translateY(-4px); box-shadow: var(--sh-md); }
    .val-icon { width: 44px; height: 44px; border-radius: 12px; display: grid; place-items: center; margin-bottom: 12px; }
    .vi1 { background: var(--blue-lt);   color: var(--blue); }
    .vi2 { background: var(--teal-lt);   color: var(--teal); }
    .vi3 { background: #fff0ee;          color: var(--coral); }
    .vi4 { background: #fffbea;          color: var(--amber); }
    .vi5 { background: #f3f0ff;          color: var(--purple); }
    .vi6 { background: #edfff8;          color: var(--green); }
    .val-card h3 { font-size: 15.5px; font-weight: 700; margin-bottom: 6px; }
    .val-card p  { font-size: 13.5px; color: var(--ink-lt); line-height: 1.65; }

    /* ─── TEAM ─── */
    .team-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-top: 28px; }
    .doc-img { width: 100%; height: 100%; object-fit: cover; object-position: center top; }

    /* ─── TIMELINE ─── */
    .timeline { margin-top: 28px; position: relative; }
    .timeline::before { content: ''; position: absolute; left: 22px; top: 0; bottom: 0; width: 2px; background: var(--border); }
    .tl-item { display: flex; gap: 22px; margin-bottom: 28px; position: relative; }
    .tl-dot {
        flex-shrink: 0; width: 46px; height: 46px; border-radius: 999px;
        display: grid; place-items: center;
        font-size: 13px; font-weight: 800; color: var(--white); position: relative; z-index: 1;
    }
    .tl-dot.blue  { background: linear-gradient(135deg,var(--blue),var(--teal)); }
    .tl-dot.coral { background: linear-gradient(135deg,var(--coral),var(--amber)); }
    .tl-year { font-size: 13px; font-weight: 800; color: var(--blue); margin-bottom: 3px; }
    .tl-body h4 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
    .tl-body p  { font-size: 13.5px; color: var(--ink-lt); }

    /* ─── ACCREDITATIONS ─── */
    .accred-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-top: 28px; }
    .accred-card {
        background: var(--bg-soft); border: 1px solid var(--border);
        border-radius: var(--r-sm); padding: 18px 14px; text-align: center;
        transition: box-shadow .2s;
    }
    .accred-card:hover { box-shadow: var(--sh-sm); }
    .accred-icon { width: 52px; height: 52px; border-radius: 14px; display: grid; place-items: center; margin: 0 auto 14px; background: var(--blue-lt); color: var(--blue); }
    .accred-card:nth-child(2) .accred-icon { background: var(--teal-lt);   color: var(--teal); }
    .accred-card:nth-child(3) .accred-icon { background: #fef3c7;           color: #92400e; }
    .accred-card:nth-child(4) .accred-icon { background: var(--purple-lt); color: var(--purple); }
    .accred-card h4 { font-size: 13px; font-weight: 700; margin-bottom: 4px; }
    .accred-card p  { font-size: 12px; color: var(--ink-lt); }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1024px) {
        .page-hero .wrap, .story .wrap { grid-template-columns: 1fr; }
        .page-hero-img { display: none; }
        .mission-strip .wrap { grid-template-columns: repeat(2,1fr); }
        .values-grid, .team-grid { grid-template-columns: repeat(2,1fr); }
        .accred-grid { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 640px) {
        .values-grid, .team-grid { grid-template-columns: 1fr; }
        .mission-strip .wrap { grid-template-columns: 1fr 1fr; }
        .accred-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')

{{-- ════ PAGE HERO ════ --}}
<section class="page-hero" aria-label="About page hero">
    <div class="wrap">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="/">Home</a>
                <span>/</span>
                <span>About Us</span>
            </nav>
            <span class="tag white">Est. 1999 · New York</span>
            <h1>We've Been Helping People Move Better for Over 25 Years</h1>
            <p>OrthoCore was founded on one belief: every patient deserves a specialist who listens, diagnoses accurately, and builds a plan that fits their real life — not just a textbook protocol.</p>
            <a href="#our-story" class="btn btn-ghost" style="border-color:rgba(255,255,255,.45);color:#fff;background:rgba(255,255,255,.12);">Read Our Story</a>
        </div>
        <div class="page-hero-img">
            <img
                src="https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=900&q=85"
                alt="Orthopedic team in a modern clinic"
                loading="eager"
                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=85'">
        </div>
    </div>
</section>

{{-- ════ MISSION NUMBERS ════ --}}
<div class="mission-strip" aria-label="Key clinic figures">
    <div class="wrap">
        <div class="mission-item">
            <span class="mission-num blue">15,000+</span>
            <span class="mission-label">Patients Successfully Treated</span>
        </div>
        <div class="mission-item">
            <span class="mission-num teal">25+</span>
            <span class="mission-label">Years of Specialist Practice</span>
        </div>
        <div class="mission-item">
            <span class="mission-num coral">98%</span>
            <span class="mission-label">Patient Satisfaction Rate</span>
        </div>
        <div class="mission-item">
            <span class="mission-num amber">12</span>
            <span class="mission-label">Fellowship-Trained Specialists</span>
        </div>
    </div>
</div>

{{-- ════ OUR STORY ════ --}}
<section class="story sec" id="our-story" aria-label="Our story">
    <div class="wrap">
        <div class="story-img">
            <img
                src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=800&q=85"
                alt="Doctors discussing a patient case in a clinic corridor"
                loading="lazy"
                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1504813184591-01572f98c85f?auto=format&fit=crop&w=800&q=85'">
        </div>
        <div class="story-text">
            <span class="tag teal">Our Story</span>
            <h2 class="sec-title">Started Small, Built on Patient Trust</h2>
            <p>OrthoCore Clinic opened in 1999 with a small team of three orthopedic surgeons and a single physiotherapy bay. Our founding principle was straightforward: no patient should leave a clinic without a clear understanding of their diagnosis and a realistic recovery plan.</p>
            <p>Over two and a half decades, we've grown into a full-service orthopedic and physiotherapy centre — but our approach hasn't changed. Every appointment still begins with a conversation, not a scan order. We take time to understand how your condition affects your daily routine, your sport, or your work, and we build around that.</p>
            <p>Today, our team of 12 specialists handles everything from emergency fractures and sports injuries to complex joint reconstructions and long-term arthritis management — all under one roof in Midtown New York.</p>
            <a href="/book-appointment" class="btn btn-solid">Book a Consultation</a>
        </div>
    </div>
</section>

{{-- ════ VALUES ════ --}}
<section class="values sec" aria-label="Our values">
    <div class="wrap">
        <span class="tag">What Guides Us</span>
        <h2 class="sec-title">Our Core Values</h2>
        <p class="sec-sub">Everything we do — from how we answer the phone to how we plan a surgery — is shaped by these principles.</p>
        <div class="values-grid">
            <div class="val-card">
                <div class="val-icon vi1"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/><line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/></svg></div>
                <h3>Diagnosis First</h3>
                <p>We don't recommend treatment until we fully understand what's wrong. Accurate diagnosis is the foundation of everything.</p>
            </div>
            <div class="val-card">
                <div class="val-icon vi2"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                <h3>Honest Communication</h3>
                <p>We tell patients what they need to hear, not what sounds reassuring. Realistic expectations lead to better outcomes.</p>
            </div>
            <div class="val-card">
                <div class="val-icon vi3"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
                <h3>Patient-Centred Care</h3>
                <p>Your goals, your timeline, your life. Treatment plans are shaped around you — not the other way around.</p>
            </div>
            <div class="val-card">
                <div class="val-icon vi4"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <h3>No Unnecessary Delays</h3>
                <p>Pain and injury shouldn't wait weeks for a slot. We maintain open capacity for rapid access at every stage of care.</p>
            </div>
            <div class="val-card">
                <div class="val-icon vi5"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M14.5 3h-5L7 9l-4 10a1 1 0 0 0 .9 1.4h14.2a1 1 0 0 0 .9-1.4L15 9z"/><line x1="6" y1="9" x2="18" y2="9"/></svg></div>
                <h3>Evidence-Based Practice</h3>
                <p>Every clinical decision is backed by current research and peer-reviewed outcomes. No guesswork, no shortcuts.</p>
            </div>
            <div class="val-card">
                <div class="val-icon vi6"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
                <h3>Continuous Improvement</h3>
                <p>We measure our outcomes, review our results, and regularly update our practices to reflect the best available care.</p>
            </div>
        </div>
    </div>
</section>

{{-- ════ TEAM ════ --}}
<section class="sec" style="background:var(--bg-soft);border-top:1px solid var(--border);" aria-label="Our specialist team" id="team">
    <div class="wrap">
        <span class="tag">Meet the Team</span>
        <h2 class="sec-title">The People Behind Your Recovery</h2>
        <p class="sec-sub">Every specialist on our team is fellowship-trained in their subspecialty. You'll always see someone who knows your condition inside-out.</p>
        <div class="team-grid">
            <article class="doc-card">
                <div class="doc-top d1">
                    <img class="doc-img"
                        src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80"
                        alt="Dr. Sarah Mitchell"
                        onerror="this.style.display='none';this.parentNode.innerHTML+='<div class=\'doc-avatar\'>SM</div>'">
                </div>
                <div class="doc-body">
                    <h3>Dr. Sarah Mitchell, MD</h3>
                    <p class="doc-spec">Joint Replacement &amp; Reconstruction</p>
                    <p class="doc-meta">Harvard Medical School · 6,000+ surgeries performed</p>
                    <span class="doc-exp">18 yrs experience</span>
                </div>
            </article>
            <article class="doc-card">
                <div class="doc-top d2"><div class="doc-avatar">JO</div></div>
                <div class="doc-body">
                    <h3>Dr. James Okafor, MD</h3>
                    <p class="doc-spec">Sports Medicine &amp; Arthroscopy</p>
                    <p class="doc-meta">Johns Hopkins University · Team physician, NY clubs</p>
                    <span class="doc-exp">14 yrs experience</span>
                </div>
            </article>
            <article class="doc-card">
                <div class="doc-top d3"><div class="doc-avatar">PS</div></div>
                <div class="doc-body">
                    <h3>Dr. Priya Sharma, MD</h3>
                    <p class="doc-spec">Spine Surgery &amp; Pain Management</p>
                    <p class="doc-meta">Mayo Clinic Fellowship · Spinal deformity specialist</p>
                    <span class="doc-exp">20 yrs experience</span>
                </div>
            </article>
            <article class="doc-card">
                <div class="doc-top d4"><div class="doc-avatar">DK</div></div>
                <div class="doc-body">
                    <h3>Dr. David Kim, MD</h3>
                    <p class="doc-spec">Pediatric Orthopedics</p>
                    <p class="doc-meta">Columbia University · Scoliosis &amp; growth plate specialist</p>
                    <span class="doc-exp">12 yrs experience</span>
                </div>
            </article>
            <article class="doc-card">
                <div class="doc-top d5"><div class="doc-avatar">RN</div></div>
                <div class="doc-body">
                    <h3>Dr. Rachel Nwosu, DPT</h3>
                    <p class="doc-spec">Lead Physiotherapist &amp; Rehab Director</p>
                    <p class="doc-meta">NYU Langone · Post-surgical rehab specialist</p>
                    <span class="doc-exp">10 yrs experience</span>
                </div>
            </article>
            <article class="doc-card">
                <div class="doc-top d6"><div class="doc-avatar">MA</div></div>
                <div class="doc-body">
                    <h3>Dr. Michael Adeyemi, MD</h3>
                    <p class="doc-spec">Hand &amp; Upper Limb Surgery</p>
                    <p class="doc-meta">Stanford Medicine · Microsurgery fellowship</p>
                    <span class="doc-exp">16 yrs experience</span>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- ════ TIMELINE ════ --}}
<section class="sec" aria-label="Clinic milestones">
    <div class="wrap">
        <span class="tag coral">Our Journey</span>
        <h2 class="sec-title">25 Years of Milestones</h2>
        <p class="sec-sub">A brief look at how OrthoCore grew from a small practice into one of New York's most trusted orthopedic clinics.</p>
        <div class="timeline">
            <div class="tl-item">
                <div class="tl-dot blue">99</div>
                <div class="tl-body">
                    <div class="tl-year">1999 — Founded</div>
                    <h4>OrthoCore Opens Its Doors</h4>
                    <p>Dr. Mitchell and two colleagues open a three-room orthopedic practice in Midtown Manhattan with a focus on joint health and sports injuries.</p>
                </div>
            </div>
            <div class="tl-item">
                <div class="tl-dot coral">05</div>
                <div class="tl-body">
                    <div class="tl-year">2005 — Expansion</div>
                    <h4>Physiotherapy Wing Added</h4>
                    <p>Growing demand for post-surgical rehabilitation leads to the creation of a dedicated in-house physio department, staffed by three specialist therapists.</p>
                </div>
            </div>
            <div class="tl-item">
                <div class="tl-dot blue">10</div>
                <div class="tl-body">
                    <div class="tl-year">2010 — Technology</div>
                    <h4>On-Site MRI &amp; Digital Imaging</h4>
                    <p>Investment in in-house imaging eliminates referral delays, allowing same-day diagnosis and faster treatment planning for all patients.</p>
                </div>
            </div>
            <div class="tl-item">
                <div class="tl-dot coral">17</div>
                <div class="tl-body">
                    <div class="tl-year">2017 — Innovation</div>
                    <h4>Robotic-Assisted Surgery Introduced</h4>
                    <p>OrthoCore becomes one of the first clinics in New York to offer robotic-assisted joint replacement, improving precision and cutting recovery time by 30%.</p>
                </div>
            </div>
            <div class="tl-item">
                <div class="tl-dot blue">24</div>
                <div class="tl-body">
                    <div class="tl-year">2024 — Today</div>
                    <h4>12 Specialists, 15,000+ Patients Served</h4>
                    <p>OrthoCore now operates across two floors with 12 specialists, same-week appointments, and a 98% patient satisfaction rate across all departments.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════ ACCREDITATIONS ════ --}}
<section class="sec" style="background:var(--bg-soft);border-top:1px solid var(--border);border-bottom:1px solid var(--border);" aria-label="Accreditations">
    <div class="wrap">
        <span class="tag">Trusted &amp; Accredited</span>
        <h2 class="sec-title">Certifications &amp; Affiliations</h2>
        <p class="sec-sub">Our clinical standards are independently verified and regularly reviewed.</p>
        <div class="accred-grid">
            <div class="accred-card">
                <div class="accred-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
                <h4>AAOS Certified</h4>
                <p>American Academy of Orthopaedic Surgeons member practice</p>
            </div>
            <div class="accred-card">
                <div class="accred-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
                <h4>HIPAA Compliant</h4>
                <p>Fully compliant patient data protection across all systems</p>
            </div>
            <div class="accred-card">
                <div class="accred-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg></div>
                <h4>Joint Commission Accredited</h4>
                <p>Nationally recognised quality and patient safety standards</p>
            </div>
            <div class="accred-card">
                <div class="accred-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="22" height="22"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div>
                <h4>Teaching Affiliate</h4>
                <p>Affiliated residency and fellowship program with NYU Langone</p>
            </div>
        </div>
    </div>
</section>

{{-- ════ APPOINTMENT BAND ════ --}}
<section class="appt-band sec" id="appointment" aria-label="Book an appointment">
    <div class="wrap">
        <div>
            <span class="tag white">Book an Appointment</span>
            <h2 class="sec-title">Ready to Start Your Recovery?</h2>
            <p class="sec-sub">Tell us your concern and our care coordinator will call you back within 2 hours to confirm your appointment.</p>
        </div>
        <form class="appt-form" onsubmit="handleBooking(event)" novalidate>
            <input type="text"  placeholder="Full Name"     required aria-label="Full name">
            <input type="tel"   placeholder="Phone Number"  required aria-label="Phone number">
            <input type="email" placeholder="Email Address"          aria-label="Email address">
            <select required aria-label="Select a service">
                <option value="" disabled selected>Select a Service</option>
                <option>Joint Replacement</option>
                <option>Sports Medicine</option>
                <option>Spine &amp; Neck Care</option>
                <option>Fracture &amp; Trauma</option>
                <option>Physiotherapy &amp; Rehab</option>
                <option>Arthritis Management</option>
            </select>
            <button type="submit">Request My Appointment →</button>
        </form>
    </div>
</section>

@endsection
