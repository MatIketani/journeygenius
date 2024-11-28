<?php

namespace App\Dto\Auth;

use Carbon\Carbon;

/**
 * Class UserDTO
 *
 * User model Data Transfer Object (DTO)
 */
class UserDTO
{
    public string $name;

    public string $email;

    public string $password;

    public ?Carbon $emailVerifiedAt;

    public bool $googleAccount;

    /**
     * Constructor method.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param Carbon|null $emailVerifiedAt
     * @param bool $googleAccount
     */
    public function __construct(
        string $name,
        string $email,
        string $password,
        ?Carbon $emailVerifiedAt = null,
        bool $googleAccount = false
    )
    {
        $this->name = $name;

        $this->email = $email;

        $this->password = $password;

        $this->emailVerifiedAt = $emailVerifiedAt;

        $this->googleAccount = $googleAccount;
    }
}
