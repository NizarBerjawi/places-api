<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateDocumentation::class,
        Commands\DownloadGeonamesFiles::class,
        Commands\ImportGeonamesFiles::class,
        Commands\UpdateGeonamesData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('geonames:update')
            ->withoutOverlapping()
            ->dailyAt('22:00');

        $schedule->command('responsecache:clear')
            ->dailyAt('22:30');
    }
}
