<?php

namespace App\Http\Controllers\Admin;

use App\Events;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class EventsController extends BaseController
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
		
		$this->setPageTitle("Events", "List Of Events");    
		return view('admin.events.index');
    }
	
	/*for datatables */
	public function getevents()
	{
		$query = Events::with('user')->latest()->get();
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('title',function($data){
				return $data->title;
			})
			->addColumn('event_date',function($data){
				return $data->event_date;
			})
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('action',function($data){
			
			$button ='<a class="link-info fs-15" href="'.route('admin.events.edit', $data->id).'">
														<i class="ri-edit-2-line"></i>
													</a>';
			if(auth()->user()->hasRole('administrator')):
			$button .= '<form action="'.route('admin.events.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
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
		
		$this->setPageTitle("कार्यक्रमहरू", "कार्यक्रमहरूको सूची");
        return view("admin.events.create");
    }
	
	
	public function save(Events $event, Request $request){
		 $event->title = $request->title;
		 $event->venue = $request->venue;
		 $event->event_date = $request->event_date;
		 $event->user_id = \Auth::user()->id;
		 $event->save();
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
				'title' => 'required',
				'venue' => 'required',
				'event_date' => 'required',
			],
			[
				'title.required'=>' नाम आवश्यक छ।',
				'venue.required'=>'स्थल आवश्यक छ।',
				'event_date.required'=>'कार्यक्रम मिति आवश्यक छ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		
		//dd($request->all());
        $event = new Events();
		 
		if($this->save($event,$request)){
           return redirect(route("admin.events.index"))->with('message','Successfully added data for '.$request->title);
        }else{
			return redirect(route("admin.events.index"))->with('message','Successfully added data for '.$request->title);
		}	
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

        $event = Events::where("id", $slug)->firstOrFail();
        //dd($compost);
        $this->setPageTitle('कार्यक्रम', 'सम्पादन कार्यक्रम');
        return view('admin.events.edit',compact('event'));
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
        $event = Events::find($id);
		//dd($request);
		if($this->save($program,$request)){
            return redirect(route("admin.events.index"))->with('message','Successfully updated data for '.$request->title_en);
        }else{
			return redirect(route("admin.events.index"))->with('message','Successfully updated data for '.$request->title_en);
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

		$event = Events::find($id);
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
