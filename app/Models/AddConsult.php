<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddConsult extends Model
{
    protected $table = 'add_consult';
    protected $fillable = [
        'patientId',
        'patientCode',
        'formType',
        'lastName',
        'firstName',
        'middleName',
        'dateOfConsult',
        'timeOfConsult',
        'age',
        'sex',
        'nationality',
        'civilstatus',
        'birthday',
        'presentaddress',
        'occupation',
        'religion',
        'subFindings',
        'objFindings',
        'assessment',
        'hypertension',
        'diabetes',
        'icdUmbrella',
        'diagnostics',
        'drugs',
        'diet',
        'disposition',

    ];
    public function attachments(){
        return $this->hasMany('App\Attachment', 'id');
    }

    protected $casts = [
        'icdUmbrella' => 'json',
 
    ];

    // You might also want to define relationships or additional methods here if needed
}