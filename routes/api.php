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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//修改当前首页信息(公司地址及电话)
Route::POST('/edit/company', 'Adm\AjaxController@company');
//查看当前新闻文章
Route::POST('/shownews', 'Adm\AjaxController@news');
//查看当前轮播图
Route::POST('/showloop', 'Adm\AjaxController@loop');
//查看当前banner图
Route::POST('/showbanner', 'Adm\AjaxController@banner');
