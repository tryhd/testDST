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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users', 'as' => 'user.'],function() {
    Route::post('login', 'API\Login\AuthController@login')->name('login');
    Route::post('logout', 'API\Login\AuthController@logout')->name('logout')->middleware('auth:sanctum');
});

Route::group(['prefix' => 'products', 'as' => 'product.'], function(){
    route::get('list', 'API\Admin\ProductController@getProduct')->name('list')->middleware('auth:sanctum');
    route::post('store', 'API\Admin\ProductController@store')->name('store')->middleware('auth:sanctum');
    route::get('show/{id}', 'API\Admin\ProductController@Detail')->name('show')->middleware('auth:sanctum');
    route::post('update/{id}', 'API\Admin\ProductController@Update')->name('update')->middleware('auth:sanctum');
    route::Delete('delete/{id}', 'API\Admin\ProductController@Delete')->name('delete')->middleware('auth:sanctum');
});

