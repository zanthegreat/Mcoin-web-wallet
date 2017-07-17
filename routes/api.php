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

// Get the DNC Price
Route::get('/dnc/price', 'DashboardController@getDNCPrice');

// Generate User's new Key Addresses
Route::get('/generate/key', 'KeyGenerator@generateKey');

// Get Dash API results
Route::group(['prefix'=>'dash'], function () {
	Route::get('/difficulty', 'DashController@getDifficulty');
	Route::get('/hash/rate', 'DashController@getHashRate');
	Route::get('/block/count', 'DashController@getBlockCount');
	Route::get('/account/{address}', 'DashController@getAccount');
	Route::get('/transaction/{hash}', 'DashController@getTransaction');
	Route::get('/info', 'DashController@getInfo');
});


// Register User
Route::post('/register', 'AccessController@registerUser');

// Return Token and User Details
Route::post('/login', 'AccessController@loginUser');

// Return user API
Route::group(['prefix'=>'user' , 'middleware'=>'jwt'] , function () {
	// Return user Profiles
	Route::get('/profile', 'AccessController@getUserProfile');
});