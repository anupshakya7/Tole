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
						<h4 class="mb-sm-0">{{ $pageTitle }}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{ $pageTitle }}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
					{{--<div class="card-header border-bottom-dashed">
							<div class="row g-4 align-items-center">
								<div class="col-sm">
									<div>
										<h5 class="card-title mb-0">सहभागीहरूको सूची</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
											<a class="btn btn-soft-success" href="{{ route('admin.participants.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ "सहभागीहरू थप्नुहोस्" }}
											</a>
									</div>
								</div>
							</div>
						</div>--}}

						<div class="card-body">
							<div class="table-responsive">
								<table id="buttons-datatables" class="table table-striped table-hover datatable datatable-Program" style="width:100%">
									<thead>
										<tr>
											<th>{{ '#' }}</th>
											<th> {{ 'कार्यक्रम' }}</th>
											<th>{{'सहभागी'}}</th>
											<th>{{'दर्ता मिति'}}</th>
											<th>{{'दान मिति'}}</th>
											<th>{{'प्रमाणपत्र प्राप्त मिति'}}</th>
											<th>{{'रक्त समूह कार्ड प्राप्त मिति'}}</th>											
											<th>{{'विगत दान मिति'}}</th>
											<th>{{'सिर्जना मिति'}}</th>
											<th>{{'प्रविष्टि द्वारा'}}</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>{{ '#' }}</th>
											<th> {{ 'कार्यक्रम' }}</th>
											<th>{{'सहभागी'}}</th>
											<th>{{'दर्ता मिति'}}</th>
											<th>{{'दान मिति'}}</th>
											<th>{{'प्रमाणपत्र प्राप्त मिति'}}</th>											
											<th>{{'रक्त समूह कार्ड प्राप्त मिति'}}</th>
											<th>{{'विगत दान मिति'}}</th>
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
		ajax: "{!!route('admin.eventparticipants.geteventparticipants')!!}",
		
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'events', name: 'events.title'},
			{data: 'participants', name: 'participants.full_name'},
			{data: 'registered_at', name: 'registered_at'},
			{data: 'donated_at', name: 'donated_at'},
			{data: 'cert_received_at', name: 'cert_received_at'},
			{data: 'blood_grp_card_received_at', name: 'blood_grp_card_received_at'},
			{data: 'previous_donation_at', name: 'previous_donation_at'},
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