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

Route::group(['prefix' => 'tasks', 'middleware' => 'auth:sanctum'], function ($api) {
	# Get List
	$api->get('/', ['as' => 'api.tasks.list', 'uses' => 'TaskController@get_list']);
	# Get Detail
	$api->get('/{task_id}/detail', ['as' => 'api.tasks.list', 'uses' => 'TaskController@get_detail']);
	# Create
	$api->post('/create', ['as' => 'api.tasks.list', 'uses' => 'TaskController@create']);
	# Update
	$api->put('/update', ['as' => 'api.tasks.list', 'uses' => 'TaskController@update']);
	# Delete
	$api->delete('/{task_id}/delete', ['as' => 'api.tasks.list', 'uses' => 'TaskController@delete']);
});
