@extends('layouts.app')

@section('title', 'Edit Blog Post | OrthoCore Clinic')

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
    .admin-hero { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: nowrap; }
    .admin-hero h1 { margin: 0; font-size: clamp(1.6rem, 2.2vw, 2.1rem); font-weight: 800; color: #0f1f3a; min-width: 0; }
    .admin-hero button { white-space: nowrap; }
    .admin-hero p { display: none; }
    .field-row { display: grid; gap: 14px; margin-bottom: 18px; }
    .field-row label { font-size: 12px; font-weight: 700; color: #475569; }
    .field-row input, .field-row textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 14px; padding: 12px 14px; font-size: 14px; color: #0f172a; background: #fff; }
    .field-row textarea { min-height: 220px; }
    .btn-primary { border: 0; border-radius: 14px; padding: 12px 22px; background: linear-gradient(135deg, #1253c8, #2877ff); color: #fff; font-weight: 700; cursor: pointer; }
    .alert { padding: 14px 18px; border-radius: 14px; background: #e6f4ff; color: #0f385d; border: 1px solid #c9e2ff; margin-bottom: 20px; }
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="wrap admin-shell">
        @include('partials.admin-sidebar')

        <div class="admin-content">
            <section class="admin-hero">
                <h1>Edit Blog Post</h1>
                <button type="submit" form="blog-form" class="btn-primary">Save Post</button>
            </section>

            <section class="panel-card">
                @if(session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif

                <form id="blog-form" method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="field-row">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title', $blog->title) }}" required>
                    </div>

                    <div class="field-row">
                        <label for="author">Author</label>
                        <input id="author" name="author" type="text" value="{{ old('author', $blog->author) }}" required>
                    </div>

                    <div class="field-row">
                        <label for="image">Featured Image</label>
                        <input id="image" name="image" type="file" accept="image/*">
                    </div>

                    <div class="field-row">
                        <label for="content">Content</label>
                        <textarea id="content" name="content">{{ old('content', $blog->content) }}</textarea>
                    </div>

                </form>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/full-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content', {
        height: 420,
        toolbar: [
            { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ] },
            { name: 'tools', items: [ 'Maximize' ] }
        ],
        removePlugins: 'elementspath',
        resize_enabled: true,
        bodyClass: 'editor-content',
        contentsCss: 'body { font-family: Inter, sans-serif; font-size: 14px; }'
    });
</script>
@endpush
@endsection
