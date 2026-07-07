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
                <form method="POST" action="{{ route('logout.submit') }}" class="auth-form">
                    @csrf
                    <button type="submit" class="auth-pill">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M10 17l1.41 1.41L7.83 21H5v-2.83l5-5 2.83 2.83ZM16 3a2 2 0 0 1 2 2v4h-2V5H7v14h11v-4h2v4a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9Z"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
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

    .auth-form {
        display: inline-flex;
    }

    .auth-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 999px;
        background: var(--white);
        color: var(--ink-md);
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        box-shadow: var(--sh-sm);
        transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease, color .15s ease;
    }

    .auth-pill:hover {
        transform: translateY(-1px);
        border-color: var(--blue);
        color: var(--blue);
        box-shadow: var(--sh-md);
    }

    .auth-pill svg {
        width: 15px;
        height: 15px;
        fill: currentColor;
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
