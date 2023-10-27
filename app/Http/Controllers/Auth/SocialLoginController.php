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
                return back()->withErrors('Unable to connect the google account please refresh the webpage and try again. If still problem persists contact with administrator.');
            }

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // public function generateAccessTokenFromRefreshToken($email)
    // {
    //     $user = User::where('email', $email)->first();

    //     if (! $user) {

    //         return false;

    //     }

    //     $refreshToken = $user->google_refresh_token;

    //     // Initialize the Google API Client
    //     $client = new Client();
    //     $client->setClientId(config('services.google.client_id'));
    //     $client->setClientSecret(config('services.google.client_secret'));

    //     // Set the refresh token
    //     // $accessToken = ['access_token' => $user->google_token, 'refresh_token' => $refreshToken];
    //     // $client->setAccessToken($accessToken);
    //     $client->refreshToken($refreshToken);


    //     $client->fetchAccessTokenWithRefreshToken();

    //     $accessToken = $client->getAccessToken()['access_token'];

    //     return $accessToken;

    // }
}
