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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
<style>
label{margin-top:15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}
.hidden{display:none;}
.has-error .invalid-feedback{
  display:block;
  font-size:16px;
}
.owner-details{display:none;}
.has-error .form-control{
border: 1px solid red;
}
.verifyhouseerror,.withmember{display:none;}.verifiedmsg{font-weight:bold;}
.center-title {
    padding: 15px;
    text-align: center;
}
@media(max-width:767px){
	.radio-inline{
  font-size:14px;
  font-weight: 600;
}
.error{font-size:10px;line-height:1.2;}
}
.invalid-citizenship{color:red;}
#withoutmember,.elderly_exists,.hidden,.rnot_chosing_ward,.smoking_duration,.missing_vaccine,.last_period_date,.breast_unfed,.breast_fed_duration,.pregnancy_test_times,.family_planning_device,.method_water_purify,.family_planning_permas,.family_planning_temps,.pneumonia_vacciated_counts,.pregnancy_danger_sign,.under_five_child,.why_pregnancytest_notdone,.maternity_test_count,.respiratory_medication_names,.sugar_medication_names,.sugar_medication_whys,.sugar_medication_dosages,.bloodpressure_checked_at,.bloodpressure_symptoms,.bloodpressure_medications,.bloodpressure_medication_names,.bloodpressure_medication_dosages,.bloodpressure_symptoms,.elderly,.respiratory_medications,.additional_food,.excerise_durations,.baby_wt_monitor_time,.one80_iron_pill,.sugar_medications,.full_name,.dob,.gender,.mobile,.blood-grp,.chronic_disease_name,.invalid-citizenship{display:none;}
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
								<li class="breadcrumb-item active">{{ 'Add Medical Survey data'}}</li>
							</ol>
						</div>
					</div>
				</div>
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header border-bottom-dashed">
							<h5 class="card-title mb-0">{{ 'Add Medical Survey data' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.medsurvey.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
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
															<td id="hno"></td>
															<td id="onm"></td>
															<td id="omob"></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-4 form-group form-check">
										<label>{{ 'घर नं.' }}*</label>
										<input type="hidden"  name="user_id" class="form-control" value="{{ \Auth::user()->id }}" >
										<input type="text"  id="houseno" onfocusout="getRoad();" autocomplete="off" name="house_no" class="form-control" value="{{ old('house_no') }}" >										
										<em class="error" style="color:red;display:none;"></em> 
									</div> 
									
									<div class="col-4 form-group form-check">
										<label>{{ 'सडक नाम' }}</label>
										<select id="road" onfocusout="checkHouseowner();" name="road" class="form-control form-select" >
											<option>{{'सडक चयन गर्नुहोस्'}}</option>
											@foreach($address as $data)
											<option value='{{$data->id}}' {{$data->id==old('road') ? 'selected' : ''}}>{{$data->address_np}}</option>
											@endforeach
										</select>
										<em class="error" style="color:red;display:none;"></em> 
									</div>
									
									<div class="col-4 form-group form-check">
										<label for="tol">{{ 'टोल' }}*</label>
										<select id="tol" name="tol" class="form-control form-select" >
											<option>{{'टोल चयन गर्नुहोस्'}}</option>
											@foreach($tol as $data)
											<option value='{{$data->id}}' {{$data->id==old('tol') ? 'selected' : ''}}>{{$data->tol_np}}</option>
											@endforeach
										</select>
										@if($errors->has('tol'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('tol') }}
											</div>
										@endif
									</div>
									<div class="col-12 verifyhouseerror">												
										<div class="text-danger text-center">
											<span class="badge badge-soft-danger" style="padding:10px;margin:8px 0px;">NOT VERIFIED</span>
											<div class="verifiedmsg"></div>
										</div>
									</div>
									<div class="col-12 withmember">									
										<div class="row">
											<div class="col-6">
												<label for="concerned_person">{{'सम्बन्धित व्यक्ति' }}*</label>
												<input id="concerned_person" name="concerned_person" type="text" class="form-control" />
												@if($errors->has('concerned_person'))
													<div class="invalid-concerned_person" style="display:block;">
														{{ $errors->first('concerned_person') }}
													</div>
												@endif	
											</div>
											<div class="col-6">
												<label for="concerned_contact">{{'सम्बन्धित व्यक्तिको मोबाइल' }}*</label>
												<input id="concerned_contact" name="concerned_contact" type="text" class="form-control" />
												@if($errors->has('concerned_contact'))
													<div class="invalid-concerned_contact" style="display:block;">
														{{ $errors->first('concerned_contact') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 listradio form-group {{ $errors->has('ownership') ? 'has-error' : '' }}">
												<label for="slug">{{ 'घर स्वामित्व' }}</label><br>
															
													<label for="ownership1" class="radio-inline">
														<input class="form-check-input" type="radio" name="ownership" value="1" {{ old('ownership') == 1 ? 'checked' : '' }} required>
														{{ 'आफ्नै' }}
													</label>
													
													<label for="ownership2" class="radio-inline">
														<input class="form-check-input" type="radio" name="ownership" value="2" {{ old('ownership') == 2 ? 'checked' : '' }}> 
														{{ 'भाडामा ' }}
													</label>
													<label for="ownership2" class="radio-inline">
														<input class="form-check-input" type="radio" name="ownership" value="3" {{ old('ownership') == 2 ? 'checked' : '' }}> 
														{{ 'ब्यापार ' }}
													</label>
													@if($errors->has('ownership'))
														<div class="invalid-feedback">
															{{ $errors->first('ownership') }}
														</div>
													@endif
											</div>
											
											<div class="col-6 form-group form-check hidden">
												<label for="year_rented">{{' कुपोण्डोलमा भाडामा बसेको कति भयो ?' }}</label>
												<select id="year_rented" name="year_rented" class="form-control form-select">
													<option value="">{{'चयन गर्नुहोस्'}}</option>				
													<option value='१ वर्ष भन्दा कम '>१ वर्ष भन्दा कम </option>
													<option value="१ देखि २ वर्ष">१ देखि २ वर्ष</option>
													<option value="२ देखि ५ वर्ष">२ देखि ५ वर्ष</option>
													<option value="५ वर्ष भन्दा बढी">५ वर्ष भन्दा बढी</option>
												</select>
												@if($errors->has('year_rented'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first(year_rented) }}
													</div>
												@endif
											</div>
				
											<div class="col-6 listradio form-group under_five_childs{{ $errors->has('under_five_child') ? 'has-error' : '' }}">
												<label for="slug">{{ 'घरमा ५ वर्ष मूनिका बच्चा छ?' }}</label><br>
															
													<label for="under_five_child1" class="radio-inline">
														<input class="form-check-input" type="radio" name="under_five_child" id="under_five_child1" value="1" {{ old('under_five_child') == 1 ? 'checked' : '' }}  required>
														{{ 'छ' }}
													</label>
													
													<label for="under_five_child2" class="radio-inline">
														<input class="form-check-input" type="radio" name="under_five_child" id="under_five_child2" value="2" {{ old('under_five_child') == 2 ? 'checked' : '' }}> 
														{{ 'छैन ' }}
													</label>
												@if($errors->has('under_five_child'))
													<div class="invalid-feedback">
														{{ $errors->first('under_five_child') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 listradio form-group elderly_exists{{ $errors->has('elderly_exist') ? 'has-error' : '' }}">
												<label for="slug">{{ 'घरमा जेष्ठ नागरिक छ?' }}</label><br>
															
													<label for="elderly_exist1" class="radio-inline">
														<input class="form-check-input" type="radio" name="elderly_exist" id="elderly_exist1" value="1" {{ old('elderly_exist') == 1 ? 'checked' : '' }}>
														{{ 'छ' }}
													</label>
													
													<label for="elderly_exist2" class="radio-inline">
														<input class="form-check-input" type="radio" name="elderly_exist" id="elderly_exist2" value="2" {{ old('elderly_exist') == 2 ? 'checked' : '' }}> 
														{{ 'छैन ' }}
													</label>
												@if($errors->has('elderly_exist'))
													<div class="invalid-feedback">
														{{ $errors->first('elderly_exist') }}
													</div>
												@endif
											</div>										
										</div>
									</div>
									<div id="withoutmember">
										@include('admin.medsurvey.partials.survey')
									</div>
								</div>                            
							</form>
						</div>
					</div>					
				</div>
			</div>
		</div>					
	</div>
 </div>  

@endsection
@section('scripts')
<script src="https://unpkg.com/nepalify@0.5.0/umd/nepalify.production.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('js/cloneData.js')}}"></script>	
<script>

 $( document ).ready(function() {
		$('.js-example-basic-multiple').select2();
		
		$("input[name$='baby_wt_monitor']").click(function() {
			var val = $(this).val();
			if(val=='1'){
				$('.baby_wt_monitor_time').show();
			}else{
				$('.baby_wt_monitor_time').hide();
			}
		});
		
		$("input[name$='pregnant_exists']").click(function() {
			var val = $(this).val();
			if(val=='1'){
				$('.last_period_date').show();
			}else{
				$('.last_period_date').hide();
			}
		});
		
		$("input[name$='chronic_disease']").click(function() {
			var val = $(this).val();
			if(val=='1'){
				$('.chronic_disease_name').show();
			}else{
				$('.chronic_disease_name').hide(); 
			}
		});
		
		$("input[name$='iron_pill_intake']").click(function() {
			var val = $(this).val();
			if(val=='1'){
				$('.180_iron_pill').show();
			}else{
				$('.180_iron_pill').hide();
			}
		});
		
		$("input[name$='ownership']").click(function() {
			var val = $(this).val();
			if(val=='2'){
				$('.hidden').show();
				$('.elderly_exists').show();
				$('.under_five_childs').show();
				$('.chronic_disease').show();
				$('.elderly_exists').hide();
				$('.mtreatment_at').show();
				$('.medical_insured').show();
				$('.body_mass_index').show();
				$('.family-planning').show();
				$('.dengue_malaria').show();
				$('.elderly').hide();
			}else if(val=='3'){
				$('.hidden').hide();
				$('.elderly_exists').hide();
				$('.under_five_childs').hide();
				$('.chronic_disease').hide();
				$('.mtreatment_at').hide();
				$('.medical_insured').hide();
				$('.body_mass_index').hide();
				$('.family-planning').hide();
				$('.dengue_malaria').hide();
			}else{
				$('.hidden').hide();
				$('.elderly_exists').show();
				$('.under_five_childs').show();
				$('.chronic_disease').show();
				$('.mtreatment_at').show();
				$('.medical_insured').show();
				$('.body_mass_index').show();
				$('.family-planning').show();
				$('.dengue_malaria').show();
				$('.elderly').show();
			}
		});
		
		$("input[name$='medical_insured']").click(function() {
			var val = $(this).val();
			if(val=='1'){
				$('.smoking_duration').show();
			}else{
				$('.smoking_duration').hide();
			}
		});
		
		$("input[name$='under_five_child']").click(function() {
			var val = $(this).val();
			if(val=='1'){
				$('.under_five_child').show();
			}else{
				$('.under_five_child').hide();
			}
		});
		
		$("input[name$='elderly_exist']").click(function() {
			var val = $(this).val();
			if(val=='1'){
				$('.elderly').show();
			}else{
				$('.elderly').hide();
			}
		});
			
		$("#mtreatment_at").change(function() {
			var val = $(this).val();
			if(val!=='आधारभूत स्वास्थ्य केन्द्र'){
				$('.rnot_chosing_ward').show();
			}else{
				$('.rnot_chosing_ward').hide();
			}		
		});
		
		$("#full_child_vaccinate").change(function() {
			var val = $(this).val();
			if(val=='खोप छुटेको'){
				$('.missing_vaccine').show();
			}else{
				$('.missing_vaccine').hide();
			}		
		});
		
		$("input[name$='mum_breast_fed']").click(function() { 
			var val = $(this).val();
			if(val=='2'){
				$('.breast_unfed').show();
				$('.breast_fed_duration').hide();     
				$('.additional_food').hide();
			}else{
				$('.breast_fed_duration').show();
				$('.additional_food').show();
				$('.breast_unfed').hide();
			}
		});
		
		$("input[name$='pregnancy_test']").click(function() { 
			var val = $(this).val();
			if(val=='1'){
				$('.pregnancy_test_times').show(); 
				$('.why_pregnancytest_notdone').hide(); 
			}else{
				$('.why_pregnancytest_notdone').show();
				$('.pregnancy_test_times').hide();
			}
		});
		
		$("input[name$='family_planning_device']").click(function() { 
			var val = $(this).val();
			if(val=='1'){
				$('.family_planning_permas').show(); 
				$('.family_planning_temps').hide(); 
			}else{
				$('.family_planning_temps').show();
				$('.family_planning_permas').hide();
			}
		});
		
		$("input[name$='pregnancy_risk']").click(function() { 
			var val = $(this).val();
			if(val=='1'){
				$('.pregnancy_danger_sign').show(); 
			}else{
				$('.pregnancy_danger_sign').hide();
			}
		});
		
		$("input[name$='maternity_test']").click(function() { 
			var val = $(this).val();
			if(val=='1'){
				$('.maternity_test_count').show(); 
			}else{
				$('.maternity_test_count').hide();
			}
		});
		
		/*senior citizen scrip*/
		
		$("div").on('click','input.pneumonia_vaccinated',function() { 
			var val = $(this).val();
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.pneumonia_vacciated_counts').show(); 
			}else{
				$(this).parents('.employee-info-wrap').find('.pneumonia_vacciated_counts').hide();
			}
		});
		
		$("div").on('click','input.respiratory_disease',function() { 
			var val = $(this).val();
			console.log(val);
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.respiratory_medications').show(); 
			}else{
				$(this).parents('.employee-info-wrap').find('.respiratory_medications').hide();
			}
		});
		
		$("div").on('click','input.respiratory_medication',function() { 
			var val = $(this).val();
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.respiratory_medication_names').show(); 
			}else{
				$(this).parents('.employee-info-wrap').find('.respiratory_medication_names').hide();
			}
		});

		$("div").on('click','input.regular_excercise',function() { 
			var val = $(this).val();
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.excerise_durations').show(); 
			}else{
				$(this).parents('.employee-info-wrap').find('.excerise_durations').hide();
			}
		});
		
		$("div").on('click','input.sugar_level_stat',function() { 
			var val = $(this).val();
			if(val=='2'){
				$(this).parents('.employee-info-wrap').find('.sugar_medications').show();
			}else{
				$(this).parents('.employee-info-wrap').find('.sugar_medications').hide();
			}
		});
		
		$("div").on('click','input.sugar_medication',function() { 
			var val = $(this).val();
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.sugar_medication_names').show();
				$(this).parents('.employee-info-wrap').find('.sugar_medication_dosages').show();
				$(this).parents('.employee-info-wrap').find('.sugar_medication_whys').hide();	
			}else{
				$(this).parents('.employee-info-wrap').find('.sugar_medication_names').hide();
				$(this).parents('.employee-info-wrap').find('.sugar_medication_dosages').hide();
				$(this).parents('.employee-info-wrap').find('.sugar_medication_whys').show();
			}
		});
		
		$("div").on('click','input.bloodpressure_check_6',function() { 
			var val = $(this).val();
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.bloodpressure_checked_at').show();
			}else{
				$(this).parents('.employee-info-wrap').find('.bloodpressure_checked_at').hide();
			}
		});
		
		$("div").on('click','input.bloodpressure_level_stat',function() { 
			var val = $(this).val();
			if(val=='2'){
				$(this).parents('.employee-info-wrap').find('.bloodpressure_symptoms').show();
			}else{
				$(this).parents('.employee-info-wrap').find('.bloodpressure_symptoms').hide();
			}
		});
		
		$("div").on('click','input.bloodpressure_symptom',function() { 
			var val = $(this).val();
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.bloodpressure_medications').show();
			}else{
				$(this).parents('.employee-info-wrap').find('.bloodpressure_medications').hide();
			}
		});
		
		$("div").on('click','input.bloodpressure_medication',function() { 
			var val = $(this).val();
			if(val=='1'){
				$(this).parents('.employee-info-wrap').find('.bloodpressure_medication_names').show();
				$(this).parents('.employee-info-wrap').find('.bloodpressure_medication_dosages').show();
			}else{
				$(this).parents('.employee-info-wrap').find('.bloodpressure_medication_names').hide();
				$(this).parents('.employee-info-wrap').find('.bloodpressure_medication_dosages').hide();
			}
		});
	
		/*senior citizen script ends*/
		$("input[name$='family_planning_done']").click(function() { 
			var val = $(this).val();
			if(val=='1'){
				$('.family_planning_device').show(); 
			}else{
				$('.family_planning_device').hide();
			}
		});
		
		$("input[name$='drinking_water_purify']").click(function() { 
			var val = $(this).val();
			if(val=='1'){
				$('.method_water_purify').show(); 
			}else{
				$('.method_water_purify').hide();
			}
		});		
		
 });
 var elder_list_option='';

 $('#add-more').cloneData({
	  //container to hold the duplicated form fields
	  mainContainerId:'clone-container',
	  //class to be cloned
	  cloneContainer:'clone-item',
	  // CSS class of remove button
	  removeButtonClass:'remove-item',
	  removeConfirm: true, // default true confirm before delete clone item
      removeConfirmMessage: 'Are you sure want to delete?', // confirm delete message
	  minLimit: 1, // Default 1 set minimum clone HTML required
      maxLimit: 5, // Default unlimited or set maximum limit of clone HTML
 	 afterRender:function() {
		  addElderlyOption();
	  },

    });
	
	/*global variabl*/

