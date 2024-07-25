<?php

namespace App\Http\Controllers\Admin;

use App\Distribution;
use App\Compostbinsurvey;
use App\Program;
use App\Address;
use App\Tol;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class DistributionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($programid)
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$program = Program::findOrFail($programid);
		$address = Address::select('address_np')->get();
		$tol = Tol::select('tol_np')->get();
		//dd($program);
		$this->setPageTitle("वितरणहरू", "कार्यक्रमहरूको थप्नुस");		
		return view('admin.distributions.index',compact('program','address','tol'));
    }
	
	/*getting all the datas that are not in house_owner table but entered on compostbin survey*/
	public function excluding(){
		$disthouseid = DB::select( DB::raw("SELECT house_no from distributions where program_id=10 group by house_no") );
		$houseid=array();
		foreach($disthouseid as $house):
			array_push($houseid,"'".$house->house_no."'");
			
		endforeach;	
		$houseno = implode(',',$houseid);		
		
		//dd($houseno);
		$where = "(".$houseno.")";
		
		$excluding = DB::select( DB::raw("SELECT cs.*,t.tol_np,ad.address_np from compostbinsurveys cs left join address ad on ad.id=cs.road left join tol t on t.id=cs.tol where cs.house_no NOT IN ".$where) );
		
		//dd($excluding);
		//dd($arrdata);
		$this->setPageTitle('क्यालेन्डर र झोला वितरण  हुन बाकी', 'क्यालेन्डर र झोला वितरण  हुन बाकी');  
									
		return view('admin.distributions.exclude',compact('excluding'));
	}
	
	public function all()
	{
		if(!Gate::allows('users_manage')){
			return abort(401);
		}
		
		$address = Address::select('address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$program = Program::latest()->get();
		
		//dd($programs);
		
		$this->setPageTitle("वितरणहरू", "कार्यक्रमहरूको थप्नुस");		
		return view('admin.distributions.all',compact('address','tol','program'));
	}
	
	public function trash()
	{
		if(!Gate::allows('users_manage')){
            return abort(401);
        }

		$this->setPageTitle('वितरणहरू', 'रद्दीटोकरी वितरण को सूची');    
        return view('admin.distributions.trashed');
	}
	
	/*distribution report according program*/
	public function report($id)
	{
		$today = Carbon::today();
		$program = Program::findOrFail($id);
		
		$received = Distribution::where('program_id',$id)->whereNotNull('received_at')->count();
		$registered = Distribution::where('program_id',$id)->whereNotNull('registered_at')->count();
		$todaydist = DB::select( DB::raw("select count(id) as today_dist from distributions where program_id=".$id." and deleted_at=NUll and Date(created_at) = '$today'"))[0];
			
		/*getting distributions done according to address*/
		$distaddress = DB::select(DB::raw('select count(d.id) as distribution,d.road,ad.address_np as location from distributions d LEFT JOIN address ad on ad.id=d.road where d.program_id='.$id.' and d.deleted_at IS NULL GROUP BY d.road'));
			
		/*getting surveys done according to tol*/
		$disttol = DB::select(DB::raw('select count(d.id) as distribution,d.tol,t.tol_np as tolname from distributions d LEFT JOIN tol t on t.id=d.tol where d.program_id='.$id.' and d.deleted_at IS NULL GROUP BY d.tol'));
		//dd($disttol);
		 
		$this->setPageTitle($program->title_np."को रिपोर्ट", "");
		return view('admin.distributions.report',compact('program','received','registered','distaddress','disttol','todaydist'));
	}
	
	public function report_old($id)
	{
		$today = Carbon::today();
		$program = Program::findOrFail($id);
		if(auth()->user()->hasRole('surveyer')):
			$received = Distribution::where('program_id',$id)->where('user_id',\Auth::user()->id)->whereNotNull('received_at')->count();
			$registered = Distribution::where('program_id',$id)->where('user_id',\Auth::user()->id)->whereNotNull('registered_at')->count();
			$todaydist = DB::select( DB::raw("select count(id) as today_dist from distributions where program_id=".$id." and user_id=".\Auth::user()->id." and deleted_at=NUll and Date(created_at) = '$today'"))[0];
			
			/*getting distributions done according to address*/
			$distaddress = DB::select(DB::raw('select count(d.id) as distribution,d.road,ad.address_np as location from distributions d LEFT JOIN address ad on ad.id=d.road where d.program_id='.$id.' and d.user_id='.\Auth::user()->id.' and d.deleted_at IS NULL GROUP BY d.road'));
			
			/*getting surveys done according to tol*/
			$disttol = DB::select(DB::raw('select count(d.id) as distribution,d.tol,t.tol_np as tolname from distributions d LEFT JOIN tol t on t.id=d.tol where d.program_id='.$id.' and d.user_id = '.\Auth::user()->id.' and d.deleted_at IS NULL GROUP BY d.tol'));
		else:
			$received = Distribution::where('program_id',$id)->whereNotNull('received_at')->count();
			$registered = Distribution::where('program_id',$id)->whereNotNull('registered_at')->count();
			$todaydist = DB::select( DB::raw("select count(id) as today_dist from distributions where program_id=".$id." and deleted_at=NUll and Date(created_at) = '$today'"))[0];
			
			/*getting distributions done according to address*/
			$distaddress = DB::select(DB::raw('select count(d.id) as distribution,d.road,ad.address_np as location from distributions d LEFT JOIN address ad on ad.id=d.road where d.program_id='.$id.' and d.deleted_at IS NULL GROUP BY d.road'));
			
			/*getting surveys done according to tol*/
			$disttol = DB::select(DB::raw('select count(d.id) as distribution,d.tol,t.tol_np as tolname from distributions d LEFT JOIN tol t on t.id=d.tol where d.program_id='.$id.' and d.deleted_at IS NULL GROUP BY d.tol'));
		endif;
		//dd($disttol);
		 
		$this->setPageTitle($program->title_np."को रिपोर्ट", "");
		return view('admin.distributions.report',compact('program','received','registered','distaddress','disttol','todaydist'));
	}
	
	/*get all distributions*/
	public function getalldistributions(Request $request)
	{	
		//dd($id);
		if(auth()->user()->hasRole('administrator')):
			$query = Distribution::with('user','programs','addresses','tols')->select('distributions.*')->latest();
		else:
			$query = Distribution::with('user','programs','addresses','tols')->select('distributions.*')->where('user_id',\Auth::user()->id)->latest();
		endif;
	
		if (!empty($request->get('citizenship'))) {
		  $query = $query->where('citizenship','=',$request->get('citizenship'));
		}
		
		if (!empty($request->get('mobile'))) {
			$query = $query->where('mobile','LIKE', "%{$request->get('mobile')}%");
		}
		
		//dd($query);
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np;
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('registered_bs',function($data){
				return $data->registered_bs ?? '-';
			})
			->addColumn('mobile',function($data){
				return $data->mobile;
			})
			->addColumn('citizenship',function($data){
				$output = $data->citizenship ? $data->citizenship: 'N/A';
				return $output;
			})
			->addColumn('received_bs',function($data){
				return $data->received_bs ?? '-';
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('remarks',function($data){
				$output = $data->remarks ? Str::limit($data->remarks, 50): '-';
				return $output;
			})
			->addColumn('programs',function($data){
				return $data->programs->title_np;
			})
			->addColumn('action',function($data){
			
			if(auth()->user()->hasRole('administrator')):
				$buttons = '<div class="dropdown d-inline-block">
								<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="ri-more-fill align-middle"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end" style="">
									<li><a href="'.route('admin.distribution.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									<li>
										<form action="'.route('admin.distribution.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
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
									<li><a href="'.route('admin.distribution.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
								</ul>
							</div>';
			endif;		
			return $buttons;
			})
			->rawColumns(['action'])
			->make(true);
	}
	
	/*for datatables distributions*/
	public function getdistributions($programid,Request $request)
	{	
		//dd($id);
		if(auth()->user()->hasRole('administrator')):
			$query = Distribution::with('user','programs','addresses','tols')->select('distributions.*')->where('program_id',$programid)->latest();
        else:
            $query = $query = Distribution::with('user','programs','addresses','tols')->select('distributions.*')->where([['user_id',\Auth::user()->id],['program_id',$programid]])->latest();
		endif;
		
		if (!empty($request->get('mobile'))) {
			$query = $query->where('mobile','=',$request->get('mobile'));
		}
		
		if (!empty($request->get('citizenship'))) {
			$query = $query->where('citizenship','=',$request->get('citizenship'));
		}
		
		//dd($query);
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np;
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('mobile',function($data){
				return $data->mobile;
			})
			->addColumn('citizenship',function($data){
				$output = $data->citizenship ? $data->citizenship: 'N/A';
				return $output;
			})
			->addColumn('registered_bs',function($data){
				return $data->registered_bs ?? '-';
			})
			->addColumn('received_bs',function($data){
				return $data->received_bs ?? '-';
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('remarks',function($data){
				$output = $data->remarks ? Str::limit($data->remarks, 50): '-';
				return $output;
			})
			->addColumn('programs',function($data){
				return $data->programs->title_np;
			})
			->addColumn('action',function($data){
			
			if(auth()->user()->hasRole('administrator')):
				$buttons = '<div class="dropdown d-inline-block">
								<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="ri-more-fill align-middle"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end" style="">
									<li><a href="'.route('admin.distribution.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									<li>
										<form action="'.route('admin.distribution.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
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
									<li><a href="'.route('admin.distribution.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
								</ul>
							</div>';
			endif;		
			return $buttons;
			})
			->rawColumns(['action'])
			->make(true);
	}
	
	/*for datatables trashed distributions*/
	public function gettrasheddistributions()
	{
		$query = Distribution::onlyTrashed()->with(['user','programs','addresses','tols'])->latest()->select('distributions.*');
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np; 
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('registered_at',function($data){
				return $data->registered_at ?? '-';
			})
			->addColumn('received_at',function($data){
				return $data->received_at ?? '-';
			})
			->addColumn('mobile',function($data){
				return $data->mobile;
			})
			->addColumn('citizenship',function($data){
				$output = $data->citizenship ? $data->citizenship: 'N/A';
				return $output;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('remarks',function($data){
				$output = $data->remarks ? Str::limit($data->remarks, 50): '-';
				return $output;
			})
			->addColumn('programs',function($data){
				return $data->programs->title_np;
			})
			->addColumn('action',function($data){
					if(auth()->user()->hasRole('administrator')):
					$button ='<a class="link-danger fs-15" onclick="return confirm("Are you sure?");" href="'.route('admin.distribution.force-delete', $data->id).'">
									<i class="ri-delete-bin-5-line"></i>
								</a>';
					endif;
					$button .= '<a class="link-success fs-15" onclick="return confirm("Are you sure?");" href="'.route('admin.distribution.restore', $data->id).'">
									<i class="ri-refresh-line"></i>
								</a>';	
			return $button;
			})
			->rawColumns(['action'])
			->make(true);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		/*if(!Gate::allows('users_manage')){
            return abort(401);
        }*/
		
		$programs = Program::select('id','title_en','title_np')->where('status',1)->latest()->get();
		$address = Address::get();
		$tol = Tol::get();
		//dd($programs);
		$this->setPageTitle("वितरणहरू", "वितरण थप्नुस");
		if(auth()->user()->hasRole('surveyer')):
			return view("admin.distributions.surveyer-add",compact('programs','address','tol'));
		else:
			 return view("admin.distributions.create",compact('programs','address','tol'));
		endif;
    }
	
	public function save(Distribution $distribution, Request $request){
		$distribution->program_id = $request->program_id;
		$distribution->house_no = $request->house_no;
		$distribution->road = $request->road;
		$distribution->tol = $request->tol;
		$distribution->receiver = $request->receiver_name;
		$distribution->mobile = $request->mobile;
		$distribution->citizenship = $request->citizenship;
		$distribution->remarks = $request->remarks;
		
		$nepalidate = explode("-",$request->registered_at);
		$year = $nepalidate[0];
		$month = $nepalidate[1];
		$day = $nepalidate[2]; 
		
		$converttoad = \Bsdate::nep_to_eng($year,$month,$day);
		//dd($request->registered_at);
		$datead = $converttoad['year'].'-'.$converttoad['month'].'-'.$converttoad['date'];
		
		$distribution->registered_at = $datead;
		$distribution->received_at = $datead;
		
		$distribution->registered_bs = $request->registered_at;
		$distribution->received_bs = (!empty($request->received_at)) ? $request->received_at : $request->registered_at;
		
		$distribution->user_id = \Auth::user()->id;
		
		$distribution->save();
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
		$validator = Validator::make(
			$request->all(),
			[
				'program_id' => 'required',
				'mobile' => 'required|min:10|numeric',
				'receiver_name' => 'required',
				'registered_at' => 'required',
			],
			[
				'program_id.required'=>'कार्यक्रम आवश्यक छ।',
				'receiver_name.required'=>'रिसीभर खाली हुनु हुँदैन',
				'mobile.required'=>'मोबाइल नम्बर आवश्यक छ।',
				'mobile.min'=>'मोबाइल नम्बरको लम्बाइ न्यूनतम १० वर्णको हुनुपर्छ।',
				'mobile.numeric'=>'मोबाइल नम्बर पूर्णांकमा हुनुपर्छ।',
				'registered_at.required'=>'दर्ता मिति आवश्यक छ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		
		$distribution = new Distribution();
		
		if($this->save($distribution,$request)){
           return back()->with('message','Successfully added data for house number '.$request->house_no);
        }else{
			return back()->with('message','Successfully added data for house number '.$request->house_no);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
    public function show(Distribution $distribution)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
         if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$program = Distribution::where("id", $slug)->firstOrFail();
		$programs = Program::select('id','title_en','title_np')->where('status',1)->orderBy('title_en','ASC')->get();
		$address = Address::get();
		$tol = Tol::get();
		//dd($programs);
		$this->setPageTitle("वितरणहरू", "सम्पादन वितरण");
        return view("admin.distributions.edit",compact('programs','program','address','tol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request,$id)
    {
		$distribution = Distribution::find($id);
        
		if($this->save($distribution,$request)){
            return redirect(route("admin.distribution.all"))->with('message','Successfully updated data for house number '.$request->house_no);
        }else{
			return redirect(route("admin.distribution.all"))->with('message','Successfully updated data for house number '.$request->house_no);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Distribution  $distribution
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

		$distribution = Distribution::find($id);
        //dd($compost);
		if($distribution->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
	
	/*deleting permanently*/
	public function forceDelete($id)
	{
		$distribution = Distribution::withTrashed()->find($id);
		if(!is_null($distribution)):
			$distribution->forceDelete();
		endif;
		
		return redirect(route('admin.distribution.all'))->with('message','Data permanently deleted!!');
	}
	
	/*restoring temporarily deleted data*/
	public function restore($id)
	{
		$distribution = Distribution::onlyTrashed()->find($id);
		if(!is_null($distribution)):
			$distribution->restore();
		endif;
		
		return Redirect(route('admin.distribution.all'))->with('message','Data restored successfully!!');
	}
}
