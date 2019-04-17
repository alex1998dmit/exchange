<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    //
    protected $fillable = ['user_id', 'currency_id', 'amount'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function currency() 
    {
        return $this->belongsTo('App\Currency');
    }
}
