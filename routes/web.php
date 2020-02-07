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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/pay','TestController@alipay');        //去支付
//Route::get('/test/alipay/return','Alipay\PayController@aliReturn');
//Route::post('/test/alipay/notify','Alipay\PayController@notify');
Route::get('/test/ascii','TestController@ascii');
Route::get('/test/dec','TestController@dec');
// 接口
Route::get('/api/test','Api\TestController@test');
Route::post('/api/user/reg','Api\TestController@reg');          //用户注册
Route::post('/api/user/login','Api\TestController@login');      //用户登录
Route::get('/api/user/list','Api\TestController@userList')->middleware('filter');      //用户列表

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//签名测试
Route::get('/sign1','TestController@sign1');
Route::get('/test/get/signonlie','Sign\IndexController@signOnline');
Route::post('/test/post/signonlie','Sign\IndexController@signOnline1');
Route::get('/test/get/sign1','Sign\IndexController@sign1');
Route::post('/test/post/sign2','Sign\IndexController@sign2');


