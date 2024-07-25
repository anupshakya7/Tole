@extends('layouts.admin-web')
@section('title') {{ "Dashboard" }} @endsection

@section('content')
@php 
	$arrayuname = array();
	
	foreach($users as $data){
		array_push($arrayuname,"'".$data->name."'");
	
	}
	$merge = implode(", ",$arrayuname);
	$merge1 = implode(", ",$arrayyes);
	$merge2 = implode(", ",$arrayno);
	
	/*survey according to address*/	
	$arrlocation = array();
	$arraysurveys = array();

	foreach($suaddress as $data){
		array_push($arrlocation,"'".$data->location."'");
		array_push($arraysurveys,$data->surveys);		
	}
	
	$location = implode(", ",$arrlocation);
	$surveylist = implode(", ",$arraysurveys);	
	
	/*survey according to date*/
	$arrdate = array();
	$arrdatetotal = array();
	foreach($surveybydate as $data){
		$date = Carbon::parse($data->created_at)->format('M d Y').'( '.Carbon::parse($data->created_at)->isoFormat('dddd').' )';
		array_push($arrdate,"'".$date."'");
		array_push($arrdatetotal,$data->total);
	}
		
	$datewise = implode(", ",$arrdate);
	$datewisetotal = implode(", ",$arrdatetotal); 
	
	
	/*survey according to location usage*/
	$yeslocation = implode(", ", $addressyes);
	$nolocation = implode(", ", $addressno);
	
	/*survey according to tol*/
	$arrtol = array();$arrtolsur = array();
	foreach($surveytol as $data){
		array_push($arrtol,$data->tolname);
		array_push($arrtolsur,$data->surveys);
	}
	
	/*survey according to usage tol*/
	$yestol = implode(", ", $tolyess);
	$notol = implode(", ", $tolnoo);
	
	$artol = json_encode($arrtol);
	$tolsurvey = implode(", ",$arrtolsur);
	
	/*survey according to users*/
	$labelchart = array();
	$datachart = array(); 
		
	foreach($compbinbyuser as $data){
		$user = \App\User::where('id',$data->user_id)->first();
		array_push($labelchart,$user->name);
		array_push($datachart,$data->survey_done);		
	}
	
	$alluser = json_encode($labelchart);//implode(", ",$labelchart);
	$allsurvey = implode(", ",$datachart);
	
	/*survey according to users by today*/
	$todaylabelchart = array();
	$todaydatachart = array(); 
	foreach($compbinbyusertoday as $tuser)
	{
		$user = \App\User::where('id',$tuser->user_id)->first();
		array_push($todaylabelchart,$user->name);
		array_push($todaydatachart,$tuser->survey_done);
	}
	
	$todayuser = json_encode($todaylabelchart);
	$todaychart = implode(", ",$todaydatachart);	
	
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
												<h4 class="fs-16 mb-1">कम्पोस्टबिन ड्यासबोर्ड</h4>
												<p class="text-muted mb-0">कम्पोस्टबिन सम्बन्धि रिपोर्ट।</p>
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
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">घर धनिको कुल संख्या</p> 
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$totalowner}}">0</span></h4>
													</div>
													<div class="avatar-sm flex-shrink-0">
														<span class="avatar-title bg-soft-info rounded fs-3">
															<i class=" ri-user-2-line text-warning"></i>
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
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">कुल कम्पोस्टबिन सर्वेक्षण</p>
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
									
									<div class="col-3">
										<!-- card -->
										<div class="card card-animate">
											<div class="card-body">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1 overflow-hidden">
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">मान्छे को कुल संख्या</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$totpeople->total}}">0</span></h4>
													</div>
													<div class="avatar-sm flex-shrink-0">
														<span class="avatar-title bg-soft-info rounded fs-3">
															<i class=" ri-user-2-line text-danger"></i>
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
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">सर्वेक्षण गरिएका घरहरूमा भान्साको संख्या</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$totkitchen->totalkitchen}}">0</span></h4>
													</div>
													<div class="avatar-sm flex-shrink-0">
														<span class="avatar-title bg-soft-info rounded fs-3">
															<i class="bx bx-bowl-rice text-info"></i>
														</span>
													</div>
												</div>
											</div><!-- end card body -->
										</div><!-- end card -->
									</div><!-- end col -->
									
									<div class="col-4">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">कम्पोस्टबिन स्रोत अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="cbinusage" style="width:100%;"></div>
												</div>                
										</div>
									</div>	
									<div class="col-4">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">प्रयोगकर्ताद्वारा गरिएको कुल सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="userwisesurvey" style="width:100%;"></div>
												</div>                
										</div>
									</div>									
									<div class="col-4">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">कम्पोस्टबिनको प्रयोग गरेको / नगरेको सर्वेक्षणकर्ता अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="chartContainer" style="width:100%;"></div>
												</div>                
										</div>
									</div>

										
									
								</div> <!-- end row-->

								<div class="row">	
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
 Highcharts.chart('chartContainer', {

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
		categories: [
			<?= $merge;?>
			],
		title:{text:'सर्वेक्षणकर्ता'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'सर्वेक्षण गरिएको संख्या'
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
		name: 'छ',		
		data: [<?= $merge1;?>],
		stack: 'छ'
	}, {
		name: 'छैन',
		data: [<?= $merge2;?>],
		stack: 'छ'
	}]
});
Highcharts.chart('cbinusage', {
	chart: {
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false,
		type: 'pie'
	},
	title: {
		text: 'कम्पोस्टबिन स्रोत',
		align: 'left'
	},
	plotOptions:{
		series:{
			dataLabels:{
				formatter:function(){
					return '<b>' + this.point.name + ':</b><br/>' + Highcharts.numberFormat(this.percentage,0,'.') + '%';
				}
			}
		}
	},
	series: [{
		data: [
			<?php foreach($cbinusage as $usage):?>
			["{{$usage->compostbin_source==NULL ? 'N/A' : $usage->compostbin_source}}", {{$usage->total}}],
			<?php endforeach;?>
		]
	}],
});


