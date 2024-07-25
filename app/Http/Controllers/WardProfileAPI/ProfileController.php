<?php

namespace App\Http\Controllers\WardProfileAPI;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Member;

class ProfileController extends Controller
{

    public function profile($gender)
    {
		 $total = Member::all()->count();
		 if($gender <= 1 && $gender >= 0){
		 $ward_profile = Member::where('gender',$gender)->get()->count();
		 if($ward_profile){
			return response()->json([
				'status'=>200,
				'total'=>$total,
				'individual'=>$ward_profile
			]);
		 }else{
			 return response()->json([
				'status'=>404,
				'message'=>'Ward Profile Not Found'
			 ]);
		 }
		 }else{
			 return response()->json([
				'status'=>404,
				'message'=>'Not Found Data'
			 ]);
		 }
	}

}