<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title') - {{ config('app.name') }}</title>
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

<body class="app header-fixed">
	<header class="app-header navbar">
		<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="{{ route('admin.home') }}">
			<span class="navbar-brand-full">{{ 'IoT' }}</span>
			<span class="navbar-brand-minimized">{{ 'IoT' }}</span>
		</a>
		
		<a href="{{ route('admin.home') }}" class="nav-link">
			<i class="nav-icon fas fa-fw fa-tachometer-alt">

			</i>
			{{ trans('global.dashboard') }}
		</a>
		{{--@php $user = auth()->user()->id;$unaccepted = \App\Installation::where(['status' => 0,'user_id' => $user,'accepted'=>0])->get(); @endphp
		 <nav class="navbar">
			<ul class="nav">
				 <li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell" aria-hidden="true"></i>
						<sup>
							<span class="badge badge-danger">{{$unaccepted->count()}}</span>
						</sup>
					</a>
					<div class="dropdown-menu dropdown-menu-lg">
						<a class="dropdown-item dropdown-header">{{$unaccepted->count()}} PENDING to ACCEPT</a>
						
						@foreach($unaccepted as $accept)
							<div class="assigned-details">
								<h3 class="dropdown-item-title">{{'Order #'.$accept->order_id}}</h3>
								<p class="text-sm">Assigned by {{$accept->creator->name}}</p>
								<span class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{$accept->created_at->diffForHumans()}}</span>
								<span class="float-right text-muted text-sm"><a class="btn btn-sm btn-primary" href="{{route('admin.install.accept',$accept->id)}}">Accept</a></span>
							</div>
							<div class="dropdown-divider"></div>
						@endforeach
						
					</ul>
					</div>
				</li>
			</ul>
		</nav>--}}
		<!--<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
			<span class="navbar-toggler-icon"></span>
		</button>-->

		<ul class="nav navbar-nav ml-auto">
				<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
					<i class="nav-icon fas fa-fw fa-sign-out-alt">

					</i>
					{{ trans('global.logout') }}
				</a>
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
	toastr.options = {
		  "closeButton": true,
		  "newestOnTop": true,
		  "positionClass": "toast-top-right",
		  "timeOut": 0,
		  "extendedTimeOut": 0,
		};

	// Enable pusher logging - don't include this in production
	Pusher.logToConsole = true;

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
	<script>
		$(function() {
  let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
  let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
  let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
  let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
  let printButtonTrans = '{{ trans('global.datatables.print') }}'
  let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'

  let languages = {
	'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
  $.extend(true, $.fn.dataTable.defaults, {
	language: {
	  url: languages['{{ app()->getLocale() }}']
	},
	columnDefs: [{
		orderable: false,
		className: 'select-checkbox',
		targets: 0
	}, {
		orderable: false,
		searchable: false,
		targets: -1
	}],
	select: {
	  style:    'multi+shift',
	  selector: 'td:first-child'
	},
	order: [],
	scrollX: true,
	pageLength: 100,
	dom: 'lBfrtip<"actions">',
	buttons: [
	  {
		extend: 'copy',
		className: 'btn-default',
		text: copyButtonTrans,
		exportOptions: {
		  columns: ':visible'
		}
	  },
	  {
		extend: 'csv',
		className: 'btn-default',
		text: csvButtonTrans,
		exportOptions: {
		  columns: ':visible'
		}
	  },
	  {
		extend: 'excel',
		className: 'btn-default',
		text: excelButtonTrans,
		exportOptions: {
		  columns: ':visible'
		}
	  },
	  {
		extend: 'pdf',
		className: 'btn-default',
		text: pdfButtonTrans,
		exportOptions: {
		  columns: ':visible'
		}
	  },
	  {
		extend: 'print',
		className: 'btn-default',
		text: printButtonTrans,
		exportOptions: {
		  columns: ':visible'
		}
	  },
	  {
		extend: 'colvis',
		className: 'btn-default',
		text: colvisButtonTrans,
		exportOptions: {
		  columns: ':visible'
		}
	  }
	]
  });

  $.fn.dataTable.ext.classes.sPageButton = '';
});

	</script>
	@yield('scripts')
</body>

</html>
