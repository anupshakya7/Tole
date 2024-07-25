<?php

namespace App\Http\Controllers;

use DB;
use App\Tol;
use App\Houseowner;
use App\User;
use App\Member;
use App\Compostbinsurvey;
use App\MedicalSurvey;
use App\SurveyInspection;
use App\Distribution;
use App\ActivityLog;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	/*impersonate*/
	public function impersonate($user_id)
	{
		$user = User::find($user_id);
		\Auth::user()->impersonate($user);
		return redirect()->route('admin.home');
	}
	
	public function impersonate_leave()
	{
		\Auth::user()->leaveImpersonation();
		return redirect()->route('admin.home');
	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
		if(auth()->user()->hasRole('surveyer')):
			return $this->surveyer();
		endif;
		
		if(auth()->user()->hasRole('medical')):
			return $this->medical();
		endif;
		
		if(auth()->user()->hasRole('report')):
			return $this->userreport();
		endif;
		
		if(auth()->user()->hasRole('members_house')):
		    //dd('test');
			return $this->membershouse();
		endif;
		
		
		$today = Carbon::today();
		/*getting the number of surveys done by different users for displaying in chart*/
		$compbinbyuser = DB::select( DB::raw("select house_no, user_id,id,count(id) as survey_done from compostbinsurveys cs GROUP BY cs.user_id order by count(id) DESC") );
		
		/*getting the number of surveys done by different users by today for displaying in chart*/
		$compbinbyusertoday = DB::select( DB::raw("select house_no, user_id,id,count(id) as survey_done from compostbinsurveys where Date(created_at) = '$today' GROUP BY user_id order by count(id) DESC") );
		//var_dump($compbinbyusertoday);
				
		/*getting users and their surveys according to compostbin_usage i.e. yes or no*/
		$users = DB::select(DB::raw('select cs.user_id,u.name from compostbinsurveys cs LEFT JOIN users u on u.id=cs.user_id group by cs.user_id'));
		$arrayyes = array();
		$arrayno = array();
		$arrayna = array();
		foreach($users as $data){
			$user = $data->user_id;
			
			$usercompstyes = DB::select(DB::raw('select count(id) as totalyes from compostbinsurveys where user_id='.$user.' and compostbin_usage=0'));
			
			$usercompstno = DB::select(DB::raw('select count(id) as totalno from compostbinsurveys where user_id='.$user.' and compostbin_usage=1'));
			
			foreach($usercompstyes as $data){
				array_push($arrayyes,$data->totalyes);
			}
			
			foreach($usercompstno as $data){
				array_push($arrayno,$data->totalno);
			}
		}
		
		/*getting surveys done according to address*/
		$suaddress = DB::select(DB::raw('select count(cs.id) as surveys,cs.road,ad.address_np as location from compostbinsurveys cs LEFT JOIN address ad on ad.id=cs.road GROUP BY cs.road'));
		//dd($suaddress);
		$addressyes = array();
		$addressno = array();
		foreach($suaddress as $add){
			$road = $add->road;			
			$roadyes = DB::select(DB::raw('select count(id) as totalyes from compostbinsurveys where road='.$road.' and compostbin_usage=0'));			
			$roadno = DB::select(DB::raw('select count(id) as totalno from compostbinsurveys where road='.$road.' and compostbin_usage=1'));
			
			foreach($roadyes as $data){
				array_push($addressyes,$data->totalyes);
			}
			
			foreach($roadno as $data){
				array_push($addressno,$data->totalno);
			}
		}
		
		//dd($addressyes);
		
		/*getting surveys done according to tol*/
		$surveytol = DB::select(DB::raw('select count(cs.id) as surveys,cs.tol,t.tol_np as tolname from compostbinsurveys cs LEFT JOIN tol t on t.id=cs.tol GROUP BY cs.tol'));
		$tolyess = array();$tolnoo = array();
		foreach($surveytol as $stol){
			$tol = $stol->tol;			
			$tolyes = DB::select(DB::raw('select count(id) as totalyes from compostbinsurveys where tol='.$tol.' and compostbin_usage=0'));			
			$tolno = DB::select(DB::raw('select count(id) as totalno from compostbinsurveys where tol='.$tol.' and compostbin_usage=1'));
			
			foreach($tolyes as $data){
				array_push($tolyess,$data->totalyes);
			}
			
			foreach($tolno as $data){
				array_push($tolnoo,$data->totalno);
			}
		}
		
		/*getting survey data for chart according to dates*/
		//$surveybydate = DB::select(DB::raw('SELECT count(id) as total, created_at FROM `compostbinsurveys` WHERE date(created_at) GROUP BY date(created_at)'));
		//dd($surveybydate);		
		//$surveys = Compostbinsurvey::latest()->take(10)->get();		
		$totsurvey = Compostbinsurvey::count();	
		/*getting members count according to age range*/
		$membersage = DB::select(DB::raw('SELECT CASE WHEN age < 20 THEN "Under 20" WHEN age BETWEEN 20 and 29 THEN "20 - 29" WHEN age BETWEEN 30 and 39 THEN "30 - 39" WHEN age BETWEEN 40 and 49 THEN "40 - 49" WHEN age BETWEEN 50 and 59 THEN "50 - 59" WHEN age BETWEEN 60 and 69 THEN "60 - 69" WHEN age BETWEEN 70 and 79 THEN "70 - 79" WHEN age >= 80 THEN "Over 80" WHEN age IS NULL THEN "Not Filled In (NULL)" END as age_range, COUNT(*) AS age_count, CASE WHEN age < 20 THEN 1 WHEN age BETWEEN 20 and 29 THEN 2 WHEN age BETWEEN 30 and 39 THEN 3 WHEN age BETWEEN 40 and 49 THEN 4 WHEN age BETWEEN 50 and 59 THEN 5 WHEN age BETWEEN 60 and 69 THEN 6 WHEN age BETWEEN 70 and 79 THEN 7 WHEN age >= 80 THEN 8 WHEN age IS NULL THEN 9 END as ordinal FROM (SELECT TIMESTAMPDIFF(YEAR, dob_ad, CURDATE()) AS age FROM members) as derived GROUP BY age_range ORDER BY ordinal'));
		
		/*getting members according to occupation*/
		$membersoccupation = DB::select(DB::raw('SELECT count(m.id) as total, o.occupation_np as occupation from members m LEFT JOIN occupation o on m.occupation_id=o.id group by m.occupation_id'));
		
		/*getting members count according to blood group*/
		$memberbybloodgrp = DB::select(DB::raw('SELECT count(id) as total, blood_group from members GROUP BY blood_group'));
		
		$years=date('Y-m-d', strtotime("-60 years"));
		$totalsenior = Member::with(['user','contacts','addresses','tols','job','groups','mabedans'])->where(DB::raw('date(dob_ad)'),'<=',$years)->where('dob_ad','!=','N/A')->count();
		
		//dd($totalsenior);
		
		$femaleowner = Houseowner::where('gender','1')->count();
		$totalowner = Houseowner::count();
		
		$this->setPageTitle("Dashboard", "");
		return view('home-new',compact('totalsenior','femaleowner','totalowner',
		'totsurvey','compbinbyuser','users','arrayyes','arrayno','suaddress','surveytol',
		'compbinbyusertoday','addressyes','addressno','tolyess','tolnoo','membersage',
		'membersoccupation','memberbybloodgrp'));//,compact('customer','order','sales','activity','orders','bestsellerproduct'));
		
    }
	
	public function userreport()
	{
		$today = Carbon::today();
		
		/*getting the number of surveys done by different users for displaying in chart*/
		$medicalbyuser = DB::select( DB::raw("select house_no, user_id,id,count(id) as survey_done from medical_survey cs GROUP BY cs.user_id order by count(id) DESC") );
		
		/*getting users and their surveys according to compostbin_usage i.e. yes or no*/
		$users = DB::select(DB::raw('select cs.user_id,u.name from medical_survey cs LEFT JOIN users u on u.id=cs.user_id group by cs.user_id'));
		$arrayyes = array();
		$arrayno = array();
		foreach($users as $data){
			$user = $data->user_id;
			
			$usercompstyes = DB::select(DB::raw('select count(id) as totalyes from medical_survey where user_id='.$user.' and elderly_exist=1'));
			
			$usercompstno = DB::select(DB::raw('select count(id) as totalno from medical_survey where user_id='.$user.' and elderly_exist=2'));
			
			foreach($usercompstyes as $data){
				array_push($arrayyes,$data->totalyes);
			}
			
			foreach($usercompstno as $data){
				array_push($arrayno,$data->totalno);
			}
		}
		
		/*getting the number of surveys done by different users by today for displaying in chart*/
		$medicalusertoday = DB::select( DB::raw("select house_no, user_id,id,count(id) as survey_done from medical_survey where Date(created_at) = '$today' GROUP BY user_id order by count(id) DESC") );
		
		/*getting surveys done according to address*/
		$suaddress = DB::select(DB::raw('select count(ms.id) as surveys,ms.road,ad.address_np as location from medical_survey ms LEFT JOIN address ad on ad.id=ms.road GROUP BY ms.road'));
		
		//dd(MedicalSurvey::remainderhouse());
		/*getting surveys done according to tol*/
		$surveytol = DB::select(DB::raw('select count(ms.id) as surveys,ms.tol,t.tol_np as tolname from medical_survey ms LEFT JOIN tol t on t.id=ms.tol GROUP BY ms.tol'));
		
		/*getting survey data according to chronic disease name by road*/
		$testquery = DB::select(DB::raw("
			select ms.road,address_np,
				count(if(ms.chronic_disease_name LIKE '%उच्च रक्तचाप%',1,null)) as high_bp,
				count(if(ms.chronic_disease_name LIKE '%थाइरोइड%',1,null)) as thyroid,
				count(if(ms.chronic_disease_name LIKE '%मधुमेह%',1,null)) as sugar,
				count(if(ms.chronic_disease_name LIKE '%हाडजोर्नी तथा मांसापेशी दुखाई%',1,null)) as joint_pain,
				count(if(ms.chronic_disease_name LIKE '%क्यान्सर%',1,null)) as cancer,
			    count(if(ms.chronic_disease_name LIKE '%पक्षाघात%',1,null)) as paralysis,
				count(if(ms.chronic_disease_name LIKE '%मृगौला डायलाइसिस%',1,null)) as kidney_dialysis,
				count(if(ms.chronic_disease_name LIKE '%आँखा सम्बन्धि समस्या%',1,null)) as eye_problem,
				count(if(ms.chronic_disease_name LIKE '%कान सम्बन्धि समस्या%',1,null)) as ear_problem,
				count(if(ms.chronic_disease_name LIKE '%मुख सम्बन्धि स्वास्थ्य समस्या%',1,null)) as mouth_problem,
				count(if(ms.chronic_disease_name LIKE '%अपाङ्गतां%',1,null)) as physical_disability,
				count(if(ms.chronic_disease_name is null ,1,null)) as no_disease
			from medical_survey ms
			left join address a on a.id=ms.road
			group by ms.road"));
		
		$chronicdisease1 = array();
		foreach($testquery as $data){
			foreach($data as $i=>$val){
				isset($chronicdisease1[$i]) ? '':$chronicdisease1[$i]=array();
				$chronicdisease1[$i][] = $val;
			}
		}
		
		/*getting survey data according to chronic disease name by tol*/
		$testquery2 = DB::select(DB::raw("
			select ms.tol,tol_np,
				count(if(ms.chronic_disease_name LIKE '%उच्च रक्तचाप%',1,null)) as high_bp,
				count(if(ms.chronic_disease_name LIKE '%थाइरोइड%',1,null)) as thyroid,
				count(if(ms.chronic_disease_name LIKE '%मधुमेह%',1,null)) as sugar,
				count(if(ms.chronic_disease_name LIKE '%हाडजोर्नी तथा मांसापेशी दुखाई%',1,null)) as joint_pain,
				count(if(ms.chronic_disease_name LIKE '%क्यान्सर%',1,null)) as cancer,
			    count(if(ms.chronic_disease_name LIKE '%पक्षाघात%',1,null)) as paralysis,
				count(if(ms.chronic_disease_name LIKE '%मृगौला डायलाइसिस%',1,null)) as kidney_dialysis,
				count(if(ms.chronic_disease_name LIKE '%आँखा सम्बन्धि समस्या%',1,null)) as eye_problem,
				count(if(ms.chronic_disease_name LIKE '%कान सम्बन्धि समस्या%',1,null)) as ear_problem,
				count(if(ms.chronic_disease_name LIKE '%मुख सम्बन्धि स्वास्थ्य समस्या%',1,null)) as mouth_problem,
				count(if(ms.chronic_disease_name LIKE '%अपाङ्गतां%',1,null)) as physical_disability,
				count(if(ms.chronic_disease_name is null ,1,null)) as no_disease
			from medical_survey ms
			left join tol a on a.id=ms.tol
			group by ms.tol"));
			
		$chronicbytol = array();
		foreach($testquery2 as $data){
			foreach($data as $i=>$val){
				isset($chronicbytol[$i]) ? '':$chronicbytol[$i]=array();
				$chronicbytol[$i][] = $val;
			}
		}	
		//dd($chronicbytol);
		//$chronicdisease = DB::select(DB::raw('select count(id) as total,chronic_disease_name from medical_survey where chronic_disease_name is not null GROUP BY chronic_disease_name'));
		$cdisease = DB::select(DB::raw("
			select
				count(if(ms.chronic_disease_name LIKE '%उच्च रक्तचाप%',1,null)) as high_bp,
				count(if(ms.chronic_disease_name LIKE '%थाइरोइड%',1,null)) as thyroid,
				count(if(ms.chronic_disease_name LIKE '%मधुमेह%',1,null)) as sugar,
				count(if(ms.chronic_disease_name LIKE '%हाडजोर्नी तथा मांसापेशी दुखाई%',1,null)) as joint_pain,
				count(if(ms.chronic_disease_name LIKE '%क्यान्सर%',1,null)) as cancer,
			    count(if(ms.chronic_disease_name LIKE '%पक्षाघात%',1,null)) as paralysis,
				count(if(ms.chronic_disease_name LIKE '%मृगौला डायलाइसिस%',1,null)) as kidney_dialysis,
				count(if(ms.chronic_disease_name LIKE '%आँखा सम्बन्धि समस्या%',1,null)) as eye_problem,
				count(if(ms.chronic_disease_name LIKE '%कान सम्बन्धि समस्या%',1,null)) as ear_problem,
				count(if(ms.chronic_disease_name LIKE '%मुख सम्बन्धि स्वास्थ्य समस्या%',1,null)) as mouth_problem,
				count(if(ms.chronic_disease_name LIKE '%अपाङ्गतां%',1,null)) as physical_disability,
				count(if(ms.chronic_disease_name is null ,1,null)) as no_disease
			from medical_survey ms"));
			
		$chronicdisease = array();
		foreach($cdisease as $data){
			foreach($data as $i=>$val){
				isset($chronicdisease[$i]) ? '':$chronicdisease[$i]=array();
				$chronicdisease[$i] = $val;
			}
		}
		//dd(MedicalSurvey::pneumoniabytol());
		$ownershipdata = DB::select(DB::raw('select count(id) as total, ownership from medical_survey GROUP BY ownership'));
		
		$this->setPageTitle("Dashboard", "");
		
		return view('admin.medsurvey.dashboard',compact('chronicdisease1','chronicbytol','medicalbyuser','medicalusertoday','suaddress','surveytol','ownershipdata','users','arrayyes','arrayno','chronicdisease'));
	}
	
	public function surveyer()
	{
		$user = auth()->user()->id;
			
		//dd($orders);
		$totsurvey = Compostbinsurvey::where('user_id',\Auth::user()->id)->count();	
		
		$totinspection = SurveyInspection::where('user_id',\Auth::user()->id)->count();	
		
		$surveys = SurveyInspection::latest()->where('user_id',\Auth::user()->id)->take(10)->get();
		
		//survey done today
		$todaysurvey = \App\Compostbinsurvey::where([['user_id',\Auth::user()->id]])->whereDate('created_at',\Carbon::today())->count();
		
	    $todayinspection = \App\SurveyInspection::where([['user_id',\Auth::user()->id]])->whereDate('created_at',\Carbon::today())->count();
		
		/*getting users and their surveys according to compostbin_usage i.e. yes or no*/			
		$usercompstyes = DB::select(DB::raw('select count(id) as totalyes from survey_inspection where user_id='.\Auth::user()->id.' and `usage`="0"'));			
		$usercompstno = DB::select(DB::raw('select count(id) as totalno from survey_inspection where user_id='.\Auth::user()->id.' and `usage`="1"'));
			
		
		$maleowner = Houseowner::where('gender','0')->count();
		$femaleowner = Houseowner::where('gender','1')->count();
		$unaccounted = Houseowner::whereNull('gender')->count();
		
		$this->setPageTitle("Dashboard", "");
		return view('surveyer',compact('surveys','totsurvey','totinspection','maleowner','todayinspection','femaleowner','unaccounted','todaysurvey','usercompstyes','usercompstno'));
	}	
	
	public function medical()
	{
		$user = auth()->user()->id;
		
		/*getting total children less or equal to 5 years old number*/
		$totalchild5 = MedicalSurvey::child();
		
		/*getting total senior citizens number*/
		$totalseniorcitizen = MedicalSurvey::senior();
		
		$totsurvey = MedicalSurvey::where('user_id',\Auth::user()->id)->count();			
		$surveys = MedicalSurvey::latest()->where('user_id',\Auth::user()->id)->take(10)->get();
		//survey done today
		$todaysurvey = \App\MedicalSurvey::where([['user_id',\Auth::user()->id]])->whereDate('created_at',\Carbon::today())->count();
		
		/*getting users and their surveys according to compostbin_usage i.e. yes or no*/			
		$elderlyyes = DB::select(DB::raw('select count(id) as totalyes from medical_survey where elderly_exist=1 and user_id='.\Auth::user()->id));			
		$elderlyno = DB::select(DB::raw('select count(id) as totalno from medical_survey where elderly_exist=2 and user_id='.\Auth::user()->id));
			
		
		$this->setPageTitle("Dashboard", "");
		return view('medical',compact('surveys','totsurvey','todaysurvey','elderlyyes','elderlyno','totalchild5','totalseniorcitizen'));
	}
	
	//for role members_house
	public function membershouse()
	{	
		$this->setPageTitle("Dashboard", "");
		return view('membershouse');
	}
	
	public function surveyer_old()
	{
		$user = auth()->user()->id;
			
		//dd($orders);
		$totsurvey = Compostbinsurvey::where('user_id',\Auth::user()->id)->count();			
		$surveys = Compostbinsurvey::latest()->where('user_id',\Auth::user()->id)->take(10)->get();
		
		//survey done today
		$todaysurvey = \App\Compostbinsurvey::where([['user_id',\Auth::user()->id]])->whereDate('created_at',\Carbon::today())->count();
		
		/*getting users and their surveys according to compostbin_usage i.e. yes or no*/			
		$usercompstyes = DB::select(DB::raw('select count(id) as totalyes from compostbinsurveys where user_id='.\Auth::user()->id.' and compostbin_usage=0'));			
		$usercompstno = DB::select(DB::raw('select count(id) as totalno from compostbinsurveys where user_id='.\Auth::user()->id.' and compostbin_usage=1'));
			
		
		$maleowner = Houseowner::where('gender','0')->count();
		$femaleowner = Houseowner::where('gender','1')->count();
		$unaccounted = Houseowner::whereNull('gender')->count();
		
		$this->setPageTitle("Dashboard", "");
		return view('surveyer',compact('surveys','totsurvey','maleowner','femaleowner','unaccounted','todaysurvey','usercompstyes','usercompstno'));
	}	

    //check slug
    public function check_slug(Request $request){

        $slug = Str::slug($request->title);
        return response()->json(['slug'=>$slug]);
    }
	
	//changing the notification status to viewed
	public function viewed($id)
	{
		$log = ActivityLog::find($id);
		//dd($log);
		$currdate = date('Y-m-d G:i:s');
		
		$update = DB::statement("UPDATE activity_log SET viewed_at = '".$currdate."' where id=".$id);
		//dd($update);
		if($update):
			return back();
		else:
			return back();
		endif;
			
		
	}
	
	//controller to send data on ajax call for admin notifications
	public function notifications()
	{
		$logs = ActivityLog::where(['log_name' => 'default','viewed_at' => NULL])->orderBy('created_at','DESC')->get();
		return response()->json($logs);
	}
	
	//controller to send data on ajax call for technician notifications
	public function technotifications()
	{
		$logs = Installation::where(['status' => 0,'user_id' => $user,'accepted'=>0])->get();
		
		return response()->json($logs);
	}

	//checking if owner exists using houseid
	public function checkHouse(Request $request)
	{
		if($request->ajax()){
			$data = $request->all();
			$survey = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->exists();
			
			if($survey){
				
				$msg = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])
							->leftJoin('users','compostbinsurveys.user_id','=','users.id')
							->leftJoin('address','compostbinsurveys.road','=','address.id')
							->select('compostbinsurveys.created_at','users.name','address.address_np')->first();
							
				$message =  $msg->address_np."मा भएको घर नम्बर  ".$data['house_no']." को सर्वेक्षण ".$msg->name." द्वारा ".$msg->created_at->toFormattedDateString()." मा भइसकेको छ";
				$data = array("error"=>$message);
				echo json_encode($data);
			}else{
				$owner = Houseowner::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
				if(!empty($owner)){
					echo $owner;
				}
			}	

		}
	}
	
	//checking if house_no exixts in house_owner table
	public function checkOwner(Request $request)
	{
		if($request->ajax())
		{
			$data = $request->all();

			$house = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->exists();
			if($house)
			{
				$check = Distribution::where([['house_no',$data['house_no']],['road',$data['road']],['program_id',$data['program']]])
							->leftJoin('users','distributions.user_id','=','users.id')
							->leftJoin('address','distributions.road','=','address.id')
							->select('distributions.received_at','distributions.registered_at','distributions.created_at','users.name')->first();
				
				if($check){
					$message =  'घर नम्बर '.$data['house_no']." को वितरण डाटा  मिति ".$check->registered_at.' मा दर्ता भएर मिति '.$check->received_at." मा वितरण भइसकेको छ ";//.$check->created_at->toFormattedDateString()." मा प्रविष्टि भइसकेको छ";
					$survey = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
					$data = array("error"=>$message,'message'=>$survey);
					echo json_encode($data);
				}else{
					$survey = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
					if(!empty($survey)){
						echo $survey;
					}
				}
				/*$survey = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
					if(!empty($survey)){
						echo $survey;
					}*/
				
			}else{
				$message = 'माफ गर्नुहोस् तर घर नम्बर '.$data['house_no'].' हाम्रो प्रणालीमा छैन!';
				$data = array('error'=>$message);
				echo json_encode($data);
			}
		}
	}
	
	//checking if house_no exixts in house_owner table
	public function checkOwner2(Request $request)
	{
		if($request->ajax())
		{
			$data = $request->all();

			$house = Houseowner::where([['house_no',$data['house_no']],['road',$data['road']]])->exists();
			if($house)
			{
				$check = Distribution::where([['house_no',$data['house_no']],['road',$data['road']],['program_id',$data['program']]])
							->leftJoin('users','distributions.user_id','=','users.id')
							->leftJoin('address','distributions.road','=','address.id')
							->leftJoin('programs','distributions.program_id','=','programs.id')
							->select('distributions.received_at','programs.title_np','distributions.registered_at','distributions.created_at','users.name')->first();
				
				if($check){
					$message =  'घर नम्बर '.$data['house_no']." को ".$check->title_np." वितरण डाटा  मिति ".$check->registered_at.' मा दर्ता भएर मिति '.$check->received_at." मा वितरण भइसकेको छ ";//.$check->created_at->toFormattedDateString()." मा प्रविष्टि भइसकेको छ";
					$survey = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
					$data = array("error"=>$message,'message'=>$survey);
					echo json_encode($data);
				}else{
					$survey = Houseowner::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
					if(!empty($survey)){
						echo $survey;
					}
				}
				/*$survey = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
					if(!empty($survey)){
						echo $survey;
					}*/
				
			}else{
				$message = 'माफ गर्नुहोस् तर घर नम्बर '.$data['house_no'].' हाम्रो प्रणालीमा छैन!';
				$data = array('error'=>$message);
				echo json_encode($data);
			}
		}
	}
	
	//checking if member exists on member table
	public function checkMember(Request $request)
	{
		if($request->ajax())
		{
			$data = $request->all();
			//echo $data;
			$check = Compostbinsurvey::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
			//echo $check;
			if($check){
				//$data = array("error"=>$message);
				echo json_encode($check);
			}else{
				$data = array("error"=>"error");
				echo json_encode($data);
			}
		}
	}
	
	/*getting list off road depending on house_no*/
	public function checkRoads(){
		if(isset($_GET)){
			$id= $_GET['id'];
			if(isset($_GET['type'])){
				$roads = DB::select(DB::raw('select ad.id,ad.address_np from compostbinsurveys cs left join address ad on cs.road=ad.id where cs.house_no="'.$id.'" GROUP BY cs.road'));
				//dd('select ad.id,ad.address_np from compostbinsurveys cs left join address ad on cs.road=ad.id where cs.house_no="'.$id.'" GROUP BY cs.road');
			}else{
				$roads = DB::select(DB::raw('select ad.id,ad.address_np from compostbinsurveys ho left join address ad on ho.road=ad.id where ho.house_no="'.$id.'" GROUP BY ho.road'));
			}
			
			if(!empty($roads)){ 
				foreach($roads as $rd){
					echo '<option value="'.$rd->id.'">'.$rd->address_np.'</option>';
				} 
			}else{
				$address = \App\Address::latest()->get();
				
				return response()->json(['error'=>'error','address'=>$address]);
			}
			
		}
	}
	
	public function checkRoads2(){
		if(isset($_GET)){
			$id= $_GET['id'];
			if(isset($_GET['type'])){
				$roads = DB::select(DB::raw('select ad.id,ad.address_np from house_owner cs left join address ad on cs.road=ad.id where cs.house_no="'.$id.'" GROUP BY cs.road'));
				//dd('select ad.id,ad.address_np from compostbinsurveys cs left join address ad on cs.road=ad.id where cs.house_no="'.$id.'" GROUP BY cs.road');
			}else{
				$roads = DB::select(DB::raw('select ad.id,ad.address_np from house_owner ho left join address ad on ho.road=ad.id where ho.house_no="'.$id.'" GROUP BY ho.road'));
			}
			
			if(!empty($roads)){ 
				foreach($roads as $rd){
					echo '<option value="'.$rd->id.'">'.$rd->address_np.'</option>';
				} 
			}else{
				$address = \App\Address::latest()->get();
				
				return response()->json(['error'=>'error','address'=>$address]);
			}
			
		}
	}

	//checking if owner exists using houseid for medical survey
	public function houseCheck(Request $request)
	{
		if($request->ajax()){
			$data = $request->all();
			$owner = Houseowner::select('id','house_no','owner','owner_np','mobile','tol','road')->where([['house_no',$data['house_no']],['road',$data['road']]])->first();
			$elder=[];
			if(isset($data['elder'])){
				$years=date('Y-m-d', strtotime("-60 years"));
				$elder = Member::select('full_name','citizenship')->where([['house_no',$data['house_no']],['road',$data['road']]])->where(DB::raw('date(dob_ad)'),'<=',$years)->get();
			}


			if(!empty($owner)){
				//echo $owner;
				return response()->json([
					'exist' => 'exist',
					'owner'=>$owner,
					'elder'=>$elder
				]);
				//$data = array("exist"=>"exist");
				//echo json_encode($data);
			}else{
				$message =  'घर नम्बर '.$data['house_no'].' हाम्रो प्रणालीमा दर्ता गरिएको छैन';
				return response()->json([
					'noexist' => 'noexist',
					'message'=>$message
				]);
			}

		}
	}	
	
	public function checkcompostbin(Request $request)
	{
		if($request->ajax()){
			$data = $request->all();
			$check = Houseowner::select('id','house_no','owner','owner_np','mobile','tol','road')->where([['house_no',$data['house_no']],['road',$data['road']]])->first();
			
			
			if(!empty($check)){
				//echo $owner;
				return response()->json([
					'exist' => 'exist',
					'check'=>$check,
				]);
				//$data = array("exist"=>"exist");
				//echo json_encode($data);
			}else{
				$message =  'घर नम्बर '.$data['house_no'].' हाम्रो प्रणालीमा दर्ता गरिएको छैन';
				
				return response()->json([
					'noexist' => 'noexist',
					'message'=>$message
				]);
			}

		}
	}
	
	//retrieve house owner name using house_no, road and tol from business-house/create view
	public function checkHouseBusiness(Request $request)
	{
	    if($request->ajax()){
			$data = $request->all();
			$check = Houseowner::select('owner','owner_np','contact')->where([['house_no',$data['house_no']],['road',$data['road']],['tol',$data['tol']]])->first();
							
			if(!empty($check)){
			    $message =  'घर नं '.$data['house_no'].' को मालिक '.$check->owner.' हुनुहुन्छ ।';
				//echo $owner;
				return response()->json([
					'exist' => 'exist',
					'message'=>$message,
				]);
				//$data = array("exist"=>"exist");
				//echo json_encode($data);
			}else{
				$message =  'घर नम्बर '.$data['house_no'].' हाम्रो प्रणालीमा दर्ता गरिएको छैन';
				
				return response()->json([
					'noexist' => 'noexist',
					'message'=>$message
				]);
			}

		}    
	}

	public function checkcbinowner(Request $request)
	{
		if($request->ajax()){
			$data = $request->all();
			//$check = Houseowner::where([['house_no',$data['house_no']],['road',$data['road']]])->first();
			//$check = DB::select(DB::raw('select ho.*,cs.compostbin_usage from house_owner ho left join compostbinsurveys cs on cs.house_no=ho.house_no where ho.house_no="'.$data['house_no'].'" and ho.road="'.$data['road'].'" group by cs.id'));
			$check = Houseowner::join('compostbinsurveys', function ($join) use($data){
                $join->on('house_owner.house_no', '=', 'compostbinsurveys.house_no')
                ->where('house_owner.house_no', '=', $data['house_no'])
                ->where('house_owner.road', '=', $data['road']);
                })->first();
			
			if(!empty($check)){
				//echo $owner;
				//$check = (object)$check;
				return response()->json([
					'exist' => 'exist',
					'check'=>$check,
				]);
				//$data = array("exist"=>"exist");
				//echo json_encode($data);
			}else{
				$message =  'घर नम्बर '.$data['house_no'].' हाम्रो प्रणालीमा दर्ता गरिएको छैन';
				
				return response()->json([
					'noexist' => 'noexist',
					'message'=>$message
				]);
			}

		}
	}	
	
	public function switchmode()
	{
		if(session()->has('isDark')){
			session()->put('isDark',!session('isDark'));
		}else{
			session()->put('isDark',true);
		}
		
		return redirect()->route('admin.home');
	}
}
