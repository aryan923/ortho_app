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
        border: 1px solid #e2e8f0;
        border-radius: 28px;
        padding: 32px;
        box-shadow: 0 18px 48px rgba(15, 31, 58, 0.08);
    }
    .panel-card h1 {
        margin: 0 0 8px;
        font-size: 1.8rem;
        font-weight: 800;
        color: #0f172a;
    }
    .panel-description {
        margin: 0 0 24px;
        font-size: 0.95rem;
        line-height: 1.7;
        color: #64748b;
    }
    .page-section {
        margin-bottom: 30px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        background: #f8fafc;
    }
    .page-section h2 {
        margin: 0 0 18px;
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
    }
    .field-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(240px, 1fr));
        gap: 18px;
    }
    .field-card {
        display: grid;
        gap: 8px;
    }
    .field-card label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #475569;
    }
    .field-card input,
    .field-card textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        padding: 12px 14px;
        font-size: 14px;
        color: #0f172a;
        background: #fff;
    }
    .field-card textarea {
        min-height: 90px;
    }
    .field-card.full-width {
        grid-column: 1 / -1;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 28px;
    }
    .btn-primary {
        border: 0;
        background: linear-gradient(135deg, #1253c8, #2877ff);
        color: #fff;
        border-radius: 14px;
        padding: 12px 22px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 10px 24px rgba(18, 83, 200, 0.18);
    }
    .alert {
        padding: 14px 18px;
        border-radius: 14px;
        background: #e6f4ff;
        color: #0f385d;
        border: 1px solid #c9e2ff;
        margin-bottom: 20px;
    }
    @media (max-width: 920px) {
        .admin-shell { grid-template-columns: 1fr; }
        .field-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush
