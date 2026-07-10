@extends('layouts.admin')

@section('title', 'Users | OrthoCore Admin')

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
    .modal-overlay.active { display: flex; }
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
    <h1>Users</h1>
    <p>View and manage registered users in the clinic portal.</p>
</div>

<div class="panel">
    <div class="panel-head">
        <div>
            <h3>Registered users</h3>
            <p class="panel-caption">Search, create, and manage clinic accounts from one place.</p>
        </div>
        <div class="panel-tools">
            <label class="search-shell" for="user-search-input">
                <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <input id="user-search-input" class="search-input" type="search" placeholder="Search by name, email, phone, or address">
                <button id="clear-search-btn" type="button" class="search-clear-btn">Clear</button>
            </label>
            <button id="create-user-btn" type="button" class="create-btn">
                <span aria-hidden="true">+</span> Create User
            </button>
        </div>
    </div>
    <div id="user-list" class="table-wrap">Loading users...</div>
    <div class="pagination-controls">
        <button id="prev-page" type="button" class="page-btn">Previous</button>
        <span id="page-info" class="page-info">Page 1 of 1</span>
        <button id="next-page" type="button" class="page-btn">Next</button>
    </div>
</div>

{{-- Edit User Modal --}}
<div id="edit-user-modal" class="modal-overlay" aria-hidden="true">
    <div class="edit-modal" role="dialog" aria-modal="true" aria-labelledby="edit-user-title">
        <div class="edit-modal-header">
            <div>
                <h2 id="edit-user-title" class="edit-modal-title">Edit User</h2>
                <p class="edit-modal-subtitle">Update user details and save changes.</p>
            </div>
            <button id="close-edit-modal" type="button" class="modal-close-btn" aria-label="Close">&times;</button>
        </div>
        <form id="edit-user-form" class="edit-form">
            <input id="edit-user-id" type="hidden" name="user_id">
            <div class="edit-grid">
                <div class="edit-field"><label class="edit-label" for="edit-name">Name</label><input id="edit-name" name="name" class="edit-input" type="text" maxlength="255" required></div>
                <div class="edit-field"><label class="edit-label" for="edit-email">Email</label><input id="edit-email" name="email" class="edit-input" type="email" maxlength="255" required></div>
                <div class="edit-field contact-field"><label class="edit-label" for="edit-contact-number">Contact No</label><input id="edit-contact-number" name="Contact_Number" class="edit-input" type="text" maxlength="20"></div>
                <div class="edit-field address-field"><label class="edit-label" for="edit-address">Address</label><textarea id="edit-address" name="address" class="edit-input" maxlength="255" rows="1"></textarea></div>
                <div class="edit-field"><label class="edit-label" for="edit-role">Role</label><select id="edit-role" name="role_id" class="edit-input"><option value="">Select role</option></select></div>
            </div>
            <div id="edit-form-error" class="edit-form-error" aria-live="polite"></div>
            <div class="edit-form-actions">
                <button id="cancel-edit-btn" type="button" class="btn-secondary">Cancel</button>
                <button id="save-edit-btn" type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Create User Modal --}}
