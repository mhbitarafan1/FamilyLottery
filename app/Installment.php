<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = ['lot_id','lottery_stock_id','paid','confirmed_by'];
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }
    public function lotterysotck()
	{
    return $this->belongsTo('App\Lotterysotck');
	}
    public function lot()
	{
    return $this->belongsTo('App\Lot');
	}
}
