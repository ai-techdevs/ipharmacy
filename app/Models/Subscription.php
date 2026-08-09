<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];



    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    public function transactions()
    {
        return $this->hasMany(SubscriptionTransaction::class);
    }
}
