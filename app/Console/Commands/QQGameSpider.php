<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use DiDom\Document;
use GuzzleHttp\Client;
use Httpful\Request;
use Illuminate\Console\Command;

class QQGameSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qq:game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取游戏和娱乐首页地址';

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
        $date = Carbon::now()->toDateString();
        $baseUrls = [
            '4' => 'https://m.v.qq.com/x/channel/video/recreation',
            '1' => 'https://m.v.qq.com/x/channel/video/game'
        ];

        foreach ($baseUrls as $category_id => $baseUrl) {































            for ($i =1; $i <= 30; $i++) {
                try {
                    // 第五人格
                    $response = Request::get($baseUrl)
                        ->addHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36')
                        ->timeout(5)
                        ->send();

                    $html = $response->body;

                    $document  = new Document();
                    $doc       = $document->load($html);
                    $documents = $doc->find('.feeds_video'); // 数组
                    echo $i;
                    if ($document && count($documents) > 0) {
                        foreach ($documents as $document) {
                            try {
                                $timestamp = Carbon::now()->subHours(1)->timestamp;
                                $thumb = $document->first('img')->getAttribute('dsrc');
                                $video_id = $document->getAttribute('data-vid');
                                $video = new Video();
                                $infoUrl      = "https://h5vv.video.qq.com/getinfo?callback=txplayerJsonpCallBack_getinfo_934380&&charge=0&defaultfmt=auto&otype=json&guid=a96d6368975b40fd9fc8a7eb5d3a45e4&flowid=e8af7e3800936921036d09289f74f5ae_11001&platform=11001&sdtfrom=v3010&defnpayver=0&appVer=3.4.40&host=m.v.qq.com&ehost=https%3A%2F%2Fm.v.qq.com%2Fx%2Fchannel%2Fvideo%2Frecreation&refer=m.v.qq.com&sphttps=1&sphls=&_rnd=" . $timestamp . "&spwm=4&vid=" . $video_id . "&defn=auto&fhdswitch=&show1080p=false&dtype=1&clip=4&defnsrc=&fmt=auto&defsrc=1&_qv_rmt=C103p%2BIKA16110pdw%3D&_qv_rmt2=jw5bfArY152401F2g%3D&_1562141001953=";
                                $client    = new Client();
                                $infoResponse = $client->request('GET', $infoUrl);
                                $infoContent  = $infoResponse->getBody()->getContents();
                                $infoJson     = $this->jsonpDecode($infoContent, false);
//                                dd($infoJson->vl);
                                // 第三步：拿到视频地址，写入数据库
                                if (isset($infoJson) && isset($infoJson->vl) && isset($infoJson->vl->vi) && count($infoJson->vl->vi) > 0) {
                                    $videoInfo      = $infoJson->vl->vi[0];
                                    $videoExtension = $videoInfo->fn;
                                    $videoKey       = $videoInfo->fvkey;
//                                    dd($infoJson);
                                    $baseUrl = $videoInfo->ul->ui[0]->url;
                                    $time    = Carbon::now()->toDateTimeString();
                                    $title = $videoInfo->ti;
                                    $play_count = '0';
                                    $original_url = '';
                                    $play_time = $infoJson->preview;

                                    if ($videoExtension && $videoKey) {
                                        $url = $baseUrl . $videoExtension . '?vkey=' . $videoKey;
//                                        dd($url);
                                        $video->url          = $url;
                                        $video->title        = $title;
                                        $video->play_count   = $play_count;
                                        $video->thumb        = $thumb;
                                        $video->date         = $date;
                                        $video->category_id  = $category_id;
                                        $video->original_url = $original_url;
                                        $video->play_time    = $play_time;
                                        $video->source_id    = 1; // 腾讯
                                        $video->status       = 1;
                                        $video->created_at   = $time;
                                        $video->updated_at   = $time;
                                        $video->save();
                                    } else {
                                        myLog('qq_video', ['data' => '【' . $category_id . '】找不到播放地址']);
                                        sleep(1);
                                    }
                                }
                            } catch (\Exception $e) {
                                myLog('qq_game_error', ['date' => $e->getLine().'找不到列表地址标签'.$e->getMessage()]);
                            }
                        }
                    }
                    sleep(3);
                } catch (\Exception $e) {
                    myLog('qq_game_error', ['date' => $e->getLine().'列表页错误'.$e->getMessage()]);
                }
            }
        }
    }

    /**
     * @param $jsonp
     * @param bool $assoc
     * @return mixed
     */
    public function jsonpDecode($jsonp, $assoc = false)
    {
        $jsonp = trim($jsonp);
        if (isset($jsonp[0]) && $jsonp[0] !== '[' && $jsonp[0] !== '{') {
            $begin = strpos($jsonp, '(');
            if (false !== $begin) {
                $end = strrpos($jsonp, ')');
                if (false !== $end) {
                    $jsonp = substr($jsonp, $begin + 1, $end - $begin - 1);
                }
            }
        }
        return json_decode($jsonp, $assoc);
    }
}
