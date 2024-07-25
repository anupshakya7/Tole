<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupsMember extends Model
{
    protected $table = 'groups_members';
	
	protected $fillable = ['member_id','member_groupid','designation'];
}
