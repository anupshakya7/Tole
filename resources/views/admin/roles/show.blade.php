@extends('layouts.admin-web')
@section('content')
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{ "Role" }}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{ $role->name }}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header border-bottom-dashed">							
							<h5 class="card-title mb-0">{{ trans('global.show') }} {{ trans('cruds.role.title') }}</h5>
						</div>

						<div class="card-body">
							<div class="mb-2">
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<th>
												{{ trans('cruds.role.fields.id') }}
											</th>
											<td>
												{{ $role->id }}
											</td>
										</tr>
										<tr>
											<th>
												{{ trans('cruds.role.fields.title') }}
											</th>
											<td>
												{{ $role->name }}
											</td>
										</tr>
										<tr>
											<th>
												Permissions
											</th>
											<td>
												@foreach($role->permissions()->pluck('name') as $permission)
													<span class="label label-info label-many">{{ $permission }}</span>
												@endforeach
											</td>
										</tr>
									</tbody>
								</table>
								<a style="margin-top:20px;" class="btn btn-info" href="{{ url()->previous() }}">
									<i class="ri-arrow-left-line"></i> {{ trans('global.back_to_list') }}
								</a>
							</div>

							<nav class="mb-3">
								<div class="nav nav-tabs">

								</div>
							</nav>
							<div class="tab-content">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection