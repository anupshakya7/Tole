@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
.form-group{margin-bottom:5px;}#chars{padding: 10px 10px;position: relative;top: -35px;font-size:12px;font-style:italic;}button{border:none;background-color:transparent;}thead{display:table-row-group;}tfoot{display:table-header-group;}
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
									<h5 class="card-title mb-0">६८ वर्षभन्दा माथि वा सोभन्दा माथिका ज्येष्ठ नागरिकहरू</h5>
								</div>
							</div>
						</div>
					</div>
						
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped datatable datatable-medsurvey" style="width:100%">
								<thead>
									<tr>
										<th> {{ '#' }}</th>
										<th>{{ 'पुरा नाम' }}</th>
										<th>{{'मोबाइल नम्बर'}}</th>
										<th>{{'उमेर'}}</th>
										<th>{{ 'घर नं.' }}</th>
										<th>{{ 'सडक' }}</th>
										<th>{{ 'टोल' }}</th>
										<th>{{ 'लिङ्ग' }}</th>
										<th>{{'वैवाहिक स्थिति'}}</th>
										<th>{{'नागरिकता नं.'}}</th>
										<th>{{'सिर्जना मिति'}}</th>
										<th>{{'प्रविष्टि द्वारा'}}</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th> {{ '#' }}</th>
										<th>{{ 'पुरा नाम' }}</th>
										<th>{{'मोबाइल नम्बर'}}</th>
										<th>{{'उमेर'}}</th>
										<th>{{ 'घर नं.' }}</th>
										<th>{{ 'सडक' }}</th>
										<th>{{ 'टोल' }}</th>
										<th>{{ 'लिङ्ग' }}</th>
										<th>{{'वैवाहिक स्थिति'}}</th>
										<th>{{'नागरिकता नं.'}}</th>
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

	var medsurvey = $('.datatable-medsurvey').DataTable( {
		processing:true,
		serverSide:true,
		//ajax: "{!!route('admin.member.getmembers')!!}",
		ajax: {
				url :   "{!!route('admin.medsurvey.getseniorabove68')!!}",
				data: function(d){
					d.martial_status =   $('#ho-martial_status').val(),
					d.gender = $('#ho-gender').val(),
					d.blood_group = $('#ho-blood_group').val(),
					d.full_name = $('#ho-full_name').val()
				}
			},
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'full_name', name: 'member.full_name'},
			{data: 'contacts',name:'member.contacts.mobile_no'},
			{data: 'age',name:'age'},			
			{data: 'house', name: 'member.house_no'},
			{data: 'addresses', name: 'member.addresses.address_np'},
			{data: 'tols', name: 'member.tols.tol_np'},
			{data: 'gender', name: 'member.gender'},
			{data: 'martial_status', name: 'member.martial_status'},
			{data: 'citizenship', name: 'member.citizenship'},
			{data: 'created_at', name: 'created_at'},
			{data: 'user', name: 'user.name'}			
		],
		initComplete: function (settings, json) {
			this.api().columns().every(function (index) {
				var column = this;
				var colDef  = settings['aoColumns'][index];
				if(colDef.bSearchable){
					if(colDef.data=='tols'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Tol</option>';
						$.each( tols, function( key, value ) {
						    input+='<option value="'+value.tol_np+'">'+value.tol_np+'</option>';
                        });
                        input+='</select>';

					}else if(colDef.data=='addresses'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Address</option>';
						$.each( addresses, function( key, value ) {
						    input+='<option value="'+value.address_np+'" data="'+value.id+'">'+value.address_np+'</option>';
                        });
                        input+='</select>';
					
					}else{
						var input = '<input class="form-control" id="ho-'+colDef.data+'" name="'+colDef.data+'">';
						
					}  
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
			title: 'Export Medical Survey',
			exportOptions: {
				columns: ':not(:last-child)',
			}
		},
		{
			extend: 'csv',
			 text: '<i class="ri-file-text-line"></i> CSV',
			titleAttr: 'Export to Excel',
			title: 'Export Medical Survey',
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
	
	$('#ho-under_five_child').change(function () {
		medsurvey.draw();
	});
	
	$('#ho-elderly_exist').change(function () {
		medsurvey.draw();
	});
	
	$('#ho-chronic_disease').change(function () {
		medsurvey.draw();
	});
	
	$('#ho-concerned_person').change(function () {
		medsurvey.draw();
	});
	
	$('#ho-concerned_contact').change(function () {
		medsurvey.draw();
	});
</script>
@endsection
