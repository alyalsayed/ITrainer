<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles  // Allow multiple roles as arguments
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // If the user is not authenticated, redirect to login
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Check if the user's role matches any of the provided roles
        if (in_array($user->userType, $roles)) {
            return $next($request);
        }

        // If the role doesn't match, deny access
        abort(403, 'Unauthorized access');
    }
}
