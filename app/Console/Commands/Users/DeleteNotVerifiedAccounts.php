<?php

namespace App\Console\Commands\Users;

use App\Models\Auth\User;
use Illuminate\Console\Command;

class DeleteNotVerifiedAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-not-verified-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all accounts older than 15 days that have not yet had their email verified.';

    /**
     * The code below deletes from the database all users who were created more than 15 days ago and have not
     * yet had their email address verified.
     */
    public function handle(): void
    {
        User::query()
            ->where('created_at', '<', today()->subDays(15))
            ->whereNull('email_verified_at')
            ->forceDelete();
    }
}
