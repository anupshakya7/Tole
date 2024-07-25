<?php

namespace App\Http\Controllers\API;

use App\Houseowner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HouseownerController extends Controller
{
    public function houseowner(Request $request){
        $user = $request->user('api');
        if($user){
            $query = Houseowner::query();
            if($user->hasRole('administrator')){
                $houseowner = $query->get();
            }else{
                $houseowner = 'Not Allowed';
            }
            return response()->json([
                'success'=>true,
                'data'=>$houseowner
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'User is not Authenticated'
            ]);
        }
    }
}
