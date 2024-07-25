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
						<h4 class="mb-sm-0">{{$pageTitle}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ 'कम्पोस्टबिन निरीक्षण थप्नुहोस्'}}</li>
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
							<h5 class="card-title mb-0">{{ 'कम्पोस्टबिन निरीक्षण थप्नुहोस्' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.sinspection.store') }}" method="POST" enctype="multipart/form-data">
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
															<th>{{ 'कम्पोस्टबिन' }}</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td id="hno"></td>
															<td id="onm"></td>
															<td id="omob"></td>
															<td>{{ 'छ' }}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<form action="{{ route('admin.sinspection.store') }}" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="col-4 form-group form-check">
											<label>{{ 'घर नं.' }}*</label>
											<input type="hidden"  name="user_id" class="form-control" value="{{ \Auth::user()->id }}" >
											<input type="text"  id="houseno" onfocusout="getRoad();" autocomplete="off" name="house_no" class="form-control" value="{{ old('house_no') }}" >										
											<em class="error" style="color:red;display:none;"></em> 
										</div> 
										
										<div class="col-4 form-group form-check">
											<label>{{ 'सडक नाम' }}</label>
											<select id="road" onfocusout="checkTol();" name="road" class="form-control form-select" >
												<option>{{'सडक चयन गर्नुहोस्'}}</option>
												@foreach($address as $data)
												<option value='{{$data->id}}' {{$data->id==old('road') ? 'selected' : ''}}>{{$data->address_np}}</option>
												@endforeach
											</select>
											<em class="error" style="color:red;display:none;"></em> 
										</div>
										
										<div class="col-4 form-group form-check">
											<label for="tol">{{ 'टोल' }}*</label>
											<select id="tol" name="tol" onfocusout="checkOwner();" class="form-control form-select" >
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
										<div class="owner-details">	
											<div class="row">
												<div class="col-6 listradio form-group {{ $errors->has('usage') ? 'has-error' : '' }}">
													<label for="slug">{{ 'कम्पोस्टबिन प्रयोग' }}</label><br>
																
														<label for="usage1" class="radio-inline">
															<input class="form-check-input" type="radio" name="usage" id="usage1" value="0" {{ old('usage') == 0 ? 'checked' : '' }} >
															{{ 'छ' }}
														</label>
														
														<label for="compostbin_usage2" class="radio-inline">
															<input class="form-check-input" type="radio" name="usage" id="usage2" value="1" {{ old('usage') == 1 ? 'checked' : '' }} checked > 
															{{ 'छैन ' }}
														</label>
													@if($errors->has('usage'))
														<div class="invalid-feedback">
															{{ $errors->first('usage') }}
														</div>
													@endif
												</div>
												
												<div class="col-6 listradio form-group {{ $errors->has('roof_farming') ? 'has-error' : '' }}">
													<label for="slug">{{ 'कौसी खेति ' }}</label><br>
																
														<label for="roof_farming" class="radio-inline">
															<input class="form-check-input" type="radio" name="roof_farming" value="0" {{ old('roof_farming') == 0 ? 'checked' : '' }} >
															{{ 'छ' }}
														</label>
														
														<label for="roof_farming" class="radio-inline">
															<input class="form-check-input" type="radio" name="roof_farming" value="1" {{ old('roof_farming') == 1 ? 'checked' : '' }} checked > 
															{{ 'छैन ' }}
														</label>
													@if($errors->has('roof_farming'))
														<div class="invalid-feedback">
															{{ $errors->first('roof_farming') }}
														</div>
													@endif
												</div>
											
												<div class="col-6 listradio form-group hidden {{ $errors->has('fast_decaying_usage') ? 'has-error' : '' }}">
													<label for="slug">{{ 'द्रुत विघटन सामग्री प्रयोग' }}</label><br>
																
														<label for="compostbin_usage1" class="radio-inline">
															<input class="form-check-input" type="radio" name="fast_decaying_usage" id="fast_decaying_usage1" value="0" {{ old('fast_decaying_usage') == 0 ? 'checked' : '' }}>
															{{ 'छ' }}
														</label>
														
														<label for="compostbin_usage2" class="radio-inline">
															<input class="form-check-input" type="radio" name="fast_decaying_usage" id="fast_decaying_usage2" value="1" {{ old('fast_decaying_usage') == 1 ? 'checked' : '' }} checked> 
															{{ 'छैन ' }}
														</label>
													@if($errors->has('fast_decaying_usage'))
														<div class="invalid-feedback">
															{{ $errors->first('fast_decaying_usage') }}
														</div>
													@endif
												</div>
											
												<div class="col-6 listradio form-group hidden {{ $errors->has('production_status') ? 'has-error' : '' }}">
													<label for="slug">{{ 'कम्पोस्ट उत्पादन भएको / नभएको' }}</label><br>
																
														<label for="compostbin_usage1" class="radio-inline">
															<input class="form-check-input" type="radio" name="production_status" id="production_status1" value="0" {{ old('production_status') == 0 ? 'checked' : '' }}>
															{{ 'छ' }}
														</label>
														
														<label for="compostbin_usage2" class="radio-inline">
															<input class="form-check-input" type="radio" name="production_status" id="production_status2" value="1" {{ old('production_status') == 1 ? 'checked' : '' }} checked> 
															{{ 'छैन ' }}
														</label>
													@if($errors->has('fast_decaying_usage'))
														<div class="invalid-feedback">
															{{ $errors->first('fast_decaying_usage') }}
														</div>
													@endif
												</div>

												<div class="col-6 form-group hidden {{ $errors->has('compost_production_interval') ? 'has-error' : '' }}">
													<label for="total_people">{{ 'उत्पादन अन्तराल' }}</label>
													<select id="compost_production_interval" name="compost_production_interval" class="form-control form-select">
														<option value="">उत्पादन अन्तराल चयन गर्नुहोस</option>
														<option value="१ महिना">१ महिना</option>
														<option value="२ महिना">२ महिना</option>
														<option value="३-१२ महिना">३-१२ महिना</option>
													</select>
													@if($errors->has('compost_production_interval'))
														<div class="invalid-feedback">
															{{ $errors->first('compost_production_interval') }}
														</div>
													@endif
												</div>
												
												<div class="col-6 form-group hidden {{ $errors->has('compost_production') ? 'has-error' : '' }}">
													<label for="total_people">{{ 'उत्पादन मात्रा (के. जी.)' }}</label>
													<input type="number" id="slug" name="compost_production" class="form-control" value="{{ old('compost_production') }}">
													@if($errors->has('compost_production'))
														<div class="invalid-feedback">
															{{ $errors->first('compost_production') }}
														</div>
													@endif
												</div>
												
												<div class="col-6 form-group {{ $errors->has('issues') ? 'has-error' : '' }}">
													<label for="total_people">{{ 'समस्याहरू' }}</label>
													<select id="issues" name="issues" class="form-control form-select">
														<option value="">सम्यस्याहरु चयन गर्नुहोस</option>
														<option value="उत्पादन भएन">उत्पादन भएन</option>
														<option value="अत्याधिक दुर्गन्ध">अत्याधिक दुर्गन्ध</option>
														<option value="झिंगा, भुसुना जस्ता किराको कारण">झिंगा, भुसुना जस्ता किराको कारण</option>
														<option value="अन्य">अन्य</option>
													</select>
													@if($errors->has('issues'))
														<div class="invalid-feedback">
															{{ $errors->first('issues') }}
														</div>
													@endif
												</div>
												
												<div class="col-6 form-group {{ $errors->has('remarks') ? 'has-error' : '' }}">
													<label for="total_people">{{ 'टिप्पणीहरू' }}</label>
													<textarea id="remarks" name="remarks" class="form-control">{{ old('remarks') }}</textarea>
													@if($errors->has('remarks'))
														<div class="invalid-feedback">
															{{ $errors->first('remarks') }}
														</div>
													@endif
												</div>
												
												<div class="col-12 text-end">
													<button class="btn btn-success" type="submit" id="uploadButton">
														<i class="ri-save-line"></i> Save
													</button>  
												</div> 
											</div>	
										</div>
									</form>
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
		$("input[name$='usage']").click(function() {
			var val = $(this).val();
			console.log(val);
			if(val=='0'){
				$('.hidden').show();
			}else{
				$('.hidden').hide();
			}
			});	
	});
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
	function checkTol(){
			var house_no = $('#houseno').val();
			var road = $('#road').val();
			if(house_no!=="" && road!==''){
				$.ajax({
						type:'post',
						url:"{{route('checkcompostbin')}}",
						data:{house_no:house_no,road:road},
						dataType: "json",
						success: function(res){
							if(res.exist){ 
								//var withmem = "{{route('withmemberform')}}";
								$('.error').hide();
								$('#tol').val(res.check.tol).prop('selected',true);	
								$('.verifyhouseerror').hide();
								$('.verifiedmsg').text('');
								
							}else{
								//$('#tol').val(res.owner.tol).prop('selected',true);
								$('.verifyhouseerror').show();
								$('.verifiedmsg').text(res.message);
							}
						},error:function(){
							console.log('Unable to currently process datas!!');
							$('.error').hide();		
						}
					});
					//$('.elderly_list').append(elder_list_option);
			}
				
		}
		
	/*getting details if house no exists*/
	function checkOwner(){
			var house_no = $('#houseno').val();
			var road = $('#road').val();
			var tol = $('#tol').val();
			console.log(tol);
			if(house_no!=="" && road!=='' && tol!==''){
				$.ajax({
						type:'post',
						url:"{{route('checkcbinowner')}}",
						data:{house_no:house_no,road:road,tol:tol},
						dataType: "json",
						success: function(res){
							console.log(res);
							if(res.exist){ 
								//var withmem = "{{route('withmemberform')}}";
								$('.error').hide();
								$('.verifyhouseerror').hide();
								$('.verifiedmsg').text('');
								
								$('#hno').text(res.check.house_no);
								$('#onm').text(res.check.owner_np);
								$('#omob').text(res.check.mobile);
								
								$('.owner-details').show();
							}else{
								//$('#tol').val(res.owner.tol).prop('selected',true);
								$('.verifyhouseerror').show();
								$('.verifiedmsg').text(res.message);
							}
						},error:function(){
							console.log('Unable to currently process datas!!');
							$('.error').hide();		
						}
					});
					//$('.elderly_list').append(elder_list_option);
			}
				
		}
	
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