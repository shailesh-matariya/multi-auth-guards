<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if you are logged in -> it will redirect you to intended homepage
        if (Auth::guard($guard)->check()) {
            $guard = $guard ? $guard. '.home' : 'app1.home';
            return redirect(route($guard));
        }

        return $next($request);
    }
}
