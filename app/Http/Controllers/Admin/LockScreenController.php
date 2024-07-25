<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Http\Controllers\BaseController;

class LockScreenController extends BaseController
{
	//lock screen
	public function locked()
	{
		/*if(!session('lock-expires-at'))
		{
			session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);
			return redirect()->route('admin.home');
		}
		
		if(session('lock-expires-at') > now())
		{
			return redirect()->route('admin.home');
		}*/
		return view('admin.lockscreen.lockscreen');
	}
	
	public function unlock(Request $request)
	{
		$request->validate([
			'password' => 'required|string',
		]);
		
		$check = Hash::check($request->input('password'),$request->user()->password);
		
		if(!check)
		{
			return redirect()->route('lock')->with("message", "Password is incorrect!!");;
		}
		
		session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);
		return redirect()->route('admin.home')->with("message", "Logged in successfully!!");;
	}
}