<?php

namespace App\Repositories\Wallet;

use App\Dto\Wallet\WalletDTO;
use App\Models\Wallet\Wallet;

/**
 * Class WalletRepository
 *
 * Used to manage all database transaction on wallets.
 */
class WalletRepository
{
    /**
     * Create a new wallet instance inside the database.
     *
     * @param WalletDTO $walletDto
     * @return Wallet
     */
    public function create(WalletDTO $walletDto): Wallet
    {
        /**
         * @var Wallet $wallet
         */
        $wallet = Wallet::query()->create([
            'user_id' => $walletDto->userId,
            'credits' => $walletDto->credits
        ]);

        return $wallet;
    }
}
