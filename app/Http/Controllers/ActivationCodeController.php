<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\ActivationCode;

class ActivationCodeController extends Controller
{
    public function showForm(Request $request)
    {
    	$user = User::where('phone_number',$request->phone_number)->first();

    	if ($user) {
    		$lastActiveCode = ActivationCode::where('user_id',$user->id)->first();
    		$lastActiveCodedontExpired = ActivationCode::where('user_id',$user->id)->where('expire_at','>',Carbon::now())->first();
    		if ($lastActiveCodedontExpired) {
    			$request->session()->put('phoneNumber',$request->phone_number);
    			return view('auth.showactivationform');	
    		}
    		if ($lastActiveCode) {
    			$lastActiveCode->delete();
    		}
    		$activeCode = ActivationCode::create([
    			'user_id'=>$user->id,
    			'code'=>rand(10000,99999),
    			'expire_at'=>Carbon::now()->addminutes(10),

    		]);
    		//send active code via sms
    		$request->session()->put('phoneNumber',$request->phone_number);
    		
    		return view('auth.showactivationform');
    	}else{
    		return redirect(route('register'));
    	}


    }


    
}
