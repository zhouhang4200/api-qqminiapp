<?php

namespace App\Console\Commands;

use App\Models\Video;
use DiDom\Document;
use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class GameUrlSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game_url:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = '';

        $puppeteer = new Puppeteer([
            'debug' => true,
            'stop_timeout' => 6,
            'read_timeout' => 30,
            'idle_timeout' => 60,
        ]);

        $browser = $puppeteer->launch([
            'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
        ]);

        // 获取数据库里面状态为0的所有的原始地址
        Video::where('status', 0)->chunk(100, function ($chunks) use ($url, $browser) {
//        Video::where('status', 0)->chunk(100, function ($chunks) use ($url) {
            foreach ($chunks as $video) {
                try {
//                    $puppeteer = new Puppeteer([
//                        'debug' => true,
//                        'stop_timeout' => 3,
//                    ]);
//
//                    $browser = $puppeteer->launch([
//                        'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
//                    ]);

                    $page = $browser->newPage();

                    $page->goto($video->original_url);

//                    $page->evaluate(JsFunction::createWithBody('return document.documentElement.outerHTML'));

                    $html = $page->content(); // Prints the HTML

                    $document = new Document();
                    $doc      = $document->load($html);
                    $urlDoc = $doc->first('video');

                    if ($urlDoc) {
                        $url = $urlDoc->getAttribute('src');
                    } else {
                        $video->delete();
                        continue;
                    }

                    // 写入数据库
                    if ($url) {
                        $video->status = 1;
                        $video->url = $url;
                        $video->save();
                    } else {
                        $video->delete();
                        continue;
                    }
                } catch (\Exception $e) {
                    $video->delete();

                    myLog('game_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]);

                    continue;
                }
            }
        });
        $browser->close();
    }
}
