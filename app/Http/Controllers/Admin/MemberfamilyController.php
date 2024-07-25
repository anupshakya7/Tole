<?php

namespace App\Http\Controllers\Admin;

use App\Memberfamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\BaseController;


class MemberfamilyController extends BaseController
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
		//dd($request->all());
		$validator = Validator::make(
			$request->all(),
			[
				
				'grandfather_name'=>'required',
				'father_name'=>'required',
				'father_citizen'=>'required',
				'mother_name'=>'required',
				'mother_citizen'=>'required',
			],
			[
				'grandfather_name.required'=>'हजुरबुबाको नाम आवश्यक छ ।',
				'father_name.required'=>'बुबाको नाम आवश्यक छ ।',
				'father_citizen.required'=>'बुबाको नागरिकता नम्बर आवश्यक छ ।',
				'mother_name.required'=>'आमाको नाम आवश्यक छ ।',
				'mother_citizen.required'=>'आमाको नागरिकता नम्बर आवश्यक छ ।',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
        $family = new Memberfamily();
		
		$family->member_id = $request->member_id;
		$family->grandfather_name = $request->grandfather_name;
		$family->grandfather_citizen = $request->grandfather_citizen;
		$family->grandmother_name = $request->grandmother_name;
		$family->grandmother_citizen = $request->grandmother_citizen;
		$family->father_name = $request->father_name;
		$family->father_citizen = $request->father_citizen;
		$family->mother_name = $request->mother_name;
		$family->mother_citizen = $request->mother_citizen;
		$family->spouse_name = $request->spouse_name;
		$family->spouse_citizen = $request->spouse_citizen;
		
		if($family->save()):
			return back()->with("message", "Member Family updated successfully");
		else:
			return back()->with("message", "Member Family could not be updated!!");
		endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Memberfamily  $memberfamily
     * @return \Illuminate\Http\Response
     */
    public function show(Memberfamily $memberfamily)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Memberfamily  $memberfamily
     * @return \Illuminate\Http\Response
     */
    public function edit(Memberfamily $memberfamily)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Memberfamily  $memberfamily
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		//dd($request->all());
        $family = Memberfamily::find($id);
		
		
		$family->grandfather_name = $request->grandfather_name;
		$family->grandfather_np = $request->grandfather_np;
		$family->grandfather_citizen = $request->grandfather_citizen;
		$family->grandmother_name = $request->grandmother_name;
		$family->grandmother_np = $request->grandmother_np;
		$family->grandmother_citizen = $request->grandmother_citizen;
		$family->father_name = $request->father_name;
		$family->father_np = $request->father_np;
		$family->father_citizen = $request->father_citizen;
		$family->mother_name = $request->mother_name;
		$family->mother_np = $request->mother_np;
		$family->mother_citizen = $request->mother_citizen;
		$family->spouse_name = $request->spouse_name;
		$family->spouse_np = $request->spouse_np;
		$family->spouse_citizen = $request->spouse_citizen;
		
		if($family->save()):
			return back()->with("message", "Member Family updated successfully");
		else:
			return back()->with("message", "Member Family could not be updated!!");
		endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Memberfamily  $memberfamily
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memberfamily $memberfamily)
    {
        //
    }
}
