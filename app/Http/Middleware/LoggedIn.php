<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

class LoggedIn {
    public function handle(Request $request, Closure $next): Response {
        if(Session()->has('loginId') && (url('logins') == $request -> url())){
            return back();
        }
        return $next($request);
    }
}