<div id="create-user-modal" class="modal-overlay" aria-hidden="true">
    <div class="edit-modal" role="dialog" aria-modal="true" aria-labelledby="create-user-title">
        <div class="edit-modal-header">
            <div>
                <h2 id="create-user-title" class="edit-modal-title">Create User</h2>
                <p class="edit-modal-subtitle">Add a new clinic user account.</p>
            </div>
            <button id="close-create-modal" type="button" class="modal-close-btn" aria-label="Close">&times;</button>
        </div>
        <form id="create-user-form" class="edit-form">
            <div class="edit-grid">
                <div class="edit-field"><label class="edit-label" for="create-name">Name</label><input id="create-name" name="name" class="edit-input" type="text" maxlength="255" required></div>
                <div class="edit-field"><label class="edit-label" for="create-email">Email</label><input id="create-email" name="email" class="edit-input" type="email" maxlength="255" required></div>
                <div class="edit-field"><label class="edit-label" for="create-contact-number">Contact No</label><input id="create-contact-number" name="Contact_Number" class="edit-input" type="text" maxlength="20" required></div>
                <div class="edit-field"><label class="edit-label" for="create-address">Address</label><textarea id="create-address" name="address" class="edit-input" maxlength="255" rows="1" required></textarea></div>
                <div class="edit-field"><label class="edit-label" for="create-password">Password</label><input id="create-password" name="password" class="edit-input" type="password" minlength="8" required></div>
                <div class="edit-field"><label class="edit-label" for="create-password-confirmation">Confirm Password</label><input id="create-password-confirmation" name="password_confirmation" class="edit-input" type="password" minlength="8" required></div>
            </div>
            <div id="create-form-error" class="edit-form-error" aria-live="polite"></div>
            <div class="edit-form-actions">
                <button id="cancel-create-btn" type="button" class="btn-secondary">Cancel</button>
                <button id="save-create-btn" type="submit" class="btn-primary">Create User</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete User Modal --}}
