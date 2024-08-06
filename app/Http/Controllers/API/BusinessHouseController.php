<?php

namespace App\Http\Controllers\API;

use App\BusinessHouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessHouseController extends Controller
{
    public function businessHouse(Request $request)
    {
        $user = $request->user('api');

        if ($user) {
            $query = BusinessHouse::query();
            if ($user->hasRole('administrator')) {
                $businessHouse = $query->get();
            } else {
                return $user->id;
                $businessHouse = $query->where('created_by', $user->id)->get();
            }
            return response()->json([
                'success' => true,
                'data' => $businessHouse
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated'
            ]);
        }
    }

    public function store(Request $request)
    {
        $business = new BusinessHouse();

        if ($request->hasFile('business_certificate')) {
            $business->addMedia($request->file('business_certificate'))->toMediaCollection();
        } else {
            $business->image = NULL;
        }

        $business->house_no = $request->house_no;
        $business->road = $request->road;
        $business->tol = $request->tol;
        $business->contact = $request->contact;
        $business->business_name = $request->business_name;

        $business->business_name = $request->business_name;

        $business->business_reg_date = $request->business_reg_date;
        $business->business_certi_no = $request->business_certi_no;
        $business->location_swap_ward = $request->location_swap_ward;
        $business->location_swap_date = $request->location_swap_date;
        $business->last_renewed_year = $request->last_renewed_year;

        $business->created_by = auth('api')->user()->id;

        if($business->save()){
            return response()->json([
                'success'=>true,
                'message'=>'Successfully inserted data for '.$request->house_no
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Unable to insert data of '.$request->house_no
            ]);
        }
    }
}
