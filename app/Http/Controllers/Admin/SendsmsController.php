<?php

namespace App\Http\Controllers\Admin;

use App\Program;
use App\TblMessage;
use App\Houseowner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;

class SendsmsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('users_manage')){
            return abort(401);
        }
		//dd('test');
		$members = DB::select(DB::raw('select m.full_name,cd.mobile_no,m.dob_ad from members m LEFT JOIN contact_details cd on m.id=cd.member_id ORDER BY m.full_name ASC'));

		$houseowners = DB::select(DB::raw('select owner,mobile,house_no from house_owner ORDER BY owner ASC'));
		
		$messages = TblMessage::select('title','body')->latest()->get();

		$businesshouse = DB::select(DB::raw('select business_name,contact,house_no from business_house ORDER BY id ASC'));
		
		//dd($houseowners);
		/*getting the remaining balance of SMS*/
		$balance = TblMessage::getBalance();	
		
		//dd($balance);
		$this->setPageTitle("SMS", "SMS");
		
		return view('admin.sms.index',compact('members','messages','balance','houseowners','businesshouse'));
    }
	
	/*sending sms from sms index page*/
	public function forward(Request $request)
	{
	    $ch = curl_init();


		$destination = explode(', ',$request->des_number);
		
		/*checking if destination number is less than 3000*/
		if(count($destination)<3000){
			//dd("less than 15");
			$apiurl =  setting()->get('api_url')."/sendsms/api?".http_build_query(array(
			"auth_key"=>setting()->get('token'),
			"from"=>$request->sender_number,
                    "to" => $request->des_number,
                    "message" => $request->message,
                ));

curl_setopt($ch, CURLOPT_URL, $apiurl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if(curl_errno($ch)) {

echo  'curl error:' . curl_error($ch);

} else {

// Process the response data (e.g., JSON decode)

$data = json_decode($response, true);

// Use the data here
			if($data[0]==1601):
				return back()->with("message", "SMS sent successfully...");							
			else:
				return back()->with("error", "SMS ".$res[1].". Please contact Web Developer.");	
			endif;


            }

curl_close($ch);


		}else{
			return back()->with("error", "Due To Over Trafficing at the network, please send sms to less than 3000 sms at a time");
		}
		
			
			
	}
}
