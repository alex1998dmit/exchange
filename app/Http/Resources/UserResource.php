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
        // return parent::toArray($request);
        $balances = $this->balance;
        $currencies_name = $balances->cur
        return [
            'name' => $this->name,
            'email' => $this->email,
            'balances' => new BalanceCollection($this->balance),
        ];
    }
}
