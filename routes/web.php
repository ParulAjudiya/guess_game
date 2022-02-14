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

Route::get('/', 'GameController@index')->name('home');
Route::get('/start_new_game', 'GameController@start_new_game')->name('start_new_game');
Route::get('/play', 'GameController@play')->name('play');
Route::get('/invite', 'GameController@invite')->name('invite');
Route::post('/new_game', 'GameController@new_game')->name('new_game');
Route::get('/joingame/{token?}', 'GameController@join_game')->name('joingame');
Route::post('/process_to_join_game', 'GameController@process_to_join_game')->name('process_to_join_game');
Route::post('/check_gamerule', 'GameController@check_gamerule')->name('check_gamerule');
Route::post('/guess_number', 'GameController@guess_number')->name('guess_number');
Route::get('/close_game', 'GameController@close_game')->name('close_game');
