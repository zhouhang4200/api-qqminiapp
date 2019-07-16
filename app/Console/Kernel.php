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
        'App\Console\Commands\QQVideoSpider', // 爬取二级分类视频地址
        'App\Console\Commands\QQGameSpider', // 爬取游戏和娱乐的一级分类视频地址
        'App\Console\Commands\DeleteVideoOverDate', // 删除6小时前视频
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('qq:video')->daily();
        $schedule->command('qq:video')->dailyAt('02:30');
        $schedule->command('qq:video')->dailyAt('03:30');
        $schedule->command('qq:video')->dailyAt('05:00');
        $schedule->command('qq:video')->dailyAt('08:00');
        $schedule->command('qq:video')->dailyAt('11:00');
        $schedule->command('qq:video')->dailyAt('14:30');
        $schedule->command('qq:video')->dailyAt('17:00');
        $schedule->command('qq:video')->dailyAt('20:00');
        $schedule->command('qq:video')->dailyAt('22:00');
        $schedule->command('qq:game')->everyThirtyMinutes();
        $schedule->command('qq:delete')->everyTenMinutes();
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
