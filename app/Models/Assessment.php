<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'procedureTitle',
        'openText',
        'procedureSignificance',
    ];

    protected $casts = [
        'procedureTitle' => 'json',
        'openText' => 'json',
        'procedureSignificance' => 'json',
    ];
}
