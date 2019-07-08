<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\QqException;
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

            $user = Auth::guard('api')->user();

            $client = new Client();

            $response = $client->request('GET', "https://api.weixin.qq.com/sns/jscode2session?appid=".config('pay.wechat.miniapp_id')."&secret=".config('pay.wechat.app_secret')."&js_code=".request('code')."&grant_type=authorization_code");
            $result =  $response->getBody()->getContents();
            $result = json_decode($result, true);

            if (is_array($result) && isset($result['openid'])) {
                $openId = $result['openid'];
                $sessionKey = $result['session_key'];
                $user->wechat_open_id = $openId;
                $user->save();

                $data['openid'] = $openId;

                return response()->json(['code' => 0, 'data' => $data, 'message' => 'success']);
            } elseif (is_array($result) && isset($result['errcode'])) {
                return response()->json(['code' => 10000, 'message' => $result['errmsg']]);
            }
        } catch (QqException $e) {
            myLog('qq-code-error', ['失败原因：' => $e->getMessage()]);
            return response()->json(['code' => 10000, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            myLog('qq-code-error', ['失败原因：' => $e->getMessage()]);
            return response()->json(['code' => 10000, 'message' => '服务器异常']);
        }
    }
}
