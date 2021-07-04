<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryManager extends Model
{
	protected $fillable = ['user_id'];
    public function lotteries()
    {
        return $this->hasMany('App\Lottery');
    }
     public function user()
    {
        return $this->belongsTo('App\User');
    }
}
