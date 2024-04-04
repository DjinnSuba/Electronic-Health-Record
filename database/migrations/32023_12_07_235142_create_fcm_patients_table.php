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
        Schema::create('fcm_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patientId')->constrained(table: 'patient_codes', indexName: 'patientId')->onDelete('cascade');
            $table->string('patientCode');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->date('dateOfConsult');
            $table->time('timeOfConsult');
            $table->integer('age');
            $table->string('sex');
            $table->string('nationality');
            $table->string('civilstatus');
            $table->date('birthday');
            $table->string('presentaddress');
            $table->string('occupation');
            $table->string('religion');
            $table->string('bp')->nullable();
            $table->string('pulserate')->nullable();
            $table->string('respirationrate')->nullable();
            $table->string('temperature')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->text('chiefComplaint');
            $table->text('historyillness');
            $table->text('allergiesInput')->nullable();
            $table->text('hpn_Input')->nullable();
            $table->text('dm_Input')->nullable();
            $table->text('ptb_Input')->nullable();
            $table->text('asthma_Input')->nullable();
            $table->string('covidFirstDose')->nullable();
            $table->date('covidFirstDoseDate')->nullable();
            $table->string('covidSecondDose')->nullable();
            $table->date('covidSecondDoseDate')->nullable();
            $table->string('covidBoosterDose')->nullable();
            $table->date('covidBoosterDoseDate')->nullable();
            $table->text('otherDetails')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('siblings')->nullable();
            $table->string('spouse')->nullable();
            $table->string('children')->nullable();
            $table->text('smoker_Input')->nullable();
            $table->text('alcohol_Input')->nullable();
            $table->string('lmp')->nullable();
            $table->json('pmp')->nullable();
            $table->text('lsc')->nullable();
            $table->string('fpTechnique')->nullable();
            $table->string('gp')->nullable();
            $table->string('g1')->nullable();
            $table->string('g2')->nullable();
            $table->string('g3')->nullable();
            $table->string('g4')->nullable();
            $table->string('g5')->nullable();
            $table->json('constitutionalSymptoms')->nullable();
            $table->json('skin')->nullable();
            $table->json('ears')->nullable();
            $table->json('noseAndSinuses')->nullable();
            $table->json('mouthAndThroat')->nullable();
            $table->json('neck')->nullable();
            $table->json('respiratorySystem')->nullable();
            $table->json('cardiovascular')->nullable();
            $table->json('git')->nullable();
            $table->json('gut')->nullable();
            $table->json('extremities')->nullable();
            $table->json('nervousSystem')->nullable();
            $table->json('hematopoietic')->nullable();
            $table->json('endocrine')->nullable();
            $table->text('generalSurvey')->nullable();
            $table->text('headExam')->nullable();
            $table->text('faceExam')->nullable();
            $table->text('eyesExam')->nullable();
            $table->text('earsExam')->nullable();
            $table->text('noseExam')->nullable();
            $table->text('neckExam')->nullable();
            $table->text('cardiovascularExam')->nullable();
            $table->text('chestExam')->nullable();
            $table->text('skinExam')->nullable();
            $table->text('extremitiesExam')->nullable();
            $table->text('workingImpression')->nullable();
            $table->text('hypertension')->nullable();
            $table->text('diabetes')->nullable();
            $table->json('icdUmbrella')->nullable();
            $table->text('diagnostics')->nullable();
            $table->text('drugs')->nullable();
            $table->text('diet')->nullable();
            $table->text('disposition')->nullable();
            $table->integer('formType')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fcm_patients');
    }
};
