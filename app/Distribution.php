<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distribution extends Model
{
	use SoftDeletes;
	
    protected $table = 'distributions';
    protected $fillable = ['program_id','house_no','road','tol','receiver','mobile','citizenship','registered_at','received_at','registered_bs','received_bs','user_id'];
	
	public function addresses()
    {
        return $this->belongsTo(Address::class,'road','id');
    }
	
	public function tols()
    {
        return $this->belongsTo(Tol::class,'tol','id'); 
    }
	
	public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
	
	public function programs()
    {
        return $this->belongsTo(Program::class,'program_id','id');
    }
}
