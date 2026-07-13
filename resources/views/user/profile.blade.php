@extends('layouts.app')

@section('title', 'My Profile — OrthoCore Clinic')

@push('styles')
<style>
    .user-profile-hero {
        padding: 50px 0 35px;
        background: linear-gradient(135deg, rgba(18, 83, 200, 0.95), rgba(31, 141, 116, 0.78));
        color: #fff;
    }

    .user-profile-hero h1 {
        font-size: clamp(2.2rem, 2.8vw, 3rem);
        margin: 0 0 8px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .user-profile-hero p {
        margin: 0;
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    .profile-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 32px;
        margin-top: -24px;
        padding-bottom: 64px;
    }

    .profile-nav-card {
        background: #fff;
        border: 1px solid rgba(15, 31, 58, 0.08);
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(15, 31, 58, 0.05);
        padding: 24px 16px;
        height: fit-content;
        position: sticky;
        top: 24px;
    }

    .profile-nav-card .user-info {
        text-align: center;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(15, 31, 58, 0.08);
    }

    .profile-nav-card .avatar-large {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1253c8, #1f8d74);
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        box-shadow: 0 8px 20px rgba(18, 83, 200, 0.15);
    }

    .profile-nav-card h3 {
        margin: 0;
        font-size: 1.15rem;
        color: #0f1f3a;
        font-weight: 700;
    }

    .profile-nav-card p {
        margin: 4px 0 0;
        font-size: 0.9rem;
        color: #64748b;
    }

    .profile-nav-links {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .profile-nav-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 12px 18px;
        background: transparent;
        border: none;
        border-radius: 14px;
        color: #64748b;
        font-size: 0.95rem;
        font-weight: 700;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .profile-nav-btn:hover {
        background: rgba(18, 83, 200, 0.04);
        color: #1253c8;
    }

    .profile-nav-btn.active {
        background: rgba(18, 83, 200, 0.08);
        color: #1253c8;
    }

    .profile-content-card {
        background: #fff;
        border: 1px solid rgba(15, 31, 58, 0.08);
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(15, 31, 58, 0.05);
        padding: 36px;
        min-height: 400px;
    }

    .profile-section {
        display: none;
    }

    .profile-section.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 700;
        color: #0f1f3a;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid rgba(15, 31, 58, 0.15);
        border-radius: 14px;
        font-size: 0.95rem;
        color: #0f1f3a;
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #1253c8;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(18, 83, 200, 0.1);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .status-badge.pending { background: #eef2ff; color: #4338ca; }
    .status-badge.confirmed { background: #dcfce7; color: #166534; }
    .status-badge.cancelled { background: #fee2e2; color: #991b1b; }

    .empty-state {
        padding: 48px 24px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border-radius: 18px;
        border: 1px dashed rgba(15, 31, 58, 0.15);
    }

    .empty-state-icon {
        font-size: 32px;
        margin-bottom: 12px;
    }

    .empty-state h4 {
        margin: 0 0 6px;
        color: #0f1f3a;
        font-size: 1.1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.95rem;
    }

    .table-container {
        overflow-x: auto;
        border: 1px solid rgba(15, 31, 58, 0.08);
        border-radius: 16px;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .modern-table th,
    .modern-table td {
        padding: 16px 20px;
        border-bottom: 1px solid rgba(15, 31, 58, 0.08);
        font-size: 0.95rem;
    }

    .modern-table th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 700;
    }

    .modern-table tr:last-child td {
        border-bottom: none;
    }

    .prescription-card {
        background: #fcfdfd;
        border: 1px solid rgba(18, 83, 200, 0.08);
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 16px;
        transition: all 0.25s ease;
    }

    .prescription-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(18, 83, 200, 0.05);
        border-color: rgba(18, 83, 200, 0.15);
    }

    .prescription-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(15, 31, 58, 0.06);
        padding-bottom: 12px;
        margin-bottom: 14px;
    }

    .prescription-header h4 {
        margin: 0;
        font-size: 1.05rem;
        color: #0f1f3a;
    }

    .prescription-date {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 900px) {
        .profile-layout {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .profile-nav-card {
            position: relative;
            top: 0;
        }

        .profile-nav-links {
            flex-direction: row;
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .profile-nav-btn {
            white-space: nowrap;
            width: auto;
        }
    }
</style>
@endpush

@section('content')
<section class="user-profile-hero" aria-label="User Profile Hero">
    <div class="wrap">
        <h1>Patient Profile</h1>
        <p>Manage your account, view appointments, and track your prescriptions.</p>
    </div>
</section>

<section class="sec" style="background: #fafbfe; padding-top: 48px;">
    <div class="wrap">
        <div class="profile-layout">
            
            <!-- Sidebar Navigation -->
            <div class="profile-nav-card">
                <div class="user-info">
                    <div class="avatar-large">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="profile-nav-links" role="tablist">
                    <button type="button" class="profile-nav-btn active" data-profile-tab="account" role="tab" aria-selected="true">
                        👤 Account Settings
                    </button>
                    <button type="button" class="profile-nav-btn" data-profile-tab="appointments" role="tab" aria-selected="false">
                        📅 My Appointments
                    </button>
                    <button type="button" class="profile-nav-btn" data-profile-tab="prescriptions" role="tab" aria-selected="false">
                        💊 My Prescriptions
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="profile-content-card">
                
                @if(session('success'))
                    <div style="padding:16px 20px; background:#ecfdf5; border:1px solid #d1fae5; border-radius:14px; color:#166534; margin-bottom: 24px; font-weight: 600;">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                <!-- Account Settings Section -->
                <section class="profile-section active" id="profile-sec-account" role="tabpanel">
                    <h2 style="margin: 0 0 24px; color: #0f1f3a; font-size: 1.4rem;">Edit Information</h2>
                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px;">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <span style="color:#b91c1c; font-size:0.85rem; margin-top:4px;">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <span style="color:#b91c1c; font-size:0.85rem; margin-top:4px;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Contact_Number">Contact Number</label>
                            <input type="text" id="Contact_Number" name="Contact_Number" value="{{ old('Contact_Number', $user->Contact_Number) }}" placeholder="e.g. +1 234 567 8900" required>
                            @error('Contact_Number') <span style="color:#b91c1c; font-size:0.85rem; margin-top:4px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Residential Address</label>
                            <textarea id="address" name="address" rows="3" placeholder="Enter your full home address" required>{{ old('address', $user->address) }}</textarea>
                            @error('address') <span style="color:#b91c1c; font-size:0.85rem; margin-top:4px;">{{ $message }}</span> @enderror
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 12px;">
                            <button type="submit" class="btn btn-solid" style="padding: 14px 28px; border-radius: 14px; font-weight: 700;">Save Changes</button>
                        </div>
                    </form>
                </section>

                <!-- Appointments Section -->
                <section class="profile-section" id="profile-sec-appointments" role="tabpanel">
                    <h2 style="margin: 0 0 24px; color: #0f1f3a; font-size: 1.4rem;">Appointment History</h2>
                    
                    @if($bookings->count() > 0)
                        <div class="table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Doctor</th>
                                        <th>Appointment Slot</th>
                                        <th>Status</th>
                                        <th>Reported Symptoms</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td style="font-weight: 700; color: #0f1f3a;">
                                                Dr. {{ optional($booking->doctor->user)->name ?? 'Specialist' }}
                                            </td>
                                            <td>
                                                {{ $booking->appointment_time->format('D, M j, Y \a\t g:i A') }}
                                            </td>
                                            <td>
                                                <span class="status-badge {{ strtolower($booking->status) }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td style="color: #64748b; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $booking->symptoms ?: 'None recorded' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📅</div>
                            <h4>No appointments found</h4>
                            <p>You haven't scheduled any orthopedic or physiotherapy visits yet.</p>
                            <a href="{{ route('book-appointment') }}" class="btn btn-solid btn-sm" style="margin-top: 16px; display: inline-flex;">Book Appointment Now</a>
                        </div>
                    @endif
                </section>

                <!-- Prescriptions Section -->
                <section class="profile-section" id="profile-sec-prescriptions" role="tabpanel">
                    <h2 style="margin: 0 0 24px; color: #0f1f3a; font-size: 1.4rem;">My Prescriptions</h2>

                    @if($prescriptions->count() > 0)
                        @foreach($prescriptions as $prescription)
                            <div class="prescription-card">
                                <div class="prescription-header">
                                    <div>
                                        <h4>Diagnosis: <strong style="color: #1253c8;">{{ $prescription->diagnosis }}</strong></h4>
                                        <p style="margin: 4px 0 0; font-size: 0.9rem; color: #64748b;">
                                            Prescribed by: <strong>Dr. {{ optional($prescription->doctor->user)->name ?? 'Specialist' }}</strong>
                                        </p>
                                    </div>
                                    <span class="prescription-date">
                                        {{ $prescription->created_at->format('M j, Y') }}
                                    </span>
                                </div>
                                <div style="margin-bottom: 12px;">
                                    <strong style="display: block; font-size: 0.9rem; color: #0f1f3a; margin-bottom: 4px;">Medication details (Rx)</strong>
                                    <p style="margin: 0; background: rgba(18, 83, 200, 0.03); padding: 12px 16px; border-radius: 10px; border-left: 3px solid #1253c8; font-family: monospace; font-size: 0.95rem; color: #1e293b; white-space: pre-line;">{{ $prescription->prescription }}</p>
                                </div>
                                @if($prescription->notes)
                                    <div>
                                        <strong style="display: block; font-size: 0.85rem; color: #64748b; margin-bottom: 2px;">Additional Instructions / Notes:</strong>
                                        <p style="margin: 0; font-size: 0.9rem; color: #475569; font-style: italic;">{{ $prescription->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">💊</div>
                            <h4>No active prescriptions</h4>
                            <p>Once your consulting specialist writes a prescription, it will appear here instantly.</p>
                        </div>
                    @endif
                </section>

            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('[data-profile-tab]');
        const sections = document.querySelectorAll('.profile-section');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const targetId = this.dataset.profileTab;

                // Deactivate all
                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                sections.forEach(s => s.classList.remove('active'));

                // Activate selected
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');
                const targetSection = document.getElementById(`profile-sec-${targetId}`);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            });
        });
    });
</script>
@endpush
