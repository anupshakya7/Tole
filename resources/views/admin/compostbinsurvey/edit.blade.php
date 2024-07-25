@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
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
								<li class="breadcrumb-item active">{{'Update '.$pageTitle}}</li>
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
							<h5 class="card-title mb-0">{{ 'Update Compostbin Survey data' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.cbinsurvey.update',$compost->id) }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('patch')
								<div class="row">
									<div class="col-6 form-group {{ $errors->has('house_no') ? 'has-error' : '' }}">
										<label for="name">{{ 'घर नं.' }}*</label>
										<input type="text" id="title" name="house_no" class="form-control" value="{{ old('house_no', isset($compost) ? $compost->house_no : '') }}" required>
										@if($errors->has('title'))
											<em class="invalid-feedback">
												{{ $errors->first('house_no') }}
											</em>
										@endif
									</div>

									<div class="col-6 form-group {{ $errors->has('owner') ? 'has-error' : '' }}">
										<label for="owner">{{ 'घर धनि' }}</label>
										<input type="text" id="owner" name="owner" class="form-control" value="{{ old('owner', isset($compost) ? $compost->owner : '') }}" required>
										@if($errors->has('owner'))
											<em class="invalid-feedback">
												{{ $errors->first('owner') }}
											</em>
										@endif
									</div>

									<div class="col-6 form-group {{ $errors->has('road') ? 'has-error' : '' }}">
										<label for="road">{{ 'सडक नाम' }}</label>
										<select name="road" class="form-control" required>
											<option>{{'सडक चयन गर्नुहोस्'}}</option>
											@foreach($address as $data)
											<option value='{{$data->id}}' {{$data->id==$compost->road ? 'selected' : ''}}>{{$data->address_np}}</option>
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
											<option value='{{$data->id}}' {{$data->id==$compost->tol ? 'selected' : ''}}>{{$data->tol_np}}</option>
											@endforeach
										</select>
										@if($errors->has('tol'))
											<em class="invalid-feedback">
												{{ $errors->first('tol') }}
											</em>
										@endif
									</div>

									<div class="col-6 form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
										<label for="contact">{{ 'घर धनिको नम्बर' }}</label>
										<input type="text" id="contact" maxlength="10" name="contact" class="form-control" value="{{ old('contact', isset($compost) ? $compost->contact : '') }}" required>
										@if($errors->has('contact'))
											<em class="invalid-feedback">
												{{ $errors->first('contact') }}
											</em>
										@endif
									</div>
									
									<div class="col-6 form-group {{ $errors->has('respondent_no') ? 'has-error' : '' }}">
										<label for="respondent_no">{{ 'अर्को नं' }}</label>
										<input type="text" id="respondent_no" maxlength="10" minlength="10" name="respondent_no" class="form-control" value="{{ old('respondent_no', isset($compost) ? $compost->respondent_no : '') }}" required>
										@if($errors->has('respondent_no'))
											<em class="invalid-feedback">
												{{ $errors->first('respondent_no') }}
											</em>
										@endif
									</div>

									<div class="col-6 form-group {{ $errors->has('house_storey') ? 'has-error' : '' }}">
										<label for="house_storey">{{ 'घरको तला' }}</label>
										<input type="number" id="slug" name="house_storey" class="form-control" value="{{ old('house_storey', isset($compost) ? $compost->house_storey : '') }}" required>
										@if($errors->has('house_storey'))
											<em class="invalid-feedback">
												{{ $errors->first('house_storey') }}
											</em>
										@endif
									</div>

									<div class="col-6 form-group {{ $errors->has('no_kitchen') ? 'has-error' : '' }}">
										<label for="no_kitchen">{{ 'भान्छाको संख्या' }}</label>
										<input type="number" id="slug" name="no_kitchen" class="form-control" value="{{ old('no_kitchen', isset($compost) ? $compost->no_kitchen : '') }}" required>
										@if($errors->has('no_kitchen'))
											<em class="invalid-feedback">
												{{ $errors->first('no_kitchen') }}
											</em>
										@endif
									</div>

									<div class="col-6 form-group {{ $errors->has('total_people') ? 'has-error' : '' }}">
										<label for="total_people">{{ 'कुल बसोबास गर्ने मानिसहरू' }}</label>
										<input type="number" id="slug" name="total_people" class="form-control" value="{{ old('total_people', isset($compost) ? $compost->total_people : '') }}" required>
										@if($errors->has('total_people'))
											<em class="invalid-feedback">
												{{ $errors->first('total_people') }}
											</em>
										@endif
									</div>
									<div class="col-6 form-group form-check {{ $errors->has('remarks') ? 'has-error' : '' }}">
										<label for="total_people">{{ 'टिप्पणीहरू(Remarks)'}}</label>
										 <textarea class="form-control" name="remarks" rows="4" cols="50">{{ old('remarks', isset($compost) ? $compost->remarks : '') }}</textarea>  <br>
										@if($errors->has('remarks'))
											<div class="invalid-feedback">
												{{ $errors->first('remarks') }}
											</div>
										@endif
									</div>
									<div class="col-6 form-group {{ $errors->has('compostbin_usage') ? 'has-error' : '' }}" style="padding:20px;">
										<label for="slug">{{ 'कम्पोस्टबिन प्रयोग' }}</label><br>
													
										<label for="slug" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_usage" id="formradioRight5" value="0" {{ $compost->compostbin_usage=="0" ? "checked" : ""}}>
												{{ 'छ' }}
											</label>
											
											<label for="slug" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_usage" id="formradioRight5" value="1" {{ $compost->compostbin_usage=="1" ? "checked" : ""}}> 
												{{ 'छैन ' }}
											</label>

										{{--<input type="text" id="slug" name="compostbin_usage" class="form-control" value="{{ old('compostbin_usage') }}" required>--}}
										@if($errors->has('compostbin_usage'))
											<em class="invalid-feedback">
												{{ $errors->first('compostbin_usage') }}
											</em>
										@endif
									</div>
									
									<div class="col-6 form-group {{ $errors->has('compostbin_source') ? 'has-error' : '' }}" style="padding:20px;">
										<label for="slug">{{ 'कम्पोस्टबिनको स्रोत' }}</label><br>
													
											<label for="slug" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_source" id="formradioRight5" value="व्यक्तिगत" {{ $compost->compostbin_source=="व्यक्तिगत" ? "checked" : ""}}>
												{{ 'व्यक्तिगत' }}
											</label>
											
											<label for="slug" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_source" id="formradioRight5" value="वडा" {{ $compost->compostbin_source=="वडा" ? "checked" : ""}}> 
												{{ 'वडा ' }}
											</label>

											<label for="slug" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_source" id="formradioRight5" value="उपलब्ध छैन" {{ $compost->compostbin_source=="उपलब्ध छैन" ? "checked" : ""}}> 
												{{ 'उपलब्ध छैन ' }}
											</label>

										{{--<input type="text" id="slug" name="compostbin_source" class="form-control" value="{{ old('compostbin_usage') }}" required>--}}
										@if($errors->has('compostbin_source'))
											<em class="invalid-feedback">
												{{ $errors->first('compostbin_source') }}
											</em>
										@endif
									</div>

									<div class="col-6 seperated form-group {{ $errors->has('compostbin_seperated') ? 'has-error' : '' }}" >
										<label for="slug">{{ 'फोहोर बर्गिकरण' }}</label><br>
											
											<label for="slug" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_seperated" id="formradioRight5" value="0" {{ $compost->compostbin_seperated=="0" ? "checked" : ""}}> 
												{{ 'छ' }}
											</label>

											<label for="slug" class="radio-inline">
												<input class="form-check-input" type="radio" name="compostbin_seperated" id="formradioRight5" value="1" {{ $compost->compostbin_seperated=="1" ? "checked" : ""}}>
												{{ 'छैन ' }}
											</label>
										{{--<input type="text" id="slug" name="compostbin_seperated" class="form-control" value="{{ old('compostbin_usage') }}" required>--}}
										@if($errors->has('compostbin_seperated'))
											<em class="invalid-feedback">
												{{ $errors->first('compostbin_seperated') }}
											</em>
										@endif
									</div>

									<div class="col-6 reason form-group {{ $errors->has('reason') ? 'has-error' : '' }}" style="margin-top:15px;padding:20px;">
										<label for="slug">{{ 'नगर्नुको कारण' }}</label><br>
											
											<label for="slug" class="radio-inline">
												<input class="form-check-input remark" type="radio" name="reason" id="formradioRight5" value="समय को आभाब" {{ $compost->reason=="समय को आभाब" ? "checked" : ""}}> 
												{{ 'समय को आभाब' }}
											</label>

											<label for="slug" class="radio-inline">
												<input class="form-check-input remark" type="radio" name="reason" id="formradioRight5" value="ठाउँको अभाव" {{ $compost->reason=="ठाउँको अभाव" ? "checked" : ""}}>
												{{ 'ठाउँको अभाव ' }}
											</label>

											<label for="slug" class="radio-inline">
												<input class="form-check-input remark" type="radio" name="reason" id="formradioRight5" value="अन्य" {{ $compost->reason=="अन्य" ? "checked" : ""}}>
												{{ 'अन्य' }}
											</label>
										{{--<input type="text" id="slug" name="reason" class="form-control" value="{{ old('compostbin_usage') }}" required>--}}
										@if($errors->has('reason'))
											<em class="invalid-feedback">
												{{ $errors->first('reason') }}
											</em>
										@endif
									</div>					

									<div class="col-12 text-end">
										<button class="btn btn-success" type="submit" id="uploadButton">
											<i class="ri-save-line"></i> Update
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://unpkg.com/nepalify@0.5.0/umd/nepalify.production.min.js"></script>
<script>		
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