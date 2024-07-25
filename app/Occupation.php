<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    protected $table = 'occupation';
    protected $fillable = ['occupation','occupation_np'];
}
