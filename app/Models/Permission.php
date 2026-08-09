<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public const IS_RESOURCE_ROUTE_YES = 1;
    public const IS_RESOURCE_ROUTE_NO  = 0;
    public const IS_CHECKING_REQUIRED_YES = 1;
    public const IS_CHECKING_REQUIRED_NO  = 0;

    protected $guarded = [] ;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, "menu_id", "id");
    }
}
