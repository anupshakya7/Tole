<?php

namespace App\Http\Controllers\Admin;

use App\Occupation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;

class OccupationController extends BaseController
{
	public function index()
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }

        $occupation = Occupation::latest()->get();
        //dd($houses);
        $this->setPageTitle('पेशाहरू', 'List of all occupations');    
        return view('admin.occupation.index',compact('occupation'));
    }
	
	public function create()
	{
		$this->setPageTitle("पेशाहरू", "पेशाको डाटा थप्नुहोस्");
        return view("admin.occupation.create");
	}
	
	public function store(Request $request)
	{
		if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $occupation = new Occupation();

        $occupation->occupation = $request->occupation;
        $occupation->occupation_np = $request->occupation_np;

        if($occupation->save()){
            return redirect(route('admin.occupation.index'))->with('message','Successfully inserted data for '.$request->address);
        }else{
            return redirect(route('admin.occupation.index'))->with('message','Unable to insert data of '.$request->address);
        }
	}
	
	public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $occupation = Occupation::where("id", $slug)->firstOrFail();
        //dd($compost);
        $this->setPageTitle('पेशा', 'Edit Occupation');
        return view('admin.occupation.edit',compact('occupation'));
    }
	
	 public function update(Request $request,$id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //dd($request->all());
        $occupation = Occupation::find($id);
        //dd($owner);
        $occupation->occupation = $request->occupation;
        $occupation->occupation_np = $request->occupation_np;

        if($occupation->save()){
		  return redirect(route("admin.occupation.index"))->with("message",$request->occupation . " updated successfully");
        }else{
		  return redirect(route("admin.occupation.index"))->with("message","Unable to update " . $request->occupation);
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

		$occupation = Occupation::find($id);
        //dd($compost);
		if($occupation->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}