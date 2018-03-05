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
    if (Auth::guard('admin')->guest()) {
        return redirect('login');
    } else {
        return redirect('dashboard');
    }
});

Route::resource('login', 'Backend\AuthController');

Route::group(['middleware'=>'admin'], function () {
    Route::resource('dashboard', 'Backend\DashboardController');
    Route::resource('order', 'Backend\OrderController');
    Route::resource('foods/category','Backend\CategoryController');
    Route::resource('foods/restourant', 'Backend\RestourantController');
    Route::resource('foods/food','Backend\FoodController');
    Route::get('foods/price/{id?}/{food_id?}', 'Backend\FoodController@price');
    Route::get('foods/price-list/{food_id?}', 'Backend\FoodController@price_list');

    Route::resource('payment','Backend\PaymentController');
    Route::resource('member','Backend\MemberController');
    Route::post('member/checker', 'Backend\MemberController@checker');
    Route::resource('report','Backend\ReportController');
    Route::resource('user','Backend\UserController');
    Route::get('user/profile', 'Backend\UserController@getProfile');
    Route::post('user/profile', 'Backend\UserController@postProfile');
    Route::post('user/checker', 'Backend\UserController@checker');
    Route::get('logout','Backend\AdminController@logout');
});

// Start API Mobile and single page app //
Route::group(['middleware'=>'cors','prefix' => 'api'],function(){
    // Member mobile app //
    Route::post('auth0/register','Api\Auth0Controller@register');
    Route::post('auth0/checkuser','Api\Auth0Controller@checkuser');
    Route::post('auth0/login','Api\Auth0Controller@login');
    //
    Route::group(['middleware' => 'jwt-member'],function(){
        Route::resource('category','Api\CategoryController');
        Route::get('foods/{id?}','Api\FoodController@index');
        Route::resource('food','Api\FoodController');
        Route::get('user','Api\MemberController@check');
    });

    Route::get('/', function () {
        $rows = App\Models\Member::orderBy('name')->get();
        return response()->json( $rows );
    });    
    Route::group(['middleware' => 'jwt-auth'],function(){

       
        Route::post('auth/signin','Api\AuthController@signin');
        Route::get('auth/check','Api\AuthController@check');
        Route::resource('admin','Api\AdminController');
        
        Route::resource('restourant','Api\RestourantController');
    });
});

