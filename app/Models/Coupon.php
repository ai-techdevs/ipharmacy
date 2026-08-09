<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
   
    protected $fillable = [
        'discount', 'title', 'description', 'button_text', 'button_link', 'image','status','image2'
    ];

}
