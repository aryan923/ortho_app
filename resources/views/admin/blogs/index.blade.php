@extends('layouts.admin')

@section('title', 'Blog Management | OrthoCore Clinic')

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
    <h1>Blog Management</h1>
    <p>Create and manage blog posts published on the public site.</p>
</div>

<div class="panel">
    <div class="panel-head">
        <div>
            <h3>All blog posts</h3>
            <p class="panel-caption">Edit or delete existing posts, or create a new one.</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="create-btn">+ Create New Post</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if($blogs->count())
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td>
                        @if($blog->image)
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-thumb">
                        @else
                            <span style="color:#9aa5be;font-size:0.85rem;">No image</span>
                        @endif
                    </td>
                    <td style="font-weight:600;color:#1a2550;">{{ $blog->title }}</td>
                    <td>{{ $blog->author }}</td>
                    <td>{{ $blog->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn-secondary" style="padding:6px 14px;font-size:0.85rem;border-radius:8px;text-decoration:none;">Edit</a>
                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" style="margin:0;" onsubmit="return confirm('Delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:#fff0f0;color:#e53e3e;border:1px solid #feb2b2;border-radius:8px;padding:6px 14px;font-size:0.85rem;font-weight:600;cursor:pointer;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:16px;padding-top:16px;border-top:1px solid #f1f5fb;">
            {{ $blogs->links() }}
        </div>
    @else
        <p style="color:#9aa5be;padding:20px 0;">No blog posts found. Create your first post!</p>
    @endif
</div>

@endsection

