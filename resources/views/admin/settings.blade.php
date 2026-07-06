@extends('layouts.app')

@section('title', 'Site Settings | OrthoCore Clinic')

@push('styles')
<style>
    .admin-page {
        padding: 32px 0 70px;
        background: linear-gradient(180deg, #f6fbff 0%, #ffffff 100%);
    }

    .admin-shell {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
        align-items: start;
    }

    .admin-shell > .admin-sidebar {
        align-self: stretch;
        min-height: 100%;
    }

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

    .admin-content {
        display: grid;
        gap: 20px;
    }

    .panel-card {
        background: #fff;
        border: 1px solid #dde8f7;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 16px 38px rgba(15, 31, 58, 0.08);
    }

    .panel-card h1 {
        margin: 0 0 12px;
        font-size: 1.6rem;
    }

    .form-grid {
        display: grid;
        gap: 18px;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .form-field {
        display: grid;
        gap: 8px;
    }

    .form-field label {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        color: #34405c;
    }

    .form-field input,
    .form-field textarea {
        width: 100%;
        border: 1px solid #dfe7f2;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        color: #1f3556;
    }

    textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 18px;
    }

    .btn-primary {
        border: 0;
        background: linear-gradient(135deg, #1253c8, #2877ff);
        color: #fff;
        border-radius: 12px;
        padding: 12px 18px;
        font-weight: 700;
        cursor: pointer;
    }

    .alert {
        padding: 14px 18px;
        border-radius: 14px;
        background: #e6f4ff;
        color: #0f385d;
        border: 1px solid #c9e2ff;
    }

    @media (max-width: 920px) {
        .admin-shell {
            grid-template-columns: 1fr;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-page">
    <div class="wrap admin-shell">
        @include('partials.admin-sidebar')

        <div class="admin-content">
            <section class="panel-card">
                <h1>Site Settings</h1>

                @if(session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="form-field">
                            <label for="site_name">Site Name</label>
                            <input id="site_name" name="site_name" type="text" value="{{ old('site_name', $values['site_name'] ?? '') }}" required>
                        </div>
                        <div class="form-field">
                            <label for="site_full_name">Full Site Name</label>
                            <input id="site_full_name" name="site_full_name" type="text" value="{{ old('site_full_name', $values['site_full_name'] ?? '') }}" required>
                        </div>
                        <div class="form-field">
                            <label for="site_logo">Logo URL</label>
                            <input id="site_logo" name="site_logo" type="text" value="{{ old('site_logo', $values['site_logo'] ?? '') }}">
                        </div>
                        <div class="form-field">
                            <label for="site_phone">Contact Phone</label>
                            <input id="site_phone" name="site_phone" type="text" value="{{ old('site_phone', $values['site_phone'] ?? '') }}" required>
                        </div>
                        <div class="form-field">
                            <label for="site_email">Contact Email</label>
                            <input id="site_email" name="site_email" type="email" value="{{ old('site_email', $values['site_email'] ?? '') }}" required>
                        </div>
                        <div class="form-field">
                            <label for="site_address_line_1">Address Line 1</label>
                            <input id="site_address_line_1" name="site_address_line_1" type="text" value="{{ old('site_address_line_1', $values['site_address_line_1'] ?? '') }}" required>
                        </div>
                        <div class="form-field">
                            <label for="site_address_line_2">Address Line 2</label>
                            <input id="site_address_line_2" name="site_address_line_2" type="text" value="{{ old('site_address_line_2', $values['site_address_line_2'] ?? '') }}" required>
                        </div>
                        <div class="form-field full-width">
                            <label for="site_description">Description</label>
                            <textarea id="site_description" name="site_description">{{ old('site_description', $values['site_description'] ?? '') }}</textarea>
                        </div>
                        <div class="form-field">
                            <label for="pagination_default">Pagination Default</label>
                            <input id="pagination_default" name="pagination_default" type="number" min="1" max="100" value="{{ old('pagination_default', $values['pagination_default'] ?? 10) }}" required>
                        </div>
                        <div class="form-field">
                            <label for="pagination_search">Pagination Search</label>
                            <input id="pagination_search" name="pagination_search" type="number" min="1" max="100" value="{{ old('pagination_search', $values['pagination_search'] ?? 2) }}" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Save Settings</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
