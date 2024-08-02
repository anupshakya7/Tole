<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated'
            ]);
        }
    }
}
