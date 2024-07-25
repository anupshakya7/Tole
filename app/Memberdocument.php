<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memberdocument extends Model
{
    protected $table = 'member_documents';
	
	protected $fillable = ['member_id','doc_type','doc_number','file','created_by'];
	
	public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
