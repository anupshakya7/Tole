<?php

namespace App\Http\Controllers\Admin;

use App\Program;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class ProgramController extends BaseController
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
		
		$this->setPageTitle("कार्यक्रमहरू", "कार्यक्रमहरूको सूची");    
		return view('admin.programs.index');
    }
	
	/*for datatables */
	public function getprograms()
	{
		$query = Program::with('user')->latest()->get();
		
		return DataTables::of($query)
			->addIndexColumn()
			->addColumn('user',function($data){
				return $data->user->name;
			})
			->addColumn('created_at',function($data){
				return $data->created_at->diffForHumans();
			})
			->addColumn('action',function($data){
			
			$button ='<a class="link-info fs-15" href="'.route('admin.program.edit', $data->id).'">
														<i class="ri-edit-2-line"></i>
													</a>';
			if(auth()->user()->hasRole('administrator')):
			$button .= '<form action="'.route('admin.program.destroy', $data->id).'" method="POST" onsubmit="return confirm("'.trans('global.areYouSure').'");" style="display: inline-block;">
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
		
		$this->setPageTitle("कार्यक्रमहरू", "कार्यक्रमहरूको सूची");
        return view("admin.programs.create");
    }
	
	
	public function save(Program $program, Request $request){
		 $program->title_en = $request->title_en;
		 $program->title_np = $request->title_np;
		 $program->quantity = $request->quantity;
		 $program->user_id = \Auth::user()->id;
		 $program->save();
	}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$validator = Validator::make(
			$request->all(),
			[
				'title_en' => 'required',
				'quantity' => 'required',
			],
			[
				'title_en.required'=>'कार्यक्रम नाम आवश्यक छ।',
				'quantity.required'=>'मात्रा आवश्यक छ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		
		//dd($request->all());
        $program = new Program();
		 
		if($this->save($program,$request)){
           return redirect(route("admin.program.index"))->with('message','Successfully added data for '.$request->title_en);
        }else{
			return redirect(route("admin.program.index"))->with('message','Successfully added data for '.$request->title_en);
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

        $program = Program::where("id", $slug)->firstOrFail();
        //dd($compost);
        $this->setPageTitle('कार्यक्रम', 'सम्पादन कार्यक्रम');
        return view('admin.programs.edit',compact('program'));
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
        $program = Program::find($id);
		//dd($request);
		if($this->save($program,$request)){
            return redirect(route("admin.program.index"))->with('message','Successfully updated data for '.$request->title_en);
        }else{
			return redirect(route("admin.program.index"))->with('message','Successfully updated data for '.$request->title_en);
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

		$program = Program::find($id);
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
