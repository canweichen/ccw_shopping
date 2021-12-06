<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:api')->get('/shop', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/auth'],function(){
    Route::get('show','GoodsController@showGoodsList');
});

Route::group(['prefix' => '/shop','middleware' => []],function(){
    Route::group(['prefix' => 'admin'],function(){
        Route::get('show','AdminUserController@showAdminUserList');
        Route::get('detail/{adminUserId}','AdminUserController@showAdminUserDetail');
        Route::post('create','AdminUserController@createAdminUser');
        Route::put('edit/{adminUserId}','AdminUserController@editAdminUser');
        Route::get('delete/{adminUserId}','AdminUserController@deleteAdminUser');
        Route::get('restore/{adminUserId}','AdminUserController@restoreAdminUser');
    });
    Route::group(['prefix' => 'goods'],function(){
       Route::get('show','GoodsController@showGoodsList');
       Route::get('detail/{goodsId}','GoodsController@showGoodsDetail');
       Route::post('create','GoodsController@createGoods');
       Route::put('edit/{goodsId}','GoodsController@editGoods');
       Route::delete('delete/{goodsId}','GoodsController@deleteGoods');
    });
});
