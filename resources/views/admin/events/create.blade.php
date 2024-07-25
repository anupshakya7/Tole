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
						<h4 class="mb-sm-0">Events</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ 'Add Events'}}</li>
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
							<h5 class="card-title mb-0">{{ 'Add Events' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-md-12 form-group {{ $errors->has('title') ? 'has-error' : '' }}">
												<label for="title"> {{ 'शीर्षक' }} <span style="color:red;">*</span></label>
												<input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
												@if($errors->has('title'))
													<em class="invalid-feedback">
														{{ $errors->first('title') }}
													</em>
												@endif
											</div>

											<div class="col-md-6 form-group {{ $errors->has('venue') ? 'has-error' : '' }}">
												<label for="venue"> {{ 'स्थल' }}</label>
												<input type="text" id="title_np" name="venue" class="form-control" value="{{ old('venue') }}">
												@if($errors->has('venue'))
													<em class="invalid-feedback">
														{{ $errors->first('venue') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('event_date') ? 'has-error' : '' }}">
												<label for="event_date"> {{ 'कार्यक्रम मिति' }} <span style="color:red;">*</span></label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="nepali-dtpicker" name="event_date" required />
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