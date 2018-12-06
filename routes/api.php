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
Route::post('/user/register', 'AuthController@register')->name('register');
Route::post('/user/login', 'AuthController@login')->name('login');

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('/user', 'AuthController@user');
    Route::post('/user/logout', 'AuthController@logout');

    Route::namespace('Api')->group(function () {

        //Orders
        Route::post('/store/order', 'OrderController@index');
        Route::get('/store/order', 'OrderController@orders');
        Route::delete('/store/order/{order_id}', 'OrderController@delete');

        //Favorites
        Route::post('/store/favorite', 'ItemController@favorite');
        Route::get('/store/favorite', 'ItemController@favorite');


        //Cart
        Route::post('/store/cart', 'CartController@syncItem');
        Route::post('/store/cart/sync', 'CartController@syncCart');
        Route::get('/store/cart', 'CartController@index');

        //User
        Route::post('/menu/settings', 'UserController@index');
    });

});
Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('/refresh', 'AuthController@refresh');
});

Route::namespace('Api')->group(function () {
    Route::get('/info', 'CategoryController@index');
    Route::get('/store/catalog', 'ItemController@index');
    Route::get('/store/catalog/items', 'ItemController@single');
    Route::get('/search', 'SearchController@index');

});



