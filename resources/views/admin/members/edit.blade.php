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
<link rel="stylesheet" href="{{asset('css/nepali.datepicker.v4.0.min.css')}}"/>
<style>
label{margin-top:15px;}
</style>
	<div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
					<div class="row">
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
					</div>

                    <div class="position-relative mx-n4 mt-n4">
                        <div class="profile-wid-bg profile-setting-img">
                            <img src="{{asset('assets/images/profile-bg.jpg')}}" class="profile-wid-img" alt="">
								{{--<div class="overlay-content">
                                <div class="text-end p-3">
                                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                            <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                                        </label>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card mt-n5">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                            <img src="{{($member->getFirstMediaUrl() ? $member->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg'))}}" class="rounded-circle avatar-xl img-thumbnail" alt="{{$member->full_name}}">
										</div>
                                        <h5 class="fs-16 mb-1">{{$member->full_name}}</h5>
										<p class="text-muted mb-0"><strong>मोबाइल:</strong> <a href="tel:{{$member->contacts->mobile_no}}">{{$member->contacts->mobile_no}}</a></p>
										<p class="text-muted mb-0"><strong>घर नं:</strong> {{$member->house_no}}</p>
										<p class="text-muted mb-0"><strong>उमेर:</strong> {{(date('Y') - date('Y',strtotime($member->dob_ad)))}}</p>
                                        <p class="text-muted mb-0">{{$member->job->occupation_np}}</p>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
							@php
								$general = \App\Member::profilepercentage($member);
								$family = \App\Member::profilepercentage($member->familys);
								$contact = \App\Member::profilepercentage($member->contacts);
								$education = \App\Member::profilepercentage($member->education);
							@endphp
							<div class="card">
                                <div class="card-body">
									<div class="d-flex align-items-center mb-5">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">आफ्नो प्रोफाइल पूरा गर्नुहोस्</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center pb-2">
										<div class="flex-shrink-0 me-3">
											General
										</div>
										<div class="flex-grow-1">
											<div class="progress animated-progress custom-progress progress-label">
												<div class="progress-bar bg-{{$general==100 ? 'success':'warning'}}" role="progressbar" style="width: {{$general}}%" aria-valuenow="{{$general}}" aria-valuemin="0" aria-valuemax="100"><div class="label">{{$general}}%</div></div>
											</div>
										</div>
									</div>
									
									 <div class="d-flex align-items-center pb-2">
										<div class="flex-shrink-0 me-3">
											Family
										</div>
										<div class="flex-grow-1">
											<div class="progress animated-progress custom-progress progress-label">
												<div class="progress-bar bg-{{$family==100 ? 'success':'warning'}}" role="progressbar" style="width: {{$family}}%" aria-valuenow="{{$family}}" aria-valuemin="0" aria-valuemax="100"><div class="label">{{$family}}%</div></div>
											</div>
										</div>
									</div>
									
									 <div class="d-flex align-items-center pb-2">
										<div class="flex-shrink-0 me-3">
											Contact
										</div>
										<div class="flex-grow-1">
											<div class="progress animated-progress custom-progress progress-label">
												<div class="progress-bar bg-{{$contact==100 ? 'success':'warning'}}" role="progressbar" style="width: {{$contact}}%" aria-valuenow="{{$contact}}" aria-valuemin="0" aria-valuemax="100"><div class="label">{{$contact}}%</div></div>
											</div>
										</div>
									</div>
									
									 <div class="d-flex align-items-center pb-2">
										<div class="flex-shrink-0 me-3">
											Education
										</div>
										<div class="flex-grow-1">
											<div class="progress animated-progress custom-progress progress-label">
												<div class="progress-bar bg-{{$education==100 ? 'success':'warning'}}" role="progressbar" style="width: {{$education}}%" aria-valuenow="{{$education}}" aria-valuemin="0" aria-valuemax="100"><div class="label">{{$education}}%</div></div>
											</div>
										</div>
									</div>
                                </div>
                            </div>
							
							@if($member->familys)
							<div class="card">
								<div class="card-body">
									<!-- Accordions Bordered -->									
									<div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-success" id="accordionBordered">
										@if($member->familys)
										<div class="accordion-item">
											<h2 class="accordion-header" id="accordionborderedFamily">
												<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accor_family" aria-expanded="true" aria-controls="accor_borderedExamplecollapse1">
													परिवार
												</button>
											</h2>
											<div id="accor_family" class="accordion-collapse collapse show" aria-labelledby="accordionborderedFamily" data-bs-parent="#accordionBordered">
												<div class="accordion-body">
													<div class="table-responsive">
														<table class="table table-borderless mb-0">
															<tbody>
																<tr>
																	<th class="ps-0" scope="row">हजुरबुबा :</th>
																	<td class="text-muted">{{$member->familys->grandfather_name}}</td>
																</tr>
																<tr>
																	@php
																		$fatherlink = \App\Member::select('id')->where('citizenship',$member->familys->father_citizen)->first();
																	@endphp
																	<th class="ps-0" scope="row">बुबा :</th>
																	<td class="text-muted">
																		{{$member->familys->father_name}} 
																	</td>
																	<?php if($fatherlink):?> 
																	<td>
																		<a href="{{route('admin.member.edit', $fatherlink->id)}}" class="btn btn-success btn-sm"><i class="las la-eye align-middle me-1"></i></a>
																	</td>
																	<?php endif;?>
																</tr>
																<tr>
																	@php
																		$motherlink = \App\Member::select('id')->where('citizenship',$member->familys->mother_citizen)->first();
																	@endphp
																	<th class="ps-0" scope="row">आमा :</th>
																	<td class="text-muted">
																		{{$member->familys->mother_name}}														
																	</td>
																	<?php if($motherlink):?> 
																	<td>
																		<a href="{{route('admin.member.edit', $motherlink->id)}}" class="btn btn-success btn-sm"><i class="las la-eye align-middle me-1"></i></a>
																	</td>
																	<?php endif;?>
																</tr>
																@if($member->familys->spouse)
																<tr>
																	<th class="ps-0" scope="row">पति/पत्नी :</th>
																	<td class="text-muted">{{$member->familys->spouse}}</td>
																</tr>
																@endif
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										@endif
										@php 
											$housemember = \App\Member::where('house_no',$member->house_no)->where('id','!=',$member->id)->get();
											$rdistributions = \App\Distribution::with('programs')->where('house_no',$member->house_no)->get();
											
										@endphp
										@if(count($housemember)>0)
										<div class="accordion-item mt-2">
											<h2 class="accordion-header" id="accordionborderedExample2">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_borderedExamplecollapse2" aria-expanded="false" aria-controls="accor_borderedExamplecollapse2">
													घर नम्बर {{$member->house_no}} मा बस्ने सदस्यहरू 
												</button>
											</h2>
											<div id="accor_borderedExamplecollapse2" class="accordion-collapse collapse" aria-labelledby="accordionborderedExample2" data-bs-parent="#accordionBordered">
												<div class="accordion-body">
													<div class="table-responsive">
														<table class="table table-borderless mb-0">
															<tbody>
																@foreach($housemember as $hmember)
																<tr>
																	<th class="ps-0" scope="row">{{$hmember->full_name}}</th>
																	<td>
																		<a href="{{route('admin.member.edit', $hmember->id)}}" class="btn btn-success btn-sm"><i class="las la-eye align-middle me-1"></i> Profile</a>
																	</td>
																</tr>
																@endforeach
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										@endif
										@if($member->groups->count())
										<div class="accordion-item mt-2">
											<h2 class="accordion-header" id="committee">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_committee" aria-expanded="false" aria-controls="accor_committee">
													संग्लग्न समिति 
												</button>
											</h2>
											<div id="accor_committee" class="accordion-collapse collapse" aria-labelledby="committee" data-bs-parent="#accordionBordered">
												<div class="accordion-body">
													<div class="table-responsive">
														<table class="table table-borderless mb-0">
															<tbody>
																@foreach($member->groups as $group)
																<tr>
																	<th class="ps-0" scope="row">{{$group->title_np}} :</th>
																	<td class="text-muted">
																		{{$group->pivot->designation}} 
																	</td>
																</tr>
																@endforeach
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										@endif
										@if(count($rdistributions)>0)
										<div class="accordion-item mt-2">
											<h2 class="accordion-header" id="accordionborderedExample2">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_borderedExamplecollapse2" aria-expanded="false" aria-controls="accor_borderedExamplecollapse2">
													प्राप्त वितरण कार्यक्रम
												</button>
											</h2>
											<div id="accor_borderedExamplecollapse2" class="accordion-collapse collapse" aria-labelledby="accordionborderedExample2" data-bs-parent="#accordionBordered">
												<div class="accordion-body">
													<div class="table-responsive">
														<table class="table table-borderless mb-0">
															<tbody>
																@foreach($rdistributions as $distributions)
																<tr>
																	<th class="ps-0" scope="row">{{$distributions->programs->title_np}}</th>																	
																</tr>																
																<tr>
																	<th scope="row">प्राप्तकर्ता</th> 
																	<td>{{$distributions->receiver}}</td>
																</tr>
																@endforeach																
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										@endif										
									</div>
								</div>
							</div>
							@endif
                            {{--<div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Complete Your Profile</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                                        </div>
                                    </div>
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">30%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Portfolio</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-add-fill align-bottom me-1"></i> Add</a>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle fs-16 bg-dark text-light">
                                                <i class="ri-github-fill"></i>
                                            </span>
                                        </div>
                                        <input type="email" class="form-control" id="gitUsername" placeholder="Username" value="@daveadame">
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle fs-16 bg-primary">
                                                <i class="ri-global-fill"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com" value="www.velzon.com">
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle fs-16 bg-success">
                                                <i class="ri-dribbble-fill"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="dribbleName" placeholder="Username" value="@dave_adame">
                                    </div>
                                    <div class="d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle fs-16 bg-danger">
                                                <i class="ri-pinterest-fill"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="pinterestName" placeholder="Username" value="Advance Dave">
                                    </div>
                                </div>
                            </div>--}}
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-9">
                            <div class="card mt-xxl-n5">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                                <i class="fas fa-home"></i> General
                                            </a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#memberFamily" role="tab">
                                                <i class="fas fa-home"></i> Family
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                                <i class="far fa-user"></i> Contact
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab">
                                                <i class="far fa-envelope"></i> Education
                                            </a>
                                        </li>
										<li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#medical" role="tab">
                                                <i class="far fa-envelope"></i> Medical
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                                <i class="far fa-envelope"></i> Documents
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                            <form action="{{ route('admin.member.update',$member->id) }}" method="POST" enctype="multipart/form-data">
											@csrf
											@method('patch')
											<div class="text-center">
												<div class="profile-user position-relative d-inline-block mx-auto  mb-4">
													<img src="{{($member->getFirstMediaUrl() ? $member->getFirstMediaUrl() : asset('assets/images/users/user-dummy-img.jpg'))}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="{{$member->full_name}}">
													<div class="avatar-xs p-0 rounded-circle profile-photo-edit">
														<input id="profile-img-file-input" type="file" name="image" class="profile-img-file-input">
														<input type="hidden" name="mediaid" value="{{$member->id}}">
														<label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
															<span class="avatar-title rounded-circle bg-light text-body">
																<i class="ri-camera-fill"></i>
															</span>
														</label>
													</div>
												</div>
												<h5 class="fs-14">{{'फोटो थप्नुहोस्'}} <span style="color: red">*</span></h5> 
											</div>
                                                <div class="row">
                                                    <div class="col-6">
													<label class="form-label" for="full_name">{{'Full Name'}} <span class="fi fi-us fis"></span> <span style="color: red">*</span></label>
													<input type="text" class="form-control" name="full_name" value="{{$member->full_name}}" required />
												</div>
												<div class="col-6">
													<label class="form-label" for="full_name">{{'पुरा नाम'}}  <span class="fi fi-np fis"></span></label>
													<input type="text" class="form-control" name="fullname_np" value="{{$member->fullname_np}}" required />
												</div>
												
												<div class="col-6">
													<label class="form-label" for="full_name">{{'जन्म मिति'}} (BS) <span style="color: red">*</span></label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" id="nepali-datepicker" name="dob_bs" value="{{$member->dob_bs}}" required />
														<i class="bx bx-calendar"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="full_name">{{'जन्म मिति'}} (AD) <span style="color: red">*</span></label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" name="dob_ad" value="{{$member->dob_ad}}" required />
														<i class="bx bx-calendar"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="gender">{{ 'लिङ्ग' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="gender" class="form-select form-control-icon" required>
															<option value="9">{{"लिङ्ग चयन गर्नुहोस्"}}</option>
															<option value="1" {{$member->gender==1 ? "selected" : ""}}>{{"पुरुष"}}</option>
															<option value="2" {{$member->gender==2 ? "selected" : ""}}>{{"महिला"}}</option>
															<option value="3" {{$member->gender==3 ? "selected" : ""}}>{{"अन्य"}}</option>
														</select>
														<i class="bx bx-male-female"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="martial_status">{{ 'वैवाहिक स्थिति' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="martial_status" class="form-select form-control-icon" required>															
															<option value="9">{{"वैवाहिक स्थिति चयन गर्नुहोस्"}}</option>
															<option value="1" {{$member->martial_status==1 ? "selected" : ""}}>{{"अविवाहित"}}</option>
															<option value="2" {{$member->martial_status==2 ? "selected" : ""}}>{{"विवाहित"}}</option>
															<option value="3" {{$member->martial_status==3 ? "selected" : ""}}>{{"सम्बन्धविच्छेद भएको"}}</option>
															<option value="4" {{$member->martial_status==4 ? "selected" : ""}}>{{"विधवा"}}</option>
														</select>
														<i class="bx bx-male-female"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="citizenship">{{'नागरिकता नम्बर'}}  <span style="color: red">*</span></label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" name="citizenship" value="{{$member->citizenship}}" required />
														<i class="ri-contacts-book-2-line"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="birth_registration">{{'जन्म दर्ता नं'}}  </label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" value="{{ $member->birth_registration}}" name="birth_registration" />
														<i class="ri-contacts-book-2-line"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="national_id">{{'राष्ट्रिय परिचय पत्र नम्बर'}}  </label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" name="national_id" value="{{$member->national_id}}"/>
														<i class="ri-contacts-book-2-line"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label for="house_no" class="form-label"> {{ 'घर नम्बर' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<input type="text" id="house_no" name="house_no" class="form-control form-control-icon" value="{{ $member->house_no }}">
														<i class=" ri-home-8-line"></i>
													</div>
													@if($errors->has('house_no'))
														<em class="invalid-feedback">
															{{ $errors->first('house_no') }}
														</em>
													@endif
													<em class="errorajax" style="display:hidden;"></em>
												</div>
												
												<div class="col-6">
												<label for="road">{{ 'सडक नाम' }} <span style="color: red">*</span></label>
												<select id="road" name="road" class="form-select" required>
													<option>{{'सडक चयन गर्नुहोस्'}}</option>
													@php $address = \App\Address::get();@endphp 
													@foreach($address as $data)
													<option value='{{$data->id}}' {{$data->id==$member->road ? 'selected' : ''}}>{{$data->address_np}}</option>
													@endforeach
												</select>
												<em class="error" style="color:red;display:none;"></em> 
												</div>
												
												<div class="col-6">
													<label for="tol">{{ 'टोल' }} <span style="color: red">*</span></label>
													<select id="tol" name="tol" class="form-select" required>
														<option>{{'टोल चयन गर्नुहोस्'}}</option>
														@php $tol = \App\Tol::get();@endphp 
														@foreach($tol as $data)
														<option value='{{$data->id}}' {{$data->id==$member->tol ? 'selected' : ''}}>{{$data->tol_np}}</option>
														@endforeach
													</select>
													@if($errors->has('tol'))
														<em class="invalid-feedback">
															{{ $errors->first('tol') }}
														</em>
													@endif
												</div>
												
												<div class="col-6">
													<label class="form-label" for="blood_grp">{{ 'रक्त समूह' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="blood_grp" class="form-select form-control-icon" required>
															<option value="0">{{"रक्त समूह चयन गर्नुहोस्"}}</option>
															<option value="A+" {{$member->blood_group == 'A+' ? 'selected' : ''}}>A+</option>
															<option value="A-" {{$member->blood_group == 'A-' ? 'selected' : ''}}>A-</option>
															<option value="B+" {{$member->blood_group == 'B+' ? 'selected' : ''}}>B+</option>
															<option value="B-" {{$member->blood_group == 'B-' ? 'selected' : ''}}>B-</option>
															<option value="O+" {{$member->blood_group == 'O+' ? 'selected' : ''}}>O+</option>
															<option value="O-" {{$member->blood_group == 'O-' ? 'selected' : ''}}>O-</option>
															<option value="AB+" {{$member->blood_group == 'AB+' ? 'selected' : ''}}>AB+</option>
															<option value="AB-" {{$member->blood_group == 'AB-' ? 'selected' : ''}}>AB-</option>
															<option value="Unknown" {{$member->blood_group == 'Unknown' ? 'selected' : ''}}>AB-</option>
														</select>
														<i class="ri-contrast-drop-2-line"></i>
													</div>
													@if($errors->has('blood_grp'))
														<em class="invalid-feedback">
															{{ $errors->first('blood_grp') }}
														</em>
													@endif
												</div>
												
												<div class="col-6">
													<label for="occupation">{{ 'पेशा' }} <span style="color: red">*</span></label>
													@php $job = \App\Occupation::get();@endphp 
													<div class="form-icon">
														<select id="occupation" name="occupation" class="form-select form-control-icon" required>
															<option value="0">{{'पेशा रोज्नुहोस्'}}</option>
															@foreach($job as $data)
															<option value='{{$data->id}}' {{$data->id==$member->occupation_id ? 'selected' : ''}}>{{$data->occupation_np}}</option>
															@endforeach
														</select>
														<i class="ri-briefcase-line"></i>
													</div>
													@if($errors->has('occupation'))
														<em class="invalid-feedback">
															{{ $errors->first('occupation') }}
														</em>
													@endif
												</div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-soft-primary">Update</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                        <!--end tab-pane-->
										<div class="tab-pane" id="memberFamily" role="tabpanel">
											@if($member->familys)
											<form action="{{ route('admin.memberfamily.update',$member->familys->id)}}" method="POST" enctype="multipart/form-data">
												@csrf
												@method('patch')
											@else
												<form action="{{ route('admin.memberfamily.store') }}" method="POST" enctype="multipart/form-data">
												@csrf
											@endif
												<div class="row g-2">
												
													<div class="col-4">
														<input type="hidden" name="member_id" value="{{$member->id}}">
														<label for="grandfather_name" class="form-label"> {{ 'Grandfather Name' }} <span style="color: red">*</span></label>
														<input type="text" name="grandfather_name" class="form-control" value="{{ $member->familys ? $member->familys->grandfather_name : '' }}">
													</div>
													
													<div class="col-4">
														<label for="grandfather_np" class="form-label"> {{ 'हजुरबुबाको नाम' }} <span style="color: red">*</span></label>
														<input type="text" name="grandfather_np" class="form-control" value="{{ $member->familys ? $member->familys->grandfather_np : '' }}">
													</div>
													
													<div class="col-4">
														<label for="grandfather_citizen" class="form-label"> {{ 'हजुरबुबाको नागरिकता नम्बर' }}</label>
														<input type="text" name="grandfather_citizen" class="form-control" value="{{ $member->familys ? $member->familys->grandfather_citizen : '' }}">
													</div>
													
													<div class="col-4">
														<label for="grandmother_name" class="form-label"> {{ 'Grandmother Name' }} <span style="color: red">*</span></label>
														<input type="text" name="grandmother_name" class="form-control" value="{{ $member->familys ? $member->familys->grandmother_name : '' }}">
													</div>
													
													<div class="col-4">
														<label for="grandmother_np" class="form-label"> {{ 'हजुरआमाको नाम' }} <span style="color: red">*</span></label>
														<input type="text" name="grandmother_np" class="form-control" value="{{ $member->familys ? $member->familys->grandmother_np : '' }}">
													</div>
													
													<div class="col-4">
														<label for="grandmother_citizen" class="form-label"> {{ 'हजुरआमाको नागरिकता नम्बर' }}</label>
														<input type="text" name="grandmother_citizen" class="form-control" value="{{ $member->familys ? $member->familys->grandmother_citizen : '' }}">
													</div>
													
													<div class="col-4">
														<label for="father_name" class="form-label"> {{ 'Father Name' }} <span style="color: red">*</span></label>
														<input type="text" name="father_name" class="form-control" value="{{ $member->familys ? $member->familys->father_name : '' }}">
													</div>
													
													<div class="col-4">
														<label for="father_np" class="form-label"> {{ 'बुबाको नाम' }} <span style="color: red">*</span></label>
														<input type="text" name="father_np" class="form-control" value="{{ $member->familys ? $member->familys->father_np : '' }}">
													</div>
													
													<div class="col-4">
														<label for="father_citizen" class="form-label"> {{ 'बुबाको नागरिकता नम्बर' }} <span style="color: red">*</span></label>
														<input type="text" name="father_citizen" class="form-control" value="{{ $member->familys ? $member->familys->father_citizen : '' }}">
													</div>
													
													<div class="col-4">
														<label for="mother_name" class="form-label"> {{ 'Mother Name' }} <span style="color: red">*</span></label>
														<input type="text" name="mother_name" class="form-control" value="{{ $member->familys ? $member->familys->mother_name : '' }}">
													</div>
													
													<div class="col-4">
														<label for="mother_np" class="form-label"> {{ 'आमाको नाम' }} <span style="color: red">*</span></label>
														<input type="text" name="mother_np" class="form-control" value="{{ $member->familys ? $member->familys->mother_np : '' }}">
													</div>
													
													<div class="col-4">
														<label for="mother_citizen" class="form-label"> {{ 'आमाको नागरिकता नम्बर' }} <span style="color: red">*</span></label>
														<input type="text" name="mother_citizen" class="form-control" value="{{ $member->familys ? $member->familys->mother_citizen : '' }}">
													</div>
													
													<div class="col-4">
														<label for="spouse_name" class="form-label"> {{ 'Spouse Name' }}</label>
														<input type="text" name="spouse_name" class="form-control" value="{{ $member->familys ? $member->familys->spouse_name : '' }}">
													</div>
													
													<div class="col-4">
														<label for="spouse_np" class="form-label"> {{ 'पति/पत्नीको नाम' }}</label>
														<input type="text" name="spouse_np" class="form-control" value="{{ $member->familys ? $member->familys->spouse_np : '' }}">
													</div>
													
													<div class="col-4">
														<label for="spouse_citizen" class="form-label"> {{ 'पति/पत्नीको नागरिकता नम्बर' }} </label>
														<input type="text" name="spouse_citizen" class="form-control" value="{{ $member->familys ? $member->familys->spouse_citizen : '' }}">
													</div>
													
													 <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="{{$member->contacts ? 'btn btn-soft-primary' : 'btn btn-soft-success'}}">{{$member->familys ? 'Update' : 'Submit'}}</button>
                                                        </div>
                                                    </div>
												</div>
											</form>
										</div>
										  <!--end tab-pane-->
										  
										<div class="tab-pane" id="medical" role="tabpanel">
											@if(count($member->medicals)==0)
												<form action="{{ route('admin.membermedical.store') }}" method="POST" enctype="multipart/form-data">
												@csrf											
											@else
												<form action="{{ route('admin.membermedical.update',$member->familys->id)}}" method="POST" enctype="multipart/form-data">
												@csrf
												@method('patch')
											@endif
												<div class="row g-2">
													@php
														$group = \App\Medicalconditions::groupBy('type')->get();
													@endphp	
													@foreach($group as $grp)		
														<div class="col-12">																		
															<div class="mt-4 mb-3 border-bottom pb-2">
																<h5 class="card-title">{{$grp->type}}</h5>		
															</div>
															@if($grp->type=="अपाङ्गता")
																<div class="form-group col-12" style="margin-bottom:20px;">
																	<label for="exampleFormControlInput1">Disability Certificate </label>
																	<input name="disability_certificate" type="file" class="form-control"> 
																</div>
															@endif	
															@php
																$medcondition = \App\Medicalconditions::where('type',$grp->type)->get();
															@endphp
															<div class="col-12">
																<select class="form-select form-control" name="medical_problem[]">
																	<option value="NULL">सेलेक्ट गर्नुहोस</option>
																	@foreach($medcondition as $cond)
																	<option value="0">{{$cond->title}}</option>
																	@endforeach
																</select>
															</div>													
														</div>
													@endforeach
													
													 <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="{{count($member->medicals)==0 ? 'btn btn-soft-success' : 'btn btn-soft-primary'}}">{{count($member->medicals)==0 ? 'Submit' : 'Update'}}</button>
                                                        </div>
                                                    </div>
												</div>
											</form>
										</div>  
                                        <div class="tab-pane" id="changePassword" role="tabpanel">										
											@if($member->contacts==NULL)
												<form action="{{ route('admin.membercontact.store') }}" method="POST" enctype="multipart/form-data">
												@csrf											
											@else
												 <form action="{{ route('admin.membercontact.update',$member->contacts->id) }}" method="POST" enctype="multipart/form-data">
												@csrf
												@method('patch')
											@endif
                                                <div class="row g-2">
                                                    <div class="col-6">
														<label for="contact" class="form-label"> {{ 'सम्पर्क नम्बर' }} <span style="color: red">*</span></label>
														<div class="form-icon">
															<input type="hidden" name="member_id" value="{{$member->id}}">
															<input type="text" name="contact_no" maxlength="10" class="form-control form-control-icon" value="{{ $member->contacts ? $member->contacts->contact_no : '' }}">
															<i class="ri-phone-line"></i>
														</div>
													</div>
											
													<div class="col-6">
														<label for="mobile" class="form-label"> {{ 'मोबाइल' }} <span style="color: red">*</span></label>
														<div class="form-icon">
															<input type="text" name="mobile_no" maxlength="10" class="form-control form-control-icon" value="{{ $member->contacts ? $member->contacts->mobile_no : '' }}">
															<i class="ri-cellphone-fill"></i>
														</div>
													</div>
											
													<div class="col-6">
														<!-- Input with Icon -->
														
														<label for="email" class="form-label"> {{ 'इमेल' }} <span style="color: red">*</span></label>
														<div class="form-icon">
															<input type="email" name="email" class="form-control form-control-icon" value="{{ $member->contacts ? $member->contacts->email : '' }}">
															<i class="ri-mail-unread-line"></i>
														</div>
														
													</div>
											
													<div class="col-6">
														<label class="form-label" for="temporary_address">{{'अस्थायी ठेगाना'}}</label>
														<div class="form-icon">
															<input type="text" class="form-control form-control-icon" value="{{ $member->contacts ? $member->contacts->temporary_address : '' }}" name="temporary_address"  />
															<i class=" bx bx-home-circle"></i>
														</div>
													</div>
                                                    <!--end col-->
													<!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="{{$member->contacts ? 'btn btn-soft-primary' : 'btn btn-soft-success'}}">{{ $member->contacts ? 'Update' : 'Submit'}}</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
												 
                                            </form>
                                            {{--<div class="mt-4 mb-3 border-bottom pb-2">
                                                <div class="float-end">
                                                    <a href="javascript:void(0);" class="link-primary">All Logout</a>
                                                </div>
                                                <h5 class="card-title">Login History</h5>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0 avatar-sm">
                                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                        <i class="ri-smartphone-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6>iPhone 12 Pro</h6>
                                                    <p class="text-muted mb-0">Los Angeles, United States - March 16 at 2:47PM</p>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">Logout</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0 avatar-sm">
                                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                        <i class="ri-tablet-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6>Apple iPad Pro</h6>
                                                    <p class="text-muted mb-0">Washington, United States - November 06 at 10:43AM</p>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">Logout</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0 avatar-sm">
                                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                        <i class="ri-smartphone-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6>Galaxy S21 Ultra 5G</h6>
                                                    <p class="text-muted mb-0">Conneticut, United States - June 12 at 3:24PM</p>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">Logout</a>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-sm">
                                                    <div class="avatar-title bg-light text-primary rounded-3 fs-18">
                                                        <i class="ri-macbook-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6>Dell Inspiron 14</h6>
                                                    <p class="text-muted mb-0">Phoenix, United States - July 26 at 8:10AM</p>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);">Logout</a>
                                                </div>
                                            </div>--}}
                                        </div>
                                        <!--end tab-pane-->
                                        <div class="tab-pane" id="experience" role="tabpanel">
											<div id="newlink">
												<div id="1">
													@if($member->education==NULL)
														<form action="{{ route('admin.membereducation.store') }}" method="POST" enctype="multipart/form-data">
														@csrf											
													@else
														<form action="{{ route('admin.membereducation.update',$member->education->id) }}" method="POST" enctype="multipart/form-data">
														@csrf
														@method('patch')
													@endif
													
														<div class="row g-2">	
															<div class="col-12">
																<input type="hidden" name="member_id" value="{{$member->id}}">
																<label class="form-label" for="last_qualification">{{ 'अन्तिम योग्यता' }} <span style="color: red">*</span></label>
																<div class="form-icon">
																	<select name="last_qualification" class="form-select form-control-icon" required>
																		<option value="NULL">{{"अन्तिम योग्यता चयन गर्नुहोस्"}}</option>
																		<option value="Under SLC" {{($member->education) ? ($member->education->last_qualification=='N/A' ? 'selected' : '') : ''}}>N/A</option>
																		<option value="Under SLC" {{($member->education) ? ($member->education->last_qualification=='Under SLC' ? 'selected' : '') : ''}}>Under SLC</option>
																		<option value="SLC" {{($member->education) ? ($member->education->last_qualification=='SLC' ? 'selected' : '') : ''}}>SLC</option>
																		<option value="+2" {{($member->education) ? ($member->education->last_qualification=='+2' ? 'selected' : '') : ''}}>+2</option>
																		<option value="Bachelors" {{($member->education) ? ($member->education->last_qualification=='Bachelors' ? 'selected' : '') : ''}}>Bachelors</option>
																		<option value="Masters" {{($member->education) ? ($member->education->last_qualification=='Masters' ? 'selected' : '') : ''}}>Masters</option>
																		<option value="Phd" {{($member->education) ? ($member->education->last_qualification=='Phd' ? 'selected' : '') : ''}}>Phd</option> 
																	</select>
																	<i class="bx bxs-graduation"></i>
																</div>
																@if($errors->has('last_qualification'))
																	<em class="invalid-feedback">
																		{{ $errors->first('last_qualification') }}
																	</em>
																@endif
															</div>
															<div class="col-12">
																<label class="form-label" for="passed_year">Passed Year</label>
																<div class="form-icon">
																	<input class="form-control form-control-icon" id="passed_year" type="text" value="{{$member->education ? $member->education->passed_year : ''}}" name="passed_year"/>
																	<i class="bx bx-calendar"></i>
																</div>
															</div>	
															<div class="col-12">
																<div class="hstack gap-2 justify-content-end">
																	<button type="submit" class="{{$member->education ? 'btn btn-soft-primary' : 'btn btn-soft-success'}}">{{$member->education ? 'Update' : 'Submit'}}</button>
																</div>
															</div>														
														</div>
														<!--end row-->
													</form>
													<!--form end-->
												</div>
											</div>
                                        </div>
                                        <!--end tab-pane-->
                                        <div class="tab-pane" id="privacy" role="tabpanel">
                                            <div class="row g-2">
												<div class="col-10" style="padding-bottom:15px;font-size:16px;font-weight:500;">
													<span>To add more files, please click the 'Add' button.</span>
												</div>

												<div class="col-2 add-less-button" style="margin-bottom:15px;text-align:right;">
													<a href="javascript:;" id="add-more" class="btn btn-soft-success" type="button"><i class="ri-add-circle-line align-middle me-1"></i> Add</a> 

												</div>
												<form action="{{ route('admin.memberdocuments.store') }}" method="POST" enctype="multipart/form-data">
													@csrf
													<div class="col-12">
														<div id="clone-container"> 
															<div class="clone-item employee-info-wrap">
																<div class="row">
																	<div class="form-group col-4">
																	<input type="hidden" name="member_id" value="{{$member->id}}">
																		<label class="form-label" for="doc_type">{{ 'कागजात प्रकार' }} <span style="color: red">*</span></label>
																		<div class="form-icon">
																			<select name="doc_type[]" class="form-select form-control-icon" required> 
																				<option value="NULL">{{"कागजातको प्रकार चयन गर्नुहोस्"}}</option>
																				@foreach($mdocuments as $docs)
																					<option value="{{$docs}}">{{$docs}}</option>
																				@endforeach
																			</select>
																			<i class="ri-contacts-book-2-line"></i>
																		</div>
																	</div>
																	<div class="form-group col-md-4">
																		<label for="exampleFormControlInput1">कागजात नम्बर <span style="color: red">*</span></label>
																		<input name="doc_number[]" type="text" class="form-control" required>
																	</div>
																	<div class="form-group col-md-4">
																		<label for="exampleFormControlInput1">File <span style="color: red">*</span></label>
																		<input name="file[]" type="file" class="form-control" required>
																	</div>
																	<div class="col-md-12" style="margin-top:15px;">
																		<a href="javascript:void(0)" class="remove-item delete btn btn-soft-danger"><i class="ri-indeterminate-circle-line"></i> Remove</a>
																	</div>
																</div>                                            
															</div>
														</div>
													</div>
													<div class="col-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-soft-success">Submit</button>
                                                        </div>
                                                    </div>
												</form>			
											</div>
											@if($member->documents)
											<div class="card">
												<div class="card-body">
													<div class="d-flex align-items-center mb-4">
														<h5 class="card-title flex-grow-1 mb-0">Documents</h5>
													</div>
													<div class="row">
														<div class="col-lg-12">
															<div class="table">
																<table class="table table-borderless align-middle mb-0">
																	<thead class="table-light">
																		<tr>
																			<th scope="col">Type</th>
																			<th scope="col">Number</th>
																			<th scope="col">Upload Date</th>
																			<th scope="col">Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach($member->documents as $doc)
																		<tr>
																			<td>
																				<div class="d-flex align-items-center">
																					<div class="avatar-sm">
																						<div class="avatar-title bg-soft-danger text-danger rounded fs-20">
																							<i class="ri-image-2-fill"></i>
																						</div>
																					</div>
																					<div class="ms-3 flex-grow-1">
																						<h6 class="fs-15 mb-0"><a href="{{ asset('storage/'.$doc->file) }}" target="_blank">{{$doc->doc_type}}</a>
																						</h6>
																					</div>
																				</div>
																			</td>
																			<td>{{$doc->doc_number}}</td>
																			<td>{{$doc->created_at->diffForHumans()}}</td>
																			<td>
																				<div class="dropdown">
																					<a href="javascript:void(0);" class="btn btn-light btn-icon" id="dropdownMenuLink15" data-bs-toggle="dropdown" aria-expanded="true">
																						<i class="ri-equalizer-fill"></i>
																					</a>
																					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink15">
																						<li><a class="dropdown-item" href="{{ asset('public/storage/'.$doc->file) }}" target="_blank"><i class="ri-eye-fill me-2 align-middle text-muted"></i>View</a></li>
																						<li><a class="dropdown-item" href="{{ asset('public/storage/'.$doc->file) }}" download><i class="ri-download-2-fill me-2 align-middle text-muted"></i>Download</a></li>
																						<li class="dropdown-divider"></li>
																						<li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle text-muted"></i>Delete</a></li>
																					</ul>
																				</div>
																			</td>
																		</tr>
																		@endforeach
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
											@endif
                                        </div>
                                        <!--end tab-pane-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->
@endsection
@section('scripts')
<script src="{{asset('js/nepali.datepicker.v4.0.min.js')}}"></script>
<script src="{{asset('js/cloneData.js')}}"></script>
<script src="{{asset('assets/js/pages/profile-setting.init.js')}}"></script>

<script>
	 var mainInput = document.getElementById("nepali-datepicker");
     mainInput.nepaliDatePicker({ndpYear: true,ndpMonth: true});
	
	$('#passed_year').datetimepicker({
		format      :   "YYYY",
		viewMode    :   "years", 
	});
	
    toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right"
        };

      var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif
	  
	  $('#add-more').cloneData({
	  //container to hold the duplicated form fields
	  mainContainerId:'clone-container',
	  //class to be cloned
	  cloneContainer:'clone-item',
	  // CSS class of remove button
	  removeButtonClass:'remove-item',
	  removeConfirm: true, // default true confirm before delete clone item
        removeConfirmMessage: 'Are you sure want to delete?', // confirm delete message
	  minLimit: 1, // Default 1 set minimum clone HTML required
      maxLimit: 15, // Default unlimited or set maximum limit of clone HTML
    });


</script>
@endsection