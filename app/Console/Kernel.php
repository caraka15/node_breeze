<?php

namespace App\Console;

use GenerateSitemap;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Existing schedules
        $schedule->command('sitemap:generate')->daily();
        $schedule->command('telegram:send-notification')
            ->dailyAt('13:11')
            ->timezone('Asia/Jakarta');

        // Add Exorde tracking schedule (every 15 minutes)
        $schedule->command('exorde:track-reputation')
            ->everyFifteenMinutes()
            ->timezone('Asia/Jakarta');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateSitemaps::class,
        Commands\TrackExordeReputation::class, // Add this line
    ];
}
