@php
   if(auth()->user()->hasRole('surveyer')) {
      $layoutDirectory = 'layouts.surveyer-web';
   } else {
      $layoutDirectory = 'layouts.admin-web';
   }
@endphp

@extends($layoutDirectory)
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
<style>
.listradio{padding:0px 20px;}
label{margin-top:15px;}
.error{color:red;}
.form-check{padding-left:5px;padding-right:5px;}
.hidden{display:none;}
.has-error .invalid-feedback{
  display:block;
  font-size:16px;
}
.has-error .form-control{
border: 1px solid red;
}
@media(max-width:767px){
	.radio-inline{
  font-size:14px;
  font-weight: 600;
}
.error{font-size:10px;line-height:1.2;}
}
</style>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">Compostbin Survey</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ 'Add Compostbin Survey data'}}</li>
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
							<h5 class="card-title mb-0">{{ 'Add Compostbin Survey data' }}</h5>
						</div>

						<div class="card-body">
							<form name="compostbinsurvey" action="{{ route('admin.cbinsurvey.saved') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-6 form-group form-check">
										<label>{{ 'घर नं.' }}*</label>
										<input type="text"  id="houseno" onfocusout="getRoad();" autocomplete="off" name="house_no" class="form-control" value="{{ old('house_no') }}" required>										
										<em class="error" style="color:red;display:none;"></em> 
									</div> 
									
									<div class="col-6 form-group form-check">
										<label>{{ 'सडक नाम' }}</label>
										<select id="road" onfocusout="checkHouseowner();" name="road" class="form-control" required>
											<option>{{'सडक चयन गर्नुहोस्'}}</option>
											@foreach($address as $data)
											<option value='{{$data->id}}' {{$data->id==old('road') ? 'selected' : ''}}>{{$data->address_np}}</option>
											@endforeach
										</select>
										<em class="error" style="color:red;display:none;"></em> 
									</div>
									
									<div class="col-6 form-group form-check">
										<label for="tol">{{ 'टोल' }}*</label>
										<select id="tol" name="tol" class="form-control" required>
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

									<div class="col-6 form-group form-check {{ $errors->has('contact') ? 'has-error' : '' }}">
										<label for="contact">{{ 'घर धनिको नम्बर' }}</label>
										<input type="text" id="contact" autocomplete="off" name="contact" class="form-control" maxlength="10" minlength="10" value="{{ old('contact') }}" required>
										@if($errors->has('contact'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('contact') }}
											</div>
										@endif
									</div>
									
									<div class="col-6 form-group form-check {{ $errors->has('owner') ? 'has-error' : '' }}">
										<label for="owner">{{ 'Home Owner' }} <span class="fi fi-us fis"></span></label>
										<input type="text" id="owner" autocomplete="off" name="owner" class="form-control" value="{{ old('owner') }}" required>
										@if($errors->has('owner'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('owner') }}
											</div>
										@endif
									</div>
									{{--<div class="col-6 form-group form-check ownerdetails {{ $errors->has('owner_np') ? 'has-error' : '' }}" style="display:none" >
										<label for="owner_np"> {{ 'घर धनि' }} <span class="fi fi-np fis"></span></label>
										<input type="text" id="owner_np" name="owner_np" class="form-control" value="{{ old('owner_np') }}">
										@if($errors->has('owner_np'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('owner_np') }}
											</div>
										@endif
									</div>
									
									<div class="col-6 form-group form-check ownerdetails {{ $errors->has('respondent') ? 'has-error' : '' }}" style="display:none">
										<label for="respondent"> {{ 'Respondent' }} <span class="fi fi-us fis"></span></label>
										<input type="text" id="respondent" name="respondent" class="form-control" value="{{ old('respondent') }}">
										@if($errors->has('respondent'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('respondent') }}
											</div>
										@endif
									</div>
									
									<div class="col-6 form-group form-check ownerdetails {{ $errors->has('respondent_np') ? 'has-error' : '' }}" style="display:none">
										<label for="respondent_np"> {{ 'प्रतिवादी नाम' }} <span class="fi fi-np fis"></span></label>
										<input type="text" id="respondent_np" name="respondent_np" class="form-control" value="{{ old('respondent_np') }}">
										@if($errors->has('respondent_np'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('respondent_np') }} 
											</div>
										@endif
									</div>
									
									<div class="col-6 form-group form-check ownerdetails {{ $errors->has('mobile') ? 'has-error' : '' }}" style="display:none">
										<label for="mobile"> {{ 'Mobile' }} <span class="fi fi-us fis"></span></label>
										<input type="text" id="mobile" name="mobile" maxlength="10" class="form-control" value="{{ old('mobile') }}">
										@if($errors->has('mobile'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('mobile') }}
											</div>
										@endif
									</div>
									
									<div class="col-6 form-group form-check ownerdetails {{ $errors->has('occupation') ? 'has-error' : '' }}" style="display:none">
										<label for="occupation"> {{ 'पेशा' }} <span class="fi fi-np fis"></span></label>
										@php $occupation = \App\Occupation::orderBy('id','DESC')->get();@endphp
										<select id="occupation" name="occupation" class="form-control" required>
											<option>{{'पेशा चयन गर्नुहोस्'}}</option>
											@foreach($occupation as $data)
											<option value='{{$data->id}}' {{$data->id==old('occupation') ? 'selected' : ''}}>{{$data->occupation_np}}</option>
											@endforeach
										</select>
										@if($errors->has('occupation'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('occupation') }}
											</div>
										@endif
									</div>
									
									<div class="col-6 form-group form-check ownerdetails {{ $errors->has('gender') ? 'has-error' : '' }}" style="display:none">
										<label for="gender">{{ 'लिङ्ग' }}</label>
										<select id="gender" name="gender" class="form-control">
											<option>{{'लिङ्ग चयन गर्नुहोस्'}}</option>
											<option value='0'>पुरुष</option>
											<option value='1'>महिला</option>
										</select>
									</div>--}}
									
									<div class="col-6 form-group {{ $errors->has('respondent_no') ? 'has-error' : '' }}">
										<label for="respondent_no">{{ 'अर्को नं' }}</label>
										<input type="text" id="respondent_no" maxlength="10" name="respondent_no" class="form-control" value="{{ old('respondent_no') }}">
										@if($errors->has('respondent_no'))
											<em class="invalid-feedback">
												{{ $errors->first('respondent_no') }}
											</em>
										@endif
									</div>

									<div class="col-6 form-group form-check {{ $errors->has('house_storey') ? 'has-error' : '' }}">
										<label for="house_storey">{{ 'घरको तला' }}</label>
										<input type="number" id="house_storey" name="house_storey" class="form-control" value="{{ old('house_storey') }}" required>
										@if($errors->has('house_storey'))
											<div class="invalid-feedback" style="display:block;">
												{{ $errors->first('house_storey') }}
											</div>
										@endif
									</div>

									<div class="col-6 form-group form-check {{ $errors->has('no_kitchen') ? 'has-error' : '' }}">
										<label for="no_kitchen">{{ 'भान्छाको संख्या' }}</label>
										<input type="number" id="no_kitchen" name="no_kitchen" class="form-control" value="{{ old('no_kitchen') }}" required>
										@if($errors->has('no_kitchen'))
											<div class="invalid-feedback">
												{{ $errors->first('no_kitchen') }}
											</div>
										@endif
									</div>

									<div class="col-6 form-group form-check {{ $errors->has('total_people') ? 'has-error' : '' }}">
										<label for="total_people">{{ 'कुल बसोबास गर्ने मानिसहरू' }}</label>
										<input type="number" id="slug" name="total_people" class="form-control" value="{{ old('total_people') }}" required>
										@if($errors->has('total_people'))
											<div class="invalid-feedback">
												{{ $errors->first('total_people') }}
											</div>
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
									<div class="col-6 listradio form-group {{ $errors->has('compostbin_usage') ? 'has-error' : '' }}">
										<label for="slug">{{ 'कम्पोस्टबिन प्रयोग' }}</label><br>
													
											<label for="compostbin_usage1" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_usage" id="compostbin_usage1" value="0" {{ old('compostbin_usage') == 0 ? 'checked' : '' }} required>
												{{ 'छ' }}
											</label>
											
											<label for="compostbin_usage2" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_usage" id="compostbin_usage2" value="1" {{ old('compostbin_usage') == 1 ? 'checked' : '' }}> 
												{{ 'छैन ' }}
											</label>
										@if($errors->has('compostbin_usage'))
											<div class="invalid-feedback">
												{{ $errors->first('compostbin_usage') }}
											</div>
										@endif
									</div>
									
									<div class="col-6 listradio seperated form-group {{ $errors->has('compostbin_seperated') ? 'has-error' : '' }}">
										<label for="slug">{{ 'फोहोर बर्गिकरण' }}</label><br>
											
											<label for="compostbin_seperated1" class="radio-inline">
												<input class="form-check-input cbinseperated" type="radio" name="compostbin_seperated" id="compostbin_seperated1" value="0" {{ old('compostbin_seperated') == 0 ? 'checked' : '' }} required> 
												{{ 'छ' }}
											</label>

											<label for="compostbin_seperated2" class="radio-inline">
												<input class="form-check-input cbinseperated" type="radio" name="compostbin_seperated" id="compostbin_seperated2" value="1" {{ old('compostbin_seperated') == 1 ? 'checked' : '' }} >
												{{ 'छैन ' }}
											</label>
										@if($errors->has('compostbin_seperated'))
											<div class="invalid-feedback">
												{{ $errors->first('compostbin_seperated') }}
											</div>
										@endif
									</div>
									
									<div class="col-6 listradio source form-group {{ $errors->has('compostbin_source') ? 'has-error' : 'hidden' }}">
										<label for="slug">{{ 'कम्पोस्टबिनको स्रोत' }}</label><br>
												
										<label for="compostbin_source1" class="radio-inline">
											<input class="form-check-input csource" type="radio" id="compostbin_source1" name="compostbin_source" value="व्यक्तिगत" {{ old('compostbin_source') == 'व्यक्तिगत' ? 'checked' : '' }}>
											{{ 'व्यक्तिगत' }}
										</label>
										
										<label for="compostbin_source2" class="radio-inline">
											<input class="form-check-input csource" type="radio" id="compostbin_source2" name="compostbin_source" value="वडा" {{ old('compostbin_source') == 'वडा' ? 'checked' : '' }}> 
											{{ 'वडा ' }}
										</label>

										<label for="compostbin_source3" class="radio-inline">
											<input class="form-check-input csource" type="radio" id="compostbin_source3" name="compostbin_source" value="उपलब्ध छैन" {{ old('compostbin_source') == 'उपलब्ध छैन' ? 'checked' : '' }}> 
											{{ 'उपलब्ध छैन ' }}
										</label>
										@if($errors->has('compostbin_source'))
											<div class="invalid-feedback">
												{{ $errors->first('compostbin_source') }}
											</div>
										@endif
									</div>

									

									<div class="col-6 listradio reason form-group {{ $errors->has('reason') ? 'has-error' : 'hidden' }}">
										<label for="slug">{{ 'नगर्नुको कारण' }}</label><br>
										
										<label for="reason1" class="radio-inline">
											<input class="form-check-input remark" type="radio" name="reason" id="reason1" value="समय को आभाब" {{ old('reason') == 'समय को आभाब' ? 'checked' : '' }}> 
											{{ 'समय को आभाब' }}
										</label>

										<label for="reason2" class="radio-inline">
											<input class="form-check-input remark" type="radio" name="reason" id="reason2" value="ठाउँको अभाव" {{ old('reason') == 'ठाउँको अभाव' ? 'checked' : '' }}>
											{{ 'ठाउँको अभाव ' }}
										</label>

										<label for="reason" class="radio-inline">
											<input class="form-check-input remark" type="radio" name="reason" id="formradioRight5" value="अन्य" {{ old('reason') == 'अन्य' ? 'checked' : '' }}>
											{{ 'अन्य' }}
										</label>
										@if($errors->has('reason'))
											<div class="invalid-feedback">
												{{ $errors->first('reason') }}
											</div>
										@endif
									</div>				

							<div class="col-12 text-end">
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
	
	//var input1 = nepalify.interceptElementById("respondent_np");
	//var input2 = nepalify.interceptElementById("owner_np");

	/*getting roads according to house_no*/
	function getRoad(){
		var houseno = $('#houseno').val();
		//var url = "{{route('homeroads')}}?id="+houseno;
		if(houseno!=''){
			$.ajax({
				type:'get',
				url:"{{route('homeroads2')}}?id="+houseno,
				success: function(res){
					//console.log(url);
					if(res.error){
						console.log('error');
						//$('.ownerdetails').show();
						$('#owner').val('');
						$('#contact').val('');
						$("#owner_np").prop("required",true);
						$("#respondent").prop("required",true);
						$("#respondent_np").prop("required",true);	
						$('.error').hide();
						$('#road').empty();
						$.each(res.address,function(i,val){
							$('#road').append('<option value="'+val.id+'">'+val.address_np+'</option>');
						})
					}else{	
						console.log('no error');
						$('.error').hide();					
						//$('.ownerdetails').hide();						
						$("#owner_np").prop("required",false);
						$("#respondent").prop("required",false);
						$("#respondent_np").prop("required",false);
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
			if(house_no!=="" && road!==''){
				$.ajax({
						type:'post',
						url:"{{route('checkHouse')}}",
						data:{house_no:house_no,road:road},
						dataType: "json",
						success: function(res){
							//console.log(res);
							if(res.error){
								$('.error').show();
								$('.error').text(res.error);
								$('#owner').val("");
								$('#tol').val("");
								$('#contact').val("");
							}else{ 
								//console.log(res);
								$('.error').hide();
								$('#owner').val(res.owner);	
								$('#tol').val(res.tol).prop('selected',true);	
								$('#contact').val(res.mobile);																
							}
						},error:function(){
							console.log('Unable to currently process data!!');
							$('.error').hide();		
						}
					});
			}
				
		}
	//form validation
	$(function(){
		$("form[name='compostbinsurvey']").validate({
			// Specify validation rules
			rules: {
			  owner: "required",
			  contact: "required",
			  contact: {
				required: true,
				minlength: 10
			  },
			  mobile:{
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
	
    $( document ).ready(function() {
		
		$("input[name$='compostbin_usage']").click(function() {
			var val = $(this).val();
			console.log(val);
			if(val=='0'){
				$('.source').show();
				$('.csource').prop('required',true);
			}else{
				$('.source').hide();
				$('.reason').hide();
				$('.cbinseperated').prop('required',false);
				$('.csource').prop('required',false);
				$('.remark').prop('required',false);
				$('.cbinseperated').prop('checked',false);
				$('.csource').prop('checked',false);
				$('.remark').prop('checked',false);
			}
			});

		$("input[name$='compostbin_source']").click(function() {
			var val = $(this).val();
			console.log(val);
			if(val=='उपलब्ध छैन'){
				$('.seperated').show();
				$('.cbinseperated').prop('required',true);
			}
			});

		$("input[name$='compostbin_seperated']").click(function() {
			var val = $(this).val();
			console.log(val);
			if(val=='1'){
				$('.reason').show();
				$('.remark').prop('required',true);
			}else{
				$('.reason').hide();
				$('.remark').prop('required',false);
				$('.remark').prop('checked',false);
			}
			
			});
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
	  
	   @if(Session::has("error"))
        toastr.error("{{session('message')}}")
      @endif

</script>
@endsection