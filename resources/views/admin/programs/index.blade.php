@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
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
						<h4 class="mb-sm-0">{{"कार्यक्रम"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{"कार्यक्रम"}}</li>
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
										<h5 class="card-title mb-0">कार्यक्रम सूची</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
											<a class="btn btn-soft-success" href="{{ route('admin.program.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ "कार्यक्रम थप्नुहोस्" }}
											</a>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table id="buttons-datatables" class="table table-striped table-hover datatable datatable-Program" style="width:100%">
									<thead>
										<tr>
											<th>{{ '#' }}</th>
											<th><span class="fi fi-us fis"></span> {{ 'Title' }}</th>
											<th><span class="fi fi-np fis"></span> {{ 'शीर्षक' }}</th>
											<th>{{'सिर्जना मिति'}}</th>
											<th>{{'प्रविष्टि द्वारा'}}</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>{{ '#' }}</th>
											<th><span class="fi fi-us fis"></span> {{ 'Title' }}</th>
											<th><span class="fi fi-np fis"></span> {{ 'शीर्षक' }}</th>
											<th>{{'सिर्जना मिति'}}</th>
											<th>{{'प्रविष्टि द्वारा'}}</th>
											<th>Action</th>
										</tr>
									</tfoot>
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
	  
	$('.datatable-Program').DataTable( {
		processing:true,
		serverSide:true,
		ajax: "{!!route('admin.program.getprograms')!!}",
		
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'title_en', name: 'title_en'},
			{data: 'title_np', name: 'title_np'},
			{data: 'created_at', name: 'created_at'},
			{data: 'user', name: 'user.name'},
			{ data: 'action', name: 'action', orderable: false, searchable: false }			
		],
		initComplete: function (settings, json) {
			this.api().columns().every(function (index) {
				var column = this;
				var colDef  = settings['aoColumns'][index];
				if(colDef.bSearchable){
					var input = '<input class="form-control">';
					$(input).appendTo($(column.footer()).empty())
					 .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
				}
			});
		},
		dom: 'Blfrtip',
		buttons: ['csv','excel'],
		"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		"language": 
		{          
		"processing": "<img style='width:50px; height:50px;' src='{{asset('img/ajax-loader.gif')}}' />",
		}
	} );
</script>
@endsection