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

    Route::get('api/user', function(Request $request) {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        return new UserResource($user);
    });

    Route::post('api/exchange', function(Request $request) {
        $exchanged_id = $request['exchanged_cur'];
        $received_id = $request['received_cur'];
        $amount = $request['amount'];
        $rate = $request['rate'];
        $user_id =  Auth::user()->id;

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

    Route::get('api/user/stats', function(Request $request) {
        // Переделать в будущем, продумать лучшую структуру для хранения информации о пользователи в транзакциях ??
        $user_id = Auth::user()->id;

        // Можно заменить добавив в сущность транзакций пользователя ???
        $balances = Balance::where('user_id', '=', 1)->get();
        $balances_id = [];

        foreach($balances as $balance) {
            array_push($balances_id, $balance->id);
        }

        $exchanges = Exchange::whereDate('date', Carbon::today())->whereIn('exchanged_currency', $balances_id)->get();
        return new ExchangesCollection($exchanges);
    });

    Route::post('/exchange', 'ExchangesController@post')->name('exchange.post');
});
