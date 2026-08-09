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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('slug')->unique();
            $table->longText('uses')->nullable();
            $table->longText('additional_information')->nullable();
            $table->longText('precautions')->nullable();
            $table->longText('interactions')->nullable();
            $table->longText('side_effects')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('image_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->longText('video_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
