<?php

namespace App\Console;

use App\Console\Commands\FunSpider;
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
        'App\Console\Commands\FunSpider', // 搞笑
        'App\Console\Commands\FunUrlSpider',
        'App\Console\Commands\EntSpider', // 娱乐
        'App\Console\Commands\EntUrlSpider',
//        'App\Console\Commands\GameSpider', // 游戏
//        'App\Console\Commands\GameUrlSpider',
//        'App\Console\Commands\ComicSpider', // 动漫
//        'App\Console\Commands\ComicUrlSpider',
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
        //          ->hourly();
        $schedule->command('fun:spider')->everyTenMinutes();
        $schedule->command('fun_url:spider')->hourly();
        $schedule->command('ent:spider')->everyTenMinutes();
        $schedule->command('ent_url:spider')->hourly();
//        $schedule->command('game:spider')->everyTenMinutes();
//        $schedule->command('game_url:spider')->hourly();
//        $schedule->command('comic:spider')->everyTenMinutes();
//        $schedule->command('comic_url:spider')->hourly();
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
