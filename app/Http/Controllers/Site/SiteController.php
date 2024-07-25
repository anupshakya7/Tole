<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests;
use App\Product;
use App\Brand;
use App\Category;
use App\Slider;
use App\Testimonial;
use App\Member;
use App\Contactdetail;
use App\Membereducation;
use App\Memberfamily;
use App\Membermedical;
use App\Memberdocument;
use App\Address;
use App\Tol;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{ 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$category = Category::where([['status','=',1],['brand_id','=','2']])->take(2)->get();
        $products = Product::latest()->where([['status','=',1],['is_supplementary','=',0],['brand_id','2']])->take(4)->get();
		//dd($products);
		$testimonials = Testimonial::where('status',1)->take(4)->get();
		
		$sliders = Slider::where([['status','=','1'],['brand_id','=','2']])->take(2)->get();
        //dd($brands);
        return view('site.index',compact('category','products','testimonials','sliders'));
    }
	
	public function about()
	{
		return view('site.pages.about');
	}
	
	public function contact()
	{
		return view('site.pages.contact');
	}
	
	/*where to buy page*/
	public function where()
	{
		return view('site.pages.where');
	}
	
	public function register()
	{
		$address = Address::get();
		$tol = Tol::get();
		$mdocuments = Member::memdocuments(setting()->get('member_documents'));
		return view('site.member-registration',compact('address','tol','mdocuments'));
	}
	
	public function memberstore(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'full_name' => 'required',
				'dob_bs' => 'required',
				'citizenship'=> "unique:App\Member,citizenship",
				'gender'=>'required|not_in:9',
				'martial_status'=>'required|not_in:9',
				'house_no'=>'required',
				'road'=>'required',
				'tol'=>'required',
				'file.*'=>'mimes:jpg,jpeg,png|max:1000',
				'blood_grp' => 'required|not_in:0',
				'occupation'=>'required|not_in:0',
				'grandfather_name'=>'required',
				'father_name'=>'required',
				'father_citizen'=>'required',
				'mother_name'=>'required',
				'mother_citizen'=>'required',
			],
			[
				'full_name.required'=>'पूरा नामको जानकारी आवश्यक छ ।',
				'dob_bs.required'=>'जन्म मितिको जानकारी आवश्यक छ ।',
				'citizenship.unique'=>'हाम्रो प्रणालीमा नागरिकता नम्बर  '.$request->citizenship.' पहिले नै अवस्थित छ ।',
				'gender.required'=>'लिंगको जानकारी आवश्यक छ ।',
				'martial_status.required'=>'वैवाहिक स्थितिको जानकारी आवश्यक छ ।',
				'house_no.required'=>'घर नम्बरको जानकारी आवश्यक छ ।',
				'road.required'=>'सडकको जानकारी आवश्यक छ ।',
				'tol.required'=>'टोलको जानकारी आवश्यक छ ।',
				'blood_grp.required'=>'रक्त समूहको जानकारी आवश्यक छ ।',
				'occupation.required'=>'पेशाको जानकारी आवश्यक छ ।',
				'grandfather_name.required'=>'हजुरबुबाको नाम आवश्यक छ ।',
				'father_name.required'=>'बुबाको नाम आवश्यक छ ।',
				'father_citizen.required'=>'बुबाको नागरिकता नम्बर आवश्यक छ ।',
				'mother_name.required'=>'आमाको नाम आवश्यक छ ।',
				'mother_citizen.required'=>'आमाको नागरिकता नम्बर आवश्यक छ ।',
				'file.*.mimes'=>'केवल jpg, jpeg र png फोटो फाइलहरूलाई अनुमति छ',
				'file.*.max'=>'माफ गर्नुहोस्! फोटोको लागि max size 1 MB हो',
			]
		);
		
		if($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}
		
        $member = new Member();
		$nepalidate = explode("-",$request->dob_bs);
		$year = $nepalidate[0];
		$month = $nepalidate[1];
		$day = $nepalidate[2]; 
		
		$converttoad = \Bsdate::nep_to_eng($year,$month,$day);
		//dd($converttoad);
		$datead = $converttoad['year'].'-'.$converttoad['month'].'-'.$converttoad['date'];
		//dd($request->dob_bs);;
		//dd($request->dob_bs);
		//dd($request->all());
		if($request->hasfile('image')):
			$member->addMedia($request->image)->toMediaCollection();
		else:
			$member->image = NULL;
		endif;
		
		/*if($request->hasfile('disability_certificate')):
			$member->addMedia($request->disability_certificate)->toMediaCollection();
		else:
			$member->disability_certificate = NULL;
		endif;*/
			
		$user = \Auth::user()->id;
		$member->full_name = $request->full_name;
		$member->fullname_np = $request->fullname_np;
		$member->dob_bs = $request->dob_bs;
		$member->dob_ad = $datead;
		$member->gender = $request->gender;
		$member->martial_status = $request->martial_status;
		$member->citizenship = $request->citizenship;
		$member->birth_registration = $request->birth_registration;
		$member->national_id = $request->national_id;
		$member->house_no = $request->house_no;
		$member->road = $request->road;
		$member->tol = $request->tol;
		$member->blood_group = $request->blood_grp;
		$member->occupation_id = $request->occupation;
		$member->created_by = 1;	
		$member->status=1;		
		$member->source = "SELF";
		
			
		if($member->save()):
			$memberid = $member->id;
			$contact = new Contactdetail();
			$education = new Membereducation();
			$family = new Memberfamily();
			$medical = new Membermedical();
			
			/*saving member related contact*/
			$contact->member_id = $memberid;			
			$contact->temporary_address = $request->temporary_address;
			$contact->contact_no = $request->contact_no;
			$contact->mobile_no = $request->mobile_no;
			$contact->email = $request->email;
			$contact->created_by = $user;	
			$contact->save();
			
			/*saving member related family*/
			$family->member_id = $memberid;			
			$family->grandfather_name = $request->grandfather_name;
			$family->grandfather_np = $request->grandfather_np;
			$family->grandfather_citizen = $request->grandfather_citizen;
			$family->grandmother_name = $request->grandmother_name;
			$family->grandmother_np = $request->grandmother_np;
			$family->grandmother_citizen = $request->grandmother_citizen;
			$family->father_name = $request->father_name;
			$family->father_np = $request->father_np;
			$family->father_citizen = $request->father_citizen;
			$family->mother_name = $request->mother_name;
			$family->mother_np = $request->mother_np;
			$family->mother_citizen = $request->mother_citizen;
			$family->spouse_name = $request->spouse_name;
			$family->spouse_np = $request->spouse_np;
			$family->spouse_citizen = $request->spouse_citizen;
			$family->created_by = $user;			
			$family->save();
			
			/*saving member related education*/
			$education->member_id = $memberid;
			$education->last_qualification = $request->last_qualification;
			$education->passed_year = $request->passed_year;
			$education->created_by = $user;			
			$education->save();
			
			/*saving member related medical*/
			
			foreach($request->medical_problem as $i=>$prob){
				if($prob!='NULL'){
					$detail = [
					"member_id"=>$memberid,
					"medical_problem"=>$prob,
					"created_by"=>$user,
					];
				
					$medical::insert($detail);
				}
			}
			
			$documents = new Memberdocument();
			
			if($request->hasfile('file')): 
				foreach ($request->file("file") as $i => $file): 
					$extension = strtolower(trim($file->getClientOriginalExtension()));
					$docno = str_replace('/', '-', $request->doc_number[$i]);
					$filename = $memberid.'-'.$docno.'-'.$request->doc_type[$i].'.'.$extension;
					//$fullpath = "members/".$request->doc_type[$i].'/'.$filename;
					//$path = $file->storeAs("members/".$request->doc_type[$i],$filename);
					
					$fullpath = $request->doc_type[$i].'/'.$filename;
					$path = $file->storeAs($request->doc_type[$i],$filename);
					//dd($path);
					/*$name = strtolower(trim($file->getClientOriginalExtension()));//$request->doc_number[$i].'-';
					$filename = $request->doc_number[$i].'-'.$request->doc_type[$i].'.'.$name;
					//dd($filename);
					$insert[$i]["name"] = $filename;
					$insert[$i]["store_path"] = $path;*/
					$detail = [
					  "member_id"=> $memberid,
					  "doc_type" => $request->doc_type[$i],
					  "doc_number" => $request->doc_number[$i],
					  "file" => $fullpath,
					  "created_by" => $user,
					];
				$documents::insert($detail);
				endforeach;
			endif;
			
			return back()->with("message", "Member registered successfully");
			
		else:
			return back()->with("message", "Sorry!! But the data could not be added.");
		endif;
	}

}
