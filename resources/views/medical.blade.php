@extends('layouts.medical-web')
@section('title') {{ "Dashboard" }} @endsection
@section('styles')
<style>
    .dash-card .title{
    font-size: 14px;
    color: #3a3a3a;
    text-transform: uppercase;
}
.dash-card .data{
    padding-top: 13px;
    font-size: 32px;
    color: #0041ff;
}
.dash-card .data .progress {
    font-size: 14px;
    color: #8e8e8e;
    float: right;
    margin-top: -2px;
}
.dash-card .data .progress .icon{
        vertical-align: middle;
}
.graph-up-icon {
    background-image: url({{asset('img/Icon-Graph-Green.svg')}});
    width: 24px;
    height: 24px;
}
</style>
@endsection
@section('content')
	        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
		
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
					
						<!--content goes here-->
						<div class="col">
                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">नमस्कार, {{\Auth::user()->name}}!</h4>
                                                <p class="text-muted mb-0">आजको चिकित्सा सर्वेक्षणमा के भइरहेको छ यहाँ छ।</p>
												
												
                                            </div>
                                            <div class="mt-3 mt-lg-0">
												<div class="row g-3 mb-0 align-items-center">
													{{--<div class="col-sm-auto">
                                                            <a href="{{route('admin.products.create')}}" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Add Product</a>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                                                        </div>--}}
                                                    </div>
                                                    <!--end row-->
                                            </div>
                                        </div><!-- end card header -->
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                                <div class="row">
								
									<div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">कुल चिकित्सा सर्वेक्षण</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$totsurvey}}">0</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                                            <i class="ri-line-chart-fill text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
									
									
									
									<div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">आज सम्पन्न चिकित्सा सर्वेक्षण </p> 
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$todaysurvey}}">0</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                                            <i class="ri-line-chart-fill text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
								
									<div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">कुल जेष्ठ नागरिक</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$totalseniorcitizen}}">0</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                                            <i class="ri-user-2-line text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
									
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">कुल बच्चा ५ बर्ष तथा मुनी</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$totalchild5}}">0</span></h4>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-soft-info rounded fs-3">
                                                            <i class=" ri-user-2-line text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div> <!-- end row-->

                                <div class="row">

                                    <div class="col-xl-6">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">भर्खरको चिकित्सा सर्वेक्षणहरू</h4>
                                                <div class="flex-shrink-0">
                                                    <button type="button" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                                    </button>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
																<th>{{ '#' }}</th>
																<th>{{ 'घर नं.' }}</th>
																<th>{{ 'सडक' }}</th>
																<th>{{ 'टोल' }}</th>
																<th>{{'द्वारा प्रविष्टि'}}</th>
															</tr>
                                                        </thead>
                                                        <tbody>
															@php $i=1; @endphp
															@foreach($surveys as $key => $cbin)
																<tr data-entry-id="{{ $cbin->id }}">
																	<td>{{ $i }}</td>
																	<td>{{$cbin->house_no}}</td>
																	<td>{{$cbin->addresses->address_np}}</td>
																	<td>{{$cbin->tols->tol_np}}</td>
																	<td>{{$cbin->user->name}}</td>
																</tr>
																@php $i++;@endphp
															@endforeach
														</tbody>
                                                    </table><!-- end table -->
                                                </div>
                                            </div>
                                        </div> <!-- .card-->
                                        
                                    </div> <!-- .col-->
									
									<div class="col-xl-6">
                                        <div class="card">
                                                <div class="card-header border-bottom-dashed align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">जेष्ठ नागरिक भएको / नभएको </h4>
                                                </div><!-- end card header -->      
                                                <div class="card-body p-0 pb-2">
                                                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                                                </div>                
                                        </div>
                                    </div>
                                </div> <!-- end row-->

                            </div> <!-- end .h-100-->

                        </div> <!-- end col -->
						
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
@endsection
@section('scripts')
@parent
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">

window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
		title:{
			text: ""              
		},
		data: [              
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
			dataPoints: [
			<?php foreach($elderlyyes as $row):?>
				{ label: "छ",  y: <?= $row->totalyes;?>  },
			<?php endforeach;?>
			<?php foreach($elderlyno as $row):?>
				{ label: "छैन",  y: <?= $row->totalno;?>  },
			<?php endforeach;?>
			]
		}
		]
	});
	chart.render();
}
</script>
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