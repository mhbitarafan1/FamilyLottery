<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivationCode2 extends Model
{
    protected $fillable = ['phone_number','code','expire_at'];
}
