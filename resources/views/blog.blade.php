@extends('layouts.app')

@section('title', 'Blog & Patient Resources — OrthoCore Clinic')

@push('styles')
<style>
    /* ─── BLOG: PAGE HERO ─── */
    .page-hero {
        background: linear-gradient(140deg, var(--blue-dk) 0%, var(--blue) 50%, var(--teal) 100%);
        padding: 56px 0 48px; color: #fff;
    }
    .page-hero .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
    .page-hero h1 { font-size: clamp(1.9rem, 3.5vw, 2.8rem); font-weight: 800; letter-spacing: -.025em; line-height: 1.1; margin-bottom: 12px; color: #fff; }
    .page-hero p  { color: rgba(255,255,255,.85); font-size: 15.5px; max-width: 560px; margin-bottom: 24px; }

    /* ─── BLOG LAYOUT ─── */
    .blog-section { padding: 56px 0; }
    .blog-layout { display: grid; grid-template-columns: 1fr 320px; gap: 32px; align-items: start; }

    /* ─── FEATURED ARTICLE ─── */
    .featured-card {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--r-lg); overflow: hidden;
        transition: transform .2s, box-shadow .2s; margin-bottom: 24px;
    }
    .featured-card:hover { transform: translateY(-4px); box-shadow: var(--sh-md); }
    .featured-img { aspect-ratio: 16/7; overflow: hidden; }
    .featured-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .featured-card:hover .featured-img img { transform: scale(1.03); }
    .featured-body { padding: 28px 28px 24px; }
    .featured-body .article-meta { margin-bottom: 12px; }
    .featured-body h2 { font-size: clamp(1.3rem, 2.2vw, 1.7rem); font-weight: 800; letter-spacing: -.01em; line-height: 1.2; margin-bottom: 10px; }
    .featured-body h2 a { color: var(--ink); transition: color .15s; }
    .featured-body h2 a:hover { color: var(--blue); }
    .featured-body p { font-size: 15px; color: var(--ink-lt); line-height: 1.7; margin-bottom: 18px; max-width: 680px; }
    .featured-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--blue-lt); color: var(--blue-dk);
        font-size: 11px; font-weight: 800; letter-spacing: .05em; text-transform: uppercase;
        padding: 4px 10px; border-radius: 999px; margin-bottom: 6px;
    }

    /* ─── ARTICLE GRID ─── */
    .article-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
    .article-card {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--r-md); overflow: hidden;
        transition: transform .2s, box-shadow .2s; display: flex; flex-direction: column;
    }
    .article-card:hover { transform: translateY(-4px); box-shadow: var(--sh-md); }
    .article-img { aspect-ratio: 16/9; overflow: hidden; }
    .article-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; display: block; }
    .article-card:hover .article-img img { transform: scale(1.04); }
    .article-body { padding: 18px; flex: 1; display: flex; flex-direction: column; }
    .article-meta {
        display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
        font-size: 12px; font-weight: 600; color: var(--ink-lt); margin-bottom: 9px;
    }
    .article-cat {
        display: inline-block; font-size: 11px; font-weight: 800;
        letter-spacing: .05em; text-transform: uppercase;
        padding: 3px 9px; border-radius: 999px; margin-bottom: 8px;
    }
    .cat-blue   { background: var(--blue-lt);   color: var(--blue-dk); }
    .cat-teal   { background: var(--teal-lt);   color: #057972; }
    .cat-coral  { background: #fff1ee;           color: #b84a35; }
    .cat-purple { background: var(--purple-lt); color: #5b21b6; }
    .cat-green  { background: var(--green-lt);  color: var(--green); }
    .cat-amber  { background: #fef3c7;           color: #92400e; }
    .article-body h3 { font-size: 15.5px; font-weight: 700; line-height: 1.3; margin-bottom: 8px; }
    .article-body h3 a { color: var(--ink); transition: color .15s; }
    .article-body h3 a:hover { color: var(--blue); }
    .article-body p { font-size: 13.5px; color: var(--ink-lt); line-height: 1.65; flex: 1; }
    .read-more {
        display: inline-flex; align-items: center; gap: 5px;
        margin-top: 14px; font-size: 13px; font-weight: 700; color: var(--blue);
        border-top: 1px solid var(--border); padding-top: 12px; width: 100%;
        transition: gap .15s;
    }
    .read-more:hover { gap: 9px; }
    .read-more svg { flex-shrink: 0; }

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
    .page-btn.wide   { width: auto; padding: 0 16px; }

    /* ─── SIDEBAR ─── */
    .sidebar { display: flex; flex-direction: column; gap: 20px; }
    .sidebar-widget {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--r-md); padding: 22px;
    }
    .sidebar-widget h4 {
        font-size: 13.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em;
        color: var(--ink); margin-bottom: 16px; padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
    }

    /* search widget */
    .search-wrap { position: relative; }
    .search-wrap input {
        font-family: inherit; font-size: 14px; width: 100%;
        padding: 11px 44px 11px 14px; border: 1.5px solid var(--border);
        border-radius: 10px; background: var(--bg-soft); color: var(--ink);
        transition: border-color .15s, box-shadow .15s;
    }
    .search-wrap input:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(18,83,200,.1); background: #fff; }
    .search-wrap input::placeholder { color: var(--ink-lt); }
    .search-btn {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer; color: var(--ink-lt);
        display: grid; place-items: center;
    }

    /* category list widget */
    .cat-list { display: flex; flex-direction: column; gap: 6px; }
    .cat-list a {
        display: flex; justify-content: space-between; align-items: center;
        font-size: 14px; font-weight: 600; color: var(--ink-md);
        padding: 8px 0; border-bottom: 1px solid var(--border); transition: color .15s;
    }
    .cat-list a:last-child { border-bottom: none; }
    .cat-list a:hover { color: var(--blue); }
    .cat-count {
        font-size: 11.5px; font-weight: 700; padding: 2px 9px; border-radius: 999px;
        background: var(--bg-soft); color: var(--ink-lt);
    }

    /* recent posts widget */
    .recent-posts { display: flex; flex-direction: column; gap: 14px; }
    .recent-post { display: flex; gap: 12px; align-items: flex-start; }
    .recent-thumb {
        width: 58px; height: 58px; border-radius: 10px; overflow: hidden;
        flex-shrink: 0; background: var(--bg-soft);
    }
    .recent-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .recent-title { font-size: 13.5px; font-weight: 700; line-height: 1.35; margin-bottom: 4px; }
    .recent-title a { color: var(--ink); transition: color .15s; }
    .recent-title a:hover { color: var(--blue); }
    .recent-date { font-size: 11.5px; color: var(--ink-lt); font-weight: 600; }

    /* newsletter widget */
    .newsletter-widget {
        background: linear-gradient(135deg, var(--blue-dk) 0%, var(--blue) 60%, var(--teal) 100%);
        border: none;
    }
    .newsletter-widget h4 { color: #fff; border-bottom-color: rgba(255,255,255,.2); }
    .newsletter-widget p { font-size: 13.5px; color: rgba(255,255,255,.8); margin-bottom: 14px; line-height: 1.6; }
    .nl-form { display: flex; flex-direction: column; gap: 8px; }
    .nl-form input {
        font-family: inherit; font-size: 14px; padding: 11px 14px;
        border: 1px solid rgba(255,255,255,.3); border-radius: 10px;
        background: rgba(255,255,255,.15); color: #fff; width: 100%;
    }
    .nl-form input::placeholder { color: rgba(255,255,255,.65); }
    .nl-form input:focus { outline: 2px solid rgba(255,255,255,.5); }
    .nl-form button {
        font-family: inherit; font-size: 14px; font-weight: 800; padding: 12px;
        border: none; border-radius: 999px; cursor: pointer; width: 100%;
        background: #fff; color: var(--blue-dk);
        box-shadow: 0 6px 16px rgba(0,0,0,.2); transition: transform .18s, filter .18s;
    }
    .nl-form button:hover { transform: translateY(-1px); filter: brightness(.97); }

    /* tag cloud widget */
    .tag-cloud { display: flex; flex-wrap: wrap; gap: 7px; }
    .tag-cloud a {
        font-size: 12.5px; font-weight: 700; padding: 5px 12px;
        border-radius: 999px; border: 1.5px solid var(--border);
        background: var(--white); color: var(--ink-md); transition: all .15s;
    }
    .tag-cloud a:hover { border-color: var(--blue); background: var(--blue-lt); color: var(--blue); }

    /* ─── CTA BAND ─── */
    .blog-cta {
        background: linear-gradient(140deg, var(--blue-dk) 0%, var(--blue) 50%, var(--teal) 100%);
        color: #fff; padding: 56px 0;
    }
    .blog-cta .wrap { display: flex; justify-content: space-between; align-items: center; gap: 24px; flex-wrap: wrap; }
    .blog-cta h2 { font-size: clamp(1.5rem, 2.5vw, 2rem); font-weight: 800; color: #fff; margin-bottom: 6px; }
    .blog-cta p  { color: rgba(255,255,255,.85); font-size: 15px; max-width: 520px; }
    .blog-cta-btns { display: flex; gap: 10px; flex-wrap: wrap; flex-shrink: 0; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1024px) {
        .page-hero .wrap { grid-template-columns: 1fr; }
        .page-hero-img { display: none; }
        .blog-layout { grid-template-columns: 1fr; }
        .sidebar { display: grid; grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .article-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .blog-section { padding: 40px 0; }
        .sidebar { grid-template-columns: 1fr; }
        .blog-cta .wrap { flex-direction: column; text-align: center; }
    }
</style>
@endpush

@section('content')

{{-- ════ PAGE HERO ════ --}}
<section class="page-hero" aria-label="Blog page hero">
    <div class="wrap">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="/">Home</a>
                <span>›</span>
                <span>Blog</span>
            </nav>
            <span class="tag white">Patient Resources</span>
            <h1>Orthopedic Health Insights &amp; Patient Guides</h1>
            <p>Evidence-based articles from our specialist team covering joint health, sports recovery, physiotherapy, and surgical outcomes — written for patients, not clinicians.</p>
            <div class="hero-features">
                <div class="hero-feat"><span class="feat-dot"></span> Written by specialists</div>
                <div class="hero-feat"><span class="feat-dot"></span> Evidence-based</div>
                <div class="hero-feat"><span class="feat-dot"></span> New articles weekly</div>
            </div>
        </div>
        <div class="page-hero-img">
            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=85"
                alt="Doctor reviewing medical literature"
                loading="eager"
                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1504813184591-01572f98c85f?auto=format&fit=crop&w=900&q=85';">
        </div>
    </div>
</section>

{{-- ════ BLOG CONTENT ════ --}}
<section class="blog-section" aria-label="Blog articles">
    <div class="wrap">
        <div class="blog-layout">

            {{-- ─── MAIN COLUMN ─── --}}
            <main>

                {{-- Featured Article --}}
                <article class="featured-card" aria-label="Featured article">
                    <div class="featured-img">
                        <img src="https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=1200&q=85"
                            alt="Surgeon reviewing knee X-ray before joint replacement"
                            loading="eager"
                            onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1530026405186-ed1f139313f8?auto=format&fit=crop&w=1200&q=85';">
                    </div>
                    <div class="featured-body">
                        <span class="featured-badge">Featured</span>
                        <span class="article-cat cat-blue">Joint Health</span>
                        <div class="article-meta">
                            <span>Dr. Sarah Mitchell, MD</span>
                            <span>&middot;</span>
                            <span>June 24, 2026</span>
                            <span>&middot;</span>
                            <span>8 min read</span>
                        </div>
                        <h2><a href="#">What to Expect Before, During, and After Total Knee Replacement Surgery</a></h2>
                        <p>Knee replacement surgery is one of the most common and most successful orthopedic procedures performed worldwide — but it's normal to have questions. Our lead joint replacement surgeon walks through the full patient journey, from pre-surgical optimisation and the day of the operation, through to rehabilitation milestones and returning to daily activities.</p>
                        <a href="#" class="btn btn-solid" style="font-size:13.5px;">Read Article
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </article>

                {{-- Article Grid --}}
                <div class="article-grid" role="list">

                    {{-- Article 1 --}}
                    <article class="article-card" role="listitem">
                        <div class="article-img">
                            <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=800&q=80"
                                alt="Athlete receiving sports injury treatment"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=800&q=80';">
                        </div>
                        <div class="article-body">
                            <span class="article-cat cat-teal">Sports Medicine</span>
                            <div class="article-meta">
                                <span>Dr. James Okafor, MD</span>
                                <span>&middot;</span>
                                <span>June 19, 2026</span>
                                <span>&middot;</span>
                                <span>6 min read</span>
                            </div>
                            <h3><a href="#">ACL Reconstruction Recovery: A Week-by-Week Rehabilitation Guide</a></h3>
                            <p>From the first 48 hours post-surgery through returning to full sport, here is what each phase of ACL rehab should look and feel like.</p>
                            <a href="#" class="read-more">Read Article
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article 2 --}}
                    <article class="article-card" role="listitem">
                        <div class="article-img">
                            <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80"
                                alt="Physiotherapist working with patient on rehabilitation"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80';">
                        </div>
                        <div class="article-body">
                            <span class="article-cat cat-green">Physiotherapy</span>
                            <div class="article-meta">
                                <span>Dr. Rachel Nwosu, DPT</span>
                                <span>&middot;</span>
                                <span>June 14, 2026</span>
                                <span>&middot;</span>
                                <span>5 min read</span>
                            </div>
                            <h3><a href="#">Five Exercises That Protect Your Knees and Reduce Pain Without Surgery</a></h3>
                            <p>Our lead physiotherapist shares the evidence-backed exercises she prescribes most for patients with early-stage knee osteoarthritis.</p>
                            <a href="#" class="read-more">Read Article
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article 3 --}}
                    <article class="article-card" role="listitem">
                        <div class="article-img">
                            <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=800&q=80"
                                alt="Doctor reviewing spinal MRI with patient"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=800&q=80';">
                        </div>
                        <div class="article-body">
                            <span class="article-cat cat-coral">Spine &amp; Neck</span>
                            <div class="article-meta">
                                <span>Dr. Priya Sharma, MD</span>
                                <span>&middot;</span>
                                <span>June 9, 2026</span>
                                <span>&middot;</span>
                                <span>7 min read</span>
                            </div>
                            <h3><a href="#">Herniated Disc: When Conservative Treatment Works and When Surgery Is Needed</a></h3>
                            <p>Most herniated discs resolve without surgery — but knowing the difference can save months of unnecessary worry or delay the right intervention.</p>
                            <a href="#" class="read-more">Read Article
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article 4 --}}
                    <article class="article-card" role="listitem">
                        <div class="article-img">
                            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=800&q=80"
                                alt="Elderly patient discussing arthritis management with doctor"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80';">
                        </div>
                        <div class="article-body">
                            <span class="article-cat cat-purple">Arthritis</span>
                            <div class="article-meta">
                                <span>Dr. Michael Adeyemi, MD</span>
                                <span>&middot;</span>
                                <span>June 3, 2026</span>
                                <span>&middot;</span>
                                <span>6 min read</span>
                            </div>
                            <h3><a href="#">Understanding Rheumatoid vs. Osteoarthritis: Key Differences and Treatment Paths</a></h3>
                            <p>Though they share the word "arthritis", these two conditions have very different causes, symptoms, and treatment approaches. Here is how to tell them apart.</p>
                            <a href="#" class="read-more">Read Article
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article 5 --}}
                    <article class="article-card" role="listitem">
                        <div class="article-img">
                            <img src="https://images.unsplash.com/photo-1530026405186-ed1f139313f8?auto=format&fit=crop&w=800&q=80"
                                alt="X-ray of fractured wrist being examined"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1581595219315-a187dd40c322?auto=format&fit=crop&w=800&q=80';">
                        </div>
                        <div class="article-body">
                            <span class="article-cat cat-amber">Fracture &amp; Trauma</span>
                            <div class="article-meta">
                                <span>Dr. Sarah Mitchell, MD</span>
                                <span>&middot;</span>
                                <span>May 27, 2026</span>
                                <span>&middot;</span>
                                <span>4 min read</span>
                            </div>
                            <h3><a href="#">Stress Fractures in Runners: Early Warning Signs and How to Prevent Re-Injury</a></h3>
                            <p>Stress fractures are among the most misdiagnosed overuse injuries in recreational and competitive runners. Recognising the signs early makes all the difference.</p>
                            <a href="#" class="read-more">Read Article
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article 6 --}}
                    <article class="article-card" role="listitem">
                        <div class="article-img">
                            <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80"
                                alt="Surgeon reviewing robotic-assisted surgery planning"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80';">
                        </div>
                        <div class="article-body">
                            <span class="article-cat cat-blue">Joint Health</span>
                            <div class="article-meta">
                                <span>Dr. James Okafor, MD</span>
                                <span>&middot;</span>
                                <span>May 20, 2026</span>
                                <span>&middot;</span>
                                <span>9 min read</span>
                            </div>
                            <h3><a href="#">Robotic-Assisted Hip Replacement: How Technology Is Improving Surgical Precision</a></h3>
                            <p>Mako robotic technology allows our surgeons to plan and execute joint replacements with sub-millimetre accuracy. Here is how it works and why it matters for patients.</p>
                            <a href="#" class="read-more">Read Article
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>

                </div>{{-- /article-grid --}}

                {{-- Pagination --}}
                <nav class="pagination" aria-label="Article pagination">
                    <a href="#" class="page-btn wide" aria-label="Previous page">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><polyline points="15 18 9 12 15 6"/></svg>
                        Prev
                    </a>
                    <a href="#" class="page-btn active" aria-label="Page 1">1</a>
                    <a href="#" class="page-btn" aria-label="Page 2">2</a>
                    <a href="#" class="page-btn" aria-label="Page 3">3</a>
                    <span class="page-btn" style="border:none;cursor:default;color:var(--ink-lt);">&hellip;</span>
                    <a href="#" class="page-btn" aria-label="Page 8">8</a>
                    <a href="#" class="page-btn wide" aria-label="Next page">
                        Next
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </nav>

            </main>{{-- /main --}}

            {{-- ─── SIDEBAR ─── --}}
            <aside class="sidebar" aria-label="Blog sidebar">

                {{-- Search --}}
                <div class="sidebar-widget">
                    <h4>Search Articles</h4>
                    <form class="search-wrap" role="search" aria-label="Search blog">
                        <input type="search" placeholder="e.g. knee replacement, ACL..." aria-label="Search articles">
                        <button type="submit" class="search-btn" aria-label="Submit search">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </button>
                    </form>
                </div>

                {{-- Categories --}}
                <div class="sidebar-widget">
                    <h4>Browse by Category</h4>
                    <nav class="cat-list" aria-label="Article categories">
                        <a href="#">Joint Health <span class="cat-count">14</span></a>
                        <a href="#">Sports Medicine <span class="cat-count">11</span></a>
                        <a href="#">Spine &amp; Neck <span class="cat-count">9</span></a>
                        <a href="#">Physiotherapy <span class="cat-count">13</span></a>
                        <a href="#">Fracture &amp; Trauma <span class="cat-count">7</span></a>
                        <a href="#">Arthritis <span class="cat-count">8</span></a>
                        <a href="#">Nutrition &amp; Recovery <span class="cat-count">6</span></a>
                    </nav>
                </div>

                {{-- Recent Posts --}}
                <div class="sidebar-widget">
                    <h4>Recent Articles</h4>
                    <div class="recent-posts">
                        <div class="recent-post">
                            <div class="recent-thumb">
                                <img src="https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=120&q=70"
                                    alt="Knee replacement article thumbnail" loading="lazy">
                            </div>
                            <div>
                                <div class="recent-title"><a href="#">What to Expect Before &amp; After Total Knee Replacement</a></div>
                                <div class="recent-date">June 24, 2026</div>
                            </div>
                        </div>
                        <div class="recent-post">
                            <div class="recent-thumb">
                                <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&w=120&q=70"
                                    alt="ACL recovery article thumbnail" loading="lazy">
                            </div>
                            <div>
                                <div class="recent-title"><a href="#">ACL Reconstruction Recovery: A Week-by-Week Guide</a></div>
                                <div class="recent-date">June 19, 2026</div>
                            </div>
                        </div>
                        <div class="recent-post">
                            <div class="recent-thumb">
                                <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=120&q=70"
                                    alt="Physiotherapy exercises article thumbnail" loading="lazy">
                            </div>
                            <div>
                                <div class="recent-title"><a href="#">Five Exercises That Protect Your Knees Without Surgery</a></div>
                                <div class="recent-date">June 14, 2026</div>
                            </div>
                        </div>
                        <div class="recent-post">
                            <div class="recent-thumb">
                                <img src="https://images.unsplash.com/photo-1666214280557-f1b5022eb634?auto=format&fit=crop&w=120&q=70"
                                    alt="Herniated disc article thumbnail" loading="lazy">
                            </div>
                            <div>
                                <div class="recent-title"><a href="#">Herniated Disc: When Surgery Is Actually Needed</a></div>
                                <div class="recent-date">June 9, 2026</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Newsletter --}}
                <div class="sidebar-widget newsletter-widget">
                    <h4>Weekly Health Insights</h4>
                    <p>Get our latest orthopedic health guides and clinic updates delivered to your inbox every Tuesday.</p>
                    <form class="nl-form" novalidate aria-label="Newsletter signup">
                        <input type="email" placeholder="Your email address" aria-label="Email address" required>
                        <button type="submit">Subscribe — It's Free</button>
                    </form>
                </div>

                {{-- Tag Cloud --}}
                <div class="sidebar-widget">
                    <h4>Topics</h4>
                    <div class="tag-cloud">
                        <a href="#">Knee Pain</a>
                        <a href="#">Hip Replacement</a>
                        <a href="#">Back Pain</a>
                        <a href="#">ACL</a>
                        <a href="#">Sciatica</a>
                        <a href="#">Arthritis</a>
                        <a href="#">Physiotherapy</a>
                        <a href="#">Recovery</a>
                        <a href="#">Sports Injury</a>
                        <a href="#">Posture</a>
                        <a href="#">Scoliosis</a>
                        <a href="#">Fractures</a>
                    </div>
                </div>

                {{-- Book Appointment CTA --}}
                <div class="sidebar-widget" style="background:var(--bg-soft);">
                    <h4>Need to See a Specialist?</h4>
                    <p style="font-size:13.5px;color:var(--ink-lt);line-height:1.6;margin-bottom:14px;">Our team is available for same-week consultations. Book online and a care coordinator will confirm within 2 hours.</p>
                    <a href="/book-appointment" class="btn btn-solid" style="width:100%;justify-content:center;">Book an Appointment</a>
                    <a href="tel:+12125550192" class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:8px;">Call +1 (212) 555-0192</a>
                </div>

            </aside>{{-- /sidebar --}}

        </div>{{-- /blog-layout --}}
    </div>{{-- /wrap --}}
</section>

{{-- ════ CTA BAND ════ --}}
<section class="blog-cta" aria-label="Book appointment call to action">
    <div class="wrap">
        <div>
            <span class="tag white">See a Specialist</span>
            <h2>Have a Question About Your Joint Health?</h2>
            <p>Our specialists offer same-week appointments. Bring your questions — we'll bring the answers.</p>
        </div>
        <div class="blog-cta-btns">
            <a href="/book-appointment" class="btn btn-fire">Book an Appointment
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="/services" class="btn btn-ghost" style="border-color:rgba(255,255,255,.4);color:#fff;background:rgba(255,255,255,.12);">View All Services</a>
        </div>
    </div>
</section>

@endsection