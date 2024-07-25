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
										<h5 class="card-title mb-0">{{'कम्पोस्टबिन सर्वेक्षण सूची'}}</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										@can('users_manage')
											<a class="btn btn-soft-success" href="{{ route('admin.cbinsurvey.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add') }} {{ 'Compostbin Survey data' }}
											</a>
										@endcan
									</div>
								</div>
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
											<th>{{ 'सडक' }}</th>
											<th>{{ 'टोल' }}</th>
											<th>{{ 'घर धनि' }}</th>
											<th>{{'सम्पर्क'}}</th>
											<th>{{ 'कम्पोस्टबिन प्रयोग' }}</th>
											<th>{{ 'कम्पोस्टबिनको स्रोत' }}</th>
											<th>{{'फोहोर बर्गिकरण'}}</th>
											<th>{{'प्रयोग नगर्नुको कारण'}}</th>
											<th>{{'घरको तला'}}</th>
											<th>{{'भान्छा संख्या'}}</th>
											<th>{{'बसोबास गर्ने मानिसहरू'}}</th>
											<th>{{'टिप्पणीहरू'}}</th>
											<th>{{'सिर्जना मिति'}}</th>
											<th>{{'प्रविष्टि द्वारा'}}</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										@php $i=1; @endphp
										@foreach($cbinsurvey as $key => $cbin)
											<tr data-entry-id="{{ $cbin->id }}">
												<td> </td>
												<td>{{ $i }}</td>
												<td>{{$cbin->house_no}}</td>
												<td>{{$cbin->addresses->address_np}}</td>
												<td>{{$cbin->tols->tol_np}}</td>
												<td>{{$cbin->owner ?? '-'}}</td>
												<td>{{$cbin->contact ?? '-'}}</td>
												<td>{{$cbin->compostbin_usage == 0 ? 'छ' : 'छैन'}}</td>
												<td>{{$cbin->compostbin_source ?? '-'}}</td>
												<td>
													@if(is_null($cbin->compostbin_seperated))
														{{'-'}}
													@else
														{{$cbin->compostbin_seperated == 0 ? 'छ' : 'छैन'}}
													@endif
												</td>
												<td>{{$cbin->reason ?? '-'}}</td>
												<td>{{$cbin->house_storey}}</td>
												<td>{{$cbin->no_kitchen}}</td>
												<td>{{$cbin->total_people}}</td>
												<td>{{$cbin->remarks ? $cbin->remarks : '-'}}</td>
												<td>{{$cbin->created_at->diffForHumans()}}</td>
												<td>{{$cbin->user->name}}</td>
												
												<td>
													<a class="link-info fs-15" href="{{ route('admin.cbinsurvey.edit', $cbin->id) }}">
														<i class="ri-edit-2-line"></i>
													</a>
													@if(auth()->user()->hasRole('administrator'))
													<form action="{{ route('admin.cbinsurvey.destroy', $cbin->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
														<input type="hidden" name="_method" value="DELETE">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<button type="submit" class="link-danger fs-15" value="Submit"><i class="ri-delete-bin-5-line"></i></button>
													</form>
													@endif
												</td>
												
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