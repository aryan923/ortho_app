/**
 * OrthoCore Clinic — Shared JavaScript
 */

/* ─── QUICK APPOINTMENT FORM (home + about inline form) ─── */
function handleBooking(e) {
    e.preventDefault();
    const btn  = e.target.querySelector('button');
    const orig = btn.textContent;
    btn.disabled = true;
    btn.textContent = "We'll call you soon \u2713";
    btn.style.background = 'linear-gradient(135deg,#16a34a,#22c55e)';
    e.target.reset();
    setTimeout(() => {
        btn.disabled      = false;
        btn.textContent   = orig;
        btn.style.background = '';
    }, 3500);
}
