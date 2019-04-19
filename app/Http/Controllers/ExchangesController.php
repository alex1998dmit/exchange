<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

use Auth;
use App\User;
use App\Balance;

class ExchangesController extends Controller
{
    //
    public function store(Request $request)
    {
        $exchanged_id = $request['exchanged_cur'];
        $received_id = $request['received_cur'];
        $amount = $request['amount'];
        $rate = $request['rate'];
        $user_id =  Auth::user()->id;

        dd($received_id);

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
    }
}
