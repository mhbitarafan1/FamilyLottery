<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{
	protected $fillable = ['user_id','code','expire_at'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
