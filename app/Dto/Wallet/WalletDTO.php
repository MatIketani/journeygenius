<?php

namespace App\Dto\Wallet;

/**
 * Class UserDTO
 *
 * Wallet model Data Transfer Object (DTO)
 */
class WalletDTO
{
    public int $userId;

    public int $credits;

    /**
     * Constructor method.
     *
     * @param int $userId
     * @param int $credits
     */
    public function __construct(int $userId, int $credits)
    {
        $this->userId = $userId;

        $this->credits = $credits;
    }
}
