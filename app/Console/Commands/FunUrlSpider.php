<?php

namespace App\Console\Commands;

use App\Models\Video;
use DiDom\Document;
use Httpful\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use JonnyW\PhantomJs\Client;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;
use QL\Ext\Chrome;
use QL\Ext\PhantomJs;
use QL\QueryList;

class FunUrlSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fun_url:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '通过搞笑视频的原始地址获取真实地址';

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
            'debug'        => true,
            'stop_timeout' => 6,
            'read_timeout' => 30,
            'idle_timeout' => 60,
        ]);

        $browser = $puppeteer->launch([
            'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
        ]);

        // 获取数据库里面状态为0的所有的原始地址
        Video::where('status', 0)
            ->where('category_id', 3)
            ->chunk(100, function ($chunks) use ($url, $browser) {
            foreach ($chunks as $video) {
                try {
                    $page = $browser->newPage();

                    $page->goto($video->original_url);
                    $html = $page->content(); // Prints the HTML

                    $document = new Document();
                    $doc      = $document->load($html);
                    $urlDoc   = $doc->first('video');

                    if ($urlDoc) {
                        $url = $urlDoc->getAttribute('src');
                    } else {
                        $video->delete();
                        continue;
                    }

                    // 写入数据库
                    if ($url) {
                        $video->status = 1;
                        $video->url    = $url;
                        $video->save();
                    } else {
                        $video->delete();
                        continue;
                    }
                } catch (\Exception $e) {
                    $video->delete();
                    myLog('fun_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]);
                    continue;
                }
            }
        });
        $browser->close();
    }
}
