<?php

namespace App\Http\Controllers\API;

use App\Houseowner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HouseownerController extends Controller
{
    //Get Houseowner
    public function houseowner(Request $request)
    {
        $user = $request->user('api');
        if ($user) {
            $query = Houseowner::query();
            if ($user->hasRole('administrator')) {
                $houseowner = $query->get();
            } else {
                $houseowner = 'Not Allowed';
            }
            return response()->json([
                'success' => true,
                'data' => $houseowner
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated'
            ]);
        }
    }

    //Create Houseowner
    public function store(Request $request)
    {
        $owner = new Houseowner();
        $owner->taxpayer_id = $request->taxpayer_id;
        $owner->house_no = $request->house_no;
        $owner->owner = $request->owner;
        $owner->owner_np = $request->owner_np;
        $owner->road = $request->road;
        $owner->tol = $request->tol;
        $owner->contact = $request->contact;
        $owner->mobile = $request->mobile;
        $owner->responent = $request->responent;
        $owner->responent_np = $request->responent_np;
        $owner->occupation = $request->occupation;
        $owner->no_of_tenants = $request->no_of_tenants;
        $owner->gender = $request->gender;

        if ($owner->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully inserted data for ' . $request->house_no
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to insert data of ' . $request->house_no
            ]);
        }
    }

    //Update Houseowner
    public function update(Request $request, $id)
    {
        $owner = Houseowner::find($id);

        if ($owner) {
            $owner->taxpayer_id = $request->taxpayer_id;
            $owner->house_no = $request->house_no;
            $owner->owner = $request->owner;
            $owner->owner_np = $request->owner_np;
            $owner->road = $request->road;
            $owner->tol = $request->tol;
            $owner->contact = $request->contact;
            $owner->mobile = $request->mobile;
            $owner->responent = $request->respondent;
            $owner->responent_np = $request->respondent_np;
            $owner->occupation = $request->occupation;
            $owner->no_of_tenants = $request->no_of_tenants;
            $owner->gender = $request->gender;

            if ($owner->save()) {
                return response()->json([
                    'success' => true,
                    'message' => $request->owner.' updated successfully'
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>"Unable to update " . $request->owner
                ]);  
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'House Owner not Found'
            ]);
        }
    }

    //Delete Houseowner
    public function delete($id){
        $owner = Houseowner::find($id);

        if($owner){
            $owner->delete();
            return response()->json([
                'success' => true,
                'message' => 'House Owner Deleted successfully'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'House Owner not Found'
            ]);
        }
    }
}
