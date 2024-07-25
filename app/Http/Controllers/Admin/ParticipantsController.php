<?php

namespace App\Http\Controllers\Admin;

use App\Participants;
use App\Events;
use App\EventsParticipants;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class ParticipantsController extends BaseController
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
		
		$this->setPageTitle("सहभागीहरू", "सहभागीहरूको सूची");    
		return view('admin.participants.index');
    }
	
	/*for datatables */
	public function getparticipants()
	{
		$query = Participants::with('user')->latest()->get();
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('full_name',function($data){
				return $data->full_name;
			})
			->addColumn('mobile',function($data){
				return $data->mobile;
			})
			->addColumn('gender',function($data){
				$output = ($data->gender!=NULL) ? ($data->gender==0 ? "M" : ($data->gender==1 ? "F" : "O")) : '-';
				return $output;
			})
			->addColumn('blood_grp',function($data){
				return $data->blood_grp;
			})
			->addColumn('blood_grp_card',function($data){
				$output = $data->blood_grp_card==0 ? "छ" : "छैन";
				return $output;
			})
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('action',function($data){
			
			$button ='<a class="link-info fs-15" href="'.route('admin.participants.edit', $data->id).'">
														<i class="ri-edit-2-line"></i>
													</a>';
			if(auth()->user()->hasRole('administrator')):
			$button .= '<form action="'.route('admin.participants.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
														<input type="hidden" name="_method" value="DELETE">
														<input type="hidden" name="_token" value="'.csrf_token().'">
														<button type="submit" class="link-danger fs-15" value="Submit"><i class="ri-delete-bin-5-line"></i></button>
													</form>';
			endif;
			return $button;
			})
			->rawColumns(['action','event_date'])
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
		$events = Events::latest()->get();
		$this->setPageTitle("सहभागी", "सहभागी बनाउनुहोस्");
        return view("admin.participants.create",compact('events'));
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
				'full_name' => 'required',
				'mobile' => 'required|unique:participants,mobile',
				'blood_grp' => 'required',
				'gender' => 'required',
			],
			[
				'full_name.required'=>' पुरा नाम आवश्यक छ।',
				'mobile.required'=>'मोबाइल आवश्यक छ।',
				'mobile.unique'=>'मोबाइल '.$request->mobile.' पहिलेनै दर्ता भैसकेको छ।',
				'blood_grp.required'=>'रक्त समूह आवश्यक छ।',
				'gender.required'=>'लिङ्ग आवश्यक छ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		
		//dd($request->all());
        $participant = new Participants();
		
		$participant->full_name = $request->full_name;
		$participant->mobile = $request->mobile;
		$participant->blood_grp = $request->blood_grp;
		$participant->gender = $request->gender;
		$participant->blood_grp_card = $request->blood_grp_card;
		$participant->user_id = \Auth::user()->id;
		
		if($participant->save()):
			//dd($participant->id);
			$eventparticipant = new EventsParticipants();
			$eventparticipant->event_id = $request->event_id;
			$eventparticipant->participant_id = $participant->id;
			$eventparticipant->registered_at = $request->registered_at;
			$eventparticipant->donated_at = $request->donated_at;
			$eventparticipant->cert_received_at = $request->cert_received_at;
			$eventparticipant->blood_grp_card_received_at = $request->blood_grp_card_received_at;
			$eventparticipant->previous_donation_at = $request->previous_donation_at;
			$eventparticipant->user_id = \Auth::user()->id;
			
			if($eventparticipant->save()):
				return redirect(route("admin.participants.index"))->with('message','Successfully added data for '.$request->full_name);
			else:
				return redirect(route("admin.participants.index"))->with('message','Successfully added data for '.$request->full_name);
			endif;
			
		endif;

		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Events $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Events  $event
     * @return \Illuminate\Http\Response
     */	
	public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $participant = Participants::where("id", $slug)->firstOrFail();
		$events = Events::latest()->get();
        //dd($compost);
        $this->setPageTitle('सहभागी', 'सहभागी सम्पादन');
        return view('admin.participants.edit',compact('participant','events'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
		//dd($request->all());
        $participants = Participants::find($id);
		
		/*$participants->full_name = $request->full_name;
		$participants->mobile = $request->mobile;
		$participants->blood_grp = $request->blood_grp;
		$participants->gender = $request->gender;
		$participants->blood_grp_card = $request->blood_grp_card;*/
		//dd($request);
		if($participants->update($request->all())){
            return redirect(route("admin.participants.index"))->with('message','Successfully updated data for '.$request->title_en);
        }else{
			return redirect(route("admin.participants.index"))->with('message','Successfully updated data for '.$request->title_en);
		}	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

		$participants = Participants::find($id);
        //dd($compost);
		if($participants->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}
