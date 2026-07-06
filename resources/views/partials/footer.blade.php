{{-- ─── FOOTER ─── --}}
<footer class="footer" id="contact">

    {{-- Emergency callout strip --}}
    <div class="footer-callout">
        <div class="wrap">
            <div>
                <strong>Orthopedic Emergency? Call us now</strong><br>
                <span>Available 24 / 7 for urgent consultations &amp; post-surgical support</span>
            </div>
            <a href="tel:+12125550192" class="btn btn-fire btn-sm">+1 (212) 555-0192</a>
        </div>
    </div>

    {{-- Main footer grid --}}
    <div class="footer-main">
        <div class="wrap">
            <div class="footer-grid">

                {{-- Column 1: Brand --}}
                <div>
                    <div class="footer-brand-name">+ {{ config('site.full_name') }}</div>
                    <p>{{ config('site.description') }}</p>
                    <address class="footer-addr" style="margin-top:10px;">
                        {{ config('site.address_line_1') }}<br>
                        {{ config('site.address_line_2') }}<br>
                        <a href="{{ config('site.phone_link') }}">{{ config('site.phone') }}</a><br>
                        <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                    </address>
                    <div class="footer-socials">
                        <a href="#" class="soc-btn">Facebook</a>
                        <a href="#" class="soc-btn">Instagram</a>
                        <a href="#" class="soc-btn">LinkedIn</a>
                    </div>
                </div>

                {{-- Column 2: Services --}}
                <div>
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="/services#joint">Joint Replacement</a></li>
                        <li><a href="/services#sports">Sports Medicine</a></li>
                        <li><a href="/services#spine">Spine Care</a></li>
                        <li><a href="/services#physio">Physiotherapy</a></li>
                        <li><a href="/services#fracture">Fracture Care</a></li>
                        <li><a href="/services#arthritis">Arthritis Treatment</a></li>
                        <li><a href="/services#pediatric">Pediatric Ortho</a></li>
                    </ul>
                </div>

                {{-- Column 3: Quick links --}}
                <div>
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/doctors">Our Doctors</a></li>
                        <li><a href="/book-appointment">Book Appointment</a></li>
                        <li><a href="/#testimonials">Patient Reviews</a></li>
                        <li><a href="#">Patient Portal</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>

                {{-- Column 4: Hours --}}
                <div>
                    <h4>Clinic Hours</h4>
                    <ul>
                        <li>Mon – Fri: 8 am – 7 pm</li>
                        <li>Saturday: 9 am – 5 pm</li>
                        <li>Sunday: Closed</li>
                        <li>Emergency: 24 / 7</li>
                    </ul>
                    <h4 style="margin-top:14px;">Accepted Plans</h4>
                    <ul>
                        <li>Medicare &amp; Medicaid</li>
                        <li>Blue Cross / Blue Shield</li>
                        <li>Aetna &amp; Cigna</li>
                        <li>United Healthcare</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    {{-- Footer bottom bar --}}
    <div class="footer-bottom">
        <div class="wrap">
            <span>&copy; {{ date('Y') }} OrthoCore Clinic. All rights reserved.</span>
            <div class="foot-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Accessibility</a>
                <a href="#">Sitemap</a>
            </div>
        </div>
    </div>

</footer>
