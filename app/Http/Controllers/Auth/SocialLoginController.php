<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Google\Client;
use Google_Service_Calendar;

class SocialLoginController extends Controller
{
    // public function openGoogleIntegrationPage()
    // {
    //     return view('auth.social.login');
    // }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(
                // Google_Service_Calendar::CALENDAR
                [
                'https://www.googleapis.com/auth/calendar'
                ]
                )
            ->with(["access_type" => "offline", "prompt" => "consent"])
            ->redirect();
    }

    public function redirectGoogleAfterLogin()
    {
        try {

            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user)
            {
                $user->update([
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken
                ]);

                session()->flash('alert-success', 'Google Calendar integrated successfully!');

                return redirect()->route('auth.accounts.edit');
            }
            else
            {
                return to_route('auth.accounts.edit')->withErrors('The app account and Google account do not match, Please log in with the same Google account that you are connecting with our app. If the problem persists, please contact the administrator.');
            }

        } catch (\Exception $e) {
            return to_route('auth.accounts.edit')->withErrors('Failed to complete the process, due to this error: '.$e->getMessage());
        }
    }

}
