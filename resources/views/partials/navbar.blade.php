{{-- ─── PRIMARY NAVBAR ─── --}}
<header class="navbar">
    <div class="wrap">
        <a href="/" class="brand">
            @if(config('site.logo'))
                <img src="{{ asset(config('site.logo')) }}" alt="{{ config('site.full_name') }}" class="brand-logo">
            @else
                <span class="brand-icon">+</span>
            @endif
            <span class="brand-name">{{ config('site.full_name') }}</span>
        </a>

        <nav aria-label="Primary navigation">
            <ul class="nav-links">
                <li>
                    <a href="/services" @class(['active' => request()->is('services')])>Services</a>
                </li>
                <li>
                    <a href="/blog" @class(['active' => request()->is('blog')])>Blog</a>
                </li>
                <li>
                    <a href="/about" @class(['active' => request()->is('about')])>Why Us</a>
                </li>
                <li>
                    <a href="/doctors" @class(['active' => request()->is('doctors')])>Doctors</a>
                </li>
                <li><a href="/#testimonials">Reviews</a></li>
                <li><a href="/#contact">Contact</a></li>
            </ul>
        </nav>

        <div class="nav-cta">
            @guest
                <a href="{{ route('login') }}" class="auth-pill">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                    </svg>
                    <span>Sign In</span>
                </a>
            @endguest

            @auth
                <div class="profile-menu">
                    <button type="button" class="profile-pill" aria-haspopup="true" aria-expanded="false">
                        <span>{{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 15.5l-5-5h10l-5 5z"/>
                        </svg>
                    </button>
                    <div class="profile-dropdown" aria-label="Profile menu">
                        <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
                        <a href="{{ route('doctor.schedule') }}">Schedule</a>
                        <a href="{{ route('doctor.profile.edit') }}">Profile</a>
                        <form method="POST" action="{{ route('logout.submit') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth

            <a href="tel:+12125550192" class="btn btn-ghost btn-sm">Call Now</a>
            <a href="/book-appointment"
               @class(['btn', 'btn-solid', 'btn-sm', 'active' => request()->is('book-appointment')])>
                Book Appointment
            </a>
        </div>
    </div>
</header>

<style>
    .nav-cta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .profile-menu {
        position: relative;
    }

    .profile-pill,
    .auth-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 14px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: var(--white);
        color: var(--ink-md);
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        box-shadow: var(--sh-sm);
        transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease, color .15s ease;
        cursor: pointer;
    }

    .profile-pill:hover,
    .auth-pill:hover {
        transform: translateY(-1px);
        border-color: var(--blue);
        color: var(--blue);
        box-shadow: var(--sh-md);
    }

    .profile-pill svg {
        width: 12px;
        height: 12px;
        fill: currentColor;
    }

    .profile-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        min-width: 210px;
        background: #fff;
        border: 1px solid rgba(15, 31, 58, 0.12);
        border-radius: 18px;
        box-shadow: 0 20px 40px rgba(15, 31, 58, 0.1);
        z-index: 20;
        padding: 10px 0;
    }

    .profile-menu.open .profile-dropdown {
        display: block;
    }

    .profile-dropdown a,
    .profile-dropdown button {
        width: 100%;
        text-align: left;
        padding: 12px 18px;
        background: transparent;
        border: none;
        color: var(--ink);
        font-size: 0.95rem;
        text-decoration: none;
        display: block;
        cursor: pointer;
    }

    .profile-dropdown a:hover,
    .profile-dropdown button:hover {
        background: rgba(18, 83, 200, 0.08);
        color: var(--blue);
    }

    .auth-pill svg {
        width: 15px;
        height: 15px;
        fill: currentColor;
    }

    .profile-menu[data-open="true"] .profile-dropdown {
        display: block;
    }

    .profile-pill[aria-expanded="true"] {
        border-color: rgba(18,83,200,0.45);
    }

    .brand-logo {
        max-height: 36px;
        width: auto;
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
    }

    .brand-name {
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: 0.02em;
        color: var(--ink-dark);
        vertical-align: middle;
        display: inline-flex;
        align-items: center;
    }

    .brand-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: var(--blue);
        color: #fff;
        font-weight: 700;
        margin-right: 10px;
        vertical-align: middle;
    }

    @media (max-width: 900px) {
        .nav-cta {
            margin-top: 8px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('[data-profile-toggle]');
        if (!toggle) return;

        const menu = toggle.closest('.profile-menu');
        const dropdown = menu.querySelector('[data-profile-dropdown]');

        toggle.addEventListener('click', function () {
            const isOpen = menu.dataset.open === 'true';
            menu.dataset.open = isOpen ? 'false' : 'true';
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });

        document.addEventListener('click', function (event) {
            if (!menu.contains(event.target)) {
                menu.dataset.open = 'false';
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
</style>
