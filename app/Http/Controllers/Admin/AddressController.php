<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;

class AddressController extends BaseController
{
	public function index()
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }

        $address = Address::latest()->get();
        //dd($houses);
        $this->setPageTitle('ठेगाना', 'List of all Address');    
        return view('admin.address.index',compact('address'));
    }
	
	public function create()
	{
		$this->setPageTitle("ठेगाना", "ठेगानाको डाटा थप्नुहोस्");
        return view("admin.address.create");
	}
	
	public function store(Request $request)
	{
		if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $address = new Address();

        $address->address = $request->address;
        $address->address_np = $request->address_np;

        if($address->save()){
            return redirect(route('admin.address.index'))->with('message','Successfully inserted data for '.$request->address);
        }else{
            return redirect(route('admin.address.index'))->with('message','Unable to insert data of '.$request->address);
        }
	}
	
	public function edit($slug)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $address = Address::where("id", $slug)->firstOrFail();
        //dd($compost);
        $this->setPageTitle('ठेगाना', 'Edit Address');
        return view('admin.address.edit',compact('address'));
    }
	
	 public function update(Request $request,$id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        //dd($request->all());
        $address = Address::find($id);
        //dd($owner);
        $address->address = $request->address;
        $address->address_np = $request->address_np;

        if($address->save()){
		  return redirect(route("admin.address.index"))->with("message",$request->address . " updated successfully");
        }else{
		  return redirect(route("admin.address.index"))->with("message","Unable to update " . $request->address . " survey");
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

		$address = Address::find($id);
        //dd($compost);
		if($address->delete()):
		  return back()->with("message", "Data deleted successfully!!");
		else:
		  return back()->with(
			"message",
			"Sorry but the data could not be deleted!!"
		  );
		endif;
    }
}