<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;


class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            // Find or create the user
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)),
                    'profile_image' => $googleUser->getAvatar(),
                    'userType' => 'student',
                ]
            );

            Auth::login($user);

            // Role-based redirection
            if ($user->userType === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->userType === 'instructor') {
                return redirect()->intended(route('instructor.dashboard'));
            } elseif ($user->userType === 'student') {
                return redirect()->intended(route('student.dashboard'));
            }

            return redirect()->intended('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Unable to login with Google.']);
        }
    }
 
     public function redirectToFacebook()
     {
         return Socialite::driver('facebook')->redirect();
     }
 
     public function handleFacebookCallback()
     {
         try {
             $facebookUser = Socialite::driver('facebook')->stateless()->user();
            
             $user = User::firstOrCreate(
                 ['email' => $facebookUser->getEmail()],
                 [
                     'name' => $facebookUser->getName(),
                     'password' => bcrypt(Str::random(16)),
                     'profile_image' => $facebookUser->getAvatar(),
                     'userType' => 'student',
                 ]
             );
 
             Auth::login($user);
 
             // Role-based redirection
             if ($user->userType === 'admin') {
                 return redirect()->intended(route('admin.dashboard'));
             } elseif ($user->userType === 'instructor') {
                 return redirect()->intended(route('instructor.dashboard'));
             } elseif ($user->userType === 'student') {
                 return redirect()->intended(route('student.dashboard'));
             }
 
             return redirect()->intended('/');
         } catch (\Exception $e) {
             return redirect('/login')->withErrors(['error' => 'Unable to login with Facebook.']);
         }
     }
}
