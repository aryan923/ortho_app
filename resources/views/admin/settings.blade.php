@extends('layouts.admin')

@section('title', 'Site Settings | OrthoCore Admin')

@push('styles')
<style>
    .page-heading { margin-bottom: 24px; }
    .page-heading h1 { font-size: 1.7rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .page-heading p  { font-size: 0.93rem; color: #6b7a99; margin: 0; }

    .panel {
        background: #fff;
        border: 1px solid #e3e9f3;
        border-radius: 14px;
        padding: 20px;
    }

    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .panel-head h3  { font-size: 1rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .panel-head .panel-caption { font-size: 0.85rem; color: #6b7a99; margin: 0; }

    .panel-tools {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Search bar */
    .search-shell {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f1f5fb;
        border: 1px solid #dce4f0;
        border-radius: 50px;
        padding: 8px 14px;
        min-width: 260px;
    }
    .search-icon { color: #8896ad; flex-shrink: 0; }
    .search-input { border: none; background: transparent; outline: none; font-size: 0.9rem; color: #3d4a6b; width: 100%; }
    .search-clear-btn { background: none; border: none; color: #8896ad; cursor: pointer; font-size: 0.82rem; white-space: nowrap; }

    /* Buttons */
    .create-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #4070f4;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 9px 16px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }
    .create-btn:hover { background: #2f5ce2; }

    .btn-primary {
        background: #4070f4;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-primary:hover { background: #2f5ce2; }

    .btn-secondary {
        background: #f1f5fb;
        color: #4a5568;
        border: 1px solid #dce4f0;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-secondary:hover { background: #e3e9f3; }

    .btn-danger {
        background: #e53e3e;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-danger:hover { background: #c53030; }

    /* Table */
    .table-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        text-align: left;
        padding: 10px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #9aa5be;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid #e3e9f3;
        background: #fafbff;
    }
    tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5fb;
        font-size: 0.9rem;
        color: #3d4a6b;
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #f8faff; }

    /* Pagination */
    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5fb;
    }
    .page-btn {
        background: #f1f5fb;
        border: 1px solid #dce4f0;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 0.88rem;
        cursor: pointer;
        color: #4a5568;
    }
    .page-btn:hover { background: #e3e9f3; }
    .page-info { font-size: 0.88rem; color: #6b7a99; }

    /* Badge */
    .badge-status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .badge-status.active   { background: #e8faf2; color: #059669; }
    .badge-status.inactive { background: #fff0f0; color: #e53e3e; }
    .badge-status.admin    { background: #eef3ff; color: #4070f4; }
    .badge-status.doctor   { background: #f3eeff; color: #7c3aed; }
    .badge-status.user     { background: #f1f5fb; color: #6b7a99; }

    /* Alert */
    .alert {
        background: #e8faf2;
        border: 1px solid #9ae6b4;
        color: #276749;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 18px;
        font-size: 0.9rem;
    }

    /* Forms */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .form-field label { display: block; font-size: 0.85rem; font-weight: 600; color: #4a5568; margin-bottom: 6px; }
    .form-field input,
    .form-field textarea,
    .form-field select {
        width: 100%;
        border: 1px solid #dce4f0;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 0.9rem;
        color: #1a2550;
        background: #fff;
        outline: none;
        transition: border-color 160ms ease;
    }
    .form-field input:focus,
    .form-field textarea:focus,
    .form-field select:focus { border-color: #4070f4; box-shadow: 0 0 0 3px rgba(64,112,244,0.12); }
    .form-field.full-width { grid-column: 1 / -1; }
    .help-text { font-size: 0.8rem; color: #9aa5be; margin-top: 4px; }
    .form-actions { margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px; }

    /* Logo preview */
    .logo-upload-row { display: flex; align-items: center; gap: 12px; }
    .logo-preview { height: 42px; width: auto; border-radius: 6px; border: 1px solid #e3e9f3; }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 500;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .edit-modal {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        width: 560px;
        max-width: 95vw;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 24px 80px rgba(0,0,0,0.2);
    }
    .edit-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 22px;
    }
    .edit-modal-title  { font-size: 1.15rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }
    .edit-modal-subtitle { font-size: 0.85rem; color: #6b7a99; margin: 0; }
    .modal-close-btn {
        background: #f1f5fb; border: none; border-radius: 8px;
        width: 34px; height: 34px; font-size: 1.2rem;
        cursor: pointer; color: #4a5568; display: grid; place-items: center;
    }
    .modal-close-btn:hover { background: #e3e9f3; }
    .edit-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .edit-field label,
    .edit-label { display: block; font-size: 0.85rem; font-weight: 600; color: #4a5568; margin-bottom: 6px; }
    .edit-input,
    .edit-select {
        width: 100%;
        border: 1px solid #dce4f0;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 0.9rem;
        color: #1a2550;
        background: #fff;
        outline: none;
    }
    .edit-input:focus,
    .edit-select:focus { border-color: #4070f4; box-shadow: 0 0 0 3px rgba(64,112,244,0.12); }
    .edit-form-error,
    .confirm-error { color: #e53e3e; font-size: 0.85rem; margin-top: 8px; }
    .edit-form-actions,
    .confirm-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
    .address-field,
    .contact-field,
    .permissions-field { grid-column: 1 / -1; }
    .confirm-modal-body { padding-top: 4px; }
    .confirm-title { font-size: 1.05rem; font-weight: 700; color: #1a2550; margin: 0 0 8px; }
    .confirm-text { font-size: 0.9rem; color: #6b7a99; margin: 0 0 16px; }
    .permissions-list { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; max-height: 200px; overflow-y: auto; border: 1px solid #dce4f0; border-radius: 10px; padding: 12px; }
    .permission-item { display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: #3d4a6b; }
    .permission-empty { color: #9aa5be; font-size: 0.88rem; }

    /* CMS fields */
    .field-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-top: 14px; }
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
    }
    .field-card.full-width { grid-column: 1 / -1; }
    .page-section h2 { font-size: 1rem; font-weight: 700; color: #1a2550; margin: 0 0 4px; }

    @media (max-width: 720px) {
        .form-grid, .edit-grid, .field-grid { grid-template-columns: 1fr; }
        .form-field.full-width, .edit-field.address-field,
        .edit-field.contact-field, .edit-field.permissions-field,
        .field-card.full-width { grid-column: auto; }
    }
</style>
@endpush

@section('content')
<div class="page-heading">
    <h1>Site Settings</h1>
    <p>Update your site branding and contact details used across the public site and admin header.</p>
</div>

<div class="panel">
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <div class="form-field">
                <label for="site_full_name">Full Site Name</label>
                <input id="site_full_name" name="site_full_name" type="text" value="{{ old('site_full_name', $values['site_full_name'] ?? '') }}" required>
            </div>
            <div class="form-field">
                <label for="site_phone">Contact Phone</label>
                <input id="site_phone" name="site_phone" type="text" value="{{ old('site_phone', $values['site_phone'] ?? '') }}" required>
            </div>
            <div class="form-field">
                <label for="site_logo">Site Logo</label>
                <div class="logo-upload-row">
                    @if(!empty($values['site_logo']))
                        <img src="{{ asset($values['site_logo']) }}" alt="Current logo" class="logo-preview">
                    @endif
                    <input id="site_logo" name="site_logo" type="file" accept="image/*">
                </div>
            </div>
            <div class="form-field">
                <label for="site_email">Contact Email</label>
                <input id="site_email" name="site_email" type="email" value="{{ old('site_email', $values['site_email'] ?? '') }}" required>
            </div>
            <div class="form-field full-width">
                <label for="site_clinic_hours">Clinic Hours</label>
                <textarea id="site_clinic_hours" name="site_clinic_hours" rows="3">{{ old('site_clinic_hours', $values['site_clinic_hours'] ?? '') }}</textarea>
                <p class="help-text">Use new lines for each schedule entry, e.g. Monday – Friday: 8 AM – 7 PM.</p>
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
                <label for="site_admin_email">Admin Email</label>
                <input id="site_admin_email" name="site_admin_email" type="email" value="{{ old('site_admin_email', $values['site_admin_email'] ?? '') }}" required>
            </div>
            <div class="form-field">
                <label for="pagination_default">Pagination Default</label>
                <input id="pagination_default" name="pagination_default" type="number" min="1" max="100" value="{{ old('pagination_default', $values['pagination_default'] ?? 10) }}" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection
