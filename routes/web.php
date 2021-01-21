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



Route::post('api/reply', 'App\Http\Controllers\BotHandlerController@reply');

Route::get('yoda', 'App\Http\Controllers\BotController@__invoke');

