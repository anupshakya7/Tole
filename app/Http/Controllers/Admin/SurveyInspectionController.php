<?php

namespace App\Http\Controllers\Admin;

use App\SurveyInspection;
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

class SurveyInspectionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
	{
		$today = Carbon::today();
		/*getting the number of surveys done by different users for displaying in chart*/
		$compbinbyuser = DB::select( DB::raw("select house_no, user_id,id,count(id) as survey_done from survey_inspection si GROUP BY si.user_id order by count(id) DESC") );
		
		/*getting the number of surveys done by different users by today for displaying in chart*/
		$compbinbyusertoday = DB::select( DB::raw("select house_no, user_id,id,count(id) as survey_done from survey_inspection where Date(created_at) = '$today' GROUP BY user_id order by count(id) DESC") );
		//var_dump($compbinbyusertoday);
		
		$users = DB::select(DB::raw('select cs.user_id,u.name from compostbinsurveys cs LEFT JOIN users u on u.id=cs.user_id group by cs.user_id'));
			
		/*getting surveys done according to address*/
		$suaddress = DB::select(DB::raw('select count(cs.id) as surveys,cs.road,ad.address_np as location from survey_inspection cs LEFT JOIN address ad on ad.id=cs.road GROUP BY cs.road'));
		//dd($suaddress);
		
		
		/*getting surveys done according to tol*/
		$surveytol = DB::select(DB::raw('select count(cs.id) as surveys,cs.tol,t.tol_np as tolname from survey_inspection cs LEFT JOIN tol t on t.id=cs.tol GROUP BY cs.tol'));
		
		
		/*getting survey data for chart according to dates*/
		$surveybydate = DB::select(DB::raw('SELECT count(id) as total, created_at FROM `survey_inspection` WHERE date(created_at) GROUP BY date(created_at)'));
		//dd($surveybydate);		
		$totsurvey = SurveyInspection::count();		
		
		$maleowner = Houseowner::where('gender','0')->count();
		$femaleowner = Houseowner::where('gender','1')->count();
		$totalowner = Houseowner::count();
		
		$this->setPageTitle("Dashboard", "");
		return view('admin.surveyinspection.dashboard',compact('maleowner','femaleowner','totalowner',
		'totsurvey','compbinbyuser','users','suaddress','surveytol',
		'compbinbyusertoday','surveybydate'));
	}
	
    public function index()
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$this->setPageTitle("कम्पोस्टबिन निरीक्षण", "कम्पोस्टबिन निरीक्षणहरूको सूची");   
		$address = Address::get();
		$tol = Tol::get();
		
		return view('admin.surveyinspection.index',compact('address','tol'));
    }
	
	/*for datatables */
	public function getinspectiondetail()
	{
        if(auth()->user()->hasRole('surveyer')):
			$res = SurveyInspection::with(['addresses','tols','user'])->select('survey_inspection.*')->where('user_id',\Auth::user()->id);
        else:
            $res = SurveyInspection::with(['addresses','tols','user'])->select('survey_inspection.*');
		endif;		
		
        return DataTables::of($res)
			->addIndexColumn()
			->addColumn('addresses',function($data){
				return $data->addresses->address_np;
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('usage',function($data){
				$output = $data->usage == 0 ? 'छ' : 'छैन';
				return $output;
			})
			->addColumn('roof_farming',function($data){
				$output = $data->roof_farming == 0 ? 'छ' : 'छैन';
				return $output;
			})
			->addColumn('production_status',function($data){
				$output = $data->production_status == 0 ? 'छ' : 'छैन';
				return $output;
			})
			->addColumn('fast_decaying_usage',function($data){
				$output = $data->fast_decaying_usage == 0 ? 'छ' : 'छैन';
				return $output;
			})
			->addColumn('compost_production_interval',function($data){
				$output = ($data->compost_production_interval!=NULL) ? $data->compost_production_interval : '-';
				return $output;
			})
			->addColumn('compost_production',function($data){
			    $output = ($data->compost_production!=NULL) ? $data->compost_production.' K.G' : '-';
				return $output;			
			})
			->addColumn('issues',function($data){
				$output = $data->issues ?? '-';
				return $output;			
			})
			->addColumn('remarks',function($data){
				$output = $data->remarks ?? '-';
				return $output;			
			})
			
			->addColumn('user',function($data){
				return $data->user->name;
			})			
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$this->setPageTitle("कम्पोस्टबिन निरीक्षण", "कम्पोस्टबिन निरीक्षण");
		$address = Address::get();
		$tol = Tol::get();
		
        return view("admin.surveyinspection.create",compact('address','tol'));
    }
	
	
	public function save(SurveyInspection $sinspection, Request $request)
	{
		 $sinspection->house_no = $request->house_no;
		 $sinspection->road = $request->road;
		 $sinspection->tol = $request->tol;
		 
		 $sinspection->usage = $request->usage;
		 $sinspection->compost_production_interval = $request->compost_production_interval;
		 $sinspection->fast_decaying_usage = $request->fast_decaying_usage;
		 $sinspection->compost_production = $request->compost_production;
		 $sinspection->production_status = $request->production_status;
		 $sinspection->roof_farming = $request->roof_farming;
		 $sinspection->issues = $request->issues;
		 $sinspection->remarks = $request->remarks;
		 $sinspection->user_id = \Auth::user()->id;
		 $sinspection->save();
	}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//dd($request->all());
		/*$validator = Validator::make(
			$request->all(),
			[
				'title_en' => 'required',
				'quantity' => 'required',
			],
			[
				'title_en.required'=>'कार्यक्रम नाम आवश्यक छ।',
				'quantity.required'=>'मात्रा आवश्यक छ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}*/
		
		//dd($request->all());
        $sinspection = new SurveyInspection();
		
		//dd($request->all());
		 
		if($this->save($sinspection,$request)){
           return back()->with('message','Successfully added data for '.$request->title_en);
        }else{
			return back()->with('message','Successfully added data for '.$request->title_en);
		}	
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */	
	public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $program = Program::where("id", $slug)->firstOrFail();
        //dd($compost);
        $this->setPageTitle('कार्यक्रम', 'सम्पादन कार्यक्रम');
        return view('admin.programs.edit',compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $program = Program::find($id);
		//dd($request);
		if($this->save($program,$request)){
            return redirect(route("admin.program.index"))->with('message','Successfully updated data for '.$request->title_en);
        }else{
			return redirect(route("admin.program.index"))->with('message','Successfully updated data for '.$request->title_en);
		}	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

		$program = Program::find($id);
        //dd($compost);
		if($program->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
	
}
