<?php

namespace App\Http\Controllers\Admin;

use App\Member;
use App\Membergroup;
use App\GroupsMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\BaseController;

class MembergroupController extends BaseController
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
		$mgroups = Membergroup::latest()->get();
		$this->setPageTitle("सदस्य समितिहरू", "सदस्य समितिहरूको सूची");    
		return view('admin.membergroup.index',compact('mgroups'));
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
        	if(!Gate::allows('users_manage')){
            return abort(401);
        }
		
		$mgroups = new Membergroup();
		
		$mgroups->title_en = $request->title_en;
		$mgroups->title_np = $request->title_np;
		//$education->save();
		
		if($mgroups->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("error", "Sorry!! But the data ".$request->title_en." could not be added.");
		endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //dd($slug);
		/*getting members that are not in pivot table i.e. group_members*/
		$members = DB::table('members')->select('members.*')->leftJoin(
					'groups_members', function ($join) use ($slug) {
						$join->on('members.id', '=', 'groups_members.member_id')
							 ->where('groups_members.member_groupid', '=', $slug);
					})->orderBy('full_name','ASC')
					->whereNull('groups_members.member_id')
					->get();
		$mgroup = Membergroup::findOrFail($slug);
		
		$membersgrp = DB::select(DB::raw('SELECT m.id,m.full_name,m.citizenship FROM `groups_members` gm LEFT JOIN members m on m.id=gm.member_id WHERE gm.member_groupid='.$slug.' ORDER BY m.full_name ASC'));

		$this->setPageTitle($mgroup->title_np."मा सदस्यहरू सेट गर्नुहोस्", $mgroup->title_np."मा सदस्यहरू सेट गर्नुहोस्"); 
		return view('admin.membergroup.setgroup',compact('members','mgroup','membersgrp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function edit(Membergroup $membergroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		//dd($request->all());	
        $id = $request->groupid;
		$mgroups = Membergroup::find($id);
		
		$mgroups->title_en = $request->title_en;
		$mgroups->title_np = $request->title_np;
		
		if($mgroups->save()):
			return back()->with("message", "Data added successfully");
			
		else:
			return back()->with("error", "Sorry!! But the data ".$request->title." could not be updated.");
		endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Membergroup  $membergroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membergroup $membergroup)
    {
        //
    }
	
	//assign members to groups
	public function assign(Request $request)
	{
		$membergrp = new GroupsMember();
		if($request->ajax())
		{
			$memberid = $request->memberid;
			//$memberarr = explode(', ',$memberid);
			$groupid = $request->groupid;
			
			foreach($memberid as $member)
			{
				$detail = [
					  "member_id"=> $member,
					  "member_groupid" => $groupid,
					];
					
				$membergrp::insert($detail);
			}
			
			return "success";
		}
	}
	
	//assign members to groups
	public function dismiss(Request $request)
	{
		$membergrp = new GroupsMember();
		if($request->ajax())
		{
			$memberid = $request->memberid;
			//$memberarr = explode(', ',$memberid);
			$groupid = $request->groupid;
			
			foreach($memberid as $member)
			{
				$detail = [
					  "member_id"=> $member,
					  "member_groupid" => $groupid,
					];
					
				GroupsMember::where([['member_id',$member],['member_groupid',$groupid]])->delete();
			}
			
				return "success";
			
		}
	}
}
