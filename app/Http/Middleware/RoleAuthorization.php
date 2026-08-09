<?php

namespace App\Http\Middleware;

use Closure;
Use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = request()->route()->getName();



        // $taskName = Permission::where('route_name', $routeName)->first()->name ?? "";
        $permission = Permission::where('route_name', $routeName)->where('checking_required', Permission::IS_CHECKING_REQUIRED_YES)->first();

       
        //----------checking permission if it is resource route----------
        if(empty($permission))
        {
            //if permission is stored in store or update or destroy and route is create or edit or delete then it's also accepted
            $alternateRouteName = str_replace(["store", "update", "destroy"], ["create", 'edit', "delete"], $routeName);
            $permission = Permission::where('route_name', $alternateRouteName)->where('checking_required', Permission::IS_CHECKING_REQUIRED_YES)->where("is_resource_route", Permission::IS_RESOURCE_ROUTE_YES)->first();
        }
        if(empty($permission))
        {
            //if permission is stored in create or edit or delete and route is store or update or destroy then it's also accepted
            $alternateRouteName = str_replace(["create", 'edit', "delete"], ["store", "update", "destroy"], $routeName);
            $permission = Permission::where('route_name', $alternateRouteName)->where('checking_required', Permission::IS_CHECKING_REQUIRED_YES)->where("is_resource_route", Permission::IS_RESOURCE_ROUTE_YES)->first();
        }
        //----------end checking permission if it is resource route----------
        if(!empty($permission))
        {
            $taskName = $permission->name ?? "";
            abort_if(!auth()->user()->can($taskName), 403, 'User does not have the right permissions.');
        }
        return $next($request);
    }
}
