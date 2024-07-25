<?php

namespace App;
use DB;
use App\Member;
use App\Houseowner;
use Illuminate\Database\Eloquent\Model;

class MedicalSurvey extends Model
{
    protected $table = 'medical_survey';
	 
    protected $fillable = [
	'house_no', 'road', 'tol', 'under_five_child','elderly_exist','concerned_person', 'concerned_contact', 'ownership', 'year_rented',
	'mtreatment_at', 'rnot_chosing_ward', 'medical_insured', 'insured_at', 'full_child_vaccinate', 
	'missing_vaccine', 'mum_breast_fed', 'breast_unfed', 'breast_fed_duration', 'additional_food', 
	'baby_wt_monitor', 'baby_wt_monitor_time', 'pregnancy_test','pregnant_exists','last_period_date', 'pregnancy_test_times', 'medsurvey_id',
	'why_pregnancytest_notdone', 'iron_pill_intake', 'pregnancy_risk', 'pregnancy_danger_sign', 
	'maternity_test', 'maternity_test_count', 'maternity_iron_pill', 'maternity_issues', 
	'body_mass_index', 'family_planning_done', 'family_planning_device', 'family_planning_perma','family_planning_temp','rubbish_mgmt', 
	'plastic_rubbish_mgmt', 'drinking_water_sr', 'drinking_water_purify', 'method_water_purify', 
	'rainy_season_disease', 'meshed_windows', 'pot_holes', 'pot_pan_water', 'family_dengue', 
	'dengue_prevention','chronic_disease','chronic_disease_name','remarks','elderly_id','chronic_id','user_id'];
	
	
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
	
	public function owner()
	{
		return $this->belongsTo(Houseowner::class,'house_no','house_no');
	}
	
	public function addresses()
    {
        return $this->belongsTo(Address::class,'road','id');
    }
	
	public function tols()
    {
        return $this->belongsTo(Tol::class,'tol','id'); 
    }
	
	public function seniors()
	{
		return $this->hasMany(SeniorCitizen::class,'medsurvey_id');
	}
	
	public static function senior()
	{
		//$senior=date('Y-m-d', strtotime("-60 years"));
		return MedicalSurvey::select('id')->where('elderly_exist','1')->count();
	}
	
	public static function child()
	{
		//$child5=date('Y-m-d',strtotime("-5 years"));
		/*getting total children less or equal to 5 years old number*/
		return MedicalSurvey::select('id')->where('under_five_child','1')->count();
	}
	
