<?php

use App\Http\Controllers\API\AuthController;

Route::get("/clear-cache", function () {
  Artisan::call("cache:clear");
  Artisan::call("route:clear");
  Artisan::call("view:clear");
  Artisan::call("config:clear");
  return "Cache is cleared";
});

Auth::routes(["register" => false]);

//public member registration page
Route::get("/member-register",'Site\SiteController@register')->name('member-register');
Route::post('/member-store','Site\SiteController@memberstore')->name('member-store');

/*lock screen
Route::prefix("admin")->group(function () {
	Route::get('/lock_screen',"Admin\LockScreenController@locked")->name('locked');
	Route::post('/unlock',"Admin\LockScreenController@unlock")->name('unlock');
});*/

Route::get('login/locked', 'Auth\LoginController@locked')->middleware('auth')->name('locked');
//Forget Password
Route::get('/reset-password',[AuthController::class,'resetPasswordLoad']);
Route::post('login/unlock', 'Auth\LoginController@unlock')->name('unlock');
Route::post("/check-house", "HomeController@checkHouse")->name("checkHouse");
Route::post("/check-owner", "HomeController@checkOwner")->name("checkOwner");

Route::get("/business-house-owner", "HomeController@checkHouseBusiness")->name("businesshouseowner");

Route::post("/check-owner2", "HomeController@checkOwner2")->name("checkOwner2");
Route::get('/homeroads','HomeController@checkRoads')->name('homeroads'); 
Route::get('/homeroads2','HomeController@checkRoads2')->name('homeroads2'); 
Route::post('/check-member','HomeController@checkMember')->name('checkmember'); 
Route::get('/check-family','Admin\MembersController@checkFamily')->name('checkfamily'); 
Route::post('/check-compostbin','HomeController@checkcompostbin')->name('checkcompostbin');
Route::post('/check-cbinowner','HomeController@checkcbinowner')->name('checkcbinowner');


//for medical survey validation and view of house no
Route::post("/housechk", "HomeController@houseCheck")->name("houseCheck");
Route::get("/withmember",function(){
	return view('admin.medsurvey.partials.withmembers');
})->name('withmemberform');

Route::get("/medsurvey",function(){
	return view('admin.medsurvey.partials.survey');
})->name('medsurvey');

//assign and remove member from groups
Route::post('/member-assign','Admin\MembergroupController@assign')->name("membergroup.assign");
Route::post('/member-dismiss','Admin\MembergroupController@dismiss')->name("membergroup.dismiss");

//adding member abeden to members_abeden table via ajax
Route::post('/memberabeden-add','Admin\MembersabedanController@add')->name('memberabeden.add');

//adding member abeden to members_abeden table via ajax
Route::post('/membersifaris-add','Admin\MembersifarisController@add')->name('membersifaris.add');

//Route::get("/chk-house", "HomeController@chkHouse")->name("chkHouse");
// Change Password Routes...
Route::get(
  "change_password","Auth\ChangePasswordController@showChangePasswordForm")->name("auth.change_password");
Route::patch("change_password","Auth\ChangePasswordController@changePassword")->name("auth.change_password");

