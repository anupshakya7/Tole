<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';
    protected $fillable = ['title_en','title_np','quantity'];
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
   
}
