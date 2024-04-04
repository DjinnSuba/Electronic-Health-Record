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
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('patientId')->constrained(table: 'patient_codes', indexName: 'patientId')->onDelete('cascade');       
            $table->string('patientCodez');     

            $table->foreignId('attendingId')->constrained(table: 'users', indexName: 'attendingId')->onDelete('cascade');
            $table->string('physicianCodez');
            
            $table->string('accessId')->nullable();
            $table->string('status')->nullable();
            $table->string('formType');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropForeign('lists_patientCode_foreign');
        $table->dropIndex('lists_patientCode_index');
        $table->dropColumn('patientCode');
        $table->dropForeign('lists_physicianCode_foreign');
        $table->dropIndex('lists_physicianCode_index');
        $table->dropColumn('physicianCode');
        Schema::dropIfExists('accesses');
    }
};
