<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TblMessage extends Model
{
    protected $table = 'tbl_message';
    
    protected $fillable = ['title','body','user_id'];
	
	public function user() 
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
	
	public static function getBalance()
	{
		
		$url = setting()->get('api_url')."/api/balancecheck?auth_key=".setting()->get('token');
		$curl = curl_init();
		   curl_setopt($curl, CURLOPT_URL, $url);
		   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		   
		   $response = curl_exec($curl);
		   if(!$response){
			  $response = "500";
		   }else{
		       $data = json_decode($response, true);
            $response = $data['total_credit'];
		   }
		   curl_close($curl);
		   return $response;
		
	}
}
