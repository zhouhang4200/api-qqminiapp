<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

// 回调接口
Route::prefix('video')->group(function () {
    Route::get('/', 'VideoController@index'); // 视频
    Route::get('search', 'VideoController@search'); // 查找
    Route::get('recommend', 'VideoController@recommend'); // 查找
});

Route::prefix('category')->group(function () {
    Route::get('/', 'CategoryController@index'); // 视频
    Route::post('subscribe', 'CategoryController@subscribe'); // 订阅
    Route::get('user', 'CategoryController@user'); // 订阅的数据
});

Route::post('login', 'LoginController@login')->name('login');
