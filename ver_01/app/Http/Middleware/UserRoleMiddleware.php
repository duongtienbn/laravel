<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Auth;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \Integer  role
     * @return mixed
     */

    // Add custom parameter $role which pass from Route.php
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // checks the rolles(...$roles) array(from routs), 
        // and sees if there is a match on user role(from DB)
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }else {
            return redirect('access-denied')->with(Auth::user()->role);
            // return response()->json(['You do not have permission to access for this page.']);
        }
    }
}
