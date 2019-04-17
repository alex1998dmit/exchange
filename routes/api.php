<?php

use Illuminate\Http\Request;
use App\User;
use App\Balance;
use App\Http\Resources\UserResource;
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

Route::get('/test', function(Request $request) {
    $name = $request['name'];
    return json_encode(['key' => $name]);
});

Route::post('/test', function(Request $request) {
    $name = $request['name'];
    $surname = $request['surname'];
    return json_encode(['name' => $name, 'surname' => $surname]);
});

Route::get('/user', function(Request $request) {
    $id  = $request['id'];
    $user = User::find($id);
    $balances = $user->balance;
    return new UserResource($user);
});
