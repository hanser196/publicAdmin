<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//定义一个后台路由
Route::prefix('/admin')->namespace('Adm')->group(function(){
    /*登录路由资源管理器*/
    Route::resource('/login','LoginController');
    /*首页路由*/
    Route::get('/','AdmIndexController@index');
    Route::put('/index/info/pic','AdmIndexController@editpic');
    Route::put('/index/add/company','AdmIndexController@addCompany');
    Route::put('/index/edit/company','AdmIndexController@editCompany');
    Route::delete('/index/del/company','AdmIndexController@delCompany');
    /*用户路由*/
    Route::resource('/user','AdminUsersController');
    /*轮播图路由*/
    Route::resource('/loop','LoopController');
    /*Banner图路由*/
    Route::resource('/banner','BannerController');
    /*品牌背景路由*/
    Route::get('/brand','BrandController@index');
    /*新闻动态路由*/
    Route::resource('/news','NewsController');
    /*加盟专区路由*/
    Route::get('/join', 'JoinController@index');
    /*加盟动态路由*/
    Route::get('/dynamic', 'DynamicController@index');
    /*创业学院路由*/
    Route::get('/school', 'SchoolController@index');
    /*在线留言路由*/
    Route::get('/word', 'WordController@index');
});
//定义一个前台路由
Route::prefix('/')->namespace('Hom')->group(function(){
    Route::get('/','IndexController@index');
});
