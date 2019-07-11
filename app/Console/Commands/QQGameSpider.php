<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use DiDom\Document;
use GuzzleHttp\Client;
use Httpful\Request;
use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;

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
     * 获取列表视频id，然后带入info接口查找具体信息写入数据库
     *
     * @param $category_id
     * @param $pageContext
     * @param $refreshContext
     * @param $date
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList($category_id, $pageContext, $refreshContext, $date)
    {
        $count = Video::where('category_id', $category_id)
            ->where('original_url', '')
            ->where('date', $date)
            ->count();

        if ($count > 200) {
            return false;
        }

        if ($category_id == 1) { // 游戏
            $url = 'https://m.v.qq.com/x/channel/video/game?pagelet=1&pageContext=' . $pageContext . '&refreshContext=' . $refreshContext . '&request=hot_videoline';
        } elseif ($category_id == 2) { // 娱乐
            $url = 'https://m.v.qq.com/x/channel/video/recreation?pagelet=1&pageContext=' . $pageContext . '&refreshContext=' . $refreshContext . '&request=hot_videoline';
        } else {
            return false;
        }

        // 获取列表页面
        $client       = new Client();
        $infoResponse = $client->request('GET', $url);
        $infoContent  = $infoResponse->getBody()->getContents();

        // 视频图片和视频id
        preg_match_all('~class=\\\"poster\\\" dsrc=\\\"(.*?)\\\"~', $infoContent, $thumbs);
        preg_match_all('~data-vid=\\\"(.*?)\\\"\>~', $infoContent, $video_ids);

        if ($thumbs && count($thumbs) > 0) {
            foreach ($thumbs[1] as $k => $thumb) {
                $timestamp = Carbon::now()->timestamp;
                $video_id  = $video_ids[1][$k];
                try {
                    $video         = new Video();
                    $infoUrl       = "https://h5vv.video.qq.com/getinfo?callback=txplayerJsonpCallBack_getinfo_934380&&charge=0&defaultfmt=auto&otype=json&guid=a96d6368975b40fd9fc8a7eb5d3a45e4&flowid=e8af7e3800936921036d09289f74f5ae_11001&platform=11001&sdtfrom=v3010&defnpayver=0&appVer=3.4.40&host=m.v.qq.com&ehost=https%3A%2F%2Fm.v.qq.com%2Fx%2Fchannel%2Fvideo%2Frecreation&refer=m.v.qq.com&sphttps=1&sphls=&_rnd=" . $timestamp . "&spwm=4&vid=" . $video_id . "&defn=auto&fhdswitch=&show1080p=false&dtype=1&clip=4&defnsrc=&fmt=auto&defsrc=1&_qv_rmt=C103p%2BIKA16110pdw%3D&_qv_rmt2=jw5bfArY152401F2g%3D&_1562141001953=";
                    $client        = new Client();
                    $infoResponse  = $client->request('GET', $infoUrl);
                    $detailContent = $infoResponse->getBody()->getContents();
                    $infoJson      = $this->jsonpDecode($detailContent, false);
                    // 第三步：拿到视频地址，写入数据库
                    if (isset($infoJson) && isset($infoJson->vl) && isset($infoJson->vl->vi) && count($infoJson->vl->vi) > 0) {
                        $videoInfo      = $infoJson->vl->vi[0];
                        $videoExtension = $videoInfo->fn;
                        $videoKey       = $videoInfo->fvkey;
                        $baseUrl      = $videoInfo->ul->ui[0]->url;
                        $time         = Carbon::now()->toDateTimeString();
                        $title        = $videoInfo->ti;
                        $play_count   = '0';
                        $original_url = '';
                        $play_time    = $infoJson->preview;

                        if ($videoExtension && $videoKey) {
                            $url = $baseUrl . $videoExtension . '?vkey=' . $videoKey;
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
                            myLog('qq_game_error', ['data' => '【' . $category_id . '】找不到播放地址']);
                        }
                        sleep(1);
                    }
                } catch (\Exception $e) {
                    myLog('qq_game_error', ['data' => $e->getLine().'行:'.$e->getMessage()]);
                    continue;
                }
            }
        } else {
            myLog('qq_game_error', ['data' => '图片和视频id没找到']);
        }

        // 两个类目的列表页的正则不一样
        if ($category_id == 2) {
//            preg_match_all('~\<div class=\"hide\"\>responsedata=\/\*\{&quot\;channelTag&quot\;\:\&quot\;recreation\&quot\;\,\&quot\;pageContext\&quot\;\:&quot\;(.*?)&quot;,&quot;refreshContext&quot;:&quot;(.*?)&quot\;\,\&quot\;hasNextPage&quot\;\:true\}\*\/\<\/div\>~', $infoContent, $matches);
            preg_match_all('~\<div class=\\\"hide\\\"\>responsedata=\/\*\{&quot\;channelTag&quot\;\:\&quot\;recreation\&quot\;\,\&quot\;pageContext\&quot\;\:&quot\;(.*?)&quot;,&quot;refreshContext&quot;:&quot;(.*?)&quot\;\,\&quot\;hasNextPage&quot\;\:true\}\*\/\<\/div\>~', $infoContent, $matches);
        } elseif ($category_id == 1) {
//                    preg_match_all('~\<div class=\"hide\"\>responsedata=\/\*\{\&quot\;channelTag&quot\;\:\&quot\;recreation\&quot\;\,\&quot\;pageContext\&quot\;\:&quot\;(.*?)\&quot\;\,\&quot\;refreshContext\&quot\;\:\&quot\;(.*?)&quot\;\,&quot\;hasNextPage&quot\;\:true\}\*\/\<\/div\>~', $html, $matches);
            preg_match_all('~\<div class=\"hide\"\>responsedata=\/\*\{&quot;channelTag&quot;:&quot;game&quot;,&quot;pageContext&quot;:&quot;(.*?)&quot;,&quot;refreshContext&quot;:&quot;(.*?)&quot;,&quot;hasNextPage&quot;:true\}\*\/\<\/div\>~', $infoContent, $matches);
        } else {
            $matches = [];
        }

        if ($matches && count($matches) > 0 && count($matches[1]) > 0) {
            $pageContext    = $matches[1][0];
            $refreshContext = $matches[2][0];
            $this->getList($category_id, $pageContext, $refreshContext, $date);
        } else {
            myLog('qq_game_error', ['data' => '刷新列表的参数未找到']);
        }

        return true;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $date     = Carbon::now()->toDateString();
        $baseUrls = [
            '1' => 'https://m.v.qq.com/x/channel/video/game',  // 游戏
            '2' => 'https://m.v.qq.com/x/channel/video/recreation', // 娱乐
        ];

        foreach ($baseUrls as $category_id => $baseUrl) {
            try {
                // 第一次爬原始页面，找数据
//                $puppeteer = new Puppeteer([
////                'debug'        => true,
//                    'stop_timeout' => 10,
//                    'read_timeout' => 60,
//                    'idle_timeout' => 60,
//                    'timeout' => 60
//                ]);
//
//                $browser = $puppeteer->launch([
//                    'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
//                ]);
//
//                $page = $browser->newPage();
//                $page->setExtraHTTPHeaders([
//                    "Origin" => "https://m.v.qq.com",
//                    "Referer" => $baseUrl,
//                    "User-Agent" => "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1",
//                ]);
//
//                $page->goto($baseUrl, ['timeout' => 60000]);
//                $html = $page->content(); // Prints the HTML
                // 游戏地址可能会出错
                $response = Request::get($baseUrl)
                    ->addHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36')
                    ->timeout(5)
                    ->send();

                $html = $response->body;

                if ($category_id == 2) { // 娱乐
                    preg_match_all('~\<div class=\"hide\"\>responsedata=\/\*\{&quot\;channelTag&quot\;\:\&quot\;recreation\&quot\;\,\&quot\;pageContext\&quot\;\:&quot\;(.*?)&quot;,&quot;refreshContext&quot;:&quot;(.*?)&quot\;\,\&quot\;hasNextPage&quot\;\:true\}\*\/\<\/div\>~', $html, $matches);
                } elseif ($category_id == 1) { // 游戏
                    preg_match_all('~\<div class=\"hide\"\>responsedata=\/\*\{&quot;channelTag&quot;:&quot;game&quot;,&quot;pageContext&quot;:&quot;(.*?)&quot;,&quot;refreshContext&quot;:&quot;(.*?)&quot;,&quot;hasNextPage&quot;:true\}\*\/\<\/div\>~', $html, $matches);
                } else {
                    continue;
                }

                if ($matches && count($matches) > 0 && count($matches[1]) > 0) {
                    $pageContext    = $matches[1][0];
                    $refreshContext = $matches[2][0];
                    // 如果其中一个分类条数大于200，则返回false，这边跳出循环，循环下一个分类
                    $result = $this->getList($category_id, $pageContext, $refreshContext, $date);

                    if (!$result) {
                        continue;
                    }
                }
            } catch (\Exception $e) {
                myLog('qq_game_error', ['data' => $e->getLine() .'行：'. $e->getMessage()]);
                continue;
            }


//            for ($i =1; $i <= 30; $i++) {
//                try {
//            $timestamp = Carbon::now()->timestamp;
//                    // 第五人格
//                    $response = Request::get($baseUrl)
//                        ->addHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36')
//                        ->timeout(5)
//                        ->send();
//
//                    $html = $response->body;
//
//                    $document  = new Document();
//                    $doc       = $document->load($html);
//                    $documents = $doc->find('.feeds_video'); // 数组
//                    echo $i;
//                    if ($document && count($documents) > 0) {
//                        foreach ($documents as $document) {
//                            try {
//                                $timestamp = Carbon::now()->subHours(1)->timestamp;
//                                $thumb = $document->first('img')->getAttribute('dsrc');
//                                $video_id = $document->getAttribute('data-vid');
//                                $video = new Video();
//                                $infoUrl      = "https://h5vv.video.qq.com/getinfo?callback=txplayerJsonpCallBack_getinfo_934380&&charge=0&defaultfmt=auto&otype=json&guid=a96d6368975b40fd9fc8a7eb5d3a45e4&flowid=e8af7e3800936921036d09289f74f5ae_11001&platform=11001&sdtfrom=v3010&defnpayver=0&appVer=3.4.40&host=m.v.qq.com&ehost=https%3A%2F%2Fm.v.qq.com%2Fx%2Fchannel%2Fvideo%2Frecreation&refer=m.v.qq.com&sphttps=1&sphls=&_rnd=" . $timestamp . "&spwm=4&vid=" . $video_id . "&defn=auto&fhdswitch=&show1080p=false&dtype=1&clip=4&defnsrc=&fmt=auto&defsrc=1&_qv_rmt=C103p%2BIKA16110pdw%3D&_qv_rmt2=jw5bfArY152401F2g%3D&_1562141001953=";
//                                $client    = new Client();
//                                $infoResponse = $client->request('GET', $infoUrl);
//                                $infoContent  = $infoResponse->getBody()->getContents();
//                                $infoJson     = $this->jsonpDecode($infoContent, false);
////                                dd($infoJson->vl);
//                                // 第三步：拿到视频地址，写入数据库
//                                if (isset($infoJson) && isset($infoJson->vl) && isset($infoJson->vl->vi) && count($infoJson->vl->vi) > 0) {
//                                    $videoInfo      = $infoJson->vl->vi[0];
//                                    $videoExtension = $videoInfo->fn;
//                                    $videoKey       = $videoInfo->fvkey;
////                                    dd($infoJson);
//                                    $baseUrl = $videoInfo->ul->ui[0]->url;
//                                    $time    = Carbon::now()->toDateTimeString();
//                                    $title = $videoInfo->ti;
//                                    $play_count = '0';
//                                    $original_url = '';
//                                    $play_time = $infoJson->preview;
//
//                                    if ($videoExtension && $videoKey) {
//                                        $url = $baseUrl . $videoExtension . '?vkey=' . $videoKey;
////                                        dd($url);
//                                        $video->url          = $url;
//                                        $video->title        = $title;
//                                        $video->play_count   = $play_count;
//                                        $video->thumb        = $thumb;
//                                        $video->date         = $date;
//                                        $video->category_id  = $category_id;
//                                        $video->original_url = $original_url;
//                                        $video->play_time    = $play_time;
//                                        $video->source_id    = 1; // 腾讯
//                                        $video->status       = 1;
//                                        $video->created_at   = $time;
//                                        $video->updated_at   = $time;
//                                        $video->save();
//                                    } else {
//                                        myLog('qq_video', ['data' => '【' . $category_id . '】找不到播放地址']);
//                                        sleep(1);
//                                    }
//                                }
//                            } catch (\Exception $e) {
//                                myLog('qq_game_error', ['date' => $e->getLine().'找不到列表地址标签'.$e->getMessage()]);
//                            }
//                        }
//                    }
//                    sleep(3);
//                } catch (\Exception $e) {
//                    myLog('qq_game_error', ['date' => $e->getLine().'列表页错误'.$e->getMessage()]);
//                }
//            }
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
