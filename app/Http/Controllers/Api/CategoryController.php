<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
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
            $data = Category::get();

            return response()->json(['code' => 0, 'data' => $data, 'message' => 'success']);
        } catch (\Exception $e) {
            myLog('category_error', ['data' => $e->getMessage()]);

            return response()->json(['code' => 10000, 'data' => '', 'message' => '服务器异常']);
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
            $categoryIds = $request->input('category_id');

            $user = Auth::guard('api')->user();

            $data = $user->categories()->attach($categoryIds);

            return response()->json(['code' => 0, 'data' => $user, 'message' => 'success']);
        } catch (\Exception $e) {
            myLog('category_error', ['data' => $e->getMessage()]);

            return response()->json(['code' => 10000, 'data' => '', 'message' => '服务器异常']);
        }
    }
}
