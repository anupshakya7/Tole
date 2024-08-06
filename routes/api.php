<?php

/**Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
	Route::get('/profile','WardProfileAPI\ProfileController@femaleProfile')->name('ward.profile');
});

Route::group(['prefix' => '/v1', 'as' => 'api.'], function () {
	Route::get('/profile/{gender}','WardProfileAPI\ProfileController@profile')->name('ward.profile');
});**/

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BusinessHouseController;
use App\Http\Controllers\API\HouseownerController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\ProfileController;
use Illuminate\Support\Facades\Route;

//Register
Route::post('/register', [AuthController::class,'register']);

//Verify Mail
Route::post('/verify-mail',[AuthController::class,'verifyMail']);
Route::get('/mail-verify/{token}',[AuthController::class,'mailVerification']);

//Login 
Route::post('/login', [AuthController::class,'login']);

//Forget Password
Route::post('/forget-password',[AuthController::class,'forgetPassword']);
Route::post('/reset-password', [AuthController::class,'resetPassword']);

Route::middleware('checkUser')->group(function(){
	Route::get('/logout',[AuthController::class,'logout']);
	Route::get('/profile',[ProfileController::class,'profile'])->middleware('checkUser');
	Route::post('/profile-update',[ProfileController::class,'updateProfile']);
	Route::post('/change-password',[ProfileController::class,'changePassword']);
	Route::post('/refresh-token',[AuthController::class,'refreshToken']);

	//Members
	Route::prefix('member')->group(function(){
		Route::get('/{slug?}',[MemberController::class,'member']);
		Route::post('create',[MemberController::class,'store']);
		Route::put('update/{id}',[MemberController::class,'update']);
		Route::delete('delete/{id}',[MemberController::class,'delete']);
	});

	//Houseowners
	Route::prefix('house-owner')->group(function(){
		Route::get('/',[HouseownerController::class,'houseowner']);
		Route::post('/',[HouseownerController::class,'store']);
		Route::put('/{id}',[HouseownerController::class,'update']);
		Route::delete('/{id}',[HouseownerController::class,'delete']);
	});

	//Business House
	Route::prefix('business-house')->group(function(){
		Route::get('/',[BusinessHouseController::class,'businessHouse']);
		Route::post('/',[BusinessHouseController::class,'store']);
		Route::put('/{id}',[BusinessHouseController::class,'update']);
		Route::delete('/{id}',[BusinessHouseController::class,'delete']);
	});
});




