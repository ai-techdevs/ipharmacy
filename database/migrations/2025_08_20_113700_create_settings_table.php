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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable() ;
            $table->string('display_name')->nullable() ;
            $table->longText('value')->nullable() ;
            $table->longText('details')->nullable() ;
            $table->string('type')->nullable() ;
            $table->integer('order')->nullable() ;
            $table->string('group')->nullable() ;
            $table->tinyInteger('is_visible')->nullable() ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
