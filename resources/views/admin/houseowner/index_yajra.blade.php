@php
   if(auth()->user()->hasRole('members_house')) {
      $layoutDirectory = 'layouts.membershouse-web';
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
										<h5 class="card-title mb-0">{{$pageTitle}} सूची</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										@can('users_manage')
											<a class="btn btn-soft-success" href="{{ route('admin.house.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add') }} {{ 'House Owner' }}
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
											<th>GBIN</th>
											<th>{{'करदाता नं.'}}</th>
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
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>#</th>
											<th>GBIN</th>
											<th>{{'करदाता नं.'}}</th>
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
var jobs = <?php echo json_encode($job); ?>;
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

     /*$('.datatable-Products').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'csv', 'excel', 'pdf'
		]
	} );*/
	
	var homeowners = $('.datatable-Products').DataTable( {
		processing:true,
		serverSide:true,
		//ajax: "{!!route('admin.house.getHouseowner')!!}",
		ajax: {
				url :   "{!!route('admin.house.getHouseowner')!!}",
				data: function(d){
					d.contact =   $('#ho-contact').val(),
					d.mobile =   $('#ho-mobile').val(),
					d.gender = $('#ho-gender').val(),
					d.house_no = $('#ho-house_no').val();
				}
			},
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'gbin', name: 'gbin'},
			{data: 'taxpayer_id', name: 'taxpayer_id'},
			{data: 'house_no', name: 'house_no'},
			{data: 'addresses', name: 'addresses.address_np'},
			{data: 'tols', name: 'tols.tol_np'},
			{data: 'owner', name: 'owner'},
			{data: 'contact', name: 'contact'},
			{data: 'mobile', name: 'mobile'},
			{data: 'responent', name: 'responent'},
			{data: 'job', name: 'job.occupation_np'},
			{data: 'no_of_tenants', name: 'no_of_tenants'},
			{data: 'gender', name: 'gender'},
			{ data: 'action', name: 'action', orderable: false, searchable: false }
			
		],
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
		initComplete: function (settings, json) {
			this.api().columns().every(function (index) {
				var column = this;
				var colDef  = settings['aoColumns'][index];
			//	console.log(tols);
				if(colDef.bSearchable){
				
					if(colDef.data=='tols'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Tol</option>';
						$.each( tols, function( key, value ) {
						    console.log(value);
						    		   input+='<option value="'+value.tol_np+'">'+value.tol_np+'</option>';
                        });
                        input+='</select>';

					}else if(colDef.data=='job'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Occupation</option>';
						$.each( jobs, function( key, value ) {
						    input+='<option value="'+value.occupation_np+'">'+value.occupation_np+'</option>';
                        });
                        input+='</select>';
						
					}else if(colDef.data=='addresses'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Address</option>';
						$.each( addresses, function( key, value ) {
						    input+='<option value="'+value.address_np+'">'+value.address_np+'</option>';
                        });
                        input+='</select>';
					
					}else if(colDef.data=='gender'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Gender</option><option value="0">M</option><option value="1">F</option></select>';
					}else{
						var input = '<input class="form-control" id="ho-'+colDef.data+'" name="'+colDef.data+'">';
						
					}  
					$(input).appendTo($(column.footer()).empty()).on('change', function () {
						column.search($(this).val(), false, false, true).draw();
					});
				}
			});
		},               
		"language": 
		{          
		"processing": "<img style='width:50px; height:50px;' src='{{asset('img/ajax-loader.gif')}}' />",
		}
	} );
	
	$('#ho-contact').change(function (e) {
            homeowners.draw();
        });
	$('#ho-house_no').change(function (e) {
		homeowners.draw();
	});
	$('#ho-mobile').change(function (e) {
		homeowners.draw();
	});
	$('#ho-gender').change(function (e) {
		homeowners.draw();
	});

</script>
@endsection