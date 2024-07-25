<?php

namespace App\Http\Controllers\Admin;

use App\TblMessage;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class MessageController extends BaseController
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
		$messages = TblMessage::latest()->get();
		$this->setPageTitle("सन्देश", "सन्देशहरूको सूची");    
		return view('admin.messages.index',compact('messages'));
    }
	
	public function store(Request $request)
	{
		//dd($request->all());
		if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$message = new TblMessage();
		
		$message->title = $request->title;
		$message->body = $request->body;
		$message->user_id = \Auth::user()->id;	
		//$education->save();
		
		if($message->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be added.");
		endif;
	}
	
	public function update(Request $request)
	{
		
		
		$id = $request->msgid;
		$message = TblMessage::find($id);
		
		$message->title = $request->title;
		$message->body = $request->body;
		
		if($message->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be added.");
		endif;
	}
}
