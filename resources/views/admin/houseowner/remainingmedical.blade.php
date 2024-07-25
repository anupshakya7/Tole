@extends('layouts.admin-web')
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
										<h5 class="card-title mb-0">{{$pageTitle}}को सूची</h5>
									</div>
								</div>
							</div>
						</div>	
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped datatable-Products" style="width:100%">
									<thead>
										<tr>
											<th>{{ '#' }}</th>
											<th>GBIN</th>
											<th>{{ 'घर नं.' }}</th>
											<th>{{ 'सडक' }}</th>
											<th>{{ 'टोल' }}</th>
											<th>{{ 'घर धनि' }}</th>
											<th>{{ 'सम्पर्क' }}</th>
											<th>{{ 'मोबाइल' }}</th>
											<th>{{'प्रतिवादी नाम'}}</th>
											<th>{{'पेशा'}}</th>
											<th>{{'भाडामा बस्नेहरुको संख्या'}}</th>
											<th>{{'लिङ्ग'}}</th>
											<!--<th>&nbsp;</th>-->	
										</tr>
									</thead>
									<tbody>
										@php $i=1; @endphp
										@foreach($arrdata as $key => $house)
										<?php if($house!=NULL):?> 
											<tr data-entry-id="{{ $house->id }}">
												<td>{{ $i }}</td>
												<td>{{$house->gbin}}</td>
												<td>{{$house->house_no}}</td>
												<td>{{$house->addresses->address_np}}</td>
												<td>{{$house->tols->tol_np}}</td>
												<td>{{$house->owner ?? '-'}}</td>
												<td>{{$house->contact ?? '-'}}</td>
												<td>{{$house->mobile ?? '-'}}</td>
												<td>{{$house->respondent ?? '-'}}</td>
												<td>{{ $house->job->occupation_np ?? '-' }}
												</td>
												<td>{{$house->no_of_tenants ?? '-'}}</td>
												<td>{{$house->gender!=NULL ? ($house->gender==0 ? "M" : "F") : '-'}}</td>
													{{--<td>
													<a class="link-info fs-15" href="{{ route('admin.house.edit', $house->id) }}">
														<i class="ri-edit-2-line"></i>
													</a>
													<form action="{{ route('admin.house.destroy', $house->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
														<input type="hidden" name="_method" value="DELETE">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<button type="submit" class="link-danger fs-15" value="Submit"><i class="ri-delete-bin-5-line"></i></button>
													</form>
												</td>--}}
											</tr>
										<?php endif;?>
											
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
			'csv', 'excel', 'pdf'
		]
	} );

</script>
@endsection