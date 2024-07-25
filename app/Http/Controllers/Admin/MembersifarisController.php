<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Abeden;
use App\Membersifaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;

class MembersifarisController extends BaseController
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
		$this->setPageTitle("सदस्यहरूको सिफारिस", "सदस्यहरूको सिफारिस सूची");    
		return view('admin.MembersSifaris.index');
    }
	
	public function getMembersifaris()
	{
		$query = Membersifaris::with('members','abedans')->latest()->get();
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
			->addColumn('sifaris_date',function($data){
				return $data->sifaris_date;
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
									<li><a href="'.route('admin.membersifaris.show', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
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
        //
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
       $membersifaris = Membersifaris::findOrFail($slug);
	   $member = \App\Member::find($membersifaris->member_id);
	   $sifaris = Abeden::find($membersifaris->abeden_id);
	   
	   $this->setPageTitle($member->fullname_np."को ".$sifaris->title, $member->fullname_np."को ".$sifaris->title); 
		return view('admin.MembersSifaris.show',compact('membersifaris'));
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
	
	//add member sifaris to members_sifaris table
	public function add(Request $request)
	{
		$membersifaris = new Membersifaris();
		if($request->ajax())
		{
			$membersifaris->member_id = $request->memberid;
			$membersifaris->memberabedan_id = $request->memberabedanid;
			$membersifaris->abeden_id = $request->abedenid;
			$membersifaris->sifaris_date = $request->abedendate;
			$membersifaris->description = $request->sifarishtml;
			
			if($membersifaris->save()){
				return "success";
			}else{
				return "failed";
			}
		}
	}
}
