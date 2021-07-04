<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
	protected $fillable = ['lottery_id','number','time_holding','amount','stock_winner'];
    public function installments()
    {
        return $this->hasMany('App\Installment');
    }
    public function lottery()
	{
    return $this->belongsTo('App\Lottery');
	}
}
