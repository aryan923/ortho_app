<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    use HasFactory;
    
protected $fillable = [      
        'specialization',
        'license_number',
        'clinic_address',
        'biography',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
