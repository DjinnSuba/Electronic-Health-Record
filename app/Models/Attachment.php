<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = [       
        'patientId',
        'patientCode',
        'filename',
    ];
    public function attachments(){
        return $this->hasMany('App\Attachment', 'id');
    }
}
