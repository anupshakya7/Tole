<?php

namespace App\Http\Controllers;

use App\Compostbinsurvey;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{

    public function getCompostbinsurveys()
    {
        if(auth()->user()->hasRole('surveyer')):
			$query = Compostbinsurvey::latest()->where('user_id',\Auth::user()->id);
        else:
            $query = Compostbinsurvey::latest();
		endif;
		
        return datatables($query)->make(true);
    }

}