@extends('layouts.admin-web')
@section('title','User View')
@section('content')
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{ "User" }}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ $user->name }}</li>
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
							<h5 class="card-title mb-0">{{ trans('global.show') }} {{ trans('cruds.user.title') }}</h5>
						</div>	
						<div class="card-body">
							<div class="mb-2">
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<th>
												{{ trans('cruds.user.fields.id') }}
											</th>
											<td>
												{{ $user->id }}
											</td>
										</tr>
										<tr>
											<th>
												{{ trans('cruds.user.fields.name') }}
											</th>
											<td>
												{{ $user->name }}
											</td>
										</tr>
										<tr>
											<th>
												{{ trans('cruds.user.fields.email') }}
											</th>
											<td>
												{{ $user->email }}
											</td>
										</tr>
										<tr>
											<th>
												Roles
											</th>
											<td>
												@foreach($user->roles()->pluck('name') as $role)
													<span class="label label-info label-many">{{ $role }}</span>
												@endforeach
											</td>
										</tr>
									</tbody>
								</table>
								<a style="margin-top:20px;" class="btn btn-info" href="{{ url()->previous() }}">
									<i class="ri-arrow-left-line"></i> {{ trans('global.back_to_list') }}
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection