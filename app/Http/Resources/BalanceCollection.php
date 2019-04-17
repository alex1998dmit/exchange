<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BalanceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {        
        $balances = $this->collection;
        
        // foreach($balances as $balance) {
        //     dd($balance);
        // }
        return [
            'amount' => $this->collection,
        ];
        // return parent::toArray($request);
    }
}
