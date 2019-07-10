<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * 分类
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $filters = $request->all();

            $data = Category::filter($filters)->with('children')->where('pid', 0)->get();

            return response()->json(['status' => 0, 'data' => $data, 'info' => 'success']);
        } catch (\Exception $e) {
            myLog('category_error', ['data' => $e->getMessage()]);

            return response()->json(['status' => 10000, 'data' => '', 'info' => '服务器异常']);
        }
    }

    /**
     * 订阅
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request)
    {
        try {
            $categoryIds = explode(',', $request->input('category_id'));

            $user = Auth::guard('api')->user();

            $data = $user->categories()->sync($categoryIds);

            return response()->json(['status' => 0, 'data' => '', 'info' => '订阅成功']);
        } catch (\Exception $e) {
            myLog('category_error', ['data' => $e->getMessage()]);

            return response()->json(['status' => 10000, 'data' => '', 'info' => '服务器异常']);
        }
    }

    /**
     * 用户订阅数据
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();

            $data = $user->load('categories');

            return response()->json(['status' => 0, 'data' => $data, 'info' => 'success']);
        } catch (\Exception $e) {
            myLog('category_error', ['data' => $e->getMessage()]);

            return response()->json(['status' => 10000, 'data' => '', 'info' => '服务器异常']);
        }
    }
}
