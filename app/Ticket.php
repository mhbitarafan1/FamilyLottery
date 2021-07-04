<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $fillable = ['user_id','title','body','parent_ticket'];
    public function user()
    {
    	return $this->belongsTo('app\User');
    }
}
