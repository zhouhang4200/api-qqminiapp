<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Video;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class QQVideoSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qq:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '腾讯视频二级分类爬虫';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $date = Carbon::now()->toDateString();
        // 获取所有的除了游戏的分类
        $categories = Category::whereNotIn('id', [1, 2])->get();

        foreach ($categories as $category) {
            $count = Video::where('category_id', $category->id)->where('date', $date)->count();

            if ($count > 200) {
                continue;
            }

            for ($i = 1; $i < 20; $i++) {
                $timestamp   = Carbon::now()->timestamp;
                $rand_number = mt_rand(100, 999);
                $page        = 15 * $i;
                try {
                    // 第一步：获取视频id
                    $searchUrl = "https://node.video.qq.com/x/api/msearch?contextValue=last_end%3D" . $page . "%26sort%3D1%26%26response%3D1&filterValue=pubfilter%3D4&searchSession=qid%3DpK7qYBiMDvhLjL1kGhWIPdbyVshRXm_pptL9YqboWWlIososhSJj1A&keyWord=" . $category->name . "&contextType=3&_=" . $timestamp . $rand_number . "&callback=jsonp3";
                    $client    = new Client();
                    $response  = $client->request('GET', $searchUrl);
                    $content   = $response->getBody()->getContents();
                    $json      = $this->jsonpDecode($content);

                    if ($json->errCode == 0 && isset($json->uiData) && count($json->uiData) > 10) {
                        foreach ($json->uiData as $data) {
                            $videoId      = $data->data[0]->id; // 视频id
                            $title        = $data->data[0]->title;
                            $play_count   = $data->data[0]->playCount;
                            $thumb        = $data->data[0]->posterPic;
                            $original_url = $data->data[0]->webPlayUrl;
                            $play_time    = $data->data[0]->duration;
                            // 去重
                            if (!$video = Video::where('original_url', $original_url)->first()) {
                                $video = new Video();
                            }

                            if ($thumb && $title && $videoId) {
                                // 第二步：拿到视频id，获取视频信息
                                $infoUrl      = "https://h5vv.video.qq.com/getinfo?callback=txplayerJsonpCallBack_getinfo_934380&&charge=0&defaultfmt=auto&otype=json&guid=a96d6368975b40fd9fc8a7eb5d3a45e4&flowid=e8af7e3800936921036d09289f74f5ae_11001&platform=11001&sdtfrom=v3010&defnpayver=0&appVer=3.4.40&host=m.v.qq.com&ehost=https%3A%2F%2Fm.v.qq.com%2Fx%2Fchannel%2Fvideo%2Frecreation&refer=m.v.qq.com&sphttps=1&sphls=&_rnd=" . $timestamp . "&spwm=4&vid=" . $videoId . "&defn=auto&fhdswitch=&show1080p=false&dtype=1&clip=4&defnsrc=&fmt=auto&defsrc=1&_qv_rmt=C103p%2BIKA16110pdw%3D&_qv_rmt2=jw5bfArY152401F2g%3D&_1562141001953=";
                                $infoResponse = $client->request('GET', $infoUrl);
                                $infoContent  = $infoResponse->getBody()->getContents();
                                $infoJson     = $this->jsonpDecode($infoContent, false);

                                // 第三步：拿到视频地址，写入数据库
                                if (isset($infoJson) && isset($infoJson->vl) && isset($infoJson->vl->vi) && count($infoJson->vl->vi) > 0) {
                                    $videoInfo      = $infoJson->vl->vi[0];
                                    $videoExtension = $videoInfo->fn;
                                    $videoKey       = $videoInfo->fvkey;
                                    $baseUrl        = $videoInfo->ul->ui[0]->url;
                                    $time           = Carbon::now()->toDateTimeString();

                                    if ($videoExtension && $videoKey) {
                                        $url                 = $baseUrl . $videoExtension . '?vkey=' . $videoKey;
                                        $video->url          = $url;
                                        $video->title        = $title;
                                        $video->play_count   = $play_count;
                                        $video->thumb        = $thumb;
                                        $video->date         = $date;
                                        $video->category_id  = $category->id;
                                        $video->original_url = $original_url;
                                        $video->play_time    = $play_time;
                                        $video->source_id    = 1; // 腾讯
                                        $video->source_name  = '腾讯视频'; // 腾讯
                                        $video->status       = 1;
                                        $video->created_at   = $time;
                                        $video->updated_at   = $time;
                                        $video->save();
                                    } else {
                                        myLog('qq_video', ['data' => '【' . $category->id . $category->name . '】找不到url地址']);

                                        sleep(1);

                                        continue;
                                    }
                                }
                            } else {
                                myLog('qq_video', ['data' => '【' . $category->id . $category->name . '】找不到视频id']);

                                sleep(1);

                                continue;
                            }

                            sleep(2);
                        }
                    } else {
                        myLog('qq_video', ['data' => '【' . $category->id . $category->name . '】获取列表失败']);

                        sleep(1);

                        continue;
                    }
                } catch (\Exception $e) {
                    myLog('qq_video', ['data' => $category->name . '【' . $e->getLine() . '】' . $e->getMessage()]);

                    sleep(1);

                    continue;
                }
            }
        }
    }

    /**
     * jsonp 转 json
     *
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
