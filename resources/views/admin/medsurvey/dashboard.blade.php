@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection

@section('content')
@php
	/*survey according to users*/
	$labelchart = array();
	$datachart = array(); 
		
	foreach($medicalbyuser as $data){
		$user = \App\User::where('id',$data->user_id)->first();
		array_push($labelchart,$user->name);
		array_push($datachart,$data->survey_done);		
	}
	
	$alluser = json_encode($labelchart);//implode(", ",$labelchart);
	$allsurvey = implode(", ",$datachart);
	
	/*survey according to users ends*/
	
	/*survey according to users by elderly exists*/
	$arrayuname = array();
	
	foreach($users as $data){
		array_push($arrayuname,"'".$data->name."'");
	
	}
	$merge = implode(", ",$arrayuname);
	$merge1 = implode(", ",$arrayyes);
	$merge2 = implode(", ",$arrayno);
	
	/*survey according to users by elderly exists ends*/
	/*survey according to address*/	
	$arrlocation = array();
	$arraysurveys = array();
	
	foreach($suaddress as $data){
		array_push($arrlocation,"'".$data->location."'");
		array_push($arraysurveys,$data->surveys);		
	}
	
	$location = implode(", ",$arrlocation);
	$surveylist = implode(", ",$arraysurveys);	
	
	/*survey according to address*/	
	
	/*survey according to tol*/
	$arrtol = array();$arrtolsur = array();
	foreach($surveytol as $data){
		array_push($arrtol,$data->tolname);
		array_push($arrtolsur,$data->surveys);
	}
	
	$artol = json_encode($arrtol);
	$tolsurvey = implode(", ",$arrtolsur);
	/*survey according to tol ends*/
	
	/*survey according to chronic_disease_name*/
	$chroniclabel = array(); $chronicdata = array();
	foreach($chronicdisease as $i=>$data){
		array_push($chroniclabel,$i);
		array_push($chronicdata,$data);
	}
	$allchronic = json_encode($chroniclabel);
	$chronicsurvey = implode(',',$chronicdata);
	
	/*getting number of child by roads*/
	$childbyroad = \App\MedicalSurvey::childbyroad();
	$childroadlabel = array();$childroaddata = array();
	foreach($childbyroad as $data){
		array_push($childroadlabel,$data->address_np);
		array_push($childroaddata,$data->total);
	}
	$allchildroad = json_encode($childroadlabel);
	$childroadsurvey = implode(',',$childroaddata);
	
	/*getting number of child by tol*/
	$childbytol = \App\MedicalSurvey::childbytol();
	$childtollabel = array();$childtoldata = array();
	foreach($childbytol as $data){
		array_push($childtollabel,$data->tol_np);
		array_push($childtoldata,$data->total);
	}
	$allchildtol = json_encode($childtollabel);
	$childtolsurvey = implode(',',$childtoldata);
	
	$pnemoniabyroad = \App\MedicalSurvey::pneumoniabyroad();
	$pnemoniabytol = \App\MedicalSurvey::pneumoniabytol();
	
	$pressurebyroad = \App\MedicalSurvey::pressurebyroad();
	$pressurebytol = \App\MedicalSurvey::pressurebytol();
	
	$sugarbyroad = \App\MedicalSurvey::sugarbyroad();
	$sugarbytol = \App\MedicalSurvey::sugarbytol();
	
	$insurancebyroad = \App\MedicalSurvey::insurancebyroad();
	$insurancebytol = \App\MedicalSurvey::insurancebytol();
	
	$ownershipbyroad = \App\MedicalSurvey::ownershipbyroad();
	$ownershipbytol = \App\MedicalSurvey::ownershipbytol();
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
												<h4 class="fs-16 mb-1">मेडिकल ड्यासबोर्ड</h4>
												<p class="text-muted mb-0">मेडिकल सर्वेक्षण सम्बन्धि रिपोर्ट।</p>
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
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">सर्वेक्षण गर्न बाँकी / सर्वेक्षण सम्पन्न घरको संख्या</p> 
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4">
														<span class="counter-value" data-target="{{\App\MedicalSurvey::remainderhouse()}}">0 </span>
														/ <span class="counter-value" data-target="{{\App\MedicalSurvey::completedhouse()}}">0</span></h4>
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
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">कुल मेडिकल सर्वेक्षण</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{\App\MedicalSurvey::count()}}">0</span></h4>
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
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">कुल जेष्ठ नागरिक</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{\App\MedicalSurvey::senior()}}">0</span></h4>
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
													 <p class="text-uppercase fw-medium text-muted text-truncate mb-0">कुल बच्चा ५ बर्ष तथा मुनी</p>
													</div>
												</div>
												<div class="d-flex align-items-end justify-content-between mt-4">
													<div>
														<h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{\App\MedicalSurvey::child()}}">0</span></h4>
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
														<h4 class="card-title mb-0 flex-grow-1">घर स्वामित्व अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="hownership" style="width:100%;"></div>
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
														<h4 class="card-title mb-0 flex-grow-1">जेष्ठ नागरिक भए नभएको सर्वेक्षणकर्ता अनुसार सर्वेक्षण</h4>
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
														<h4 class="card-title mb-0 flex-grow-1">घरको स्वामित्व स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="ownershipbyroad" style="width:100%;"></div>
												</div>                
										</div>
									</div>									
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">घरको स्वामित्व टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="ownershipbytol" style="width:100%;"></div>
												</div>                
										</div>
									</div>
								</div> <!-- end row-->
								
								<div class="row">								
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">स्थान अनुसार ५ बर्ष तथा मुनीको संख्या</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="childbyroad" style="width:100%;"></div>
												</div>                
										</div>
									</div>									
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">टोल अनुसार ५ बर्ष तथा मुनीको संख्या</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="childbytol" style="width:100%;"></div>
												</div>                
										</div>
									</div>								
								</div>								
								
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
								</div> <!-- end row-->
								
								
								
								<div class="row">
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">स्वास्थ्य बिमा गरे / नगरेको स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="insurancebyroad" style="width:100%;"></div>
												</div>                
										</div>
									</div>

									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">स्वास्थ्य बिमा गरे / नगरेको टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="insurancebytol" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">निमोनिया खोप लगाएको / नलगाएको टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="pnemoniabytol" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">निमोनिया खोप लगाएको / नलगाएको स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="pnemoniabyroad" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">रक्तचापको स्थिति स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="pressurebyroad" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">रक्तचापको स्थिति टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="pressurebytol" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">सुगरको स्थिति टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="sugarbytol" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-6">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">सुगरको स्थिति स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="sugarbyroad" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-12">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">नसर्ने तथा दीर्घरोग अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="chronicwise" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-12">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">नसर्ने तथा दीर्घरोग स्थान अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="chronicroadwise" style="width:100%;"></div>
												</div>                
										</div>
									</div>
									
									<div class="col-12">
										<div class="card">
												<div class="card-header border-bottom-dashed align-items-center d-flex">
														<h4 class="card-title mb-0 flex-grow-1">नसर्ने तथा दीर्घरोग टोल अनुसार सर्वेक्षण</h4>
												</div><!-- end card header -->      
												<div class="card-body p-0 pb-2">
													<div id="chronictolwise" style="width:100%;"></div>
												</div>                
										</div>
									</div>	
								</div>
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
	}, {
		name: 'छैन',
		data: [<?= $merge2;?>],
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
			colorByPoint: true,	
			data: [<?= $allsurvey;?>],
		}]
	});
	
	/*no of child by roads*/
	Highcharts.chart('childbyroad', {	
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
			categories: <?= $allchildroad;?>,
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
			colorByPoint: true,	
			data: [<?= $childroadsurvey;?>],
		}]
	});
	
	/*no of child by roads*/
	Highcharts.chart('childbytol', {	
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
			categories: <?= $allchildtol;?>,
			title:{text:'सर्वेक्षण गरिएको टोल'}
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
			colorByPoint: true,	
			data: [<?= $childtolsurvey;?>],
		}]
	});
	
	/*survey according to chronic disease name*/
	Highcharts.chart('chronicwise', {	
		chart: {type: 'column'},	
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories: <?= $allchronic;?>,
			title:{text:'नसर्ने तथा दीर्घरोग स्थान अनुसार सर्वेक्षण'}
		},	
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: 'कुल सर्वेक्षण संख्या'
			}
		},
		legend: {
			align: 'left',
			x: 75,
			verticalAlign: 'top',
			y: 25,
			floating: true,
			borderColor: '#CCC',
			borderWidth: 1,
			shadow: false
		},
		tooltip: {
			 headerFormat: '<b>{point.x}</b><br/>',
			pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
		},
		plotOptions: {
			column: {
				stacking: 'normal',
				 dataLabels: {
					enabled: true
				}
			}
		},	
		series: [{
			name: 'कुल संख्या',		
			data: [<?= $chronicsurvey;?>],
		}]
	});
	
	/*survey according to house ownership by tol*/
	Highcharts.chart('ownershipbyroad', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $ownershipbyroad["address_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको स्थान'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
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
		
		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($ownershipbyroad as $i=>$val):
			if($i!='address_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to house ownership by tol*/
	Highcharts.chart('ownershipbytol', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $ownershipbytol["tol_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको टोल'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
		},
		legend: {
			align: 'left',
			x: 75,
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($ownershipbytol as $i=>$val):
			if($i!='tol_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to insurance by tol*/
	Highcharts.chart('insurancebyroad', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $insurancebyroad["address_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको स्थान'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
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
		
		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($insurancebyroad as $i=>$val):
			if($i!='address_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to insurance by tol*/
	Highcharts.chart('insurancebytol', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $insurancebytol["tol_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको टोल'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
		},
		legend: {
			align: 'left',
			x: 75,
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($insurancebytol as $i=>$val):
			if($i!='tol_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to pnemonia by road*/
	Highcharts.chart('pnemoniabyroad', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $pnemoniabyroad["address_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको स्थान'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($pnemoniabyroad as $i=>$val):
			if($i!='address_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to pnemonia by tol*/
	Highcharts.chart('pnemoniabytol', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $pnemoniabytol["tol_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको टोल'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
		},
		legend: {
			align: 'left',
			x: 75,
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($pnemoniabytol as $i=>$val):
			if($i!='tol_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to pnemonia by tol*/
	Highcharts.chart('pressurebyroad', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $pressurebyroad["address_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको स्थान'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
		},
		legend: {
			align: 'left',
			x: 75,
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($pressurebyroad as $i=>$val):
			if($i!='address_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to pnemonia by tol*/
	Highcharts.chart('pressurebytol', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $pressurebytol["tol_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको टोल'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
		},
		legend: {
			align: 'left',
			x: 75,
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($pressurebytol as $i=>$val):
			if($i!='tol_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to sugar by tol*/
	Highcharts.chart('sugarbyroad', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $sugarbyroad["address_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको स्थान'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
		},
		legend: {
			align: 'left',
			x: 75,
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
		
		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($sugarbyroad as $i=>$val):
			if($i!='address_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to sugar by tol*/
	Highcharts.chart('sugarbytol', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $sugarbytol["tol_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको टोल'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
		},
		legend: {
			align: 'left',
			x: 75,
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($sugarbytol as $i=>$val):
			if($i!='tol_np'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to chronic disease name*/
	Highcharts.chart('chronicroadwise', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $chronicdisease1["address_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको स्थान'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($chronicdisease1 as $i=>$val):
			if($i!='address_np' && $i!='road'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	/*survey according to chronic disease name*/
	Highcharts.chart('chronictolwise', {

		chart: {type: 'column'},
		title: {text: ''},
		credits: {enabled: false},
		xAxis: {
			categories:[<?= "'" . implode ( "', '", $chronicbytol["tol_np"] ) . "'" ?>],
			title:{text:'सर्वेक्षण गरिएको टोल'}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {text: 'सर्वेक्षण गरिएको संख्या'},
			stackLabels: {enabled: true}
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

		plotOptions: {
			column: {
				stacking: 'normal',
				dataLabels: {enabled: true}
			}
		},
		series: [
		<?php 
			foreach($chronicbytol as $i=>$val):
			if($i!='tol_np' && $i!='tol'):
		?>
		{
			name: '<?= $i?>',
			data: [<?= implode(',',$val);?>]
		},
		<?php endif;endforeach;?>
		]
	});
	
	Highcharts.chart('hownership', {
		chart: {
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie'
		},
		title: {
			text: '',
			align: 'left'
		},
		plotOptions:{
			series:{
				borderRadius: 5,
				dataLabels:{
					formatter:function(){
						return '<b>' + this.point.name + ':</b><br/>' + Highcharts.numberFormat(this.percentage,0,'.') + '%';
					}
				}
			}
		},
		series: [{
			data: [
				<?php foreach($ownershipdata as $ownership):?>
				["{{  $ownership->ownership === '1' ? 'आफ्नै' : ($ownership->ownership ==='2' ? 'भाडामा' : 'ब्यापार') }}", {{$ownership->total}}],
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
	
	
	
</script>
@endsection