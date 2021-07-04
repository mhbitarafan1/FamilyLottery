<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $fillable = ['lottery_manager_id','amount','time_of_first_lot','cycle','count_of_lots','type_of_income','name','slug','short_description','type_of_choose_winner','count_of_view','count_of_like'];
    
    public function lots()
    {
        return $this->hasMany('App\Lot');
    }
    public function lotterystocks()
    {
        return $this->hasMany('App\LotteryStock');
    }
    public function stockrequests()
    {
        return $this->hasMany('App\StockRequest');
    }
     public function lotterymembers()
    {
        return $this->belongsToMany('App\LotteryMember');
    }
     public function lotterymanager()
    {
        return $this->belongsTo('App\LotteryManager');
    }



}
