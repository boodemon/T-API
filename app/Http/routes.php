<?php
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware'=>'api'],function(){
        Route::post('auth/login','Api\AuthController@login');
        Route::post('auth/signin','Api\AuthController@signin');
        Route::get('auth/token','Api\AuthController@token');
        Route::get('auth/check','Api\AuthController@check');

        Route::resource('auth0','Api\Auth0Controller');
        Route::resource('admin','Api\AdminController');
        Route::resource('category','Api\CategoryController');
        Route::resource('restourant','Api\RestourantController');
});
