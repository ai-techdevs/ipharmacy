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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
            $table->enum('donation_type', ['one_time', 'monthly'])->default('one_time');

            $table->string('payment_method'); // paypal, square, etc.
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');

            $table->string('transaction_id')->nullable();
            $table->json('payment_response')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
