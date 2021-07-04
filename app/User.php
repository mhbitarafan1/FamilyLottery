<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone_number', 'password','avatar_url','cash',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activationcodes()
    {
        return $this->hasMany('App\ActivationCode');
    }
     public function lotterymanager()
    {
        return $this->hasOne('App\LotteryManager');
    }
     public function lotterymember()
    {
        return $this->hasOne('App\LotteryMember');
    }
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
