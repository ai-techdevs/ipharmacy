<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Cdc extends Model
{
    use HasSlug ;

    protected $guarded = [] ;


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');

    }

    public function comments()
    {
        return $this->hasMany(CdcComment::class, 'cdc_id', 'id');
    }

     public function getRelatedBlogsIdsAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }

    
    public function relatedBlogs()
    {
        return $this->hasMany(Cdc::class, 'id', 'id')
            ->whereIn('id', $this->related_blogs_ids);
    }
}

