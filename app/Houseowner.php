<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Houseowner extends Model
{
    protected $table = 'house_owner';
    protected $fillable = ['gbin','house_no','taxpayer_id','road','tol','owner','owner_np','contact','mobile','respondent','respondent_np','no_of_tenants','occupation','gender','flag'];
	
	public function addresses()
    {
        return $this->belongsTo(Address::class,'road','id');
    }
	
	public function tols()
    {
        return $this->belongsTo(Tol::class,'tol','id'); 
    }
	
	public function job()
    {
        return $this->belongsTo(Occupation::class,'occupation','id'); 
    }
	
	public function medicalsurvey()
	{
		return $this->hasMany(MedicalSurvey::class,'house_no','house_no');
	}
	
	public static function checkowner($house,$road)
	{
		$check = Houseowner::where([['house_no',$house],['road',$road]])->exists();
		
		return $check;
	}
}
