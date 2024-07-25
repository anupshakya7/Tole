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
									<h5 class="card-title mb-0">सदस्यहरूको सूची</h5>
								</div>
							</div>
							<div class="col-sm-auto">
								<div class="d-flex flex-wrap align-items-start gap-2">
								<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#checkMember">
											<i class="ri-search-line align-bottom me-1"></i>  {{ "सदस्यहरू जाँच गर्नुहोस्" }}</button>
												{{--@can('users_manage')
										<a class="btn btn-soft-success" href="{{ route('admin.member.create') }}">
											<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add') }} {{ 'सदस्यहरू' }}
										</a>
												@endcan--}}
								</div>
							</div>
						</div>
					</div>
						
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped datatable datatable-members" style="width:100%">
								<thead>
									<tr>
										<th> {{ '#' }}</th>
										<th>SMS</th>
										<th>{{ 'पुरा नाम' }}</th>
										<th>{{'मोबाइल नम्बर'}}</th>
										<th>{{'उमेर'}}</th>
										<th>{{ 'जन्म मिति (AD)' }}</th>
										<th>{{ 'जन्म मिति (BS)' }}</th>
										<th>{{ 'लिङ्ग' }}</th>
										<th>{{'वैवाहिक स्थिति'}}</th>
										<th>{{'नागरिकता नं.'}}</th>
										<th>{{ 'घर नं.' }}</th>
										<th>{{ 'सडक' }}</th>
										<th>{{ 'टोल' }}</th>
										<th>{{'पेशा'}}</th>
										<th>{{'रक्त समूह'}}</th>
										<th>{{'समिति'}}</th>
										<th>{{'आवेदन'}}</th>
										<th>{{'सिर्जना मिति'}}</th>
										<th>{{'प्रविष्टि द्वारा'}}</th>
										<th>Action</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th> {{ '#' }}</th>
										<th>SMS</th>
										<th>{{ 'पुरा नाम' }}</th>
										<th>{{'मोबाइल नम्बर'}}</th>
										<th>{{'उमेर'}}</th>
										<th>{{ 'जन्म मिति (AD)' }}</th>
										<th>{{ 'जन्म मिति (BS)' }}</th>										
										<th>{{ 'लिङ्ग' }}</th>
										<th>{{'वैवाहिक स्थिति'}}</th>
										<th>{{'नागरिकता नं.'}}</th>
										<th>{{ 'घर नं.' }}</th>
										<th>{{ 'सडक' }}</th>
										<th>{{ 'टोल' }}</th>
										<th>{{'पेशा'}}</th>
										<th>{{'रक्त समूह'}}</th>
										<th>{{'समिति'}}</th>
										<th>{{'आवेदन'}}</th>
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
	<!--check member modal -->
	 <div class="modal fade" id="checkMember" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel">सदस्यहरू जाँच गर्नुहोस्</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.member.check')}}" method="post">
					@csrf
					<div class="modal-body">
						<div class="mb-3" id="modal-id">
							<label for="title" class="form-label">नागरिकता नम्बर  / जन्म दर्ता नं</label>
							<input type="text" name="citizen" class="form-control" value="" placeholder="नागरिकता नम्बर  / जन्म दर्ता नं" />
						</div>
					</div>
					<div class="modal-footer">
						<div class="hstack gap-2 justify-content-end">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-soft-success" id="add-btn">जाँच गर्नुहोस्</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--create modal ends-->
	<!--add modal -->
	 <div class="modal fade" id="showAddModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel">समिति सेट गर्नुहोस्</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.membergroups.add')}}" method="post">
					@csrf
					<div class="modal-body">
					<input type="hidden" class="membersid" name="memberid">	
						<div class="mb-3" id="modal-id">
							<label for="title" class="form-label">समिति</label>
							<select class="form-control form-select groupid" name="groupid">
								@php $groups = \App\Membergroup::latest()->get();@endphp
									<option>समिति चयन गर्नुहोस्</option>
								@foreach($groups as $group)
									<option value="{{$group->id}}">{{$group->title_np}}</option>
								@endforeach								
							</select>
						</div>

						<div class="mb-3">
							<label for="customername-field" class="form-label">पद</label>
							<select class="form-control form-select memberdesignation" name="designation">
								@foreach($designations as $post)
								<option value="{{$post}}">{{$post}}</option>
								@endforeach							
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<div class="hstack gap-2 justify-content-end">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-soft-success" id="add-btn">समूह सेट गर्नुहोस्</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--create modal ends-->
	
	<!--update modal -->
	 <div class="modal fade" id="showupdateModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel">समिति अपडेट गर्नुहोस्</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.membergroups.update')}}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" class="memberid" name="memberid">	
						<input type="hidden" class="membergroup" name="groupid">	
						<div class="mb-3">
							<label for="customername-field" class="form-label">पद</label>
							<select class="form-control form-select designation" name="designation">
								<option>समूह चयन गर्नुहोस्</option>
								@foreach($designations as $post)
								<option value="{{$post}}">{{$post}}</option>
								@endforeach										
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<div class="hstack gap-2 justify-content-end">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-soft-success" id="add-btn">समिति अपडेट गर्नुहोस्</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--create modal ends-->
	
	<!--abeden modal -->
	 <div class="modal fade" id="showabeden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel">आबेदन पेश गर्नुहोस</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.abeden.add')}}" method="post">
					@csrf
					<div class="modal-body">
						<input type="hidden" class="memcitizen" name="memcitizen">		
						<div class="mb-3">
							<label for="customername-field" class="form-label">आवेदन प्रकार</label>
							@php $abedens = \App\Abeden::select('id','title')->get(); @endphp
							<select class="form-control form-select designation" name="abeden">
								<option>आवेदन चयन गर्नुहोस्</option>
								@foreach($abedens as $abeden)
								<option value="{{$abeden->id}}">{{$abeden->title}}</option>
								@endforeach										
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<div class="hstack gap-2 justify-content-end">
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-soft-success" id="add-btn">आबेदन पेश गर्नुहोस</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--abedan modal ends-->
	
	<!--send sms modal -->
	 <div class="modal fade" id="sendsms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light p-3">
					<h5 class="modal-title" id="exampleModalLabel"><i class=" ri-mail-send-line"></i> Send SMS to <span class="membername"></span>(<span class="memberno"></span>)</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
				</div>
				<form action="{{route('admin.sendsms.forward')}}" method="post">
					@csrf
					@php
						$messages = \App\TblMessage::select('title','body')->latest()->get();
					@endphp
					<div class="modal-body">
						<input type="hidden" class="des_number" name="des_number">		
						<div class="form-group">
							<select id="msg_tpl_select" name="msg_template" class="form-control form-select">
								<option value="">Select Message Template</option>
								@foreach($messages as $message)
									<option value="{{$message->body}}">{{$message->title}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<textarea class="form-control message_content required"  rows="8" maxlength="250" name="message" placeholder="Type Your Message Here ..."></textarea>
							<p class="clearfix" id="chars"></p>
						</div>
						<div class="form-group">
							<button class="btn btn-soft-success"  name="send_msg" type="submit">
								<i class="ri-mail-send-line"></i> Send SMS
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--abedan modal ends-->
	
</div>
@endsection
@section('scripts')
@parent
<script>
var tols = <?php echo json_encode($tol); ?>;
var jobs = <?php echo json_encode($job); ?>;
var addresses =  <?php echo json_encode($address); ?>;
var role = <?php if(\Auth()->user()->hasRole('administrator')): echo 1; else: echo 0; endif?>;

/*counting character in textarea*/
$(document).ready(function() {
    var $txtArea = $('.message_content');
    var $chars   = $('#chars');
    var textMax = $txtArea.attr('maxlength');
	//console.log(textMax);
    $chars.html(textMax + ' characters remaining');

    $txtArea.on('keyup', countChar);
    
    function countChar() {
        var textLength = $txtArea.val().length;
        var textRemaining = textMax - textLength;
        $chars.html(textRemaining + ' characters remaining');
    };
});

/*setting messages in textarea depending on message template selected*/
$('#msg_tpl_select').on('change',function(){
		var msg_tmp=$(this).val();
		//console.log(msg_tmp);
		$('.message_content').val(msg_tmp);
});

function sendsms(selected){
	//console.log("test");
	var memname = selected.attr('memname');
	var memnum = selected.attr('memmobile');
	$('.membername').text(memname);
	$('.memberno').text(memnum);
	$('.des_number').val(memnum);
}

function addgroup(selected){
	//var selected = $('.groupadd');
	//console.log(selected.attr('memid'));
	var memberid = selected.attr('memid');
	$('.membersid').val(memberid);
	
}

function groupupdate(selected){
	var designation = selected.attr('choice');
	var groupid = selected.attr('groupid');
	var memberid = selected.attr('memid');
	
	$('.memberid').val(memberid);
	$(".designation option[value=" + designation +"]").prop("selected", true);
	$(".membergroup").val(groupid);
	
}

function abeden(selected){
	var memcitizen = selected.attr('memcitizen');
	$('.memcitizen').val(memcitizen);
}

toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif
    var showAdminColumns =  role ==0 ? false:true;
	var members = $('.datatable-members').DataTable( {
		processing:true,
		serverSide:true,
		//ajax: "{!!route('admin.member.getmembers')!!}",
		ajax: {
				url :   "{!!route('admin.member.getmembers')!!}",
				data: function(d){
					d.martial_status =   $('#ho-martial_status').val(),
					d.gender = $('#ho-gender').val(),
					d.blood_group = $('#ho-blood_group').val(),
					d.full_name = $('#ho-full_name').val()
				}
			},
		columns:[
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{data: 'sms', name: 'sms', orderable: false, searchable: false},
			{data: 'full_name', name: 'full_name'},
			{data: 'contacts',name:'contacts.mobile_no'},
			{data: 'age', name: 'age',orderable: false, searchable: false},
			{data: 'dob_ad', name: 'dob_ad'},
			{data: 'dob_bs', name: 'dob_bs'},			
			{data: 'gender', name: 'gender'},
			{data: 'martial_status', name: 'martial_status'},
			{data: 'citizenship', name: 'citizenship'},
			{data: 'house_no', name: 'house_no'},
			{data: 'addresses', name: 'addresses.address_np'},
			{data: 'tols', name: 'tols.tol_np'},
			{data: 'job', name: 'job.occupation_np'},
			{data: 'blood_group', name: 'blood_group'},
			{data: 'groups', name: 'groups.title_np'},
			{data: 'mabedans', name: 'mabedans', orderable: false, searchable: false},
			{data: 'created_at', name: 'created_at'},
			{data: 'user',name:'user'},
			 { data:'action' , name: 'action' ,visible : showAdminColumns,orderable: false, searchable: false }
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
					
					}else if(colDef.data=='job'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Occupation</option>';
						$.each( jobs, function( key, value ) {
						    input+='<option value="'+value.occupation_np+'">'+value.occupation_np+'</option>';
                        });
                        input+='</select>';
						
					}else if(colDef.data=='gender'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Gender</option><option value="9">N/A</option><option value="1">M</option><option value="2">F</option><option value="3">O</option></select>';
					}else if(colDef.data=='martial_status'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Martial Status</option><option value="9">N/A</option><option value="1">अविवाहित</option><option value="2">विवाहित</option><option value="3">सम्बन्धविच्छेद भएको</option><option value="4">विधवा</option></select>';
					}else if(colDef.data=='blood_group'){
						var input='<select class="form-select" id="ho-'+colDef.data+'" name="'+colDef.data+'"><option value="">Select Blood Group</option><option value="A+">A+</option><option value="A-">A-</option><option value="B+">B+</option><option value="B-">B-</option><option value="O+">O+</option><option value="O-">O-</option><option value="AB+">AB+</option><option value="AB-">AB-</option><option value="Unknown">Unknown</option>';
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
	
	$('#ho-martial_status').change(function () {
		members.draw();
	});
	
	$('#ho-gender').change(function () {
		members.draw();
	});
	$('#ho-blood_group').change(function () {
		members.draw();
	});
	
	$('#ho-full_name').change(function () {
		members.draw();
	});
</script>
@endsection