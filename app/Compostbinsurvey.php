<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compostbinsurvey extends Model
{
    protected $table = 'compostbinsurveys';
    protected $fillable = ['house_no','road','tol','owner','contact','respondent_no','compostbin_usage','compostbin_source','compostbin_seperated','remarks','reason','house_storey','no_kitchen','total_people'];
	
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
	
	public static function checksurvey($house,$road)
	{
		$check = Compostbinsurvey::where([['house_no',$house],['road',$road]])->exists();
		
		return $check;
	}
	
	
	//survey inspection relation
	public function cinspection()
	{
		return $this->hasOne(SurveyInspection::class,'survey_id');
	}
}
