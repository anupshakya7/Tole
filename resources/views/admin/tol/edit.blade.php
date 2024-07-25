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
						<h4 class="mb-sm-0">टोल</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ 'Edit Tol'}}</li>
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
							<h5 class="card-title mb-0">{{ 'Edit Tol' }}</h5>
						</div>

						<div class="card-body">
							<form action="{{ route('admin.tol.update',$tol->id) }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('patch')
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-md-6 form-group {{ $errors->has('address') ? 'has-error' : '' }}">
												<label for="tol"><span class="fi fi-us fis"></span> {{ 'Tol' }}*</label>
												<input type="text" name="tol" class="form-control" value="{{ old('tol', isset($tol) ? $tol->tol : '') }}" required>
												@if($errors->has('address'))
													<em class="invalid-feedback">
														{{ $errors->first('address') }}
													</em>
												@endif
											</div>

											<div class="col-md-6 form-group {{ $errors->has('tol_np') ? 'has-error' : '' }}">
												<label for="tol_np"><span class="fi fi-np fis"></span> {{ 'टोल' }}</label>
												<input type="text" id="tol_np" name="tol_np" class="form-control" value="{{ old('tol_np', isset($tol) ? $tol->tol_np : '') }}">
												@if($errors->has('tol_np'))
													<em class="invalid-feedback">
														{{ $errors->first('tol_np') }}
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
<script>
	var inputEl = nepalify.interceptElementById("tol_np");
	
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