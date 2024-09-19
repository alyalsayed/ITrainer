<?php


// https://stackoverflow.com/questions/43901719/laravel-middleware-with-multiple-roles


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,   ...$roles): Response
    {
       
        if (in_array(Auth::user()->userType, $roles)) {
            return $next($request);
        }

        abort(403);
    }
}
