<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use DiDom\Document;
use Httpful\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Nesk\Puphpeteer\Puppeteer;

class FunSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fun:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取搞笑视频的原始地址';

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
     * 爬取搞笑视频的第一个url
     */
    public function handle()
    {
        try {
            $thumb = ''; // 视频照
            $url   = '';
            $title = '';

            $puppeteer = new Puppeteer([
                'debug'        => true,
                'stop_timeout' => 6,
                'read_timeout' => 30,
                'idle_timeout' => 60,
            ]);

            $browser = $puppeteer->launch([
                'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
            ]);

            $page = $browser->newPage();

            $page->goto(config('spider.spider_url.fun'));
            $html = $page->content(); // Prints the

            $document = new Document();
            $doc      = $document->load($html);

//            $input = $doc->first(".player");
            $documents = $doc->find(config('spider.fun.class')); // 数组
//            dd($documents);
            $insert = [];
            array_unique($documents, SORT_REGULAR); // 去重

            if (is_array($documents) && count($documents) > 0) {
                foreach ($documents as $k => $document) {
                    try {
                        $urlDoc = $document->first("a");
                        $imgDoc = $document->first('img');

                        $baseUrl = config('spider.spider_url.fun_base_url');

                        if (isset($urlDoc) && $urlDoc) {
                            $url   = $baseUrl . $urlDoc->getAttribute('href');
                            $title = $urlDoc->getAttribute('title');
                        }

                        if (isset($imgDoc) && $imgDoc) {
                            $thumb = 'http:' . $imgDoc->getAttribute('src');
                        }
                        // 没有找到则跳过
                        if (!$url || !$title || !$thumb) {
                            continue;
                        }
                        // 数据库是否有相同记录，有则跳过
                        $video = Video::where('category_id', config('spider.category.fun'))
                            ->where('original_url', $url)
                            ->first();

                        if ($video) {
                            continue;
                        }

                        $insert[] = [
                            'date'         => Carbon::now()->toDateString(),
                            'status'       => 0,
                            'category_id'  => config('spider.category.fun'),
                            'title'        => $title,
                            'thumb'        => $thumb,
                            'original_url' => $url,
                            'url'          => '',
                            'play_times'   => 0,
                            'source_id'    => 2, // 西瓜视频
                            'created_at'   => Carbon::now()->toDateTimeString(),
                            'updated_at'   => Carbon::now()->toDateTimeString(),
                        ];

                    } catch (\Exception $e) {
                        myLog('fun_original_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]);
                        continue;
                    }
                }
                // 写入数据库
                DB::table('videos')->insert($insert);
            }
        } catch (\Exception $e) {
            myLog('fun_original_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]);
        }
    }
}