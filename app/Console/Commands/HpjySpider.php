<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use DiDom\Document;
use Httpful\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HpjySpider extends Command
{
    protected $url = '';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hpjy:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '和平精英爬虫';

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
            $thumb     = ''; // 视频照
            $url       = '';
            $title     = '';
            $play_time = '';

            while (true) {
                if ($this->url) {
                    $original_url = $this->url;
                } else {
                    $original_url = config('spider.spider_url.game.hpjy'); // 改第一处
                }

                // 第五人格
                $response = Request::get($original_url)
                    ->addHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36')
                    ->addHeader('Cookie', 'tt_webid=6707093169689118215; xiguavideopcwebid=6707093163134649864; xiguavideopcwebid.sig=LEb5f42Asx_PqJ9zxaW3u8SGLP4; Hm_lvt_db8ae92f7b33b6596893cdf8c004a1a2=1561616846; SLARDAR_WEB_ID=5b6fd568-251e-41e7-b3ad-1328c8073e83; s_v_web_id=65a5bbff32d089d1512cdce3a34c974a; _ga=GA1.2.1771259702.1561616854; _gid=GA1.2.180337239.1561975032; Hm_lpvt_db8ae92f7b33b6596893cdf8c004a1a2=1562232551')
                    ->timeout(5)
                    ->send();

                $html = $response->body;

                $document  = new Document();
                $doc       = $document->load($html);
                $documents = $doc->find(config('spider.document.class')); // 数组
//                dd($documents);
                $insert = [];
                array_unique($documents, SORT_REGULAR); // 去重

                if (is_array($documents) && count($documents) > 0) {
                    foreach ($documents as $k => $document) {
                        try {
                            $urlDoc  = $document->first("a");
                            $imgDoc  = $document->first('img');
                            $timeDoc = $document->first('span');
                            $baseUrl = config('spider.spider_url.xigua_base_url');

                            if (isset($timeDoc) && $timeDoc) {
                                $play_time = $timeDoc->text() ?? '';
                            }

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
                            $video = Video::where('category_id', config('spider.category.hpjy')) // 改第五处
                            ->where('original_url', $url)
                                ->first();

                            if ($video) {
                                continue;
                            }

                            $insert[] = [
                                'date'         => Carbon::now()->toDateString(),
                                'status'       => 0,
                                'category_id'  => config('spider.category.hpjy'), // 改第二处
                                'title'        => $title,
                                'thumb'        => $thumb,
                                'original_url' => $url,
                                'url'          => '',
                                'play_time'     => $play_time,
                                'play_count'   => 0,
                                'source_id'    => 2, // 西瓜视频
                                'created_at'   => Carbon::now()->toDateTimeString(),
                                'updated_at'   => Carbon::now()->toDateTimeString(),
                            ];

                        } catch (\Exception $e) {
                            myLog('hpjy_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]); // 改第三处
                            continue;
                        }
                    }
                    // 写入数据库
                    if ($insert && count($insert) > 0) {
                        DB::table('videos')->insert($insert);
                        $this->url = end($insert)['original_url'] ?? '';

                        if (!$this->url) {
                            break;
                        }
                    }
                }

                sleep(3);
            }
        } catch (\Exception $e) {
            myLog('hpjy_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]); // 改第四处
        }
    }
}
