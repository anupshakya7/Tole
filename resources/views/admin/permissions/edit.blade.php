@extends('layouts.admin-web')
@section('content')
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{ "Permission" }}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ $permission->name }}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-md--12">
					<div class="card">
						<div class="card-header">
							{{ trans('global.edit') }} {{ trans('cruds.permission.title_singular') }}
						</div>

						<div class="card-body">
							<form action="{{ route("admin.permissions.update", [$permission->id]) }}" method="POST" enctype="multipart/form-data">
								@csrf
								@method('PUT')
								<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
									<label for="name">{{ trans('cruds.permission.fields.title') }}*</label>
									<input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($permission) ? $permission->name : '') }}" required>
									@if($errors->has('name'))
										<em class="invalid-feedback">
											{{ $errors->first('name') }}
										</em>
									@endif
									<p class="helper-block">
										{{ trans('cruds.permission.fields.title_helper') }}
									</p>
								</div>
								<div>
									<button class="btn btn-success" type="submit">
										<i class="ri-download-line"></i> {{ trans('global.save') }}
									</button> 
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