<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrinciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $currencies = ['RUB', 'USD', 'EUR', 'GBP'];
        for($i = 0; $i < count($currencies);$i++){
            Currency::create([
                'name' => $currencies[$i],
            ]);
        }
    }
}
