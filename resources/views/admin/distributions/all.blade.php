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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
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
						<h4 class="mb-sm-0">{{"वितरण कार्यक्रम"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{"वितरण कार्यक्रम"}}</li>
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
										<h5 class="card-title mb-0">वितरण कार्यक्रमको सूची</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
											<a class="btn btn-soft-success" href="{{ route('admin.distribution.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ "वितरण थप्नुहोस्" }}
											</a>
											@if(auth()->user()->hasRole('administrator'))
											<a class="btn btn-soft-warning" href="{{route('admin.distribution.trash')}}">
												<i class="ri-delete-bin-5-line align-middle me-1"></i> रद्दीटोकरी हेर्नुहोस्
											</a>
											@endif
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
	var tols = <?php echo json_encode($tol); ?>;
	var addresses =  <?php echo json_encode($address); ?>;
	var program =  <?php echo json_encode($program); ?>;
	toastr.options = {
	  "closeButton": true,
	  "newestOnTop": true,
	  "positionClass": "toast-top-right"
	};

	  var _url = "settings";
	  @if(Session::has("message"))
		toastr.success("{{session('message')}}")
	  @endif
	  
	var distributions = $('.datatable-Distribution').DataTable( {
		processing:true,
		serverSide:true,
			ajax: {
				url :   "{!!route('admin.distribution.getalldistributions')!!}",
				data: function(d){
					d.mobile =   $('#ho-mobile').val(),
					d.citizenship = $('#ho-citizenship').val()
				}
			},
		
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'programs', name: 'programs.title_np'},
			{data: 'house_no', name: 'house_no'},
			{data: 'addresses', name: 'addresses.address_np'},
			{data: 'tols', name: 'tols.tol_np'},
			{data: 'receiver', name: 'receiver'},
			{data: 'mobile', name: 'mobile'},
			{data: 'citizenship', name: 'citizenship'},
			{data: 'registered_bs', name: 'registered_bs'},
			{data: 'received_bs', name: 'received_bs'},
			{data: 'remarks', name: 'remarks'},
			{data: 'created_at', name: 'created_at'},
			{data: 'user', name: 'user'},
			{data: 'action', name: 'action', orderable: false, searchable: false }			
		],
		initComplete: function (settings, json) {
			this.api().columns().every(function (index) {
				var column = this;
				var colDef  = settings['aoColumns'][index];
				//if(colDef.sName!='compostbin_usage'){
					if(colDef.bSearchable){
						if(colDef.data=='tols'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Tol</option>';
						$.each( tols, function( key, value ) {
						    input+='<option value="'+value.tol_np+'">'+value.tol_np+'</option>';
                        });
                        input+='</select>';
						}else if(colDef.data=='programs'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Program</option>';
							$.each( program, function( key, value ) {
								input+='<option value="'+value.title_np+'">'+value.title_np+'</option>';
							});
							input+='</select>';
						}else if(colDef.data=='addresses'){
							var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Address</option>';
							$.each( addresses, function( key, value ) {
								input+='<option value="'+value.address_np+'">'+value.address_np+'</option>';
							});
							input+='</select>';
						
						}else{
							var input = '<input class="form-control" id="ho-'+colDef.data+'" name="'+colDef.data+'">';
							
						}  
					$(input).appendTo($(column.footer()).empty()).on('change', function () {
						column.search($(this).val(), false, false, true).draw();
					});
					}
				//}
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
	
	$('#ho-mobile').change(function () {
		distributions.draw();
	});
	
	$('#ho-citizenship').change(function () {
		distributions.draw();
	});
	
</script>
@endsection