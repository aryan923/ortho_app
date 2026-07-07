@extends('layouts.app')

@section('title', $blog->title . ' — OrthoCore Clinic')

@push('styles')
<style>
    .page-hero { background: linear-gradient(140deg, var(--blue-dk) 0%, var(--blue) 50%, var(--teal) 100%); padding: 56px 0 48px; color: #fff; }
    .page-hero .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
    .page-hero h1 { font-size: clamp(1.9rem, 3.5vw, 2.8rem); font-weight: 800; letter-spacing: -.025em; line-height: 1.1; margin-bottom: 12px; color: #fff; }
    .page-hero p { color: rgba(255,255,255,.85); font-size: 15.5px; max-width: 560px; margin-bottom: 24px; }
    .article-hero { padding: 56px 0; }
    .article-hero .wrap { display: grid; gap: 32px; }
    .article-card { background: #fff; border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; }
    .article-img { aspect-ratio: 16/7; overflow: hidden; }
    .article-img img { width: 100%; height: 100%; object-fit: cover; }
    .article-body { padding: 32px; }
    .article-meta { display: flex; gap: 10px; flex-wrap: wrap; font-size: 13px; color: #6a7f99; margin-bottom: 18px; }
    .article-body h2 { margin: 0 0 16px; font-size: clamp(2rem, 3vw, 2.8rem); line-height: 1.05; }
    .article-content { font-size: 16px; line-height: 1.9; color: #24303f; }
    .article-content h2, .article-content h3, .article-content h4 { margin: 30px 0 16px; font-weight: 800; color: #0f172a; }
    .article-content p { margin: 0 0 22px; }
    .article-content strong { font-weight: 700; }
    .article-content em { font-style: italic; }
    .article-content ul, .article-content ol { margin: 18px 0 22px 20px; }
    .article-content a { color: #1253c8; text-decoration: underline; }
    @media (max-width: 1024px) { .page-hero .wrap, .article-hero .wrap { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<section class="page-hero" aria-label="Article hero">
    <div class="wrap">
        <div>
            <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a> › <a href="{{ route('blog') }}">Blog</a> › <span>{{ $blog->title }}</span></nav>
            <h1>{{ $blog->title }}</h1>
            <p>{{ $blog->author }} · {{ $blog->created_at->format('M d, Y') }}</p>
        </div>
    </div>
</section>

<section class="article-hero">
    <div class="wrap">
        <article class="article-card">
            @if($blog->image)
                <div class="article-img"><img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"></div>
            @endif
            <div class="article-body">
                <div class="article-meta">{{ $blog->author }} · {{ $blog->created_at->format('M d, Y') }}</div>
                <div class="article-content">{!! $blog->content !!}</div>
            </div>
        </article>
    </div>
</section>
@endsection
