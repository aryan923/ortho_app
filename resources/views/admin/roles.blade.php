@extends('layouts.admin')

@section('title', 'Roles | OrthoCore Admin')

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
    <h1>Roles</h1>
    <p>Manage role names, status, and permissions assignment structure.</p>
</div>

<div class="panel">
    <div class="panel-head">
        <div>
            <h3>Role list</h3>
            <p class="panel-caption">Use role status to control availability in your system.</p>
        </div>
        <button id="create-role-btn" type="button" class="create-btn">
            <span aria-hidden="true">+</span> Create Role
        </button>
    </div>
    <div id="role-list" class="table-wrap">Loading roles...</div>
    <div class="pagination-controls">
        <button id="prev-page" type="button" class="page-btn">Previous</button>
        <span id="page-info" class="page-info">Page 1 of 1</span>
        <button id="next-page" type="button" class="page-btn">Next</button>
    </div>
</div>

{{-- Create Role Modal --}}
<div id="create-role-modal" class="modal-overlay" aria-hidden="true">
    <div class="edit-modal" role="dialog" aria-modal="true" aria-labelledby="create-role-title">
        <div class="edit-modal-header">
            <div>
                <h2 id="create-role-title" class="edit-modal-title">Create Role</h2>
                <p class="edit-modal-subtitle">Add a new role with status.</p>
            </div>
            <button id="close-create-role-modal" type="button" class="modal-close-btn" aria-label="Close">&times;</button>
        </div>
        <form id="create-role-form" class="edit-form">
            <div class="edit-grid">
                <div class="edit-field"><label class="edit-label" for="create-role-name">Role Name</label><input id="create-role-name" class="edit-input" type="text" maxlength="255" required></div>
                <div class="edit-field"><label class="edit-label" for="create-role-status">Status</label><select id="create-role-status" class="edit-select" required><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
            </div>
            <div id="create-role-error" class="edit-form-error" aria-live="polite"></div>
            <div class="edit-form-actions">
                <button id="cancel-create-role-btn" type="button" class="btn-secondary">Cancel</button>
                <button id="save-create-role-btn" type="submit" class="btn-primary">Create Role</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Role Modal --}}
<div id="edit-role-modal" class="modal-overlay" aria-hidden="true">
    <div class="edit-modal" role="dialog" aria-modal="true" aria-labelledby="edit-role-title">
        <div class="edit-modal-header">
            <div>
                <h2 id="edit-role-title" class="edit-modal-title">Edit Role</h2>
                <p class="edit-modal-subtitle">Update role details.</p>
            </div>
            <button id="close-edit-role-modal" type="button" class="modal-close-btn" aria-label="Close">&times;</button>
        </div>
        <form id="edit-role-form" class="edit-form">
            <input id="edit-role-id" type="hidden">
            <div class="edit-grid">
                <div class="edit-field"><label class="edit-label" for="edit-role-name">Role Name</label><input id="edit-role-name" class="edit-input" type="text" maxlength="255" required></div>
                <div class="edit-field"><label class="edit-label" for="edit-role-status">Status</label><select id="edit-role-status" class="edit-select" required><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
                <div class="edit-field permissions-field"><label class="edit-label">Permissions</label><div id="edit-role-permissions" class="permissions-list"><div class="permission-empty">Loading permissions...</div></div></div>
            </div>
            <div id="edit-role-error" class="edit-form-error" aria-live="polite"></div>
            <div class="edit-form-actions">
                <button id="cancel-edit-role-btn" type="button" class="btn-secondary">Cancel</button>
                <button id="save-edit-role-btn" type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Role Modal --}}
