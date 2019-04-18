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

Route::get('/test', function(Request $request) {
    $name = $request['name'];
    return json_encode(['key' => $name]);
});

Route::post('/test', function(Request $request) {
    $name = $request['name'];
    $surname = $request['surname'];
    return json_encode(['name' => $name, 'surname' => $surname]);
});


// Route::middleware('auth:api')->get('/user', function(Request $request) {
//         // $userId = Auth::id();
//         $userId = $request->user()->id;
//         // $id  = Auth::user()->id;
//         $user = User::find($userId);
//         // return $userId;
//         return json_encode(['user_id' => 'dsada']);
//         // return new UserResource($user);
//     });

// });
Route::group(['middleware' => 'auth'], function () {
    // your routes

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

Route::get('/user/stats', function(Request $request) {
    // Переделать в будущем, продумать лучшую структуру для хранения информации о пользователи в транзакциях ??
    $user_id = 1;

    // Можно заменить добавив в сущность транзакций пользователя ???
    $balances = Balance::where('user_id', '=', 1)->get();
    $balances_id = [];

    foreach($balances as $balance) {
        array_push($balances_id, $balance->id);
    }

    $exchanges = Exchange::whereDate('date', Carbon::today())->whereIn('exchanged_currency', $balances_id)->get();
    return new ExchangesCollection($exchanges);
});

