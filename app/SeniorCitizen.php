<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeniorCitizen extends Model
{
    protected $table = 'senior_citizens';
	 
    protected $fillable = [
	'pneumonia_vaccinated', 'respiratory_disease', 'respiratory_medication', 'respiratory_medication_name','regular_excercise',
	'excerise_duration', 'sugar_check_6', 'sugar_level_stat', 'sugar_medication','sugar_medication_name', 'sugar_medication_dosage',
	'sugar_medication_why', 'bloodpressure_check_6', 'bloodpressure_checked_at', 'bloodpressure_level_stat', 'bloodpressure_medication_name',
	'bloodpressure_medication_dosage', 'breast_fed_duration', 'family_medical_issue', 'created_by'];
		
	public function user() 
    {
        return $this->belongsTo(User::class,'created_by');
    }
	
	public function member()
	{
		return $this->belongsTo(Member::class,'elderly_id','citizenship');
	}
	
	public function medicalsurvey()
	{
		return $this->belongsTo(MedicalSurvey::class,'medsurvey_id','id');
	}
}
