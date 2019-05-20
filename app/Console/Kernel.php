<?php

namespace App\Console;

use App\Http\Controllers\Cron\CronApp;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        // ->hourly();
        $schedule->call(function(){
            $cronAds = new CronApp();
            $cronAds->updateAds(); //update all ads on crons table
        })->timezone('America/Caracas')->hourly();

        $schedule->call(function(){
            $cronAds = new CronApp();
            $cronAds->fillAvgCron();
        })->timezone('America/Caracas')->everyFiveMinutes();

        $schedule->call(function(){
            $cronAds = new CronApp();
            $cronAds->getOrderBook();
        })->timezone('America/Caracas')->hourlyAt(00);

        $schedule->call(function(){
            $cronAds = new CronApp();
            $cronAds->getOrderBook();
        })->timezone('America/Caracas')->hourlyAt(30);

        $schedule->call(function(){
            $cronAds = new CronApp();
            $cronAds->cronUpdateBands();
        })->timezone('America/Caracas')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
