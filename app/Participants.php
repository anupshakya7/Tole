<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    protected $table = 'participants';
    protected $fillable = ['full_name','mobile','gender','blood_grp','blood_grp_card','user_id'];
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
}
