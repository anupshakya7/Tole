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
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ 'कार्यक्रम सहभागी सम्पादन '}}</li>
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
							<h5 class="card-title mb-0">{{ 'कार्यक्रम सहभागी सम्पादन '}}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.eventparticipants.update',$eparticipant->id) }}" method="POST">
								@csrf
								@method('patch')
								<div class="row">
									<div class="col-12">
										<div class="row">

											<div class="col-6 form-group {{ $errors->has('event_id') ? 'has-error' : '' }}">
												<label for="event_id"> {{ 'कार्यक्रम' }} <span style="color:red;">*</span></label>
												<select id="event_id" name="event_id" class="form-control form-select" required>
													<option>{{'कार्यक्रम चयन गर्नुहोस्'}}</option>
													@foreach($events as $event)														
														<option value='{{$event->id}}' {{$event->id==$eparticipant->event_id ? 'selected' : ''}}>{{$event->title}}</option>
													@endforeach 
												</select>
												@if($errors->has('event_id'))
													<em class="invalid-feedback">
														{{ $errors->first('event_id') }}
													</em>
												@endif
											</div>
											@php 
												$participants = \App\Participants::latest()->get();
											@endphp
											<div class="col-6 form-group {{ $errors->has('participant_id') ? 'has-error' : '' }}">
												<label for="event_id"> {{ 'सहभागी' }} <span style="color:red;">*</span></label>
												<select id="event_id" name="participant_id" class="form-control form-select" required>
													<option>{{'सहभागी चयन गर्नुहोस्'}}</option>
													@foreach($participants as $participant)														
														<option value='{{$participant->id}}' {{$participant->id==$eparticipant->participant_id ? 'selected' : ''}}>{{$participant->full_name}}</option>
													@endforeach 
												</select>
												@if($errors->has('participant_id'))
													<em class="invalid-feedback">
														{{ $errors->first('participant_id') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('registered_at') ? 'has-error' : '' }}">
												<label for="registered_at"> {{ 'दर्ता मिति' }} </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="registered_at" name="registered_at" value="{{ old('registered_at', isset($eparticipant) ? $eparticipant->registered_at : '') }}"/>
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('donated_at') ? 'has-error' : '' }}">
												<label for="donated_at"> {{ 'दान गरेको मिति' }} </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="donated_at" name="donated_at" value="{{ old('donated_at', isset($eparticipant) ? $eparticipant->donated_at : '') }}"/>
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('cert_received_at') ? 'has-error' : '' }}">
												<label for="cert_received_at"> {{ 'प्रमाणपत्र प्राप्त मिति' }} </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="cert_received_at" name="cert_received_at" value="{{ old('cert_received_at', isset($eparticipant) ? $eparticipant->cert_received_at : '') }}"/>
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('blood_grp_card_received_at') ? 'has-error' : '' }}">
												<label for="blood_grp_card_received_at"> {{ 'रक्त समूह कार्ड प्राप्त मिति' }}  </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="blood_grp_card_received_at" name="blood_grp_card_received_at" value="{{ old('blood_grp_card_received_at', isset($eparticipant) ? $eparticipant->blood_grp_card_received_at : '') }}"/>
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('previous_donation_at') ? 'has-error' : '' }}">
												<label for="previous_donatiion_at"> {{ 'विगत दान मिति' }}  </label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="previous_donation_at" name="previous_donation_at" value="{{ old('previous_donation_at', isset($eparticipant) ? $eparticipant->previous_donation_at : '') }}"/>
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
	
	var mainInput1 = document.getElementById("donated_at");
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