<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pt_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patientId')->constrained(table: 'patient_codes', indexName: 'patientId')->onDelete('cascade');
            $table->string('patientCode');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->text('medicalDiagnosis');
            $table->string('sex');
            $table->date('birthday');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('presentaddress');
            $table->text('refMD');
            $table->text('refUnit');
            $table->date('dateOfConsult');
            $table->time('timeOfConsult');
            $table->time('timeOfEndConsult');
            $table->string('duration')->nullable();
            $table->text('attendees');

            $table->text('complaints');
            $table->text('goals');
            $table->text('hpi');
            $table->text('pshx');
            $table->text('ehx');
            $table->text('pmhx');
            $table->text('fmhx');
            $table->text('medications');


            //Vital Signs
            $table->foreignId('vsId')->constrained(table: 'vital_signs', indexName: 'vsId')->onDelete('cascade');
            //$table->json('text');
            //$table->json('bp');
            //$table->json('hr');
            //$table->json('osat');
            //$table->json('rr');
            $table->text('significance');

            //Assessments
            $table->foreignId('asId')->constrained(table: 'assessments', indexName: 'asId')->onDelete('cascade'); 
            //$table->json('procedureTitle');
            //$table->json('openText');
            //$table->json('procedureSignificance');
 
            $table->text('diagnosis');
            $table->text('prognosis');
            $table->text('plan');
            $table->text('references');
            $table->string('attachment');
            $table->text('license');
            $table->integer('formType')->default(2); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pt_patients');
    }
};
