@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>label{margin-top:15px;}</style>
<link rel="stylesheet" href="{{asset('css/nepali.datepicker.v4.0.min.css')}}"/>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">सहभागी</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ 'सहभागी सम्पादन '}}</li>
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
							<h5 class="card-title mb-0">{{ 'सहभागी सम्पादन '}}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.participants.update',$participant->id) }}" method="POST">
								@csrf
								@method('patch')
								<div class="row">
									<div class="col-12">
										<div class="row">

											<div class="col-md-6 form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
												<label for="full_name"> {{ 'पुरा नाम' }} <span style="color:red;">*</span></label>
												<input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name', isset($participant) ? $participant->full_name : '') }}">
												@if($errors->has('full_name'))
													<em class="invalid-feedback">
														{{ $errors->first(full_name) }}
													</em>
												@endif
											</div>
											
											<div class="col-md-6 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
												<label for="mobile"> {{ 'मोबाइल' }}</label>
												<input type="text" name="mobile" maxlength="10" minlength="10" class="form-control" value="{{ old('mobile', isset($participant) ? $participant->mobile : '') }}">
												@if($errors->has('mobile'))
													<em class="invalid-feedback">
														{{ $errors->first('mobile') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('blood_grp') ? 'has-error' : '' }}">
												<label class="form-label" for="blood_grp">{{ 'रक्त समूह' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="blood_grp" class="form-select form-control-icon" required>
															<option value="NULL">{{"रक्त समूह चयन गर्नुहोस्"}}</option>
															<option value="A+" {{$participant->blood_grp == 'A+' ? 'selected' : ''}}>A+</option>
															<option value="A-" {{$participant->blood_grp == 'A-' ? 'selected' : ''}}>A-</option>
															<option value="B+" {{$participant->blood_grp == 'B+' ? 'selected' : ''}}>B+</option>
															<option value="B-" {{$participant->blood_grp == 'B-' ? 'selected' : ''}}>B-</option>
															<option value="O+" {{$participant->blood_grp == 'O+' ? 'selected' : ''}}>O+</option>
															<option value="O-" {{$participant->blood_grp == 'O-' ? 'selected' : ''}}>O-</option>
															<option value="AB+" {{$participant->blood_grp == 'AB+' ? 'selected' : ''}}>AB+</option>
															<option value="AB-" {{$participant->blood_grp == 'AB-' ? 'selected' : ''}}>AB-</option>
															<option value="Unknown" {{$participant->blood_grp == 'Unknown' ? 'selected' : ''}}>Unknown</option>
														</select>
														<i class="ri-contrast-drop-2-line"></i>
													</div>
													@if($errors->has('blood_grp'))
														<em class="invalid-feedback">
															{{ $errors->first('blood_grp') }}
														</em>
													@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
												<label class="form-label" for="gender">{{ 'लिङ्ग' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<select name="gender" class="form-select form-control-icon">
														<option value="9">{{"लिङ्ग चयन गर्नुहोस्"}}</option>
														<option value="0" {{$participant->gender==0 ? "selected" : ""}}>{{"पुरुष"}}</option>
														<option value="1" {{$participant->gender==1 ? "selected" : ""}}>{{"महिला"}}</option>
														<option value="2" {{$participant->gender==2 ? "selected" : ""}}>{{"अन्य"}}</option>
													</select>
													<i class="bx bx-male-female"></i>
												</div>
											</div>
											
											<div class="col-6 listradio seperated form-group {{ $errors->has('blood_grp_card') ? 'has-error' : '' }}">
												<label for="blood_grp_card">{{ 'रक्त समूह कार्ड' }}</label><br>
													
													<label for="blood_grp_card" class="radio-inline">
														<input class="form-check-input" type="radio" name="blood_grp_card" value="0" {{ $participant->blood_grp_card == 0 ? 'checked' : '' }} required> 
														{{ 'छ' }}
													</label>

													<label for="compostbin_seperated2" class="radio-inline">
														<input class="form-check-input" type="radio" name="blood_grp_card" value="1" {{ $participant->blood_grp_card == 1 ? 'checked' : '' }} >
														{{ 'छैन ' }}
													</label>
												@if($errors->has('blood_grp_card'))
													<div class="invalid-feedback">
														{{ $errors->first('blood_grp_card') }}
													</div>
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
<script src="{{asset('js/nepali.datepicker.v4.0.min.js')}}"></script>
<script>
	var mainInput = document.getElementById("nepali-dtpicker");
    mainInput.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	 
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