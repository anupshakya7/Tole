<?php

namespace App\Http\Controllers\API;

use App\BusinessHouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessHouseController extends Controller
{
    public function businessHouse(Request $request){
        $user = $request->user('api');
        
        if($user){
            $query = BusinessHouse::query();
            if($user->hasRole('administrator')){
                $businessHouse = $query->get();
            }else{
                return $user->id;
                $businessHouse = $query->where('created_by',$user->id)->get();
            }
            return response()->json([
                'success'=>true,
                'data'=>$businessHouse
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'User is not Authenticated'
            ]);
        }
    }
}
