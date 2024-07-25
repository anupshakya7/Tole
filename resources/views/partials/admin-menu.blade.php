<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
	<!-- LOGO -->
	<div class="navbar-brand-box">
		<!-- Dark Logo-->
		<a href="{{route('admin.home')}}" class="logo logo-dark">
			<span class="logo-sm">
				<img src="{{asset('img/np-logo.png')}}" alt="" height="25">
			</span>
			<span class="logo-lg">
				<img src="{{asset('img/np-logo.png')}}" alt="" height="50">
			</span>
		</a>
		<!-- Light Logo-->
		<a href="{{route('admin.home')}}" class="logo logo-light">
			<span class="logo-sm">
				<img src="{{asset('img/np-logo.png')}}" alt="" height="25">
			</span>
			<span class="logo-lg">
				<img src="{{asset('img/np-logo.png')}}" alt="" height="50">
			</span>
		</a>
		<button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
			<i class="ri-record-circle-line"></i>
		</button>
	</div>

	<div id="scrollbar">
		<div class="container-fluid">
			<div id="two-column-menu">
			</div>
			<ul class="navbar-nav" id="navbar-nav">
				<li class="menu-title"><span data-key="t-menu">मेनु</span></li>
				<li class="nav-item">
					<a class="nav-link menu-link" href="{{route('admin.home')}}">
						<i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">ड्यासबोर्ड</span>
					</a>
				</li> <!-- end Dashboard Menu -->
				@if(auth()->user()->hasRole('surveyer'))
				{{--<li class="nav-item">
					<a href="{{ route('admin.house.remainder') }}" class="nav-link menu-link">
						<i class="ri-home-8-line"></i>
						<span data-key="t-home">{{ 'सर्वेक्षण हुन बाँकी घरहरू' }}</span>
					</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('admin.cbinsurvey.index') }}" class="nav-link menu-link">
							<i class="ri-survey-line"></i>
							<span data-key="t-home">{{ 'कम्पोस्टबिन सर्वेक्षण' }}</span>
						</a>
					</li>
					<li class="nav-item">
					<a class="nav-link menu-link" href="#compostbin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class="ri-survey-line"></i>
						<span data-key="t-usermanagement">{{ 'कम्पोस्टबिन सर्वेक्षण' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="compostbin">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.cbinsurvey.dashboard') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'कम्पोस्टबिन ड्यासबोर्ड' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.cbinsurvey.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'सम्पन्न सर्वेक्षण' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.cbinsurvey.cbintrue') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'प्रयोग भएका कम्पोस्टबिन ' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.house.remainder') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'सर्वेक्षण हुन बाँकी घरहरू' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.sinspection.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{' कम्पोस्टबिन निरीक्षण' }}</span>
								</a>
							</li>							
						</ul>
					</div>
					</li>--}}
					<li class="nav-item">
						<a href="{{ route('admin.sinspection.index') }}" class="nav-link menu-link">
							<i class="ri-home-8-line"></i>
							<span data-key="t-home">{{' कम्पोस्टबिन निरीक्षण' }}</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('admin.sinspection.create') }}" class="nav-link menu-link">
							<i class="ri-add-box-fill"></i>
							<span data-key="t-home">{{' कम्पोस्टबिन निरीक्षण थप्नुहोस्' }}</span>
						</a>
					</li>
					@php
						$distmenu = \App\Distribution::select('id','program_id')->groupBy('program_id')->get();
					@endphp
					{{--<li class="nav-item">
						<a class="nav-link menu-link" href="#distribution" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
							<i class="ri-pin-distance-fill"></i>
							<span data-key="t-sliders">{{ 'वितरण कार्यक्रम' }}</span>
						</a>
						<div class="collapse menu-dropdown" id="distribution">
							<ul class="nav nav-sm flex-column">
								<li class="nav-item">
									<a href="{{ route('admin.distribution.create') }}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'वितरण थप्नुहोस्' }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.distribution.all') }}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'सबै वितरणहरु' }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.distribution.exclude')}}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'वितरण हुन बाकी क्यालेन्डर र झोला' }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.distribution.report',10) }}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'क्यालेन्डर  र झोला रिपोर्ट' }}</span>
									</a>
								</li>		
							</ul>
						</div>
					</li>--}}	
				@elseif(auth()->user()->hasRole('medical'))		
					<li class="nav-item">
						<a class="nav-link menu-link" href="#medsurvey" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
							<i class="ri-survey-line"></i>
							<span data-key="t-usermanagement">{{ 'मेडिकल सर्वेक्षण' }}</span>
						</a>
						<div class="collapse menu-dropdown" id="medsurvey">
							<ul class="nav nav-sm flex-column">								
								<li class="nav-item">
									<a href="{{ route('admin.medsurvey.index') }}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'मेडिकल सर्वेक्षण सुची' }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.medsurvey.create') }}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'मेडिकल सर्वेक्षण थप्नुहोस्' }}</span>
									</a>
								</li>							
							</ul>
						</div>
					</li>	
				@else
				@can('users_manage')	
				<li class="nav-item">
					<a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class="ri-account-circle-line"></i> 
						<span data-key="t-usermanagement">{{ 'प्रयोगकर्ता व्यवस्थापन' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="sidebarAuth">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.permissions.index') }}" class="nav-link">{{ 'अनुमति' }}</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.roles.index') }}" class="nav-link">{{ 'भूमिका' }}</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.users.index') }}" class="nav-link">{{ 'प्रयोगकर्ता' }}</a>
							</li>

							<li class="nav-item">
								<a href="{{ route('auth.change_password') }}" class="nav-link">
									{{'पासवर्ड रिसेट'}}
								</a>
							</li>
						</ul>
					</div>
				</li>						
				@endcan
				<li class="nav-item">
					<a class="nav-link menu-link" href="#digitalprofile" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class="ri-account-circle-fill"></i>
						<span data-key="t-sliders">{{ 'डिजिटल प्रोफाइल' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="digitalprofile">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.member.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'सदस्य' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.member.seniorctzn') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'जेष्ठ नागरिक' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.member.seniorctznsixty') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'जेष्ठ नागरिक (६८ माथि)' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.member.seniorctznabovesixtyeight') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'जेष्ठ नागरिक (६८-७०)' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.membergroup.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'सदस्य समिति' }}</span>
								</a>
							</li>	
							<li class="nav-item">
								<a  data-bs-target="#displayabeden" data-bs-toggle="modal" href="" class="nav-link menu-link">
									<span data-key="t-home">{{ 'निवेदन दर्ता गर्नुहोस' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.abedan.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'दर्ता भएका निवेदनहरु' }}</span>
								</a>
							</li>	
							<li class="nav-item">
								<a href="{{ route('admin.sifaris.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'निवेदनका सिफारिसहरु' }}</span>
								</a>
							</li>								
						</ul>
					</div>
				</li>	
				<li class="nav-item">
					<a href="{{ route('admin.house.index') }}" class="nav-link menu-link">
						<i class="ri-home-8-line"></i>
						<span data-key="t-home">{{ 'घर धनि' }}</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.business.index') }}" class="nav-link menu-link">
						<i class="ri-home-8-line"></i>
						<span data-key="t-home">{{ 'व्यवसायिक घर' }}</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link menu-link" href="#compostbin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class="ri-survey-line"></i>
						<span data-key="t-usermanagement">{{ 'कम्पोस्टबिन सर्वेक्षण' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="compostbin">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.cbinsurvey.dashboard') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'कम्पोस्टबिन ड्यासबोर्ड' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.cbinsurvey.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'सम्पन्न सर्वेक्षण' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.cbinsurvey.cbintrue') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'प्रयोग भएका कम्पोस्टबिन ' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.house.remainder') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'सर्वेक्षण हुन बाँकी घरहरू' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.cbinsurvey.exclude') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'घर धनिको डाटा नभएको सर्वेक्षण ' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.sinspection.dashboard') }}" class="nav-link menu-link">
									<span data-key="t-home">{{' कम्पोस्टबिन निरीक्षण ड्यासबोर्ड' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.sinspection.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{' कम्पोस्टबिन निरीक्षण' }}</span>
								</a>
							</li>
						</ul>
					</div>
				</li>

				<li class="nav-item">
					<a class="nav-link menu-link" href="#medsurvey" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class="ri-survey-line"></i>
						<span data-key="t-usermanagement">{{ 'मेडिकल सर्वेक्षण' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="medsurvey">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.medsurvey.dashboard') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'मेडिकल सर्वेक्षण ड्यासबोर्ड' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.medsurvey.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'मेडिकल सर्वेक्षण सुची' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.house.remaindermedical') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'मेडिकल सर्वेक्षण हुन बाँकी घरहरू' }}</span>
								</a>
							</li>	
							<li class="nav-item">
								<a href="{{ route('admin.medsurvey.seniorabove68') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ '६८ वर्षभन्दा माथि वा सोभन्दा माथिका' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.medsurvey.childunder45') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ '45 दिन मुनिको बच्चा' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.medsurvey.create') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'मेडिकल सर्वेक्षण थप्नुहोस्' }}</span>
								</a>
							</li>							
						</ul>
					</div>
				</li>				
				@php
					$distmenu = \App\Distribution::select('id','program_id')->groupBy('program_id')->get();
				@endphp
				<li class="nav-item">
					<a class="nav-link menu-link" href="#distribution" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class="ri-pin-distance-fill"></i>
						<span data-key="t-sliders">{{ 'वितरण कार्यक्रम' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="distribution">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.distribution.create') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'वितरण थप्नुहोस्' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.distribution.all') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'सबै वितरणहरु' }}</span>
								</a>
							</li>	
							@foreach($distmenu as $dmenu)
							<li class="nav-item">
								<a href="{{ route('admin.distribution.index',$dmenu->program_id) }}" class="nav-link menu-link">
									<span data-key="t-home">{{ $dmenu->programs->title_np }}</span>
								</a>
							</li>
							@endforeach
							<li class="nav-item">
								<a href="#sidebarCrm" class="nav-link collapsed" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm" data-key="t-level-2.2">वितरण रिपोर्ट
								</a>
								<div class="collapse menu-dropdown" id="sidebarCrm">
									<ul class="nav nav-sm flex-column">
										@foreach($distmenu as $dmenu)
										<li class="nav-item">
											<a href="{{ route('admin.distribution.report',$dmenu->program_id) }}" class="nav-link menu-link">
												<span data-key="t-home">{{ $dmenu->programs->title_np }}</span>
											</a>
										</li>
										@endforeach
									</ul>
								</div>
							</li>		
						</ul>
					</div>
				</li>
								
				<li class="nav-item">
						<a class="nav-link menu-link" href="#events" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
							<i class="ri-pin-distance-fill"></i>
							<span data-key="t-sliders">{{ 'Events' }}</span>
						</a>
						<div class="collapse menu-dropdown" id="events">
							<ul class="nav nav-sm flex-column">
								<li class="nav-item">
									<a href="{{ route('admin.events.index') }}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'Events List' }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.participants.index') }}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'सबै सहभागीहरू' }}</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('admin.eventparticipants.index')}}" class="nav-link menu-link">
										<span data-key="t-home">{{ 'कार्यक्रमका सहभागीहरू' }}</span>
									</a>
								</li>	
							</ul>
						</div>
					</li>
				<li class="nav-item">
					<a href="{{ route('admin.program.index') }}" class="nav-link menu-link">
						<i class="ri-home-gear-line"></i>
						<span data-key="t-sliders">{{ 'कार्यक्रमहरू' }}</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('admin.abeden.index') }}" class="nav-link menu-link">
						<i class="ri-file-list-3-line"></i>
						<span data-key="t-sliders">{{ 'निवेदन ढाँचा' }}</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link menu-link" href="#messages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class=" ri-mail-send-line"></i>
						<span data-key="t-usermanagement">{{ 'सन्देशहरू' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="messages">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.sendsms.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'SMS' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.message.index') }}" class="nav-link menu-link">
									<span data-key="t-home">{{ 'Messages' }}</span>
								</a>
							</li>							
						</ul>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link menu-link" href="#setting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
						<i class="ri-settings-2-line"></i>
						<span data-key="t-usermanagement">{{ 'सेटिङ' }}</span>
					</a>
					<div class="collapse menu-dropdown" id="setting">
						<ul class="nav nav-sm flex-column">
							<li class="nav-item">
								<a href="{{ route('admin.occupation.index') }}" class="nav-link menu-link">
									<span data-key="t-sliders">{{ 'पेशाहरू' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.address.index') }}" class="nav-link menu-link">
									<span data-key="t-sliders">{{ 'ठेगाना' }}</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.tol.index') }}" class="nav-link menu-link">
									<span data-key="t-sliders">{{ 'टोल' }}</span>
								</a>
							</li>
							 
							<li class="nav-item">
								<a href="{{ route('settings.index') }}" class="nav-link menu-link">
									<span data-key="t-sliders">{{ 'सामान्य सेटिङ' }}</span>
								</a>
							</li>								
						</ul>
					</div>
				</li>					
				@endif
			</ul>
		</div>
		<!-- Sidebar -->
	</div>

	<div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>