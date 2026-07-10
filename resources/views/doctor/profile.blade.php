@extends('layouts.app')

@section('title', 'Doctor Profile — OrthoCore Clinic')

@section('content')
<section class="sec" style="padding: 64px 0;">
    <div class="wrap" style="max-width: 980px; margin: 0 auto;">
        <div style="background: #fff; border: 1px solid rgba(15,31,58,0.08); border-radius: 30px; box-shadow: 0 22px 50px rgba(15,31,58,0.08); overflow: hidden;">
            <div style="background: linear-gradient(135deg, rgba(18,83,200,0.95), rgba(31,141,116,0.78)); padding: 32px 36px; color: #fff;">
                <p style="margin:0 0 10px; font-size:0.95rem; letter-spacing:0.1em; text-transform:uppercase; opacity:.92;">Doctor Profile</p>
                <h1 style="margin:0; font-size:2.5rem; line-height:1.05;">{{ optional($doctor->user)->name ?? 'Doctor' }}</h1>
                <p style="margin: 12px 0 0; color: rgba(255,255,255,0.92); max-width: 720px;">Manage your public profile, specialization, and clinic details from one place.</p>
            </div>
            <div style="display:grid; grid-template-columns: 1fr; gap: 24px; padding: 32px 36px; background:#f8fafc;">
                @if(session('success'))
                    <div style="padding:18px 22px; background:#ecfdf5; border:1px solid #d1fae5; border-radius:18px; color:#166534;">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('doctor.profile.update') }}" style="display:grid; gap:20px;">
                    @csrf
                    @method('PUT')

                    <div style="display:grid; gap:14px;">
                        <label for="specialization" style="font-weight:700; color:#14243d;">Specialization</label>
                        <input id="specialization" name="specialization" type="text" value="{{ old('specialization', $doctor->specialization) }}" placeholder="e.g. Orthopedic Surgeon" style="width:100%; padding:14px 16px; border:1px solid rgba(15,31,58,0.16); border-radius:16px; background:#fff; color:#0f1f3a;" />
                        @error('specialization') <span style="color:#b91c1c; font-size:0.92rem;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display:grid; gap:14px; grid-template-columns: repeat(2, minmax(0, 1fr));">
                        <div style="display:grid; gap:14px;">
                            <label for="license_number" style="font-weight:700; color:#14243d;">License Number</label>
                            <input id="license_number" name="license_number" type="text" value="{{ old('license_number', $doctor->license_number) }}" placeholder="License number" style="width:100%; padding:14px 16px; border:1px solid rgba(15,31,58,0.16); border-radius:16px; background:#fff; color:#0f1f3a;" />
                            @error('license_number') <span style="color:#b91c1c; font-size:0.92rem;">{{ $message }}</span> @enderror
                        </div>

                        <div style="display:grid; gap:14px;">
                            <label for="clinic_address" style="font-weight:700; color:#14243d;">Clinic Address</label>
                            <input id="clinic_address" name="clinic_address" type="text" value="{{ old('clinic_address', $doctor->clinic_address) }}" placeholder="Clinic address" style="width:100%; padding:14px 16px; border:1px solid rgba(15,31,58,0.16); border-radius:16px; background:#fff; color:#0f1f3a;" />
                            @error('clinic_address') <span style="color:#b91c1c; font-size:0.92rem;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display:grid; gap:14px;">
                        <label for="biography" style="font-weight:700; color:#14243d;">Biography</label>
                        <textarea id="biography" name="biography" placeholder="Tell patients about your experience and approach." style="width:100%; min-height: 150px; padding:14px 16px; border:1px solid rgba(15,31,58,0.16); border-radius:16px; background:#fff; color:#0f1f3a;">{{ old('biography', $doctor->biography) }}</textarea>
                        @error('biography') <span style="color:#b91c1c; font-size:0.92rem;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display:flex; justify-content:flex-end; gap:14px; flex-wrap:wrap; margin-top:8px;">
                        <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary" style="padding: 12px 20px; border-radius: 14px;">Back to dashboard</a>
                        <button type="submit" class="btn btn-solid" style="padding: 12px 20px; border-radius: 14px;">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
