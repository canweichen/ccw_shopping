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
    Route::get('/test/{id}','ShopLoginController@test');
    Route::post('/login','ShopLoginController@login');
    Route::post('/me','ShopLoginController@me')->middleware('jwt.auth');
    Route::post('/logout','ShopLoginController@logout')->middleware('jwt.auth');
    Route::post('/refresh','ShopLoginController@refresh')->middleware('jwt.auth');
});

Route::group(['prefix' => '/shop','middleware' => ['jwt.auth','check.rules']],function(){
    Route::group(['prefix' => 'admin'],function(){
        Route::get('show','AdminUserController@showAdminUserList');
        Route::get('detail/{adminUserId}','AdminUserController@showAdminUserDetail');
        Route::post('create','AdminUserController@createAdminUser');
        Route::put('edit/{adminUserId}','AdminUserController@editAdminUser');
        Route::delete('delete/{adminUserId}','AdminUserController@deleteAdminUser');
        Route::post('restore/{adminUserId}','AdminUserController@restoreAdminUser');
    });
    Route::group(['prefix' => 'permission'],function(){
        Route::get('show','ShopPermissionController@getShopPermissionList');
        Route::get('detail/{permissionId}','ShopPermission@getShopPermissionDetail');
        Route::post('create','ShopPermission@addShopPermission');
        Route::put('edit/{permissionId}','ShopPermission@updateShopPermission');
        Route::delete('delete/{permissionId}','ShopPermission@deleteShopPermission');
    });
    Route::group(['prefix' => 'role'],function(){
        Route::get('show','ShopRoleController@showShopRoleList');
        Route::get('detail/{roleId}','ShopRoleController@showShopRoleDetail');
        Route::post('create','ShopRoleController@createShopRole');
        Route::put('edit/{roleId}','ShopRoleController@editShopRole');
        Route::delete('delete/{roleId}','ShopRoleController@deleteShopRole');
    });
    Route::group(['prefix' => 'goods'],function(){
       Route::get('show','GoodsController@showGoodsList');
       Route::get('detail/{goodsId}','GoodsController@showGoodsDetail');
       Route::post('create','GoodsController@createGoods');
       Route::put('edit/{goodsId}','GoodsController@editGoods');
       Route::delete('delete/{goodsId}','GoodsController@deleteGoods');
    });
});
