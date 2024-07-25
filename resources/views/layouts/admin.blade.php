<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ 'Ward 1 Digital Profile' }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@2.1.16/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css" rel="stylesheet">
    
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    @yield('styles')
	<style>nav .fa{font-size:18px;}</style>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full">{{ 'IoT' }}</span>
            <span class="navbar-brand-minimized">{{ 'IoT' }}</span>
        </a>
        <!--<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>-->
		@if(Auth()->user()->hasRole('administrator'))
		@php $logs = \App\ActivityLog::where(['log_name' => 'default','viewed_at' => NULL])->orderBy('created_at','DESC')->get(); @endphp
		 <nav class="navbar">
			<ul class="nav">
				 <li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell" aria-hidden="true"></i>
						<sup>
							<span class="logcount badge badge-danger">{{$logs->count()}}</span>
						</sup>
					</a>
					<div class="dropdown-menu dropdown-menu-lg">
						<a class="dropdown-item dropdown-header"><span class="logcount">{{$logs->count()}}</span> NOTIFICATION</a>
						<div class="admin-notifications">
						@foreach($logs as $log)
							<div class="assigned-details">
								<p class="text-sm">{{$log->description}}</p>
								<span class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{$log->created_at->diffForHumans()}}</span>
								<span class="float-right text-muted text-sm"><a class="btn btn-sm btn-success" href="{{route('admin.viewed',$log->id)}}">SET AS VIEWED</a></span>
							</div>
							<div class="dropdown-divider"></div>
						@endforeach
						</div>
					</ul>
					</div>
				</li>
			</ul>
		</nav>
		@endif	
        <ul class="nav navbar-nav ml-auto">
            @if(count(config('panel.available_languages', [])) > 1)
                <li class="nav-item dropdown d-md-down-none">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                            <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
            @endif


        </ul>
    </header>

    <div class="app-body">
		@if(Auth()->user()->hasRole('technician'))
			
		@else
			@include('partials.menu')
		@endif
        <main class="main">


            <div style="padding-top: 20px" class="container-fluid">
                @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')

            </div>


        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
    
    <script src="{{ asset('js/main.js') }}"></script>
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
					console.log(data.length);
					$('.logcount').html(data.length);
					var cont = "";
					 $(data).each(function(i,element){
						console.log(data);
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

    // Enable pusher logging - don't include this in production
    //Pusher.logToConsole = true;

    var pusher = new Pusher('9bce621b8171d3f8b9af', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        toastr.warning(data.message)
        //console.log(JSON.stringify(data));
        //alert(JSON.stringify(data.message));
    });
  </script>

    @yield('scripts')
</body>

</html>
