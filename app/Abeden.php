<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abeden extends Model
{
   protected $table = 'abeden_format';
    protected $fillable = ['title','abeden','sifaris','abeden_en','sifaris_en','required_docs','status'];
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
}