Route::group(["middleware" => ["auth"], "prefix" => "admin", "as" => "admin."],
  function () {
	  Route::get('/switchmode','HomeController@switchmode')->name('switchmode');
    Route::get("/home", "HomeController@index")->name("home");
	Route::get("/viewed/{id}","HomeController@viewed")->name("viewed");
    Route::get("/check_slug", "HomeController@check_slug")->name("check_slug");
    Route::resource("permissions", "Admin\PermissionsController");
    Route::delete("permissions_mass_destroy","Admin\PermissionsController@massDestroy")->name("permissions.mass_destroy");
    Route::resource("roles", "Admin\RolesController");
    Route::delete("roles_mass_destroy","Admin\RolesController@massDestroy")->name("roles.mass_destroy");
    Route::resource("users", "Admin\UsersController");
    Route::delete("users_mass_destroy","Admin\UsersController@massDestroy")->name("users.mass_destroy");
    Route::post("users_change", "Admin\UsersController@usersChange")->name("users_change");
	
	Route::get("notifications","HomeController@notifications")->name("notifications");
    Route::get("technotifications","HomeController@technotifications")->name("technotifications");
	
	/*user impersonate*/
	Route::get('/impersonate/{user_id}','HomeController@impersonate')->name('impersonate');
	Route::get('/impersonate_leave','HomeController@impersonate_leave')->name('impersonate_leave');
	
	//Address
    Route::prefix('address')->group(function(){
      Route::get('/',"Admin\AddressController@index")->name("address.index");
      Route::get('/create','Admin\AddressController@create')->name('address.create');
      Route::post('/store','Admin\AddressController@store')->name('address.store');
      Route::delete('/{id}','Admin\AddressController@destroy')->name('address.destroy');
      Route::get("/{slug}/edit", "Admin\AddressController@edit")->name("address.edit");
      Route::patch("/{slug}", "Admin\AddressController@update")->name("address.update");
    });
	
	//Occupation
    Route::prefix('occupation')->group(function(){
      Route::get('/',"Admin\OccupationController@index")->name("occupation.index");
      Route::get('/create','Admin\OccupationController@create')->name('occupation.create');
      Route::post('/store','Admin\OccupationController@store')->name('occupation.store');
      Route::delete('/{id}','Admin\OccupationController@destroy')->name('occupation.destroy');
      Route::get("/{slug}/edit", "Admin\OccupationController@edit")->name("occupation.edit");
      Route::patch("/{slug}", "Admin\OccupationController@update")->name("occupation.update");
    });
	
	//Programs
    Route::prefix('programs')->group(function(){
      Route::get('/',"Admin\ProgramController@index")->name("program.index");
      Route::get('/create','Admin\ProgramController@create')->name('program.create');
      Route::post('/store','Admin\ProgramController@store')->name('program.store');
      Route::delete('/{id}','Admin\ProgramController@destroy')->name('program.destroy');
      Route::get("/{slug}/edit", "Admin\ProgramController@edit")->name("program.edit");
      Route::patch("/{slug}", "Admin\ProgramController@update")->name("program.update");
	   /*for datatable index*/
	  Route::get('/getprograms',"Admin\ProgramController@getprograms")->name("program.getprograms");
    });
	
	//Events
    Route::prefix('events')->group(function(){
      Route::get('/',"Admin\EventsController@index")->name("events.index");
      Route::get('/create','Admin\EventsController@create')->name('events.create');
      Route::post('/store','Admin\EventsController@store')->name('events.store');
      Route::delete('/{id}','Admin\EventsController@destroy')->name('events.destroy');
      Route::get("/{slug}/edit", "Admin\EventsController@edit")->name("events.edit");
      Route::patch("/{slug}", "Admin\EventsController@update")->name("events.update");
	   /*for datatable index*/
	  Route::get('/getevents',"Admin\EventsController@getevents")->name("events.getevents");
    });
	
	//Participants for events
    Route::prefix('participants')->group(function(){
      Route::get('/',"Admin\ParticipantsController@index")->name("participants.index");
      Route::get('/create','Admin\ParticipantsController@create')->name('participants.create');
      Route::post('/store','Admin\ParticipantsController@store')->name('participants.store');
      Route::delete('/{id}','Admin\ParticipantsController@destroy')->name('participants.destroy');
      Route::get("/{slug}/edit", "Admin\ParticipantsController@edit")->name("participants.edit");
      Route::patch("/{slug}", "Admin\ParticipantsController@update")->name("participants.update");
	   /*for datatable index*/
	  Route::get('/getparticipants',"Admin\ParticipantsController@getparticipants")->name("participants.getparticipants");
    });
	
	//event participants table CRUD i.e. pivot table
    Route::prefix('eventparticipants')->group(function(){
      Route::get('/',"Admin\EventsParticipantsController@index")->name("eventparticipants.index");
      Route::get('/create','Admin\EventsParticipantsController@create')->name('eventparticipants.create');
      Route::post('/store','Admin\EventsParticipantsController@store')->name('eventparticipants.store');
      Route::delete('/{id}','Admin\EventsParticipantsController@destroy')->name('eventparticipants.destroy');
      Route::get("/{slug}/edit", "Admin\EventsParticipantsController@edit")->name("eventparticipants.edit");
      Route::patch("/{slug}", "Admin\EventsParticipantsController@update")->name("eventparticipants.update");
	   /*for datatable index*/
	  Route::get('/geteventparticipants',"Admin\EventsParticipantsController@geteventparticipants")->name("eventparticipants.geteventparticipants");
    });
	
	//Application format : आवेदन ढाँचा
    Route::prefix('abeden')->group(function(){
      Route::get('/',"Admin\AbedenController@index")->name("abeden.index");
	  Route::post('/add',"Admin\AbedenController@add")->name("abeden.add");
      Route::get('/create','Admin\AbedenController@create')->name('abeden.create');
      Route::post('/store','Admin\AbedenController@store')->name('abeden.store');
      Route::delete('/{id}','Admin\AbedenController@destroy')->name('abeden.destroy');
      Route::get("/{slug}/edit", "Admin\AbedenController@edit")->name("abeden.edit");
      Route::patch("/{slug}", "Admin\AbedenController@update")->name("abeden.update");
	   /*for datatable index*/
	  Route::get('/getabeden',"Admin\AbedenController@getabeden")->name("abeden.getabeden");
    });
	
	//Programs
    Route::prefix('distributions')->group(function(){
		Route::get('/all',"Admin\DistributionController@all")->name("distribution.all");
		Route::get('/report/{id}','Admin\DistributionController@report')->name('distribution.report');
		Route::get('/programs/{programid}',"Admin\DistributionController@index")->name("distribution.index");
		Route::get('/create','Admin\DistributionController@create')->name('distribution.create');
		Route::post('/store','Admin\DistributionController@store')->name('distribution.store');
		Route::delete('/{id}','Admin\DistributionController@destroy')->name('distribution.destroy'); //deleting temporary
		Route::get("/{slug}/edit", "Admin\DistributionController@edit")->name("distribution.edit");
		Route::patch("/{slug}", "Admin\DistributionController@update")->name("distribution.update");
		Route::get("/trash", "Admin\DistributionController@trash")->name("distribution.trash");
		Route::get("/restore/{id}", "Admin\DistributionController@restore")->name("distribution.restore"); //restoring temporary deleted row
		Route::get("/force-delete/{id}", "Admin\DistributionController@forceDelete")->name("distribution.force-delete"); //deleting permanently
		Route::get('/exclude',"Admin\DistributionController@excluding")->name("distribution.exclude");
		/*for datatable index*/     
		Route::get('/getalldistributions',"Admin\DistributionController@getalldistributions")->name("distribution.getalldistributions");
		Route::get('/getdistributions/{programid}',"Admin\DistributionController@getdistributions")->name("distribution.getdistributions");
		Route::get('/gettrasheddistributions',"Admin\DistributionController@gettrasheddistributions")->name("distribution.gettrasheddistributions");
    }); 
	
	//Tol
    Route::prefix('tol')->group(function(){
      Route::get('/',"Admin\TolController@index")->name("tol.index");
      Route::get('/create','Admin\TolController@create')->name('tol.create');
      Route::post('/store','Admin\TolController@store')->name('tol.store');
      Route::delete('/{id}','Admin\TolController@destroy')->name('tol.destroy');
      Route::get("/{slug}/edit", "Admin\TolController@edit")->name("tol.edit");
      Route::patch("/{slug}", "Admin\TolController@update")->name("tol.update");
    });
	
	Route::prefix('member')->group(function(){
      Route::get('/',"Admin\MembersController@index")->name("member.index");
	  Route::post('/check',"Admin\MembersController@check")->name("member.check");
	  //Route::get('/show/{slug}','Admin\MembersController@show')->name('member.show');
      Route::get('/create','Admin\MembersController@create')->name('member.create');
      
      Route::get('/underage','Admin\MembersController@underage')->name('member.underage');
       
      Route::post('/store','Admin\MembersController@store')->name('member.store');
      Route::delete('/{id}','Admin\MembersController@destroy')->name('member.destroy');
      Route::get("/{slug}/edit", "Admin\MembersController@edit")->name("member.edit");
      Route::patch("/{slug}", "Admin\MembersController@update")->name("member.update");
	   /*for datatable index*/
	  Route::get('/getmembers',"Admin\MembersController@getmembers")->name("member.getmembers");
	  //checking if member exists using citizenship
	  Route::post('/check-member',"Admin\MembersController@checkMember")->name("member.checkmembers");
	  
	  //update member group from member index
	  Route::post("/membergroup-update", "Admin\MembersController@updateGroup")->name("membergroups.update");
	  //add member group from member index
	  Route::post("/membergroup-add", "Admin\MembersController@addGroup")->name("membergroups.add");
	  
	  Route::get("/senior-citizen", "Admin\MembersController@seniorctzn")->name("member.seniorctzn");
	  /*for senior citizen datatables*/
	  Route::get("/getseniorcitizens", "Admin\MembersController@getseniorcitizens")->name("member.getseniorcitizens");
	  
	  Route::get("/senior-citizen-above-sixty-eight", "Admin\MembersController@seniorctznabovesixtyeight")->name("member.seniorctznabovesixtyeight");
	  /*for senior citizen betweent 68-70 datatables*/
	  Route::get("/getseniorcitzabovesiztyeight", "Admin\MembersController@getseniorcitzabovesiztyeight")->name("member.getseniorcitzabovesiztyeight");
	  
	  Route::get("/senior-citizen-sixty", "Admin\MembersController@seniorctznsixty")->name("member.seniorctznsixty");
	   /*for senior citizen above 60 datatables*/
	  Route::get("/getseniorsixty", "Admin\MembersController@getseniorsixty")->name("member.getseniorsixty");
    });
	
	/*for member contact details*/
	Route::prefix('contactdetail')->group(function(){
	Route::post("/store", "Admin\ContactDetailsController@store")->name("membercontact.store");
      Route::patch("/{slug}", "Admin\ContactDetailsController@update")->name("membercontact.update");
	});
	
	/*for member family details*/
	Route::prefix('member-family')->group(function(){
      Route::post("/store", "Admin\MemberfamilyController@store")->name("memberfamily.store");
      Route::patch("/{slug}", "Admin\MemberfamilyController@update")->name("memberfamily.update");
	});
	
	/*for member medical details*/
	Route::prefix('member-medical')->group(function(){
      Route::post("/store", "Admin\MembermedicalController@store")->name("membermedical.store");
      Route::patch("/{slug}", "Admin\MembermedicalController@update")->name("membermedical.update");
	});

	
	/*for member education details*/
	Route::prefix('membereducation')->group(function(){
		Route::post("/store", "Admin\MemberEducationController@store")->name("membereducation.store");
		Route::patch("/{slug}", "Admin\MemberEducationController@update")->name("membereducation.update");
	});
	
	/*for member medical details*/
	Route::prefix('member-documents')->group(function(){
      Route::post("/store", "Admin\MemberdocumentController@store")->name("memberdocuments.store");
      //Route::patch("/{slug}", "Admin\MemberdocumentController@update")->name("memberdocuments.update");
	});
	
	//house owner
    Route::prefix('house-owner')->group(function(){
      Route::get('/',"Admin\HouseownerController@index")->name("house.index");
	  Route::get('/remainder',"Admin\HouseownerController@remainder")->name('house.remainder');
      Route::get('/create','Admin\HouseownerController@create')->name('house.create');
      Route::post('/store','Admin\HouseownerController@store')->name('house.store');
      Route::delete('/{id}','Admin\HouseownerController@destroy')->name('house.destroy');
      Route::get("/{slug}/edit", "Admin\HouseownerController@edit")->name("house.edit");
      Route::patch("/{slug}", "Admin\HouseownerController@update")->name("house.update");
	  
	  /*for datatable index*/
	  Route::get('/gethouseowner',"Admin\HouseownerController@getHouseowner")->name("house.getHouseowner");
	  
	  Route::get('/remainder-medical',"Admin\HouseownerController@remaindermedical")->name('house.remaindermedical');
	  
	   
    });
	
	//house owner
    Route::prefix('business-house')->group(function(){
      Route::get('/',"Admin\BusinessHouseController@index")->name("business.index");
	  Route::get('/remainder',"Admin\BusinessHouseController@remainder")->name('business.remainder');
      Route::get('/create','Admin\BusinessHouseController@create')->name('business.create');
      Route::post('/store','Admin\BusinessHouseController@store')->name('business.store');
      Route::delete('/{id}','Admin\BusinessHouseController@destroy')->name('business.destroy');
      Route::get("/{slug}/edit", "Admin\BusinessHouseController@edit")->name("business.edit");
      Route::patch("/{slug}", "Admin\BusinessHouseController@update")->name("business.update");
	  
	  /*for datatable index*/
	  Route::get('/getBusinesshouse',"Admin\BusinessHouseController@getBusinesshouse")->name("business.getBusinesshouse");
    });

    //compostbin survey
    Route::prefix('compostbin-survey')->group(function(){
		Route::get('/dashboard',"Admin\CompostbinsurveyController@dashboard")->name("cbinsurvey.dashboard");
		Route::get('/',"Admin\CompostbinsurveyController@index")->name("cbinsurvey.index");      
		Route::get('/create','Admin\CompostbinsurveyController@create')->name('cbinsurvey.create');
		Route::get('/exclude',"Admin\CompostbinsurveyController@excluding")->name("cbinsurvey.exclude");
		Route::get('/add','Admin\CompostbinsurveyController@add')->name('cbinsurvey.add'); //temporary route
		Route::post('/added','Admin\CompostbinsurveyController@added')->name('cbinsurvey.added'); //temporary route
		Route::post('/saved','Admin\CompostbinsurveyController@saved')->name('cbinsurvey.saved'); //temporary route
		Route::post('/store','Admin\CompostbinsurveyController@store')->name('cbinsurvey.store');
		Route::delete('/{id}','Admin\CompostbinsurveyController@destroy')->name('cbinsurvey.destroy');
		Route::get("/{slug}/edit", "Admin\CompostbinsurveyController@edit")->name("cbinsurvey.edit");
		Route::patch("/{slug}", "Admin\CompostbinsurveyController@update")->name("cbinsurvey.update");
		/*for datatable index*/
		Route::get('/getcompostbinsurvey',"Admin\CompostbinsurveyController@getCompostbinsurveys")->name("cbinsurvey.getCompostbinsurveys");
		
		//getting compostbin survey that has compost usage as true i.e. 0
		Route::get('/cbintrue',"Admin\CompostbinsurveyController@cbintrue")->name("cbinsurvey.cbintrue"); 
		/*for datatable index*/
		Route::get('/getCompostbintrue',"Admin\CompostbinsurveyController@getCompostbintrue")->name("cbinsurvey.getCompostbintrue");
	  
    });
	
	//compostbin survey
    Route::prefix('medical-survey')->group(function(){
		Route::get('/dashboard',"Admin\MedicalSurveyController@dashboard")->name("medsurvey.dashboard");
		Route::get('/',"Admin\MedicalSurveyController@index")->name("medsurvey.index");      
		Route::get('/create','Admin\MedicalSurveyController@create')->name('medsurvey.create');
		Route::post('/store','Admin\MedicalSurveyController@store')->name('medsurvey.store');
		Route::delete('/{id}','Admin\MedicalSurveyController@destroy')->name('medsurvey.destroy');
		Route::get("/{slug}/edit", "Admin\MedicalSurveyController@edit")->name("medsurvey.edit");
		Route::get("/{slug}/show", "Admin\MedicalSurveyController@show")->name("medsurvey.show");
		Route::patch("/{slug}", "Admin\MedicalSurveyController@update")->name("medsurvey.update");
		/*for datatable index*/
		Route::get('/getmedicalsurvey',"Admin\MedicalSurveyController@getmedicalsurvey")->name("medsurvey.getmedicalsurvey");
		
		/*temp route for checking query result*/
		Route::get('/query-test',"Admin\MedicalSurveyController@test")->name("medsurvey.test");	
		
		/*for child under 45 days*/
		Route::get('/childunder45','Admin\MedicalSurveyController@childunder45')->name('medsurvey.childunder45');
		Route::get('/getchildunder45','Admin\MedicalSurveyController@getchildunder45')->name('medsurvey.getchildunder45');
		
		/*for seniors above or equal to 68 years*/
		Route::get('/seniorabove68','Admin\MedicalSurveyController@seniorabove68')->name('medsurvey.seniorabove68');
		Route::get('/getseniorabove68','Admin\MedicalSurveyController@getseniorabove68')->name('medsurvey.getseniorabove68');
	  
    });
	
	//member group
	Route::prefix('member-group')->group(function(){
		Route::get('/','Admin\MembergroupController@index')->name("membergroup.index");
		Route::get('/create','Admin\MembergroupController@create')->name('membergroup.create');
		Route::get("/{slug}", "Admin\MembergroupController@show")->name("membergroup.show");
		Route::post('/store','Admin\MembergroupController@store')->name('membergroup.store');
		Route::patch("/update", "Admin\MembergroupController@update")->name("membergroup.update");		
	});
	
	//member abeden
	Route::prefix('member-abedan')->group(function(){
		Route::get('/','Admin\MembersabedanController@index')->name("abedan.index"); 
		 /*for datatable index*/
		Route::get('/getmembersabedan',"Admin\MembersabedanController@getMemberabeden")->name("membersabeden.getmembersabedan");
		Route::get('/view/{slug}','Admin\MembersabedanController@show')->name('membersabeden.show');
		//Route::get("/{slug}", "Admin\MembergroupController@show")->name("membergroup.show");
		//Route::post('/store','Admin\MembergroupController@store')->name('membergroup.store');
		//Route::patch("/update", "Admin\MembergroupController@update")->name("membergroup.update");		
	});
	
	//member abeden
	Route::prefix('member-sifaris')->group(function(){
		Route::get('/','Admin\MembersifarisController@index')->name("sifaris.index"); 
		 /*for datatable index*/
		Route::get('/getmembersifaris',"Admin\MembersifarisController@getMembersifaris")->name("membersifaris.getmembersifaris");
		Route::get('/view/{slug}','Admin\MembersifarisController@show')->name('membersifaris.show');
		//Route::get('/create','Admin\MembergroupController@create')->name('membergroup.create');
		//Route::get("/{slug}", "Admin\MembergroupController@show")->name("membergroup.show");
		//Route::post('/store','Admin\MembergroupController@store')->name('membergroup.store');
		//Route::patch("/update", "Admin\MembergroupController@update")->name("membergroup.update");		
	});
	
	//Ward Profile API
/**	Route::prefix('profile')->group(function(){
		Route::get('/','WardProfileAPI\ProfileController@femaleProfile')->name('ward.profile');
	}); **/
	
	//generating sifaris from abedan index
	Route::get('/createsifaris/{memberid}/{memberabedanid}/{abedanid}','Admin\MembersabedanController@sifaris')->name('membersabeden.sifaris');
	
	//send sms
	Route::prefix('message')->group(function(){
		Route::get('/','Admin\MessageController@index')->name("message.index");
		Route::get('/create','Admin\MessageController@create')->name('message.create');
		Route::post('/store','Admin\MessageController@store')->name('message.store');
		Route::patch("/update", "Admin\MessageController@update")->name("message.update");
	});
	
	
	//send sms
	Route::prefix('sendsms')->group(function(){
		Route::get('/','Admin\SendsmsController@index')->name("sendsms.index");
		Route::post('/forward','Admin\SendsmsController@forward')->name("sendsms.forward");
	});
	
	//survey inspection
	Route::prefix('survey-inspection')->group(function(){
	    Route::get('/dashboard',"Admin\SurveyInspectionController@dashboard")->name("sinspection.dashboard");
		Route::get('/','Admin\SurveyInspectionController@index')->name("sinspection.index");
		Route::get('/create','Admin\SurveyInspectionController@create')->name("sinspection.create");
		Route::post('/store','Admin\SurveyInspectionController@store')->name("sinspection.store");
		//get inspection depending on house no ajax
		
		Route::get('/getinspectiondetail','Admin\SurveyInspectionController@getinspectiondetail')->name("sinspection.getinspectiondetail");
	});
	
  }
);
