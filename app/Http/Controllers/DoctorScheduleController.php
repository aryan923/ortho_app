<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->get();

        return view('doctor.schedule', compact('doctors'));
    }

    public function show(Doctor $doctor)
    {
        $doctors = Doctor::with('user')->get();

        return view('doctor.schedule', compact('doctors', 'doctor'));
    }
}
