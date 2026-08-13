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
        Schema::create('temp_cdc_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->text('related_blogs_ids')->nullable();
            $table->string('cdc_media_id')->nullable()->unique();
            $table->text('source_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_cdc_posts');
    }
};
