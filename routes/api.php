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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\LoginController@api_login');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', 'Auth\LoginController@api_logout');
    });
});


Route::group(['middleware' => 'auth:api'], function() {
    // ROUTES -> Turns
    Route::patch('/turns/activator/{id}', 'TurnController@activator');
    Route::resource('/turns', 'TurnController');

    // ROUTES -> Movies
    Route::patch('/movies/activator/{id}', 'MovieController@activator');
    Route::patch('/movies/turns/{id}', 'MovieController@update_turns');
    Route::resource('/movies', 'MovieController');
});