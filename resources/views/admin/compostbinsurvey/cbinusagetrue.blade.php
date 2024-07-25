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
										<h5 class="card-title mb-0">{{$pageTitle}}</h5>
									</div>
								</div>
								{{--<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										@can('users_manage')
											<a class="btn btn-soft-success" href="{{ route('admin.cbinsurvey.create') }}">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add') }} {{ 'Compostbin Survey data' }}
											</a>
										@endcan
									</div>
								</div>--}}
							</div>
						</div>	
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped datatable-Products" style="width:100%">
									<thead>
										<tr>
											<th>#</th>
											<th>{{ 'घर नं.' }}</th>
											<th>निरीक्षण</th>
											<th>{{ 'घर धनि' }}</th>
											<th>{{'सम्पर्क'}}</th>
											
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th>{{ 'घर नं.' }}</th>
											<th>निरीक्षण</th>
											<th>{{ 'घर धनि' }}</th>
											<th>{{'सम्पर्क'}}</th>
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
	
	<!--inspection modal -->
	 <div class="modal fade" id="showinspection" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel">निरीक्षण पेश गर्नुहोस</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.sinspection.store')}}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" class="survey_id" name="survey_id">	
						<input type="hidden" class="house_no" name="house_no">							
						<div class="mb-3">
							<label for="slug">{{ 'कम्पोस्टबिन प्रयोग' }}</label><br>
													
							<label for="usage" class="radio-inline">
								<input class="form-check-input" type="radio" name="usage" id="usage" value="0" checked required>
								{{ 'छ' }}
							</label>
							
							<label for="usage" class="radio-inline">
								<input class="form-check-input" type="radio" name="usage" id="usage" value="1" > 
								{{ 'छैन ' }}
							</label>
						</div>
						<div class="mb-3">
							<label for="customername-field" class="form-label">महिनामा कति पटक कम्पोस्ट उत्पादन हुन्छ</label>
							<select class="form-control form-select designation" name="production_interval">
								<option>महिना चयन गर्नुहोस्</option>
								@for($mnth=1;$mnth<=12;$mnth++)
								<option value="{{$mnth}}">{{$mnth}}</option>
								@endfor
							</select>
						</div>
						<div class="mb-3">
							<label for="slug">{{ 'EM वा द्रुत कम्पोस्टिङ सामग्रीको प्रयोग' }}</label><br>
													
							<label for="compostbin_usage1" class="radio-inline">
								<input class="form-check-input" type="radio" name="fast_decaying_usage" id="fast_decaying_usage" value="0" checked required>
								{{ 'छ' }}
							</label>
							
							<label for="compostbin_usage2" class="radio-inline">
								<input class="form-check-input" type="radio" name="fast_decaying_usage" id="fast_decaying_usage" value="1" > 
								{{ 'छैन ' }}
							</label>
						</div>
						<div class="mb-3">
							<label for="customername-field" class="form-label">अहिलेसम्म कति उत्पादन भएको छ? (KG)</label>
							<input type="number" class="form-control" name="production">
						</div>
						<div class="mb-3">
							<label for="customername-field" class="form-label">उत्पादन स्थिति</label>
							<select type="text" class="form-control form-select" name="production_status">
								<option>उत्पादन स्थिति चयन गर्नुहोस्</option>
								<option value="अभाव">अभाव</option>
								<option value="अत्यधिक">अत्यधिक</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="customername-field" class="form-label">उत्पादन गर्दाको समस्या</label>
							<select type="text" class="form-control form-select" name="issues">
								<option>उत्पादन गर्दाको समस्या चयन गर्नुहोस्</option>
								<option value="छैन">छैन</option>
								<option value="धेरै समय लिने">धेरै समय लिने</option>
								<option value="गनाउने">गनाउने</option>
								<option value="सडिरहेको">सडिरहेको</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="customername-field" class="form-label">टिप्पणीहरू</label>
							<textarea class="form-control" name="remarks"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<div class="hstack gap-2 justify-content-end">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-soft-success" id="add-btn">निरीक्षण पेश गर्नुहोस</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--inspection modal ends-->
	
	<!--inspection modal -->
	 <div class="modal fade bs-example-lg" id="showinspectedcbin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="inspectionlabel">निरीक्षण पेश गर्नुहोस</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<table id="inspectedbinid" class="table">
								<thead>
									<th>प्रयोग</th>
									<th>उत्पादन अन्तराल</th>
									<th>EM वा द्रुत कम्पोस्टिङ सामग्रीको प्रयोग</th>
									<th>कम्पोष्ट उत्पादन (KG)</th>
									<th>उत्पादन  स्थिति</th>
									<th>उत्पादन गर्दाको समस्या</th>
									<th>टिप्पणीहरू</th>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--inspection modal ends-->
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

     var table = $('.datatable-Products').DataTable( {
		processing:true,
		serverSide:true,
		ajax: "{!!route('admin.cbinsurvey.getCompostbintrue')!!}",
		
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'house_no', name: 'house_no'},
			{data:'inspection',name:'inspection', orderable: false, searchable: false},
			{data: 'owner', name: 'owner'},
			{data: 'contact', name: 'contact'}	
		],
		initComplete: function (settings, json) {
			this.api().columns().every(function (index) {
				var column = this;
				var colDef  = settings['aoColumns'][index];
				//if(colDef.sName!='compostbin_usage'){
					if(colDef.bSearchable){
						var input = '<input class="form-control">';
						$(input).appendTo($(column.footer()).empty())
						 .on('change', function () {
							column.search($(this).val(), false, false, true).draw();
						});
					}
				//}
			});
		},
		"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		"language": 
		{          
		"processing": "<img style='width:50px; height:50px;' src='{{asset('img/ajax-loader.gif')}}' />",
		}
	} );
	
	function inspection(selected){
		var surveyid = selected.attr('cbinid');
		var houseno = selected.attr('houseno');
		
		console.log(surveyid,houseno);
		$('.survey_id').val(surveyid);
		$('.house_no').val(houseno);
	}
	
	function inspectioncbin(selected){
		var houseno = selected.attr('houseno');
		var headertitle = "घर नम्बर "+houseno+" को कम्पोस्टबिन निरीक्षण विवरण";
		console.log(headertitle);
		$('#inspectionlabel').text(headertitle);
		$.ajax({
				type:'get',
				url:"{{route('admin.sinspection.getinspectiondetail')}}?houseno="+houseno,
				success: function(res){
					console.log(res);
					$('#inspectedbinid tbody').append(res);
					
				},error:function(){
					console.log('Unable to currently process data!!');
				}
			});
	}

</script>
@endsection