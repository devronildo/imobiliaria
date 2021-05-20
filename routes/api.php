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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'Api', 'as' => 'api.'], function(){

    Route::post('/auth/login', 'AuthController@login')->name('login');

    Route::group(['middleware' => ['apiJwt']], function(){
        Route::post('/auth/logout', 'AuthController@logout')->name('logout');
        Route::post('/me', 'AuthController@me')->name('me');

        Route::apiResource('/company', 'CompanyController');
    });

});