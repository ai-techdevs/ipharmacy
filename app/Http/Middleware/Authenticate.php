<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          if(!\Auth::check()){

            Redirect::setIntendedUrl(url()->previous());
            return redirect(route('login')) ;
        }

          if (\Auth::check() && \Auth::user()->status == 0) {
            \Auth::logout();

            return redirect()->route('login')
                ->withErrors(['Your account has been disabled.Please contact Admin!']);
        }
        return $next($request);
    }
}
