@extends('layouts.admin')

@section('title', 'Create Blog Post | OrthoCore Clinic')

@push('styles')
<style>
    .page-heading { margin-bottom: 24px; }
    .page-heading h1 { font-size: 1.7rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .page-heading p  { font-size: 0.93rem; color: #6b7a99; margin: 0; }
    .panel { background: #fff; border: 1px solid #e3e9f3; border-radius: 14px; padding: 20px; }
    .panel-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 18px; flex-wrap: wrap; }
    .panel-head h3 { font-size: 1rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .panel-head .panel-caption { font-size: 0.85rem; color: #6b7a99; margin: 0; }
    .create-btn { display: inline-flex; align-items: center; gap: 6px; background: #4070f4; color: #fff; border: none; border-radius: 10px; padding: 9px 16px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; }
    .create-btn:hover { background: #2f5ce2; color: #fff; }
    .btn-primary { background: #4070f4; color: #fff; border: none; border-radius: 10px; padding: 10px 20px; font-size: 0.9rem; font-weight: 600; cursor: pointer; }
    .btn-primary:hover { background: #2f5ce2; }
    .btn-secondary { background: #f1f5fb; color: #4a5568; border: 1px solid #dce4f0; border-radius: 10px; padding: 10px 20px; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: none; }
    .btn-secondary:hover { background: #e3e9f3; }
    .form-field label { display: block; font-size: 0.85rem; font-weight: 600; color: #4a5568; margin-bottom: 6px; }
    .form-field input, .form-field textarea, .form-field select { width: 100%; border: 1px solid #dce4f0; border-radius: 10px; padding: 10px 12px; font-size: 0.9rem; color: #1a2550; background: #fff; outline: none; }
    .form-field input:focus, .form-field textarea:focus, .form-field select:focus { border-color: #4070f4; box-shadow: 0 0 0 3px rgba(64,112,244,0.12); }
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .form-field.full-width { grid-column: 1 / -1; }
    .form-actions { margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px; }
    .help-text { font-size: 0.8rem; color: #9aa5be; margin-top: 4px; }
    table { width: 100%; border-collapse: collapse; }
    thead th { text-align: left; padding: 10px 14px; font-size: 0.8rem; font-weight: 600; color: #9aa5be; text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 1px solid #e3e9f3; background: #fafbff; }
    tbody td { padding: 12px 14px; border-bottom: 1px solid #f1f5fb; font-size: 0.9rem; color: #3d4a6b; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #f8faff; }
    .alert { background: #e8faf2; border: 1px solid #9ae6b4; color: #276749; border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; font-size: 0.9rem; }
    .img-thumb { width: 60px; height: 40px; object-fit: cover; border-radius: 6px; }
</style>
@endpush


@section('content')

<div class="page-heading">
    <h1>Create Blog Post</h1>
    <p>Write and publish a new post to the public blog.</p>
</div>

<div class="panel">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert" style="background:#fff0f0;border-color:#feb2b2;color:#c53030;">
            <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form id="blog-form" method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <div class="form-field">
                <label for="title">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" required>
            </div>
            <div class="form-field">
                <label for="author">Author</label>
                <input id="author" name="author" type="text" value="{{ old('author') }}" required>
            </div>
            <div class="form-field">
                <label for="image">Featured Image</label>
                <input id="image" name="image" type="file" accept="image/*">
            </div>
            <div class="form-field full-width">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="8">{{ old('content') }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.blogs.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary">Publish Post</button>
        </div>
    </form>
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
        contentsCss: 'body { font-family: Inter, sans-serif; font-size: 14px; }'
    });
</script>
@endpush

@endsection
