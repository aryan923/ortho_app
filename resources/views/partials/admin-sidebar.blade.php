<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <div class="brand-mark">OC</div>
        <div>
            <p class="brand-name">OrthoCore</p>
            <span class="brand-subtitle">Admin Console</span>
        </div>
    </div>

    <nav class="sidebar-nav" aria-label="Admin sections">
        <a href="{{ route('dashboard') }}#overview" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span>◉</span>
            Overview
        </a>

        <div class="nav-dropdown {{ request()->routeIs('view-users') || request()->routeIs('roles') ? 'open' : '' }}">
            <button class="nav-item nav-toggle" type="button" aria-expanded="{{ request()->routeIs('view-users') || request()->routeIs('roles') ? 'true' : 'false' }}" aria-controls="admin-manage-menu">
                <span>◉</span>
                Manage Users
                <span class="nav-caret">▾</span>
            </button>
            <div class="nav-dropdown-menu" id="admin-manage-menu">
                <a href="{{ route('view-users') }}" class="nav-subitem {{ request()->routeIs('view-users') ? 'active' : '' }}">Users</a>
                <a href="{{ route('roles') }}" class="nav-subitem {{ request()->routeIs('roles') ? 'active' : '' }}">Roles</a>
                <a href="{{ route('dashboard') }}#permissions" class="nav-subitem">Permissions</a>
            </div>
        </div>

        <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <span>◉</span>
            Settings
        </a>
        <div class="nav-dropdown {{ request()->routeIs('admin.cms.*') ? 'open' : '' }}">
            <button class="nav-item nav-toggle" type="button" aria-expanded="{{ request()->routeIs('admin.cms.*') ? 'true' : 'false' }}" aria-controls="admin-cms-menu">
                <span>◉</span>
                Page CMS
                <span class="nav-caret">▾</span>
            </button>
            <div class="nav-dropdown-menu" id="admin-cms-menu">
                <a href="{{ route('admin.cms.edit', ['page' => 'home']) }}" class="nav-subitem {{ request()->routeIs('admin.cms.edit') && request()->route('page') === 'home' ? 'active' : '' }}">Home</a>
                <a href="{{ route('admin.cms.edit', ['page' => 'about']) }}" class="nav-subitem {{ request()->routeIs('admin.cms.edit') && request()->route('page') === 'about' ? 'active' : '' }}">About</a>
                <a href="{{ route('admin.cms.edit', ['page' => 'services']) }}" class="nav-subitem {{ request()->routeIs('admin.cms.edit') && request()->route('page') === 'services' ? 'active' : '' }}">Services</a>
                <a href="{{ route('admin.cms.edit', ['page' => 'doctors']) }}" class="nav-subitem {{ request()->routeIs('admin.cms.edit') && request()->route('page') === 'doctors' ? 'active' : '' }}">Doctors</a>
                <a href="{{ route('admin.cms.edit', ['page' => 'blog']) }}" class="nav-subitem {{ request()->routeIs('admin.cms.edit') && request()->route('page') === 'blog' ? 'active' : '' }}">Blog</a>
                <a href="{{ route('admin.cms.edit', ['page' => 'book_appointment']) }}" class="nav-subitem {{ request()->routeIs('admin.cms.edit') && request()->route('page') === 'book_appointment' ? 'active' : '' }}">Book Appointment</a>
            </div>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="nav-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
            <span>◉</span>
            Blog Posts
        </a>
    </nav>
</aside>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggles = document.querySelectorAll('.nav-dropdown > .nav-toggle');

        dropdownToggles.forEach(function (toggle) {
            const dropdown = toggle.closest('.nav-dropdown');
            if (!dropdown || toggle.dataset.bound === '1') {
                return;
            }

            toggle.dataset.bound = '1';

            toggle.addEventListener('click', function () {
                const isOpen = dropdown.classList.contains('open');
                dropdown.classList.toggle('open', !isOpen);
                toggle.setAttribute('aria-expanded', String(!isOpen));
            });
        });
    });
</script>
@endpush
