<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Video;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        // 获取所有的除了娱乐和游戏的分类
        $categories = Category::whereNotIn('id', [1, 2])->get();

        foreach ($categories as $category) {
//            $count = Video::where('category_id', $category->id)->where('date', $date)->count();

//            $latestVideo = Video::where('category_id', $category->id)
//                ->where('date', $date)
//                ->oldest('updated_at')
//                ->first();

//            $oldestTimestamp = Carbon::parse($latestVideo->updated_at)->addHours(4)->timestamp;
//            $nowTimestamp = Carbon::now()->timestamp;

//            if ($count > 300) {
//                continue;
//            }

            for ($i = 1; $i < 19; $i++) {
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
                        $insertData = [];
                        foreach ($json->uiData as $data) {
                            try {
                                $videoId      = $data->data[0]->id; // 视频id
                                $title        = $data->data[0]->title;
                                $play_count   = $data->data[0]->playCount;
                                $thumb        = $data->data[0]->posterPic;
                                $original_url = $data->data[0]->webPlayUrl;
                                $play_time    = $data->data[0]->duration;
                                // 去重
                                $video = Video::where('original_url', $original_url)
                                    ->first();

                                if ($video) {
                                    continue;
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
                                            $url          = $baseUrl . $videoExtension . '?vkey=' . $videoKey;
                                            $insertData[] = [
                                                'url'          => $url,
                                                'title'        => $title,
                                                'play_count'   => $play_count,
                                                'thumb'        => $thumb,
                                                'date'         => $date,
                                                'category_id'  => $category->id,
                                                'original_url' => $original_url,
                                                'play_time'    => $play_time,
                                                'source_id'    => 1, // 腾讯
                                                'source_name'  => '腾讯视频', // 腾讯
                                                'status'       => 1,
                                                'sort'         => mt_rand(100, 999999),
                                                'created_at'   => $time,
                                                'updated_at'   => $time,
                                            ];
                                        }
                                    } else {
                                        continue;
                                    }
                                } else {
                                    continue;
                                }
                            } catch (\Exception $e) {
                                myLog('qq_video_error', ['data' => $category->name . '【' . $e->getLine() . '】' . $e->getMessage()]);
                                continue;
                            }
                        }
                        // 写入数据库
                        if ($insertData && count($insertData) > 0) {
                            DB::table('videos')->insert($insertData);
                        }
                    } else {
                        myLog('qq_video_error', ['data' => $category->name . '无列表数据']);
                    }
                } catch (\Exception $e) {
                    myLog('qq_video_error', ['data' => $category->name . '【' . $e->getLine() . '】' . $e->getMessage()]);
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
