<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicalconditions extends Model
{
    protected $table = 'medical_conditions';
    
   protected $fillable = ['title','type'];
}
