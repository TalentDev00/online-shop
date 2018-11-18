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

Route::get('/users', function () {
    return factory('App\User', 10)->make();
});


Route::namespace('Api')->group(function () {
    Route::get('/catalog', 'CatalogController@index')->name('catalog');
    Route::get('/catalog/{catalog_id}', 'CatalogController@subcatalogIndex')
        ->where('catalog_id', '[0-9]+')

        ->name('subcatalog');
    Route::get('/catalog/{catalog_id}/{section_id}', 'CatalogController@sectionIndex')
        ->where('catalog_id', '[0-9]+')
        ->where('section_id', '[0-9]+');

});
