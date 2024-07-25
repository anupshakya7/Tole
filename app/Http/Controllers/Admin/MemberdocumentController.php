<?php

namespace App\Http\Controllers\Admin;

use App\Memberdocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\BaseController;

class MemberdocumentController extends BaseController
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
        
		
        $validator = Validator::make(
            $request->all(),
            [
                'file.*'=>'mimes:jpg,jpeg,png|max:1000'
            ],
            [
                'file.*.mimes'=>'केवल jpg, jpeg र png फोटो फाइलहरूलाई अनुमति छ',
                'file.*.max'=>'माफ गर्नुहोस्! फोटोको लागि max size 1 MB हो',
            ]
        );
        
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        
        $documents = new Memberdocument();
        
			if($request->hasfile('file')): 
				foreach ($request->file("file") as $i => $file): 
					$extension = strtolower(trim($file->getClientOriginalExtension()));
					$docno = str_replace('/', '-', $request->doc_number[$i]);
					$filename = $docno.'-'.$request->doc_type[$i].'.'.$extension;
					//$fullpath = "members/".$request->doc_type[$i].'/'.$filename;
					//$path = $file->storeAs("members/".$request->doc_type[$i],$filename);
					
					$fullpath = $request->doc_type[$i].'/'.$filename;
					$path = $file->storeAs($request->doc_type[$i],$filename);
					//dd($path);
					/*$name = strtolower(trim($file->getClientOriginalExtension()));//$request->doc_number[$i].'-';
					$filename = $request->doc_number[$i].'-'.$request->doc_type[$i].'.'.$name;
					//dd($filename);
					$insert[$i]["name"] = $filename;
					$insert[$i]["store_path"] = $path;*/
					$detail = [
					  "member_id"=> $request->member_id,
					  "doc_type" => $request->doc_type[$i],
					  "doc_number" => $request->doc_number[$i],
					  "file" => $fullpath,
					  "created_by" => \Auth::user()->id,
					];
				$documents::insert($detail);
				endforeach;
			endif;
			
			return back()->with("message", "Data added successfully");
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
