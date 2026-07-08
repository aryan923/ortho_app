<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\User;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [        
        'doctor_id',
        'patient_id',
        'appointment_time',
        'status',
        'symptoms',
    ];

    protected $casts = [
        'appointment_time' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
