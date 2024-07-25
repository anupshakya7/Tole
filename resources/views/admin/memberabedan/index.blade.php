@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
button{border:none;background-color:transparent;}thead{display:table-row-group;}tfoot{display:table-header-group;}
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
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{$pageTitle}}</li>
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
									<h5 class="card-title mb-0">{{$pageTitle}}</h5>
								</div>
							</div>
						</div>
					</div>
						
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped datatable datatable-membersabeden" style="width:100%">
								<thead>
									<tr>
										<th> {{ '#' }}</th>
										<th>{{ 'सदस्यको नाम' }}</th>
										<th>{{ 'आवेदन फारम' }}</th>
										<th>{{ 'आवेदन मिति' }}</th>
										<th>सिफारिस</th>
										<th>{{'सिर्जना मिति'}}</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th> {{ '#' }}</th>
										<th>{{ 'सदस्यको नाम' }}</th>
										<th>{{ 'आवेदन फारम' }}</th>
										<th>{{ 'आवेदन मिति' }}</th>
										<th>सिफारिस</th>
										<th>{{'सिर्जना मिति'}}</th>
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

	$('.datatable-membersabeden').DataTable( {
		processing:true,
		serverSide:true,
		ajax: "{!!route('admin.membersabeden.getmembersabedan')!!}",
		
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'members', name: 'members'},
			{data: 'abedans', name: 'abedans'},
			{data: 'abeden_date', name: 'abeden_date'},
			{data: 'sifaris', name: 'sifaris'},
			{data: 'created_at', name: 'created_at'},
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
		buttons: [
		{
			extend: 'excel',
			text: '<i class="ri-file-excel-2-fill"></i> Excel',
			titleAttr: 'Export to Excel',
			title: 'Export Members',
			exportOptions: {
				columns: ':not(:last-child)',
			}
		},
		{
			extend: 'csv',
			 text: '<i class="ri-file-text-line"></i> CSV',
			titleAttr: 'Export to Excel',
			title: 'Export Members',
			exportOptions: {
				columns: ':not(:last-child)',
			}
		},
		],
		"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		"language": 
		{          
		"processing": "<img style='width:50px; height:50px;' src='{{asset('img/ajax-loader.gif')}}' />",
		}
	} );
	
	
</script>
@endsection