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
        Schema::create('doctor_queries', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('age_group', 40)->nullable();
            $table->string('gender', 40)->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city', 40)->nullable();
            $table->string('state', 40)->nullable();
            $table->string('zip', 40)->nullable();
            $table->text('existing_medical_condition')->nullable();
            $table->text('currenty_taking_medication')->nullable();
            $table->text('known_allergies')->nullable();
            $table->text('previous_allergies')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_queries');
    }
};
