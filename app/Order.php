<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['user_id','amount','return_order','type_of_order','status'];
	public function appservices()
    {
        return $this->belongsToMany('App\AppService');
    }
	public function installments()
	{
	    return $this->belongsToMany('App\Installment');
	}
	public function payments()
	{
	    return $this->hasMany('App\Payment');
	}
	public function user()
	{
	    return $this->belongsTo('App\User');
	}
}
