<?php

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

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'UsersController@index')->name('user');
    Route::get('/exchange', 'ExchangesController@index')->name('exchange');
    Route::get('/user', 'UsersController@index')->name('user');
    Route::post('/exchange', 'ExchangesController@post')->name('exchange.post');
});




