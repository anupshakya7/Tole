<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class BusinessHouse extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $table = 'business_house';
    protected $fillable = ['house_no','road','tol','business_name','contact','business_owner','business_certi_no','last_renewed_year','location_swap_ward','location_swap_date','business_reg_date','business_certificate','mobile','business_type'];
	
	
	public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('medium')
              ->width(600)
			  ->quality(100)
			  ->keepOriginalImageFormat();
    }
    
	public function user() 
    {
        return $this->belongsTo(User::class,'created_by','id');
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
