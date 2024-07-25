<?php

namespace App\Http\Controllers\Admin;

use App\Contactdetail;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class ContactDetailsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $contact = new Contactdetail();
		
		$contact->member_id = $request->member_id;
		$contact->contact_no = $request->contact_no;
		$contact->mobile_no = $request->mobile_no;
		$contact->email = $request->email;
		$contact->temporary_address = $request->temporary_address;
		$contact->created_by = \Auth::user()->id;
		
		if($contact->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be added.");
		endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contactdetail  $contactdetail
     * @return \Illuminate\Http\Response
     */
    public function show(Contactdetail $contactdetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contactdetail  $contactdetail
     * @return \Illuminate\Http\Response
     */
    public function edit(Contactdetail $contactdetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contactdetail  $contactdetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$contact = Contactdetail::find($id);
		
		$contact->contact_no = $request->contact_no;
		$contact->mobile_no = $request->mobile_no;
		$contact->email = $request->email;
		$contact->temporary_address = $request->temporary_address;
		
		if($contact->save()):
			return back()->with("message", "Contact Detail updated successfully");
		else:
			return back()->with("message", "Contact Detail could not be updated!!");
		endif;
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contactdetail  $contactdetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contactdetail $contactdetail)
    {
        //
    }
}