<div id="delete-role-modal" class="modal-overlay" aria-hidden="true">
    <div class="edit-modal confirm-modal" role="dialog" aria-modal="true" aria-labelledby="delete-role-title">
        <div class="edit-modal-header">
            <div>
                <h2 id="delete-role-title" class="edit-modal-title">Delete Role</h2>
                <p class="edit-modal-subtitle">This action cannot be undone.</p>
            </div>
            <button id="close-delete-role-modal" type="button" class="modal-close-btn" aria-label="Close">&times;</button>
        </div>
        <div class="confirm-modal-body">
            <h3 class="confirm-title">Delete this role?</h3>
            <p class="confirm-text">This will permanently remove the selected role.</p>
            <div id="delete-role-error" class="confirm-error" aria-live="polite"></div>
            <div class="confirm-actions">
                <button id="cancel-delete-role-btn" type="button" class="btn-secondary">Cancel</button>
                <button id="confirm-delete-role-btn" type="button" class="btn-danger">Delete Role</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const rolesEndpoint = '{{ route("get-roles") }}';
			const permissionsEndpoint = '{{ route("get-permissions") }}';
		const createRoleUrl = '{{ route("create-role") }}';
		const editRoleUrlTemplate = '{{ route("edit-role", ["id" => "__ID__"]) }}';
		const deleteRoleUrlTemplate = '{{ route("delete-role", ["id" => "__ID__"]) }}';
		const csrfToken = '{{ csrf_token() }}';

		const roleList = document.getElementById('role-list');
		const prevBtn = document.getElementById('prev-page');
		const nextBtn = document.getElementById('next-page');
		const pageInfo = document.getElementById('page-info');
		const createRoleBtn = document.getElementById('create-role-btn');

		const createRoleModal = document.getElementById('create-role-modal');
		const closeCreateRoleModal = document.getElementById('close-create-role-modal');
		const cancelCreateRoleBtn = document.getElementById('cancel-create-role-btn');
		const createRoleForm = document.getElementById('create-role-form');
		const createRoleName = document.getElementById('create-role-name');
		const createRoleStatus = document.getElementById('create-role-status');
		const createRoleError = document.getElementById('create-role-error');
		const saveCreateRoleBtn = document.getElementById('save-create-role-btn');

		const editRoleModal = document.getElementById('edit-role-modal');
		const closeEditRoleModal = document.getElementById('close-edit-role-modal');
		const cancelEditRoleBtn = document.getElementById('cancel-edit-role-btn');
		const editRoleForm = document.getElementById('edit-role-form');
		const editRoleId = document.getElementById('edit-role-id');
		const editRoleName = document.getElementById('edit-role-name');
		const editRoleStatus = document.getElementById('edit-role-status');
			const editRolePermissions = document.getElementById('edit-role-permissions');
		const editRoleError = document.getElementById('edit-role-error');
		const saveEditRoleBtn = document.getElementById('save-edit-role-btn');

		const deleteRoleModal = document.getElementById('delete-role-modal');
		const closeDeleteRoleModal = document.getElementById('close-delete-role-modal');
		const cancelDeleteRoleBtn = document.getElementById('cancel-delete-role-btn');
		const confirmDeleteRoleBtn = document.getElementById('confirm-delete-role-btn');
		const deleteRoleError = document.getElementById('delete-role-error');

			if (!roleList || !prevBtn || !nextBtn || !pageInfo || !createRoleBtn || !createRoleModal || !createRoleForm || !createRoleName || !createRoleStatus || !saveCreateRoleBtn || !editRoleModal || !editRoleForm || !editRoleId || !editRoleName || !editRoleStatus || !editRolePermissions || !saveEditRoleBtn || !deleteRoleModal || !confirmDeleteRoleBtn || !deleteRoleError) return;

		let currentPage = 1;
		let lastPage = 1;
		let isLoading = false;
		let pendingDeleteRoleId = null;
			let permissionCatalog = [];

		function escapeHtml(value) {
			return String(value)
				.replace(/&/g, '&amp;')
				.replace(/</g, '&lt;')
				.replace(/>/g, '&gt;')
				.replace(/"/g, '&quot;')
				.replace(/'/g, '&#39;');
		}

		function setCreateSubmitting(isSubmitting) {
			saveCreateRoleBtn.disabled = isSubmitting;
			if (cancelCreateRoleBtn) cancelCreateRoleBtn.disabled = isSubmitting;
			if (closeCreateRoleModal) closeCreateRoleModal.disabled = isSubmitting;
			saveCreateRoleBtn.textContent = isSubmitting ? 'Creating...' : 'Create Role';
		}

		function setEditSubmitting(isSubmitting) {
			saveEditRoleBtn.disabled = isSubmitting;
			if (cancelEditRoleBtn) cancelEditRoleBtn.disabled = isSubmitting;
			if (closeEditRoleModal) closeEditRoleModal.disabled = isSubmitting;
			saveEditRoleBtn.textContent = isSubmitting ? 'Saving...' : 'Save Changes';
		}

		function setDeleteSubmitting(isSubmitting) {
			confirmDeleteRoleBtn.disabled = isSubmitting;
			if (cancelDeleteRoleBtn) cancelDeleteRoleBtn.disabled = isSubmitting;
			if (closeDeleteRoleModal) closeDeleteRoleModal.disabled = isSubmitting;
			confirmDeleteRoleBtn.textContent = isSubmitting ? 'Deleting...' : 'Delete Role';
		}

		function setLoadingState(loading) {
			isLoading = loading;
			prevBtn.disabled = loading || currentPage <= 1;
			nextBtn.disabled = loading || currentPage >= lastPage;
		}

			function permissionLabel(name) {
				return String(name || '')
					.replace(/([a-z])([A-Z])/g, '$1 $2')
					.replace(/[_-]/g, ' ');
			}

			function renderEditPermissions(selectedIds) {
				const selectedSet = new Set((selectedIds || []).map(Number));

				if (!Array.isArray(permissionCatalog) || permissionCatalog.length === 0) {
					editRolePermissions.innerHTML = '<div class="permission-empty">No permissions available.</div>';
					return;
				}

				const groups = {
					users: [],
					roles: [],
				};

				permissionCatalog.forEach(function (permission) {
					const key = String(permission.group || '').toLowerCase();
					if (key === 'users' || key === 'roles') {
						groups[key].push(permission);
					}
				});

				const renderGroup = function (title, items) {
					if (!items.length) {
						return `
							<div class="permission-group-row">
								<div class="permission-group-title">${title}</div>
								<div class="permission-empty">No permissions found.</div>
							</div>
						`;
					}

					const checkboxes = items.map(function (permission) {
						const id = Number(permission.id);
						const checked = selectedSet.has(id) ? 'checked' : '';
						return `
							<label class="permission-row">
								<input type="checkbox" class="permission-checkbox" value="${id}" ${checked}>
								<span>${escapeHtml(permissionLabel(permission.name))}</span>
							</label>
						`;
					}).join('');

					return `
						<div class="permission-group-row">
							<div class="permission-group-title">${title}</div>
							<div class="permission-group-items">${checkboxes}</div>
						</div>
					`;
				};

				editRolePermissions.innerHTML = [
					renderGroup('Users', groups.users),
					renderGroup('Roles', groups.roles),
				].join('');
			}

			function loadPermissions() {
				return fetch(permissionsEndpoint, {
					headers: { 'Accept': 'application/json' },
				})
					.then(response => {
						if (!response.ok) throw new Error('Unable to load permissions.');
						return response.json();
					})
					.then(payload => {
						permissionCatalog = Array.isArray(payload) ? payload : [];
					});
			}

		function updatePagination(payload) {
			currentPage = Number(payload.current_page) || 1;
			lastPage = Number(payload.last_page) || 1;
			pageInfo.textContent = `Page ${currentPage} of ${lastPage}`;
			prevBtn.disabled = currentPage <= 1 || isLoading;
			nextBtn.disabled = currentPage >= lastPage || isLoading;
		}

		function renderRoles(roles) {
			if (!Array.isArray(roles) || roles.length === 0) {
				roleList.innerHTML = `
					<table class="roles-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Status</th>
								<th class="action-cell">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3" class="table-empty">No roles found.</td>
							</tr>
						</tbody>
					</table>
				`;
				return;
			}

			const rows = roles.map(role => {
				const roleId = Number(role.id) || '';
				const name = escapeHtml(role.name || 'Unnamed role');
				const status = (role.status || 'active').toLowerCase() === 'inactive' ? 'inactive' : 'active';
				const statusLabel = status === 'active' ? 'Active' : 'Inactive';
				const permissionIds = Array.isArray(role.permissions)
					? role.permissions.map(item => Number(item.id)).filter(Number.isFinite)
					: [];

				return `
					<tr>
						<td class="role-name">${name}</td>
						<td><span class="pill ${status}">${statusLabel}</span></td>
						<td class="action-cell">
							<div class="action-group">
								<button
									type="button"
									class="icon-btn edit-btn"
									title="Edit role"
									data-role-id="${roleId}"
									data-role-name="${encodeURIComponent(role.name || '')}"
									data-role-status="${status}"
									data-role-permissions="${encodeURIComponent(JSON.stringify(permissionIds))}"
								>
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
										<path d="M3 17.25V21H6.75L18.37 9.38L14.62 5.63L3 17.25Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
										<path d="M13.5 6.75L17.25 10.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
									</svg>
								</button>
								<button type="button" class="icon-btn delete-btn" title="Delete role" data-role-id="${roleId}">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
										<path d="M4 7H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
										<path d="M10 11V17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
										<path d="M14 11V17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
										<path d="M6 7L7 19C7.1 20.1 7.9 21 9 21H15C16.1 21 16.9 20.1 17 19L18 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
									</svg>
								</button>
							</div>
						</td>
					</tr>
				`;
			}).join('');

			roleList.innerHTML = `
				<table class="roles-table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Status</th>
							<th class="action-cell">Actions</th>
						</tr>
					</thead>
					<tbody>${rows}</tbody>
				</table>
			`;
		}

		function loadRoles(page) {
			if (isLoading) return;
			setLoadingState(true);
			roleList.innerHTML = '<div style="padding: 14px; color: #5f6f85;">Loading roles...</div>';

			fetch(`${rolesEndpoint}?page=${page}`, {
				headers: { 'Accept': 'application/json' },
			})
				.then(response => {
					if (!response.ok) throw new Error('Request failed');
					return response.json();
				})
				.then(payload => {
					const roles = Array.isArray(payload.data) ? payload.data : [];
					renderRoles(roles);
					updatePagination(payload);
				})
				.catch(() => {
					roleList.innerHTML = '<div style="padding: 14px; color: #b3261e;">Unable to load roles right now.</div>';
				})
				.finally(() => {
					setLoadingState(false);
				});
		}

		function openCreateModal() {
			createRoleForm.reset();
			createRoleStatus.value = 'active';
			createRoleError.textContent = '';
			createRoleModal.classList.add('active');
			createRoleModal.setAttribute('aria-hidden', 'false');
			requestAnimationFrame(() => createRoleName.focus());
		}

		function closeCreateModal() {
			createRoleModal.classList.remove('active');
			createRoleModal.setAttribute('aria-hidden', 'true');
			createRoleError.textContent = '';
			setCreateSubmitting(false);
		}

		function openEditModal(roleData) {
			editRoleId.value = roleData.id;
			editRoleName.value = roleData.name || '';
			editRoleStatus.value = roleData.status || 'active';
				renderEditPermissions(roleData.permissionIds || []);
			editRoleError.textContent = '';
			editRoleModal.classList.add('active');
			editRoleModal.setAttribute('aria-hidden', 'false');
			requestAnimationFrame(() => editRoleName.focus());
		}

		function closeEditModal() {
			editRoleModal.classList.remove('active');
			editRoleModal.setAttribute('aria-hidden', 'true');
			editRoleError.textContent = '';
			setEditSubmitting(false);
		}

		function openDeleteModal(roleId) {
			pendingDeleteRoleId = roleId;
			deleteRoleError.textContent = '';
			deleteRoleModal.classList.add('active');
			deleteRoleModal.setAttribute('aria-hidden', 'false');
		}

		function closeDeleteModal() {
			deleteRoleModal.classList.remove('active');
			deleteRoleModal.setAttribute('aria-hidden', 'true');
			deleteRoleError.textContent = '';
			pendingDeleteRoleId = null;
			setDeleteSubmitting(false);
		}

		createRoleBtn.addEventListener('click', openCreateModal);

		if (closeCreateRoleModal) closeCreateRoleModal.addEventListener('click', closeCreateModal);
		if (cancelCreateRoleBtn) cancelCreateRoleBtn.addEventListener('click', closeCreateModal);
		if (closeEditRoleModal) closeEditRoleModal.addEventListener('click', closeEditModal);
		if (cancelEditRoleBtn) cancelEditRoleBtn.addEventListener('click', closeEditModal);
		if (closeDeleteRoleModal) closeDeleteRoleModal.addEventListener('click', closeDeleteModal);
		if (cancelDeleteRoleBtn) cancelDeleteRoleBtn.addEventListener('click', closeDeleteModal);

		createRoleForm.addEventListener('submit', function (event) {
			event.preventDefault();

			const payload = {
				name: String(createRoleName.value || '').trim(),
				status: createRoleStatus.value || 'active',
			};

			if (!payload.name) {
				createRoleError.textContent = 'Role name is required.';
				return;
			}

			createRoleError.textContent = '';
			setCreateSubmitting(true);

			fetch(createRoleUrl, {
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
						throw new Error(firstError || errorPayload?.message || 'Unable to create role.');
					}
					return response.json();
				})
				.then(() => {
					closeCreateModal();
					loadRoles(1);
				})
				.catch(error => {
					createRoleError.textContent = error.message || 'Unable to create role.';
				})
				.finally(() => {
					setCreateSubmitting(false);
				});
		});

		editRoleForm.addEventListener('submit', function (event) {
			event.preventDefault();

			const roleId = editRoleId.value;
			const selectedPermissions = Array.from(editRoleForm.querySelectorAll('.permission-checkbox:checked'))
				.map(function (element) { return Number(element.value); })
				.filter(Number.isFinite);
			const payload = {
				name: String(editRoleName.value || '').trim(),
				status: editRoleStatus.value || 'active',
				permissions: selectedPermissions,
			};

			if (!roleId || !payload.name) {
				editRoleError.textContent = 'Role name is required.';
				return;
			}

			editRoleError.textContent = '';
			setEditSubmitting(true);

			fetch(editRoleUrlTemplate.replace('__ID__', encodeURIComponent(roleId)), {
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
						throw new Error(firstError || errorPayload?.message || 'Unable to update role.');
					}
					return response.json();
				})
				.then(() => {
					closeEditModal();
					loadRoles(currentPage);
				})
				.catch(error => {
					editRoleError.textContent = error.message || 'Unable to update role.';
				})
				.finally(() => {
					setEditSubmitting(false);
				});
		});

		confirmDeleteRoleBtn.addEventListener('click', function () {
			if (!pendingDeleteRoleId) {
				deleteRoleError.textContent = 'Invalid role selected.';
				return;
			}

			setDeleteSubmitting(true);
			deleteRoleError.textContent = '';

			fetch(deleteRoleUrlTemplate.replace('__ID__', encodeURIComponent(pendingDeleteRoleId)), {
				method: 'DELETE',
				headers: {
					'Accept': 'application/json',
					'X-CSRF-TOKEN': csrfToken,
				},
			})
				.then(async response => {
					if (!response.ok) {
						const errorPayload = await response.json().catch(() => null);
						throw new Error(errorPayload?.message || 'Unable to delete role.');
					}
					return response.json();
				})
				.then(() => {
					closeDeleteModal();
					loadRoles(currentPage);
				})
				.catch(error => {
					deleteRoleError.textContent = error.message || 'Unable to delete role.';
				})
				.finally(() => {
					setDeleteSubmitting(false);
				});
		});

		roleList.addEventListener('click', function (event) {
			const editBtn = event.target.closest('.edit-btn');
			if (editBtn) {
				const roleId = editBtn.getAttribute('data-role-id');
				if (!roleId) return;
				let permissionIds = [];
				const encodedPermissions = editBtn.getAttribute('data-role-permissions') || '';
				if (encodedPermissions) {
					try {
						const parsed = JSON.parse(decodeURIComponent(encodedPermissions));
						permissionIds = Array.isArray(parsed) ? parsed : [];
					} catch (error) {
						permissionIds = [];
					}
				}

				openEditModal({
					id: roleId,
					name: decodeURIComponent(editBtn.getAttribute('data-role-name') || ''),
					status: editBtn.getAttribute('data-role-status') || 'active',
					permissionIds: permissionIds,
				});
				return;
			}

			const deleteBtn = event.target.closest('.delete-btn');
			if (!deleteBtn) return;

			const roleId = deleteBtn.getAttribute('data-role-id');
			if (!roleId) return;
			openDeleteModal(roleId);
		});

		prevBtn.addEventListener('click', function () {
			if (currentPage > 1) loadRoles(currentPage - 1);
		});

		nextBtn.addEventListener('click', function () {
			if (currentPage < lastPage) loadRoles(currentPage + 1);
		});

		[createRoleModal, editRoleModal, deleteRoleModal].forEach(function (modal) {
			modal.addEventListener('click', function (event) {
				if (event.target !== modal) return;
				if (modal === createRoleModal) closeCreateModal();
				if (modal === editRoleModal) closeEditModal();
				if (modal === deleteRoleModal) closeDeleteModal();
			});
		});

		document.addEventListener('keydown', function (event) {
			if (event.key !== 'Escape') return;
			if (createRoleModal.classList.contains('active')) closeCreateModal();
			if (editRoleModal.classList.contains('active')) closeEditModal();
			if (deleteRoleModal.classList.contains('active')) closeDeleteModal();
		});

			loadPermissions()
				.catch(() => {
					permissionCatalog = [];
				});

			loadRoles(1);
	});
</script>
@endpush