<div id="delete-user-modal" class="modal-overlay" aria-hidden="true">
    <div class="edit-modal confirm-modal" role="dialog" aria-modal="true" aria-labelledby="delete-user-title">
        <div class="edit-modal-header">
            <div>
                <h2 id="delete-user-title" class="edit-modal-title">Delete User</h2>
                <p class="edit-modal-subtitle">This action cannot be undone.</p>
            </div>
            <button id="close-delete-modal" type="button" class="modal-close-btn" aria-label="Close">&times;</button>
        </div>
        <div class="confirm-modal-body">
            <h3 class="confirm-title">Are you sure?</h3>
            <p class="confirm-text">Deleting this user will permanently remove their account record.</p>
            <div id="delete-form-error" class="confirm-error" aria-live="polite"></div>
            <div class="confirm-actions">
                <button id="cancel-delete-btn" type="button" class="btn-secondary">Cancel</button>
                <button id="confirm-delete-btn" type="button" class="btn-danger">Delete User</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const endpoint = '{{ route("get-users") }}';
        const container = document.getElementById('user-list');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        const pageInfo = document.getElementById('page-info');
        const createBtn = document.getElementById('create-user-btn');
        const searchInput = document.getElementById('user-search-input');
        const clearSearchBtn = document.getElementById('clear-search-btn');
        const registerSubmitUrl = '{{ route("admin.users.store") }}';
        const searchUsersUrl = '{{ route("userSearch") }}';
        const updateUrlTemplate = '{{ route("users.update", ["id" => "__ID__"]) }}';
        const deleteUrlTemplate = '{{ route("users.delete", ["id" => "__ID__"]) }}';
        const roleOptionsUrl = '{{ route("get-role-options") }}';
        const csrfToken = '{{ csrf_token() }}';
        const editModal = document.getElementById('edit-user-modal');
        const closeModalBtn = document.getElementById('close-edit-modal');
        const cancelEditBtn = document.getElementById('cancel-edit-btn');
        const editForm = document.getElementById('edit-user-form');
        const editFormError = document.getElementById('edit-form-error');
        const editUserId = document.getElementById('edit-user-id');
        const editName = document.getElementById('edit-name');
        const editEmail = document.getElementById('edit-email');
        const editContactNumber = document.getElementById('edit-contact-number');
        const editAddress = document.getElementById('edit-address');
        const editRoleSelect = document.getElementById('edit-role');
        const saveEditBtn = document.getElementById('save-edit-btn');
        const createModal = document.getElementById('create-user-modal');
        const closeCreateModalBtn = document.getElementById('close-create-modal');
        const cancelCreateBtn = document.getElementById('cancel-create-btn');
        const createForm = document.getElementById('create-user-form');
        const createFormError = document.getElementById('create-form-error');
        const createName = document.getElementById('create-name');
        const createEmail = document.getElementById('create-email');
        const createContactNumber = document.getElementById('create-contact-number');
        const createAddress = document.getElementById('create-address');
        const createPassword = document.getElementById('create-password');
        const createPasswordConfirmation = document.getElementById('create-password-confirmation');
        const saveCreateBtn = document.getElementById('save-create-btn');
        const deleteModal = document.getElementById('delete-user-modal');
        const closeDeleteModalBtn = document.getElementById('close-delete-modal');
        const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        const deleteFormError = document.getElementById('delete-form-error');

        if (!container || !prevBtn || !nextBtn || !pageInfo || !createBtn || !searchInput || !clearSearchBtn || !editModal || !editForm || !editUserId || !editName || !editEmail || !editContactNumber || !editAddress || !editRoleSelect || !saveEditBtn || !editFormError || !createModal || !createForm || !createFormError || !createName || !createEmail || !createContactNumber || !createAddress || !createPassword || !createPasswordConfirmation || !saveCreateBtn || !deleteModal || !confirmDeleteBtn || !deleteFormError) return;

        let currentPage = 1;
        let lastPage = 1;
        let isLoading = false;
        let pendingDeleteUserId = null;
        let searchTerm = '';
        let searchDebounceId = null;

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function encodeAttr(value) {
            return encodeURIComponent(String(value || ''));
        }

        function decodeAttr(value) {
            try {
                return decodeURIComponent(value || '');
            } catch (_) {
                return value || '';
            }
        }

        function setFormSubmitting(isSubmitting) {
            saveEditBtn.disabled = isSubmitting;
            if (cancelEditBtn) cancelEditBtn.disabled = isSubmitting;
            if (closeModalBtn) closeModalBtn.disabled = isSubmitting;
            saveEditBtn.textContent = isSubmitting ? 'Saving...' : 'Save Changes';
        }

        function setCreateFormSubmitting(isSubmitting) {
            saveCreateBtn.disabled = isSubmitting;
            if (cancelCreateBtn) cancelCreateBtn.disabled = isSubmitting;
            if (closeCreateModalBtn) closeCreateModalBtn.disabled = isSubmitting;
            saveCreateBtn.textContent = isSubmitting ? 'Creating...' : 'Create User';
        }

        function setDeleteSubmitting(isSubmitting) {
            confirmDeleteBtn.disabled = isSubmitting;
            if (cancelDeleteBtn) cancelDeleteBtn.disabled = isSubmitting;
            if (closeDeleteModalBtn) closeDeleteModalBtn.disabled = isSubmitting;
            confirmDeleteBtn.textContent = isSubmitting ? 'Deleting...' : 'Delete User';
        }

        function closeEditModal() {
            editModal.classList.remove('active');
            editModal.setAttribute('aria-hidden', 'true');
            editFormError.textContent = '';
            setFormSubmitting(false);
        }

        function openEditModal(user) {
            editUserId.value = user.id || '';
            editName.value = user.name || '';
            editEmail.value = user.email || '';
            editContactNumber.value = user.Contact_Number || '';
            editAddress.value = user.address || '';
            editRoleSelect.value = user.role_id || '';
            editFormError.textContent = '';

            editModal.classList.add('active');
            editModal.setAttribute('aria-hidden', 'false');

            requestAnimationFrame(() => {
                editName.focus();
            });
        }

        function closeCreateModal() {
            createModal.classList.remove('active');
            createModal.setAttribute('aria-hidden', 'true');
            createFormError.textContent = '';
            setCreateFormSubmitting(false);
        }

        function openCreateModal() {
            createForm.reset();
            createFormError.textContent = '';
            createModal.classList.add('active');
            createModal.setAttribute('aria-hidden', 'false');

            requestAnimationFrame(() => {
                createName.focus();
            });
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('active');
            deleteModal.setAttribute('aria-hidden', 'true');
            deleteFormError.textContent = '';
            pendingDeleteUserId = null;
            setDeleteSubmitting(false);
        }

        function openDeleteModal(userId) {
            pendingDeleteUserId = userId;
            deleteFormError.textContent = '';
            deleteModal.classList.add('active');
            deleteModal.setAttribute('aria-hidden', 'false');

            requestAnimationFrame(() => {
                confirmDeleteBtn.focus();
            });
        }

        function deleteUserById(userId) {
            deleteFormError.textContent = '';
            setDeleteSubmitting(true);

            fetch(deleteUrlTemplate.replace('__ID__', encodeURIComponent(userId)), {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
                .then(async response => {
                    if (!response.ok) {
                        const errorPayload = await response.json().catch(() => null);
                        throw new Error(errorPayload?.message || 'Unable to delete user.');
                    }
                    return response.json();
                })
                .then(() => {
                    closeDeleteModal();
                    loadUsers(currentPage);
                })
                .catch(error => {
                    deleteFormError.textContent = error.message || 'Unable to delete user.';
                })
                .finally(() => {
                    setDeleteSubmitting(false);
                });
        }

        function renderUsers(users) {
            if (!Array.isArray(users) || users.length === 0) {
                container.innerHTML = `
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th class="action-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="table-empty">No users found.</td>
                            </tr>
                        </tbody>
                    </table>
                `;
                return;
            }

            const rows = users.map(user => {
                const phone = user.Contact_Number || user.contact_number || user.phone_number || user.phone || 'N/A';
                const address = user.address || 'N/A';
                const name = user.name || 'Unnamed user';
                const email = user.email || 'No email available';

                const safeName = escapeHtml(name);
                const safeEmail = escapeHtml(email);
                const safePhone = escapeHtml(phone);
                const safeAddress = escapeHtml(address);
                const userId = Number(user.id) || '';
                const roleIdValue = Array.isArray(user.roles) && user.roles.length > 0
                    ? user.roles[0].id
                    : '';

                return `
                    <tr>
                        <td class="user-name">${safeName}</td>
                        <td class="user-email">${safeEmail}</td>
                        <td>${safePhone}</td>
                        <td>${safeAddress}</td>
                        <td class="action-cell">
                            <div class="action-group">
                                <button
                                    type="button"
                                    class="icon-btn edit-btn"
                                    title="Edit user"
                                    data-user-id="${userId}"
                                    data-user-name="${encodeAttr(name)}"
                                    data-user-email="${encodeAttr(email)}"
                                    data-user-phone="${encodeAttr(phone === 'N/A' ? '' : phone)}"
                                    data-user-address="${encodeAttr(address === 'N/A' ? '' : address)}"
                                    data-user-role-id="${encodeAttr(roleIdValue)}"
                                >
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M3 17.25V21H6.75L18.37 9.38L14.62 5.63L3 17.25Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                        <path d="M13.5 6.75L17.25 10.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M20.71 7.04C21.1 6.65 21.1 6.02 20.71 5.63L18.37 3.29C17.98 2.9 17.35 2.9 16.96 3.29L15.13 5.12L18.88 8.87L20.71 7.04Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <button type="button" class="icon-btn delete-btn" title="Delete user" data-user-id="${userId}">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M4 7H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M10 11V17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M14 11V17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M6 7L7 19C7.1 20.1 7.9 21 9 21H15C16.1 21 16.9 20.1 17 19L18 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M9 7V5C9 3.9 9.9 3 11 3H13C14.1 3 15 3.9 15 5V7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            container.innerHTML = `
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th class="action-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            `;
        }

        function updateUser(user) {
            const payload = {
                name: String(user.name || '').trim(),
                email: String(user.email || '').trim(),
                Contact_Number: String(user.Contact_Number || '').trim(),
                address: String(user.address || '').trim(),
                role_id: user.role_id ? Number(user.role_id) : null,
            };

            if (!payload.name || !payload.email) {
                editFormError.textContent = 'Name and email are required.';
                return;
            }

            editFormError.textContent = '';
            setFormSubmitting(true);

            fetch(updateUrlTemplate.replace('__ID__', encodeURIComponent(user.id)), {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            })
                .then(async response => {
                    if (!response.ok) {
                        const errorPayload = await response.json().catch(() => null);
                        const firstError = errorPayload?.errors
                            ? Object.values(errorPayload.errors)[0]?.[0]
                            : null;
                        throw new Error(firstError || errorPayload?.message || 'Unable to update user.');
                    }
                    return response.json();
                })
                .then(() => {
                    closeEditModal();
                    loadUsers(currentPage);
                })
                .catch(error => {
                    editFormError.textContent = error.message || 'Unable to update user.';
                })
                .finally(() => {
                    setFormSubmitting(false);
                });
        }

        function updatePaginationState(payload) {
            currentPage = Number(payload.current_page) || 1;
            lastPage = Number(payload.last_page) || 1;

            pageInfo.textContent = `Page ${currentPage} of ${lastPage}`;
            prevBtn.disabled = currentPage <= 1 || isLoading;
            nextBtn.disabled = currentPage >= lastPage || isLoading;
        }

        function setLoadingState(loading) {
            isLoading = loading;
            prevBtn.disabled = loading || currentPage <= 1;
            nextBtn.disabled = loading || currentPage >= lastPage;
        }

        function updateSearchUi() {
            const hasSearch = searchTerm.trim().length > 0;
            clearSearchBtn.classList.toggle('visible', hasSearch);
        }

        let roleOptions = [];

        function loadRoleOptions() {
            return fetch(roleOptionsUrl, {
                headers: {
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (!response.ok) throw new Error('Unable to load role options.');
                    return response.json();
                })
                .then(payload => {
                    roleOptions = Array.isArray(payload) ? payload : [];
                    if (!editRoleSelect) return;

                    editRoleSelect.innerHTML = '<option value="">Select role</option>' + roleOptions.map(role => `
                        <option value="${encodeAttr(role.id)}">${escapeHtml(role.name)}</option>
                    `).join('');
                })
                .catch(() => {
                    roleOptions = [];
                });
        }

        function loadUsers(page) {
            if (isLoading) return;

            setLoadingState(true);
            container.innerHTML = '<div style="padding: 14px; color: #5f6f85;">Loading users...</div>';

            const activeSearch = searchTerm.trim();
            const requestUrl = activeSearch
                ? `${searchUsersUrl}?query=${encodeURIComponent(activeSearch)}&page=${page}`
                : `${endpoint}?page=${page}`;

            fetch(requestUrl, {
                headers: {
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Request failed');
                    }
                    return response.json();
                })
                .then(payload => {
                    const users = Array.isArray(payload.data) ? payload.data : [];
                    renderUsers(users);
                    updatePaginationState(payload);
                })
                .catch(() => {
                    container.innerHTML = '<div style="padding: 14px; color: #b3261e;">Unable to load users right now.</div>';
                })
                .finally(() => {
                    setLoadingState(false);
                });
        }

        if (createBtn) {
            createBtn.addEventListener('click', function () {
                openCreateModal();
            });
        }

        searchInput.addEventListener('input', function (event) {
            searchTerm = event.target.value;
            updateSearchUi();

            if (searchDebounceId) {
                clearTimeout(searchDebounceId);
            }

            searchDebounceId = window.setTimeout(function () {
                loadUsers(1);
            }, 250);
        });

        clearSearchBtn.addEventListener('click', function () {
            searchTerm = '';
            searchInput.value = '';
            updateSearchUi();

            if (searchDebounceId) {
                clearTimeout(searchDebounceId);
            }

            loadUsers(1);
            searchInput.focus();
        });

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closeEditModal);
        }

        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', closeEditModal);
        }

        if (closeCreateModalBtn) {
            closeCreateModalBtn.addEventListener('click', closeCreateModal);
        }

        if (cancelCreateBtn) {
            cancelCreateBtn.addEventListener('click', closeCreateModal);
        }

        if (closeDeleteModalBtn) {
            closeDeleteModalBtn.addEventListener('click', closeDeleteModal);
        }

        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', closeDeleteModal);
        }

        confirmDeleteBtn.addEventListener('click', function () {
            if (!pendingDeleteUserId) {
                deleteFormError.textContent = 'Invalid user selected.';
                return;
            }

            deleteUserById(pendingDeleteUserId);
        });

        editModal.addEventListener('click', function (event) {
            if (event.target === editModal) {
                closeEditModal();
            }
        });

        createModal.addEventListener('click', function (event) {
            if (event.target === createModal) {
                closeCreateModal();
            }
        });

        deleteModal.addEventListener('click', function (event) {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && editModal.classList.contains('active')) {
                closeEditModal();
            }

            if (event.key === 'Escape' && createModal.classList.contains('active')) {
                closeCreateModal();
            }

            if (event.key === 'Escape' && deleteModal.classList.contains('active')) {
                closeDeleteModal();
            }
        });

        createForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const payload = {
                name: String(createName.value || '').trim(),
                email: String(createEmail.value || '').trim(),
                Contact_Number: String(createContactNumber.value || '').trim(),
                address: String(createAddress.value || '').trim(),
                password: String(createPassword.value || ''),
                password_confirmation: String(createPasswordConfirmation.value || ''),
            };

            if (!payload.name || !payload.email || !payload.Contact_Number || !payload.address || !payload.password || !payload.password_confirmation) {
                createFormError.textContent = 'All fields are required.';
                return;
            }

            if (payload.password !== payload.password_confirmation) {
                createFormError.textContent = 'Password confirmation does not match.';
                return;
            }

            createFormError.textContent = '';
            setCreateFormSubmitting(true);

            fetch(registerSubmitUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            })
                .then(async response => {
                    if (!response.ok) {
                        const errorPayload = await response.json().catch(() => null);
                        const firstError = errorPayload?.errors
                            ? Object.values(errorPayload.errors)[0]?.[0]
                            : null;
                        throw new Error(firstError || errorPayload?.message || 'Unable to create user.');
                    }
                    return response.json();
                })
                .then(() => {
                    closeCreateModal();
                    loadUsers(1);
                })
                .catch(error => {
                    createFormError.textContent = error.message || 'Unable to create user.';
                })
                .finally(() => {
                    setCreateFormSubmitting(false);
                });
        });

        editForm.addEventListener('submit', function (event) {
            event.preventDefault();

            updateUser({
                id: editUserId.value,
                name: editName.value,
                email: editEmail.value,
                Contact_Number: editContactNumber.value,
                address: editAddress.value,
                role_id: editRoleSelect.value,
            });
        });

        container.addEventListener('click', function (event) {
            const editBtn = event.target.closest('.edit-btn');
            if (editBtn) {
                const userId = editBtn.getAttribute('data-user-id');
                if (!userId) {
                    alert('Invalid user selected.');
                    return;
                }

                openEditModal({
                    id: userId,
                    name: decodeAttr(editBtn.getAttribute('data-user-name')),
                    email: decodeAttr(editBtn.getAttribute('data-user-email')),
                    Contact_Number: decodeAttr(editBtn.getAttribute('data-user-phone')),
                    address: decodeAttr(editBtn.getAttribute('data-user-address')),
                    role_id: decodeAttr(editBtn.getAttribute('data-user-role-id')),
                });
                return;
            }

            const deleteBtn = event.target.closest('.delete-btn');
            if (!deleteBtn) return;

            const userId = deleteBtn.getAttribute('data-user-id');
            if (!userId) {
                alert('Invalid user selected.');
                return;
            }

            openDeleteModal(userId);
        });

        prevBtn.addEventListener('click', function () {
            if (currentPage > 1) {
                loadUsers(currentPage - 1);
            }
        });

        nextBtn.addEventListener('click', function () {
            if (currentPage < lastPage) {
                loadUsers(currentPage + 1);
            }
        });

        loadRoleOptions().finally(() => {
            loadUsers(1);
            updateSearchUi();
        });
    });
</script>
@endpush