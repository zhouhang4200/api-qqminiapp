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
            $title = $request->input('title');

            $filters = compact('category_id', 'title');

            $videos = Video::filter($filters)
                ->paginate(15);

            return response()->json([
                'status' => 0,
                'info' => '获取成功',
                'data' => $videos
            ]);
        } catch (\Exception $e) {
            myLog('video_error', ['info' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'info' => '服务器异常',
                'data' => false
            ]);
        }
    }

    /**
     * 相关推荐视频
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommend(Request $request)
    {
        try {
            $category_id = $request->input('category_id');
            $title = $request->input('title');

            $filters = compact('category_id', 'title');

            $videos = Video::filter($filters)
                ->offset(20)
                ->limit(15)
                ->get();

            return response()->json([
                'status' => 0,
                'info' => '获取成功',
                'data' => $videos
            ]);
        } catch (\Exception $e) {
            myLog('video_error', ['info' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'info' => '服务器异常',
                'data' => false
            ]);
        }
    }
}
