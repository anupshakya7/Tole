<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicons/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicons/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicons/favicon-16x16.png')}}">
	<link rel="manifest" href="{{asset('img/favicons/site.webmanifest')}}">

    <title>@yield('title') - {{ config('app.name') }}</title>
	
	 <!-- jsvectormap css -->
    <link href="{{asset('assets/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{asset('assets/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
	
	<script src="{{asset('assets/js/layout.js')}}"></script>
	
	<!-- Bootstrap Css -->
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
	
	<!-- App Css-->
	<link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
	
	<!-- custom Css-->
	<link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
	
	<link href="{{asset('assets/css/select.init.css')}}" rel="stylesheet" type="text/css" />
	
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css" rel="stylesheet">
    @yield('styles')
</head>

<body>
	<div id="layout-wrapper">
		<header id="page-topbar">
			<div class="layout-width">
				<div class="navbar-header">
					<div class="d-flex">
						<!-- LOGO -->
						<div class="navbar-brand-box horizontal-logo">
							<a href="index.html" class="logo logo-dark">
								<span class="logo-sm">
									<img src="{{asset('img/np-logo.png')}}" alt="" height="22">
								</span>
								<span class="logo-lg">
									<img src="{{asset('img/np-logo.png')}}" alt="" height="17">
								</span>
							</a>

							<a href="index.html" class="logo logo-light">
								<span class="logo-sm">
									<img src="{{asset('img/np-logo.png')}}" alt="" height="22">
								</span>
								<span class="logo-lg">
									<img src="{{asset('img/np-logo.png')}}" alt="" height="17"> 
								</span>
							</a>
						</div>

						<button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
							<span class="hamburger-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>
					   
					</div>

					<div class="d-flex align-items-center">
						@php 
							$user = \Auth::user()->id;$today = \Carbon::today();
							$allsurvey = \App\SurveyInspection::where('user_id',\Auth::user()->id)->count();
							$currsurvey = \App\SurveyInspection::where([['user_id',$user]])->whereDate('created_at',$today)->count();
							//var_dump($currsurvey);
						@endphp
						
						<div class="ms-1 header-item d-sm-flex">
							 <a class="btn btn-warning btn-sm">आजको निरीक्षण</a>
							<span class="topbar-badge translate-middle badge rounded-pill bg-info">{{$currsurvey}}</span>
						</div>
						
						<div class="ms-1 header-item d-sm-flex">
							 <a href="{{route('admin.cbinsurvey.index')}}" class="btn btn-warning btn-sm">कुल गरिएको निरीक्षण</a>
							<span class="topbar-badge translate-middle badge rounded-pill bg-info">{{$allsurvey}}</span>
						</div>
						{{--<div class="ms-1 header-item d-sm-flex">
							 <a class="btn btn-warning btn-sm">आजको सर्वेक्षण नम्बर </a>
							<span class="topbar-badge translate-middle badge rounded-pill bg-info">{{$currsurvey}}</span>
						</div>
						
						<div class="ms-1 header-item d-sm-flex">
							 <a href="{{route('admin.cbinsurvey.index')}}" class="btn btn-warning btn-sm">कुल निरीक्षण नम्बर</a>
							<span class="topbar-badge translate-middle badge rounded-pill bg-info">{{$allsurvey}}</span>
						</div>--}}
						
						
						<!--button to add compostbin survey-->
						{{--<div class="ms-1 header-item d-sm-flex">
							<a class="btn btn-soft-success" href="{{ route('admin.cbinsurvey.create') }}">
								<i class="ri-add-circle-line align-middle me-1"></i> {{ trans('global.add') }} {{ 'Compostbin Survey data' }}
							</a>
						</div>--}}
						
						<div class="ms-1 header-item d-sm-flex">
							<a class="btn btn-soft-success" href="{{ route('admin.sinspection.create') }}">
								<i class="ri-add-circle-line align-middle me-1"></i> {{ 'निरीक्षण थप्नुहोस्' }}
							</a>
						</div>
						
						
						<!--enable full screen-->
						<div class="ms-1 header-item d-none d-sm-flex">
							<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
								<i class='bx bx-fullscreen fs-22'></i>
							</button>
						</div>
						
						<!--dark mode header-->
						<div class="ms-1 header-item d-none d-sm-flex">
							<button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
								<i class='bx bx-moon fs-22'></i>
							</button>
						</div>

						
						<div class="dropdown ms-sm-3 header-item topbar-user">
							<button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="d-flex align-items-center">
									@if(asset('avatar-'.auth()->id().'.png'))
										<img class="rounded-circle header-profile-user" src="{{asset('storage/avatar-'.auth()->id().'.png')}}" alt="Header Avatar">
									@else
										<img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="Header Avatar">
									@endif
									<span class="text-start ms-xl-2">
										<span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{\Auth::user()->name}}</span>
										<?php 
											$role = \Auth::user()->getRoleNames(); 
											foreach($role as $rol):
										?>
										<span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{$rol}}</span>
										<?php endforeach;?>
									</span>
								</span>
							</button>
							<div class="dropdown-menu dropdown-menu-end">
								<!-- item-->
								<h6 class="dropdown-header">Welcome {{\Auth::user()->name}}!</h6>
									{{--<a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
								<a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
								<a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
								<a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
								<a class="dropdown-item" href="{{ route('admin.users.edit', \Auth::user()->id) }}"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
								<a class="dropdown-item" href="{{route('locked')}}"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>--}}
								@if(session('impersonated_by'))
									<a class="dropdown-item" href="{{route('admin.impersonate_leave')}}"><i class="ri-logout-box-line text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Back to my Account</span></a>
								@endif
								<a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		
		@include('partials.admin-menu')
		
		@yield('content')
		
		<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
		
		 <!--start back-to-top-->
		<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
			<i class="ri-arrow-up-line"></i>
		</button>
		<!--end back-to-top-->
	</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script> 
	<script src="{{asset('assets/js/plugins.js')}}"></script>

    <!-- apexcharts -->
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
	
	<!-- Vector map-->
    <script src="{{asset('assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{asset('assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

    <!--Swiper slider js-->
    <script src="{{asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Dashboard init -->
    <script src="{{asset('assets/js/pages/dashboard-ecommerce.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>	
	<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.53/build/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
    
    <script src="{{asset('js/main.js') }}"></script>
	<script src="{{asset('assets/js/pages/select2.init.js')}}"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>  
	$(document).ready(function () {
		/*function to call ajax on specified interval of time*/
		setInterval(function(){
		time()
		},3000);
		
		function time(){
			//var dt = new Date();
			//$('#autodiv').text(dt.getHours()+" : "+dt.getMinutes()+" : "+dt.getSeconds());
			var notificationsurl = "{{route('admin.notifications')}}";
			//console.log(notificationsurl);
			$.ajax({
				url: notificationsurl,
				dataType: 'json',
				success: function(data){
					//console.log(data.length);
					$('.logcount').html(data.length);
					var cont = "";
					 $(data).each(function(i,element){
						//console.log(data);
						//console.log(this.description);
						var route = '{{ route("admin.viewed", ":id") }}';
						route = route.replace(':id', element.id);
						var created = moment(element.created_at).fromNow();
						//console.log(created); 
						cont += ("<div class='assigned-details'><p class='text-sm'>"+element.description+"</p><span class='text-sm text-muted'><i class='far fa-clock mr-1'></i>"+created+"</span><span class='float-right text-muted text-sm'><a class='btn btn-sm btn-success' href='"+route+"'>SET AS VIEWED</a></span></div><div class='dropdown-divider'></div>");
						//$(".admin-notifications").html("<div class='assigned-details'><p class='text-sm'>"+element.description+"</p><span class='text-sm text-muted'><i class='far fa-clock mr-1'></i>"+element.created_at+"</span><span class='float-right text-muted text-sm'><a class='btn btn-sm btn-success' href='"+route+"'>SET AS VIEWED</a></span></div><div class='dropdown-divider'></div>");
					}) 
					$(".admin-notifications").html(cont);
				}
			});
		} 
	});
	
	
	toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right",
          "timeOut": 0,
          "extendedTimeOut": 0,
        };
  </script>
    @yield('scripts')
</body>

</html>
