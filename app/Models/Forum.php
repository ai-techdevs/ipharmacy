<?php

namespace App\Models;

use App\Models\User;
use App\Models\Action;
use App\Models\ForumComment;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $guarded = [] ;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'forum_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Action::class, 'table_id', 'id')->where(['table' => 'forums', 'action_type' => 'like', 'status'=>1]);
    }

    public function shares()
    {
        return $this->hasMany(Action::class, 'table_id', 'id')->where(['table' => 'forums', 'action_type' => 'share', 'status'=>1]);
    }
}
