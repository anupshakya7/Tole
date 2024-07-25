@extends('layouts.admin-web')
@section('title','Change Password')
@section('content')
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{ "Password" }}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ "change password" }}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title mb-0">Change password ({{\Auth::user()->name}})</h5>
						</div>
						<div class="card-body">
							<form action="{{ route('auth.change_password') }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('PATCH')
								<div class="mb-3 form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
									<label class="form-label" for="current_password">Current password *</label>
									<input type="password" id="current_password" name="current_password" class="form-control" required>
									@if($errors->has('current_password'))
										<em class="invalid-feedback">
											{{ $errors->first('current_password') }}
										</em>
									@endif
								</div>
								<div class="mb-3 form-group {{ $errors->has('new_password') ? 'has-error' : '' }}">
									<label class="form-label" for="new_password">New password *</label>
									<input type="password" id="new_password" name="new_password" class="form-control" required>
									@if($errors->has('new_password'))
										<em class="invalid-feedback">
											{{ $errors->first('new_password') }}
										</em>
									@endif
								</div>
								<div class="mb-3 form-group {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
									<label class="form-label" for="new_password_confirmation">New password confirmation *</label>
									<input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
									@if($errors->has('new_password_confirmation'))
										<em class="invalid-feedback">
											{{ $errors->first('new_password_confirmation') }}
										</em>
									@endif
								</div>
								<div class="text-end">
									<input class="btn btn-success" type="submit" value="{{ trans('global.save') }}">
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