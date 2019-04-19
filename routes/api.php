<?php

use Illuminate\Http\Request;

use App\Http\Resources\ExchangesCollection;
use App\Http\Resources\UserResource;

use App\User;
use App\Balance;
use App\Exchange;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| API Routes
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
