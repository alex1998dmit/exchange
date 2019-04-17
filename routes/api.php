<?php

use Illuminate\Http\Request;
use App\User;
use App\Balance;
use App\Exchange;
use App\Http\Resources\UserResource;
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
    return new UserResource($user);
});

Route::post('/exchange', function(Request $request) {
    $exchanged_id = $request['exchanged_cur'];
    $received_id = $request['received_cur'];
    $amount = $request['amount'];
    $rate = $request['rate'];
    $user_id = 1;

    $exchanged_balance = Balance::find($exchanged_id);
    $received_balance = Balance::find($received_id);
    $user = User::find($user_id);


    if($amount * $rate > $exchanged_balance->amount) {
        die('Нет средств на транзакцию');
    } else {

        $exchange = Exchange::create([
            'exchanged_currency' => $exchanged_id,
            'received_currency' => $received_id,
            'amount' => $amount, 
            'date' => Carbon::now(),
            'rate' => $rate,
        ]);     
        
        $exchanged_balance->amount = $exchanged_balance->amount - $amount * $rate;
        $received_balance->amount = $received_balance->amount + $amount;

        $exchanged_balance->save();
        $received_balance->save();
    }
    return new UserResource($user);
});

