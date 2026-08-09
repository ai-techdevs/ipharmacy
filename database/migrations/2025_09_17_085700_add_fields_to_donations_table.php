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
        Schema::table('donations', function (Blueprint $table) {
             //$table->enum('donation_type', ['Donation_One_Time', 'Donation_Monthly'])->default('Donation_One_Time')->after('payment_method');
            $table->string('customer_id')->nullable()->after('transaction_id');
            $table->string('subscription_id')->nullable()->after('customer_id');
            $table->string('card_id')->nullable()->after('subscription_id');
            $table->timestamp('next_payment_date')->nullable()->after('card_id');
            $table->enum('subscription_status', ['active', 'cancelled', 'paused', 'pending'])->nullable()->after('next_payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
             $table->dropColumn([
               
                'customer_id', 
                'subscription_id',
                'card_id',
                'next_payment_date',
                'subscription_status'
            ]);
        });
    }
};
