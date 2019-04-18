<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Balance;

class ExchangesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $exchanges = $this->collection;
        $response = [];
        foreach($exchanges as $exchange) {

            $exchange_balance_id = $exchange->exchanged_currency;
            $received_balance_id = $exchange->received_currency;

            $response[] = [
                'exchanged_currency' => Balance::find($exchange_balance_id)->currency->name,
                'received_currency' => Balance::find($received_balance_id)->currency->name,
                'rate' => $exchange->rate,
                'amount' => $exchange->amount,
                'date' => $exchange->created_at->format('l jS \\of F Y h:i:s A'),
            ];
        }
        return $response;
    }
}
