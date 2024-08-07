<?php

namespace App\Http\Controllers\API;

use App\BusinessHouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class BusinessHouseController extends Controller
{
    //Get Business House 
    public function businessHouse(Request $request)
    {
        $user = $request->user('api');

        if ($user) {
            $query = BusinessHouse::query();
            if ($user->hasRole('administrator')) {
                $businessHouse = $query->get();
            } else {
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

    //Create Business House
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

        if ($business->save()) {
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

    //Update Business House
    public function update(Request $request, $id)
    {
        $user = $request->user('api');

        if ($user->hasRole('administrator')) {
            $business = BusinessHouse::find($id);

            if ($business) {
                if ($request->file('business_certificate')) {
                    if (isset($request->mediaid) && !empty($request->mediaid)) {
                        $media = Media::where('model_id', $request->mediaid)->first();
                        if ($media) {
                            $model_type = $media->model_type;
                            $model = $model_type::find($media->model_id);
                            $model->deleteMedia($media->id);
                        }
                    }
                    $business->addMedia($request->file('business_certificate'))->toMediaCollection();
                }

                $business->house_no = $request->house_no;
                $business->road = $request->road;
                $business->tol = $request->tol;
                $business->contact = $request->contact;
                $business->business_name = $request->business_name;

                $business->business_reg_date = $request->business_reg_date;
                $business->business_certi_no = $request->business_certi_no;
                $business->location_swap_ward = $request->location_swap_ward;
                $business->location_swap_date = $request->location_swap_date;
                $business->last_renewed_year = $request->last_renewed_year;

                $business->business_type = $request->business_type;
                $business->created_by = auth('api')->user()->id;

                if($business->save()){
                   return response()->json([
                        'success'=>true,
                        'message'=>$request->owner . " updated successfully"
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
                    'message' => 'Business House Not Found'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not allowed'
            ]);
        }
    }

    //Delete Business House
    public function delete(Request $request,$id){
        $user = $request->user('api');
        
        if($user->hasRole('administrator')){
            $business = BusinessHouse::find($id);
            if($business){
                if($business->delete()){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Business House has been Deleted'
                    ]);
                }else{
                    return response()->json([
                        'success'=>false,
                        'message'=>'Sorry but the data could not be deleted!!'
                    ]); 
                }   
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Business House Not Found'
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User is not allowed'
            ]);
        }
    }
}
