<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient_codes';
    protected $fillable = [
        'patientCode',
    ];
    // You might also want to define relationships or additional methods here if needed
}
