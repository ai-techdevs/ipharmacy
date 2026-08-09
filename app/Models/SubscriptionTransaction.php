<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionTransaction extends Model
{
     protected $fillable = [
        'subscription_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'payment_time',
        'payment_response'
    ];



     public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

  
    public function user()
    {
        return $this->subscription->user();
    }
}
