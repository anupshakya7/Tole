@extends('layouts.admin-web')
@section('title','User Index')
@section('content')
<style>
	button {
		border: none;
		background-color: transparent;
	}
</style>
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
								<li class="breadcrumb-item active">{{"User"}}</li>
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
							<div class="row g-4 align-items-center">
								<div class="col-sm">
									<div>
										<h5 class="card-title mb-0">User List</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										<a class="btn btn-soft-success" href="{{ route('admin.users.create') }}">
											<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add')
											}} {{ trans('cruds.user.title_singular') }}
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped datatable-User" style="width:100%">
									<thead>
										<tr>
											<th scope="col" style="width: 10px;">

											</th>
											<th>
												{{ trans('cruds.user.fields.id') }}
											</th>
											<th>
												{{ trans('cruds.user.fields.name') }}
											</th>
											<th>
												{{ 'Status' }}
											</th>
											<th>
												{{ trans('cruds.user.fields.email') }}
											</th>
											<th>
												{{ trans('cruds.user.fields.roles') }}
											</th>
											<th>
												&nbsp;
											</th>
										</tr>
									</thead>
									<tbody>
										@foreach($users as $key => $user)
										<tr data-entry-id="{{ $user->id }}">
											<td scope="row">

											</td>
											<td>
												{{ $user->id ?? '' }}
											</td>
											<td>
												<div class="d-flex gap-2 align-items-center">
													<div class="flex-shrink-0">
														<img src="{{asset('storage/avatar-'.$user->id.'.png')}}"
															class="avatar-xs rounded-circle" alt="{{$user->name}}"
															title="{{$user->name}}">
													</div>
													<div class="flex-grow-1">
														{{ $user->name ?? '' }}
													</div>
												</div>
											</td>
											<td>

												{{--<form action="{{ route('users.users_change', $user->id) }}"
													method="POST">
													<label class="switch">
														<input type="checkbox" {{ $user->status=="on" ? "checked" : ''
														}}>
														<span class="slider round"></span>
													</label>
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="submit" class="btn btn-xs btn-danger"
														value="{{ trans('global.delete') }}">
												</form>--}}
												<div class="form-check form-switch form-switch-success">
													<input class="form-check-input statuschng" data-id="{{$user->id}}"
														type="checkbox" role="switch" {{ $user->status=="1" ? "checked"
													: "" }}>
												</div>
												{{--<label class="switch">
													<input class="statuschng" data-id="{{$user->id}}" type="checkbox" {{
														$user->status=="1" ? "checked" : "" }}>
													<span class="slider round"></span>
												</label>--}}
											</td>
											<td>
												{{ $user->email ?? '' }}
											</td>
											<td>
												@foreach($user->roles()->pluck('name') as $role)
												<span class="badge badge-soft-info">{{ $role }}</span>
												@endforeach
											</td>
											<td>
												@if(auth()->user()->name=='Admin' && $user->id!=1)
												<a class="link-warning fs-15"
													href="{{ route('admin.impersonate', $user->id) }}">
													<i class="mdi mdi-account-lock-open"></i>
												</a>
												@endif
												<a class="link-success fs-15"
													href="{{ route('admin.users.show', $user->id) }}">
													<i class="ri-eye-line"></i>
												</a>

												<a class="link-info fs-15"
													href="{{ route('admin.users.edit', $user->id) }}">
													<i class="ri-edit-2-line"></i>
												</a>

												<form action="{{ route('admin.users.destroy', $user->id) }}"
													method="POST"
													onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
													style="display: inline-block;">
													<input type="hidden" name="_method" value="DELETE">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<button type="submit" class="link-danger fs-15" value="Submit"><i
															class="ri-delete-bin-5-line"></i></button>
												</form>

											</td>

										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@parent
<script>
	toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };


    $(".statuschng").on("change",function(){
        //var value = $(this).checked ? 'on':'off';
        var status = $(this).prop('checked') == true ? 1 : 0; 
		console.log(status);
        var id = $(this).data('id'); 
		$.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            type: "POST",
            dataType: "json",
            url: '{{route("admin.users_change")}}',
            data: {'status': status, 'id': id},
            success: function(data){
              //console.log(data.success)
              toastr.success(data.success);
              setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 3000); 
            }
        }); 
        
    });

    $('.datatable-User').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'csv', 'excel', 'pdf'
		]
	} );

</script>
@endsection