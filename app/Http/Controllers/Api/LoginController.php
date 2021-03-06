<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\QqException;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    /**
     * 获取qq的openid
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function code(Request $request)
    {
        try {
            // 参数缺失
            if (is_null( request('code'))) {
                throw new QqException('code参数缺失');
            }

            $user = User::find(1);
//            $token = $user->createToken('qq_mini_app_jrhk')->accessToken;
                $token = $user->token;
//            $data['openid'] = $user->openid;
//            $data['token'] = $token;

            Cache::rememberForever($token, function () use ($token) {
                return User::where('token', $token)->first();
            });

            return response()->json(['status' => 0, 'data' => $token, 'info' => 'success']);

            $appId = config('spider.qq_mini_app.appid');
            $secret = config('spider.qq_mini_app.secret');

            $client = new Client();

            $response = $client->request('GET', "https://api.q.qq.com/sns/jscode2session?appid=$appId&secret=$secret&js_code=JSCODE&grant_type=authorization_code");
            $result =  $response->getBody()->getContents();
            $result = json_decode($result, true);

            if (is_array($result) && isset($result['openid'])) {
                $openId = $result['openid'];
                $sessionKey = $result['session_key'];

                $user = User::where('open_id', $openId)->first();

                if (!$user) {
                    $user = User::create([
                        'name' => '',
                        'token' => md5($openId),
                        'password' => '',
                        'phone' => '',
                        'openid' => $openId,
                        'qq' => '',
                        'nickname' => '',
                        'unionid' => '',
                    ]);
                }

                $token = $user->createToken('qq_mini_app_jrhk')->accessToken;

//                $data['openid'] = $openId;

                return response()->json(['status' => 0, 'data' => $token, 'info' => 'success']);
            } elseif (is_array($result) && isset($result['errcode'])) {
                return response()->json(['status' => 10000, 'info' => $result['errmsg']]);
            }
        } catch (QqException $e) {
            myLog('qq-code-error', ['失败原因：' => $e->getMessage()]);
            return response()->json(['status' => 10000, 'info' => $e->getMessage()]);
        } catch (\Exception $e) {
            myLog('qq-code-error', ['失败原因：' => $e->getMessage()]);
            return response()->json(['status' => 10000, 'info' => '服务器异常']);
        }
    }
}
