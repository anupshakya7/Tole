@php
   if(auth()->user()->hasRole('members_house')) {
      $layoutDirectory = 'layouts.membershouse-web';
   } else {
      $layoutDirectory = 'layouts.admin-web';
   }
@endphp

@extends($layoutDirectory)
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link rel="stylesheet" href="{{asset('css/nepali.datepicker.v4.0.min.css')}}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
<style>
label{margin-top:15px;}.nextgeneral{display:none;}.verifyhousesuccess,.verifyhouseerror{margin-top:15px;}.verifyhousesuccess,.verifyhouseerror{display:none;}
</style>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
		<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">सदस्य</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ 'नाबालक बच्चाको डाटा थप्नुहोस्'}}</li>
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
			<div class="row">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title mb-0">{{'नाबालक बच्चाको डाटा थप्नुहोस्'}}</h4>
						</div><!-- end card header -->
						<div class="card-body">
							<form id="memberform" action="{{route('admin.member.store')}}" class="form-steps" autocomplete="off" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="text-center pt-3 pb-4 mb-1">
									<img src="{{asset('img/np-logo.png')}}" alt="" height="80">
								</div>
								<div class="step-arrow-nav mb-4">

									<ul class="nav nav-pills custom-nav nav-justified" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link active" id="steparrow-verify-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-verify-info" type="button" role="tab" aria-controls="steparrow-verify-info" aria-selected="true">Verify</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-gen-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-gen-info" type="button" role="tab" aria-controls="steparrow-gen-info" aria-selected="true">General</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-family-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-family-info" type="button" role="tab" aria-controls="steparrow-family-info" aria-selected="false">Family</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-contact-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-contact-info" type="button" role="tab" aria-controls="steparrow-contact-info" aria-selected="false">Contact</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-education-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-education-info" type="button" role="tab" aria-controls="steparrow-education-info" aria-selected="false">Education</button>
										</li>
									</ul>
								</div>

								<div class="tab-content">
									<div class="tab-pane fade show active" id="steparrow-verify-info" role="tabpanel" aria-labelledby="steparrow-verify-info-tab">
										<div class="row">
											<div class="col-6">
												<label for="contact" class="form-label"> {{ 'घर नम्बर' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<input type="text" id="house_no" onfocusout="getRoad();" value="{{old('house_no')}}" name="house_no" class="form-control form-control-icon" value="{{ old('house_no') }}">
													<i class=" ri-home-8-line"></i>
												</div>
												@if($errors->has('house_no'))
													<em class="invalid-feedback">
														{{ $errors->first('house_no') }}
													</em>
												@endif
												<em class="errorajax" style="display:hidden;"></em>
											</div>
											
											<div class="col-6">
											<label for="road">{{ 'सडक नाम' }} <span style="color: red">*</span></label>
											<select id="road" onfocusout="checkMember();" name="road" class="form-select" required>
												<option>{{'सडक चयन गर्नुहोस्'}}</option>
												@foreach($address as $data)
												<option value='{{$data->id}}' {{$data->id==old('road') ? 'selected' : ''}}>{{$data->address_np}}</option>
												@endforeach
											</select>
											<em class="error" style="color:red;display:none;"></em> 
											</div>
											
											<div class="col-6">
												<label for="tol">{{ 'टोल' }} <span style="color: red">*</span></label>
												<select id="tol" name="tol" class="form-select" required>
													<option value="">{{'टोल चयन गर्नुहोस्'}}</option>
													@foreach($tol as $data)
													<option value='{{$data->id}}' {{$data->id==old('tol') ? 'selected' : ''}}>{{$data->tol_np}}</option>
													@endforeach
												</select>
												@if($errors->has('tol'))
													<em class="invalid-feedback">
														{{ $errors->first('tol') }}
													</em>
												@endif
											</div>
											<div class="col-12 verifyhousesuccess">												
												<div class="text-success text-center">
													<span class="badge badge-soft-success" style="padding:10px;margin:8px 0px;">VERIFIED</span>
													<div class="verifiedmsg"></div>
												</div>
											</div>
											<div class="col-12 verifyhouseerror">												
												<div class="text-danger text-center">
													<span class="badge badge-soft-danger" style="padding:10px;margin:8px 0px;">NOT VERIFIED</span>
													<div class="verifiedmsg"></div>
												</div>
											</div>
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab nextgeneral" data-nexttab="steparrow-gen-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to General</button>
										</div>
									</div>
									<div class="tab-pane" id="steparrow-gen-info" role="tabpanel" aria-labelledby="steparrow-gen-info-tab">
										<div>
											<div class="text-center">
												<div class="profile-user position-relative d-inline-block mx-auto mb-2">
													<img src="{{asset('assets/images/users/user-dummy-img.jpg')}}" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
													<div class="avatar-xs p-0 rounded-circle profile-photo-edit">
														<input id="profile-img-file-input" type="file" name="image" class="profile-img-file-input" accept="image/png, image/jpeg">
														<label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
															<span class="avatar-title rounded-circle bg-light text-body">
																<i class="ri-camera-fill"></i>
															</span>
														</label>
													</div>
												</div>
												<h5 class="fs-14">{{'फोटो थप्नुहोस्'}} <span style="color: red">*</span></h5> 

											</div>
											
											<div class="row" style="margin-top:15px;">
												<div class="col-6">
													<label class="form-label" for="full_name">{{'Full Name'}} <span class="fi fi-us fis"></span> <span style="color: red">*</span></label>
													<input type="text" class="form-control" name="full_name" value="{{old('full_name')}}" />
												</div>
												<div class="col-6">
													<label class="form-label" for="full_name">{{'पुरा नाम'}}  <span class="fi fi-np fis"></span></label>
													<input type="text" class="form-control" name="fullname_np" value="{{old('fullname_np')}}" />
												</div>
												
												<div class="col-6">
													<label class="form-label" for="full_name">{{'जन्म मिति'}} (BS) <span style="color: red">*</span></label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" id="nepali-datepicker" value="{{old('dob_bs')}}" name="dob_bs" />
														<i class="bx bx-calendar"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="gender">{{ 'लिङ्ग' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="gender" class="form-select form-control-icon">
															<option value="9">{{"लिङ्ग चयन गर्नुहोस्"}}</option>
															<option value="1" {{old("gender")==1 ? "selected" : ""}}>{{"पुरुष"}}</option>
															<option value="2" {{old("gender")==2 ? "selected" : ""}}>{{"महिला"}}</option>
															<option value="3" {{old("gender")==3 ? "selected" : ""}}>{{"अन्य"}}</option>
														</select>
														<i class="bx bx-male-female"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="birth_registration">{{'जन्म दर्ता नं'}}  </label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" value="{{old('birth_registration')}}" name="birth_registration" />
														<i class="ri-contacts-book-2-line"></i>
													</div>
												</div>										
												<div class="col-6">
													<label class="form-label" for="blood_grp">{{ 'रक्त समूह' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="blood_grp" class="form-select form-control-icon">
															<option value="">{{"रक्त समूह चयन गर्नुहोस्"}}</option>
															<option value="A+" {{old('blood_grp')=='A+' ? 'selected' : ''}}>A+</option>
															<option value="A-" {{old('blood_grp')=='A-' ? 'selected' : ''}}>A-</option>
															<option value="B+" {{old('blood_grp')=='B+' ? 'selected' : ''}}>B+</option>
															<option value="B-" {{old('blood_grp')=='B-' ? 'selected' : ''}}>B-</option>
															<option value="O+" {{old('blood_grp')=='O+' ? 'selected' : ''}}>O+</option>
															<option value="O-" {{old('blood_grp')=='O-' ? 'selected' : ''}}>O-</option>
															<option value="AB+" {{old('blood_grp')=='AB+' ? 'selected' : ''}}>AB+</option>
															<option value="AB-" {{old('blood_grp')=='AB-' ? 'selected' : ''}}>AB-</option>
															<option value="Unknown" {{old('blood_grp')=='Unknown' ? 'selected' : ''}}>Unknown</option>
														</select>
														<i class="ri-contrast-drop-2-line"></i>
													</div>
												</div>
												
											</div>
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-verify-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Verify</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-family-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Family</button>
										</div>
									</div>
									<!-- end tab pane -->
									<div class="tab-pane fade" id="steparrow-family-info" role="tabpanel" aria-labelledby="steparrow-family-info-tab">
										<div class="row">
										
											<div class="col-4">
												<label for="father_citizen" class="form-label"> {{ 'बुबाको नागरिकता नम्बर' }} <span style="color: red">*</span></label>
												<input type="text" onfocusout="checkFamily();" id="mfathercitizen" name="father_citizen" class="form-control" value="{{ old('father_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="father_name" class="form-label"> {{ 'Father Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mfathername" name="father_name" class="form-control" value="{{ old('father_name') }}">
											</div>
											
											<div class="col-4">
												<label for="father_name" class="form-label"> {{ 'बुबाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mfathernp" name="father_np" class="form-control" value="{{ old('father_np') }}">
											</div>
											
											<div class="col-4">
												<label for="grandfather_name" class="form-label"> {{ 'Grandfather Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mgfathernp" name="grandfather_np" class="form-control" value="{{ old('grandfather_np') }}">
											</div>
											
											<div class="col-4">
												<label for="grandfather_name" class="form-label"> {{ 'हजुरबुबाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mgfathername" name="grandfather_name" class="form-control" value="{{ old('grandfather_name') }}">
											</div>
											
											<div class="col-4">
												<label for="grandfather_citizen" class="form-label"> {{ 'हजुरबुबाको नागरिकता नम्बर' }}</label>
												<input type="text" id="mgfathercitizen" name="grandfather_citizen" class="form-control" value="{{ old('grandfather_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="grandmother_name" class="form-label"> {{ 'Grandmother Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mgmothernp" name="grandmother_np" class="form-control" value="{{ old('grandmother_np') }}">
											</div>
											
											<div class="col-4">
												<label for="grandmother_name" class="form-label"> {{ 'हजुरआमाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mgmothername" name="grandmother_name" class="form-control" value="{{ old('grandmother_name') }}">
											</div>
											
											<div class="col-4">
												<label for="grandmother_citizen" class="form-label"> {{ 'हजुरआमाको नागरिकता नम्बर' }}</label>
												<input type="text" id="mgmothercitizen" name="grandmother_citizen" class="form-control" value="{{ old('grandmother_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="mother_name" class="form-label"> {{ 'Mother Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mmothername" name="mother_name" class="form-control" value="{{ old('mother_name') }}">
											</div>
											
											<div class="col-4">
												<label for="mother_np" class="form-label"> {{ 'आमाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mmothernp" name="mother_np" class="form-control" value="{{ old('mother_np') }}">
											</div>
											
											<div class="col-4">
												<label for="mother_citizen" class="form-label"> {{ 'आमाको नागरिकता नम्बर' }} <span style="color: red">*</span></label>
												<input type="text" id="mmothercitizen" name="mother_citizen" class="form-control" value="{{ old('mother_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="spouse_name" class="form-label"> {{ 'Spouse Name' }}</label>
												<input type="text" name="spouse_name" class="form-control" value="{{ old('spouse_name') }}">
											</div>
											
											<div class="col-4">
												<label for="spouse_np" class="form-label"> {{ 'पति/पत्नीको नाम' }}</label>
												<input type="text" name="spouse_np" class="form-control" value="{{ old('spouse_np') }}">
											</div>
											
											<div class="col-4">
												<label for="spouse_citizen" class="form-label"> {{ 'पति/पत्नीको नागरिकता नम्बर' }} </label>
												<input type="text" name="spouse_citizen" class="form-control" value="{{ old('spouse_citizen') }}">
											</div>
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to General</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-contact-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Contact</button>
										</div>
									</div>		

									<div class="tab-pane fade" id="steparrow-contact-info" role="tabpanel" aria-labelledby="steparrow-contact-info-tab">
										<div class="row">
											
											<div class="col-6">
												<label for="contact" class="form-label"> {{ 'सम्पर्क नम्बर' }} </label>
												<div class="form-icon">
													<input type="text" name="contact_no" maxlength="10" class="form-control form-control-icon" value="{{ old('contact_no') }}">
													<i class="ri-phone-line"></i>
												</div>
											</div>
											
											<div class="col-6">
												<label for="mobile" class="form-label"> {{ 'मोबाइल' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<input type="text" name="mobile_no" maxlength="10" class="form-control form-control-icon" value="{{ old('mobile_no') }}">
													<i class="ri-cellphone-fill"></i>
												</div>
											</div>
											
											<div class="col-6">
												<!-- Input with Icon -->
												
												<label for="email" class="form-label"> {{ 'इमेल' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<input type="email" name="email" class="form-control form-control-icon" value="{{ old('email') }}">
													<i class="ri-mail-unread-line"></i>
												</div>
												
											</div>
											
											<div class="col-6">
												<label class="form-label" for="temporary_address">{{'अस्थायी ठेगाना'}}</label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" value="{{old('temporary_address')}}" name="temporary_address"  />
													<i class=" bx bx-home-circle"></i>
												</div>
											</div>
									
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-family-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Family</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-medical-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Medical</button>
										</div>
									</div>
									<!-- end tab pane -->
									<div class="tab-pane fade" id="steparrow-medical-info" role="tabpanel" aria-labelledby="steparrow-medical-info-tab">
										<div class="row">
											@php
												$group = \App\Medicalconditions::groupBy('type')->get();
											@endphp	
											@foreach($group as $grp)		
												<div class="col-12">																		
													<div class="mt-4 mb-3 border-bottom pb-2">
														<h5 class="card-title">{{$grp->type}}</h5>		
													</div>
													@if($grp->type=="अपाङ्गता")
														<div class="form-group col-12" style="margin-bottom:20px;">
															<label for="exampleFormControlInput1">Disability Certificate </label>
															<input name="disability_certificate" type="file" class="form-control">
														</div>
													@endif	
													@php
														$medcondition = \App\Medicalconditions::where('type',$grp->type)->get();
													@endphp
													<div class="col-12">
														<select class="form-select form-control" name="medical_problem[]">
															<option value="NULL">सेलेक्ट गर्नुहोस</option>
															@foreach($medcondition as $cond)
															<option value="0">{{$cond->title}}</option>
															@endforeach
														</select>
													</div>													
												</div>
											@endforeach
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-education-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Education</button>
											<button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
										</div>    
									</div>
								</div>
								<!-- end tab content -->
							</form>
						</div>
						<!-- end card body -->
					</div>
					<!-- end card -->
				</div>
				<!-- end col -->
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('js/nepali.datepicker.v4.0.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-wizard.init.js')}}"></script>
<script src="{{asset('js/cloneData.js')}}"></script>
<script>
	 var mainInput = document.getElementById("nepali-datepicker");
     mainInput.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	
	$('#passed_year').datetimepicker({
		format      :   "YYYY",
		viewMode    :   "years", 
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
      maxLimit: 15, // Default unlimited or set maximum limit of clone HTML
    });
	  
	  /*getting roads according to house_no*/
	function getRoad(){
		var houseno = $('#house_no').val();
		if(houseno !=''){
			$.ajax({
				type:'get',
				url:"{{route('homeroads')}}?id="+houseno+"&type=member",
				success: function(res){	
					if(res.error){
						//console.log(res);
						$('.error').show();
						$('#road').empty();
						$.each(res.address,function(i,val){
							$('#road').append('<option value="'+val.id+'">'+val.address_np+'</option>');
						})
						
					}else{	
						$('.error').hide();	
						
						$('#road').html(res);						
						//$('.ownerdetails').hide();				
						
					}
					
				},error:function(){
					console.log('Unable to currently process data!!');
				}
			});
		}
	}
	
	/*getting family member details according father's citizenship*/
	function checkFamily(){
		var fcitizen = $('#mfathercitizen').val();
		console.log(fcitizen);
		if(fcitizen !=''){
			$.ajax({
				type:'get',
				url:"{{route('checkfamily')}}?fcitizen="+fcitizen,
				success: function(res){	
					//console.log(res);
					//console.log(res.family[0].full_name);
					if(res.success){
						$('#mfathername').val(res.family[0].full_name);
						$('#mgfathername').val(res.family[0].father_name);
						$('#mgfathercitizen').val(res.family[0].father_citizen);
						$('#mgmothername').val(res.family[0].mother_name);
						$('#mgmothercitizen').val(res.family[0].mother_citizen);
						$('#mmothername').val(res.family[0].spouse_name);
						$('#mmothercitizen').val(res.family[0].spouse_citizen);
					}else{
						$('#mfathername').val('');
						$('#mgfathername').val('');
						$('#mgfathercitizen').val('');
						$('#mgmothername').val('');
						$('#mgmothercitizen').val('');
						$('#mmothername').val('');
						$('#mmothercitizen').val('');
					}
					
				},error:function(){
					console.log('Unable to currently process data!!');
				}
			});
		}
	}
	
	/*check if house no exists*/
	function checkMember(){
		var house_no = $('#house_no').val();
		var road = $('#road').val();
		var type= 'member';
		if(house_no!=="" && road!==''){
			$.ajax({
				type:'post',
						url:"{{route('checkmember')}}",
						data:{house_no:house_no,road:road},
						dataType: "json",
						success: function(res){
							console.log(res);
							if(res.error){
								var parent = $('.errorajax').parent().addClass('has-error');
								$('.errorajax').show();
								
								$('.errorajax').text(res.error);
								$('.verifyhouseerror').show();
								$('.verifyhousesuccess').hide();
								$('.verifiedmsg').text('');
								$('.verifiedmsg').text('घर नं. '+houseno+' हाम्रो प्रणालीमा अवस्थित छैन');
								$('#memberform').submit(function(e){
									e.preventDefault();
								});
							}else{
								var parent = $('.errorajax').parent().removeClass('has-error');
								var msg = "घर नं "+house_no+" को मालिक "+res.owner+" हो र सम्पर्क नम्बर "+res.contact+" हो ।";
								$('.errorajax').hide();
								$('.verifyhouseerror').hide();
								$('.verifyhousesuccess').show();
								$('.verifiedmsg').text(msg);
								$('.nextgeneral').show();
								//$('#receiver_name').val(res.owner);	
								$('#tol').val(res.tol).prop('selected',true);	
								//$('#mobile').val(res.contact);
							}
							
						},error:function(){
							console.log('Unable to currently process data!!');
							$('.error').hide();		
						}
			});
		}
	}

</script>
@endsection