<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;


class IsLoggedIn {
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session()->has('loginId')){
            return redirect('logins')->with('fail', 'You have to login first.');
        }
        return $next($request);
    }
}
