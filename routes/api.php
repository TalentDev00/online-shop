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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



Route::post('/user/register', 'AuthController@register')->name('register');
Route::post('/user/login', 'AuthController@login')->name('login');

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('/user', 'AuthController@user');
    Route::post('/user/logout', 'AuthController@logout');

});
Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('/refresh', 'AuthController@refresh');
});


Route::namespace('Api')->group(function () {
    //Route::get('/store/catalog', 'CategoryController@show');
    //Route::get('/store/catalog/{path}', 'CategoryController@index')
   //     ->where('path', '[a-zA-Z0-9\-/_]+');

   /* Route::get('/store/catalog/{path?}', 'CategoryController@show')
        ->where('path', '[a-zA-Z0-9\-/_]+');*/


    Route::get('/store/catalog', 'ItemController@index');
    Route::get('/info', 'CategoryController@index');
    Route::get('/search', 'SearchController@index');
    Route::post('/store/order', 'OrderController@index');


    //Favorites
    Route::post('/store/favorite', 'ItemController@favorite');
    Route::get('/store/favorite', 'ItemController@favorite');
});
