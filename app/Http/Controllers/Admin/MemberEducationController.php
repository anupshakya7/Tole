<?php

namespace App\Http\Controllers\Admin;

use App\Membereducation;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class MemberEducationController extends BaseController
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
        $education = new Membereducation();
		
		$education->member_id = $request->member_id;
		$education->last_qualification = $request->last_qualification;
		$education->passed_year = $request->passed_year;
		$education->created_by = \Auth::user()->id;	
		//$education->save();
		
		if($education->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be added.");
		endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Membereducation  $membereducation
     * @return \Illuminate\Http\Response
     */
    public function show(Membereducation $membereducation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Membereducation  $membereducation
     * @return \Illuminate\Http\Response
     */
    public function edit(Membereducation $membereducation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Membereducation  $membereducation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $education = Membereducation::find($id);
		
		$education->last_qualification = $request->last_qualification;
		$education->passed_year = $request->passed_year;
		
		if($education->save()):
			return back()->with("message", "Education Detail updated successfully");
		else:
			return back()->with("message", "Education Detail could not be updated!!");
		endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Membereducation  $membereducation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membereducation $membereducation)
    {
        //
    }
}
