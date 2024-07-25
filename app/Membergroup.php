<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membergroup extends Model
{
    protected $table = 'member_groups';
	
	protected $fillable = ['title_en','title_np'];
	
	public function members()
	{
		return $this->belongsToMany(Member::class,'groups_members','member_groupid'); 
	}
}
