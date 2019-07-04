<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use DiDom\Document;
use Httpful\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Nesk\Puphpeteer\Puppeteer;

class EntSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ent:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取娱乐的original_url';

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
            while (true) {
                $response = Request::get(config('spider.spider_url.ent'))
                    ->addHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36')
                    ->addHeader('Cookie', 'tt_webid=6707093169689118215; xiguavideopcwebid=6707093163134649864; xiguavideopcwebid.sig=LEb5f42Asx_PqJ9zxaW3u8SGLP4; Hm_lvt_db8ae92f7b33b6596893cdf8c004a1a2=1561616846; SLARDAR_WEB_ID=5b6fd568-251e-41e7-b3ad-1328c8073e83; s_v_web_id=65a5bbff32d089d1512cdce3a34c974a; _ga=GA1.2.1771259702.1561616854; _gid=GA1.2.180337239.1561975032; Hm_lpvt_db8ae92f7b33b6596893cdf8c004a1a2=1562232551')
                    ->timeout(5)
                    ->send();

                $result = $response->body;

                $insert = [];
                $baseUrl = config('spider.spider_url.xigua_base_url');

                if ($result && isset($result->data->cards)) {
                    foreach ($result->data->cards as $card) {
                        try {
                            if (!$card->videoId || !$card->videoTitle || !$card->videoImage) {
                                continue;
                            }

                            $url   = $baseUrl . '/i' . $card->videoId.'/';
                            $title = $card->videoTitle;
                            $thumb = $card->videoImage;

                            // 数据库是否有相同记录，有则跳过
                            $video = Video::where('category_id', config('spider.category.ent'))
                                ->where('status', 0)
                                ->where('original_url', $url)
                                ->first();

                            if ($video) {
                                continue;
                            }

                            $insert[] = [
                                'date'         => Carbon::now()->toDateString(),
                                'status'       => 0,
                                'category_id'  => config('spider.category.ent'),
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
                            myLog('ent_original_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]);
                            continue;
                        }
                    }

                    // 写入数据库
                    DB::table('videos')->insert($insert);
                }
                sleep(3);
            }
        } catch (\Exception $e) {
            myLog('ent_original_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]);
        }
    }
}
