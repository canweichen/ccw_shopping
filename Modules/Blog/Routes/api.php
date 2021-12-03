<?php

use Illuminate\Http\Request;
use Modules\Blog\Http\Models\Article;
use App\Models\Users;

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

Route::middleware('auth:api')->get('/blog', function (Request $request) {
    return $request->user();
});
Route::get('/blog/id/{id}', function (Request $request,$id) {
    return ['artic_id' => $id,'artic_name' => 'BBC','artic_date' => '2021-10-22'];
});
//路由绑定模型 路由通过数据库查询将id转化成相应的模型数据
Route::get('/blog/{user}', function(Users $user){
    return $user;
});
//路由分组
Route::group(['prefix' => '/blog'], function(){
    Route::get('/update/{id}','BlogController@update');
});