<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    //
    protected $fillable = ['exchanged_currency', 'received_currency', 'amount', 'date', 'rate'];

    public function currency() 
    {
        return $this->belongsTo('App\Balance');
    }

}
