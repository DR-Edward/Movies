<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (!Auth::check()) return view('auth.login');
    return redirect()->route('home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    
    // ROUTES -> Turns
    Route::patch('/turns/activator/{id}', 'TurnController@activator')->name('turns.activator');
    Route::resource('/turns', 'TurnController');

    // ROUTES -> Movies
    Route::patch('/movies/activator/{id}', 'MovieController@activator');
    Route::patch('/movies/turns/{id}', 'MovieController@update_turns');
    Route::resource('/movies', 'MovieController');
});
