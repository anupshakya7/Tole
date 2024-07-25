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
		$this->setPageTitle("चिकित्सा सर्वेक्षण","चिकित्सा सर्वेक्षणको सूची");
		return view("admin.medsurvey.index",compact('designations','address','tol','job'));
	}
	
	public function getmedicalsurvey(Request $request){
		$query = MedicalSurvey::with(['user','addresses','tols'])->select('medical_survey.*')->orderBy('medical_survey.created_at','DESC');
		
		if (!empty($request->get('concerned_person'))) {
			$query = $query->where('concerned_person','LIKE', "%{$request->get('concerned_person')}%");
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
				return $data->tols->tol_np;
			})
			->addColumn('under_five_child',function($data){
				return $data->under_five_child==1 ? 'छ': 'छैन';
			})
			->addColumn('elderly_exist',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				return $data->elderly_exist==1 ? 'छ': 'छैन';
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
									<li><a href="#" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
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
			->rawColumns(['sms','full_name','groups','mabedans','action'])
			->make(true);
	}
	
	public function create()
	{
		$this->setPageTitle("चिकित्सा सर्वेक्षण", "Add Medical Survey data");
		$address = Address::get();
		$tol = Tol::get();
		
        return view("admin.medsurvey.create",compact('address','tol'));
	}
	
	public function store(Request $request)
	{	
	
		//dd($request->all());
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
		//var_dump($request['chronic_disease_name']);die();
		if(array_key_exists('chronic_disease_name', $surveydata)){
			$chronic_disease = implode(', ',$surveydata['chronic_disease_name']);
			$surveydata['chronic_disease_name']=$chronic_disease;
			//var_dump($chronic_disease);die();
		}
		if(array_key_exists('family_planning_temp', $surveydata)){
			$chronic_disease = implode(', ',$surveydata['family_planning_temp']);
			$surveydata['family_planning_temp']=$chronic_disease;
			//var_dump($chronic_disease);die();
		}		//dd($surveydata);

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
