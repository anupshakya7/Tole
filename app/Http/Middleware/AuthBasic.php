<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthBasic{
	public function handle($request, Closure $next){
	
		if(Auth::onceBasic()){
			return response()->json(['message'=>'Auth Failed'],401);
		}else{
			return $next($request);
		}
	}
} 