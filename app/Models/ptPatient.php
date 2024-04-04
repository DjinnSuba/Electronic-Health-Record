<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ptPatient extends Model
{
    protected $fillable = [
        'patientId',
        'patientCode',
        'lastName',
        'firstName',
        'middleName',
        'medicalDiagnosis',
        'sex',

        'birthday',
        'phone',

        'email',
        'presentaddress',
        'refMD',
        'refUnit',
        
        'dateOfConsult',
        'timeOfConsult',
        'timeOfEndConsult',
        'duration',
        'attendees',

        'complaints',
        'goals',
        'hpi',
        'pshx',
        'ehx',
        'pmhx',
        'fmhx',
        'medications',
        'vsId',

        'significance',
        'asId',

        'diagnosis',
        'prognosis',
        'plan',
        'references',
        'attachment',
        'license',
        'formType',
    ];
    public function attachments(){
        return $this->hasMany('App\Attachment', 'id');
    }

    protected $casts = [
        
    ];

    // You might also want to define relationships or additional methods here if needed
}
