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
<link href="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/css/nepali.datepicker.v4.0.4.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>

<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">वितरण</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ 'वितरण थप्नुहोस्'}}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header border-bottom-dashed">
							<h5 class="card-title mb-0">{{ 'वितरण थप्नुहोस्' }}</h5>
						</div>

						<div class="card-body">
							<form id="distributionform" action="{{ route('admin.distribution.store') }}" method="POST">
								@csrf
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-6 form-group {{ $errors->has('program_id') ? 'has-error' : '' }}">
												<label for="program_id"> {{ 'कार्यक्रम' }} <span style="color:red;">*</span></label>
												<select id="program_id" name="program_id" class="form-control form-select" value="{{ old('program_id') }}" required>
													<option>{{'कार्यक्रम चयन गर्नुहोस्'}}</option>
													@foreach($programs as $program)														
														<option value='{{$program->id}}' {{$program->id==2 ? 'selected' : ''}}>{{$program->title_np}}</option>
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
												<input type="text" id="house_no"  onfocusout="getRoad();" name="house_no" class="form-control" value="{{ old('house_no') }}" required>										
												@if($errors->has('house_no'))
													<em class="invalid-feedback">
														{{ $errors->first('house_no') }}
													</em>
												@endif
												<em class="errorajax" style="display:hidden;"></em>
											</div>
											<div class="col-6 form-group form-check">
												<label>{{ 'सडक नाम' }}</label>
												<select id="road" onfocusout="checkHouseowner();" name="road" class="form-control form-select" required>
													<option>{{'सडक चयन गर्नुहोस्'}}</option>
													@foreach($address as $data)
													<option value='{{$data->id}}' {{$data->id==old('road') ? 'selected' : ''}}>{{$data->address_np}}</option>
													@endforeach
												</select>
												<em class="error" style="color:red;display:none;"></em> 
											</div>
									
											<div class="col-6 form-group form-check">
												<label for="tol">{{ 'टोल' }}*</label>
												<select id="tol" name="tol" class="form-control form-select" required>
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
											<div class="col-6 form-group {{ $errors->has('receiver_name') ? 'has-error' : '' }}">
												<label for="receiver_name">{{ 'Receiver Name' }}  <span style="color:red;">*</span></label>
												<input type="text" id="receiver_name" name="receiver_name" class="form-control" value="{{ old('receiver_name') }}">
												@if($errors->has('receiver'))
													<em class="invalid-feedback">
														{{ $errors->first(receiver_name) }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
												<label for="mobile"> {{ 'मोबाइल' }} <span style="color:red;">*</span></label>
												<input type="text" id="mobile" name="mobile" maxlength="10" minlength="10" class="form-control" value="{{ old('mobile') }}">
												@if($errors->has('mobile'))
													<em class="invalid-feedback">
														{{ $errors->first('mobile') }}
													</em>
												@endif
											</div>
											
											<div class="col-6 form-group {{ $errors->has('citizenship') ? 'has-error' : '' }}">
												<label for="citizenship"> {{ 'नागरिकता नं' }} <span style="color:red;">*</span></label>
												<input type="text" id="citizenship" name="citizenship" class="form-control" value="{{ old('citizenship') }}">
												@if($errors->has('citizenship'))
													<em class="invalid-feedback">
														{{ $errors->first('citizenship') }}
													</em>
												@endif
											</div>
											
											{{--<div class="col-6 form-group {{ $errors->has('registered_at') ? 'has-error' : '' }}">
												<label for="registered_at"> {{ 'दर्ता मिति' }} <span style="color:red;">*</span></label>
													<input type="text" name="registered_at" id="nepali-datepicker" class="form-control" value="{{ old('registered_at') }}">
														<select id="registered_at" name="registered_at" class="form-control form-select" required>
													<option>{{'दर्ता मिति गर्नुहोस्'}}</option>
													<option value="2022-08-28">2079-05-12</option>
													<option value="2022-09-02">2079-05-17</option>
													<option value="2022-09-03">2079-05-18</option>
													<option value="2022-09-10">2079-05-25</option>
													<option value="2022-09-17">2079-06-01</option>
													<option value="2022-12-17">2079-09-02</option>
												</select>
												@if($errors->has('registered_at'))
													<em class="invalid-feedback">
														{{ $errors->first('registered_at') }}
													</em>
												@endif
											</div>--}}
											
											<div class="col-6 form-group {{ $errors->has('registered_at') ? 'has-error' : '' }}">
												<label for="registered_at"> {{ 'दर्ता मिति' }} <span style="color:red;">*</span></label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" id="nepali-datepicker" name="registered_at" required />
													<i class="bx bx-calendar"></i>
												</div>
											</div>
											
											<div class="col-6 form-group {{ $errors->has('received_at') ? 'has-error' : '' }}">
												<label for="received_at"> {{ 'प्राप्त भएको मिति' }} </label>
												<div class="form-icon">
													<input type="text" name="received_at" id="nepali-datepicker1" class="form-control" value="{{ old('received_at') }}">
													<i class="bx bx-calendar"></i>
												</div>
												@if($errors->has('received_at'))
												<em class="invalid-feedback">
													{{ $errors->first('received_at') }}
												</em>
												@endif
											</div>
											
											<div class="col-6 form-group form-check {{ $errors->has('remarks') ? 'has-error' : '' }}">
												<label for="total_people">{{ 'टिप्पणीहरू(Remarks)'}}</label>
												 <textarea class="form-control" name="remarks" rows="4" cols="50"></textarea>  <br>
												@if($errors->has('remarks'))
													<div class="invalid-feedback">
														{{ $errors->first('remarks') }}
													</div>
												@endif
											</div>
										</div>
									</div>							

									<div class="col-12 text-end" style="margin-top:15px;">
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
	
	/*getting roads according to house_no*/
	function getRoad(){
		var houseno = $('#house_no').val();
	
		if(houseno !=''){
			$.ajax({
				type:'get',
				url:"{{route('homeroads2')}}?id="+houseno+"&type=distribution",
				success: function(res){
					if(res.error){
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
	
	/*check if house no exists*/
	function checkHouseowner(){
		var house_no = $('#house_no').val();
		var road = $('#road').val();
		var type= 'distribution';
	
		var program = $('#program_id :selected').val();
		console.log(program,"test"); 
		if(house_no!=="" && road!==''){
			$.ajax({
				type:'post',
						url:"{{route('checkOwner2')}}",
						data:{house_no:house_no,road:road,type:type,program:program},
						dataType: "json",
						success: function(res){
							//console.log(res); 
							if(res.error){
								var parent = $('.errorajax').parent().addClass('has-error');
								$('.errorajax').show();
								
								$('.errorajax').text(res.error);
								if(program=='2'){
								    $("#uploadButton").hide();
    								$('#distributionform').submit(function(e){
    									e.preventDefault();
    								});
								}
								
							}else{
								var parent = $('.errorajax').parent().removeClass('has-error');
								$('.errorajax').hide();
								$("#uploadButton").show();
								$('#receiver_name').val(res.owner);	
								$('#tol').val(res.tol).prop('selected',true);	
								$('#mobile').val(res.contact);
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