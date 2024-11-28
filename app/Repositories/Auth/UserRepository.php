<?php

namespace App\Repositories\Auth;

use App\Dto\Auth\UserDTO;
use App\Models\Auth\User;

/**
 * Class UserRepository
 *
 * Used to manage all database transactions involving users.
 */
class UserRepository
{
    /**
     * Create a new User instance on the database.
     *
     * @param UserDTO $userDto
     * @return User
     */
    public function create(UserDTO $userDto): User
    {
        /**
         * @var User $user
         */
        $user = User::query()->create([
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => $userDto->password,
            'email_verified_at' => $userDto->emailVerifiedAt,
            'google_account' => $userDto->googleAccount,
        ]);

        return $user;
    }
}
