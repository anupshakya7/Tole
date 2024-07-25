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
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header border-bottom-dashed">							
							<h5 class="card-title mb-0">{{ trans('global.show') }} {{ trans('cruds.permission.title') }}</h5>
						</div>

						<div class="card-body">
							<div class="mb-2">
								<table class="table table-bordered table-striped">
									<tbody>
										<tr>
											<th>
												{{ trans('cruds.permission.fields.id') }}
											</th>
											<td>
												{{ $permission->id }}
											</td>
										</tr>
										<tr>
											<th>
												{{ trans('cruds.permission.fields.title') }}
											</th>
											<td>
												{{ $permission->name }}
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