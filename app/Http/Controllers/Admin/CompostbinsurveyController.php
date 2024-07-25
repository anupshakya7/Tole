<?php

namespace App\Http\Controllers\Admin;

use App\Compostbinsurvey;
use App\Address;
use App\Tol;
use App\Houseowner;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class CompostbinsurveyController extends BaseController
{
	
	/*getting all the datas that are not in house_owner table but entered on compostbin survey*/
	public function excluding(){
		$exclude = DB::select( DB::raw("SELECT cs.id 
								FROM compostbinsurveys cs LEFT OUTER JOIN house_owner ho 
									 ON ho.house_no = cs.house_no
								WHERE ho.house_no is NULL") );
		
		$arrdata = array();

		foreach($exclude as $data){
			$row = Compostbinsurvey::find($data->id);
			array_push($arrdata, $row);
		}	
		
		//dd($arrdata);
		$this->setPageTitle('कम्पोस्टबिन सर्वेक्षण जुन घर धनिको डाटामा छैन', 'List of compostbin survey');  
									
		return view('admin.compostbinsurvey.exclude',compact('arrdata'));
	}
	
	/*getting all compostbin survey with compostbin_usage as true i.e. 0*/
	public function cbintrue()
	{
		
        if(!Gate::allows('users_manage')){
            return abort(401);
        }        
        
        $this->setPageTitle('प्रयोग भएका कम्पोस्टबिन सर्वेक्षण', 'List of compostbin survey');    
		return view('admin.compostbinsurvey.cbinusagetrue');
	}
	
	public function dashboard()
	{
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
		$surveybydate = DB::select(DB::raw('SELECT count(id) as total, created_at FROM `compostbinsurveys` WHERE date(created_at) GROUP BY date(created_at)'));
		//dd($surveybydate);		
		$totsurvey = Compostbinsurvey::count();		
		
		$maleowner = Houseowner::where('gender','0')->count();
		$femaleowner = Houseowner::where('gender','1')->count();
		$totalowner = Houseowner::count();
			
		$cbinusage = DB::select(DB::raw('select count(id) as total, compostbin_source from compostbinsurveys where compostbin_source IS NOT NULL and compostbin_source!="उपलब्ध छैन" GROUP BY compostbin_source'));
		$totpeople = Compostbinsurvey::select(DB::raw("SUM(total_people) as total"))->first();
		
		$totkitchen = Compostbinsurvey::select(DB::raw("SUM(no_kitchen) as totalkitchen"))->whereNotNull('no_kitchen')->first();
		
		$this->setPageTitle("Dashboard", "");
		return view('admin.compostbinsurvey.dashboard',compact('maleowner','femaleowner','totalowner',
		'totsurvey','compbinbyuser','users','arrayyes','arrayno','suaddress','surveytol',
		'compbinbyusertoday','addressyes','addressno','tolyess','tolnoo','surveybydate','cbinusage','totpeople','totkitchen'));
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$address = Address::select('address_np')->get();
		$tol = Tol::select('tol_np')->get();

        /*if(auth()->user()->hasRole('surveyer')):
			$cbinsurvey = Compostbinsurvey::latest()->where('user_id',\Auth::user()->id)->get();
        else:
            $cbinsurvey = Compostbinsurvey::latest()->get();
		endif;*/
        
        
        $this->setPageTitle('कम्पोस्टबिन सर्वेक्षण', 'List of compostbin survey');    
		return view('admin.compostbinsurvey.index_yajra',compact('address','tol'));
        //return view('admin.compostbinsurvey.index',compact('cbinsurvey'));
    }
	 
	public function getCompostbinsurveys()
    {
        if(auth()->user()->hasRole('surveyer')):
			$res = Compostbinsurvey::with(['addresses','tols','user'])->select('compostbinsurveys.*')->where('user_id',\Auth::user()->id);
        else:
            $res = Compostbinsurvey::with(['addresses','tols','user'])->select('compostbinsurveys.*');
		endif;
		
		
        return DataTables::of($res)
			->addIndexColumn()
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('owner',function($data){
				$output = ($data->owner!=NULL) ? $data->owner:'-';
				return $output;			
			})
			->addColumn('contact',function($data){
				$output = $data->contact ?? '-';
				return $output;			
			})
			->addColumn('compostbin_usage',function($data){
				$output = $data->compostbin_usage == 0 ? 'छ' : 'छैन';
				return $output;
			})
			->addColumn('compostbin_source',function($data){
				$output = ($data->compostbin_source!=NULL) ? ($data->compostbin_source==0 ? 'छ' : 'छैन') : '-';
				return $output;
			})
			->addColumn('compostbin_seperated',function($data){
				$output = $data->compostbin_seperated == 0 ? 'छ' : 'छैन';
				return $output;			
			})
			->addColumn('reason',function($data){
				$output = $data->reason ?? '-';
				return $output;			
			})
			->addColumn('remarks',function($data){
				$output = $data->remarks ?? '-';
				return $output;			
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np;
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			}) 
			->addColumn('action',function($data){
				if(auth()->user()->hasRole('administrator')):
					$buttons = '<div class="dropdown d-inline-block">
									<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="ri-more-fill align-middle"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end" style="">
										<li><a href="'.route('admin.cbinsurvey.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
										<li>
											<form action="'.route('admin.cbinsurvey.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="'.csrf_token().'">
												<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
											</form>
										</li>
									</ul>
								</div>';
				else:
					$buttons = '<div class="dropdown d-inline-block">
									<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="ri-more-fill align-middle"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end" style="">
										<li><a href="'.route('admin.cbinsurvey.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									</ul>
								</div>';
				endif;		
				return $buttons;
			})
			->rawColumns(['action'])
			->make(true);
    }
	
	/*compostbin survey list with compostbin usage yes*/
	public function getCompostbintrue()
    {
        if(auth()->user()->hasRole('surveyer')):
			$res = Compostbinsurvey::with(['addresses','tols','user','cinspection'])->where([['user_id',\Auth::user()->id],['compostbin_usage','0']])->latest()->get();
        else:
            $res = Compostbinsurvey::with(['addresses','tols','user','cinspection'])->where('compostbin_usage','0')->latest()->get();
		endif;
		
		//dd($res);
        return DataTables::of($res)
			->addIndexColumn()
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('owner',function($data){
				$output = ($data->owner!=NULL) ? $data->owner:'-';
				return $output;			
			})
			->addColumn('contact',function($data){
				$output = $data->contact ?? '-';
				return $output;			
			})
			->addColumn('compostbin_usage',function($data){
				$output = $data->compostbin_usage == 0 ? 'छ' : 'छैन';
				return $output;
			})
			->addColumn('compostbin_source',function($data){
				$output = ($data->compostbin_source!=NULL) ? ($data->compostbin_source==0 ? 'छ' : 'छैन') : '-';
				return $output;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np;
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('inspection', function ($data) {
				if(!empty($data->cinspection->created_at)){
                    //return $data->cinspection->map(function($inspection) {
						/*return $group->pivot->map(function($pivot){
							return '<span class="badge badge-soft-info">'.$group->title_np.': '.$pivot->designation.'</span>';
						});*/
                        return '<button class="badge badge-soft-success" data-bs-target="#showinspectedcbin" houseno="'.$data->house_no.'" onclick="inspectioncbin($(this));" data-bs-toggle="modal">'.$data->cinspection->created_at.'</button>';
					//});
				 }else{
					 return '<button data-bs-target="#showinspection" onclick="inspection($(this));" houseno="'.$data->house_no.'" cbinid="'.$data->id.'" data-bs-toggle="modal" class="badge badge-soft-info">निरीक्षण</button>';
				 }
					//return '<button data-bs-target="#showinspection" onclick="inspection($(this));" houseno="'.$data->house_no.'" cbinid="'.$data->id.'" data-bs-toggle="modal" class="badge badge-soft-info">निरीक्षण</button>';
				 
                })		
			->addColumn('action',function($data){
				if(auth()->user()->hasRole('administrator')):
					$buttons = '<div class="dropdown d-inline-block">
									<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="ri-more-fill align-middle"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end" style="">
										<li><a href="'.route('admin.cbinsurvey.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
										<li>
											<form action="'.route('admin.cbinsurvey.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="'.csrf_token().'">
												<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
											</form>
										</li>
									</ul>
								</div>';
				else:
					$buttons = '<div class="dropdown d-inline-block">
									<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="ri-more-fill align-middle"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end" style="">
										<li><a href="'.route('admin.cbinsurvey.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									</ul>
								</div>';
				endif;		
				return $buttons;
			})
			->rawColumns(['action','inspection'])
			->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $this->setPageTitle("कम्पोस्टबिन सर्वेक्षण", "Add Compostbin Survey data");
		$address = Address::get();
		$tol = Tol::get();
        return view("admin.compostbinsurvey.create",compact('address','tol'));
    }
	
	/*temporary functions*/
	public function add()
    {        
        $this->setPageTitle("कम्पोस्टबिन सर्वेक्षण", "Add Compostbin Survey data");
		$address = Address::get();
		$tol = Tol::get();
        return view("admin.compostbinsurvey.add",compact('address','tol'));
    }
	public function added(Request $request)
	{
		if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //dd($request->all());
		$validator = Validator::make(
			$request->all(),
			[
				'contact' => 'required|min:10|numeric',
				'compostbin_source' => 'required_if:compostbin_usage,0',
				'reason'=>'required_if:compostbin_seperated,1',
			],
			[
				'compostbin_source.required_if'=>'कम्पोस्टबिन प्रयोग छ चयन गर्दा कम्पोस्टबिन स्रोत क्षेत्र आवश्यक हुन्छ।',
				'reason.required_if'=>'फोहोर बर्गिकरण छैन  चयन गर्दा  कम्पोस्टबिन  नगर्नुको कारण  छनोट आवश्यक हुन्छ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		//dd($request->all());		
        $compost = new Compostbinsurvey();
        $compost->house_no = $request->house_no;
        $compost->road =$request->road;
		$compost->tol =$request->tol;
		$compost->owner = $request->owner;
        $compost->contact = $request->contact;
        $compost->compostbin_usage = $request->compostbin_usage;
        $compost->compostbin_source = $request->compostbin_source;
        $compost->compostbin_seperated = $request->compostbin_seperated;
        $compost->house_storey = $request->house_storey;
        $compost->no_kitchen = $request->no_kitchen;
        $compost->total_people = $request->total_people;
		$compost->remarks = $request->remarks;
		$compost->reason = $request->reason;
		$compost->respondent_no = $request->respondent_no;
        $compost->user_id = \Auth::user()->id;

        if($compost->save()){
			Houseowner::where([['house_no',$request->house_no],['road',$request->road]])->update(['flag' => '1']);
            /*$check = Houseowner::checkowner($request->house_no,$request->road);
			if($check):
				Houseowner::where([['house_no',$request->house_no],['road',$request->road]])->update(['flag' => '1']);
				return back()->with('message','Successfully inserted data for '.$request->house_no);
			else:
				$owner = new Houseowner();
				$owner->road = $request->road;
				$owner->tol = $request->tol;
				$owner->owner = $request->owner;
				$owner->owner_np = $request->owner_np;
				$owner->contact = $request->contact;
				$owner->mobile = $request->mobile;
				$owner->respondent = $request->respondent;
				$owner->respondent_np = $request->respondent_np;
				$owner->no_of_tenants = $request->no_of_tenants;
				$owner->occupation = $request->occupation;
				$owner->gender = $request->gender;
				$owner->house_no = $request->house_no;
				$owner->flag = 1;
				$owner->save();*/
				return back()->with('message','Successfully inserted data for '.$request->house_no);
			//endif;
			
        }else{
            return back()->with('message','Unable to insert data of '.$request->house_no);
        }
	}
	public function saved(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //dd($request->all());
		$validator = Validator::make(
			$request->all(),
			[
				'contact' => 'required|min:10|numeric',
				'compostbin_source' => 'required_if:compostbin_usage,0',
				'reason'=>'required_if:compostbin_seperated,1',
			],
			[
				'compostbin_source.required_if'=>'कम्पोस्टबिन प्रयोग छ चयन गर्दा कम्पोस्टबिन स्रोत क्षेत्र आवश्यक हुन्छ।',
				'reason.required_if'=>'फोहोर बर्गिकरण छैन  चयन गर्दा  कम्पोस्टबिन  नगर्नुको कारण  छनोट आवश्यक हुन्छ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		//dd($request->all());		
        $compost = new Compostbinsurvey();
        $compost->house_no = $request->house_no;
        $compost->road =$request->road;
		$compost->tol =$request->tol;
		$compost->owner = $request->owner;
        $compost->contact = $request->contact;
        $compost->compostbin_usage = $request->compostbin_usage;
        $compost->compostbin_source = $request->compostbin_source;
        $compost->compostbin_seperated = $request->compostbin_seperated;
        $compost->house_storey = $request->house_storey;
        $compost->no_kitchen = $request->no_kitchen;
        $compost->total_people = $request->total_people;
		$compost->remarks = $request->remarks;
		$compost->reason = $request->reason;
		$compost->respondent_no = $request->respondent_no;
        $compost->user_id = \Auth::user()->id;
		
		$survey = Compostbinsurvey::where([['house_no',$request->house_no],['road',$request->road]])->exists();
		
		if($survey):
			$msg = Compostbinsurvey::where([['house_no',$request->house_no],['road',$request->road]])
							->leftJoin('users','compostbinsurveys.user_id','=','users.id')
							->leftJoin('address','compostbinsurveys.road','=','address.id')
							->select('compostbinsurveys.created_at','users.name','address.address_np')->first();
							
				$message =  $msg->address_np."मा भएको घर नम्बर  ".$data['house_no']." को सर्वेक्षण ".$msg->name." द्वारा ".$msg->created_at->toFormattedDateString()." मा भइसकेको छ";
				
				return back()->with('error',$message);
		else:
			 if($compost->save()){
				Houseowner::where([['house_no',$request->house_no],['road',$request->road]])->update(['flag' => '1']);
				return back()->with('message','Successfully inserted data for '.$request->house_no);
			//endif;
			
        }else{
            return back()->with('message','Unable to insert data of '.$request->house_no);
        }
		endif;
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //dd($request->all());
		$validator = Validator::make(
			$request->all(),
			[
				'house_no' => 'required|unique:compostbinsurveys',
			],
			[
				'house_no.unique'=>"माथिको घर नम्बरको सर्वेक्षण पहिले नै भइसकेको छ",
			],
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		//dd($request->all());		
        $compost = new Compostbinsurvey();
        $compost->house_no = $request->house_no;
        $compost->road =$request->road;
		$compost->tol =$request->tol;
		$compost->owner = $request->owner;
        $compost->contact = $request->contact;
        $compost->compostbin_usage = $request->compostbin_usage;
        $compost->compostbin_source = $request->compostbin_source;
        $compost->compostbin_seperated = $request->compostbin_seperated;
        $compost->house_storey = $request->house_storey;
        $compost->no_kitchen = $request->no_kitchen;
        $compost->total_people = $request->total_people;
		$compost->remarks = $request->remarks;
		$compost->reason = $request->reason;
		$compost->respondent_no = $request->respondent_no;
        $compost->user_id = \Auth::user()->id;

        if($compost->save()){
            $check = Houseowner::checkowner($request->house_no,$request->road);
			if($check):
				Houseowner::where([['house_no',$request->house_no],['road',$request->road]])->update(['flag' => '1']);
				return back()->with('message','Successfully inserted data for '.$request->house_no);
			else:
				$owner = new Houseowner();
				$owner->road = $request->road;
				$owner->tol = $request->tol;
				$owner->owner = $request->owner;
				$owner->owner_np = $request->owner_np;
				$owner->contact = $request->contact;
				$owner->mobile = $request->mobile;
				$owner->respondent = $request->respondent;
				$owner->respondent_np = $request->respondent_np;
				$owner->no_of_tenants = $request->no_of_tenants;
				$owner->occupation = $request->occupation;
				$owner->gender = $request->gender;
				$owner->house_no = $request->house_no;
				$owner->flag = 1;
				$owner->save();
				return back()->with('message','Successfully inserted data for '.$request->house_no);
			endif;
			
        }else{
            return back()->with('message','Unable to insert data of '.$request->house_no);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compostbinsurvey  $compostbinsurvey
     * @return \Illuminate\Http\Response
     */
    public function show(Compostbinsurvey $compostbinsurvey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compostbinsurvey  $compostbinsurvey
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $compost = Compostbinsurvey::where("id", $slug)->firstOrFail();

		$address = Address::get();
		$tol = Tol::get();
        //dd($compost);
        $this->setPageTitle('कम्पोस्टबिन सर्वेक्षण', 'Edit Compostbin Survey');
        return view('admin.compostbinsurvey.edit', compact('compost','address','tol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compostbinsurvey  $compostbinsurvey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        
        $data = Compostbinsurvey::find($id);
		
        $data->house_no = $request->house_no;
        $data->road =$request->road;
		$data->tol =$request->tol;
		$data->owner = $request->owner;
        $data->contact = $request->contact;
        $data->compostbin_usage = $request->compostbin_usage;
        $data->compostbin_source = $request->compostbin_source;
        $data->compostbin_seperated = $request->compostbin_seperated;
        $data->reason = $request->reason;
        $data->house_storey = $request->house_storey;
        $data->no_kitchen = $request->no_kitchen;
        $data->total_people = $request->total_people;
		$data->remarks = $request->remarks;
		$data->reason = $request->reason;
		$data->respondent_no = $request->respondent_no;
        //$data->user_id = \Auth::user()->id;

        if ($data->update()):
		  return redirect(route("admin.cbinsurvey.index"))->with(
			"message",
			$request->owner . " updated successfully"
		  );
		else:
		  return redirect(route("admin.cbinsurvey.index"))->with(
			"message",
			"Unable to update " . $request->owner . " survey"
		  );
		endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compostbinsurvey  $compostbinsurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

		$compost = Compostbinsurvey::find($id);
        //dd($compost);
		if($compost->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}
