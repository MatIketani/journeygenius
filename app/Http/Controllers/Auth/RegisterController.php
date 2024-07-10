<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\UserDTO;
use App\Dto\Wallet\WalletDTO;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Notifications\User\WelcomeUser;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Wallet\WalletRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = '/home';

    /**
     * User repository instance.
     *
     * @var UserRepository $userRepository
     */
    protected UserRepository $userRepository;

    /**
     * Wallet repository instance.
     *
     * @var WalletRepository $walletRepository
     */
    protected WalletRepository $walletRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepository User Repository dependency injection.
     * @param WalletRepository $walletRepository Wallet Repository dependency injection.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, WalletRepository $walletRepository)
    {
        $this->middleware('guest');

        $this->userRepository = $userRepository;

        $this->walletRepository = $walletRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        $userDto = new UserDTO(
            $data['name'],
            $data['email'],
            Hash::make($data['password'])
        );

        $user = $this->userRepository->create($userDto);

        $walletDto = new WalletDTO(
            $user->id,
            10
        );

        $this->walletRepository->create($walletDto);

        $user->notify(new WelcomeUser($user));

        return $user;
    }
}
