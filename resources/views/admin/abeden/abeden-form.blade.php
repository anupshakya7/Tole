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
.table td:first-child{
  width:60px;
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
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
								<li class="breadcrumb-item active">{{$pageTitle}}</li>
							</ol>
						</div>

					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
			{{--<div class="card">						
					<div class="card-header border-bottom-dashed">
						<div class="row g-4 align-items-center">
							<div class="col-sm">
								<div>
									<h5 class="card-title mb-0">निवेदन फारम</h5>
								</div>
							</div>
							<div class="col-sm-auto abedanprint" style="display:none">
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
							{!!$abedenhtml!!}
							
						</div>
						@if($abeden->required_docs!='' || $abeden->required_docs!=NULL)
								{!!$abeden->required_docs!!}
							@endif
						<div class="col-md-12 text-end" style="margin-top:15px;">
							<button class="btn btn-success abedensubmit" memberid="{{$member->id}}" abedenid="{{$abeden->id}}" abedendate="{!!$datebs!!}">
								<input type="hidden" class="mabeden" value=""/>
								<i class="ri-save-line"></i> Save
							</button>  
						</div> 
					</div>
				</div>--}}
				<div class="card">
					<div class="card-header align-items-xl-center d-xl-flex">
						 <p class="text-muted flex-grow-1 mb-xl-0"></p>
						<div class="flex-shrink-0">
							<ul class="nav nav-pills card-header-pills" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-bs-toggle="tab" href="#nepali" role="tab">
										नेपाली
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#english" role="tab">
										English
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="card-body">
						<!-- Tab panes -->
						<div class="tab-content text-muted">
							<div class="tab-pane active" id="nepali" role="tabpanel">
								<div class="row">
									<div class="abedan-form">							
										{!!$abedenhtml!!}
										
									</div>
									@if($abeden->required_docs!='' || $abeden->required_docs!=NULL)
											{!!$abeden->required_docs!!}
										@endif
									<div class="col-md-12 text-end" style="margin-top:15px;">
										<button class="btn btn-success abedensubmit" memberid="{{$member->id}}" abedenid="{{$abeden->id}}" abedendate="{!!$datebs!!}">
											<input type="hidden" class="mabeden" value=""/>
											<i class="ri-save-line"></i> Save
										</button>  
									</div> 
								</div>
								<!--end row-->
							</div>
							<div class="tab-pane active" id="english" role="tabpanel">
								<div class="row">
									<div class="abedan-form">							
										testing										
									</div>
										@if($abeden->required_docs!='' || $abeden->required_docs!=NULL)
											{!!$abeden->required_docs!!}
										@endif
									<div class="col-md-12 text-end" style="margin-top:15px;">
										<button class="btn btn-success abedensubmit" memberid="{{$member->id}}" abedenid="{{$abeden->id}}" abedendate="{!!$datebs!!}">
											<input type="hidden" class="mabeden" value=""/>
											<i class="ri-save-line"></i> Save
										</button>  
									</div> 
								</div>
								<!--end row-->
							</div>
						</div>
					</div><!-- end card-body -->
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
	
	$('.abedensubmit').on('click',function(){
		var memberid = $(this).attr('memberid');
		var abedenid = $(this).attr('abedenid');
		var abedendate = $(this).attr('abedendate');
		var abedanhtml = $('.abedan-form').html();
		$('.loader').addClass('loader-show');
		$('.loader').show();
		
		$.ajax({
			type:'post',
					url:"{{route('memberabeden.add')}}",
					data:{memberid:memberid,abedenid:abedenid,abedendate:abedendate,abedenhtml:abedanhtml},
					//dataType: "json",
					success: function(res){
						if(res=='success'){							
							$('.abedanprint').show();
							$('.loader').removeClass('loader-show');
							$('.loader').hide();
							$('.abedensubmit').css({'display':'none'});
							toastr.success("आबेदन सफलतापूर्वक थपियो");
						}else{							
							$('.loader').removeClass('loader-show');
							$('.loader').hide();
							toastr.success("आबेदन थप्न असमर्थ !!");
						}						
						
					},error:function(){
						$('.loader').removeClass('loader-show');
						$('.loader').hide();
						$('.abedanprint').hide();
						toastr.error('हाल डाटा प्रक्रिया गर्न असमर्थ !!');
					}
		});
		
	});
    $('.form-select').select2();
	var abeden = $('.abedan-form');
	
	$('.printabedan').on('click',function(){
     abeden.print();
	 //console.log($('.abedan-form').text());
	});
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

</script>
@endsection