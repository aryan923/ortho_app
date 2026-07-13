<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Prescription as PrescriptionModel;
use App\Models\User;
use Illuminate\Http\Request;

class Prescription extends Controller
{
    public function getPrescriptions(Request $request, $patientId)
    {
        $patient = User::findOrFail($patientId);
        $prescriptions = PrescriptionModel::where('patient_id', $patient->id)->get();

        return response()->json([
            'prescriptions' => $prescriptions,
        ]);
    }

    public function patientHistory(Request $request, $patientId)
    {
        $bookings = Booking::where('patient_id', $patientId)
            ->with(['doctor.user'])
            ->orderBy('appointment_time', 'desc')
            ->get();

        $prescriptions = PrescriptionModel::where('patient_id', $patientId)
            ->with(['doctor.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'bookings' => $bookings,
            'prescriptions' => $prescriptions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'appointment_id' => 'required|exists:bookings,id',
            'diagnosis' => 'required|string',
            'prescription' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $prescription = PrescriptionModel::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => auth()->id(),
            'appointment_id' => $validated['appointment_id'],
            'diagnosis' => $validated['diagnosis'],
            'prescription' => $validated['prescription'],
            'notes' => $validated['notes'],
        ]);

        $booking = Booking::findOrFail($validated['appointment_id']);
        $booking->status = 'completed';
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Prescription saved successfully.',
            'prescription' => $prescription,
        ]);
    }
}
