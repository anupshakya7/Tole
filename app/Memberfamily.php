<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memberfamily extends Model
{
    protected $table = 'member_family';
    
    protected $fillable = ['member_id','grandfather_name','grandfather_np','grandfather_citizen','grandmother_name','grandmother_np','grandmother_citizen','father_name','father_np','father_citizen','mother_name','mother_np','mother_citizen','spouse_name','spouse_np','spouse_citizen','created_by'];
}
