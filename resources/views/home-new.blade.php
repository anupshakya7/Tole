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
	
	/*members according age range*/
	$arrage = array();
	$arragetotal = array();
	$totcount = 0;
	foreach($membersage as $data){
		$totcount += $data->age_count;
	}
	
	foreach($membersage as $data){
		array_push($arrage,"'".$data->age_range."'");
		array_push($arragetotal,round($data->age_count/$totcount*100));
	}
	
	//var_dump($arragetotal);die();
		
	$agerange = implode(", ",$arrage);
	$agewisetotal = implode(", ",$arragetotal); 
	
	/*members according blood group*/
	$arrbloodgrp = array();
	$arrtotal = array();
	$totblood = 0;
	foreach($memberbybloodgrp as $data){
		$totblood += $data->total;
	}
	
	foreach($memberbybloodgrp as $data){
		array_push($arrbloodgrp,"'".$data->blood_group."'");
		array_push($arrtotal,round($data->total/$totblood*100));
	}
		
	$bloodgroup = implode(", ",$arrbloodgrp);
	$totalblood = implode(", ",$arrtotal); 
	
	
	/*members according occupation*/
	$arrmemoccupation = array();
	$arrmemberoccupation = array();
	$totoccupation = 0;
	
	foreach($membersoccupation as $data){
		$totoccupation+=$data->total;
	}
	foreach($membersoccupation as $data){
		array_push($arrmemoccupation,"'".$data->occupation."'");
		array_push($arrmemberoccupation,round($data->total/$totoccupation*100));
	}
		
	$occupation = implode(", ",$arrmemoccupation);
	$totaloccupation = implode(", ",$arrmemberoccupation); 
	
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
                                                <h4 class="fs-16 mb-1">नमस्कार, {{\Auth::user()->name}}!</h4>
                                                <p class="text-muted mb-0">आजको सर्वेक्षणमा के भइरहेको छ यहाँ छ।</p>
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
								
									<div class="col-xl-3 col-md-6">
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
								
									<div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">ज्येष्ठ नागरिक (६० माथि)</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$totalsenior}}">0</span></h4>
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
                                                     <p class="text-uppercase fw-medium text-muted text-truncate mb-0">घर धनि (महिला)</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$femaleowner}}">0</span></h4>
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
									
									{{--<div class="col-12">
										<div class="card">
											<div class="card-header border-bottom-dashed align-items-center d-flex">
													<h4 class="card-title mb-0 flex-grow-1">प्रयोगकर्ता द्वारा गरिएको  आजको कम्पोस्टबिन सर्वेक्षण</h4>
											</div><!-- end card header -->      
											<div class="card-body p-0 pb-2">
												<div id="todayschartbyuser" style="width:100%;"></div>
											</div>                
                                        </div>
									</div>	--}}
									
									{{--<div class="col-8">
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
                                    </div>--}}

										
									
                                </div> <!-- end row-->

                                <div class="row">					
									
                                    {{--<div class="col-12">
                                        <div class="card card-height-100">
                                            <div class="card-header border-bottom-dashed align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">भर्खरको कम्पोस्टबिन सर्वेक्षणहरू</h4>
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
																	<th>{{ 'कम्पोस्टबिन प्रयोग' }}</th>
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
																<td>{{$cbin->compostbin_usage == 0 ? 'छ' : 'छैन'}}</td>
																<td>{{$cbin->user->name}}</td>
															</tr>
															@php $i++;@endphp
																@endforeach
														</tbody>
                                                    </table><!-- end table -->
                                                </div>
                                            </div>
                                        </div> <!-- .card-->                                        
                                    </div>--}} <!-- .col-->
									<div class="col-6">
                                        <div class="card">
                                                <div class="card-header border-bottom-dashed align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">टोल अनुसार घर संख्या</h4>
                                                </div><!-- end card header -->      
                                                <div class="card-body p-0 pb-2">
                                                    <div id="tolsurvey" style="width:100%;"></div>
                                                </div>                
                                        </div>
                                    </div>									
                                    
									<div class="col-6">
                                        <div class="card">
                                                <div class="card-header border-bottom-dashed align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">स्थान अनुसार घर संख्या</h4>
                                                </div><!-- end card header -->      
                                                <div class="card-body p-0 pb-2">
                                                    <div id="locationsurvey" style="width:100%;"></div>
                                                </div>                
                                        </div>
                                    </div>
									
									<div class="col-12">
                                        <div class="card">
                                                <div class="card-header border-bottom-dashed align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">उमेर समुह अनुसार सदस्य संख्या</h4>
                                                </div><!-- end card header -->      
                                                <div class="card-body p-0 pb-2">
                                                    <div id="agerangemembers" style="width:100%;"></div>
                                                </div>                
                                        </div>
                                    </div>	
									
									<div class="col-6">
                                        <div class="card">
                                                <div class="card-header border-bottom-dashed align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">रक्त समूह अनुसार सदस्यहरू</h4>
                                                </div><!-- end card header -->      
                                                <div class="card-body p-0 pb-2">
                                                    <div id="membersblood" style="width:100%;"></div>
                                                </div>                
                                        </div>
                                    </div>	
									
									<div class="col-6">
                                        <div class="card">
                                                <div class="card-header border-bottom-dashed align-items-center d-flex">
                                                        <h4 class="card-title mb-0 flex-grow-1">पेशा अनुसार सदस्यहरू</h4>
                                                </div><!-- end card header -->      
                                                <div class="card-body p-0 pb-2">
                                                    <div id="membersoccupation" style="width:100%;"></div>
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
 /*Highcharts.chart('chartContainer', {

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
});*/

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
/*Highcharts.chart('userwisesurvey', {

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
//survey done by user today
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
 
/*members according to blood group*/
Highcharts.chart('agerangemembers', {

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
        categories: [<?= $agerange;?>],
		title:{text:'उमेर दायरा'}
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: 'कुल प्रतिशत'
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
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal} %'
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
        name: 'कुल प्रतिशत',		
        data: [<?= $agewisetotal;?>],
    }]
});


/*survey done by datewise*/
Highcharts.chart('membersblood', {

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
        categories: [<?= $bloodgroup;?>],
		title:{text:'रक्त समूह'}
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: 'सदस्य प्रतिशत'
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
         pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal} %'
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
        name: 'कुल प्रतिशत',		
        data: [<?= $totalblood;?>],
    }]
});

/*members according to occupation*/
Highcharts.chart('membersoccupation', {

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
        categories: [<?= $occupation;?>],
		title:{text:'पेशा'}
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: 'सदस्य प्रतिशत'
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
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal} %'
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
        name: 'कुल प्रतिशत',		
        data: [<?= $totaloccupation;?>],
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