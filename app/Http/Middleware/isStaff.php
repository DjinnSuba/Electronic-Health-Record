<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;
use Session;


class isStaff{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session()->has('loginId')){
            return redirect('logins')->with('fail', 'You have to login first.');
        }else {
            $info = User::where('id', '=', Session::get('loginId'))-> first();
            if ($info-> department != "Family Medicine" && $info-> department != "Physical Therapist" ) {
            return redirect('/admin/dashboard')->with('fail', 'Unathorized.');
            //abort(Response::HTTP_UNAUTHORIZED);
            }
            return $next($request);
        }
    }

}
