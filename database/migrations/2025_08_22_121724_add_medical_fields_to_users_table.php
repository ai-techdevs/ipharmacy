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
        Schema::table('users', function (Blueprint $table) {
            $table->text('existing_medical_conditions')->nullable();
            $table->text('currently_taking_medications')->nullable();
            $table->text('known_allergies')->nullable();
            $table->text('previous_surgeries')->nullable();
            $table->text('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn([
                'existing_medical_conditions',
                'currently_taking_medications',
                'known_allergies',
                'previous_surgeries',
                'medical_image',
            ]);
        });
    }
};
