@extends('layouts.admin-web')
@section('title') {{ "Occupation" }} @endsection
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
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
						<h4 class="mb-sm-0">{{"Occupation"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{"Occupation"}}</li>
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
										<h5 class="card-title mb-0">Occupation List</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
											<a class="btn btn-soft-success" href="{{ route('admin.occupation.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ "Add Occupation" }}
											</a>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table id="buttons-datatables" class="table table-striped table-hover datatable datatable-Role" style="width:100%">
									<thead>
										<tr>
											<th>{{ '#' }}</th>
											<th><span class="fi fi-us fis"></span> {{ 'Occupation' }}</th>
											<th><span class="fi fi-np fis"></span> {{ 'Occupation' }}</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
										@php $i=1; @endphp
										@php 
											//$nepalidate = Bsdate::eng_to_nep(2023,01,01);
											//$bs = $nepalidate['year'].'/'.$nepalidate['month'].'/'.$nepalidate['date'];
											//var_dump($bs);	
										@endphp
										@foreach($occupation as $key => $data)
											
											<tr data-entry-id="{{ $data->id }}">
												<td>{{$i}}</td>
												<td>
													{{ $data->occupation ? $data->occupation : '-' }}
												</td>
												<td>
													{{ $data->occupation_np ? $data->occupation_np : '-' }}
												</td>
												<td>
													<a class="link-info fs-15" href="{{ route('admin.occupation.edit', $data->id) }}">
														<i class="ri-edit-2-line"></i>
													</a>

													<form action="{{ route('admin.occupation.destroy', $data->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
														<input type="hidden" name="_method" value="DELETE">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<button type="submit" class="link-danger fs-15" value="Submit"><i class="ri-delete-bin-5-line"></i></button>
													</form>
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
	
	$('.datatable-Role').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'csv', 'excel', 'pdf'
    ]
} );

</script>
@endsection