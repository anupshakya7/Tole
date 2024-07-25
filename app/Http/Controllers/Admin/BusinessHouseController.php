<?php

namespace App\Http\Controllers\Admin;

use App\BusinessHouse;
use App\Address;
use App\Tol;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;

use Image;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media; 

class BusinessHouseController extends BaseController
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
		
        $this->setPageTitle('व्यवसायिक घर', 'List of all Business House'); 
		return view('admin.businesshouse.index',compact('address','tol','job'));		
        //return view('admin.houseowner.index',compact('houses'));
     }
	 
	 /*for datatables*/
	 public function getBusinesshouse(Request $request)
	 {
		$model = BusinessHouse::with(['addresses','tols','user'])->select('business_house.*')->orderBy('id','DESC');
		if (!empty($request->get('contact'))) {
			$model = $model->where('contact','=',$request->get('contact'));
			//dd($model);
		}
		if (!empty($request->get('house_no'))) {
			$model = $model->where('house_no','LIKE', "{$request->get('house_no')}%",);
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
			->addColumn('business_name',function($data){
				$output = '<div class="d-flex align-items-center">
								<div class="flex-shrink-0"><img src="'.($data->getFirstMediaUrl() ? $data->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg')).'" alt="'.$data->business_name.'" title="'.$data->business_name.'" class="avatar-xs"></div>
								<div class="flex-grow-1 ms-2 name">'.$data->business_name.'</div>
							</div>'; 
				return $output;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np;
			})
			->addColumn('tols',function($data){
				if($data->tol!='0')
				return $data->tol!='0' ? $data->tols->tol_np : 'N/A';
			})
			->addColumn('contact',function($data){
				$output = $data->contact ?? '-';
				return $output;			
			})
			->addColumn('action',function($data){
					$buttons = '<div class="dropdown d-inline-block">
									<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
										<i class="ri-more-fill align-middle"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-end" style="">
										<li><a href="'.route('admin.business.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
										<li>
											<form action="'.route('admin.business.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
												<input type="hidden" name="_method" value="DELETE">
												<input type="hidden" name="_token" value="'.csrf_token().'">
												<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
											</form>
										</li>
									</ul>
								</div>';
				return $buttons;
			})
			->rawColumns(['business_name','action'])
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
		$businesstype = BusinessHouse::select('id','business_type')->where('business_type','!=','')->groupBy('business_type')->get();
		
		
		
        $this->setPageTitle("व्यवसायिक घर", "व्यवसायिक घरको डाटा थप्नुहोस्");
        return view("admin.businesshouse.create",compact('address','tol','businesstype'));
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
        
        
       
        $business = new BusinessHouse();
        
        
        if($request->hasfile('business_certificate')):
			$business->addMedia($request->file('business_certificate'))->toMediaCollection();
		else:
			$business->image = NULL;
		endif;
		
        /*if($request->hasfile('business_certificate')){
           //dd($request->file('business_certificate'));
           $file = $request->file('business_certificate');
           
           	$originalName = time().'_'.$file->getClientOriginalName();
           	
			$filename = time().'-'.$originalName;
			//dd($filename);
			$fullpath = 'business_house/'.$filename;
			$path = $file->storeAs('business_house',$filename);
			
			$business->business_certificate = $fullpath;
			
			
       }*/
       
        $business->house_no = $request->house_no;
        $business->road = $request->road;
        $business->tol = $request->tol;
        $business->contact = $request->contact;
        $business->business_name = $request->business_name;
        
        $business->business_name = $request->business_name;
		
		$business->business_reg_date = $request->business_reg_date;
		$business->business_certi_no = $request->business_certi_no;
		$business->location_swap_ward = $request->location_swap_ward;
		$business->location_swap_date = $request->location_swap_date;
		$business->last_renewed_year = $request->last_renewed_year;
		
		$business->created_by = \Auth::user()->id;

        if($business->save()){
            return redirect(route('admin.business.index'))->with('message','Successfully inserted data for '.$request->house_no);
        }else{
            return redirect(route('admin.business.index'))->with('message','Unable to insert data of '.$request->house_no);
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

        $business = BusinessHouse::where("id", $slug)->firstOrFail();
		$address = Address::get();
		$tol = Tol::get();
		$businesstype = BusinessHouse::select('id','business_type')->where('business_type','!=','')->groupBy('business_type')->get();
        //dd($compost);
         $this->setPageTitle("व्यवसायिक घर", "व्यवसायिक घर अपडेट गर्नुहोस्");
        return view('admin.businesshouse.edit', compact('business','address','tol','businesstype'));
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
        $business = BusinessHouse::find($id);
        
        if($request->file('business_certificate')){
			if (isset($request->mediaid) && !empty($request->mediaid)):
				$media = Media::where('model_id',$request->mediaid)->first();
				if($media)://dd($media->model_type);
					$model_type = $media->model_type;
					
					$model = $model_type::find($media->model_id);
					//dd($model);
					$model->deleteMedia($media->id);
				endif;
			endif;
			
			$business->addMedia($request->file('business_certificate'))->toMediaCollection();
		}
		
        $business->house_no = $request->house_no;
        $business->road = $request->road;
        $business->tol = $request->tol;
        $business->contact = $request->contact;
        $business->business_name = $request->business_name;
        
        $business->business_reg_date = $request->business_reg_date;
		$business->business_certi_no = $request->business_certi_no;
		$business->location_swap_ward = $request->location_swap_ward;
		$business->location_swap_date = $request->location_swap_date;
		$business->last_renewed_year = $request->last_renewed_year;
        
		$business->business_type = $request->business_type;
		$business->created_by = \Auth::user()->id;

        if($business->save()){
		  return redirect(route("admin.business.index"))->with("message",$request->owner . " updated successfully");
        }else{
		  return redirect(route("admin.business.index"))->with("message","Unable to update " . $request->owner);
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

		$business = BusinessHouse::find($id);
        //dd($compost);
		if($business->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}
