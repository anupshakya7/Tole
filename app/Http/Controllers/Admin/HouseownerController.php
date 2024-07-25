<?php

namespace App\Http\Controllers\Admin;

use App\Houseowner;
use App\MedicalSurvey;
use App\Address;
use App\Tol;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;

class HouseownerController extends BaseController
{
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

        //$houses = Houseowner::latest()->get();
        //dd($houses);
		$address = Address::select('address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$job = \App\Occupation::select('id','occupation_np')->get();
		
        $this->setPageTitle('घर धनी', 'List of all House Owners'); 
		return view('admin.houseowner.index_yajra',compact('address','tol','job'));		
        //return view('admin.houseowner.index',compact('houses'));
     }
	 
	 /*remaining houses to survey*/
	 public function remainder()
	 {
		if(!Gate::allows('users_manage')){
            return abort(401);
        }

        // $houses = Houseowner::whereNull('compostbinsurveys.house_no')->leftJoin('compostbinsurveys', 'compostbinsurveys.house_no', '=', 'house_owner.house_no')->get();
        $houses = DB::select( DB::raw("SELECT ho.id
        FROM house_owner ho LEFT OUTER JOIN compostbinsurveys cs 
             ON ho.house_no = cs.house_no
        WHERE cs.house_no is NULL") );
        
        $arrdata = array();
        
        foreach($houses as $data){
            $row = Houseowner::find($data->id);
            array_push($arrdata, $row);
        }	
        //dd($arrdata);die();
        $this->setPageTitle('सर्वेक्षण हुन बाँकी घरहरू', 'List of all House Owners');    
        return view('admin.houseowner.remaining',compact('arrdata'));
	 }
	 
	 
	 public function remaindermedical()
	 {
		if(!Gate::allows('users_manage')){    
            return abort(401);
        }
		 $houses =  DB::select(DB::raw('select ho.id from medical_survey ms
			 right join house_owner ho on ms.house_no=ho.house_no and ms.road=ho.road and ms.tol=ho.tol 
			where ms.house_no is null'));
			
		$arrdata = array();
        
        foreach($houses as $data){
            $row = Houseowner::find($data->id);
            array_push($arrdata, $row);
        }	
		//dd($arrdata);
        $this->setPageTitle('मेडिकल सर्वेक्षण हुन बाँकी घरहरू', 'List of all House Owners');    
        return view('admin.houseowner.remainingmedical',compact('arrdata'));
	 }
	 
	  
	 
	 /*for datatables*/
	 public function getHouseowner(Request $request)
	 {
		$model = Houseowner::with(['addresses','tols','job'])->select('house_owner.*');
		if (!empty($request->get('contact'))) {
			$model = $model->where('contact','=',$request->get('contact'));
			//dd($model);
		}
		if (!empty($request->get('mobile'))) {
			$model = $model->where('mobile','LIKE', "%{$request->get('mobile')}%");
			//dd($model);
		}
		if (!empty($request->get('house_no'))) {
			$model = $model->where('house_no','=', "{$request->get('house_no')}");
			//dd($model);
		}
		if (!empty($request->get('gender'))) {
			$model = $model->where('gender',$request->get('gender'));
			//dd($model);
		}

		//return $model;die();
		  return DataTables::of($model)
			/*->filter(function ($query) {
                    if (request()->has('contact')) {
                        dd('test');
                    }
			 })*/
			->addIndexColumn()
			->addColumn('taxpayer_id',function($data){
				$output = $data->taxpayer_id ?? 'N/A';
				return $output;			
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np;
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('contact',function($data){
				$output = $data->contact ?? '-';
				return $output;			
			})
			->addColumn('responent',function($data){
				$output = $data->responent ?? '-';
				return $output;	
				
			})
			->addColumn('mobile',function($data){
				$output = $data->mobile ?? '-';
				return $output;	
				
			})			
			->addColumn('job',function($data){
				$output = $data->job->occupation_np ?? '-';
				return $output;			
			})
			->addColumn('no_of_tenants',function($data){
				$output = $data->no_of_tenants ?? '-';
				return $output;			
			})
			->addColumn('gender',function($data){
				$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : "F") : '-';
				return $output;
			})
			->addColumn('action',function($data){
					$buttons = '<div class="dropdown d-inline-block">
									<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="ri-more-fill align-middle"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end" style="">
										<li><a href="'.route('admin.house.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
										<li>
											<form action="'.route('admin.house.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="'.csrf_token().'">
												<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
											</form>
										</li>
									</ul>
								</div>';
				return $buttons;
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
		$address = Address::get();
		$tol = Tol::get();
		
        $this->setPageTitle("घर धनि", "घर धनिको डाटा थप्नुहोस्");
        return view("admin.houseowner.create",compact('address','tol'));
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
        $owner = new Houseowner();
		$owner->taxpayer_id = $request->taxpayer_id;
        $owner->house_no = $request->house_no;
        $owner->owner = $request->owner;
		$owner->owner_np = $request->owner_np;
        $owner->road = $request->road;
        $owner->tol = $request->tol;
        $owner->contact = $request->contact;
        $owner->mobile = $request->mobile;
        $owner->responent = $request->responent;
		$owner->responent_np = $request->responent_np;
        $owner->occupation = $request->occupation;
		$owner->no_of_tenants = $request->no_of_tenants;
        $owner->gender = $request->gender;

        if($owner->save()){
            return redirect(route('admin.house.index'))->with('message','Successfully inserted data for '.$request->house_no);
        }else{
            return redirect(route('admin.house.index'))->with('message','Unable to insert data of '.$request->house_no);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Houseowner  $houseowner
     * @return \Illuminate\Http\Response
     */
    public function show(Houseowner $houseowner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Houseowner  $houseowner
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $owner = Houseowner::where("id", $slug)->firstOrFail();
		$address = Address::get();
		$tol = Tol::get();
        //dd($compost);
        $this->setPageTitle('House Owner', 'Edit House Owner');
        return view('admin.houseowner.edit', compact('owner','address','tol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Houseowner  $houseowner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //dd($request->all());
        $owner = Houseowner::find($id);
        //dd($owner);
		$owner->taxpayer_id = $request->taxpayer_id;
        $owner->house_no = $request->house_no;
        $owner->owner = $request->owner;
		$owner->owner_np = $request->owner_np;
        $owner->road = $request->road;
        $owner->tol = $request->tol;
        $owner->contact = $request->contact;
        $owner->mobile = $request->mobile;
        $owner->responent = $request->respondent;
		$owner->responent_np = $request->respondent_np;
        $owner->occupation = $request->occupation;
		$owner->no_of_tenants = $request->no_of_tenants;
        $owner->gender = $request->gender;

        if($owner->save()){
		  return redirect(route("admin.house.index"))->with("message",$request->owner . " updated successfully");
        }else{
		  return redirect(route("admin.house.index"))->with("message","Unable to update " . $request->owner);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Houseowner  $houseowner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

		$owner = Houseowner::find($id);
        //dd($compost);
		if($owner->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}
