@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">कार्यक्रम</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ 'कार्यक्रम सम्पादन'}}</li>
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
							<h5 class="card-title mb-0">{{ 'कार्यक्रम सम्पादन' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.program.update',$program->id) }}" method="POST">
								@csrf
								@method('patch')
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-md-6 form-group {{ $errors->has('title_en') ? 'has-error' : '' }}">
												<label for="title_en"><span class="fi fi-us fis"></span> {{ 'Title' }}*</label>
												<input type="text" name="title_en" class="form-control" value="{{ old('title_en', isset($program) ? $program->title_en : '') }}" required>
												@if($errors->has('title_en'))
													<em class="invalid-feedback">
														{{ $errors->first('title_en') }}
													</em>
												@endif
											</div>

											<div class="col-md-6 form-group {{ $errors->has('title_np') ? 'has-error' : '' }}">
												<label for="title_np"><span class="fi fi-np fis"></span> {{ 'कार्यक्रम' }}</label>
												<input type="text" id="title_np" name="title_np" class="form-control" value="{{ old('title_np', isset($program) ? $program->title_np : '') }}">
												@if($errors->has('title_np'))
													<em class="invalid-feedback">
														{{ $errors->first('title_np') }}
													</em>
												@endif
											</div>
											
											<div class="col-md-6 form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
												<label for="quantity"><span class="fi fi-np fis"></span> {{ 'मात्रा' }}</label>
												<input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', isset($program) ? $program->quantity : '') }}">
												@if($errors->has('quantity'))
													<em class="invalid-feedback">
														{{ $errors->first('quantity') }}
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