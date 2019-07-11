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
//        'App\Console\Commands\FunSpider', // 搞笑
//        'App\Console\Commands\EntSpider', // 娱乐
//        'App\Console\Commands\ComicSpider', // 娱乐
//        'App\Console\Commands\WzrySpider', // 王者荣耀
//        'App\Console\Commands\DwrgSpider', // 第五人格
//        'App\Console\Commands\JdqsSpider', // 绝地求生
//        'App\Console\Commands\LolSpider', // 英雄联盟
//        'App\Console\Commands\HpjySpider', // 和平精英
//        'App\Console\Commands\FunFinalSpider', // 搞笑
//        'App\Console\Commands\EntFinalSpider', // 娱乐
//        'App\Console\Commands\ComicFinalSpider', // 娱乐
//        'App\Console\Commands\WzryFinalSpider', // 王者荣耀
//        'App\Console\Commands\DwrgFinalSpider', // 第五人格
//        'App\Console\Commands\JdqsFinalSpider', // 绝地求生
//        'App\Console\Commands\LolFinalSpider', // 英雄联盟
//        'App\Console\Commands\HpjyFinalSpider', // 和平精英
        'App\Console\Commands\QQVideoSpider', // 腾讯视频爬虫
        'App\Console\Commands\QQGameSpider', // 腾讯视频爬虫
//        'App\Console\Commands\FunUrlSpider',
//        'App\Console\Commands\EntUrlSpider',
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
//        $schedule->command('fun:spider')->everyTenMinutes();
//        $schedule->command('fun_final:spider')->everyTenMinutes();
//        $schedule->command('ent:spider')->everyTenMinutes();
//        $schedule->command('ent_final:spider')->everyTenMinutes();
//        $schedule->command('comic:spider')->everyTenMinutes();
//        $schedule->command('comic_final:spider')->everyTenMinutes();
//        $schedule->command('jdqs:spider')->everyTenMinutes();
//        $schedule->command('jdqs_final:spider')->everyTenMinutes();
//        $schedule->command('wzry:spider')->everyTenMinutes();
//        $schedule->command('wzry_final:spider')->everyTenMinutes();
//        $schedule->command('lol:spider')->everyTenMinutes();
//        $schedule->command('lol_final:spider')->everyTenMinutes();
//        $schedule->command('dwrg:spider')->everyTenMinutes();
//        $schedule->command('dwrg_final:spider')->everyTenMinutes();
//        $schedule->command('hpjy:spider')->everyTenMinutes();
//        $schedule->command('hpjy_final:spider')->everyTenMinutes();
        $schedule->command('qq:video')->hourly();
        $schedule->command('qq:game')->hourly();
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
