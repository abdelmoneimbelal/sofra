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
Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('reset', 'AuthController@reset');
    Route::post('password', 'AuthController@password');
    Route::get('cities', 'MainController@cities');
    Route::get('regions', 'MainController@regions');
    Route::get('setting', 'MainController@setting');
    Route::get('item', 'MainController@item');
    Route::get('products', 'MainController@products');
    Route::get('resturant', 'MainController@resturant');
    Route::get('offers', 'MainController@offers');
    Route::post('contacts', 'MainController@contacts');
    Route::post('restregister', 'AuthController@restregister');
    Route::post('resturantlogin', 'AuthController@resturantlogin');
    Route::post('resturantreset', 'AuthController@resturantreset');
    Route::post('resturantpassword', 'AuthController@resturantpassword');


    Route::group(['middleware' => 'auth:clients'], function () {
        Route::post('profile', 'AuthController@profile');
        Route::post('registerToken', 'AuthController@registerToken');
        Route::post('removeToken', 'AuthController@removeToken');
        Route::post('createorder', 'MainController@createorder');
        Route::get('payment', 'MainController@payment');

        //Route::get('showorder','MainController@showorder');
    });
    Route::group(['middleware' => 'auth:resturants'], function () {
        Route::get('resturantoffers', 'MainController@resturantoffers');
        Route::post('reregisterToken', 'AuthController@reregisterToken');
        Route::post('reremoveToken', 'AuthController@reremoveToken');
        Route::post('reProfile', 'AuthController@reProfile');

    });

});
