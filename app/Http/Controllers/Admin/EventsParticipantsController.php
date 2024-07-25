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

class EventsParticipantsController extends BaseController
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
		
		$this->setPageTitle("कार्यक्रम सहभागीहरु", "कार्यक्रम सहभागीहरुको सूची");    
		return view('admin.eventparticipant.index');
    }
	
	/*for datatables */
	public function geteventparticipants()
	{
		$query = EventsParticipants::with('user','events','participants')->latest()->get();
		//dd($query);
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('events',function($data){
				return $data->events->title;
			})
			->addColumn('participants',function($data){
				return $data->participants->full_name;
			})
			->addColumn('registered_at',function($data){
				return $data->registered_at;
			})
			->addColumn('donated_at',function($data){
				$output = $data->donated_at!=null ? $data->donated_at : "-";
				return $output;
			})
			->addColumn('cert_received_at',function($data){
				$output = $data->cert_received_at!=null ? $data->cert_received_at : "-";
				return $output;
			})
			->addColumn('blood_grp_card_received_at',function($data){
				$output = $data->blood_grp_card_received_at!=null ? $data->blood_grp_card_received_at : "-";
				return $output;
			})
			->addColumn('previous_donation_at',function($data){
				$output = $data->previous_donation_at!=null ? $data->previous_donation_at : "-";
				return $output;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('action',function($data){
			
			$button ='<a class="link-info fs-15" href="'.route('admin.eventparticipants.edit', $data->id).'">
														<i class="ri-edit-2-line"></i>
													</a>';
			if(auth()->user()->hasRole('administrator')):
			$button .= '<form action="'.route('admin.eventparticipants.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
														<input type="hidden" name="_method" value="DELETE">
														<input type="hidden" name="_token" value="'.csrf_token().'">
														<button type="submit" class="link-danger fs-15" value="Submit"><i class="ri-delete-bin-5-line"></i></button>
													</form>';
			endif;
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
			$eventparticipant->dontated_at = $request->dontated_at;
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

        $eparticipant = EventsParticipants::where("id", $slug)->firstOrFail();
		//dd($eparticipant);
		$events = Events::latest()->get();
        //dd($compost);
        $this->setPageTitle('कार्यक्रम सहभागी', 'कार्यक्रम सहभागी सम्पादन');
        return view('admin.eventparticipant.edit',compact('eparticipant','events'));
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
		
        $eparticipants = EventsParticipants::find($id);
		if($eparticipants->update($request->all())){
            return redirect(route("admin.eventparticipants.index"))->with('message','Successfully updated data for '.$request->title_en);
        }else{
			return redirect(route("admin.eventparticipants.index"))->with('message','Successfully updated data for '.$request->title_en);
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

		$eparticipants = EventsParticipants::find($id);
        //dd($compost);
		if($eparticipants->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}
