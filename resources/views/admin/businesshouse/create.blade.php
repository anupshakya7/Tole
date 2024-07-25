@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection

@section('styles')
<link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.4.min.css" rel="stylesheet" type="text/css"/>

<!-- Filepond css -->
{{--<link rel="stylesheet" href="{{asset('assets/libs/filepond/filepond.min.css')}}" type="text/css" />
<link rel="stylesheet" href="{{asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">--}}
<style>label{margin-top:15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}.verifyhousesuccess,.verifyhouseerror{margin-top:15px;}.verifyhousesuccess,.verifyhouseerror{display:none;}
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
						<h4 class="mb-sm-0">{{$pageTitle}}</h4>

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
							<h5 class="card-title mb-0"> {{ 'व्यवसायिक घर थप्नुहोस्' }}</h5>
						</div>

						<div class="card-body">
							<form name="homeowner" action="{{ route('admin.business.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-12">
										<div class="row">
										    
										    {{--<div class="col-12" style="margin-bottom:20px;">
												<label for="exampleFormControlInput1">व्यवसाय प्रमाणपत्र</label>
												<p class="text-muted">Only Images are accepted</p>
												<input name="filepond" type="file" class="filepond" data-max-files="1">
											</div>--}}
											
											<div class="col-12 verifyhousesuccess">												
												<div class="text-success text-center">
													<div class="verifiedmsg"></div>
												</div>
											</div>
											<div class="col-12 verifyhouseerror">												
												<div class="text-danger text-center">
													<div class="verifiedmsg"></div>
												</div>
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('house_no') ? 'has-error' : '' }}">
												<label for="name">{{ 'घर नं.' }}*</label>
												<input type="text" onfocusout="getRoad();" id="houseno" name="house_no" class="form-control" value="{{ old('house_no') }}" required>
												@if($errors->has('house_no'))
													<em class="invalid-feedback">
														{{ $errors->first('house_no') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('road') ? 'has-error' : '' }}">
												<label for="road">{{ 'सडक नाम' }}</label>
												<select id="road" onfocusout="checkHouseowner();" name="road" class="form-control form-select" required>
													<option>{{'सडक चयन गर्नुहोस्'}}</option>
													@foreach($address as $data)
													<option value='{{$data->id}}' {{$data->id==old('road') ? 'selected' : ''}}>{{$data->address_np}}</option>
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
												<select id="tol" onfocusout="checkOwner();" name="tol" class="form-control form-select" required>
													<option>{{'टोल चयन गर्नुहोस्'}}</option>
													@foreach($tol as $data)
													<option value='{{$data->id}}' {{$data->id==old('tol') ? 'selected' : ''}}>{{$data->tol_np}}</option>
													@endforeach
												</select>
												@if($errors->has('title'))
													<em class="invalid-feedback">
														{{ $errors->first('tol') }}
													</em>
												@endif
											</div> 
											
											<div class="col-6 form-group form-check {{ $errors->has('business_name') ? 'has-error' : '' }}">
												<label for="business_name">{{ 'व्यवसायको नाम' }}</label>
												<input type="text" id="business_name" name="business_name" class="form-control" value="{{ old('business_name') }}">
												@if($errors->has('business_name'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_name') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('business_reg_date') ? 'has-error' : '' }}">
												<label for="business_reg_date">{{ 'व्यवसाय दर्ता भएको मिति' }}</label>
												<div class="form-icon right">
												    	<input type="text" id="business_reg_date" name="business_reg_date" class="form-control" value="{{ old('business_reg_date') }}">
												    <i class=" ri-calendar-2-line"></i>
												</div>
												@if($errors->has('business_reg_date'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_reg_date') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('contact') ? 'has-error' : '' }}">
												<label for="contact">{{ 'सम्पर्क' }}</label>
												<input type="text" id="contact" name="contact" class="form-control" value="{{ old('contact') }}" required>
												@if($errors->has('contact'))
													<em class="invalid-feedback">
														{{ $errors->first('contact') }}
													</em>
												@endif
											</div>

											<div class="col-6 form-group form-check {{ $errors->has('business_type') ? 'has-error' : '' }}">
												<label for="business_type">{{'व्यवसायको प्रकार'}}</label>
												{{--<input type="text" id="business_type" name="business_type" class="form-control" value="{{ old('business_type') }}">--}}
												<select id="business_type" name="business_type" class="form-control select2">
												    <option value="">व्यापार प्रकार चयन गर्नुहोस</option>
												    @foreach($businesstype as $data)
												    <option value="{{$data->business_type}}">{{$data->business_type}}</option>
												    @endforeach
												</select>
												@if($errors->has('business_type'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_type') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('business_owner') ? 'has-error' : '' }}">
												<label for="business_owner">{{ 'व्यवसायको मालिक' }}</label>
												<input type="text" id="business_owner" name="business_owner" class="form-control" value="{{ old('business_owner') }}">
												@if($errors->has('business_owner'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_owner') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('business_certi_no') ? 'has-error' : '' }}">
												<label for="business_certi_no">{{ 'व्यवसाय प्रमाणपत्र नम्बर' }}</label>
												<input type="text" id="business_certi_no" name="business_certi_no" class="form-control" value="{{ old('business_certi_no') }}">
												@if($errors->has('business_certi_no'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('business_certi_no') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('location_swap_ward') ? 'has-error' : '' }}">
												<label for="location_swap_ward">{{ 'व्यवसाय ठाउँसारी भएको वडा' }}</label>
												<input type="text" id="location_swap_ward" name="location_swap_ward" class="form-control" value="{{ old('location_swap_ward') }}">
												@if($errors->has('location_swap_ward'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('location_swap_ward') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('location_swap_date') ? 'has-error' : '' }}">
												<label for="location_swap_date">{{ 'व्यवसाय ठाउँसारी भएको मिति' }}</label>
												<div class="form-icon right">
												    <input type="text" id="location_swap_date" name="location_swap_date" class="form-control" value="{{ old('location_swap_date') }}">
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
												    <option>नवीकरण गरिएको पछिल्लो आर्थिक वर्ष</option>
												    @foreach($fiscal as $data)
												    	<option value="{{$data}}">{{$data}}</option>
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
											</div>
											
										</div>
									</div>							

									<div class="col-md-12 text-end" style="margin-top:15px;">
										<button class="btn btn-success" type="submit" id="uploadButton">
											<i class="ri-save-line"></i> Save
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
{{--<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>--}}
<script>

    var mainInput = document.getElementById("business_reg_date");
    mainInput.nepaliDatePicker({ndpYear: true,ndpMonth: true});
    
    var mainInput1 = document.getElementById("location_swap_date");
    mainInput1.nepaliDatePicker({ndpYear: true,ndpMonth: true});
    
    //FilePond.registerPlugin(FilePondPluginImagePreview);

    // Turn all file input elements into ponds
   /// FilePond.create(document.querySelector('input[type="file"]'));

    toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif
	  
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
		
		/*getting details if house no exists*/
	function checkOwner(){
			var house_no = $('#houseno').val();
			var road = $('#road').val();
			var tol = $('#tol').val();
			console.log(house_no,road,tol);
		   if(house_no!=="" && road!=='' && tol!=''){
		       $.ajax({
				type:'get',
						url:"{{route('businesshouseowner')}}",
						data:{house_no:house_no,road:road,tol:tol},
						dataType: "json",
						success: function(res){
							var parent = $('.verifyhousesuccess');
							parent.show();
							$('.verifyhouseerror').hide();
							parent.find('.verifiedmsg').text(res.message);
							
						},error:function(){
						    var parent = $('.verifyhouseerror');
							parent.show();	
							$('.verifyhousesuccess').hide();
							parent.find('.verifiedmsg').text(res.message);	
						}
			});
		   }
				
		}

</script>
@endsection