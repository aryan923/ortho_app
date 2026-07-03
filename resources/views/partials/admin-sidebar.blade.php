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

        <div class="nav-dropdown {{ request()->routeIs('view-users') ? 'open' : '' }}">
            <button class="nav-item nav-toggle" type="button" aria-expanded="{{ request()->routeIs('view-users') ? 'true' : 'false' }}" aria-controls="admin-manage-menu">
                <span>◉</span>
                Manage
                <span class="nav-caret">▾</span>
            </button>
            <div class="nav-dropdown-menu" id="admin-manage-menu">
                <a href="{{ route('view-users') }}" class="nav-subitem">Users</a>
                <a href="{{ route('dashboard') }}#roles" class="nav-subitem">Roles</a>
                <a href="{{ route('dashboard') }}#permissions" class="nav-subitem">Permissions</a>
            </div>
        </div>
    </nav>
</aside>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.nav-toggle');
        const dropdown = document.querySelector('.nav-dropdown');

        if (!toggle || !dropdown || toggle.dataset.bound === '1') {
            return;
        }

        toggle.dataset.bound = '1';

        toggle.addEventListener('click', function () {
            const isOpen = dropdown.classList.contains('open');
            dropdown.classList.toggle('open', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });
    });
</script>
@endpush
