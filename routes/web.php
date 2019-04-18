<?php


use App\Http\Resources\ExchangesCollection;
use App\Http\Resources\UserResource;

use App\User;
use App\Balance;
use App\Exchange;
use App\Currency;
use Carbon\Carbon;
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
    Route::get('/exchange', 'ExchangesController@index')->name('exchange');
    Route::get('/user', 'UsersController@index')->name('user');

    Route::get('/test/{id}', function($id) {
        $user = User::find($id);
        // dd($user->balance());
        $balance = Balance::find(1);
        // $currencey = Currency::find(1);
        print_r($balance->currency->name);
        // $balance->currency->
    });

    Route::get('api/user', function(Request $request) {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        return new UserResource($user);
    });


    Route::post('/exchange', 'ExchangesController@post')->name('exchange.post');
});
