<?php

namespace App\Http\Controllers\Admin;

use App\MedicalSurvey;
use App\Address;
use App\Tol;
use App\SeniorCitizen;
use App\Contactdetail;
use App\Member;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class MedicalSurveyController extends BaseController
{
    public function index()
	{
		//echo "under construction";die();
		 if(!Gate::allows("users_manage")){
			return abort(401);
		}
		
		$designations = Member::designation(setting()->get('designation'));
		
		$address = Address::select('id','address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$job = \App\Occupation::select('id','occupation_np')->get();
		//dd($designations);
		/*$query = Member::with('user','contacts','addresses','tols','job','groups')->latest()->get();
		return response()->json([
            'members' => $query
        ], 200);*/
		$this->setPageTitle("मेडिकल सर्वेक्षण","मेडिकल सर्वेक्षणको सूची");
		return view("admin.medsurvey.index",compact('designations','address','tol','job'));
	}
	
	/*for testing query purpose*/
	public function test()
	{
		$years=date('Y-m-d', strtotime("-68 years"));
		
		/*$query = SeniorCitizen::with(['member','user','medicalsurvey'])->select('senior_citizens.*')->where(DB::raw('date(members.dob_ad)'),'<=',$years)
		 ->where('members.dob_ad','!=','N/A')->orderBy('senior_citizens.created_at','DESC')->get();*/
		 $query = SeniorCitizen::with(['medicalsurvey','user','member' => function ($q) use($years){
			 $q->where(DB::raw('date(dob_ad)'),'<=',$years)->where('dob_ad','!=','N/A');
		 }])->select('senior_citizens.*')->orderBy('senior_citizens.created_at','DESC')->get();
		 
		 //$query = SeniorCitizen::with(['medicalsurvey','member'])->select('senior_citizens.*')->get();
		 foreach($query as $data){
			 var_dump($data->member);
		 }
		 die();
		 
	}
	
	public function dashboard()
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
	
	public function childunder45()
	{
		if(!Gate::allows("users_manage")){
			return abort(401);
		}
		
		$designations = Member::designation(setting()->get('designation'));
		
		$address = Address::select('id','address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$job = \App\Occupation::select('id','occupation_np')->get();
		//dd($designations);
		/*$query = Member::with('user','contacts','addresses','tols','job','groups')->latest()->get();
		return response()->json([
            'members' => $query
        ], 200);*/
		$this->setPageTitle("45 दिन मुनिको बच्चा","मेडिकल सर्वेक्षणको सूची");
		return view("admin.medsurvey.childunder45",compact('designations','address','tol','job'));
	}
	
	public function getchildunder45(Request $request)
	{
		$query = MedicalSurvey::with(['user','addresses','tols'])->select('medical_survey.*')->where('pregnant_exists','1')->orderBy('medical_survey.created_at','DESC');
		
		if (!empty($request->get('concerned_person'))) {
			$query = $query->where('concerned_person','LIKE', "%{$request->get('concerned_person')}%");
		}
		
		if (!empty($request->get('concerned_contact'))) {
			$query = $query->where('concerned_contact','LIKE', "%{$request->get('concerned_contact')}%");
		}
		
		if (!empty($request->get('under_five_child'))) {
			$query = $query->where('under_five_child','=',$request->get('under_five_child'));
		}
		
		if (!empty($request->get('elderly_exist'))) {
			$query = $query->where('elderly_exist','=',$request->get('elderly_exist'));
		}
		
		if (!empty($request->get('chronic_disease'))) {
			$query = $query->where('chronic_disease','=',$request->get('chronic_disease'));
		}
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('concerned_person',function($data){
				return $data->concerned_person; 
			})
			->addColumn('concerned_contact',function($data){
				return $data->concerned_contact; 
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np; 
			})
			->addColumn('tols',function($data){
				
				return $data->tols->tol_np ? $data->tols->tol_np : 'N/A';
			})
			->addColumn('under_five_child',function($data){
				return $data->under_five_child==1 ? 'छ': 'छैन';
			})
			->addColumn('elderly_exist',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				if($data->elderly_exist==1){
					$output = 'छ <br>';
					$senior = SeniorCitizen::select()->where('medsurvey_id',$data->id)->get();
					if($senior){
						foreach($senior as $row):
							$output.= '<button class="badge badge-soft-success">'.$row->elderly_id.'</button><br>';
						endforeach;	
					}
					return $output;
				}else if($data->elderly_exist==2){
					return 'छैन';
				}else{
					return 'N/A';
				}
				//return $data->elderly_exist==1 ? 'छ': 'छैन';
			})
			->addColumn('chronic_disease',function($data){
				return $data->chronic_disease==1 ? 'छ': 'छैन';
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			}) 
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->rawColumns(['full_name','elderly_exist'])
			->make(true);
	}
	
	public function seniorabove68()
	{
		if(!Gate::allows("users_manage")){
			return abort(401);
		}
		
		$designations = Member::designation(setting()->get('designation'));
		
		$address = Address::select('id','address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$job = \App\Occupation::select('id','occupation_np')->get();
		//dd($designations);
		/*$query = Member::with('user','contacts','addresses','tols','job','groups')->latest()->get();
		return response()->json([
            'members' => $query
        ], 200);*/
		$this->setPageTitle("६८ वर्षभन्दा माथि वा सोभन्दा माथिका ज्येष्ठ नागरिकहरू","मेडिकल सर्वेक्षणको सूची");
		return view("admin.medsurvey.seniorabove68",compact('designations','address','tol','job'));
	}
	
	public function getseniorabove68(Request $request)
	{
		$years=date('Y-m-d', strtotime("-68 years"));
		
		/*$query = SeniorCitizen::with(['member','user','medicalsurvey'])->select('senior_citizens.*')->where(DB::raw('date(members.dob_ad)'),'<=',$years)
		 ->where('members.dob_ad','!=','N/A')->orderBy('senior_citizens.created_at','DESC')->get();*/
		 $query = SeniorCitizen::with(['medicalsurvey','user'])->whereHas('member' , function ($q) use($years){
			 $q->where(DB::raw('date(dob_ad)'),'<=',$years)->where('dob_ad','!=',NULL);
		 })->select('senior_citizens.*')->orderBy('senior_citizens.created_at','DESC')->get();
		 
		 //$query->whereNotNull('senior_citizens.elderly_id');
		 
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('full_name',function($data){
				$output = '<div class="d-flex align-items-center">
								<div class="flex-shrink-0"><img src="'.($data->member->getFirstMediaUrl() ? $data->member->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg')).'" alt="'.$data->full_name.'" title="'.$data->full_name.'" class="avatar-xs rounded-circle"></div>
								<div class="flex-grow-1 ms-2 name">'.$data->member->full_name.'</div>
							</div>'; 
				return $output;
			})
			->addColumn('dob_ad',function($data){
				return $data->member->dob_ad!='N/A' ? $data->member->dob_ad : 'N/A';				
			})
			->addColumn('age',function($data){
				$dob = Carbon::parse($data->member->dob_ad);
				$output = $data->member->dob_ad=='N/A' ? 'N/A' : $dob->diffInYears(now());
				return $output;
			}) 			
			->addColumn('contacts',function($data){
				if($data->member->contacts):
					return $data->member->contacts->mobile_no ? $data->member->contacts->mobile_no : '-';
				else:
					return '-';
				endif;
			})
			->addColumn('house',function($data){
				return $data->member->house_no; 
			})
			->addColumn('addresses',function($data){
				return $data->member->addresses->address_np; 
			})
			->addColumn('tols',function($data){
				return $data->member->tols->tol_np;
			})
			->addColumn('gender',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				if($data->member->gender==1){ $output = "M";}
				if($data->member->gender==2){ $output = "F";}
				if($data->member->gender==3){ $output = "O";}
				if($data->member->gender==9){ $output = "N/A";}
				return $output;
			})
			->addColumn('martial_status',function($data){
				if($data->member->martial_status==1){ $output = "अविवाहित";}
				if($data->member->martial_status==2){ $output = "विवाहित";}
				if($data->member->martial_status==3){ $output = "सम्बन्धविच्छेद भएको";}
				if($data->member->martial_status==4){ $output = "विधवा";}
				if($data->member->martial_status==9){ $output = "N/A";}
				return $output;
				})
			->addColumn('citizenship',function($data){
				return $data->member->citizenship;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			}) 
			->addColumn('user',function($data){
				if($data->user):
				return $data->user->name;
				endif;
			}) 
			->rawColumns(['full_name'])
			->make(true);
	}
	
	public function getmedicalsurvey(Request $request){
		
		if(auth()->user()->hasRole('medical')):
			$query = MedicalSurvey::with(['user','addresses','tols'])->select('medical_survey.*')->where('user_id',\Auth::user()->id)->orderBy('medical_survey.created_at','DESC');
        else:
            $query = MedicalSurvey::with(['user','addresses','tols'])->select('medical_survey.*')->orderBy('medical_survey.created_at','DESC');
		endif;
		
		if (!empty($request->get('concerned_person'))) {
			$query = $query->where('concerned_person','LIKE', "%{$request->get('concerned_person')}%");
		}
		
		if (!empty($request->get('concerned_contact'))) {
			$query = $query->where('concerned_contact','LIKE', "%{$request->get('concerned_contact')}%");
		}
		
		if (!empty($request->get('medical_insured'))) {
			$query = $query->where('medical_insured','=',$request->get('medical_insured'));
		}
		
		if (!empty($request->get('under_five_child'))) {
			$query = $query->where('under_five_child','=',$request->get('under_five_child'));
		}
		
		if (!empty($request->get('house_no'))) {
			$query = $query->where('house_no','=', $request->get('house_no'));
		}
		
		if (!empty($request->get('elderly_exist'))) {
			$query = $query->where('elderly_exist','=',$request->get('elderly_exist'));
		}
		
		if (!empty($request->get('chronic_disease'))) {
			$query = $query->where('chronic_disease','=',$request->get('chronic_disease'));
		}
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('concerned_person',function($data){
				return $data->concerned_person; 
			})
			->addColumn('concerned_contact',function($data){
				return $data->concerned_contact; 
			})
			->addColumn('medical_insured',function($data){
				return $data->medical_insured==1 ? 'छ': 'छैन';
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np; 
			})
			->addColumn('tols',function($data){
				
				return $data->tols->tol_np ? $data->tols->tol_np : 'N/A';
			})
			->addColumn('under_five_child',function($data){
				return $data->under_five_child==1 ? 'छ': 'छैन';
			})
			->addColumn('elderly_exist',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				if($data->elderly_exist==1){
					$output = 'छ <br>';
					$senior = SeniorCitizen::select()->where('medsurvey_id',$data->id)->get();
					if($senior){
						foreach($senior as $row):
							$output.= '<button class="badge badge-soft-success">'.$row->elderly_id.'</button><br>';
						endforeach;	
					}
					return $output;
				}else if($data->elderly_exist==2){
					return 'छैन';
				}else{
					return 'N/A';
				}
				//return $data->elderly_exist==1 ? 'छ': 'छैन';
			})
			->addColumn('chronic_disease',function($data){
				return $data->chronic_disease==1 ? 'छ': 'छैन';
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			}) 
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('action',function($data){
				$buttons = '<div class="dropdown d-inline-block">
								<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="ri-more-fill align-middle"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end" style="">
									<li><a href="'.route('admin.medsurvey.show', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> View</a></li>
									<li>
										<form action="#" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
											<input type="hidden" name="_method" value="DELETE">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
										</form> 
									</li>
								</ul>
							</div>';
			return $buttons;
			})
			->rawColumns(['sms','full_name','groups','mabedans','action','elderly_exist'])
			->make(true);
	}
	
	public function create()
	{
		$this->setPageTitle("मेडिकल सर्वेक्षण", "Add Medical Survey data");
		$address = Address::get();
		$tol = Tol::get();
		
        return view("admin.medsurvey.create",compact('address','tol'));
	}
	
	public function store(Request $request)
	{	
	
		//var_dump($request->dengue_prevention);die();
		if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
		/**/
		$validator = Validator::make(
			$request->all(),
			[
				'house_no' => 'required',
				'road' => 'required',
				'tol'=> "required",
				'concerned_person'=>'required',
				'under_five_child'=>'required',
				'elderly_exist'=>'required',
				'concerned_contact' => 'required|min:10|numeric',
				'ownership'=>'required',
				'tol'=>'required',
				'mtreatment_at' => 'required',
				'medical_insured'=>'required',
				'family_planning_done'=>'required',
				//'rubbish_mgmt'=>'required',
				//'plastic_rubbish_mgmt'=>'required',
				//'drinking_water_src'=>'required',
				
				'meshed_windows'=>'required',
				'pot_holes'=>'required',
				'pot_pan_water'=>'required',
				'family_dengue'=>'required',
				'dengue_prevention'=>'required',
			],
			[
				'house_no.required'=>'घर नं को जानकारी आवश्यक छ ।',
				'road.required'=>'सडकको जानकारी आवश्यक छ ।',
				'tol.required'=>'टोलको जानकारी आवश्यक छ ।',
				'concerned_person.required'=>'सम्बन्धित व्यक्तिको जानकारी आवश्यक छ ।',
				'concerned_contact.required'=>'सम्बन्धित व्यक्तिको  मोबाइल नं आवश्यक छ ।',
				'under_five_child.required'=>'५ वर्ष मूनिका बच्चाको विवरण आवश्यक छ ।',
				'elderly_exist.required'=>'जेष्ठ नागरिकको विवरण आवश्यक छ ।',
				'mtreatment_at.required'=>'विरामी हुँदा उपचार स्थानको जानकारी आवश्यक छ ।',
				'medical_insured.required'=>'स्वास्थ्य विमाको जानकारी आवश्यक छ ।',
				'family_planning_done.required'=>'परिवार नियोजनको साधन प्रयोगको जानकारी आवश्यक छ ।',
				'rubbish_mgmt.required'=>'फोहरमैला ब्यवस्थापनको जानकारी आवश्यक छ ।',
				'plastic_rubbish_mgmt.required'=>'प्लाष्टिकजन्य फोहरमैला ब्यवस्थापनको  मोबाइल नं आवश्यक छ ।',
				'drinking_water_src.required'=>'खानेपानी श्रोतकोको जानकारी आवश्यक छ ।',
				'meshed_windows'=>'घरको झ्याल ,ढोकामा जाली लगाये नलगायेको जानकारी आवश्यक छ ।',
				'pot_holes'=>'घर बाहिर खाल्डाखुल्डीमा पानी भये नभयेको जानकारी आवश्यक छ । ',
				'pot_pan_water'=>'गमला ,फुल्दानी ,भाडाकुडामा पानी जमे नजमेको जानकारी आवश्यक छ । ',
				'family_dengue'=>'तपाईको परिवारमा डेँगु ,मलेरियाको समस्या भये नभयेको जानकारी आवश्यक छ । ',
				'dengue_prevention'=>'डेँगु महामारी नियन्त्रणको बारेमा जानकारी आवश्यक छ ।  ',
				
			]
		);
		
		/*if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}*/
		//dd($request->all());

		/*foreach($request->full_name as $i=>$fullname){
			if($fullname!=NULL){
				$member->house_no = $request->house_no;
				$member->road = $request->road;
				$member->tol = $request->tol;
				$member->full_name = $request->full_name[$i];
				$member->dob_ad = $request->dob_ad[$i];
				$member->citizenship = $request->citizenship[$i];
				$member->gender = $request->gender[$i];
				$member->blood_group = $request->blood_group[$i];
				$member->occupation_id = 20;
				$member->created_by = \Auth::user()->id;
				
				if($member->save()){
					$memcontact->created_by = \Auth::user()->id;;
					$memcontact->member_id = $member->id;
					$memcontact->mobile_no = $request->mobile_no[$i];
					$memcontact->save();
				}
			}
		}*/
		
		
		/*for saving survey data*/
		
		$surveydata = $request->except(['citizenship','elderly_id','full_name','dob_ad','gender','elder','mobile_no','blood_group']);
		//var_dump($surveydata);die();
		if(array_key_exists('chronic_disease_name', $surveydata)){
			$chronic_disease = implode(', ',$surveydata['chronic_disease_name']);
			$surveydata['chronic_disease_name']=$chronic_disease;
			//var_dump($chronic_disease);die();
		}
		if(array_key_exists('family_planning_temp', $surveydata)){
			$chronic_disease = implode(', ',$surveydata['family_planning_temp']);
			$surveydata['family_planning_temp']=$chronic_disease;
			//var_dump($chronic_disease);die();
		}
		if(array_key_exists('dengue_prevention', $surveydata)){
			$chronic_disease = implode(', ',$surveydata['dengue_prevention']);
			$surveydata['dengue_prevention']= $chronic_disease;
			//var_dump($chronic_disease);die();
		}
		//dd($surveydata);

		//var_dump($surveydata->chronic_disease_name);die();
		
		$medical = MedicalSurvey::create($surveydata);
		
		/*saving survey data end*/		
			
		if($medical){
			$surveyid = $medical->id;
			//dd($request->elder);
			$arr = array();
			if($request->elderly_exist==1):
			foreach($request->elder as $elder){
				//var_dump($elder);die();
				if(is_array($elder)){
					$elder['medsurvey_id'] = $surveyid;
					if($elder['member']['full_name']!=null){
						$member=$elder['member'];
						$member['house_no'] = $request->house_no;
						$member['road'] = $request->road;
						$member['tol'] = $request->tol;
						$member['occupation_id'] = 20;
						$member['created_by'] = \Auth::user()->id;
						//dd($member);
						$mobile_number=$member['mobile'];
						unset($member['mobile']);

						$memberInsert=Member::insertGetId($member);
							//var_dump($memberInsert);die();

						if($memberInsert){
							$contactdetail['created_by'] = \Auth::user()->id;
							$contactdetail['member_id'] =$memberInsert;
							$contactdetail['mobile_no'] =$mobile_number ;

							Contactdetail::insert($contactdetail);
							$elder['elderly_id']=$member['citizenship'];

						}
					}else{
						$elder['elderly_id'] = $elder['member']['citizenship'];
						$elder['created_by'] = \Auth::user()->id;

					}
					//unset($elder['citizenship']);
					unset($elder['member']);
					
					//var_dump($elder);die();		
								$arr = $elder;
				SeniorCitizen::insert($arr);	

				}

			}
			//dd($arr);
			//var_dump($arr);die();
			//var_dump($result);true;

			endif;

			//var_dump($arr);die();
			//var_dump($arr);die();	
			return back()->with("message", "Data added successfully");
		}else{
			return back()->with("message", "Sorry!! But the data could not be added.");
		}
		
	}
	
	public function edit($slug)
	{
		
	}
	
	public function update(Request $request,$id)
	{
		
	}
	
	public function show($id)
	{	
		if (! Gate::allows('users_manage')) {
            return abort(401);
        }
		$survey = MedicalSurvey::with('seniors','addresses','tols')->where('medical_survey.id',$id)->firstOrFail();
		
		//dd($survey);
		$this->setPageTitle($survey->concerned_person."को मेडिकल सर्वेक्षण", "");
		return view('admin.medsurvey.show',compact('survey'));
	}
	
	public function destroy($id)
	{
		if (! Gate::allows('users_manage')) {
            return abort(401);
        }
		
		$medsurvey = MedicalSurvey::find($id);
		
		if($medsurvey->delete()):
			return back()->with('message','Data deleted successfully!!');
		else:
			return back()->with(
				'',
				'Sorry but the data could not be deleted!!'
			);
		endif;
	}
	
	
}
