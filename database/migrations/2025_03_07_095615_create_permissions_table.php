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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("route_name");
            $table->string("display_name");
            $table->tinyInteger("is_resource_route")->default(1)->comment("1 = Yes, 0 = No");
            $table->tinyInteger("status")->default(1)->comment("1 = active, 0 = inactive");
            $table->bigInteger('menu_id')->nullable();
            $table->tinyInteger("checking_required")->default(1)->comment("1 = Yes, 0 = No");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
