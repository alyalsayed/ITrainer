<?php
<<<<<<< HEAD
=======


// https://stackoverflow.com/questions/43901719/laravel-middleware-with-multiple-roles


>>>>>>> origin/master
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
<<<<<<< HEAD
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        if ($user->userType !== $role) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
=======
    public function handle(Request $request, Closure $next,   ...$roles): Response
    {
       
        if (in_array(Auth::user()->userType, $roles)) {
            return $next($request);
        }

        abort(403);
>>>>>>> origin/master
    }
}
