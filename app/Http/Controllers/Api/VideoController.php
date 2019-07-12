<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\QqException;
use App\Models\UserCategory;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $category_id = $request->input('category_id');
            $title = $request->input('title');
            $token = $request->input('token');

            $filters = compact('category_id', 'title', 'token');

            $videos = Video::filter($filters)
                ->with('category')
                ->paginate(20);

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
            $video_id = $request->input('video_id');
            $token = $request->input('token');
            $filters = compact('token');

            if (!$video_id) {
                throw new QqException('必选参数不可为空');
            }

            $videos = Video::filter([])
                ->with('category')
                ->where('videos.id', '>', $video_id)
                ->oldest('id')
                ->take(20)
                ->get();

            return response()->json([
                'status' => 0,
                'info' => '获取成功',
                'data' => $videos
            ]);
        } catch (QqException $e) {
            myLog('video_recommend_error', ['info' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'info' => $e->getMessage(),
                'data' => false
            ]);
        } catch (\Exception $e) {
            myLog('video_recommend_error', ['info' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'info' => '服务器异常',
                'data' => false
            ]);
        }
    }

    /**
     * 视频详情
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request)
    {
        try {
            $id = $request->input('video_id');

            if (!$id) {
                throw new QqException('参数video_id不可为空');
            }

            $video = Video::with('category')
                ->find($id);

            return response()->json([
                'status' => 0,
                'info' => '获取成功',
                'data' => $video
            ]);
        } catch (QqException $e) {
            myLog('video_detail_error', ['info' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'info' => $e->getMessage(),
                'data' => ''
            ]);
        } catch (\Exception $e) {
            myLog('video_detail_error', ['info' => '【'.$e->getLine().'】:'.$e->getMessage()]);

            return response()->json([
                'status' => 10000,
                'info' => '服务器异常',
                'data' => ''
            ]);
        }
    }
}
