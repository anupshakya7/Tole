<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //Profile
    public function profile()
    {
        try {
            $user = auth('api')->user();

            //Check if user is Authenticated
            if(!$user){
                return response()->json([
                    'success'=>false,
                    'message'=>'User is not Authenticated'
                ]);
            }

            $user->load('roles');

            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    //Update Profile
    public function updateProfile(Request $request)
    {
        if(auth('api')->user()) {
            $validator = Validator::make($request->all(), [
                'id' => "required",
                'name' => 'required|string',
                'email' => 'required|email|string|unique:users,email,'.auth('api')->user()->id
            ]);

            if($validator->fails()) { 
                return response()->json($validator->errors(), 400);
            }

            $user = User::with('roles')->find($request->id);
            $userRoles = $user->roles->pluck('name')->toArray();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            
            
            $user->syncRoles($userRoles);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated'
            ]);
        }
    }

    //Change Password
    public function changePassword(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6|max:100',
            'new_password' => 'required|string|min:6|max:100',
            'confirm_password' => 'required|string|same:new_password'
        ]);

        if($validators->fails()) {
            return response()->json($validators->errors(), 400);
        }

        if(auth('api')->user()) {
            if(Hash::check($request->old_password, auth('api')->user()->password)) {
                auth('api')->user()->update([
                    'password' => bcrypt($request->new_password)
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Password Successfully Updated.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Old Password does not matched.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated.'
            ]);
        }
    }
}
