<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate the session to prevent session fixation
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Flash notification to the session
        session()->flash('login_success', 'Welcome back, ' . $user->name . '!');

        // Role-based redirection
        if ($user->userType === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->userType === 'hr') {
            return redirect()->intended(route('hr.dashboard'));
        } elseif ($user->userType === 'instructor') {
            return redirect()->intended(route('instructor.dashboard'));
        } elseif ($user->userType === 'student') {
            return redirect()->intended(route('student.dashboard'));
        }

        // Default redirection if role doesn't match
        // return redirect()->intended(route('dashboard'));

        return redirect()->intended('/');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
