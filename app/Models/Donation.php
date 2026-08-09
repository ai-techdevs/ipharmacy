<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
   protected $fillable = [
        'name',
        'email',
        'phone',
        'amount',
        'currency',
        'donation_type',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_response',
        'invoice_sent',
         'customer_id',
        'subscription_id',
        'card_id',
        'next_payment_date',
        'subscription_status',
    ];

    protected $casts = [
        'payment_response' => 'array',
        'next_payment_date' => 'datetime',
        'payment_response' => 'array',
    ];


    

    // public function isSubscription(): bool
    // {
    //     return $this->donation_type === 'Donation_Monthly';
    // }

    
    // public function isActiveSubscription(): bool
    // {
    //     return  $this->subscription_status === 'active';
    // }

  
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->amount, 2);
    }

    public function donations() {
    return $this->hasMany(Donation::class);
}

public function subscription() {
    return $this->belongsTo(Subscription::class,'subscription_id', 'id');
}
}
