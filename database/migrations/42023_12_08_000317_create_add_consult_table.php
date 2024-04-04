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
        Schema::create('add_consult', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patientId')->constrained(table: 'patient_codes', indexName: 'id')->onDelete('cascade');
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
            $table->text('subFindings')->nullable();;
            $table->text('objFindings')->nullable();;
            $table->text('assessment')->nullable();;
            $table->text('hypertension')->nullable();
            $table->text('diabetes')->nullable();
            $table->json('icdUmbrella')->nullable();
            $table->text('diagnostics')->nullable();
            $table->text('drugs')->nullable();
            $table->text('diet')->nullable();
            $table->text('disposition')->nullable();
            $table->integer('formType')->default(1); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_consult');
    }
};
