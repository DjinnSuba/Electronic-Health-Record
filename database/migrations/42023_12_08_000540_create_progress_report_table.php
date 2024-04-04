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
        Schema::create('progress_report', function (Blueprint $table) {
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
            //$table->text('refMD');
            $table->date('dateOfConsult');
            $table->time('timeOfConsult');
            $table->time('timeOfEndConsult');
            $table->string('duration')->nullable();
            $table->text('attendees');
            $table->text('modeOrVenue');
            $table->text('changes');
            $table->text('focus');
            
            $table->foreignId('vsId')->constrained(table: 'vital_signs', indexName: 'vsId')->onDelete('cascade');
            $table->text('significance');

            $table->text('managementAct');
            $table->text('plan');
            $table->text('references');
            $table->string('attachment')->nullable();
            $table->text('license') ->nullable();
            $table->integer('formType')->default(3); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_report');
    }
};
