<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
	protected $fillable = ['lottery_id','lottery_member_id','count_of_stock','type_of_request','accepted_by_lotterymanager'];
    public function lottery()
    {
        return $this->belongsTo('App\Lottery');
    }
        public function lotterymember()
    {
    	return $this->belongsTo('App\LotteryMember');
    }
}
