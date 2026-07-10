@extends('layouts.admin')

@section('title', $currentPageLabel . ' | Page CMS | OrthoCore Admin')

@push('styles')
<style>
    .page-heading { margin-bottom: 24px; }
    .page-heading h1 { font-size: 1.7rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .page-heading p  { font-size: 0.93rem; color: #6b7a99; margin: 0; }
    .panel { background: #fff; border: 1px solid #e3e9f3; border-radius: 14px; padding: 24px; }
    .panel h2 { font-size: 1.05rem; font-weight: 700; color: #1a2550; margin: 0 0 20px; }
    .field-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .field-card label { display: block; font-size: 0.85rem; font-weight: 600; color: #4a5568; margin-bottom: 6px; }
    .field-card input,
    .field-card textarea {
        width: 100%;
        border: 1px solid #dce4f0;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 0.9rem;
        color: #1a2550;
        background: #fff;
        outline: none;
        font-family: inherit;
        transition: border-color 160ms ease;
    }
    .field-card input:focus,
    .field-card textarea:focus { border-color: #4070f4; box-shadow: 0 0 0 3px rgba(64,112,244,0.12); }
    .field-card.full-width { grid-column: 1 / -1; }
    .form-actions { margin-top: 22px; display: flex; justify-content: flex-end; gap: 10px; }
    .btn-primary { background: #4070f4; color: #fff; border: none; border-radius: 10px; padding: 10px 22px; font-size: 0.9rem; font-weight: 600; cursor: pointer; }
    .btn-primary:hover { background: #2f5ce2; }
    .alert { background: #e8faf2; border: 1px solid #9ae6b4; color: #276749; border-radius: 10px; padding: 12px 16px; margin-bottom: 18px; font-size: 0.9rem; }
    .page-nav { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }
    .page-nav a {
        padding: 8px 16px;
        border-radius: 10px;
        border: 1px solid #dce4f0;
        background: #fff;
        color: #4a5568;
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 500;
        transition: background 150ms ease, color 150ms ease;
    }
    .page-nav a:hover { background: #eef3ff; color: #4070f4; border-color: #c7d9ff; }
    .page-nav a.active { background: #4070f4; color: #fff; border-color: #4070f4; }
    @media (max-width: 720px) {
        .field-grid { grid-template-columns: 1fr; }
        .field-card.full-width { grid-column: auto; }
    }
</style>
@endpush

@section('content')

<div class="page-heading">
    <h1>Content &amp; Pages</h1>
    <p>Manage hero content for each page. Click a page tab below to edit it.</p>
</div>

<nav class="page-nav" aria-label="Page navigation">
    @foreach($pages as $key => $label)
        <a href="{{ route('admin.cms.edit', ['page' => $key]) }}"
           class="{{ $key === $currentPageKey ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
</nav>

<div class="panel">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <h2>{{ $currentPageLabel }}</h2>

    <form method="POST" action="{{ route('admin.cms.update', ['page' => $currentPageKey]) }}">
        @csrf
        <div class="field-grid">
            @foreach($fields as $fieldKey => $fieldLabel)
                <div class="field-card {{ in_array($fieldKey, ['hero_subtitle']) ? 'full-width' : '' }}">
                    <label for="page_{{ $currentPageKey }}_{{ $fieldKey }}">{{ $fieldLabel }}</label>
                    @if($fieldKey === 'hero_subtitle')
                        <textarea id="page_{{ $currentPageKey }}_{{ $fieldKey }}"
                                  name="page_{{ $currentPageKey }}_{{ $fieldKey }}"
                                  rows="3">{{ old("page_{$currentPageKey}_{$fieldKey}", $values["page_{$currentPageKey}_{$fieldKey}"] ?? '') }}</textarea>
                    @else
                        <input id="page_{{ $currentPageKey }}_{{ $fieldKey }}"
                               name="page_{{ $currentPageKey }}_{{ $fieldKey }}"
                               type="text"
                               value="{{ old("page_{$currentPageKey}_{$fieldKey}", $values["page_{$currentPageKey}_{$fieldKey}"] ?? '') }}">
                    @endif
                </div>
            @endforeach
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save Page Content</button>
        </div>
    </form>
</div>

@endsection
