<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{

    public function handle(Request $request, Closure $next): Response
    {

        if(!\Auth::check()){

            Redirect::setIntendedUrl(url()->previous());
            return redirect(route('admin.login')) ;
        }


        return $next($request);
    }
}
