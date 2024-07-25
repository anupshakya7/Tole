<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function member(Request $request,$slug=null){
        $user = $request->user('api');

        if($user){
            $query = Member::query();
            if($slug == "senior-citizen"){
                $year = date('Y-m-d',strtotime('-60 years'));
                $query->where(DB::raw('date(dob_ad)'),'<=',$year)->where('dob_ad','!=','N/A');
            }
            if($slug == "senior-citizen-sixty"){
                $year = date('Y-m-d',strtotime('-68 years'));
                $query->where(DB::raw('date(dob_ad)'),'<',$year)->where('dob_ad','!=','N/A');
            }
            if($slug == "senior-citizen-above-sixty-eight"){
                $minAge = date('Y-m-d',strtotime('-68 years'));
                $maxAge = date('Y-m-d',strtotime('-71 years'));

                $query->whereBetween(DB::raw('date(dob_ad)'),[$maxAge,$minAge])->where('dob_ad','!=','N/A');
            }
            if($slug == "belowsixteen"){
                $year = date('Y-m-d',strtotime('-16 years'));
                $query->where(DB::raw('date(dob_ad)'),'>=',$year)->whereNotNull('dob_ad');
            }
            if($slug == "youth"){
                $startDate = Carbon::now()->subYears(30)->format('Y-m-d');
                $endDate = Carbon::now()->subYears(16)->format('Y-m-d');
                $query->whereBetween('dob_ad',[$startDate,$endDate]);
            }

            if($user->hasRole('administrator')){
                $member = $query->get();
            }else{
               $member = $query->where('created_by',$user->id)->get();
            }
            return response()->json([
                'success'=>true,
                'data'=>$member
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'User is not Authenticated'
            ]);
        }
    }
}
