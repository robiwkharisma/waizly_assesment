<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function ($api) {
	# Login
	$api->post('login', ['as' => 'api.auth.login', 'uses' => 'AuthController@login']);

	Route::group(['middleware' => 'auth:sanctum'], function ($api) {
		$api->post('change-password', ['as' => 'api.auth.change-password', 'uses' => 'AuthController@change_password']);
		$api->post('refresh-token', ['as' => 'api.auth.refresh-token', 'uses' => 'AuthController@refresh_token']);
		$api->post('logout', ['as' => 'api.auth.logout', 'uses' => 'AuthController@logout']);
	});
});
