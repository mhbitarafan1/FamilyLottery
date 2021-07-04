<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LotteryMember;
use App\LotteryManager;
use Illuminate\Support\Facades\Auth;
use App\ActivationCode2;
use Illuminate\Support\Facades\Hash;

class Register2Controller extends Controller
{
    public function register(Request $request)
    {

    		//check activation code and phone number
    		$phoneNumber = $request->session()->get('phoneNumber');
    		$name = $request->session()->get('Name');
    			$activeCode = ActivationCode2::where('phone_number',$phoneNumber)->first()->code;
    			if ($request->active_code == $activeCode) {
                    
    				User::create([
    					'name' => $name,
    					'phone_number' => $phoneNumber,
    					'password' => Hash::make('bkc9615d'),
    				]);
                    $user = User::where('phone_number',$phoneNumber)->first();
    				Auth::login($user);
    				LotteryMember::create([
    				    'user_id' => auth()->user()->id,
    				]);
    				LotteryManager::create([
    				    'user_id' => auth()->user()->id,
    				]);

    				
    			return redirect('home');
    			}

            $request->session()->put('phoneNumber',$phoneNumber);
            $request->session()->put('Name',$name);   
    		return back();

    	}











}
