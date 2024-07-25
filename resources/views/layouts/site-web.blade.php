<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-mode="dark" data-preloader="disable">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicons/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicons/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicons/favicon-16x16.png')}}">
	<link rel="manifest" href="{{asset('img/favicons/site.webmanifest')}}">

    <title>{{ 'Membership Registration' }}</title>
		
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
	
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    @yield('styles')
</head>

<body>
	<div id="layout-wrapper">
		@yield('content')
		 <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © वडा १ सर्वेक्षण
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                <a href="https://krizmatic.com/" target="_blank">Krizmatic</a> द्वारा डिजाइन र विकास
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
		
		 <!--start back-to-top-->
		<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
			<i class="ri-arrow-up-line"></i>
		</button>
		<!--end back-to-top-->
	</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script src="{{asset('js/main.js') }}"></script>
	<script src="{{asset('assets/js/pages/select2.init.js')}}"></script>
  <script>  	
	
	toastr.options = {
          "closeButton": true,
          "newestOnTop": true,
          "positionClass": "toast-top-right",
          "timeOut": 0,
          "extendedTimeOut": 0,
        };
		
	var _url = "settings";
      @if(Session::has("message"))
        toastr.success("{{session('message')}}")
      @endif
  </script>
    @yield('scripts')
</body>

</html>
