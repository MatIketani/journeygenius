<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Notifications\User\WelcomeUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpRedirectResponse;

/**
 * Class GoogleController
 *
 * Controller responsible for handling the Google integration with Social Log In
 */
class GoogleController extends Controller
{

    /**
     * GET /google/redirect
     * Redirect to Google log-in page.
     *
     * @return RedirectResponse|HttpRedirectResponse
     */
    public function redirect(): RedirectResponse|HttpRedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * GET /google/callback
     * Login using Google user.
     *
     * @return Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function login(): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::query()->where('email', $googleUser->getEmail())->first();

        if (!$user) {

            /**
             * @var User $user
             */
            $user = User::query()->create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Str::password(),
                'email_verified_at' => now(),
            ]);

            $user->notify(new WelcomeUser($user));
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
