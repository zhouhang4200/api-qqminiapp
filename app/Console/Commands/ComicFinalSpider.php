<?php

namespace App\Console\Commands;

use App\Models\Video;
use DiDom\Document;
use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;

class ComicFinalSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comic_final:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '动漫最终爬虫';

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
        try {
            $url = '';

            $puppeteer = new Puppeteer([
//                'debug'        => true,
                'stop_timeout' => 10,
                'read_timeout' => 60,
                'idle_timeout' => 60,
                'timeout' => 60
            ]);

            $browser = $puppeteer->launch([
                'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
            ]);

            // 获取数据库里面状态为0的所有的原始地址
            Video::where('status', 0)
                ->where('category_id', config('spider.category.comic')) // 改第一处
                ->chunk(100, function ($chunks) use ($url, $browser) {
                    foreach ($chunks as $video) {
                        try {
                            $page = $browser->newPage();

                            $page->goto($video->original_url, ['timeout' => 60000]);
                            $html = $page->content(); // Prints the HTML

                            $document = new Document();
                            $doc      = $document->load($html);
                            $urlDoc   = $doc->first('video');

                            if ($urlDoc) {
                                $url = $urlDoc->getAttribute('src');
                            } else {
                                myLog('comic_final_spider_error', ['src不存在！']); // 改第二处
//                                $video->delete();
                                continue;
                            }

                            // 写入数据库
                            if ($url) {
                                $video->status = 1;
                                $video->url    = $url;
                                $video->save();
                            } else {
//                                $video->delete();
                                continue;
                            }
                            sleep(mt_rand(4, 9));
                        } catch (\Exception $e) {
//                            $video->delete();
                            myLog('comic_final_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]); // 改第二处
                            continue;
                        }
                    }
                });
            $browser->close();
        } catch (\Exception $e) {
            myLog('comic_final_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]); // 改第二处

        }
    }
}
