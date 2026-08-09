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
        Schema::create('subscription_transactions', function (Blueprint $table) {
            $table->id();
             $table->foreignId('subscription_id')->constrained()->onDelete('cascade');
            
            $table->string('transaction_id')->nullable();
            
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');
            
            $table->string('status', 50)
                  ->comment('completed, failed, refunded');
            
            $table->timestamp('payment_time')->nullable();
            
            $table->longtext('payment_response')->nullable()
                  ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_transactions');
    }
};
