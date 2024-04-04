<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    use HasFactory;
    protected $fillable = [

        'text',
        'bp',
        'hr',
        'osat',
        'rr',

    ];

    protected $casts = [

        'text' => 'json',
        'bp' => 'json',
        'hr' => 'json',
        'osat' => 'json',
        'rr' => 'json',
        
    ];

}