/*survey done by tol*/
Highcharts.chart('tolsurvey', {

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
		categories: <?= $artol;?>,
		title:{text:'टोल'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'कुल सर्वेक्षण'
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
		data: [<?= $tolsurvey;?>],
	}]
});

/*survey done by address*/
Highcharts.chart('locationsurvey', {

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
		categories: [
			<?= $location;?>
			],
		title:{text:'सर्वेक्षण गरिएको स्थान'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'कुल सर्वेक्षण'
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
		data: [<?= $surveylist;?>],
	}]
});

/*survey done by user all*/
Highcharts.chart('userwisesurvey', {

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
		categories: <?= $alluser;?>,
		title:{text:'सर्वेक्षक'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'कुल सर्वेक्षण'
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
		data: [<?= $allsurvey;?>],
	}]
});

/*survey done by user today
Highcharts.chart('todayschartbyuser', {

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
		categories: <?= $todayuser;?>,
		title:{text:'सर्वेक्षक'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'आजको कुल सर्वेक्षण'
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
		data: [<?= $todaychart;?>],
	}]
});*/
 
/*survey done by datewise*/
Highcharts.chart('datewisesurvey', {

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
		categories: [<?= $datewise;?>],
		title:{text:'मिति'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'कुल सर्वेक्षण'
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
		data: [<?= $datewisetotal;?>],
	}]
});

/*survey done according to usage in address*/ 
Highcharts.chart('locationusageContainer', {

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
		categories: [
			<?= $location;?>
			],
		title:{text:'सर्वेक्षण गरिएको स्थान'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'सर्वेक्षण गरिएको संख्या'
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
		name: 'छ',		
		data: [<?= $yeslocation;?>],
		stack: 'छ'
	}, {
		name: 'छैन',
		data: [<?= $nolocation;?>],
		stack: 'छ'
	}]
});

/*survey done according to usage in address*/ 
Highcharts.chart('tolusageContainer', {

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
		categories: [
			<?= $artol;?>
			],
		title:{text:'सर्वेक्षण गरिएको टोल'}
	},

	yAxis: {
		allowDecimals: false,
		min: 0,
		title: {
			text: 'सर्वेक्षण गरिएको संख्या'
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
		name: 'छ',		
		data: [<?= $yestol;?>],
		stack: 'छ'
	}, {
		name: 'छैन',
		data: [<?= $notol;?>],
		stack: 'छ'
	}]
});
</script>

@endsection