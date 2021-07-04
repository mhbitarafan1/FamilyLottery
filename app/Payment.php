<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $fillable = ['order_id','type','tracking_code','status','user_cash_after_pay'];
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
