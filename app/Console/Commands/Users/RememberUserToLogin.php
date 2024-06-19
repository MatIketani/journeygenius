<?php

namespace App\Console\Commands\Users;

use App\Models\Auth\User;
use App\Notifications\User\RememberLogin;
use Illuminate\Console\Command;

class RememberUserToLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remember-user-to-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a remember notification to users that did not log-in on the last 15 days.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $usersToBeNotified = User::query()
            ->where('last_login_at', '<=', today()->subDays(15))
            ->get();

        /**
         * @var User $user
         */
        foreach ($usersToBeNotified as $user) {

            $user->notify(new RememberLogin());
        }
    }
}
