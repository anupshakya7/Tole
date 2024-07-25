<?php
$mdocuments = \App\Member::memdocuments(setting()->get('member_documents'));
?><form id="memberform" action="{{route('admin.member.store')}}" class="form-steps" autocomplete="off" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="text-center pt-3 pb-4 mb-1">
									<img src="{{asset('img/np-logo.png')}}" alt="" height="80">
								</div>
								<div class="step-arrow-nav mb-4">

									<ul class="nav nav-pills custom-nav nav-justified" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-gen-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-gen-info" type="button" role="tab" aria-controls="steparrow-gen-info" aria-selected="true">General</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-family-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-family-info" type="button" role="tab" aria-controls="steparrow-family-info" aria-selected="false">Family</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-contact-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-contact-info" type="button" role="tab" aria-controls="steparrow-contact-info" aria-selected="false">Contact</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-education-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-education-info" type="button" role="tab" aria-controls="steparrow-education-info" aria-selected="false">Education</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-medical-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-medical-info" type="button" role="tab" aria-controls="steparrow-medical-info" aria-selected="false">Medical</button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="steparrow-documents-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-documents-info" type="button" role="tab" aria-controls="steparrow-documents-info" aria-selected="false">Documents</button>
										</li>
									</ul>
								</div>

								<div class="tab-content">
									<div class="tab-pane fade show active" id="steparrow-gen-info" role="tabpanel" aria-labelledby="steparrow-gen-info-tab">
										<div>
											<div class="text-center">
												<div class="profile-user position-relative d-inline-block mx-auto mb-2">
													<img src="{{asset('assets/images/users/user-dummy-img.jpg')}}" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
													<div class="avatar-xs p-0 rounded-circle profile-photo-edit">
														<input id="profile-img-file-input" type="file" name="image" class="profile-img-file-input" accept="image/png, image/jpeg">
														<label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
															<span class="avatar-title rounded-circle bg-light text-body">
																<i class="ri-camera-fill"></i>
															</span>
														</label>
													</div>
												</div>
												<h5 class="fs-14">{{'फोटो थप्नुहोस्'}} <span style="color: red">*</span></h5> 

											</div>
											
											<div class="row" style="margin-top:15px;">
												<div class="col-6">
													<label class="form-label" for="full_name">{{'Full Name'}} <span class="fi fi-us fis"></span> <span style="color: red">*</span></label>
													<input type="text" class="form-control" name="full_name" value="{{old('full_name')}}" />
												</div>
												<div class="col-6">
													<label class="form-label" for="full_name">{{'पुरा नाम'}}  <span class="fi fi-np fis"></span></label>
													<input type="text" class="form-control" name="fullname_np" value="{{old('fullname_np')}}" />
												</div>
												
												<div class="col-6">
													<label class="form-label" for="full_name">{{'जन्म मिति'}} (BS) <span style="color: red">*</span></label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" id="nepali-datepicker" value="{{old('dob_bs')}}" name="dob_bs" />
														<i class="bx bx-calendar"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="gender">{{ 'लिङ्ग' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="gender" class="form-select form-control-icon">
															<option value="9">{{"लिङ्ग चयन गर्नुहोस्"}}</option>
															<option value="1" {{old("gender")==1 ? "selected" : ""}}>{{"पुरुष"}}</option>
															<option value="2" {{old("gender")==2 ? "selected" : ""}}>>{{"महिला"}}</option>
															<option value="3" {{old("gender")==3 ? "selected" : ""}}>{{"अन्य"}}</option>
														</select>
														<i class="bx bx-male-female"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="martial_status">{{ 'वैवाहिक स्थिति' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="martial_status" class="form-select form-control-icon">
															<option value="9">{{"वैवाहिक स्थिति चयन गर्नुहोस्"}}</option>
															<option value="1" {{old("martial_status")==1 ? "selected" : ""}}>{{"अविवाहित"}}</option>
															<option value="2" {{old("martial_status")==2 ? "selected" : ""}}>{{"विवाहित"}}</option>
															<option value="3" {{old("martial_status")==3 ? "selected" : ""}}>{{"सम्बन्धविच्छेद भएको"}}</option>
															<option value="4" {{old("martial_status")==4 ? "selected" : ""}}>{{"विधवा"}}</option>
														</select>
														<i class="bx bx-male-female"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="full_name">{{'नागरिकता नम्बर'}} </label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" value="{{old('citizenship')}}" name="citizenship" />
														<i class="ri-contacts-book-2-line"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="birth_registration">{{'जन्म दर्ता नं'}}  </label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" value="{{old('birth_registration')}}" name="birth_registration" />
														<i class="ri-contacts-book-2-line"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label class="form-label" for="full_name">{{'राष्ट्रिय परिचय पत्र नम्बर'}}  </label>
													<div class="form-icon">
														<input type="text" class="form-control form-control-icon" value="{{old('national_id')}}" name="national_id" />
														<i class="ri-contacts-book-2-line"></i>
													</div>
												</div>												
												<div class="col-6">
													<label class="form-label" for="blood_grp">{{ 'रक्त समूह' }} <span style="color: red">*</span></label>
													<div class="form-icon">
														<select name="blood_grp" class="form-select form-control-icon">
															<option value="">{{"रक्त समूह चयन गर्नुहोस्"}}</option>
															<option value="A+" {{old('blood_grp')=='A+' ? 'selected' : ''}}>A+</option>
															<option value="A-" {{old('blood_grp')=='A-' ? 'selected' : ''}}>A-</option>
															<option value="B+" {{old('blood_grp')=='B+' ? 'selected' : ''}}>B+</option>
															<option value="B-" {{old('blood_grp')=='B-' ? 'selected' : ''}}>B-</option>
															<option value="O+" {{old('blood_grp')=='O+' ? 'selected' : ''}}>O+</option>
															<option value="O-" {{old('blood_grp')=='O-' ? 'selected' : ''}}>O-</option>
															<option value="AB+" {{old('blood_grp')=='AB+' ? 'selected' : ''}}>AB+</option>
															<option value="AB-" {{old('blood_grp')=='AB-' ? 'selected' : ''}}>AB-</option>
															<option value="Unknown" {{old('blood_grp')=='Unknown' ? 'selected' : ''}}>Unknown</option>
														</select>
														<i class="ri-contrast-drop-2-line"></i>
													</div>
												</div>
												
												<div class="col-6">
													<label for="occupation">{{ 'पेशा' }} <span style="color: red">*</span></label>
													@php $job = \App\Occupation::get();@endphp 
													<div class="form-icon">
														<select id="occupation" name="occupation" class="form-select form-control-icon">
															<option value="">{{'पेशा रोज्नुहोस्'}}</option>
															@foreach($job as $data)
															<option value='{{$data->id}}' {{$data->id==old('occupation') ? 'selected' : ''}}>{{$data->occupation_np}}</option>
															@endforeach
														</select>
														<i class="ri-briefcase-line"></i>
													</div>
												</div>
												
											</div>
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-verify-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Verify</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-family-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Family</button>
										</div>
									</div>
									<!-- end tab pane -->
									<div class="tab-pane fade" id="steparrow-family-info" role="tabpanel" aria-labelledby="steparrow-family-info-tab">
										<div class="row">
										
											<div class="col-4">
												<label for="father_citizen" class="form-label"> {{ 'बुबाको नागरिकता नम्बर' }} <span style="color: red">*</span></label>
												<input type="text" onfocusout="checkFamily();" id="mfathercitizen" name="father_citizen" class="form-control" value="{{ old('father_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="father_name" class="form-label"> {{ 'Father Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mfathername" name="father_name" class="form-control" value="{{ old('father_name') }}">
											</div>
											
											<div class="col-4">
												<label for="father_name" class="form-label"> {{ 'बुबाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mfathernp" name="father_np" class="form-control" value="{{ old('father_np') }}">
											</div>
											
											<div class="col-4">
												<label for="grandfather_name" class="form-label"> {{ 'Grandfather Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mgfathernp" name="grandfather_np" class="form-control" value="{{ old('grandfather_np') }}">
											</div>
											
											<div class="col-4">
												<label for="grandfather_name" class="form-label"> {{ 'हजुरबुबाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mgfathername" name="grandfather_name" class="form-control" value="{{ old('grandfather_name') }}">
											</div>
											
											<div class="col-4">
												<label for="grandfather_citizen" class="form-label"> {{ 'हजुरबुबाको नागरिकता नम्बर' }}</label>
												<input type="text" id="mgfathercitizen" name="grandfather_citizen" class="form-control" value="{{ old('grandfather_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="grandmother_name" class="form-label"> {{ 'Grandmother Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mgmothernp" name="grandmother_np" class="form-control" value="{{ old('grandmother_np') }}">
											</div>
											
											<div class="col-4">
												<label for="grandmother_name" class="form-label"> {{ 'हजुरआमाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mgmothername" name="grandmother_name" class="form-control" value="{{ old('grandmother_name') }}">
											</div>
											
											<div class="col-4">
												<label for="grandmother_citizen" class="form-label"> {{ 'हजुरआमाको नागरिकता नम्बर' }}</label>
												<input type="text" id="mgmothercitizen" name="grandmother_citizen" class="form-control" value="{{ old('grandmother_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="mother_name" class="form-label"> {{ 'Mother Name' }} <span style="color: red">*</span></label>
												<input type="text" id="mmothername" name="mother_name" class="form-control" value="{{ old('mother_name') }}">
											</div>
											
											<div class="col-4">
												<label for="mother_np" class="form-label"> {{ 'आमाको नाम' }} <span style="color: red">*</span></label>
												<input type="text" id="mmothernp" name="mother_np" class="form-control" value="{{ old('mother_np') }}">
											</div>
											
											<div class="col-4">
												<label for="mother_citizen" class="form-label"> {{ 'आमाको नागरिकता नम्बर' }} <span style="color: red">*</span></label>
												<input type="text" id="mmothercitizen" name="mother_citizen" class="form-control" value="{{ old('mother_citizen') }}">
											</div>
											
											<div class="col-4">
												<label for="spouse_name" class="form-label"> {{ 'Spouse Name' }}</label>
												<input type="text" name="spouse_name" class="form-control" value="{{ old('spouse_name') }}">
											</div>
											
											<div class="col-4">
												<label for="spouse_np" class="form-label"> {{ 'पति/पत्नीको नाम' }}</label>
												<input type="text" name="spouse_np" class="form-control" value="{{ old('spouse_np') }}">
											</div>
											
											<div class="col-4">
												<label for="spouse_citizen" class="form-label"> {{ 'पति/पत्नीको नागरिकता नम्बर' }} </label>
												<input type="text" name="spouse_citizen" class="form-control" value="{{ old('spouse_citizen') }}">
											</div>
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to General</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-contact-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Contact</button>
										</div>
									</div>		

									<div class="tab-pane fade" id="steparrow-contact-info" role="tabpanel" aria-labelledby="steparrow-contact-info-tab">
										<div class="row">
											
											<div class="col-6">
												<label for="contact" class="form-label"> {{ 'सम्पर्क नम्बर' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<input type="text" name="contact_no" maxlength="10" class="form-control form-control-icon" value="{{ old('contact_no') }}">
													<i class="ri-phone-line"></i>
												</div>
											</div>
											
											<div class="col-6">
												<label for="mobile" class="form-label"> {{ 'मोबाइल' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<input type="text" name="mobile_no" maxlength="10" class="form-control form-control-icon" value="{{ old('mobile_no') }}">
													<i class="ri-cellphone-fill"></i>
												</div>
											</div>
											
											<div class="col-6">
												<!-- Input with Icon -->
												
												<label for="email" class="form-label"> {{ 'इमेल' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<input type="email" name="email" class="form-control form-control-icon" value="{{ old('email') }}">
													<i class="ri-mail-unread-line"></i>
												</div>
												
											</div>
											
											<div class="col-6">
												<label class="form-label" for="temporary_address">{{'अस्थायी ठेगाना'}}</label>
												<div class="form-icon">
													<input type="text" class="form-control form-control-icon" value="{{old('temporary_address')}}" name="temporary_address"  />
													<i class=" bx bx-home-circle"></i>
												</div>
											</div>
									
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-family-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Family</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-education-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Education</button>
										</div>
									</div>
									<!-- end tab pane -->

									<div class="tab-pane fade" id="steparrow-education-info" role="tabpanel" aria-labelledby="steparrow-education-info-tab">
										<div>
											<div class="mb-3">
												<label class="form-label" for="last_qualification">{{ 'अन्तिम योग्यता' }} <span style="color: red">*</span></label>
												<div class="form-icon">
													<select name="last_qualification" class="form-select form-control-icon" required>
														<option value="">{{"अन्तिम योग्यता चयन गर्नुहोस्"}}</option>
														<option value="N/A" {{old('last_qualification')=='N/A' ? 'selected' : ''}}>N/A</option>
														<option value="Under SLC" {{old('last_qualification')=='Under SLC' ? 'selected' : ''}}>Under SLC</option>
														<option value="SLC" {{old('last_qualification')=='SLC' ? 'selected' : ''}}>SLC</option>
														<option value="+2" {{old('last_qualification')=='+2' ? 'selected' : ''}}>+2</option>
														<option value="Bachelors" {{old('last_qualification')=='Bachelors' ? 'selected' : ''}}>Bachelors</option>
														<option value="Masters" {{old('last_qualification')=='Masters' ? 'selected' : ''}}>Masters</option>
														<option value="Phd" {{old('last_qualification')=='Phd' ? 'selected' : ''}}>Phd</option>
													</select>
													<i class="bx bxs-graduation"></i>
												</div>
												@if($errors->has('last_qualification'))
													<em class="invalid-feedback">
														{{ $errors->first('last_qualification') }}
													</em>
												@endif
											</div>
											<div>
												<label class="form-label" for="passed_year">Passed Year</label>
												<div class="form-icon">
													<input class="form-control form-control-icon" id="passed_year" value="{{old('passed_year')}}" type="text" name="passed_year"/>
													<i class="bx bx-calendar"></i>
												</div>
											</div>
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-contact-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Contact</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-medical-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Medical</button>
										</div>
									</div>
									<!-- end tab pane -->
									<div class="tab-pane fade" id="steparrow-medical-info" role="tabpanel" aria-labelledby="steparrow-medical-info-tab">
										<div class="row">
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
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-education-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Education</button>
											<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-documents-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Documents</button>
										</div>    
									</div>
									
									<div class="tab-pane fade" id="steparrow-documents-info" role="tabpanel" aria-labelledby="steparrow-documents-info-tab">
										<div class="row">
											<div class="col-10" style="padding-bottom:15px;font-size:16px;font-weight:500;">
												<span>To add more files, please click the 'Add' button.</span>
											</div>

											<div class="col-2 add-less-button" style="margin-bottom:15px;text-align:right;">
												<a href="javascript:;" id="add-more" class="btn btn-soft-success" type="button"><i class="ri-add-circle-line align-middle me-1"></i> Add</a> 

											</div>
											
											<div class="col-12">
												<div id="clone-container"> 
													<div class="clone-item employee-info-wrap">
														<div class="row">
															<div class="form-group col-4">
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
										</div>
										<div class="d-flex align-items-start gap-3 mt-4">
											<button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-education-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back to Education</button>
											<button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
										</div>
									</div>
								</div>
								<!-- end tab content -->
							</form>