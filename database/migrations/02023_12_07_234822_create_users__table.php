<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('physicianCode');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName')->nullable();

            $table->date('birthday');
            $table->string('cnumber')->nullable();
            $table->string('address');

            $table->string('email');
            $table->string('password');
            
            $table->string('department');
            $table->string('status');
            $table->string('license');
            $table->string('profile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
