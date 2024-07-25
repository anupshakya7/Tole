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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
<style>label{margin-top:15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}</style>
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
								<li class="breadcrumb-item active">{{ 'Add House Owner data'}}</li>
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
							<h5 class="card-title mb-0">{{ 'Add House Owner data' }}</h5>
						</div>

						<div class="card-body">
							<form name="homeowner" action="{{ route('admin.house.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-12">
										<div class="row">
										
											<div class="col-6 form-group form-check {{ $errors->has('taxpayer_id') ? 'has-error' : '' }}">
												<label for="name">{{ 'करदाता संकेत नं.' }}</label>
												<input type="text" id="taxpayerid" name="taxpayer_id" class="form-control" value="{{ old('taxpayer_id') }}">
												@if($errors->has('taxpayer_id'))
													<em class="invalid-feedback">
														{{ $errors->first('taxpayer_id') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('house_no') ? 'has-error' : '' }}">
												<label for="name">{{ 'घर नं.' }}*</label>
												<input type="text" id="houseno" id="title" name="house_no" class="form-control" value="{{ old('house_no') }}" required>
												@if($errors->has('house_no'))
													<em class="invalid-feedback">
														{{ $errors->first('house_no') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('road') ? 'has-error' : '' }}">
												<label for="road">{{ 'सडक नाम' }}</label>
												<select id="road" name="road" class="form-control" required>
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
												<label for="tol">{{ 'टोल' }}*</label>
												<select id="tol" name="tol" class="form-control" required>
													<option>{{'सडक चयन गर्नुहोस्'}}</option>
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
											
											<div class="col-6 form-group form-check {{ $errors->has('contact') ? 'has-error' : '' }}">
												<label for="contact">{{ 'सम्पर्क' }}</label>
												<input type="text" id="contact" name="contact" class="form-control" value="{{ old('contact') }}" required>
												@if($errors->has('contact'))
													<em class="invalid-feedback">
														{{ $errors->first('contact') }}
													</em>
												@endif
											</div>

											<div class="col-6 form-group form-check {{ $errors->has('owner') ? 'has-error' : '' }}">
												<label for="owner">{{ 'घर धनि' }} <span class="fi fi-us fis"></span></label>
												<input type="text" id="owner" name="owner" class="form-control" value="{{ old('owner') }}" required>
												@if($errors->has('owner'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('owner') }}
													</div>
												@endif
											</div>

											<div class="col-6 form-group form-check {{ $errors->has('owner_np') ? 'has-error' : '' }}">
												<label for="owner_np"> {{ 'घर धनि' }} <span class="fi fi-np fis"></span></label>
												<input type="text" id="owner_np" name="owner_np" class="form-control" value="{{ old('owner_np') }}">
												@if($errors->has('owner_np'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('owner_np') }}
													</div>
												@endif
											</div>

											<div class="col-6 form-group form-check {{ $errors->has('responent') ? 'has-error' : '' }}">
												<label for="responent"> {{ 'Respondent' }} <span class="fi fi-us fis"></span></label>
												<input type="text" id="responent" name="responent" class="form-control" value="{{ old('responent') }}">
												@if($errors->has('responent'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('responent') }}
													</div>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('responent_np') ? 'has-error' : '' }}">
												<label for="responent_np"> {{ 'प्रतिवादी नाम' }} <span class="fi fi-np fis"></span></label>
												<input type="text" id="responent_np" name="responent_np" class="form-control" value="{{ old('responent_np') }}">
												@if($errors->has('responent_np'))
													<div class="invalid-feedback" style="display:block;">
														{{ $errors->first('responent_np') }} 
													</div>
												@endif
											</div>											

											<div class="col-6 form-group form-check {{ $errors->has('mobile') ? 'has-error' : '' }}">
												<label for="house_storey">{{ 'मोबाइल' }}</label>
												<input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" required>
												@if($errors->has('mobile'))
													<em class="invalid-feedback">
														{{ $errors->first('mobile') }}
													</em>
												@endif
											</div>

											<div class="col-6 form-group form-check {{ $errors->has('occupation') ? 'has-error' : '' }}">
												<label for="occupation">{{ 'पेशा' }}</label>
												@php $job = \App\Occupation::get();@endphp 
												<select id="occupation" name="occupation" class="form-control" required>
													<option>{{'पेशा रोज्नुहोस्'}}</option>
													@foreach($job as $data)
													<option value='{{$data->id}}' {{$data->id==old('occupation') ? 'selected' : ''}}>{{$data->occupation_np}}</option>
													@endforeach
												</select>
												@if($errors->has('occupation'))
													<em class="invalid-feedback">
														{{ $errors->first('occupation') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('no_of_tenants') ? 'has-error' : '' }}">
												<label for="no_of_tenants">{{ 'भाडामा बस्नेहरुको संख्या' }}</label>
												<input type="number" name="no_of_tenants" class="form-control" value="{{ old('respondent') }}" required>
												@if($errors->has('no_of_tenants'))
													<em class="invalid-feedback">
														{{ $errors->first('no_of_tenants') }}
													</em>
												@endif
											</div>

											<div class="col-6 form-group form-check {{ $errors->has('gender') ? 'has-error' : '' }}">
												<label for="gender">{{ 'लिङ्ग' }}</label>
												<select name="gender" class="form-control" required>
													<option value="NULL">{{"लिङ्ग चयन गर्नुहोस्"}}</option>
													<option value="0">{{"पुरुष"}}</option>
													<option value="1">{{"महिला"}}</option>
												</select>
												@if($errors->has('gender'))
													<em class="invalid-feedback">
														{{ $errors->first('gender') }}
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
<script src="https://unpkg.com/nepalify@0.5.0/umd/nepalify.production.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
	var textareaE2 = nepalify.interceptElementById("respondent_np");
	var textareaE3 = nepalify.interceptElementById("owner_np");
	
    toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif
	  
	  //form validation
	$(function(){
		$("form[name='homeowner']").validate({
			// Specify validation rules
			rules: {
			  owner: "required",
			  contact: "required",
			  mobile: "required",
			  contact: {
				required: true,
				minlength: 10
			  },
			  mobile:{
				  required: true,
				  minlength:10
			  },
			},
			// Specify validation error messages
			messages: {

			  owner: "घर धनिको पूरा नाम प्रविष्ट गर्नुहोस्",
			  contact: {
				required: "कृपया सम्पर्क नम्बर प्रविष्ट गर्नुहोस्",
				minlength: "सम्पर्क नम्बर 10 वर्ण लामो हुनुपर्छ"

			  },
			  mobile:{
				  required: "कृपया मोबाइल नम्बर प्रविष्ट गर्नुहोस्",
				  minlength: "मोबाइल नम्बर 10 वर्ण लामो हुनुपर्छ"
			  }

			},
			// Make sure the form is submitted to the destination defined

			// in the "action" attribute of the form when valid

			submitHandler: function(form) {

			  form.submit();

			}

		  });
	});

</script>
@endsection