	public static function childbyroad()
	{
		$childbyroad = DB::select(DB::raw('select count(ms.id) as total,ad.address_np from medical_survey ms
			 left join address ad on ms.road=ad.id where ms.under_five_child="1" and ms.under_five_child is not null group by ms.road'));
			
		return $childbyroad;	
	}
	
	public static function childbytol()
	{
		$childbytol = DB::select(DB::raw('select count(ms.id) as total,t.tol_np from medical_survey ms
			 left join tol t on ms.tol=t.id where ms.under_five_child="1" and ms.under_five_child is not null group by ms.tol;'));
			
		return $childbytol;	
	}
	
	public static function pneumoniabyroad()
	{
		$row = DB::select(DB::raw('select address_np,
				count(if(sc.pneumonia_vaccinated=1,1,null)) as छ,
				count(if(sc.pneumonia_vaccinated=2,1,null)) as छैन,
				count(if(sc.pneumonia_vaccinated is null,1,null)) as अज्ञात
			from medical_survey ms
			left join address a on a.id=ms.road
            left join senior_citizens sc on sc.medsurvey_id=ms.id
			group by ms.road'));
			
		$pneumoniabyroad = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($pneumoniabyroad[$i]) ? '':$pneumoniabyroad[$i]=array();
				$pneumoniabyroad[$i][] = $val;
			}
		}	
		
		return $pneumoniabyroad;
	}
	
	public static function pneumoniabytol()
	{
		$row = DB::select(DB::raw('select tol_np,
				count(if(sc.pneumonia_vaccinated=1,1,null)) as छ,
				count(if(sc.pneumonia_vaccinated=2,1,null)) as छैन,
				count(if(sc.pneumonia_vaccinated is null,1,null)) as अज्ञात
			from medical_survey ms
			left join tol a on a.id=ms.tol
            left join senior_citizens sc on sc.medsurvey_id=ms.id
			group by ms.tol'));
			
		$pneumoniabytol = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($pneumoniabytol[$i]) ? '':$pneumoniabytol[$i]=array();
				$pneumoniabytol[$i][] = $val;
			}
		}	
		
		return $pneumoniabytol;
	}
	
	public static function pressurebyroad()
	{
		$row = DB::select(DB::raw('select address_np,
				count(if(sc.bloodpressure_level_stat=1,1,null)) as नर्मल, 
				count(if(sc.bloodpressure_level_stat=2,1,null)) as उच्च,
				count(if(sc.bloodpressure_level_stat is null,1,null)) as अज्ञात
			from medical_survey ms
			left join address a on a.id=ms.road
            left join senior_citizens sc on sc.medsurvey_id=ms.id
			group by ms.road'));
			
		$pressurebyroad = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($pressurebyroad[$i]) ? '':$pressurebyroad[$i]=array();
				$pressurebyroad[$i][] = $val;
			}
		}	
		
		return $pressurebyroad;
	}
	
	public static function pressurebytol()
	{
		$row = DB::select(DB::raw('select tol_np,
				count(if(sc.bloodpressure_level_stat=1,1,null)) as नर्मल,
				count(if(sc.bloodpressure_level_stat=2,1,null)) as उच्च,
				count(if(sc.bloodpressure_level_stat is null,1,null)) as अज्ञात
			from medical_survey ms
			left join tol a on a.id=ms.tol
            left join senior_citizens sc on sc.medsurvey_id=ms.id
			group by ms.tol'));
			
		$pressurebytol = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($pressurebytol[$i]) ? '':$pressurebytol[$i]=array();
				$pressurebytol[$i][] = $val;
			}
		}	
		
		return $pressurebytol;
	}
	
	public static function sugarbyroad()
	{
		$row = DB::select(DB::raw('select address_np,
				count(if(sc.sugar_level_stat=1,1,null)) as नर्मल, 
				count(if(sc.sugar_level_stat=2,1,null)) as उच्च,
				count(if(sc.sugar_level_stat is null,1,null)) as अज्ञात
			from medical_survey ms
			left join address a on a.id=ms.road
            left join senior_citizens sc on sc.medsurvey_id=ms.id
			group by ms.road'));
			
		$sugarbyroad = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($sugarbyroad[$i]) ? '':$sugarbyroad[$i]=array();
				$sugarbyroad[$i][] = $val;
			}
		}	
		
		return $sugarbyroad;
	}
	
	public static function sugarbytol()
	{
		$row = DB::select(DB::raw('select tol_np,
				count(if(sc.sugar_level_stat=1,1,null)) as नर्मल,
				count(if(sc.sugar_level_stat=2,1,null)) as उच्च,
				count(if(sc.sugar_level_stat is null,1,null)) as अज्ञात
			from medical_survey ms
			left join tol a on a.id=ms.tol
            left join senior_citizens sc on sc.medsurvey_id=ms.id
			group by ms.tol'));
			
		$sugarbytol = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($sugarbytol[$i]) ? '':$sugarbytol[$i]=array();
				$sugarbytol[$i][] = $val;
			}
		}	
		
		return $sugarbytol;
	}
	
	public static function insurancebyroad()
	{
		$row = DB::select(DB::raw('select address_np,
				count(if(ms.medical_insured=1,1,null)) as छ, 
				count(if(ms.medical_insured=2,1,null)) as छैन,
				count(if(ms.medical_insured is null,1,null)) as अज्ञात
			from medical_survey ms
			left join address a on a.id=ms.road
			group by ms.road'));
			
		$insurancebyroad = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($insurancebyroad[$i]) ? '':$insurancebyroad[$i]=array();
				$insurancebyroad[$i][] = $val;
			}
		}	
		
		return $insurancebyroad;
	}
	
	public static function insurancebytol()
	{
		$row = DB::select(DB::raw('select tol_np,
				count(if(ms.medical_insured=1,1,null)) as छ, 
				count(if(ms.medical_insured=2,1,null)) as छैन,
				count(if(ms.medical_insured is null,1,null)) as अज्ञात
			from medical_survey ms
			left join tol a on a.id=ms.tol
			group by ms.tol'));
			
		$insurancebytol = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($insurancebytol[$i]) ? '':$insurancebytol[$i]=array();
				$insurancebytol[$i][] = $val;
			}
		}	
		
		return $insurancebytol;
	}
	
	
	public static function ownershipbyroad()
	{
		$row = DB::select(DB::raw('select address_np,
				count(if(ms.ownership=1,1,null)) as आफ्नै, 
				count(if(ms.ownership=2,1,null)) as भाडा,
				count(if(ms.ownership=3,1,null)) as ब्यबासायिक
			from medical_survey ms
			left join address a on a.id=ms.road
			group by ms.road'));
			
		$insurancebyroad = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($insurancebyroad[$i]) ? '':$insurancebyroad[$i]=array();
				$insurancebyroad[$i][] = $val;
			}
		}	
		
		return $insurancebyroad;
	}
	
	public static function ownershipbytol()
	{
		$row = DB::select(DB::raw('select tol_np,
				count(if(ms.ownership=1,1,null)) as आफ्नै, 
				count(if(ms.ownership=2,1,null)) as भाडा,
				count(if(ms.ownership=3,1,null)) as ब्यबासायिक
			from medical_survey ms
			left join tol a on a.id=ms.tol
			group by ms.tol'));
			
		$insurancebytol = array();
		foreach($row as $data){
			foreach($data as $i=>$val){
				isset($insurancebytol[$i]) ? '':$insurancebytol[$i]=array();
				$insurancebytol[$i][] = $val;
			}
		}	
		
		return $insurancebytol;
	}
	
	public static function remainderhouse()
	{
		$remainder =  DB::select(DB::raw('select count(ho.house_no) as total from medical_survey ms
			 right join house_owner ho on ms.house_no=ho.house_no and ms.road=ho.road and ms.tol=ho.tol 
			where ms.house_no is null'));
		
		foreach($remainder as $data){
			$house = $data->total;
		}
		
		return $house;//count($arrdata);
	}
	
	public static function completedhouse()
	{
		$total = Houseowner::select('id')->count();
		return $total-self::remainderhouse();
	}
}
