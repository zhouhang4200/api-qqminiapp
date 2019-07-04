<?php

namespace App\Http\Controllers\Home;

use App\Models\Video;
use DiDom\Document;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Httpful\Request;
use Nesk\Puphpeteer\Puppeteer;
use QL\Ext\PhantomJs;
use QL\QueryList;

class SpiderController extends Controller
{
    public function spider()
    {
        Video::where('status', 0)->chunk(100, function ($chunks) {
            foreach ($chunks as $video) {
                try {
                    $puppeteer = new Puppeteer([
                        'debug' => true,
                        'stop_timeout' => 3,
                    ]);
                    $browser = $puppeteer->launch([
                        'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
                    ]);
                    dd($browser);
                } catch (\Exception $e) {
                    myLog('fun_url_spider_error', ["【" . $e->getLine() . "】" . $e->getMessage()]);
                    dd($e->getMessage());
                    continue;
                }
            }
        });
    }
}
