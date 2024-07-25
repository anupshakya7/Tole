<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactdetail extends Model
{
    protected $table = 'contact_details';
	
	protected $fillable = ['member_id','temporary_address','temporary_address','contact_no','mobile_no','email','created_by','updated_by'];
}
