<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membereducation extends Model
{
    protected $table = 'member_education';
	
	protected $fillable = ['member_id','last_qualification','passed_year','created_by','updated_by'];
}
