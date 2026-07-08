<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;

class DashboardController extends Controller
{
    //
    public function updateProfile(Request $request, $id )
    {
        $doctor = Doctor::findOrFail($id);
       $validated = $request->validate([
            'specialization' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:255|unique:doctors,license_number,' . $doctor->id,
            'clinic_address' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
        ]);

        $doctor->update($validated);

        return response()->json([
            'message' => 'Doctor profile updated successfully',
            'doctor' => $doctor,
        ]);
    }

    public function viewProfile($id)
    {
        $doctor = Doctor::findOrFail($id);  // 
        return response()->json($doctor);
    }

    public function dashboard()
    {
        $doctor = auth()->user()->doctor;

        if (! $doctor) {
            abort(404, 'Doctor profile not found.');
        }

        $bookings = $doctor->bookings()->with('user')->latest()->paginate(config('site.pagination.default', 10));

        return view('doctor.dashboard', compact('doctor', 'bookings'));
    }

    
}
