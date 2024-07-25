@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css"/>
<style>
.member-group {
    max-height: 530px;
    overflow: auto;
}
.members {
    max-height: 530px;
    overflow: auto;
}
.loader{
    position: absolute;
    z-index: 99999;
    content: '';
    background: rgba(0,0,0,0.54);
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
	display:none;
}
.loader-show{
	display: flex !important;
}
</style>
<div class="loader">
	<a href="javascript:void(0);" class="text-success"><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2" style="font-size:70px !important;"></i></a>
</div> 
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{"समिति"}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{$mgroup->title_np}}</li>
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
										<h5 class="card-title mb-0">{{$mgroup->title_np}}मा सदस्यहरू सेट गर्नुहोस्</h5>
									</div>
								</div>
								{{--<div class="col-sm-auto">
									<div class="d-flex flex-wrap align-items-start gap-2">
										<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
											<i class="ri-add-line align-bottom me-1"></i>  {{ "समूह थप्नुहोस्" }}</button>
									</div>
								</div>--}}
							</div>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-5">
									<div class="card">										
										<div class="card-header border-bottom-dashed">
											
											<div class="row" style="margin-bottom:15px;">
												<div class="col-12">
													<div class="app-search d-none d-md-block">
														<div class="position-relative">
															<input class="form-control" id="myInput" placeholder="Search Members..."/>
															<span class="mdi mdi-magnify search-widget-icon"></span> 
														</div>	
													</div>
												</div>
											</div>
											<div class="row g-4 align-items-center">
												<div class="col-sm">
													<div class="d-flex flex-wrap align-items-start gap-2">
														<div class="form-check checkbox">
															<input type="checkbox" class="form-check-input block_check_all" />
															<label class="form-check-label" for="formCheck6">Check All</label>
														</div>
														
													</div>
												</div>
												<div class="col-sm-auto">
													<div>
														<h5 class="card-title mb-0">सदस्यहरू</h5>
													</div>
												</div>
											</div>
										</div>
						
										<div class="card-body members">
											@foreach($members as $member)	
											<div class="row g-4 align-items-center box">
												<div class="col-sm">								
													<div class="form-check form-check-success mb-12">
														<input class="form-check-input" type="checkbox" id="formCheck6" mcitizenship="{{$member->citizenship}}" mname="{{$member->full_name}}" number="{{$member->id}}">
														<label class="form-check-label" for="formCheck6"> 
															{{$member->full_name}} ({{$member->citizenship}})
														</label>	
													</div>
												</div>
											</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="col-2" style="display: flex;align-items: center;">
									<div class="align-middle">
										<button type="button" class="btn btn-danger btn-label waves-effect waves-light removemember" groupid="{{$mgroup->id}}" style="width: 100%;margin-bottom: 8px;"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Remove</button>
										<button type="button" class="btn btn-success btn-label right waves-effect waves-light addmember" groupid="{{$mgroup->id}}" style="width: 100%;"><i class="ri-arrow-right-line label-icon align-middle fs-16 me-2"></i> Set</button>
									</div>
								</div>
								<div class="col-5">
									<div class="card">
										<div class="card-header border-bottom-dashed">
											<div class="row" style="margin-bottom:15px;">
												<div class="col-12">
													<div class="app-search d-none d-md-block">
														<div class="position-relative">
															<input class="form-control" id="myGroup" placeholder="Search Assigned Members..."/>
															<span class="mdi mdi-magnify search-widget-icon"></span>
														</div>	
													</div>
												</div>
											</div>
											<div class="row g-4 align-items-center">
												<div class="col-sm">
													<div class="d-flex flex-wrap align-items-start gap-2">
														<div class="form-check checkbox">
															<input type="checkbox" class="form-check-input group_check_all" />
															<label class="form-check-label" for="formCheck6">Check All</label>
														</div>
													</div>
												</div>
												<div class="col-sm-auto">
													<div>
														<h5 class="card-title mb-0">{{$mgroup->title_np}}</h5>
													</div>
												</div>
											</div>
										</div>
										<div class="card-body member-group">
											@if(count($membersgrp)>0)
												@foreach($membersgrp as $mem)	
												<div class="row g-4 align-items-center groupbox">
													<div class="col-sm">								
														<div class="form-check form-check-success mb-12">
															<input class="form-check-input" type="checkbox" id="formCheck6" mcitizenship="{{$mem->citizenship}}" mname="{{$mem->full_name}}" number="{{$mem->id}}">
															<label class="form-check-label" for="formCheck6"> 
																{{$mem->full_name}} ({{$mem->citizenship}})
															</label>	
														</div>
													</div>
												</div>
												@endforeach
											@endif
										</div>
									</div>
								</div>
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
<script src="{{asset('js/setgroup.js')}}"></script>
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

</script>
@endsection