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
        Schema::create('cdc_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cdc_id');
        $table->string('name');
        $table->string('email');
        $table->string('website')->nullable();
        $table->text('message');
        $table->boolean('status')->default('true');
            $table->timestamps();
             $table->foreign('cdc_id')->references('id')->on('cdcs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdc_comments');
    }
};
