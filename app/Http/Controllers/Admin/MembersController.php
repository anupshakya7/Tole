<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Member;
use App\Contactdetail;
use App\Membereducation;
use App\Memberdocument;
use App\Memberfamily;
use App\Membermedical;
use App\Address;
use App\GroupsMember;
use App\Tol;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

use Image;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media; 

use App\Http\Controllers\BaseController;

class MembersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
		$this->setPageTitle("सदस्यहरू","सदस्यहरूको सूची");
		return view("admin.members.index",compact('designations','address','tol','job'));
    }
	/*temporary senior citizens view*/
	public function seniorctzn()
	{
		$address = Address::select('id','address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$job = \App\Occupation::select('id','occupation_np')->get();

		$this->setPageTitle("जेष्ठ नागरिक","जेष्ठ नागरिक सूची");
		return view('admin.members.senior',compact('address','tol','job'));
		
	}
	
	/*senior citizens between 68 and 70*/
	public function seniorctznabovesixtyeight()
	{
	    $address = Address::select('id','address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$job = \App\Occupation::select('id','occupation_np')->get();
        
        $this->setPageTitle("जेष्ठ नागरिक(६८-७०)","जेष्ठ नागरिक (६८-७०) सूची");
		return view('admin.members.seniorsixtyeight',compact('address','tol','job'));
	}
	
	/*for datatables senior citizens between 68 and 70*/
	public function getseniorcitzabovesiztyeight(Request $request)
	{
	    $minAge=date('Y-m-d', strtotime("-68 years"));
        $maxAge=date('Y-m-d', strtotime("-71 years"));
		
		$query = Member::with(['user','contacts','addresses','tols','job','groups','mabedans'])->whereBetween(DB::raw('date(dob_ad)'), [$maxAge, $minAge])
                ->where('dob_ad', '!=', 'N/A')
                ->select('members.*'); 
        
        if (!empty($request->get('martial_status'))) {
			$query = $query->where('martial_status',$request->get('martial_status'));
		}
		
		if (!empty($request->get('dob_ad'))) {
			$query = $query->where('dob_ad','LIKE',"%{$request->get('dob_ad')}%");
		}
		
		if (!empty($request->get('gender'))) {
			$query = $query->where('gender','=',$request->get('gender'));
		}
		
		if (!empty($request->get('blood_group'))) {
			$query = $query->where('blood_group','=',$request->get('blood_group'));
		}
		
		if (!empty($request->get('full_name'))) {
			$query = $query->where('full_name','LIKE', "%{$request->get('full_name')}%");
		}
		
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('sms', function ($data) {
				
				//$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" mobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success">Send SMS</button>';
				$output = "";
				if(is_null($data->contacts)){
					$output = '<button class="badge badge-soft-success">Mobile N/A</button>';
				}else{
					$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" memname="'.$data->full_name.'" memmobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success"><i class=" ri-mail-send-line"></i> SMS</button>';
				}
				return $output;
                })
			->addColumn('full_name',function($data){
				$output = '<div class="d-flex align-items-center">
								<div class="flex-shrink-0"><img src="'.($data->getFirstMediaUrl() ? $data->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg')).'" alt="'.$data->full_name.'" title="'.$data->full_name.'" class="avatar-xs rounded-circle"></div>
								<div class="flex-grow-1 ms-2 name">'.$data->full_name.'</div>
							</div>'; 
				return $output;
			})
			->addColumn('dob_ad',function($data){
				return $data->dob_ad!='N/A' ? $data->dob_ad : 'N/A';				
			})
			->addColumn('age',function($data){
				$dob = Carbon::parse($data->dob_ad);
				$output = $data->dob_ad=='N/A' ? 'N/A' : $dob->diffInYears(now());
				return $output;
			}) 			
			->addColumn('contacts',function($data){
				if($data->contacts):
					return $data->contacts->mobile_no ? $data->contacts->mobile_no : '-';
				else:
					return '-';
				endif;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np; 
			})
			->addColumn('job',function($data){
				$output = $data->job->occupation_np ?? '-';
				return $output;			
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('gender',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				if($data->gender==1){ $output = "M";}
				if($data->gender==2){ $output = "F";}
				if($data->gender==3){ $output = "O";}
				if($data->gender==9){ $output = "N/A";}
				return $output;
			})
			->addColumn('martial_status',function($data){
				if($data->martial_status==1){ $output = "अविवाहित";}
				if($data->martial_status==2){ $output = "विवाहित";}
				if($data->martial_status==3){ $output = "सम्बन्धविच्छेद भएको";}
				if($data->martial_status==4){ $output = "विधवा";}
				if($data->martial_status==9){ $output = "N/A";}
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
									<li><a href="'.route('admin.member.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									<li>
										<form action="'.route('admin.member.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
											<input type="hidden" name="_method" value="DELETE">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
										</form>
									</li>
								</ul>
							</div>';
			return $buttons;
			})
			->rawColumns(['full_name','action'])
			->make(true);
	}
	
	/*senior citizens above 60 years*/
	public function seniorctznsixty()
	{
	    $address = Address::select('id','address_np')->get();
		$tol = Tol::select('tol_np')->get();
		$job = \App\Occupation::select('id','occupation_np')->get();
        
        $this->setPageTitle("जेष्ठ नागरिक(६८ माथि)","जेष्ठ नागरिक (६८ माथि) सूची");
		return view('admin.members.seniorsixty',compact('address','tol','job'));
	}
	
	/*for datatables senior citizens*/
	public function getseniorcitizens(Request $request)
	{
		$years=date('Y-m-d', strtotime("-60 years"));
		$query = Member::with(['user','contacts','addresses','tols','job','groups','mabedans'])->where(DB::raw('date(dob_ad)'),'<=',$years)->where('dob_ad','!=','N/A')->select('members.*');
		
	
		if (!empty($request->get('martial_status'))) {
			$query = $query->where('martial_status',$request->get('martial_status'));
		}
		
		if (!empty($request->get('dob_ad'))) {
			$query = $query->where('dob_ad','LIKE',"%{$request->get('dob_ad')}%");
		}
		
		if (!empty($request->get('gender'))) {
			$query = $query->where('gender','=',$request->get('gender'));
		}
		
		if (!empty($request->get('blood_group'))) {
			$query = $query->where('blood_group','=',$request->get('blood_group'));
		}
		
		if (!empty($request->get('full_name'))) {
			$query = $query->where('full_name','LIKE', "%{$request->get('full_name')}%");
		}
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('sms', function ($data) {
				
				//$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" mobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success">Send SMS</button>';
				$output = "";
				if(is_null($data->contacts)){
					$output = '<button class="badge badge-soft-success">Mobile N/A</button>';
				}else{
					$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" memname="'.$data->full_name.'" memmobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success"><i class=" ri-mail-send-line"></i> SMS</button>';
				}
				return $output;
                })
			->addColumn('full_name',function($data){
				$output = '<div class="d-flex align-items-center">
								<div class="flex-shrink-0"><img src="'.($data->getFirstMediaUrl() ? $data->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg')).'" alt="'.$data->full_name.'" title="'.$data->full_name.'" class="avatar-xs rounded-circle"></div>
								<div class="flex-grow-1 ms-2 name">'.$data->full_name.'</div>
							</div>'; 
				return $output;
			})
			->addColumn('dob_ad',function($data){
				return $data->dob_ad!='N/A' ? $data->dob_ad : 'N/A';				
			})
			->addColumn('age',function($data){
				$dob = Carbon::parse($data->dob_ad);
				$output = $data->dob_ad=='N/A' ? 'N/A' : $dob->diffInYears(now());
				return $output;
			}) 			
			->addColumn('contacts',function($data){
				if($data->contacts):
					return $data->contacts->mobile_no ? $data->contacts->mobile_no : '-';
				else:
					return '-';
				endif;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np; 
			})
			->addColumn('job',function($data){
				$output = $data->job->occupation_np ?? '-';
				return $output;			
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('gender',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				if($data->gender==1){ $output = "M";}
				if($data->gender==2){ $output = "F";}
				if($data->gender==3){ $output = "O";}
				if($data->gender==9){ $output = "N/A";}
				return $output;
			})
			->addColumn('martial_status',function($data){
				if($data->martial_status==1){ $output = "अविवाहित";}
				if($data->martial_status==2){ $output = "विवाहित";}
				if($data->martial_status==3){ $output = "सम्बन्धविच्छेद भएको";}
				if($data->martial_status==4){ $output = "विधवा";}
				if($data->martial_status==9){ $output = "N/A";}
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
									<li><a href="'.route('admin.member.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									<li>
										<form action="'.route('admin.member.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
											<input type="hidden" name="_method" value="DELETE">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
										</form>
									</li>
								</ul>
							</div>';
			return $buttons;
			})
			->rawColumns(['full_name','action'])
			->make(true);
			
	}
	
	/*for datatables senior citizens with age greater than 60*/
	public function getseniorsixty(Request $request)
	{
		$years=date('Y-m-d', strtotime("-68 years"));
		$query = Member::with(['user','contacts','addresses','tols','job','groups','mabedans'])->where(DB::raw('date(dob_ad)'),'<',$years)->where('dob_ad','!=','N/A')->select('members.*');
	
		if (!empty($request->get('martial_status'))) {
			$query = $query->where('martial_status',$request->get('martial_status'));
		}
		
		if (!empty($request->get('dob_ad'))) {
			$query = $query->where('dob_ad','LIKE',"%{$request->get('dob_ad')}%");
		}
		
		if (!empty($request->get('gender'))) {
			$query = $query->where('gender','=',$request->get('gender'));
		}
		
		if (!empty($request->get('blood_group'))) {
			$query = $query->where('blood_group','=',$request->get('blood_group'));
		}
		
		if (!empty($request->get('full_name'))) {
			$query = $query->where('full_name','LIKE', "%{$request->get('full_name')}%");
		}
		
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('sms', function ($data) {
				
				//$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" mobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success">Send SMS</button>';
				$output = "";
				if(is_null($data->contacts)){
					$output = '<button class="badge badge-soft-success">Mobile N/A</button>';
				}else{
					$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" memname="'.$data->full_name.'" memmobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success"><i class=" ri-mail-send-line"></i> SMS</button>';
				}
				return $output;
                })
			->addColumn('full_name',function($data){
				$output = '<div class="d-flex align-items-center">
								<div class="flex-shrink-0"><img src="'.($data->getFirstMediaUrl() ? $data->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg')).'" alt="'.$data->full_name.'" title="'.$data->full_name.'" class="avatar-xs rounded-circle"></div>
								<div class="flex-grow-1 ms-2 name">'.$data->full_name.'</div>
							</div>'; 
				return $output;
			})
			->addColumn('dob_ad',function($data){
				return $data->dob_ad!='N/A' ? $data->dob_ad : 'N/A';				
			})
			->addColumn('age',function($data){
				$dob = Carbon::parse($data->dob_ad);
				$output = $data->dob_ad=='N/A' ? 'N/A' : $dob->diffInYears(now());
				return $output;
			}) 			
			->addColumn('contacts',function($data){
				if($data->contacts):
					return $data->contacts->mobile_no ? $data->contacts->mobile_no : '-';
				else:
					return '-';
				endif;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np; 
			})
			->addColumn('job',function($data){
				$output = $data->job->occupation_np ?? '-';
				return $output;			
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('gender',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				if($data->gender==1){ $output = "M";}
				if($data->gender==2){ $output = "F";}
				if($data->gender==3){ $output = "O";}
				if($data->gender==9){ $output = "N/A";}
				return $output;
			})
			->addColumn('martial_status',function($data){
				if($data->martial_status==1){ $output = "अविवाहित";}
				if($data->martial_status==2){ $output = "विवाहित";}
				if($data->martial_status==3){ $output = "सम्बन्धविच्छेद भएको";}
				if($data->martial_status==4){ $output = "विधवा";}
				if($data->martial_status==9){ $output = "N/A";}
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
									<li><a href="'.route('admin.member.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									<li>
										<form action="'.route('admin.member.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
											<input type="hidden" name="_method" value="DELETE">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<button type="submit" class="dropdown-item remove-item-btn" value="Submit"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</button>
										</form>
									</li>
								</ul>
							</div>';
			return $buttons;
			})
			->rawColumns(['full_name','action'])
			->make(true);
			
	}
	
	/*for datatables members*/
	public function getmembers(Request $request) 
	{	
		$query = Member::with(['user','contacts','addresses','tols','job','groups','mabedans'])->select('members.*')->orderBy('members.id','DESC');
		if (!empty($request->get('martial_status'))) {
			$query = $query->where('martial_status',$request->get('martial_status'));
		}
		
		if (!empty($request->get('gender'))) {
			$query = $query->where('gender','=',$request->get('gender'));
		}
		
		if (!empty($request->get('blood_group'))) {
			$query = $query->where('blood_group','=',$request->get('blood_group'));
		}
		
		if (!empty($request->get('full_name'))) {
			$query = $query->where('full_name','LIKE', "%{$request->get('full_name')}%");
		}
		
		//dd($query);
		/*foreach($query as $data):
			echo $data->getFirstMediaUrl();
		endforeach;*/
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('sms', function ($data) {
				
				//$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" mobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success">Send SMS</button>';
				$output = "";
				if(is_null($data->contacts)){
					$output = '<button class="badge badge-soft-success">Mobile N/A</button>';
				}else{
					$output = '<button data-bs-target="#sendsms" onclick="sendsms($(this));" memname="'.$data->full_name.'" memmobile="'.$data->contacts->mobile_no.'" data-bs-toggle="modal" class="badge badge-soft-success"><i class=" ri-mail-send-line"></i> SMS</button>';
				}
				return $output;
                })
			->addColumn('full_name',function($data){
				$output = '<div class="d-flex align-items-center">
								<div class="flex-shrink-0"><img src="'.($data->getFirstMediaUrl() ? $data->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg')).'" alt="'.$data->full_name.'" title="'.$data->full_name.'" class="avatar-xs rounded-circle"></div>
								<div class="flex-grow-1 ms-2 name">'.$data->full_name.'</div>
							</div>'; 
				return $output;
			})
			->addColumn('age',function($data){
				$dob = Carbon::parse($data->dob_ad);
				$output = $data->dob_ad=='N/A' ? 'N/A' : $dob->diffInYears(now());
				return $output;
			}) 	
			->addColumn('contacts',function($data){
				if($data->contacts):
					return $data->contacts->mobile_no ? $data->contacts->mobile_no : '-';
				else:
					return '-';
				endif;
			})
			->addColumn('addresses',function($data){
				return $data->addresses->address_np; 
			})
			->addColumn('job',function($data){
				$output = $data->job->occupation_np ?? '-';
				return $output;			
			})
			->addColumn('tols',function($data){
				return $data->tols->tol_np;
			})
			->addColumn('gender',function($data){
				//$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				if($data->gender==1){ $output = "M";}
				if($data->gender==2){ $output = "F";}
				if($data->gender==3){ $output = "O";}
				if($data->gender==9){ $output = "N/A";}
				return $output;
			})
			->addColumn('martial_status',function($data){
				if($data->martial_status==1){ $output = "अविवाहित";}
				if($data->martial_status==2){ $output = "विवाहित";}
				if($data->martial_status==3){ $output = "सम्बन्धविच्छेद भएको";}
				if($data->martial_status==4){ $output = "विधवा";}
				if($data->martial_status==9){ $output = "N/A";}
				return $output;
				})	
			->addColumn('groups', function ($data) {
				 if(count($data->groups)>0){
                    return $data->groups->map(function($group) {
						/*return $group->pivot->map(function($pivot){
							return '<span class="badge badge-soft-info">'.$group->title_np.': '.$pivot->designation.'</span>';
						});*/
                        return '<button class="badge badge-soft-info groupupdate" onclick="groupupdate($(this));" data-bs-toggle="modal" data-bs-target="#showupdateModel" memid="'.$group->pivot->member_id.'" groupid="'.$group->id.'" choice="'.$group->pivot->designation.'">'.$group->title_np.': '.$group->pivot->designation.'</button>';//str_limit($post->title, 30, '...');
                    })->implode('<br>');
				 }else{
					 return '<button data-bs-target="#showAddModel" onclick="addgroup($(this));" memid="'.$data->id.'" data-bs-toggle="modal" class="badge badge-soft-info groupadd">N/A</button>';
				 }
                })
			->addColumn('application', function ($data) {

				return '<button data-bs-target="#showabeden" onclick="abeden($(this));" memcitizen="'.$data->citizenship.'" data-bs-toggle="modal" class="badge badge-soft-success">आवेदन फारम</button>';
				 
                })
			->addColumn('mabedans', function ($data) {
				$output = '<button data-bs-target="#showabeden" onclick="abeden($(this));" memcitizen="'.$data->citizenship.'" data-bs-toggle="modal" class="badge badge-soft-success">आवेदन फारम</button>';
				foreach($data->mabedans as $mabedan):
					$output.='<br><a href="'.route('admin.membersabeden.show', $mabedan->id).'" class="badge badge-outline-info">'.$mabedan->abedans->title.'<br>'.$mabedan->created_at->diffForHumans().'</a>';
				endforeach;
				
				return $output;
                })
			/*->addColumn('mabedans', function ($data) {
				return '<button data-bs-target="#showabeden" onclick="abeden($(this));" memcitizen="'.$data->citizenship.'" data-bs-toggle="modal" class="badge badge-soft-success">आवेदन फारम</button><br>';
				return $data->mabedans->created_at;//if($data->mabedans):
						foreach($data->mabedans as $mabedan):
							return '<button  class="badge badge-soft-success">'.$mabedan->created_at.'</button>';
						endforeach;
                })*/
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
									<li><a href="'.route('admin.member.edit', $data->id).'" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
									<li>
										<form action="'.route('admin.member.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
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
	
	/*check if member exists from index view*/
	public function check(Request $request)
	{
		//dd($request->citizen);	
		$check = Member::where('citizenship',$request->citizen)->orWhere('birth_registration',$request->citizen)->first();//DB::select(DB::raw("SELECT id FROM `members` WHERE citizenship='".$request->citizen."' or birth_registration='".$request->citizen."'"));
		if($check){
			return Redirect::route('admin.member.edit', $check->id);
		}else{
			return Redirect::route('admin.member.create');
		}
		dd($check->id);
	}
	
	/*checking if member exists from medical survey using citizenship*/
	public function checkMember(Request $request)
	{
		$check = Member::where('citizenship',$request->citizenship)->first();
		if($check){
			$data = array('success'=>'exists','memid'=>$check->id,'name'=>$check->full_name);
			echo json_encode($data);
		}else{
			$data = array('error'=>'doesnot exist');
			echo json_encode($data);
		}
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
		
		$address = Address::get();
		$tol = Tol::get();
		$mdocuments = Member::memdocuments(setting()->get('member_documents'));
		
		$this->setPageTitle("सदस्यहरू", "सदस्यहरूको डाटा थप्नुहोस्");
        return view('admin.members.create1',compact('address','tol','mdocuments'));
    }
    
    public function underage()
    {
		if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$address = Address::get();
		$tol = Tol::get();
		$mdocuments = Member::memdocuments(setting()->get('member_documents'));
		
		$this->setPageTitle("नाबालिग बच्चा", "नाबालक बच्चाको डाटा थप्नुहोस्");
        return view('admin.members.underage',compact('address','tol','mdocuments'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {		
		//dd($kidney);
		 if (! Gate::allows('users_manage')) {
            return abort(401);
        }
		
			
		$validator = Validator::make(
			$request->all(),
			[
				'full_name' => 'required',
				'dob_bs' => 'required',
				'citizenship'=> "unique:App\Member,citizenship",
				'gender'=>'required|not_in:9',
				'martial_status'=>'required|not_in:9',
				'house_no'=>'required',
				'road'=>'required',
				'tol'=>'required',
				'file.*'=>'mimes:jpg,jpeg,png|max:1000',
				'blood_grp' => 'required|not_in:0',
				'occupation'=>'required|not_in:0',
				//'grandfather_name'=>'required',
				//'father_name'=>'required',
				//'father_citizen'=>'required',
				//'mother_name'=>'required',
				//'mother_citizen'=>'required',
			],
			[
				'full_name.required'=>'पूरा नामको जानकारी आवश्यक छ ।',
				'dob_bs.required'=>'जन्म मितिको जानकारी आवश्यक छ ।',
				'citizenship.unique'=>'हाम्रो प्रणालीमा नागरिकता नम्बर  '.$request->citizenship.' पहिले नै अवस्थित छ ।',
				'gender.required'=>'लिंगको जानकारी आवश्यक छ ।',
				'martial_status.required'=>'वैवाहिक स्थितिको जानकारी आवश्यक छ ।',
				'house_no.required'=>'घर नम्बरको जानकारी आवश्यक छ ।',
				'road.required'=>'सडकको जानकारी आवश्यक छ ।',
				'tol.required'=>'टोलको जानकारी आवश्यक छ ।',
				'blood_grp.required'=>'रक्त समूहको जानकारी आवश्यक छ ।',
				'occupation.required'=>'पेशाको जानकारी आवश्यक छ ।',
				//'grandfather_name.required'=>'हजुरबुबाको नाम आवश्यक छ ।',
				//'father_name.required'=>'बुबाको नाम आवश्यक छ ।',
				//'father_citizen.required'=>'बुबाको नागरिकता नम्बर आवश्यक छ ।',
				//'mother_name.required'=>'आमाको नाम आवश्यक छ ।',
				//'mother_citizen.required'=>'आमाको नागरिकता नम्बर आवश्यक छ ।',
				'file.*.mimes'=>'केवल jpg, jpeg र png फोटो फाइलहरूलाई अनुमति छ',
				'file.*.max'=>'माफ गर्नुहोस्! फोटोको लागि max size 1 MB हो',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		
        $member = new Member();
		$nepalidate = explode("-",$request->dob_bs);
		$year = $nepalidate[0];
		$month = $nepalidate[1];
		$day = $nepalidate[2]; 
		//dd($year);
		if($year>=2000):
			$converttoad = \Bsdate::nep_to_eng($year,$month,$day);
			//dd($converttoad);
			$datead = $converttoad['year'].'-'.$converttoad['month'].'-'.$converttoad['date'];
		else:
			$datead ="N/A";
		endif;
		//dd($request->dob_bs);;
		//dd($request->dob_bs);
		//dd($request->all());
		if($request->hasfile('image')):
			$member->addMedia($request->image)->toMediaCollection();
		else:
			$member->image = NULL;
		endif;
		
		/*if($request->hasfile('disability_certificate')):
			$member->addMedia($request->disability_certificate)->toMediaCollection();
		else:
			$member->disability_certificate = NULL;
		endif;*/
			
		$user = \Auth::user()->id;
		$member->full_name = $request->full_name;
		$member->fullname_np = $request->fullname_np;
		$member->dob_bs = $request->dob_bs;
		$member->dob_ad = $datead;
		$member->gender = $request->gender;
		if($request->martial_status!=9):
			$member->martial_status = $request->martial_status;
		endif;
		$member->citizenship = $request->citizenship;
		$member->birth_registration = $request->birth_registration;
		$member->national_id = $request->national_id;
		$member->house_no = $request->house_no;
		$member->road = $request->road;
		$member->tol = $request->tol;
		$member->blood_group = $request->blood_grp;
		$member->occupation_id = $request->occupation;
		$member->created_by = $user;		
		
			
		if($member->save()):
			$memberid = $member->id;
			$contact = new Contactdetail();
			$education = new Membereducation();
			$family = new Memberfamily();
			$medical = new Membermedical();
			
			/*saving member related contact*/
			$contact->member_id = $memberid;			
			$contact->temporary_address = $request->temporary_address;
			$contact->contact_no = $request->contact_no;
			$contact->mobile_no = $request->mobile_no;
			$contact->email = $request->email;
			$contact->created_by = $user;	
			$contact->save();
			
			/*saving member related family*/
			$family->member_id = $memberid;			
			$family->grandfather_name = $request->grandfather_name;
			$family->grandfather_np = $request->grandfather_np;
			$family->grandfather_citizen = $request->grandfather_citizen;
			$family->grandmother_name = $request->grandmother_name;
			$family->grandmother_np = $request->grandmother_np;
			$family->grandmother_citizen = $request->grandmother_citizen;
			$family->father_name = $request->father_name;
			$family->father_np = $request->father_np;
			$family->father_citizen = $request->father_citizen;
			$family->mother_name = $request->mother_name;
			$family->mother_np = $request->mother_np;
			$family->mother_citizen = $request->mother_citizen;
			$family->spouse_name = $request->spouse_name;
			$family->spouse_np = $request->spouse_np;
			$family->spouse_citizen = $request->spouse_citizen;
			$family->created_by = $user;			
			$family->save();
			
			/*saving member related education*/
			$education->member_id = $memberid;
			$education->last_qualification = $request->last_qualification;
			$education->passed_year = $request->passed_year;
			$education->created_by = $user;			
			$education->save();
			
			/*saving member related medical*/
			
			foreach($request->medical_problem as $i=>$prob){
				if($prob!='NULL'){
					$detail = [
					"member_id"=>$memberid,
					"medical_problem"=>$prob,
					"created_by"=>$user,
					];
				
					$medical::insert($detail);
				}
			}
			
			$documents = new Memberdocument();
			
			if($request->hasfile('file')): 
				foreach ($request->file("file") as $i => $file): 
					$extension = strtolower(trim($file->getClientOriginalExtension()));
					$docno = str_replace('/', '-', $request->doc_number[$i]);
					$filename = $memberid.'-'.$docno.'-'.$request->doc_type[$i].'.'.$extension;
					//$fullpath = "members/".$request->doc_type[$i].'/'.$filename;
					//$path = $file->storeAs("members/".$request->doc_type[$i],$filename);
					
					$fullpath = $request->doc_type[$i].'/'.$filename;
					$path = $file->storeAs($request->doc_type[$i],$filename);
					//dd($path);
					/*$name = strtolower(trim($file->getClientOriginalExtension()));//$request->doc_number[$i].'-';
					$filename = $request->doc_number[$i].'-'.$request->doc_type[$i].'.'.$name;
					//dd($filename);
					$insert[$i]["name"] = $filename;
					$insert[$i]["store_path"] = $path;*/
					$detail = [
					  "member_id"=> $memberid,
					  "doc_type" => $request->doc_type[$i],
					  "doc_number" => $request->doc_number[$i],
					  "file" => $fullpath,
					  "created_by" => $user,
					];
				$documents::insert($detail);
				endforeach;
			endif;
			
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be added.");
		endif;
		
		
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {       
		$member = Member::findOrFail($slug);
		//dd($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $member = Member::where("id", $slug)->firstOrFail();	
		$mdocuments = Member::memdocuments(setting()->get('member_documents'));
		//$profile = Member::profilepercentage($member);
		
		//dd($profile);
        //dd($member); 
        $this->setPageTitle("सदस्यहरू", "सदस्य सम्पादन गर्नुहोस्");
        return view('admin.members.edit',compact('member','mdocuments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = Member::find($id);
		//dd($request->all());
		//adding image to media
		if($request->file('image')){
			if (isset($request->mediaid) && !empty($request->mediaid)):
				$media = Media::where('model_id',$request->mediaid)->first();
				if($media)://dd($media->model_type);
					$model_type = $media->model_type;
					
					$model = $model_type::find($media->model_id);
					//dd($model);
					$model->deleteMedia($media->id);
				endif;
			endif;
			
			$member->addMedia($request->image)->toMediaCollection();
		}
		
		$nepalidate = explode("-",$request->dob_bs);
		$year = $nepalidate[0];
		$month = $nepalidate[1];
		$day = $nepalidate[2]; 
		
		if($year>=2000):
			$converttoad = \Bsdate::nep_to_eng($year,$month,$day);
			//dd($converttoad);
			$datead = $converttoad['year'].'-'.$converttoad['month'].'-'.$converttoad['date'];
		else:
			$datead ="N/A";
		endif;
		
		$user = \Auth::user()->id;
		$member->full_name = $request->full_name;
		$member->fullname_np = $request->fullname_np;
		$member->dob_bs = $request->dob_bs;
		//$member->dob_ad = $datead;
		$member->dob_ad = $request->dob_ad;
		$member->gender = $request->gender;
		$member->martial_status = $request->martial_status;
		$member->citizenship = $request->citizenship;
		$member->birth_registration = $request->birth_registration;
		$member->national_id = $request->national_id;
		$member->house_no = $request->house_no;
		$member->road = $request->road;
		$member->tol = $request->tol;
		$member->blood_group = $request->blood_grp;
		$member->occupation_id = $request->occupation;
		
		if($member->save()):
			return back()->with("message", "Member ".$request->full_name." updated successfully");
		else:
			return back()->with("message", "Member ".$request->full_name." could not be updated!!");
		endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
	
	/*get family's detail according member's father citizenship number*/
	public function checkFamily(){
		if(isset($_GET)){
			$citizen = $_GET['fcitizen'];
			//dd("SELECT m.full_name,mf.father_name,mf.father_citizen,mf.spouse_name,mf.spouse_citizen FROM `members` m LEFT JOIN member_family mf on mf.member_id=m.id WHERE m.citizenship='".$citizen."'");
			$family = DB::select(DB::raw("SELECT m.full_name,mf.father_name,mf.father_citizen,mf.mother_name,mf.mother_citizen,mf.spouse_name,mf.spouse_citizen FROM `members` m LEFT JOIN member_family mf on mf.member_id=m.id WHERE m.citizenship='".$citizen."'"));
			
			if(!empty($family)){
				return response()->json(['success'=>'success','family'=>$family]);
			}else{
				return response()->json(['error'=>'error']);
			}
		}
	}
	
	/*update member group*/
	public function updateGroup(Request $request){
		//dd($request->memberid);
		//dd($request->groupid);
		//dd($request->designation);
		
		$update = GroupsMember::where([['member_id',$request->memberid],['member_groupid',$request->groupid]])->update([
					'designation'=>$request->designation]);
					
		if($update):
			return back()->with("message", "Updated successfully");
		else:
			return back()->with("error", "Could not be updated!!");
		endif;
		
	}
	
	/*update member group*/
	public function addGroup(Request $request){
		
		$data = new GroupsMember();
		
		$data->member_id = $request->memberid;
		$data->member_groupid = $request->groupid;
		$data->designation = $request->designation;
		
		if($data->save()):
			return back()->with("message", "Added successfully");
		else:
			return back()->with("error", "Could not be added!!");
		endif;
		
	}
}
