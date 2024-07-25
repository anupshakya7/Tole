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
						<h4 class="mb-sm-0">{{"सन्देश"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{"सन्देश"}}</li>
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
										<h5 class="card-title mb-0">सन्देशहरूको सूची</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
											<i class="ri-add-line align-bottom me-1"></i>  {{ "सन्देश थप्नुहोस्" }}</button>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							@if(count($messages)>0)
							<div class="table-responsive table-card mb-1">
								<table class="table table-nowrap align-middle" id="orderTable">
									 <thead class="text-muted table-light">
										 <tr class="text-uppercase">
											<th>{{ '#' }}</th>
											<th>{{ 'Title' }}</th>
											<th>{{ 'Body' }}</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@php $i=1; @endphp
										@foreach($messages as $key => $message)
										<tr>
											<td>{{ $i }}</td>
											<td> {{ $message->title }}</td>
											<td> {{ $message->body }}</td>
											<td>
												<ul class="list-inline hstack gap-2 mb-0">
													<li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
														<a href="#showupdateModal" class="edit-btn" data-id="{{$message->id}}" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
															<i class="ri-pencil-fill fs-16"></i>
														</a>
													</li>
													<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
														<a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder">
															<i class="ri-delete-bin-5-fill fs-16"></i>
														</a>
													</li>
												</ul>
											</td>
										</tr>
										@php $i++;@endphp
										@endforeach
									</tbody>
								</table>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--create modal -->
	 <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel">सन्देश थप्नुहोस्</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.message.store')}}" method="post">
					@csrf
					<div class="modal-body">
						<div class="mb-3" id="modal-id">
							<label for="title" class="form-label">Title</label>
							<input type="text" name="title" class="form-control" value="" placeholder="Title" />
						</div>

						<div class="mb-3">
							<label for="customername-field" class="form-label">Message</label>
							<textarea class="form-control" name="body" rows="4" cols="50"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<div class="hstack gap-2 justify-content-end">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-soft-success" id="add-btn">सन्देश थप्नुहोस्</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--create modal ends-->
	<!--update modal -->
	 <div class="modal fade" id="showupdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel">सन्देश अपडेट गर्नुहोस्</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.message.update')}}" method="post">
					@csrf
					@method('patch')
					<div class="modal-body">
						<input type="hidden" id="msgid" name="msgid">	
						<div class="mb-3" id="modal-id">
							<label for="title" class="form-label">Title</label>
							<input type="text" id="msgtitle" name="title" class="form-control" placeholder="Title" />
						</div>

						<div class="mb-3">
							<label for="customername-field" class="form-label">Message</label>
							<textarea class="form-control" id="msg" name="body" rows="4" cols="50"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<div class="hstack gap-2 justify-content-end">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-soft-success" id="add-btn">सन्देश अपडेट गर्नुहोस्</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--create modal ends-->
</div>
@endsection
@section('scripts')
@parent
<script>
	$('.edit-btn').on('click',function(){
		
		var currRow = $(this).closest("tr");
		var currId = $(this).attr('data-id');
		var currTitle = currRow.find('td:eq(1)').text();
		var currBody = currRow.find('td:eq(2)').text();
		
		$('#msgid').val(currId);
		$('#msgtitle').val(currTitle);
		
		$('#msg').text(currBody);
	});
</script>
{{--<script>
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
</script>--}}
@endsection