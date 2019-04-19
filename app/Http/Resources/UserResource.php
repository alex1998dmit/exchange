<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CurrenciesResource;
use App\Http\Resources\BalanceCollection;



class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [];
        foreach($this->balance as $bal){
            $response[] = [
                'balance_id' => $bal->id,
                'name' => $bal->currency->name,
                'amount' => $bal->amount,
            ];
        }

        return [
            'name' => $this->name,
            'email' => $this->email,
            'balances' => $response,
        ];
    }
}
