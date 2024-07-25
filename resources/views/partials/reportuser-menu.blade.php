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
				@can('users_manage')			
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