/*for checking the citizenship exists*/
function addCitizenship(cur_val){
	var elder_val=cur_val.val();
		console.log(elder_val);
		cur_val.parents('.employee-info-wrap').find('.elder_citizenship').val(elder_val);
		$( ".elder_citizenship" ).trigger( "change" );
	
}

/*for checking elderly citizenship */
// $('.elder_citizenship').on('change',function(){
// 	console.log('citizenship change');
// 	checkMember($(this));
// });
	/*getting roads according to house_no*/
	function getRoad(){
		var houseno = $('#houseno').val();
		//var url = "{{route('homeroads')}}?id="+houseno;
		if(houseno!=''){
			$.ajax({
				type:'get',
				url:"{{route('homeroads')}}?id="+houseno,
				success: function(res){
					//console.log(url);
					if(res.error){
						$.each(res.address,function(i,val){
							$('#road').append('<option value="'+val.id+'">'+val.address_np+'</option>');
						})
					}else{	
						
						$('#road').html(res);
					}
					
				},error:function(){
					console.log('Unable to currently process data!!');
				}
			});
		}
	}
	
	/*getting details if house no exists*/
	function checkHouseowner(){
			var house_no = $('#houseno').val();
			var road = $('#road').val();
			console.log(house_no);
			if(house_no!=="" && road!==''){
				$.ajax({
						type:'post',
						url:"{{route('houseCheck')}}",
						data:{house_no:house_no,road:road,elder:true},
						dataType: "json",
						success: function(res){
							if(res.exist){ 
								//console.log(res.exist);
								var medview = "{{route('medsurvey')}}";
								//var withmem = "{{route('withmemberform')}}";
								$('.error').hide();
								$('#tol').val(res.owner.tol).prop('selected',true);	
								$('.verifyhouseerror').hide();
								$('.verifiedmsg').text('');
								$('.withmember').show();
								$('#withoutmember').show();
								
								$('.owner-details').show();
								$('#hno').text(res.owner.house_no);
								$('#onm').text(res.owner.owner_np);
								$('#omob').text(res.owner.mobile);
								elder_list_option=res.elder;
								addElderlyOption();

								
							}else{
								//$('#tol').val(res.owner.tol).prop('selected',true);
								$('.verifyhouseerror').show();
								$('.verifiedmsg').text(res.message);
								$('#withoutmember').hide(); 
								//$('#withmember').html(withmem);		
							}
						},error:function(){
							console.log('Unable to currently process datas!!');
							$('.error').hide();		
						}
					});
					//$('.elderly_list').append(elder_list_option);
			}
				
		}
		/*For adding elderly citizen option dynamically*/
		function addElderlyOption(){
			
			$.each( elder_list_option, function( key, value ) {
			  //elder_list_option+='<option value="'+value.citizenship+'">'+value.full_name+'</option>';
			  $('.elderly_list').append($('<option>', { 
				  value: value.citizenship,
				  text : value.full_name 
			  }));
			 // alert( key + ": " + value );
			});
		}
	/*check if member exists according to citizenship number*/
	function checkMember(cur_citizen){
			var citizenship = cur_citizen.val();			
			console.log(citizenship);
			if(citizenship!==""){
				$.ajax({
						headers: {
						  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						 },	
						type:'post',
						url:"{{route('admin.member.checkmembers')}}",
						data:{citizenship:citizenship},
						dataType: "json",
						
						success: function(res){
							console.log(res);
							if(res.error){ 
								cur_citizen.parents('.employee-info-wrap').find('.full_name').show();
								cur_citizen.parents('.employee-info-wrap').find('.dob').show();
								cur_citizen.parents('.employee-info-wrap').find('.gender').show();
								cur_citizen.parents('.employee-info-wrap').find('.mobile').show();
								cur_citizen.parents('.employee-info-wrap').find('.blood-grp').show();
								cur_citizen.parents('.employee-info-wrap').find('.invalid-citizenship').hide();
							}else{
								cur_citizen.parents('.employee-info-wrap').find('.full_name').hide();
								cur_citizen.parents('.employee-info-wrap').find('.dob').hide();
								cur_citizen.parents('.employee-info-wrap').find('.gender').hide();
								cur_citizen.parents('.employee-info-wrap').find('.mobile').hide();
								cur_citizen.parents('.employee-info-wrap').find('.blood-grp').hide();
								cur_citizen.parents('.employee-info-wrap').find('.invalid-citizenship').show().text('Member with citizen no. '+citizenship+' name . '+res.name+' already exist on our system!');
							}
						},error:function(){
							console.log('Unable to currently process datas!!');
							cur_citizen.parents('.employee-info-wrap').find('.error').hide();		
							cur_citizen.parents('.employee-info-wrap').find('.invalid-citizenship').hide()
						}
					});
			}
				
		}
	
	
    $( document ).ready(function() {
        });
    
		toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif
	  
	   @if(Session::has("error"))
        toastr.error("{{session('message')}}")
      @endif

</script>
@endsection