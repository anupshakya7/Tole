<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membersifaris extends Model
{
    protected $table = 'members_sifaris';
    
    //protected $fillable = ['member_id','kidney_transplant','undergoing_dialysis','cancer_patient','spinal_paralysis','severe_disability','moderate_disability','general_disability','disability_certificate'];
	protected $fillable = ['member_id','abeden_id','description'];
	
	public function members()
	{
		return $this->belongsTo(Member::class,'member_id','id');
	}
	
	public function abedans()
	{
		return $this->belongsTo(Abeden::class,'abeden_id','id'); 
	}
}
