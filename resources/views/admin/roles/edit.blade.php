@extends('layouts.admin-web')
@section('title') {{ "Edit Role" }} @endsection
@section('content')
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{"Role"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{"Edit Role"}}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="card">
					<div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0"> {{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="card-body">
						<form action="{{ route("admin.roles.update", [$role->id]) }}" method="POST" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								<label for="name">{{ trans('cruds.role.fields.title') }}*</label>
								<input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($role) ? $role->name : '') }}" required>
								@if($errors->has('name'))
									<em class="invalid-feedback">
										{{ $errors->first('name') }}
									</em>
								@endif
								<p class="helper-block">
									{{ trans('cruds.role.fields.title_helper') }}
								</p>
							</div>
							<div class="form-group {{ $errors->has('permission') ? 'has-error' : '' }}">
								<label for="permission">{{ trans('cruds.role.fields.permissions') }}*
									<span class="btn btn-soft-success waves-effect waves-effect select-all">{{ trans('global.select_all') }}</span>
									<span class="btn btn-soft-warning waves-effect waves-effect deselect-all">{{ trans('global.deselect_all') }}</span></label>
									<select name="permission[]" id="permission" class="form-control select2" multiple="multiple" required>
										@foreach($permissions as $id => $permissions)
											<option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || isset($role) && $role->permissions()->pluck('name', 'id')->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
										@endforeach
									</select>
								@if($errors->has('permission'))
									<em class="invalid-feedback">
										{{ $errors->first('permission') }}
									</em>
								@endif
								<p class="helper-block">
									{{ trans('cruds.role.fields.permissions_helper') }}
								</p>
							</div>
							<div>
								<button class="btn btn-success" type="submit" id="uploadButton">
									<i class="ri-save-line"></i> Save
								</button>  
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection