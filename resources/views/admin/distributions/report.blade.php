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
@php 
	/*distribution according to address*/	
	$arrlocation = array();
	$arraydistribution = array();

	foreach($distaddress as $data){
		array_push($arrlocation,$data->location);
		array_push($arraydistribution,$data->distribution);		
	}
	
	$location = json_encode($arrlocation);//implode(", ",$arrlocation);
	
	$distributionlist = implode(", ",$arraydistribution);	
	
	/*distribution according to tol*/	
	$arrtol = array();
	$arrdistribution = array();

	foreach($disttol as $data){
		array_push($arrtol,$data->tolname);
		array_push($arrdistribution,$data->distribution);		
	}
	
	$tols = json_encode($arrtol);
	$distlists = implode(", ",$arrdistribution);	
	//var_dump($tols);die();
@endphp

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
											{{--<h4 class="fs-16 mb-1"> ड्यासबोर्ड</h4>--}}
												<p class="text-muted mb-0">{{$program->title_np}} सम्बन्धि रिपोर्ट।</p>
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
								
									<div class="col-3">
										<!-- card -->
										<div class="card card-animate">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1 overflow-hidden">
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{$program->title_np.' वितरणको कुल संख्या'}}</p> 
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$program->quantity}}">0</span></h4>
													</div>
													<div class="avatar-sm flex-shrink-0">
														<span class="avatar-title bg-soft-info rounded fs-3">
															<i class="ri-numbers-line text-warning"></i>
														</span>
													</div>
												</div>
											</div><!-- end card body -->
										</div><!-- end card -->
									</div><!-- end col -->
								
									<div class="col-3">
										<!-- card -->
										<div class="card card-animate">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1 overflow-hidden">
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">वितरण गरिएको {{$program->title_np}}को कुल संख्या</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$received}}">0</span></h4>
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
									
									<div class="col-3">
										<!-- card -->
										<div class="card card-animate">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1 overflow-hidden">
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{$program->title_np.' वितरणको लागि दर्ता भएका कुल संख्या'}}</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$registered}}">0</span></h4>
													</div>
													<div class="avatar-sm flex-shrink-0">
														<span class="avatar-title bg-soft-info rounded fs-3">
															<i class="ri-numbers-line text-danger"></i>
														</span>
													</div>
												</div>
											</div><!-- end card body -->
										</div><!-- end card -->
									</div><!-- end col -->
									
									<div class="col-3">
										<!-- card -->
										<div class="card card-animate">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1 overflow-hidden">
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ "आजको कुल " .$program->title_np." वितरण"}}</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$todaydist->today_dist}}">0</span></h4>
													</div>
													<div class="avatar-sm flex-shrink-0">
														<span class="avatar-title bg-soft-info rounded fs-3">
															<i class="ri-numbers-line text-info"></i>
														</span>
													</div>
												</div>
											</div><!-- end card body -->
										</div><!-- end card -->
									</div><!-- end col -->
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">स्थान अनुसार {{$program->title_np}} वितरण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="roadwisedistribution" style="width:100%;"></div>
												</div>                
										</div>
									</div>									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">टोल अनुसार {{$program->title_np}} वितरण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="tolwisedistribution" style="width:100%;"></div>
												</div>                
										</div>
									</div>

										
									
								</div> <!-- end row-->

								{{--<div class="row">	
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="tolsurvey" style="width:100%;"></div>
												</div>                
										</div>
									</div>									
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="locationsurvey" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-12">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">मिति अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="datewisesurvey" style="width:100%;"></div>
												</div>                
										</div>
									</div>	
									
									<div class="col-6">
										 <div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">कम्पोस्टबिनको प्रयोग गरेको / नगरेको स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="locationusageContainer" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-6">
										 <div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">कम्पोस्टबिनको प्रयोग गरेको / नगरेको टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="tolusageContainer" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
								</div>--}} <!-- end row-->
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
	/*distribution done according to address*/
	Highcharts.chart('roadwisedistribution', {

		chart: {
			type: 'column'
		},

		title: {
			text: ''
		},
		credits: {
			enabled: false
		},

		xAxis: {
			categories: <?= $location;?>,
			title:{text:'स्थान'}
		},

		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: 'कुल वितरण'
			}
		},
		legend: {
			align: 'right',
			x: -30,
			verticalAlign: 'top',
			y: 25,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			borderColor: '#CCC',
			borderWidth: 1,
			shadow: false
		},
		tooltip: {
			 headerFormat: '<b>{point.x}</b><br/>',
			pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
		},
		colors: [
				'#D4EDDA',	
				'#F8D7DA',						
				],

		plotOptions: {
			column: {
				stacking: 'normal',
				 dataLabels: {
					enabled: true,
					color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
				}
			}
		},

		series: [{
			name: 'कुल संख्या',		
			data: [<?= $distributionlist;?>],
		}]
	});
	
	/*distribution done according to tol*/
	Highcharts.chart('tolwisedistribution', {

		chart: {
			type: 'column'
		},

		title: {
			text: ''
		},
		credits: {
			enabled: false
		},

		xAxis: {
			categories: <?= $tols;?>,
			title:{text:'टोल'}
		},

		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: 'कुल वितरण'
			}
		},
		legend: {
			align: 'right',
			x: -30,
			verticalAlign: 'top',
			y: 25,
			floating: true,
			backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			borderColor: '#CCC',
			borderWidth: 1,
			shadow: false
		},
		tooltip: {
			 headerFormat: '<b>{point.x}</b><br/>',
			pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
		},
		colors: [
				'#D4EDDA',	
				'#F8D7DA',						
				],

		plotOptions: {
			column: {
				stacking: 'normal',
				 dataLabels: {
					enabled: true,
					color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
				}
			}
		},

		series: [{
			name: 'कुल संख्या',		
			data: [<?= $distlists;?>],
		}]
	});
</script>

@endsection