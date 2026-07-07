@extends('layouts.app')

@section('title', 'Roles | OrthoCore Clinic')

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

	.nav-subitem:hover,
	.nav-subitem.active {
		background: rgba(255,255,255,0.1);
		color: #fff;
	}

	.admin-content {
		display: grid;
		gap: 20px;
	}

	.admin-hero,
	.panel-card {
		background: #fff;
		border: 1px solid #dde8f7;
		border-radius: 24px;
		padding: 24px;
		box-shadow: 0 16px 38px rgba(15, 31, 58, 0.08);
	}

	.admin-hero h1 {
		font-size: clamp(1.6rem, 2.2vw, 2.1rem);
		font-weight: 800;
		color: #0f1f3a;
		margin-bottom: 8px;
	}

	.admin-hero p {
		color: #5f6f85;
		margin-bottom: 0;
	}

	.panel-head {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 18px;
		flex-wrap: wrap;
		padding-bottom: 8px;
		border-bottom: 1px solid #e9f0fa;
		width: 100%;
	}

	.panel-title-group {
		display: grid;
		gap: 4px;
		flex: 1 1 0;
		min-width: 0;
	}

	.panel-tools {
		display: flex;
		align-items: center;
		gap: 12px;
		flex: 0 1 auto;
		min-width: 0;
		justify-content: flex-end;
	}

	.panel-title-group h3 {
		margin: 0;
		font-size: 1.1rem;
		font-weight: 800;
		color: #0f1f3a;
	}

	.panel-caption {
		margin: 0;
		font-size: 13px;
		color: #6a7f99;
	}

	.create-btn {
		border: 0;
		background: linear-gradient(135deg, #1253c8, #2877ff);
		color: #fff;
		border-radius: 14px;
		min-height: 46px;
		padding: 0 18px;
		font-size: 13px;
		font-weight: 700;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		box-shadow: 0 14px 28px rgba(18, 83, 200, 0.18);
	}

	.table-wrap {
		margin-top: 16px;
		border: 1px solid #e4ecf8;
		border-radius: 16px;
		overflow: auto;
		background: #fff;
	}

	.roles-table {
		width: 100%;
		border-collapse: collapse;
		min-width: 620px;
	}

	.roles-table thead th {
		text-align: left;
		padding: 12px 14px;
		font-size: 12px;
		letter-spacing: 0.04em;
		text-transform: uppercase;
		color: #4f637d;
		background: #f6faff;
		border-bottom: 1px solid #e4ecf8;
	}

	.roles-table tbody td {
		padding: 13px 14px;
		border-bottom: 1px solid #eef4fb;
		font-size: 14px;
		color: #1f3556;
		vertical-align: middle;
	}

	.roles-table tbody tr:last-child td {
		border-bottom: none;
	}

	.role-name {
		font-weight: 700;
		color: #0f1f3a;
	}

	.pill {
		display: inline-block;
		padding: 4px 10px;
		border-radius: 999px;
		font-size: 12px;
		font-weight: 700;
	}

	.pill.active {
		background: #e7f7ef;
		color: #12784a;
	}

	.pill.inactive {
		background: #f2f3f7;
		color: #5b667a;
	}

	.action-cell {
		width: 128px;
		text-align: center;
	}

	.action-group {
		display: inline-flex;
		align-items: center;
		gap: 8px;
	}

	.icon-btn {
		width: 34px;
		height: 34px;
		border-radius: 10px;
		border: 1px solid #f1d7d7;
		background: #fff5f5;
		color: #c62828;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
	}

	.icon-btn.edit-btn {
		border-color: #c8ddff;
		background: #ebf3ff;
		color: #1253c8;
	}

	.table-empty {
		text-align: center;
		color: #607490;
		font-weight: 500;
	}

	.pagination-controls {
		margin-top: 18px;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		gap: 10px;
	}

	.page-btn {
		border: 1px solid #c9d9ef;
		background: #fff;
		color: #0f1f3a;
		border-radius: 10px;
		padding: 8px 14px;
		font-size: 13px;
		font-weight: 600;
		cursor: pointer;
	}

	.page-btn:disabled {
		opacity: 0.45;
		cursor: not-allowed;
	}

	.page-info {
		font-size: 13px;
		color: #5f6f85;
		min-width: 98px;
		text-align: center;
	}

	.modal-overlay {
		position: fixed;
		inset: 0;
		background: rgba(8, 20, 42, 0.54);
		display: none;
		align-items: center;
		justify-content: center;
		padding: 20px;
		z-index: 1200;
	}

	.modal-overlay.active {
		display: flex;
	}

	.edit-modal {
		width: min(520px, 100%);
		border-radius: 20px;
		border: 1px solid #d7e5fa;
		background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
		box-shadow: 0 24px 56px rgba(15, 31, 58, 0.22);
		overflow: hidden;
	}

	.edit-modal-header {
		padding: 18px 22px;
		background: linear-gradient(135deg, #1253c8, #2877ff);
		color: #fff;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 12px;
	}

	.edit-modal-title {
		margin: 0;
		font-size: 18px;
		font-weight: 800;
	}

	.edit-modal-subtitle {
		margin: 2px 0 0;
		font-size: 12px;
		color: #dbe9ff;
	}

	.modal-close-btn {
		width: 34px;
		height: 34px;
		border: 1px solid rgba(255, 255, 255, 0.35);
		border-radius: 10px;
		background: rgba(255, 255, 255, 0.1);
		color: #fff;
		font-size: 20px;
		line-height: 1;
		cursor: pointer;
	}

	.edit-form {
		padding: 20px 22px 22px;
	}

	.edit-grid {
		display: grid;
		gap: 14px;
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.edit-field {
		display: grid;
		gap: 6px;
	}

	.permissions-field {
		grid-column: 1 / -1;
	}

	.permissions-list {
		border: 1px solid #ccdbf2;
		border-radius: 12px;
		background: #fff;
		padding: 10px;
		display: grid;
		gap: 8px;
		max-height: 210px;
		overflow: auto;
	}

	.permission-group-row {
		border: 1px solid #e0ebfa;
		border-radius: 10px;
		padding: 10px;
		background: #f8fbff;
		display: grid;
		gap: 8px;
	}

	.permission-group-title {
		font-size: 12px;
		font-weight: 800;
		letter-spacing: 0.03em;
		text-transform: uppercase;
		color: #2f4d73;
	}

	.permission-group-items {
		display: grid;
		gap: 8px;
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}

	.permission-row {
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 13px;
		color: #264368;
	}

	.permission-row input[type="checkbox"] {
		accent-color: #1253c8;
	}

	@media (max-width: 720px) {
		.permission-group-items {
			grid-template-columns: 1fr;
		}
	}

	.permission-empty {
		font-size: 13px;
		color: #5f6f85;
	}

	.edit-label {
		font-size: 12px;
		font-weight: 700;
		letter-spacing: 0.03em;
		text-transform: uppercase;
		color: #3f5778;
	}

	.edit-input,
	.edit-select {
		width: 100%;
		border: 1px solid #ccdbf2;
		border-radius: 10px;
		background: #fff;
		color: #16355d;
		padding: 10px 12px;
		font-size: 14px;
		min-height: 42px;
	}

	.edit-form-error {
		margin-top: 14px;
		font-size: 13px;
		color: #b3261e;
		min-height: 18px;
	}

	.edit-form-actions {
		margin-top: 14px;
		display: flex;
		justify-content: flex-end;
		gap: 10px;
	}

	.btn-secondary,
	.btn-primary,
	.btn-danger {
		border-radius: 10px;
		padding: 10px 14px;
		font-size: 13px;
		font-weight: 700;
		cursor: pointer;
	}

	.btn-secondary {
		border: 1px solid #c9d9ef;
		background: #fff;
		color: #0f1f3a;
	}

	.btn-primary {
		border: 0;
		background: linear-gradient(135deg, #1253c8, #2877ff);
		color: #fff;
	}

	.btn-danger {
		border: 0;
		background: linear-gradient(135deg, #c62828, #ef5350);
		color: #fff;
	}

	.btn-secondary:disabled,
	.btn-primary:disabled,
	.btn-danger:disabled {
		opacity: 0.5;
		cursor: not-allowed;
	}

	.confirm-modal {
		width: min(430px, 100%);
	}

	.confirm-modal-body {
		padding: 22px;
	}

	.confirm-title {
		margin: 0;
		font-size: 18px;
		color: #0f1f3a;
		font-weight: 800;
	}

	.confirm-text {
		margin: 10px 0 0;
		font-size: 14px;
		color: #526884;
	}

	.confirm-error {
		margin-top: 14px;
		font-size: 13px;
		color: #b3261e;
		min-height: 18px;
	}

	.confirm-actions {
		margin-top: 16px;
		display: flex;
		justify-content: flex-end;
		gap: 10px;
	}

	@media (max-width: 920px) {
		.admin-shell {
			grid-template-columns: 1fr;
		}

		.edit-grid {
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
			<section class="admin-hero">
				<h1>Roles</h1>
				<p>Manage role names, status, and permissions assignment structure.</p>
			</section>

			<section class="panel-card">
				<div class="panel-head">
					<div class="panel-title-group">
						<h3>Role list</h3>
						<p class="panel-caption">Use role status to control availability in your system.</p>
					</div>
					<button id="create-role-btn" type="button" class="create-btn">
						<span aria-hidden="true">+</span>
						<span>Create Role</span>
					</button>
				</div>

				<div id="role-list" class="table-wrap">Loading roles...</div>

				<div class="pagination-controls">
					<button id="prev-page" type="button" class="page-btn">Previous</button>
					<span id="page-info" class="page-info">Page 1 of 1</span>
					<button id="next-page" type="button" class="page-btn">Next</button>
				</div>
			</section>
		</div>
	</div>

	<div id="create-role-modal" class="modal-overlay" aria-hidden="true">
		<div class="edit-modal" role="dialog" aria-modal="true" aria-labelledby="create-role-title">
			<div class="edit-modal-header">
				<div>
					<h2 id="create-role-title" class="edit-modal-title">Create Role</h2>
					<p class="edit-modal-subtitle">Add a new role with status.</p>
				</div>
				<button id="close-create-role-modal" type="button" class="modal-close-btn" aria-label="Close create role modal">&times;</button>
			</div>

			<form id="create-role-form" class="edit-form">
				<div class="edit-grid">
					<div class="edit-field">
						<label class="edit-label" for="create-role-name">Role Name</label>
						<input id="create-role-name" class="edit-input" type="text" maxlength="255" required>
					</div>
					<div class="edit-field">
						<label class="edit-label" for="create-role-status">Status</label>
						<select id="create-role-status" class="edit-select" required>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
				</div>

				<div id="create-role-error" class="edit-form-error" aria-live="polite"></div>

				<div class="edit-form-actions">
					<button id="cancel-create-role-btn" type="button" class="btn-secondary">Cancel</button>
					<button id="save-create-role-btn" type="submit" class="btn-primary">Create Role</button>
				</div>
			</form>
		</div>
	</div>

	<div id="edit-role-modal" class="modal-overlay" aria-hidden="true">
		<div class="edit-modal" role="dialog" aria-modal="true" aria-labelledby="edit-role-title">
			<div class="edit-modal-header">
				<div>
					<h2 id="edit-role-title" class="edit-modal-title">Edit Role</h2>
					<p class="edit-modal-subtitle">Update role details.</p>
				</div>
				<button id="close-edit-role-modal" type="button" class="modal-close-btn" aria-label="Close edit role modal">&times;</button>
			</div>

			<form id="edit-role-form" class="edit-form">
				<input id="edit-role-id" type="hidden">

				<div class="edit-grid">
					<div class="edit-field">
						<label class="edit-label" for="edit-role-name">Role Name</label>
						<input id="edit-role-name" class="edit-input" type="text" maxlength="255" required>
					</div>
					<div class="edit-field">
						<label class="edit-label" for="edit-role-status">Status</label>
						<select id="edit-role-status" class="edit-select" required>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
					<div class="edit-field permissions-field">
						<label class="edit-label">Permissions</label>
						<div id="edit-role-permissions" class="permissions-list">
							<div class="permission-empty">Loading permissions...</div>
						</div>
					</div>
				</div>

				<div id="edit-role-error" class="edit-form-error" aria-live="polite"></div>

				<div class="edit-form-actions">
					<button id="cancel-edit-role-btn" type="button" class="btn-secondary">Cancel</button>
					<button id="save-edit-role-btn" type="submit" class="btn-primary">Save Changes</button>
				</div>
			</form>
		</div>
	</div>

	<div id="delete-role-modal" class="modal-overlay" aria-hidden="true">
		<div class="edit-modal confirm-modal" role="dialog" aria-modal="true" aria-labelledby="delete-role-title">
			<div class="edit-modal-header">
				<div>
					<h2 id="delete-role-title" class="edit-modal-title">Delete Role</h2>
					<p class="edit-modal-subtitle">This action cannot be undone.</p>
				</div>
				<button id="close-delete-role-modal" type="button" class="modal-close-btn" aria-label="Close delete role modal">&times;</button>
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
