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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            
            $table->string('customer_id')->nullable()
                  ->comment('PayPal Payer ID / Stripe Customer ID');
            
            $table->string('subscription_gateway_id')->nullable()
                  ->comment('PayPal/Stripe subscription ID');
            
            $table->string('plan_id')->nullable();
            
            $table->string('status', 50)->default('ACTIVE')
                  ->comment('ACTIVE, SUSPENDED, CANCELLED, EXPIRED');
            
            $table->timestamp('start_date')->nullable();
            $table->timestamp('next_payment_date')->nullable();
            $table->timestamp('end_date')->nullable();
            
            $table->string('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
