<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\UserDTO;
use App\Dto\Invitation\InvitationDTO;
use App\Dto\Invitation\InviteCodeDTO;
use App\Dto\Wallet\WalletDTO;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Notifications\User\WelcomeUser;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Invitation\InvitationRepository;
use App\Repositories\Invitation\InviteCodeRepository;
use App\Repositories\Wallet\WalletRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
     * Invite Code Repository instance.
     *
     * @var InviteCodeRepository $inviteCodeRepository
     */
    protected InviteCodeRepository $inviteCodeRepository;

    /**
     * Invitation Repository instance.
     *
     *
     * @var InvitationRepository $invitationRepository
     */
    protected InvitationRepository $invitationRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $userRepository User Repository dependency injection.
     * @param WalletRepository $walletRepository Wallet Repository dependency injection.
     * @param InviteCodeRepository $inviteCodeRepository Invite Code Repository dependency injection.
     * @param InvitationRepository $invitationRepository Invitation Repository dependency injection.
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        WalletRepository $walletRepository,
        InviteCodeRepository $inviteCodeRepository,
        InvitationRepository $invitationRepository
    )
    {
        $this->middleware('guest');

        $this->userRepository = $userRepository;

        $this->walletRepository = $walletRepository;

        $this->inviteCodeRepository = $inviteCodeRepository;

        $this->invitationRepository = $invitationRepository;
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
            'invite_code' => ['nullable' ,'string', 'size:8', 'exists:invite_codes,code'],
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

        $creditsReward = 10;

        $inviteCode = $data['invite_code'] ?? null;

        if ($inviteCode) {

            $inviteCode = $this->inviteCodeRepository->getByCode($inviteCode);

            $creditsReward = $inviteCode->credits_reward;

            $invitationDto = new InvitationDTO(
                $user->id,
                $inviteCode->id
            );

            $this->invitationRepository->create($invitationDto);

            $this->walletRepository->addCredits($inviteCode->wallet, 5);
        }

        $walletDto = new WalletDTO(
            $user->id,
            $creditsReward
        );

        $this->walletRepository->create($walletDto);

        $inviteCodeDto = new InviteCodeDTO(
            $user->id,
            Str::random(8),
            15
        );

        $this->inviteCodeRepository->create($inviteCodeDto);

        $user->notify(new WelcomeUser($user));

        return $user;
    }
}
