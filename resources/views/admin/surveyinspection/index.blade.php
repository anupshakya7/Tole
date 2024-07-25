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
											<a class="btn btn-soft-success" href="{{ route('admin.sinspection.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ 'कम्पोस्टबिन निरीक्षण थप्नुहोस्' }}
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
											<th>#</th>
											<th>{{ 'घर नं.' }}</th>
											<th>{{ 'सडक' }}</th>
											<th>{{ 'टोल' }}</th>
											<th>{{ 'कम्पोस्टबिन प्रयोग' }}</th>
											<th>{{'कौसी खेति'}}</th>
											<th>{{'द्रुत विघटन सामग्री प्रयोग'}}</th>
											<th>{{ 'कम्पोस्ट उत्पादन भएको / नभएको' }}</th>
											<th>{{ 'उत्पादन अन्तराल' }}</th>
											<th>{{'उत्पादन मात्रा'}}</th>
											<th>{{'समस्याहरू'}}</th>
											<th>{{'टिप्पणीहरू'}}</th>
											<th>{{'सिर्जना मिति'}}</th>
											<th>{{'प्रविष्टि द्वारा'}}</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th>{{ 'घर नं.' }}</th>
											<th>{{ 'सडक' }}</th>
											<th>{{ 'टोल' }}</th>
											<th>{{ 'कम्पोस्टबिन प्रयोग' }}</th>
											<th>{{'कौसी खेति'}}</th>
											<th>{{'द्रुत विघटन सामग्री प्रयोग'}}</th>
											<th>{{ 'कम्पोस्ट उत्पादन भएको / नभएको' }}</th>
											<th>{{ 'उत्पादन अन्तराल' }}</th>
											<th>{{'उत्पादन मात्रा'}}</th>
											<th>{{'समस्याहरू'}}</th>
											<th>{{'टिप्पणीहरू'}}</th>
											<th>{{'सिर्जना मिति'}}</th>
											<th>{{'प्रविष्टि द्वारा'}}</th>
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
	toastr.options = {
	  "closeButton": true,
	  "newestOnTop": true,
	  "positionClass": "toast-top-right"
	};

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif

     var table = $('.datatable-Products').DataTable( {
		processing:true,
		serverSide:true,
		ajax: "{!!route('admin.sinspection.getinspectiondetail')!!}",
		
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'house_no', name: 'house_no'},
			{data: 'addresses', name: 'addresses.address_np'},
			{data: 'tols', name: 'tols.tol_np'},
			{data: 'usage', name: 'usage'},
			{data: 'roof_farming', name: 'roof_farming'},
			{data: 'production_status', name: 'production_status'},
			{data: 'fast_decaying_usage', name: 'fast_decaying_usage'},
			{data: 'compost_production_interval', name: 'compost_production_interval'},
			{data: 'compost_production', name: 'compost_production'},
			{data: 'issues', name: 'issues'},
			{data: 'remarks', name: 'remarks'},
			{data: 'created_at', name: 'created_at'},
			{data: 'user', name: 'user'}		
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
						    console.log(value);
						    		   input+='<option value="'+value.tol_np+'">'+value.tol_np+'</option>';
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
	
	/*$('.compostusage').change(function(){
		table.column($(this).data('column'))
		.search($(this).val(), false, false, true)
		.draw();
	});*/

</script>
@endsection