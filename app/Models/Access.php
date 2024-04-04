<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'accesses';

    protected $fillable = [
        'patientId',
        'patientCodez',
        'attendingId',
        'physicianCodez',
        'accessId',
        'status',
        'formType',
    ];

    public $timestamps = true;

}
