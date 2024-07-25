@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection

@section('styles')
<link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.4.min.css" rel="stylesheet" type="text/css"/>

<style>label{margin-top:15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}
</style>
@endsection
@php
    $fiscal = explode(', ',AppSettings::get('fiscal_year'));
@endphp
@section('content')
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">घर धनी</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{$pageTitle}}</li>
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
							<h5 class="card-title mb-0"> {{ 'व्यवसायिक घर अपडेट गर्नुहोस्' }}</h5>
						</div>

						<div class="card-body">
							<form name="homeowner" action="{{ route('admin.business.update',$business->id) }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('patch')
								<div class="row">
									<div class="col-12">
										<div class="row">
											
											<div class="col-6 form-group form-check {{ $errors->has('house_no') ? 'has-error' : '' }}">
												<label for="name">{{ 'घर नं.' }}*</label>
												<input type="text" onfocusout="getRoad();" id="houseno" name="house_no" class="form-control" value="{{ $business->house_no ? $business->house_no :'' }}" required>
												@if($errors->has('house_no'))
													<em class="invalid-feedback">
														{{ $errors->first('house_no') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('road') ? 'has-error' : '' }}">
												<label for="road">{{ 'सडक नाम' }}</label>
												<select id="road" onfocusout="checkHouseowner();" name="road" class="form-control form-select" required>
													<option value="">{{'सडक चयन गर्नुहोस्'}}</option>
													@foreach($address as $data)
													<option value='{{$data->id}}' {{$business->road==$data->id ? 'selected' : ''}}>{{$data->address_np}}</option>
													@endforeach
												</select>
												@if($errors->has('road'))
													<em class="invalid-feedback">
														{{ $errors->first('road') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('tol') ? 'has-error' : '' }}">
												<label for="tol">{{ 'टोल' }}</label>
												<select id="tol" name="tol" class="form-control form-select" required>
													<option value="">{{'टोल चयन गर्नुहोस्'}}</option>
													@foreach($tol as $data)
													<option value='{{$data->id}}' {{$business->tol==$data->id ? 'selected' : ''}}>{{$data->tol_np}}</option>
													@endforeach
												</select>
												@if($errors->has('tol'))
													<em class="invalid-feedback">
														{{ $errors->first('tol') }}
													</em>
												@endif
											</div> 
											
											<div class="col-6 form-group form-check {{ $errors->has('business_name') ? 'has-error' : '' }}">
												<label for="business_name">{{ 'ब्यापारको नाम' }}</label>
												<input type="text" id="business_name" name="business_name" class="form-control" value="{{ $business->business_name ? $business->business_name :'' }}">
												@if($errors->has('business_name'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_name') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('business_reg_date') ? 'has-error' : '' }}">
												<label for="business_reg_date">{{ 'व्यवसाय दर्ता भएको मिति' }}</label>
												<div class="form-icon right">
												    	<input type="text" id="business_reg_date" name="business_reg_date" class="form-control" value="{{ $business->business_reg_date ? $business->business_reg_date :'' }}">
												    <i class=" ri-calendar-2-line"></i>
												</div>
												@if($errors->has('business_reg_date'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_reg_date') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('business_type') ? 'has-error' : '' }}">
												<label for="business_type">{{'व्यवसायको प्रकार'}}</label>
												{{--<input type="text" id="business_type" name="business_type" class="form-control" value="{{ old('business_type') }}">--}}
												<select id="business_type" name="business_type" class="form-control select2">
												    <option value="">व्यापार प्रकार चयन गर्नुहोस</option>
												    @foreach($businesstype as $data)
												    <option value="{{$data->business_type}}" {{ $business->business_type ==$data->business_type ? 'selected' :'' }}>{{$data->business_type}}</option>
												    @endforeach
												</select>
												@if($errors->has('business_type'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_type') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('contact') ? 'has-error' : '' }}">
												<label for="contact">{{ 'सम्पर्क' }}</label>
												<input type="text" id="contact" name="contact" class="form-control" value="{{ $business->contact ? $business->contact :'' }}" required>
												@if($errors->has('contact'))
													<em class="invalid-feedback">
														{{ $errors->first('contact') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('business_certi_no') ? 'has-error' : '' }}">
												<label for="business_certi_no">{{ 'व्यवसाय प्रमाणपत्र नम्बर' }}</label>
												<input type="text" id="business_certi_no" name="business_certi_no" class="form-control" value="{{ $business->business_certi_no ? $business->business_certi_no :'' }}">
												@if($errors->has('business_certi_no'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_certi_no') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('location_swap_ward') ? 'has-error' : '' }}">
												<label for="location_swap_ward">{{ 'व्यवसाय ठाउँसारी भएको वडा' }}</label>
												<input type="text" id="location_swap_ward" name="location_swap_ward" class="form-control" value="{{ $business->location_swap_ward ? $business->location_swap_ward :'' }}">
												@if($errors->has('location_swap_ward'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('location_swap_ward') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('location_swap_date') ? 'has-error' : '' }}">
												<label for="location_swap_date">{{ 'व्यवसाय ठाउँसारी भएको मिति' }}</label>
												<div class="form-icon right">
												    <input type="text" id="location_swap_date" name="location_swap_date" class="form-control" value="{{ $business->location_swap_date ? $business->location_swap_date :'' }}">
												    <i class=" ri-calendar-2-line"></i>
												</div>
												@if($errors->has('location_swap_date'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('location_swap_date') }}
													</div>
												@endif 
											</div>
											
											<div class="col-6 form-group form-check">
												<label for="last_renewed_year">{{ 'नवीकरण गरिएको पछिल्लो आर्थिक वर्ष' }}</label>
												<select name="last_renewed_year" class="form-control form-select">
												    <option value="">नवीकरण गरिएको पछिल्लो आर्थिक वर्ष</option>
												    @foreach($fiscal as $data)
												    	<option value="{{$data}}" {{ $business->last_renewed_year==$data ? 'selected' :'' }}>{{$data}}</option>
												    @endforeach
												</select>
												@if($errors->has('last_renewed_year'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('last_renewed_year') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check">
												<label for="business_certificate">व्यवसाय प्रमाणपत्र</label>
											    <input name="business_certificate" type="file" class="form-control">
												@if($errors->has('business_certificate'))
													<em class="invalid-feedback">
														{{ $errors->first('business_certificate') }}
													</em>
												@endif
												<input type="hidden" name="mediaid" value="{{$business->id}}">
												@if($business->getFirstMediaUrl())
													<img src="{{($business->getFirstMediaUrl() ? $business->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg'))}}" class="avatar-xl img-thumbnail user-profile-image" alt="{{$business->business_name}}">
												@endif	
											</div>
											
										</div>
									</div>							

									<div class="col-md-12 text-end" style="margin-top:15px;">
										<button class="btn btn-success" type="submit" id="uploadButton">
											<i class="ri-save-line"></i> Update
										</button>  
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
<script src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js" type="text/javascript"></script>
<script>
    var mainInput = document.getElementById("business_reg_date");
    mainInput.nepaliDatePicker({ndpYear: true,ndpMonth: true});
    
    var mainInput1 = document.getElementById("location_swap_date");
    mainInput1.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	  
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

</script>
@endsection