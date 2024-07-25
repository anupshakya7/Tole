<?php

namespace App;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends Model 
{
	//use InteractsWithMedia;
	
    protected $table = 'members';
	
	protected $fillable = ['full_name','dob_ad','dob_bs','gender','birth_registration','martial_status','house_no','road','tol','blood_group','image','created_by','updated_by'];
	 
	/*protected $dates = [
        'dob_ad'
    ];*/
	
	/*public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('medium')
              ->width(300)
              ->height(300)
			  ->quality(100)
			  ->keepOriginalImageFormat();
    }*/
	
	public function user() 
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
	
	public function job()
    {
        return $this->belongsTo(Occupation::class,'occupation_id','id'); 
    }
	
	public function addresses() 
    {
        return $this->belongsTo(Address::class,'road','id');
    }
	
	public function tols()
    {
        return $this->belongsTo(Tol::class,'tol','id'); 
    }
	
	public function documents()
	{
		return $this->hasMany(Memberdocument::class,'member_id','id');
	}
	
	public function medicals()
	{
		return $this->hasMany(Membermedical::class,'member_id','id');
	}
	
	public function contacts()
	{
		return $this->hasOne(Contactdetail::class,'member_id');
	}	
	
	public function education()
	{
		return $this->hasOne(Membereducation::class,'member_id');
	}
	
	public function familys()
	{
		return $this->hasOne(Memberfamily::class,'member_id');
	}
	
	public function groups()
	{
		return $this->belongsToMany(Membergroup::class,'groups_members','member_id','member_groupid')->withPivot('designation');;
	}
	
	//getting designations from settings, converting it into array and returning
	public static function designation($designation)
	{
		$posts = explode(', ',$designation);
		
		return $posts;
	}
	
	//getting members document type required from settings, converting it into array and returning
	public static function memdocuments($memdocuments)
	{
		$mdocuments = explode(', ',$memdocuments);
		return $mdocuments;
	}
	
	public function mabedans()
	{
		return $this->hasMany(Memberabeden::class,'member_id');
	}
	
	//get profile completion percentage
	public static function profilepercentage($profile)
	{
		if ( ! $profile) {
		return 0;
		}
	
		$columns    = preg_grep('/(.+ed_at)|(.*id)|(.+ed_by)/', array_keys($profile->toArray()), PREG_GREP_INVERT);
		
		$per_column = 100 / count($columns);
		$total      = 0;	

		foreach ($profile->toArray() as $key => $value) {
			if ($value !== NULL && $value !== [] && in_array($key, $columns)) {
				$total += $per_column;
				}
		}
		
		$rpercentage = (int) round($total);
		
		return $rpercentage;
	}
	
}
