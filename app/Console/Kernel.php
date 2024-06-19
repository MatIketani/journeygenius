<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Deletes all accounts older than 15 days that have not yet had their email verified.
        $schedule->command('app:delete-not-verified-accounts')->dailyAt('00:00');

        // Send a remember notification to users that did not log-in on the last 15 days.
        $schedule->command('app:remember-user-to-login')->weeklyOn(1);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
