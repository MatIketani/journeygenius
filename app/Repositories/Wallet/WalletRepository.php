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

    /**
     * Add credits to the provided wallet.
     *
     * @param Wallet $wallet
     * @param int $credits
     * @return void
     */
    public function addCredits(Wallet $wallet, int $credits): void
    {
        $wallet->credits += $credits;

        $wallet->save();
    }
}
