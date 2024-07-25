@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>

label{margin-top:15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}
.hidden{display:none;}
.has-error .invalid-feedback{
  display:block;
  font-size:16px;
}
.has-error .form-control{
  border:1px solid red;
}
</style>
<link rel="stylesheet" href="{{asset('css/nepali.datepicker.v4.0.min.css')}}"/>
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
								<li class="breadcrumb-item active">{{ $pageTitle}}</li>
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
							<h5 class="card-title mb-0">{{ $pageTitle }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.participants.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-6 form-group {{ $errors->has('event_id') ? 'has-error' : '' }}">
												<label for="event_id"> {{ 'कार्यक्रम' }} <span style="color:red;">*</span></label>
												<select id="event_id" name="event_id" class="form-control form-select" value="{{ old('event_id') }}" required>
													<option>{{'कार्यक्रम चयन गर्नुहोस्'}}</option>
													@foreach($events as $event)														
														<option value='{{$event->id}}' {{old('event_id') ? 'selected' : ''}}>{{$event->title}}</option>
													@endforeach 
												</select>
												@if($errors->has('event_id'))
													<em class="invalid-feedback">
														{{ $errors->first('event_id') }}
													</em>
												@endif
											</div>
											<div class="col-md-6 form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
												<label for="full_name"> {{ 'पुरा नाम' }} <span style="color:red;">*</span></label>
												<input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
												@if($errors->has('full_name'))
													<em class="invalid-feedback">
														{{ $errors->first('full_name') }}
													</em>
												@endif
											</div>

											<div class="col-md-6 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
												<label for="mobile"> {{ 'मोबाइल' }}</label>
												<input type="text" name="mobile" maxlength="10" minlength="10" class="form-control" value="{{ old('mobile') }}">
												@if($errors->has('mobile'))
													<em class="invalid-feedback">
														{{ $errors->first('mobile') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('blood_grp') ? 'has-error' : '' }}">
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
											
											<div class="col-6 form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
												<label class="form-label" for="gender">{{ 'लिङ्ग' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<select name="gender" class="form-select form-control-icon">
														<option value="9">{{"लिङ्ग चयन गर्नुहोस्"}}</option>
														<option value="0" {{old("gender")==0 ? "selected" : ""}}>{{"पुरुष"}}</option>
														<option value="1" {{old("gender")==1 ? "selected" : ""}}>{{"महिला"}}</option>
														<option value="2" {{old("gender")==2 ? "selected" : ""}}>{{"अन्य"}}</option>
													</select>
													<i class="bx bx-male-female"></i>
												</div>
											</div>
											
											<div class="col-6 listradio seperated form-group {{ $errors->has('blood_grp_card') ? 'has-error' : '' }}">
												<label for="blood_grp_card">{{ 'रक्त समूह कार्ड' }}</label><br>
													
													<label for="blood_grp_card" class="radio-inline">
														<input class="form-check-input" type="radio" name="blood_grp_card" value="0" {{ old('blood_grp_card') == 0 ? 'checked' : '' }} required> 
														{{ 'छ' }}
													</label>

													<label for="compostbin_seperated2" class="radio-inline">
														<input class="form-check-input" type="radio" name="blood_grp_card" value="1" {{ old('blood_grp_card') == 1 ? 'checked' : '' }} >
														{{ 'छैन ' }}
													</label>
												@if($errors->has('blood_grp_card'))
													<div class="invalid-feedback">
														{{ $errors->first('blood_grp_card') }}
													</div>
												@endif
											</div>
											<div class="col-12"></div>
											
											<div class="col-6 form-group {{ $errors->has('registered_at') ? 'has-error' : '' }}">
												<label for="registered_at"> {{ 'दर्ता मिति' }} </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="registered_at" name="registered_at" />
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('dontated_at') ? 'has-error' : '' }}">
												<label for="dontated_at"> {{ 'दान गरेको मिति' }} </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="dontated_at" name="dontated_at" />
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('cert_received_at') ? 'has-error' : '' }}">
												<label for="cert_received_at"> {{ 'प्रमाणपत्र प्राप्त मिति' }} </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="cert_received_at" name="cert_received_at" />
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('blood_grp_card_received_at') ? 'has-error' : '' }}">
												<label for="blood_grp_card_received_at"> {{ 'रक्त समूह कार्ड प्राप्त मिति' }}  </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="blood_grp_card_received_at" name="blood_grp_card_received_at" />
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('previous_donation_at') ? 'has-error' : '' }}">
												<label for="previous_donation_at"> {{ 'विगत दान मिति' }}  </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="previous_donation_at" name="previous_donation_at" />
													<i class="bx bx-calendar"></i>
												</div>
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
<script src="{{asset('js/nepali.datepicker.v4.0.min.js')}}"></script>
<script>
	var mainInput = document.getElementById("registered_at");
    mainInput.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	
	var mainInput1 = document.getElementById("dontated_at");
    mainInput1.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	
	var mainInput2 = document.getElementById("cert_received_at");
    mainInput2.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	
	var mainInput3 = document.getElementById("blood_grp_card_received_at");
    mainInput3.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	
	var mainInput4 = document.getElementById("previous_donation_at");
    mainInput4.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	 
	toastr.options = {
	  "closeButton": true,
	  "newestOnTop": true,
	  "positionClass": "toast-top-right"
	};

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif

</script>
@endsection