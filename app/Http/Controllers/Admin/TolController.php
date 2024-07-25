<?php

namespace App\Http\Controllers\Admin;

use App\Tol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;

class TolController extends BaseController
{
	public function index()
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }

        $tol = Tol::latest()->get();
        //dd($houses);
        $this->setPageTitle('टोल', 'List of all Tol');    
        return view('admin.tol.index',compact('tol'));
    }
	
	public function create()
	{
		$this->setPageTitle("टोल", "टोलको डाटा थप्नुहोस्");
        return view("admin.tol.create");
	}
	
	public function store(Request $request)
	{
		if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $tol = new Tol();

        $tol->tol = $request->tol;
        $tol->tol_np = $request->tol_np;

        if($tol->save()){
            return redirect(route('admin.tol.index'))->with('message','Successfully inserted data for '.$request->tol);
        }else{
            return redirect(route('admin.tol.index'))->with('message','Unable to insert data of '.$request->tol);
        }
	}
	
	public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $tol = Tol::where("id", $slug)->firstOrFail();
        //dd($compost);
        $this->setPageTitle('टोल', 'Edit Tol');
        return view('admin.tol.edit',compact('tol'));
    }
	
	 public function update(Request $request,$id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //dd($request->all());
        $tol = Tol::find($id);
        //dd($owner);
        $tol->tol = $request->tol;
        $tol->tol_np = $request->tol_np;

        if($tol->save()){
		  return redirect(route("admin.tol.index"))->with("message",$request->tol . " updated successfully");
        }else{
		  return redirect(route("admin.tol.index"))->with("message","Unable to update " . $request->tol . " survey");
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

		$tol = Tol::find($id);
        //dd($compost);
		if($tol->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}