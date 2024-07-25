@extends('layouts.admin-web')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
button{border:none;background-color:transparent;}thead{display:table-row-group;}tfoot{display:table-header-group;}
.loader{
    position: absolute;
    z-index: 99999;
    content: '';
    background: rgba(0,0,0,0.54);
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
	display:none;
}
.loader-show{
	display: flex !important;
}
</style>
<div class="loader">
	<a href="javascript:void(0);" class="text-success"><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2" style="font-size:70px !important;"></i></a>
</div>
<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-sm-flex align-items-center justify-content-between">
						<h4 class="mb-sm-0">{{$pageTitle}}</h4>

						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">Ward Survey</a></li>
								<li class="breadcrumb-item active">{{$pageTitle}}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="card">						
					<div class="card-header border-bottom-dashed">
						<div class="row g-4 align-items-center">
							<div class="col-sm">
								<div>
									<h5 class="card-title mb-0">{{ $pageTitle }}</h5>
								</div>
							</div>
							<div class="col-sm-auto abedanprint">
								<div class="d-flex flex-wrap align-items-start gap-2">
									<a class="btn btn-soft-success printabedan" href="#">
										<i class="ri-printer-line align-middle me-1"></i> {{'Print'}}
									</a>
								</div>
							</div>
						</div>
					</div>
						
					<div class="card-body">
						<div class="abedan-form">							
							{!!$memberabedan->description!!}							   
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
@endsection
@section('scripts')
@parent
<script src="{{asset('js/print.min.js')}}"></script>
<script>
$(document).ready(function() {
	
	
	$('.printabedan').on('click',function(){
     $('.abedan-form').print();
	 //console.log($('.abedan-form').text());
	});
});

</script>
@endsection