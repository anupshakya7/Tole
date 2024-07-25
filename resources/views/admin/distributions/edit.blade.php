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
  font-size:14px;
}
.errorajax{
	color:red;font-size:14px;
}
.has-error .form-control{
  border:1px solid red;
}
</style>
<link rel="stylesheet" href="{{asset('css/nepali.datepicker.v4.0.min.css')}}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">वितरण कार्यक्रम</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ 'वितरण सम्पादन'}}</li>
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
							<h5 class="card-title mb-0">{{ 'वितरण सम्पादन' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.distribution.update',$program->id) }}" method="POST">
								@csrf
								@method('patch')
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-6 form-group {{ $errors->has('program_id') ? 'has-error' : '' }}">
												<label for="program_id"> {{ 'कार्यक्रम' }} <span style="color:red;">*</span></label>
												<select name="program_id" class="form-control" required>
													@foreach($programs as $data)
														<option>{{'कार्यक्रम चयन गर्नुहोस्'}}</option>
														<option value='{{$data->id}}' {{$data->id==$program->program_id ? 'selected' : ''}}>{{$data->title_np}}</option>
													@endforeach 
												</select>
												@if($errors->has('program_id'))
													<em class="invalid-feedback">
														{{ $errors->first('program_id') }}
													</em>
												@endif
											</div>
											<div class="col-6 form-group {{ $errors->has('house_no') ? 'has-error' : '' }}">
												<label for="house_no">{{ 'घर नं.' }} <span style="color:red;">*</span></label>
												<input type="text" id="house_no" name="house_no" class="form-control" value="{{ old('house_no', isset($program) ? $program->house_no : '') }}" required>										
												@if($errors->has('house_no'))
													<em class="invalid-feedback">
														{{ $errors->first('house_no') }}
													</em>
												@endif
												<em class="errorajax" style="display:hidden;"></em>
											</div>
											<div class="col-6 form-group {{ $errors->has('road') ? 'has-error' : '' }}">
												<label for="road">{{ 'सडक नाम' }}</label>
												<select name="road" class="form-control" required>
													<option>{{'सडक चयन गर्नुहोस्'}}</option>
													@foreach($address as $data)
													<option value='{{$data->id}}' {{$data->id==$program->road ? 'selected' : ''}}>{{$data->address_np}}</option>
													@endforeach
												</select>
												@if($errors->has('road'))
													<em class="invalid-feedback">
														{{ $errors->first('road') }}
													</em>
												@endif
											</div>

											<div class="col-6 form-group {{ $errors->has('tol') ? 'has-error' : '' }}">
												<label for="tol">{{ 'टोल' }}*</label>
												<select name="tol" class="form-control" required>
													<option>{{'टोल चयन गर्नुहोस्'}}</option>
													@foreach($tol as $data)
													<option value='{{$data->id}}' {{$data->id==$program->tol ? 'selected' : ''}}>{{$data->tol_np}}</option>
													@endforeach
												</select>
												@if($errors->has('tol'))
													<em class="invalid-feedback">
														{{ $errors->first('tol') }}
													</em>
												@endif
											</div>
											<div class="col-6 form-group {{ $errors->has('receiver_name') ? 'has-error' : '' }}">
												<label for="receiver_name">{{ 'Receiver Name' }}  <span style="color:red;">*</span></label>
												<input type="text" name="receiver_name" class="form-control" value="{{ old('receiver_name', isset($program) ? $program->receiver : '') }}" required>
												@if($errors->has('receiver'))
													<em class="invalid-feedback">
														{{ $errors->first(receiver_name) }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
												<label for="mobile"> {{ 'मोबाइल' }} <span style="color:red;">*</span></label>
												<input type="text" name="mobile" maxlength="10" minlength="10" class="form-control" value="{{ old('mobile', isset($program) ? $program->mobile : '') }}" required>
												@if($errors->has('mobile'))
													<em class="invalid-feedback">
														{{ $errors->first('mobile') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('citizenship') ? 'has-error' : '' }}">
												<label for="citizenship"> {{ 'नागरिकता नं' }} <span style="color:red;">*</span></label>
												<input type="text" name="citizenship" class="form-control" value="{{ old('citizenship', isset($program) ? $program->citizenship : '') }}">
												@if($errors->has('citizenship'))
													<em class="invalid-feedback">
														{{ $errors->first('citizenship') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('registered_at') ? 'has-error' : '' }}">
												<label for="registered_at"> {{ 'दर्ता मिति' }} <span style="color:red;">*</span></label>
												<input type="text" name="registered_at" id="nepali-datepicker" class="form-control" value="{{ old('registered_bs', isset($program) ? $program->registered_bs : '') }}"  required>
												@if($errors->has('registered_at'))
													<em class="invalid-feedback">
														{{ $errors->first('registered_at') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('received_at') ? 'has-error' : '' }}">
												<label for="received_at"> {{ 'प्राप्त भएको मिति' }} <span style="color:red;">*</span></label>
												<input type="text" name="received_at" id="nepali-datepicker1" class="form-control" value="{{ old('received_bs', isset($program) ? $program->received_bs : '') }}" >
												@if($errors->has('received_at'))
													<em class="invalid-feedback">
														{{ $errors->first('received_at') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('remarks') ? 'has-error' : '' }}">
												<label for="total_people">{{ 'टिप्पणीहरू(Remarks)'}}</label>
												 <textarea class="form-control" name="remarks" rows="4" cols="50">{{ old('remarks', isset($program) ? $program->remarks : '') }}</textarea>  <br>
												@if($errors->has('remarks'))
													<div class="invalid-feedback">
														{{ $errors->first('remarks') }}
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
	var mainInput = document.getElementById("nepali-datepicker");
     mainInput.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	 
	 var mainInput1 = document.getElementById("nepali-datepicker1");
     mainInput1.nepaliDatePicker({ndpYear: true,ndpMonth: true});
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