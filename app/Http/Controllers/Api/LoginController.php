<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\QqException;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

            $user = Auth::guard('api')->user() ?? '';
            $appId = config('spider.qq_mini_app.appid');
            $secret = config('spider.qq_mini_app.secret');

            $client = new Client();

            $response = $client->request('GET', "https://api.q.qq.com/sns/jscode2session?appid=$appId&secret=$secret&js_code=JSCODE&grant_type=authorization_code");
            $result =  $response->getBody()->getContents();
            $result = json_decode($result, true);

            if (is_array($result) && isset($result['openid'])) {
                $openId = $result['openid'];
                $sessionKey = $result['session_key'];

                if ($user) {
                    $user->wechat_open_id = $openId;
                    $user->save();
                } else {
                    $user = User::create([
                        'name' => '',
                        'email' => '',
                        'password' => '',
                        'phone' => '',
                        'openid' => $openId,
                        'qq' => '',
                        'nickname' => '',
                        'unionid' => '',
                    ]);
                }

                $token = $user->createToken('qq_mini_app_jrhk')->accessToken;

                $data['openid'] = $openId;

                return response()->json(['status' => 0, 'data' => ['openid' => $openId, 'token' => $token], 'info' => 'success']);
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
