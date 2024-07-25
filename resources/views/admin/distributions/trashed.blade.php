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
						<h4 class="mb-sm-0">{{"रद्दीटोकरी वितरण कार्यक्रम"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{"रद्दीटोकरी वितरण कार्यक्रम"}}</li>
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
										<h5 class="card-title mb-0">रद्दीटोकरीको वितरण कार्यक्रमको सूची</h5>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table id="buttons-datatables" class="table table-striped table-hover datatable datatable-Distribution" style="width:100%">
									<thead>
										<tr>
											<th>{{ '#' }}</th>
											<th> {{ 'कार्यक्रम ' }}</th>
											<th> {{ 'घर नं. ' }}</th>
											<th>{{ 'सडक' }}</th>
											<th>{{ 'टोल' }}</th>
											<th>Receiver Name</th>
											<th>मोबाइल </th>
											<th>नागरिकता नं </th>
											<th>दर्ता मिति</th>
											<th>प्राप्त मिति</th>
											<th>टिप्पणीहरू</th>
											<th>{{'सिर्जना मिति'}}</th>
											<th>{{'प्रविष्टि द्वारा'}}</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>{{ '#' }}</th>
											<th> {{ 'कार्यक्रम ' }}</th>
											<th> {{ 'घर नं. ' }}</th>
											<th>{{ 'सडक' }}</th>
											<th>{{ 'टोल' }}</th>
											<th>Receiver Name</th>
											<th>मोबाइल </th>
											<th>नागरिकता नं </th>
											<th>दर्ता मिति</th>
											<th>प्राप्त मिति</th>
											<th>टिप्पणीहरू</th>
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
	  
	$('.datatable-Distribution').DataTable( {
		processing:true,
		serverSide:true,
		ajax: "{!!route('admin.distribution.gettrasheddistributions')!!}",
		
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'programs', name: 'programs.title_np'},
			{data: 'house_no', name: 'house_no'},
			{data: 'addresses', name: 'addresses.address_np'},
			{data: 'tols', name: 'tols.tol_np'},
			{data: 'receiver', name: 'receiver'},
			{data: 'mobile', name: 'mobile'},
			{data: 'citizenship', name: 'citizenship'},
			{data: 'registered_at', name: 'registered_at'},
			{data: 'received_at', name: 'received_at'},
			{data: 'remarks', name: 'remarks'},
			{data: 'created_at', name: 'created_at'},
			{data: 'user', name: 'user.name'},
			{data: 'action', name: 'action', orderable: false, searchable: false }			
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
		"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		"language": 
		{          
		"processing": "<img style='width:50px; height:50px;' src='{{asset('img/ajax-loader.gif')}}' />",
		}
	} );
</script>
@endsection