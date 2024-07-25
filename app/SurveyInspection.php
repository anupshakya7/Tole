<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyInspection extends Model
{
   protected $table = 'survey_inspection';
   
   protected $fillable = ['house_no','usage','compost_production_interval','compost_production','production_status','roof_farming','issues','remarks','road','tol','user_id'];

	public function user()
    {
        return $this->belongsTo(User::class);
    }
	
	public function addresses()
    {
        return $this->belongsTo(Address::class,'road','id');
    }
	
	public function tols()
    {
        return $this->belongsTo(Tol::class,'tol','id'); 
    }
}
