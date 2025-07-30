<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;

class SocialiteController extends Controller
{
public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        if ($googleUser->email !== 'pemdesngrejo@gmail.com') {
            return redirect('/')->with('error', 'Akun tidak diizinkan login.');
        }

        $user = User::updateOrCreate([
            'google_id' => $googleUser->getId(),
        ], [
            'username' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);

        Auth::login($user);
        return redirect('/admin/profile');
    }
}
