<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';
    protected $fillable = ['title','venue','event_date','user_id'];
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
}
