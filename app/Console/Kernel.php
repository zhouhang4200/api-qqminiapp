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
        'App\Console\Commands\DeleteVideoOverDate', // 删除2天前视频
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('qq:video')->everyFiveMinutes();
        $schedule->command('qq:game')->everyFiveMinutes();
        $schedule->command('qq:delete')->everyFiveMinutes();
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
