<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;

class DashboardController extends Controller
{
    public function editProfile()
    {
        $doctor = auth()->user()->doctor;

        if (! $doctor) {
            abort(404, 'Doctor profile not found.');
        }

        return view('doctor.profile', compact('doctor'));
    }

    public function updateProfile(Request $request)
    {
        $doctor = auth()->user()->doctor;

        if (! $doctor) {
            abort(404, 'Doctor profile not found.');
        }

        $validated = $request->validate([
            'specialization' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:255|unique:doctors,license_number,' . $doctor->id,
            'clinic_address' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctor.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function viewProfile($id)
    {
        $doctor = Doctor::findOrFail($id);  // 
        return response()->json($doctor);
    }

    public function getBookings()
    {
        return redirect()->route('doctor.dashboard');
    }

    public function dashboard()
    {
        $doctor = auth()->user()->doctor;

        if (! $doctor) {
            abort(404, 'Doctor profile not found.');
        }

        $bookings = $doctor->bookings()->with('user')->latest()->paginate(config('site.pagination.default', 10));
        $totalBookings = $doctor->bookings()->count();
        $upcomingBookings = $doctor->bookings()
            ->where('appointment_time', '>=', now())
            ->count();

        return view('doctor.dashboard', compact('doctor', 'bookings', 'totalBookings', 'upcomingBookings'));
    }

    
}
