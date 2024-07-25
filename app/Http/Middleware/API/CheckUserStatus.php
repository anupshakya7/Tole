<?php

namespace App\Http\Middleware\API;

use App\User;
use Closure;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authUser = auth('api')->user();
        if($authUser){
            $user = User::where('email',$authUser->email)->where('status',1)->first();
            if(!$user){
                auth('api')->logout();
                return response()->json([
                    'success'=>false,
                    'message'=>'User is Inactive'
                ]);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'User is not Authenticated'
            ]);
        }
        

        return $next($request);
    }
}
