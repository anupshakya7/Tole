@php
   if(auth()->user()->hasRole('surveyer')) {
      $layoutDirectory = 'layouts.surveyer-web';
   } else {
      $layoutDirectory = 'layouts.admin-web';
   }
@endphp


@extends($layoutDirectory)
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
button{border:none;background-color:transparent;}
</style>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{$pageTitle}}</h4>
						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{$pageTitle}}</li>
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
										<h5 class="card-title mb-0">{{$pageTitle}}</h5>
									</div>
								</div>
								{{--<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										@can('users_manage')
											<a class="btn btn-soft-success" href="{{ route('admin.cbinsurvey.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add') }} {{ 'Compostbin Survey data' }}
											</a>
										@endcan
									</div>
								</div>--}}
							</div>
						</div>	
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped datatable-Products" style="width:100%">
									<thead>
										<tr>
											<th width="10"></th>
											<th>{{ '#' }}</th>
											<th>{{ 'घर नं.' }}</th>
											<th>{{ 'घर धनि' }}</th>
											<th>{{'सम्पर्क'}}</th>
											<th>{{ 'सडक' }}</th>
											<th>{{ 'टोल' }}</th>
										</tr>
									</thead>
									<tbody>
										@php $i=1; @endphp
										@foreach($excluding as $key => $cbin)
											<tr data-entry-id="{{ $cbin->id }}">
												<td> </td>
												<td>{{ $i }}</td>
												<td>{{$cbin->house_no}}</td>
												<td>{{$cbin->owner ?? '-'}}</td>
												<td>{{$cbin->contact ?? '-'}}</td>	
												<td>{{$cbin->address_np}}</td>	
												<td>{{$cbin->tol_np}}</td>	
											</tr>
											@php $i++;@endphp
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

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif

     $('.datatable-Products').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'csv', 'excel', 'print'
		]
	} );

</script>
@endsection