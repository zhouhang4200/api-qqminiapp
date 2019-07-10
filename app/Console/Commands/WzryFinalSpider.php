<?php

namespace App\Console\Commands;

use App\Models\Video;
use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Console\Command;
use Nesk\Puphpeteer\Puppeteer;

class WzryFinalSpider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wzry_final:spider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '王者荣耀最终爬虫';

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
            $proxy = 's1.proxy.mayidaili.com:8123';

            $puppeteer = new Puppeteer([
//                'debug'        => true,
                'stop_timeout' => 10,
                'read_timeout' => 60,
                'idle_timeout' => 60,
                'timeout' => 60
            ]);

            $browser = $puppeteer->launch([
                'ignoreHTTPSErrors' => true,
                'args'              => ['--no-sandbox', '--disable-setuid-sandbox', '--proxy-server=' . $proxy],
            ]);

            // 获取数据库里面状态为0的所有的原始地址
            Video::where('status', 0)
                ->where('date', Carbon::now()->toDateString())
                ->where('category_id', config('spider.category.wzry')) // 改第一处
                ->chunk(100, function ($chunks) use ($url, $browser, $puppeteer, $proxy) {
                    foreach ($chunks as $video) {
                        try {
//                            $browser   = $puppeteer->launch([
//                                'ignoreHTTPSErrors' => true,
//                                'args'              => ['--no-sandbox', '--disable-setuid-sandbox', '--proxy-server=' . $proxy],
//                            ]);

                            $auth = $this->sign();
                            $page = $browser->newPage();
                            $page->setExtraHTTPHeaders([
                                "Mayi-Authorization" => " {$auth}",
                            ]);

                            $page = $browser->newPage();

                            $page->goto($video->original_url, ['timeout' => 60000]);
                            $html = $page->content(); // Prints the HTML

                            $document = new Document();
                            $doc      = $document->load($html);
                            $urlDoc   = $doc->first('video');
                            $playCount = $doc->first(".playerContainer .view_counts");

                            if ($urlDoc) {
                                $url = $urlDoc->getAttribute('src');
                            } else {
                                myLog('wzry_final_spider_error', ['src不存在！']); // 改第二处
//                                $video->delete();
                                continue;
                            }

                            // 写入数据库
                            if ($url) {
                                $video->status = 1;
                                $video->play_count = $playCount->text() ?? '0';
                                $video->date = Carbon::now()->toDateString();
                                $video->url    = $url;
                                $video->save();
                            } else {
//                                $video->delete();
                                continue;
                            }
                            sleep(mt_rand(4, 9));
                        } catch (\Exception $e) {
//                            $video->delete();
                            myLog('wzry_final_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]); // 改第三处
                            continue;
                        }
                    }
                });
            $browser->close();
        } catch (\Exception $e) {
            myLog('wzry_final_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]); // 改第三处

        }

    }

    /**
     * 获取 sign
     *
     * @return string
     */
    public function sign()
    {
        //AppKey 信息，请替换
        $appKey = '70357409';
        //AppSecret 信息，请替换
        $secret = 'e7e5b19b8858f8278a01e953b4f77632';
        //示例请求参数
        $paramMap = array(
            'app_key'   => $appKey,
            'timestamp' => date('Y-m-d H:i:s')
        );
        //按照参数名排序
        ksort($paramMap);
        //连接待加密的字符串
        $codes = $secret;

        //请求的URL参数
        $auth = 'MYH-AUTH-MD5 ';
        foreach ($paramMap as $key => $val) {
            $codes .= $key . $val;
            $auth  .= $key . '=' . $val . '&';
        }
        $codes .= $secret;
        //签名计算
        $auth .= 'sign=' . strtoupper(md5($codes));

        return $auth;
    }
}
