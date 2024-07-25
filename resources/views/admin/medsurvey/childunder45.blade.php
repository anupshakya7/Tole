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
									<h5 class="card-title mb-0">45 दिन मुनिको बच्चाको सूची</h5>
								</div>
							</div>
							{{--<div class="col-sm-auto">
								<div class="d-flex flex-wrap align-items-start gap-2">
									@can('users_manage')
										<a class="btn btn-soft-success" href="{{ route('admin.medsurvey.create') }}">
											<i class="ri-add-circle-line align-middle me-1"></i>  {{ 'मेडिकल सर्वेक्षण थप्नुहोस्' }}
										</a>
									@endcan
								</div>
							</div>--}}
						</div>
					</div>
						
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped datatable datatable-medsurvey" style="width:100%">
								<thead>
									<tr>
										<th> {{ '#' }}</th>
										<th>{{ 'सम्बन्धित व्यक्ति' }}</th>
										<th>{{ 'सम्बन्धित व्यक्तिको मोबाइल' }}</th>
										<th>{{ 'घर नं.' }}</th>
										<th>{{ 'सडक' }}</th>
										<th>{{ 'टोल' }}</th>
										<th>{{'५ वर्ष मूनिका बच्चा'}}</th>
										<th>{{'जेष्ठ नागरिक'}}</th>
										<th>{{'नसर्ने तथा दीर्घरोग सम्बन्धि समस्या'}}</th>
										<th>{{'सिर्जना मिति'}}</th>
										<th>{{'प्रविष्टि द्वारा'}}</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th> {{ '#' }}</th>
										<th>{{ 'सम्बन्धित व्यक्ति' }}</th>
										<th>{{ 'सम्बन्धित व्यक्तिको मोबाइल' }}</th>
										<th>{{ 'घर नं.' }}</th>
										<th>{{ 'सडक' }}</th>
										<th>{{ 'टोल' }}</th>
										<th>{{'५ वर्ष मूनिका बच्चा'}}</th>
										<th>{{'जेष्ठ नागरिक'}}</th>
										<th>{{'नसर्ने तथा दीर्घरोग सम्बन्धि समस्या'}}</th>
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
				url :   "{!!route('admin.medsurvey.getchildunder45')!!}",
				data: function(d){
					d.under_five_child =   $('#ho-under_five_child').val(),
					d.elderly_exist = $('#ho-elderly_exist').val(),
					d.chronic_disease = $('#ho-chronic_disease').val(),
					d.concerned_person = $('#ho-concerned_person').val(),
					d.concerned_contact = $('#ho-concerned_contact').val()
				}
			},
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'concerned_person', name: 'concerned_person'},
			{data: 'concerned_contact',name:'concerned_contact'},
			{data: 'house_no', name: 'house_no'},
			{data: 'addresses', name: 'addresses.address_np'},
			{data: 'tols', name: 'tols.tol_np'},
			{data: 'under_five_child', name: 'under_five_child'},
			{data: 'elderly_exist', name: 'elderly_exist'},
			{data: 'chronic_disease', name: 'chronic_disease'},
			{data: 'created_at', name: 'created_at'},
			{data: 'user', name: 'user'}			
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
					
					}else if(colDef.data=='under_five_child'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select</option><option value="1">छ</option><option value="2">छैन</option></select>';
					}else if(colDef.data=='elderly_exist'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select</option><option value="1">छ</option><option value="2">छैन</option></select>';
					}else if(colDef.data=='chronic_disease'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select</option><option value="1">छ</option><option value="2">छैन</option></select>';
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
