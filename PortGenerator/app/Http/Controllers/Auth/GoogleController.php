<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

   public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
        
        $user = User::where('email', $googleUser->getEmail())->first();

        // Scenario A: If they are trying to register, but the email already exists
        // (You can check a session flag if you set one during redirect)
        if (session('auth_action') === 'register' && $user) {
            return redirect('/login')->with('error', 'An account with this email already exists. Please log in instead.');
        }

        // Scenario B: Standard login/create flow
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(24)),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Logged in successfully!');

    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Google authentication failed. Please try again.');
    }
}
}