<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function create(Request $request, $doctorId )
    {
        $validatedData = $request->validate([           
            'appointment_time' => 'required|string',
            'status' => 'nullable|string|max:255',
            'symptoms' => 'nullable|string',
        ]);
        
        $doctor = Doctor::findOrFail($doctorId);

        $appointmentTime = Carbon::createFromFormat('Y-m-d h:i A', $validatedData['appointment_time']);

        if (! $appointmentTime) {
            return response()->json(['message' => 'Invalid appointment date and time.'], 422);
        }

        $existing = Booking::where('doctor_id', $doctor->id)
            ->where('appointment_time', $appointmentTime)
            ->exists();

        if ($existing) {
            return response()->json(['message' => 'This slot has already been booked. Please choose another time.'], 422);
        }

        $validatedData['appointment_time'] = $appointmentTime;
        $validatedData['doctor_id'] = $doctor->id;
        $validatedData['patient_id'] = auth()->id();

        $booking = Booking::create($validatedData);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ]);
    }

    public function index()
    {
        $bookings = Booking::with(['doctor', 'user'])->latest()->paginate(config('site.pagination.default', 10));

        return response()->json($bookings);
    }

    public function show($id)
    {
        $booking = Booking::with(['doctor', 'user'])->findOrFail($id);

        return response()->json($booking);
    }



    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validatedData = $request->validate([
            'appointment_time' => 'nullable|date',  
            'status' => 'nullable|string|max:255',
            'symptoms' => 'nullable|string',
        ]);

        $booking->update($validatedData);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking,
        ]);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully',
        ]);
    }

    public function getBookedSlots(Request $request, $doctorId)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
        ]);

        $doctor = Doctor::findOrFail($doctorId);

        $bookedSlots = Booking::where('doctor_id', $doctor->id)
            ->whereDate('appointment_time', $validated['date'])
            ->pluck('appointment_time')
            ->map(function ($appointmentTime) {
                return Carbon::parse($appointmentTime)->format('g:i A');
            })
            ->unique()
            ->values();

        return response()->json([
            'doctor' => $doctor,
            'booked_slots' => $bookedSlots,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $booking->update($validatedData);

        return response()->json([
            'message' => 'Booking status updated successfully',
            'booking' => $booking,
        ]);
    }


}
