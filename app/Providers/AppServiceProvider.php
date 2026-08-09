<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $roles = Role::with('permissions')->get() ;

        $permissionsArray = [];

        // Collection Of Roles Group By Permission.
        foreach ($roles as $role) {
            foreach ($role->permissions as $permissions) {
                $permissionsArray[$permissions->name][] = $role->id;
            }
        }

        foreach ($permissionsArray as $title => $roles) {

            Gate::define($title, function ($user) use ($roles, $title) {
                if(in_array($user->role_id, $roles)){
                    return true;
                }
            });
        }
    }
}
