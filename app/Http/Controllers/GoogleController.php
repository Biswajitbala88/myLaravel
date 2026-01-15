<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('google_id', $googleUser->id)->first();
            if (empty($user)) {
                // Create a new user if not found
                $data = [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('12345678'),
                ];
                $user = User::updateOrCreate(
                    ['email' => $googleUser->email],   
                    [
                        'name' => $googleUser->name,
                        'google_id' => $googleUser->id,
                        'password' => bcrypt(str()->random(16)),
                    ]
                );
            }
            Auth::login($user);
            return redirect()->intended('/dashboard');
        } catch (Exception $e) {
            return redirect('/login')->withErrors('Unable to login using Google. Please try again.');
        }
    }
}