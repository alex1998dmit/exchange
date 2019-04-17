<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //
    protected $fillable = ['name'];
    protected $table = 'currencies';

    public function balance() 
    {
        return $this->hasMany('App\Balance');
    }   
}
