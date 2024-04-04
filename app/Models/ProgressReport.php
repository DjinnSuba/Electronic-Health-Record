<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;
    protected $table = 'progress_report';
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

        'modeOrVenue',
        'changes',
        'focus',

        'vsId',
        'significance',

        'managementAct',

        'plan',

        'references',
        'attachment',
        'license',
        'formType',
    ];
    public function attachments(){
        return $this->hasMany('App\Attachment', 'id');
    }
}
