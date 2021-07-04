<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryStock extends Model
{
	protected $fillable = ['lottery_id','number','owner','winned','total_payment'];
    public function installments()
    {
        return $this->hasMany('App\Installment');
    }
    public function lottery()
    {
        return $this->belongsTo('App\Lottery');
    }
}
