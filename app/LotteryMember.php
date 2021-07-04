<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryMember extends Model
{
    protected $fillable = ['user_id'];
     public function lotteries()
    {
        return $this->belongsToMany('App\Lottery');
    }
         public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function stockrequests()
    {
    	return $this->hasMany('App\StockRequest');
    }
}
