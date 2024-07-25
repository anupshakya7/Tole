@php
   if(auth()->user()->hasRole('surveyer')) {
      $layoutDirectory = 'layouts.surveyer-web';
   } else {
      $layoutDirectory = 'layouts.admin-web';
   }
@endphp

@extends($layoutDirectory)
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
label{margin-top:15px;padding-right: 15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}
.hidden{display:none;}
.has-error .invalid-feedback{
  display:block;
  font-size:16px;
}
.has-error .form-control{
border: 1px solid red;
}
@media(max-width:767px){
	.radio-inline{
  font-size:14px;
  font-weight: 600;
}
.error{font-size:10px;line-height:1.2;}
}
.card-title{
padding: 15px;
    text-align: center;}
.div-header{border-bottom: 1px solid var(--vz-border-color);margin-top:10px;}

</style>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">Medical Survey</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ $survey->concerned_person}}</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header border-bottom-dashed">
							<h5 class="card-title mb-0">{{ 'Add Medical Survey data' }}</h5>
						</div>

						<div class="card-body">
								<div class="row">
									<div class="col-12 div-header owner-details" style="padding-bottom: 15px;background:lightgrey;">
										<div class="row">
											<h5 class="card-title center-title mb-0">घर धनिको विवरण</h5>
											<div class="table-responsive">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>{{ 'घर नं.' }}</th>
															<th>{{ 'घर धनि' }}</th>
															<th>{{ 'मोबाइल' }}</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td id="hno">{{$survey->house_no}}</td>
															<td id="onm">{{$survey->concerned_person}}</td>
															<td id="omob">{{$survey->concerned_contact}}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									
									<div class="col-6">
										<label>{{ 'सडक नाम' }}</label>
										<p>{{$survey->addresses->address_np}}</p>
									</div>
									
									<div class="col-6">
										<label for="tol">{{ 'टोल' }}</label>
										<p>{{$survey->tols->tol_np}}</p>
									</div>
									
									<div class="div-header border-bottom-dashed" style="padding-bottom: 15px;">									
										<div class="row">											
											<div class="col-6">
												<label for="slug">{{ 'घर स्वामित्व' }}</label><br>
												<p>{{  $survey->ownership === '1' ? 'आफ्नै' : ($survey->ownership ==='2' ? 'भाडामा' : 'ब्यापार') }}</p>
											</div>
											
											<div class="col-6">
												<label for="year_rented">{{' कुपोण्डोलमा भाडामा बसेको कति भयो ?' }}</label>
												<p>{{$survey->year_rented!=NULL ? $survey->year_rented : 'N/A'}}</p>
											</div>
				
											<div class="col-6">
												<label for="slug">{{'घरमा गर्भवति तथा ५ बर्ष मुनिक बच्चा छ? '}}</label><br>
															
												<p>{{$survey->under_five_child==1 ? 'छ' : 'छैन'}}</p>
											</div>
											
											<div class="col-6">
												<label for="slug">{{ 'घरमा जेष्ठ नागरिक छ?' }}</label><br>
															
												<p>{{$survey->elderly_exist==1 ? 'छ' : 'छैन'}}</p>
											</div>											
											<div class="col-6">
													<label for="slug">{{ 'तपाईलाई नसर्ने तथा दीर्घरोग सम्बन्धि समस्या छ ?' }}</label><br>
													<p>{{$survey->chronic_disease==1 ? 'छ':'छैन'}}</p>		
													
											</div>
											<div class="col-6">
												<label for="chronic_disease_name">{{'कुन नसर्ने अथवा दीर्घरोग छ ?' }}</label>
												<p>{{$survey->chronic_disease_name!=NULL ? $survey->chronic_disease_name : 'N/A'}}</p>												
											</div>									
																						
											<div class="col-6">
												<label for="mtreatment_at">{{ 'विरामी हुँदा उपचार स्थान' }}</label>
												<p>{{$survey->mtreatment_at}}</p>
											</div>
											
											<div class="col-6">
												<label for="rnot_chosing_ward">{{'वडा स्थित आधारभूत स्वास्थ्य केन्द्रमा नजानुको कारण के हो ?' }}</label>
												<p>{{$survey->rnot_chosing_ward!=NULL ? $survey->rnot_chosing_ward : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="slug">{{'स्वास्थ्य विमा गर्नु भएको छ ?' }}</label><br>
												<p>{{$survey->medical_insured==1 ? 'छ': 'छैन'}}</p>	
											</div>
											
											<div class="col-6">
												<label for="insured_at">{{'स्वास्थ्य विमा कहाँ गर्नु भएको छ ?' }}</label>
												<p>{{$survey->insured_at!=NULL ? $survey->insured_at : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="body_mass_index">{{'बडी मास इन्डेक्स कस्तो रहेको छ ? (तौल र उचाईको हिसाब गरेर भर्ने)' }}</label>
												<p>{{$survey->body_mass_index!=NULL ? $survey->body_mass_index : 'N/A'}}</p>
											</div>
										</div>
									</div>
									
									<?php if(count($survey->seniors)>0):?>
										<div class="col-12 div-header elderly border-bottom-dashed" style="padding-bottom: 15px;">
											<div class="row">
												<h5 class="card-title mb-0">ज्येष्ठ नागरिक दाटा</h5> 
												<?php foreach($survey->seniors as $senior):?>
												<div class="col-12 card" style="padding: 30px;">
													<div id="card-body"> 
														<div class="clone-item employee-info-wrap">
															<div class="row">
																<div class="col-6">
																	<label class="form-label" for="citizenship">{{'नागरिकता नम्बर'}} </label>
																	<p>{{$senior->elderly_id}}</p>
																</div>
																<div class="col-6">
																	<label for="slug">{{'के तपाईले निमोनियाको खोप लगाउनु भयो ?' }}</label><br>
																	<p>{{$senior->pneumonia_vaccinated==1 ? 'छ':'छैन'}}</p>	
																</div>
																
																<div class="col-6">
																	<label for="pneumonia_vacciated_count">{{'न्युमोनियाको खोप कति पटक लगाउनु भयो?' }}</label>
																	<p>{{$senior->family_planning_done!=NULL ? $senior->family_planning_done: 'N/A'}}</p>
																</div>
																
																<div class="col-6 listradio form-group {{ $errors->has('respiratory_disease') ? 'has-error' : '' }}">
																	<label for="slug">{{'स्वास प्रश्वास सम्बन्धि रोग जस्तै न्युमोनिया ,दम सम्बन्धि समस्या रहेको छ ?' }}</label><br>
																	<p>{{$senior->respiratory_disease==1 ? 'छ':'छैन'}}</p>	
																</div>
																
																<div class="col-6 listradio form-group respiratory_medications">
																	<label for="slug">{{'नियमित औषधि सेवन गरिरहनु भएको छ ?' }}</label><br>
																	<p>{{  $senior->respiratory_medication === NULL ? 'N/A' : ($senior->respiratory_medication ==='1' ? 'छ' : 'छैन') }}</p>
																</div>
																
																<div class="col-6 form-group form-check respiratory_medication_names">
																	<label for="medication_name">{{'औषधिको नाम' }}</label>
																	<p>{{$senior->respiratory_medication_name!=NULL ? $senior->respiratory_medication_name: 'N/A'}}</p>
																</div>
																
																<div class="col-6 listradio form-group {{ $errors->has('regular_excercise') ? 'has-error' : '' }}">
																	<label for="slug">{{'दैनिक योग, ब्यायाम वा मर्निङ्ग वाक गर्नुहुन्छ ?' }}</label><br>
																	<p>{{$senior->regular_excercise==1 ? 'गर्छु':'गर्दिन'}}</p>	
																</div>
																
																<div class="col-6 form-group form-check excerise_durations">
																	<label for="excerise_duration">{{'दैनिक ब्यायाम अवधि' }}</label>
																	<p>{{$senior->excerise_duration!=NULL ? $senior->excerise_duration: 'N/A'}}</p>
																</div>
																
																<div class="col-6 listradio form-group {{ $errors->has('sugar_check_6') ? 'has-error' : '' }}">
																	<label for="slug">{{'के तपाईले ६ महिना भित्रमा सुगर जाँच गराउनु भएको छ ?' }}</label><br>
																	<p>{{$senior->sugar_check_6==1 ? 'छ':'छैन'}}</p>	
																</div>
																
																<div class="col-6 listradio form-group {{ $errors->has('sugar_level_stat') ? 'has-error' : '' }}">
																	<label for="slug">{{'सुगर लेभल कस्तो छ ?' }}</label><br>
																	<p>{{$senior->sugar_level_stat==1 ? 'नर्मल छ':'नर्मल भन्दा बढी'}}</p>	
																</div>
																
																<div class="col-6 listradio form-group sugar_medications{{ $errors->has('sugar_medication') ? 'has-error' : '' }}">
																	<label for="slug">{{'सुगरको नियमित औषधि सेवन गर्नुभएको छ ?' }}</label><br>
																	<p>{{  $senior->sugar_medication === NULL ? 'N/A' : ($senior->sugar_medication ==='1' ? 'छ' : 'छैन') }}</p>
																</div>
																
																<div class="col-6 form-group form-check sugar_medication_names">
																	<label for="sugar_medication_name">{{'सुगर औषधिको नाम' }}</label>
																	<p>{{$senior->sugar_medication_name!=NULL ? $senior->sugar_medication_name: 'N/A'}}</p>
																</div> 
																
																<div class="col-6 form-group form-check sugar_medication_dosages">
																	<label for="sugar_medication_dosage">{{'सुगर औषधिको  मात्रा' }}</label>
																	<p>{{$senior->sugar_medication_dosage!=NULL ? $senior->sugar_medication_dosage: 'N/A'}}</p>
																</div>
																
																<div class="col-6 form-group form-check sugar_medication_whys">
																	<label for="sugar_medication_why">{{'सुगरको औषधि किन नलिनुभएको ?' }}</label>
																	<p>{{$senior->sugar_medication_why!=NULL ? $senior->sugar_medication_why: 'N/A'}}</p>
																</div>
																
																<div class="col-6 listradio form-group {{ $errors->has('bloodpressure_check_6') ? 'has-error' : '' }}">
																	<label for="slug">{{'के तपाईले ६ महिना भित्रमा रक्तचापको परिक्षण गराउनु भएको छ ?' }}</label><br>
																	<p>{{$senior->bloodpressure_check_6==1 ? 'छ':'छैन'}}</p>	
																</div>
																
																<div class="col-6 form-group form-check bloodpressure_checked_at">
																	<label for="bloodpressure_checked_at">{{'रक्तचापको परिक्षण कहाँ गराउनु भयो ?' }}</label>
																	<p>{{$senior->bloodpressure_checked_at!=NULL ? $senior->bloodpressure_checked_at: 'N/A'}}</p>
																</div>
																
																<div class="col-6 listradio form-group {{ $errors->has('bloodpressure_level_stat') ? 'has-error' : '' }}">
																	<label for="slug">{{'रक्तचापको अवस्था कस्तो छ ?' }}</label><br>
																	<p>{{$senior->sugar_level_stat==1 ? 'नर्मल छ':'नर्मल भन्दा बढी'}}</p>			
																	<label for="bloodpressure_level_stat" class="radio-inline">
																</div>
																
																<div class="col-6 listradio form-group bloodpressure_symptoms">
																	<label for="slug">{{'उच्च रक्तचाप भएको भएमा विगतमा तपाईलाई छाती दुख्ने वा हृदयघात हुने गरेको वा लक्षण देखिएको छ ?' }}</label><br>
																	<p>{{  $senior->bloodpressure_symptoms === NULL ? 'N/A' : ($senior->bloodpressure_symptoms ==='1' ? 'छ' : 'छैन') }}</p>
																</div>
																
																<div class="col-6 listradio form-group bloodpressure_medications">
																	<label for="slug">{{'उच्च रक्तचापको नियमित औषधि सेवन गर्नु भएको छ ?' }}</label><br>
																	<p>{{  $senior->bloodpressure_medication === NULL ? 'N/A' : ($senior->bloodpressure_medication ==='1' ? 'छ' : 'छैन') }}</p>
																</div>
																
																<div class="col-6 form-group form-check bloodpressure_medication_names">
																	<label for="bloodpressure_medication_name">{{'रक्तचापको औषधिको नाम' }}</label>
																	<p>{{$senior->bloodpressure_medication_name!=NULL ? $senior->bloodpressure_medication_name: 'N/A'}}</p>
																</div>
																
																<div class="col-6 form-group form-check bloodpressure_medication_dosages">
																	<label for="bloodpressure_medication_dosage">{{'रक्तचापको औषधिको  मात्रा' }}</label>
																	<p>{{$senior->bloodpressure_medication_dosage!=NULL ? $senior->bloodpressure_medication_dosage: 'N/A'}}</p>
																</div>
																
																<div class="col-6 form-group form-check family_medical_issue">
																	<label for="family_medical_issue">{{'तपाईको मूख्य स्वास्थ्य समस्या के हो ?' }}</label>
																	<p>{{$senior->family_medical_issue!=NULL ? $senior->family_medical_issue: 'N/A'}}</p>
																</div>		
															</div>
														</div>
													</div>
												</div>
												<?php endforeach;?>
											</div>
										</div>	
									<?php endif;?>
									
									<div class="col-12 div-header border-bottom-dashed family-planning" style="padding-bottom: 15px;">
										<div class="row">
										
											<h5 class="card-title mb-0">( १५ देखि ४९ वर्ष सम्मका महिला पुरुषलाई प्रश्न)</h5>
											<div class="col-6 listradio">
												<label for="slug">{{'परिवार नियोजनको साधनको प्रयोग गर्नुभएको छ?' }}</label>
												<p>{{  $survey->family_planning_done === NULL ? 'N/A' : ($survey->family_planning_done ==='1' ? 'छ' : 'छैन') }}</p>	
											</div>
											
											<div class="col-6 form-group listradio family_planning_device">
												<label for="family_planning_device">{{'कुन साधन प्रयोग गर्नुभएको छ ?' }}</label><br><br>
												<p>{{  $survey->family_planning_device === NULL ? 'N/A' : ($survey->family_planning_device ==='1' ? 'स्थायी' : 'अस्थायी') }}</p>
											</div>
											
											<div class="col-md-6 form-group family_planning_permas">
												<label for="family_planning_perma">{{'कुन स्थायी साधनको प्रयोग गर्नुभयो? ' }}</label>
												<p>{{$survey->family_planning_perma!=NULL ? $survey->family_planning_perma : 'N/A'}}</p>
											</div>
											
											<div class="col-md-5 form-group family_planning_temps">
												<label for="family_planning_temp">{{'कुन अस्थायी साधनको प्रयोग गर्नुभयो?  ' }}</label>
												<p>{{$survey->family_planning_temp!=NULL ? $survey->family_planning_temp : 'N/A'}}</p>
										</div>
									</div>	
									
									<div class="col-12 div-header border-bottom-dashed" style="padding-bottom: 15px;"> 
										<div class="row">
											<h5 class="card-title mb-0">मातृ तथा नवजात शिशु  </h5> 
											<div class="col-6">
												<label for="full_child_vaccinate">{{'बच्चालाई पूर्ण खोप लगाउनुभयो ?' }}</label>
												<p>{{$survey->full_child_vaccinate!=NULL ? $survey->full_child_vaccinate : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="missing_vaccine">{{'छुटेको खोप' }}</label>
												<p>{{$survey->missing_vaccine!=NULL ? $survey->missing_vaccine : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="slug">{{'के बच्चालाई आमाको दुध खुवाउनु भयो ?' }}</label><br>
												<p>{{  $survey->mum_breast_fed === NULL ? 'N/A' : ($survey->mum_breast_fed ==='1' ? 'खुवाए' : 'खुवाएन') }}</p>
											</div>
											
											<div class="col-6">
												<label for="breast_unfed">{{'किन खुवाउनु भएन ?' }}</label>
												<p>{{$survey->breast_unfed!=NULL ? $survey->breast_unfed : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="breast_fed_duration">{{'बच्चालाई आमाको दुध कुन उमेर सम्म खुवाउनु भयो ?' }}</label>
												<p>{{$survey->breast_fed_duration!=NULL ? $survey->breast_fed_duration : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="additional_food">{{'बच्चा कति महिनाको भएपछि आमाको दुधको अलावा थप खाना खुवाउनु भयो ?' }}</label>
												<p>{{$survey->additional_food!=NULL ? $survey->additional_food : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="slug">{{' बच्चाको वजन वृद्धि अनुगमन गराउनु भयो ?' }}*</label><br>
												<p>{{  $survey->baby_wt_monitor === NULL ? 'N/A' : ($survey->baby_wt_monitor ==='1' ? 'गराए' : 'गराएन') }}</p>	
											</div>

											<div class="col-6">
												<label for="baby_wt_monitor_time">{{'कति पटक बच्चाको वजन अनुगमन गराउनु भयो?' }}</label>
												<p>{{$survey->baby_wt_monitor_time!=NULL ? $survey->baby_wt_monitor_time : 'N/A'}}</p>
											</div>	

											<div class="col-6">
												<label for="pregnant_exists">{{'तपाईंको घरमा गर्भवती तथा ४५ दिन भित्रको सुत्केरी हुनुहुन्छ?' }}</label><br>
												<p>{{  $survey->pregnant_exists === NULL ? 'N/A' : ($survey->pregnant_exists ==='1' ? 'छ' : 'छैन') }}</p>	
											</div>	
											
											<div class="col-6">
												<label for="last_period_date">{{'अन्तिम महिनवरी मिती' }}</label>
												<p>{{$survey->last_period_date!=NULL ? $survey->last_period_date : 'N/A'}}</p>
											</div>
											<div class="col-6">
												<label for="slug">{{'तपाईँ गर्भवती हुँदा गर्भजाँच गराउनु भयो ?' }}</label><br>
												<p>{{  $survey->pregnancy_test === NULL ? 'N/A' : ($survey->pregnancy_test ==='1' ? 'गराए' : 'गराएन') }}</p>	
											</div>
											
											<div class="col-6">
												<label for="pregnancy_test_times">{{'गर्भजाँच कती पटक गर्नुभयो ?' }}</label>
												<p>{{$survey->pregnancy_test_times!=NULL ? $survey->pregnancy_test_times : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="why_pregnancytest_notdone">{{'किन गर्भजाँच गराउनु भएन ?' }}</label>
												<p>{{$survey->why_pregnancytest_notdone!=NULL ? $survey->why_pregnancytest_notdone : 'N/A'}}</p>
											</div>
											
											<div class="col-6">
												<label for="slug">{{'तपाईँ गर्भवती हुँदा आइरन चक्की, जुकाको औषधी खानुभयो ?' }}</label><br>
												<p>{{  $survey->iron_pill_intake === NULL ? 'N/A' : ($survey->iron_pill_intake ==='1' ? 'खाएँ' : 'खाएन') }}</p>	
											</div>
											
											<div class="col-6">
												<label for="slug">{{'तपाईँ गर्भवती हुँदा १८० चक्की आइरन खानुभयो ?' }}</label><br>
												<p>{{  $survey->one80_iron_pill === NULL ? 'N/A' : ($survey->one80_iron_pill ==='1' ? 'खाएँ' : 'खाएन') }}</p>
											</div>
											
											<div class="col-6">
												<label for="slug">{{'गर्भावस्थामा हुने खतराको लक्षण बारेमा थाहा छ ?' }}</label><br>
												<p>{{  $survey->pregnancy_risk === NULL ? 'N/A' : ($survey->pregnancy_risk ==='1' ? 'छ' : 'छैन') }}</p>	
											</div>
											
											<div class="col-6">
												<label for="pregnancy_danger_sign">{{'गर्भावस्थामा हुने खतराको लक्षण के हुन ?' }}</label>
												<p>{{  $survey->pregnancy_danger_sign != NULL ? $survey->pregnancy_danger_sign: 'N/A'}}</p>	
											</div>
											
											<div class="col-6">
												<label for="slug">{{'सुत्केरी अवस्थामा सुत्केरी जाँच गराउनु भयो ?' }}</label><br>
												<p>{{  $survey->maternity_test === NULL ? 'N/A' : ($survey->maternity_test ==='1' ? 'गराए' : 'गराएन') }}</p>	
											</div>
											
											<div class="col-6">
												<label for="maternity_test_count">{{'सुत्केरी जाँच कती पटक गर्नुभयो ?' }}</label>
												<p>{{  $survey->maternity_test_count != NULL ? $survey->maternity_test_count: 'N/A'}}</p>	
											</div>
											
											<div class="col-6">
												<label for="slug">{{'सुत्केरी भएको ४५ दिनभित्र आइरन चक्की खानु भयो?' }}</label><br>
												<p>{{  $survey->maternity_iron_pill === NULL ? 'N/A' : ($survey->maternity_iron_pill ==='1' ? 'खाए' : 'खाएन') }}</p>	
											</div>
											
											<div class="col-6">
												<label for="slug">{{'सुत्केरी अवस्थामा तपाईलाई कुनै समस्या भयो ?' }}</label><br>
												<p>{{  $survey->maternity_issues === NULL ? 'N/A' : ($survey->maternity_issues ==='1' ? 'भयो' : 'भएन') }}</p>	
											</div>
											
										</div>	
									</div>
									
									<div class="col-12 div-header border-bottom-dashed" style="padding-bottom: 15px;">
										<div class="row">
											<h5 class="card-title mb-0">किटजन्य (डेँगु ,मलेरिया)</h5> 
											
											<div class="col-6 form-group listradio">
												<label for="meshed_windows">{{'घरको झ्याल ,ढोकामा जाली लगाएको छ ? ' }}</label><br>
												<p>{{$survey->meshed_windows==1 ? 'छ' : 'छैन'}}</p>
											</div>
											<div class="col-6 form-group listradio">
												<label for="pot_holes">{{'घर बाहिर खाल्डाखुल्डीमा पानी जमेको छ ? ' }}</label>
												<p>{{$survey->pot_holes==1 ? 'छ' : 'छैन'}}</p>
											</div>
											<div class="col-6 form-group listradio">
												<label for="pot_pan_water">{{'गमला ,फुल्दानी ,भाडाकुडामा पानी जमेको छ  ? ' }}</label>
												<p>{{$survey->pot_pan_water==1 ? 'छ' : 'छैन'}}</p>
											</div>
											<div class="col-6 form-group listradio">
												<label for="family_dengue">{{'तपाईको परिवारमा डेँगु ,मलेरियाको समस्या देखिएको थियो ? ' }}</label>
												<p>{{$survey->family_dengue==1 ? 'छ' : 'छैन'}}</p>
											</div>
											<div class="col-6 form-group form-check">
												<label for="dengue_prevention">{{'तपाईको विचारमा डेँगु महामारी नियन्त्रण गर्न के गर्नुपर्ला ?' }}</label>
												<p>{{$survey->dengue_prevention!=NULL ? $survey->dengue_prevention : 'N/A'}}</p>
											</div>
										</div>
									</div>		
								</div>
							</div>  
						</div>
					</div>					
				</div>
			</div>
		</div>					
	</div>
 </div>  

@endsection