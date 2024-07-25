<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Abeden;
use App\Memberabeden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;

class MembersabedanController extends BaseController
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
		//dd('test');
		//$mabeden = Memberabeden::with('members','abedans')->latest()->get();
		//dd($mabeden);
		$this->setPageTitle("दर्ता भएका निवेदनहरु", "दर्ता भएका निवेदनहरु");    
		return view('admin.memberabedan.index');
    }
	
	public function getMemberabeden()
	{
		$query = Memberabeden::with('members','abedans','sifaris')->latest()->get();
		//dd($query);
		/*foreach($query as $data):
			echo $data->getFirstMediaUrl();
		endforeach;*/
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('members',function($data){				
				return $data->members->fullname_np;
			})
			->addColumn('abedans',function($data){
				return $data->abedans->title;
			})
			->addColumn('abeden_date',function($data){
				return $data->abeden_date;
			})
			->addColumn('sifaris', function ($data) {
				//return '<a href="'.route('admin.membersabeden.sifaris', ['memberid'=>$data->member_id,'memberabedanid'=>$data->abeden_id,'abedanid'=>$data->id]).'" class="badge badge-soft-info groupadd">सिर्जना गर्नुहोस्</a>';				
                $output = '<a href="'.route('admin.membersabeden.sifaris', ['memberid'=>$data->member_id,'memberabedanid'=>$data->abeden_id,'abedanid'=>$data->id]).'" class="badge badge-soft-success groupadd">सिर्जना गर्नुहोस्</a>';
				foreach($data->sifaris as $msifaris):
					$output.='<br><a href="'.route('admin.membersifaris.show', $msifaris->id).'" class="badge badge-outline-info">'.$data->abedans->title.'<br>'.$data->abedans->created_at->diffForHumans().'</a>';
				endforeach;
				
				return $output;
				})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('action',function($data){
				$buttons = '<div class="dropdown d-inline-block">
								<button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="ri-more-fill align-middle"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end" style="">
									<li><a href="'.route('admin.membersabeden.show', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
								</ul>
							</div>'; 
			return $buttons;
			})			
			->rawColumns(['sifaris','action'])
			->make(true);	
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
	
	/*generating and saving sifaris from abedan index page*/
	public function sifaris($memberid,$abedanid,$memberabedanid)
	{
		
		//converting current date to nepali bs date
		$nepdate = \Bsdate::eng_to_nep(Date('Y'),Date('m'),Date('d'));
		$datebs = $nepdate['year'].'-'.$nepdate['month'].'-'.$nepdate['date'];
		$member = \App\Member::with('familys','tols','contacts')->find($memberid);
		
		//dd($member);
		$abedan = Memberabeden::where([['abeden_id','=',$abedanid],['member_id','=',$memberid]])->firstOrFail();
		$sifaris = Abeden::findOrFail($abedanid);
		//dd($abedan);
		$form1 = $sifaris->sifaris;
		//$applicantimg = '<img src="'.$member->getFirstMediaUrl().'" width="80" style="margin:15px 0px;">';
		$tobereplaced1 = ['[grandfather-name]','[father-name]','[applicant-name]','[tol-dropdown]','[applicant-citizenship]','[curr-date]'];
		$replacedby1 = [$member->familys->grandfather_name,$member->familys->father_name,$member->fullname_np,$member->tols->tol_np,$member->citizenship,$datebs];
		//dd($member->familys);
		$sifarishtml = str_replace($tobereplaced1,$replacedby1,$form1);
		
		//dd($sifaris);
		
		$this->setPageTitle('सिफारिस फारम', 'सिफारिस फारम');
        return view('admin.abeden.sifaris-form',compact('sifaris','datebs','sifarishtml','abedan','memberabedanid'));
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        	if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$mgroups = new Membergroup();
		
		$mgroups->title_en = $request->title_en;
		$mgroups->title_np = $request->title_np;
		//$education->save();
		
		if($mgroups->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("error", "Sorry!! But the data ".$request->title_en." could not be added.");
		endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //dd($slug);
		/*getting members that are not in pivot table i.e. group_members*/
		$memberabedan = Memberabeden::findOrFail($slug);
		$member = \App\Member::find($memberabedan->member_id);
		$abedan = Abeden::find($memberabedan->abeden_id);
		//dd($abedan);
		$this->setPageTitle($member->fullname_np."को ".$abedan->title." निबेदन", $member->fullname_np."को ".$abedan->title." निबेदन"); 
		return view('admin.memberabedan.show',compact('memberabedan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Membergroup $membergroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membergroup $membergroup)
    {
        //
    }
	
	//add member abeden to memberabeden table
	public function add(Request $request)
	{
		$memberabeden = new Memberabeden();
		if($request->ajax())
		{
			$memberabeden->member_id = $request->memberid;
			$memberabeden->abeden_id = $request->abedenid;
			$memberabeden->abeden_date = $request->abedendate;
			$memberabeden->description = $request->abedenhtml;
			
			if($memberabeden->save()){
				return "success";
			}else{
				return "failed";
			}
		}
	}
}
