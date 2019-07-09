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
                ->paginate(2);

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
