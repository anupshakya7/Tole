@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>.sms-contacts{max-height: 630px;overflow: auto;}form label{padding:8px 0px;}#chars{padding: 10px 10px;position: relative;top: -35px;font-size:12px;font-style:italic;}</style> 
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{"SMS"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{"SMS"}}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-5">
					<div class="card">
						<div class="card-header border-bottom-dashed">
							<div class="row g-4 align-items-center">
								<div class="col-sm">
									<div class="d-flex flex-wrap align-items-start gap-2">
											<a class="btn btn-soft-success add-contacts" href="#">
												<i class="ri-add-circle-line align-middle me-1"></i> {{ "SMS पठाउन सम्पर्कहरू थप्नुहोस्" }} <span class="total"></span>
											</a>
									</div>
								</div>
								<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										<div class="form-check checkbox">
											<input type="checkbox" class="form-check-input block_check_all" />
											<label class="form-check-label" for="formCheck6">Check All</label>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body sms-contacts">
						
							<div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-success" id="accordionBordered">
								<div class="accordion-item">
									<h2 class="accordion-header" id="accordionborderedMember">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_member" aria-expanded="true" aria-controls="accor_borderedExamplecollapse1">
											सदस्य
										</button>
									</h2>
									<div id="accor_member" class="accordion-collapse collapse" aria-labelledby="accordionborderedMember" data-bs-parent="#accordionBordered">
										<div class="accordion-body">
											<div class="checkbox"><label><input type="checkbox" class="form-check-input member_check_all">Check All</label></div>
											@foreach($members as $member)	
											<div class="row g-4 align-items-center box">
												<div class="col-sm">								
													<div class="form-check form-check-success mb-12">
														<input class="form-check-input" type="checkbox" id="formCheck6" number="{{$member->mobile_no}}">
														<label class="form-check-label" for="formCheck6"> 
															{{$member->full_name}}
														</label>
													</div>
												</div>
												<div class="col-sm-auto">
													<div class="d-flex flex-wrap align-items-start gap-2">
														<span>{{$member->mobile_no}}</span>									
													</div>
												</div>
											</div>
											@endforeach
										</div>
									</div>
								</div>
								
								<div class="accordion-item">
									<h2 class="accordion-header" id="accordionborderedMember">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_senior" aria-expanded="true" aria-controls="accor_borderedExamplecollapse1">
											जेष्ठ नागरिक
										</button>
									</h2>
									<div id="accor_senior" class="accordion-collapse collapse" aria-labelledby="accordionborderedMember" data-bs-parent="#accordionBordered">
										<div class="accordion-body">
											<div class="checkbox"><label><input type="checkbox" class="form-check-input senior_check_all">Check All</label></div>
											@foreach($members as $member)	
											@php if($member->dob_ad!='N/A'): $dob = \Carbon\Carbon::parse($member->dob_ad);endif; @endphp
										
											@if($dob->diffInYears(now()) >= 68)
											<div class="row g-4 align-items-center box">
												<div class="col-sm">								
													<div class="form-check form-check-success mb-12">
														<input class="form-check-input" type="checkbox" id="formCheck6" number="{{$member->mobile_no}}">
														<label class="form-check-label" for="formCheck6"> 
															{{$member->full_name}}
														</label>
													</div>
												</div>
												<div class="col-sm-auto">
													<div class="d-flex flex-wrap align-items-start gap-2">
														<span>{{$member->mobile_no}}</span>									
													</div>
												</div>
											</div>
											@endif
											@endforeach
										</div>
									</div>
								</div>							
								
								
								<div class="accordion-item">
									<h2 class="accordion-header" id="accordionborderedOwner">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_owner" aria-expanded="true" aria-controls="accor_borderedExamplecollapse1">
											घर धनि
										</button>
									</h2>
									<div id="accor_owner" class="accordion-collapse collapse" aria-labelledby="accordionborderedOwner" data-bs-parent="#accordionBordered">
										<div class="accordion-body">
											<div class="checkbox"><label><input type="checkbox" class="form-check-input owner_check_all">Check All</label></div>
											@foreach($houseowners as $owners)
												@if(strlen($owners->mobile)==10)		
												<div class="row g-4 align-items-center box">
													<div class="col-sm">								
														<div class="form-check form-check-success mb-12">
															<input class="form-check-input" type="checkbox" id="formCheck7" number="{{$owners->mobile}}">
															<label class="form-check-label" for="formCheck7"> 
																{{$owners->owner}}({{$owners->house_no}})
															</label>
														</div>
													</div>
													<div class="col-sm-auto">
														<div class="d-flex flex-wrap align-items-start gap-2">
															<span>{{$owners->mobile}}</span>									
														</div>
													</div>
												</div>
												@endif
											@endforeach
										</div>
									</div>
								</div>
								
								<div class="accordion-item">
									<h2 class="accordion-header" id="accordionborderedOwner">
										<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_businesshouse" aria-expanded="true" aria-controls="accor_borderedExamplecollapse1">
											व्यवसायिक घर
										</button>
									</h2>
									<div id="accor_businesshouse" class="accordion-collapse collapse" aria-labelledby="accordionborderedOwner" data-bs-parent="#accordionBordered">
										<div class="accordion-body">
											<div class="checkbox"><label><input type="checkbox" class="form-check-input business_check_all">Check All</label></div>
											@foreach($businesshouse as $business)
												@if(strlen($business->contact)==10)		
												<div class="row g-4 align-items-center box">
													<div class="col-sm">								
														<div class="form-check form-check-success mb-12">
															<input class="form-check-input" type="checkbox" id="formCheck7" number="{{$business->contact}}">
															<label class="form-check-label" for="formCheck7"> 
																{{$business->business_name}}({{$business->house_no}})
															</label>
														</div>
													</div>
													<div class="col-sm-auto">
														<div class="d-flex flex-wrap align-items-start gap-2">
															<span>{{$business->contact}}</span>									
														</div>
													</div>
												</div>
												@endif
											@endforeach
										</div>
									</div>
								</div>
							</div>
							
							
						</div>
					</div>
				</div>
				<!--form to send sms-->
				<div class="col-7">
					<div class="card">
						<div class="card-header border-bottom-dashed">
							<div class="row g-4 align-items-center">
								<div class="col-sm">
									<div>
										<h5 class="card-title mb-0"><i class="ri-mail-send-line"></i> Compose SMS</h5>
									</div>
								</div>
								<div class="col-sm-auto">
									<div>
										<blockquote class="blockquote custom-blockquote blockquote-outline blockquote-{{$balance<100 ? 'warning': 'success'}} rounded mb-0">
											<h5 class="card-title mb-0" style="font-size:11px;"><span><?php  if($balance=="500"): echo "N/A"; else: echo "Total Credit: रु. ".$balance; endif;//var_dump($respons);// ?></span></h5>
										</blockquote>
										{{--<h5 class="card-title mb-0" style="font-size:12px;text-decoration:underline"><span>Total Balance: {{"रु. ".$balance}}</span></h5>--}}
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							<!--SMS Form-->
							<form id="send_msg" method="post" action="{{route('admin.sendsms.forward')}}" enctype="multipart/form-data">
								@csrf
								<div class="box-body"> 
									<div class="form-group">
										<label>Sender Number:</label>
										<select name="sender_number" class="form-control form-select">
											   <option value="Ward 1">Ward 1</option>
										</select>
									</div>
									<div class="form-group">
										<label>To:<small>(Enter Numbers with comma separated only!!!)</small></label>
										<textarea id="destination_content" name="des_number" class="form-control" minlength="10" style="height:100px"></textarea>
									</div>
									<div class="form-group">
										<label>Message Templates:</label>
										<select id="msg_tpl_select" name="msg_template" class="form-control form-select">
											<option value="">Select Message Template</option>
											@foreach($messages as $message)
												<option value="{{$message->body}}">{{$message->title}}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label>Message Type:</label>
										<input type="radio" name="text_type" value='text' class="iradio_minimal-red checked" checked=checked><label>Text</label><!--<input type="radio" name="text_type" value="unicode" class="iradio_minimal-red"><label>Unicode(Nepali Language)</label></div>-->
										<div class="form-group">
											<textarea class="form-control message_content required"  rows="8" maxlength="250" name="message" placeholder="Type Your Message Here ..."></textarea>
											<p class="clearfix" id="chars"></p>
										</div>
									</div>
									<div class="box-footer">
										<div class="form-group">
											<button class="btn btn-soft-success"  name="send_msg" type="submit">
											<i class="ri-mail-send-line"></i> Send Message
											</button>
										</div>
									</div>
								</div>
							</form>
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
<script src="{{asset('js/sms.js')}}"></script>
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
	   @if(Session::has("error"))
        toastr.error("{{session('error')}}")
      @endif
	  
	/*$('.datatable-Program').DataTable( {
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
	} );*/
</script>
@endsection