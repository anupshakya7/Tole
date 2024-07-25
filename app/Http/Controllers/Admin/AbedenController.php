<?php

namespace App\Http\Controllers\Admin;

use App\Abeden;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class AbedenController extends BaseController
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
		
		$this->setPageTitle("निवेदनको ढाँचाहरू", "निवेदन ढाँचाहरूको सूची");    
		return view('admin.abeden.index');
    }
	
	/*for datatables */
	public function getabeden()
	{
		$query = Abeden::with('user')->latest()->get();
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('title',function($data){
				return $data->title;
			})
			->addColumn('abeden',function($data){				
				return Str::limit($data->abeden, 100 );
			})
			->addColumn('sifaris',function($data){				
				return Str::limit($data->sifaris, 100 );
			})
			->addColumn('required_docs',function($data){				
				return Str::limit($data->required_docs, 100 );
			})
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('status',function($data){	
				$output = $data->status==0 ? 'INACTIVE': 'ACTIVE';	
				return $output;
			})
			->addColumn('action',function($data){
				$buttons = '<div class="dropdown d-inline-block">
								<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="ri-more-fill align-middle"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end" style="">
									<li><a href="'.route('admin.abeden.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									<li>
										<form action="'.route('admin.abeden.destroy', $data->id).'" class="deleteabeden" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
											<input type="hidden" name="_method" value="DELETE">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<button type="submit" class="dropdown-item remove-item-btn" onclick="deleteabeden($(this));" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
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
        if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$this->setPageTitle("निवेदन ढाँचा", "निवेदन ढाँचा सिर्जना गर्नुहोस्");
        return view("admin.abeden.create");
    }
	
	
	public function save(Abeden $abeden, Request $request){
			if(isset($request->status)){
            $status = 1;
        }else{
            $status = 0;
        }
		 $abeden->title = $request->title;
		 $abeden->title_en = $request->title_en;
		 $abeden->status = $status;
		 $abeden->abeden = $request->abeden;
		 $abeden->sifaris = $request->sifaris;
		 $abeden->nibedan_en = $request->abeden_en;
		 $abeden->sifaris_en = $request->sifaris_en;
		 $abeden->required_docs = $request->required_docs;		 
		 $abeden->user_id = \Auth::user()->id;
		 $abeden->save();
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
        $abeden = new Abeden();
		 
		if($this->save($abeden,$request)){
           return redirect(route("admin.abeden.index"))->with('message','Successfully added data for '.$request->title);
        }else{
			return redirect(route("admin.abeden.index"))->with('message','Successfully added data for '.$request->title);
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

        $abeden = Abeden::where("id", $slug)->firstOrFail();
        //dd($compost);
        $this->setPageTitle('निवेदन', 'सम्पादन निवेदन');
        return view('admin.abeden.edit',compact('abeden'));
    }
	
	public function add(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
		
		
		
        $abeden = Abeden::find($request->abeden);
		
		
		$member = \App\Member::with('familys','tols','contacts')->where('citizenship',$request->memcitizen)->first();
		//dd($member);
		if(is_null($member)){
			return back()->with('message',$request->memcitizen.' नागरिकता नम्बर हाम्रो प्रणालीमा अवस्थित छैन');
		}else{
			//converting current date to nepali bs date
			$nepdate = \Bsdate::eng_to_nep(Date('Y'),Date('m'),Date('d'));
			$datebs = $nepdate['year'].'-'.$nepdate['month'].'-'.$nepdate['date'];
			$datead = Date('Y').'/'.Date('m').'/'.Date('d');
			
			$form = $abeden->abeden;
			$formen = $abeden->nibedan_en;
			$tobereplaced = ['[applicant-name]','[tol-dropdown]','[father-name]','[grandfather-name]','[applicant-citizenship]','[mobile-no]','[curr-date]'];
			$replacedby = [$member->fullname_np,$member->tols->tol_np,$member->familys->father_name,$member->familys->grandfather_name,$member->citizenship,$member->contacts->mobile_no,$datebs];
			//dd($member->familys);
			$abedenhtml = str_replace($tobereplaced,$replacedby,$form);
			
			$tobereplaceden = ['[applicant-name]','[tol-dropdown]','[father-name]','[grandfather-name]','[applicant-citizenship]','[mobile-no]','[curr-endate]'];
			$replacedbyen = [$member->full_name,$member->tols->tol,$member->familys->father_np,$member->familys->grandfather_np,$member->citizenship,$member->contacts->mobile_no,$datead];
			$abedenhtmlen = str_replace($tobereplaceden,$replacedbyen,$formen);
			
			$form1 = $abeden->sifaris;
			$form1en = $abeden->sifaris_en;
			$applicantimg = '<img src="'.$member->getFirstMediaUrl().'" width="80" style="margin:15px 0px;">';
			$tobereplaced1 = ['[applicant-name]','[tol-dropdown]','[applicant-citizenship]','[curr-date]','[applicant-image]'];
			$replacedby1 = [$member->fullname_np,$member->tols->tol_np,$member->citizenship,$datebs,$applicantimg];
			//dd($member->familys);
			$sifarishtml = str_replace($tobereplaced1,$replacedby1,$form1);
			
			$applicantimg = '<img src="'.$member->getFirstMediaUrl().'" width="80" style="margin:15px 0px;">';
			$tobereplaced1en = ['[applicant-name]','[tol-dropdown]','[applicant-citizenship]','[curr-date]','[applicant-image]'];
			$replacedby1en = [$member->full_name,$member->tols->tol,$member->citizenship,$datead,$applicantimg];
			//dd($member->familys);
			$sifarishtmlen = str_replace($tobereplaced1en,$replacedby1en,$form1);
			//$tols = str_replace('[tol-dropdown]',$member->tols->tol_np,$name);
			
			//dd($datebs);
			//dd($member);
			$this->setPageTitle('निवेदन फारम', 'निवेदन फारम');
			return view('admin.abeden.abeden-form',compact('abeden','abedenhtml','abedenhtmlen','sifarishtml','sifarishtmlen','abeden','member','datebs'));
		}
		
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
        $abeden = Abeden::find($id);
		//dd($request);
		if($this->save($abeden,$request)){
            return redirect(route("admin.abeden.index"))->with('message','Successfully updated data for '.$request->title);
        }else{
			return redirect(route("admin.abeden.index"))->with('message','Successfully updated data for '.$request->title);
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

		$nibedan = Abeden::find($id);
        //dd($compost);
		if($nibedan->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}
