@extends('layouts.app')

@section('title', 'Blog Management | OrthoCore Clinic')

@push('styles')
<style>
    .admin-page { padding: 32px 0 70px; background: linear-gradient(180deg, #f6fbff 0%, #ffffff 100%); }
    .admin-shell { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }
    .admin-shell > .admin-sidebar { align-self: stretch; min-height: 100%; }
    .admin-sidebar {
        background: #0f1f3a;
        color: #fff;
        border-radius: 24px;
        padding: 20px;
        min-height: 70vh;
        height: 100%;
        box-shadow: 0 16px 38px rgba(15, 31, 58, 0.12);
    }
    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 18px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        margin-bottom: 18px;
    }
    .brand-mark {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        font-weight: 800;
        background: linear-gradient(135deg, #1253c8, #4fd3cc);
        color: white;
    }
    .brand-name {
        font-size: 15px;
        font-weight: 700;
        margin: 0;
    }
    .brand-subtitle {
        color: #9db2cf;
        font-size: 12px;
    }
    .sidebar-nav {
        display: grid;
        gap: 8px;
    }
    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 12px;
        border-radius: 12px;
        color: #dce8f7;
        text-decoration: none;
        font-size: 14px;
        transition: background 0.2s, color 0.2s;
    }
    .nav-item:hover,
    .nav-item.active {
        background: rgba(255,255,255,0.12);
        color: #fff;
    }
    .nav-dropdown {
        display: grid;
        gap: 6px;
    }
    .nav-toggle {
        width: 100%;
        justify-content: space-between;
        border: 0;
        background: transparent;
        cursor: pointer;
        font: inherit;
        text-align: left;
    }
    .nav-caret {
        margin-left: auto;
        color: #8fd7d1;
        font-size: 12px;
    }
    .nav-dropdown-menu {
        display: none;
        gap: 4px;
        padding-left: 22px;
        margin-top: 4px;
    }
    .nav-dropdown.open .nav-dropdown-menu {
        display: grid;
    }
    .nav-dropdown.open .nav-caret {
        transform: rotate(180deg);
    }
    .nav-subitem {
        padding: 8px 10px;
        border-radius: 10px;
        color: #cfe0f3;
        text-decoration: none;
        font-size: 13px;
    }
    .nav-subitem:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }
    .admin-content { display: grid; gap: 20px; }
    .admin-hero, .panel-card { background: #fff; border: 1px solid #dde8f7; border-radius: 24px; padding: 24px; box-shadow: 0 16px 38px rgba(15, 31, 58, 0.08); }
    .admin-hero { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
    .admin-hero h1 { margin: 0; font-size: clamp(1.6rem, 2.2vw, 2.1rem); font-weight: 800; color: #0f1f3a; }
    .admin-hero p { display: none; }
    .blog-list { display: grid; gap: 16px; }
    .blog-row { display: grid; grid-template-columns: 1fr auto; gap: 16px; align-items: center; padding: 18px 20px; border: 1px solid #e9f2fb; border-radius: 18px; }
    .blog-title { font-size: 1rem; font-weight: 700; margin: 0 0 6px; }
    .blog-meta { font-size: 13px; color: #6a7f99; }
    .blog-actions { display: flex; gap: 10px; }
    .btn { border: 0; border-radius: 14px; padding: 10px 16px; font-weight: 700; cursor: pointer; }
    .btn-primary { background: linear-gradient(135deg, #1253c8, #2877ff); color: #fff; }
    .btn-secondary { background: #f8fafc; color: #0f172a; border: 1px solid #d9e6f7; }
    .pagination { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: flex-end; }
    .page-link { display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 42px; border-radius: 12px; border: 1px solid #d9e6f7; background: #fff; color: #0f172a; text-decoration: none; }
    .page-link.active { background: #1253c8; color: #fff; border-color: #1253c8; }
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="wrap admin-shell">
        @include('partials.admin-sidebar')

        <div class="admin-content">
            <section class="admin-hero">
                <h1>Blog Management</h1>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Create New Post</a>
            </section>

            <section class="panel-card">
                <div class="blog-list">
                    @forelse($blogs as $blog)
                        <div class="blog-row">
                            <div>
                                <p class="blog-title">{{ $blog->title }}</p>
                                <p class="blog-meta">{{ $blog->author }} · {{ $blog->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="blog-actions">
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-secondary">Edit</a>
                                <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>No blog posts found.</p>
                    @endforelse
                </div>

                <div class="pagination">
                    {{ $blogs->links() }}
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
