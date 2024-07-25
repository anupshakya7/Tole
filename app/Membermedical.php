<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membermedical extends Model
{
    protected $table = 'member_medical';
    
    //protected $fillable = ['member_id','kidney_transplant','undergoing_dialysis','cancer_patient','spinal_paralysis','severe_disability','moderate_disability','general_disability','disability_certificate'];
	protected $fillable = ['member_id','medical_problem','medical_status'];
}
