{{-- ─── TOPBAR ─── --}}
<div class="topbar">
    <div class="wrap">
        <span>{{ config('site.address_line_1') }}, {{ config('site.address_line_2') }}</span>
        <span>
            <a href="{{ config('site.phone_link') }}">{{ config('site.phone') }}</a>
            &nbsp;|&nbsp;
            <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
        </span>
    </div>
</div>
