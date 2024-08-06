<?php

namespace App\Http\Controllers\API;

use App\Contactdetail;
use App\Http\Controllers\Controller;
use App\Member;
use App\Memberdocument;
use App\Membereducation;
use App\Memberfamily;
use App\Membermedical;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Spatie\MediaLibrary\Models\Media;

class MemberController extends Controller
{
    public function member(Request $request, $slug = null)
    {
        $user = $request->user('api');

        if ($user) {
            $query = Member::query();
            if ($slug == "senior-citizen") {
                $year = date('Y-m-d', strtotime('-60 years'));
                $query->where(DB::raw('date(dob_ad)'), '<=', $year)->where('dob_ad', '!=', 'N/A');
            }
            if ($slug == "senior-citizen-sixty") {
                $year = date('Y-m-d', strtotime('-68 years'));
                $query->where(DB::raw('date(dob_ad)'), '<', $year)->where('dob_ad', '!=', 'N/A');
            }
            if ($slug == "senior-citizen-above-sixty-eight") {
                $minAge = date('Y-m-d', strtotime('-68 years'));
                $maxAge = date('Y-m-d', strtotime('-71 years'));

                $query->whereBetween(DB::raw('date(dob_ad)'), [$maxAge, $minAge])->where('dob_ad', '!=', 'N/A');
            }
            if ($slug == "belowsixteen") {
                $year = date('Y-m-d', strtotime('-16 years'));
                $query->where(DB::raw('date(dob_ad)'), '>=', $year)->whereNotNull('dob_ad');
            }
            if ($slug == "youth") {
                $startDate = Carbon::now()->subYears(30)->format('Y-m-d');
                $endDate = Carbon::now()->subYears(16)->format('Y-m-d');
                $query->whereBetween('dob_ad', [$startDate, $endDate]);
            }

            if ($user->hasRole('administrator')) {
                $member = $query->get();
            } else {
                $member = $query->where('created_by', $user->id)->get();
            }
            return response()->json([
                'success' => true,
                'data' => $member
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated'
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user('api');

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'dob_bs' => 'required',
            'citizenship' => 'required|unique:members,citizenship',
            'gender' => 'required|not_in:9',
            'martial_status' => 'required|not_in:9',
            'house_no' => 'required',
            'road' => 'required',
            'tol' => 'required',
            'file.*' => 'mimes:jpg,jpeg,png|max:1000',
            'blood_grp' => 'required|not_in:0',
            'occupation' => 'required|not_in:0',
        ], [
            'full_name.required' => 'पूरा नामको जानकारी आवश्यक छ ।',
            'dob_bs.required' => 'जन्म मितिको जानकारी आवश्यक छ ।',
            'citizenship.unique' => 'हाम्रो प्रणालीमा नागरिकता नम्बर ' . $request->citizenship . ' पहिले नै अवस्थित छ ।',
            'gender.required' => 'लिंगको जानकारी आवश्यक छ ।',
            'martial_status.required' => 'वैवाहिक स्थितिको जानकारी आवश्यक छ ।',
            'house_no.required' => 'घर नम्बरको जानकारी आवश्यक छ ।',
            'road.required' => 'सडकको जानकारी आवश्यक छ ।',
            'tol.required' => 'टोलको जानकारी आवश्यक छ ।',
            'blood_grp.required' => 'रक्त समूहको जानकारी आवश्यक छ ।',
            'occupation.required' => 'पेशाको जानकारी आवश्यक छ ।',
            'file.*.mimes' => 'पूरा नामको जानकारी आवश्यक छ ।',
            'file.*.max' => 'पूरा नामको जानकारी आवश्यक छ ।',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        if ($user) {
            $member = new Member();
            $nepalidate = explode('-', $request->dob_bs);
            $year = $nepalidate[0];
            $month = $nepalidate[1];
            $day = $nepalidate[2];

            if ($year >= 2000) {
                $converttoad = \Bsdate::nep_to_eng($year, $month, $day);
                $dated = $converttoad['year'] . '-' . $converttoad['month'] . '-' . $converttoad['date'];
            } else {
                $dated = "N/A";
            }

            if ($request->hasfile('image')) {
                $member->addMedia($request->image)->toMediaCollection();
            } else {
                $member->image = NULL;
            }

            $user = auth('api')->user()->id;
            $member->full_name = $request->full_name;
            $member->fullname_np = $request->fullname_np;
            $member->dob_bs = $request->dob_bs;
            $member->dob_ad = $dated;
            $member->gender = $request->gender;
            if ($request->martial_status != 9) {
                $member->martial_status = $request->martial_status;
            }
            $member->citizenship = $request->citizenship;
            $member->birth_registration = $request->birth_registration;
            $member->national_id = $request->national_id;
            $member->house_no = $request->house_no;
            $member->road = $request->road;
            $member->tol = $request->tol;
            $member->blood_group = $request->blood_grp;
            $member->occupation_id = $request->occupation;
            $member->created_by = $user;

            if ($member->save()) {
                $memberid = $member->id;
                $contact = new Contactdetail();
                $education = new Membereducation();
                $family = new Memberfamily();
                $medical = new Membermedical();

                // Member Contact
                $contact->member_id = $memberid;
                $contact->temporary_address = $request->temporary_address;
                $contact->contact_no = $request->contact_no;
                $contact->mobile_no = $request->mobile_no;
                $contact->email = $request->email;
                $contact->created_by = $user;
                $contact->save();

                // Related Family
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

                //Member Education
                $education->member_id = $memberid;
                $education->last_qualification = $request->last_qualification;
                $education->passed_year = $request->passed_year;
                $education->created_by = $user;
                $education->save();

                // Member Medical
                if (!empty($request->medical_problem)) {
                    foreach ($request->medical_problem as $i => $prob) {
                        if ($prob != 'NULL') {
                            $detail = [
                                "member_id" => $memberid,
                                "medical_problem" => $prob,
                                "created_by" => $user
                            ];

                            $medical::insert($detail);
                        }
                    }
                }

                $documents = new Memberdocument();

                if ($request->hasFile('file')) {
                    foreach ($request->file("file") as $i => $file) {
                        $extension = strtolower(trim($file->getClientOriginalExtension()));
                        $docno = str_replace('/', '-', $request->doc_number[$i]);
                        $filename = $memberid . '-' . $docno . '-' . $request->doc_type[$i] . '.' . $extension;

                        $fullpath = $request->doc_type[$i] . '/' . $filename;
                        $path = $file->storeAs($request->doc_type[$i], $filename);

                        $detail = [
                            "member_id" => $memberid,
                            "doc_type" => $request->doc_type[$i],
                            "doc_number" => $request->doc_number[$i],
                            "file" => $fullpath,
                            "created_by" => $user,
                        ];
                        $documents::insert($detail);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Data Added Successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry!! But the data could not be added.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated'
            ]);
        }
    }

    public function update(Request $request,$id){
        $user = $request->user('api');
        if($user->hasRole('administrator')){
            $member = Member::find($id);
            if($request->file('image')){
                if(isset($request->mediaid) && !empty($request->mediaid)){
                    $media = Media::where('model_id',$request->mediaid)->first();
                    if($media){
                        $model_type = $media->model_type;
                        $model = $model_type::find($media->model_id);
                        $model->deleteMedia($media->id);
                    }
                }
                $member->addMedia($request->image)->toMediaCollection();
            }
    
            $nepalidate = explode("-",$request->dob_bs);
            $year = $nepalidate[0];
            $month = $nepalidate[1];
            $day = $nepalidate[2];
    
            if($year >= 2000){
                $converttoad = \Bsdate::nep_to_eng($year,$month,$day);
                $dated = $converttoad['year'].'-'.$converttoad['year'].'-'.$converttoad['date'];
            }else{
                $dated = "N/A";
            }

            $member->full_name = $request->full_name;
            $member->fullname_np = $request->fullname_np;
            $member->dob_bs = $request->dob_bs;
            $member->dob_ad = $request->dob_ad;
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
    
            if($member->save()){
                return response()->json([
                    'success'=>true,
                    'message'=>'Member '.$request->full_name.' updated successfully'
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Member '.$request->full_name.' could not be Updated'
                ]);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'User is not allowed'
            ]);
        }
       
        
    }

    public function delete(Request $request,$id){
        $user = $request->user('api');

        if($user->hasRole('administrator')){
            $member =  Member::find($id);
            if($member){
                Contactdetail::where('member_id',$member->id)->delete();
                Membereducation::where('member_id',$member->id)->delete();
                Memberfamily::where('member_id',$member->id)->delete();
                Membermedical::where('member_id',$member->id)->delete();
    
                $member->delete();
                return response()->json([
                    'success'=>true,
                    'message'=>$member->full_name.' data has been Deleted!!!'
                ]);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Member Not Found'
                ]);
            }
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'User is not allowed'
            ]);
        }
       
    }
}
