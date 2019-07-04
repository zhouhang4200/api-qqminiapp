<?php

namespace App\Http\Controllers\Api;

use DiDom\Document;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpiderController extends Controller
{
    public function spider()
    {
        try {
            $client = new Client(['cookies' => true]);

            $response = $client->get(config('spider.url.fun'));

            $html = $response->getBody()->getContents();
dd($html);
            $document = new Document();
            $doc = $document->load($html);
            $input = $doc->find("ul class[name='_token']")[0];
            $csrfToken = $input->getAttribute("value");
            //dd($csrfToken);
            $request = $client->request('POST', $this->url, [
                'form_params' => [
                    'username' => 'zhouhang8878@163.com',
                    'password' => 'admin888',
                    'remember' => 'yes',
                    '_token' => $csrfToken,
                ],
            ]);
            //        dd($request);
            echo $request->getBody();
        } catch (\Exception $e) {

        }
    }
}
