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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->text('description')->nullable();
            $table->string('paypal_product_id')->nullable()->comment('PayPal Product ID');
            $table->string('paypal_plan_id')->nullable()->comment('PayPal Plan ID');
            $table->string('interval_unit', 50)->default('MONTH')->comment('MONTH/YEAR');
            $table->integer('interval_count')->default(1);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
             $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
