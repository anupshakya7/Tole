@extends('layouts.admin-web')
@section('title') {{ "Create User" }} @endsection
@section('content')
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{"User"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{"Create User"}}</li>
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
                                    <h5 class="card-title mb-0"> {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card-body">
						<form action="{{ route("admin.users.store") }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								<label for="name">{{ trans('cruds.user.fields.name') }}*</label>
								<input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
								@if($errors->has('name'))
									<em class="invalid-feedback">
										{{ $errors->first('name') }}
									</em>
								@endif
								<p class="helper-block">
									{{ trans('cruds.user.fields.name_helper') }}
								</p>
							</div>
							<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
								<label for="email">{{ trans('cruds.user.fields.email') }}*</label>
								<input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
								@if($errors->has('email'))
									<em class="invalid-feedback">
										{{ $errors->first('email') }}
									</em>
								@endif
								<p class="helper-block">
									{{ trans('cruds.user.fields.email_helper') }}
								</p>
							</div>
							<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
								<label for="password">{{ trans('cruds.user.fields.password') }}</label>
								<input type="password" id="password" name="password" class="form-control" required>
								@if($errors->has('password'))
									<em class="invalid-feedback">
										{{ $errors->first('password') }}
									</em>
								@endif
								<p class="helper-block">
									{{ trans('cruds.user.fields.password_helper') }}
								</p>
							</div>
							<div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
								<label for="roles">{{ trans('cruds.user.fields.roles') }}*
									<span class="btn btn-soft-warning waves-effect waves-light select-all">{{ trans('global.select_all') }}</span>
									<span class="btn btn-soft-warning waves-effect waves-light deselect-all">{{ trans('global.deselect_all') }}</span></label>
								<select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
									@foreach($roles as $id => $roles)
										<option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
									@endforeach
								</select>
								@if($errors->has('roles'))
									<em class="invalid-feedback">
										{{ $errors->first('roles') }}
									</em>
								@endif
								<p class="helper-block">
									{{ trans('cruds.user.fields.roles_helper') }}
								</p>
							</div>
							<div>
								<input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection