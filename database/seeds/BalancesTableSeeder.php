<?php

use Illuminate\Database\Seeder;
use App\Balance;
use App\User;
use App\Currency;

class BalancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $currencies = Currency::all();
        $user = User::where('name', '=', 'admin')->first();
        $user_id = $user->id;
        foreach($currencies as $currency) {
            Balance::create([
                'user_id' => $user_id,
                'currency_id' => $currency->id,
                'amount' => 1000,
            ]);
        }
    }
}
