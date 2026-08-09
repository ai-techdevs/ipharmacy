<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CdcComment extends Model
{
    protected $fillable = ['cdc_id', 'name', 'email', 'website', 'message', 'status'];


    public function cdc()
    {
        return $this->belongsTo(Cdc::class, 'cdc_id', 'id');
    }
}
