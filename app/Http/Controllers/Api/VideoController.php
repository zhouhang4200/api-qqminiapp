<?php

namespace App\Http\Controllers\Api;

use App\Models\UserCategory;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $category_id = $request->input('category_id');

            $filters = compact('category_id');

            $videos = Video::filter($filters)
                ->paginate(15);

            return response()->json([
                'status' => 0,
                'message' => '获取成功',
                'data' => $videos
            ]);
        } catch (\Exception $e) {
            myLog('video_error', ['message' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'message' => '服务器异常',
                'data' => false
            ]);
        }
    }

    public function subscribe(Request $request)
    {
        try {
            $category_id = $request->input('category_id');
            $openid = $request->input('openid');

            UserCategory::updateOrCreated([
                'openid' => $openid
            ], [
                'openid' => $openid
            ]);

            return response()->json([
                'status' => 0,
                'message' => '获取成功',
                'data' => $videos
            ]);
        } catch (\Exception $e) {
            myLog('video_error', ['message' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'message' => '服务器异常',
                'data' => false
            ]);
        }
    }
}
