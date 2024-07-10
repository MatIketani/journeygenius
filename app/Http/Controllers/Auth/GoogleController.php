<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\UserDTO;
use App\Dto\Wallet\WalletDTO;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Notifications\User\WelcomeUser;
use App\Providers\RouteServiceProvider;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Wallet\WalletRepository;
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
     * User Repository instance.
     *
     * @var UserRepository $userRepository
     */
    private UserRepository $userRepository;

    /**
     * Wallet Repository instance.
     *
     * @var WalletRepository $walletRepository
     */
    private WalletRepository $walletRepository;

    /**
     * Constructor method.
     *
     * @param UserRepository $userRepository User Repository dependency injection.
     * @param WalletRepository $walletRepository Wallet Repository dependency injection.
     */
    public function __construct(UserRepository $userRepository, WalletRepository $walletRepository)
    {
        $this->userRepository = $userRepository;

        $this->walletRepository = $walletRepository;
    }

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

            $userDto = new UserDTO(
                $googleUser->getName(),
                $googleUser->getEmail(),
                Str::password(),
                now()
            );

            $user = $this->userRepository->create($userDto);

            $walletDto = new WalletDTO(
                $user->id,
                10
            );

            $this->walletRepository->create($walletDto);

            $user->notify(new WelcomeUser($user));
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
