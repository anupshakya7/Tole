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
								<li class="breadcrumb-item"><a href="{{route('admin.home')}}">वडा सर्वेक्षण</a></li>
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
									<h5 class="card-title mb-0">सिफारिस फारम</h5>
								</div>
							</div>
							<div class="col-sm-auto sifarisprint" style="display:none">
								<div class="d-flex flex-wrap align-items-start gap-2">
									<a class="btn btn-soft-success printsifaris" href="#">
										<i class="ri-printer-line align-middle me-1"></i> {{'Print'}}
									</a>
								</div>
							</div>
						</div>
					</div>
						
					<div class="card-body">
						<div class="row">
							<div class="abedan-form" style="display:none">
							{!!$abedan->description!!}
							</div>
							<div class="sifaris-form col-12">							
								{!!$sifarishtml!!}							   
							</div>
							<div class="col-12 text-end" style="margin-top:15px;">
								<button class="btn btn-success sifarissubmit" memberid="{{$abedan->member_id}}" memberabedanid="{{$memberabedanid}}" abedenid="{{$abedan->abeden_id}}" abedendate="{!!$datebs!!}">
									<input type="hidden" class="msifaris" value=""/>
									<i class="ri-save-line"></i> Save
								</button>  
							</div> 
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
	
	//changing value that is inside of label with id shree
	var selected = $('.abedan-form');
	var abedandesc = selected.find('#shree').text();
	$('#titlename').text(abedandesc);
	
	var takernm = selected.find('#taker_name').text();
	$('#taker').text(takernm);
	
	var giver = selected.find('#giver_name').text();
	$('#giver').text(giver);
	
	var nagarpalika = selected.find('#nagarpalika').text();
	$('#npalika').text(nagarpalika);
	
	var wada = selected.find('#wada').text();
	$('#woda').text(wada);
	
	var kitta = selected.find('#kitta').text();
	$('#citta').text(kitta);
	
	var area = selected.find('#area').text();
	$('#chetra').text(area);
	
	var remark = selected.find('#remarks').text();
	$('#kaifiyat').text(remark);
	
	
	//calling ajax to submit data to membersifaris table
	$('.sifarissubmit').on('click',function(){
		var memberid = $(this).attr('memberid');
		var memberabedanid = $(this).attr('memberabedanid');
		var abedenid = $(this).attr('abedenid');
		var abedendate = $(this).attr('abedendate');
		var sifarishtml = $('.sifaris-form').html();
		$('.loader').addClass('loader-show');
		$('.loader').show();
		//console.log(memberid,abedenid,abedendate,abedanhtml);
		$.ajax({
			type:'post',
					url:"{{route('membersifaris.add')}}",
					data:{memberid:memberid,abedenid:abedenid,abedendate:abedendate,memberabedanid:memberabedanid,sifarishtml:sifarishtml},
					//dataType: "json",
					success: function(res){
						console.log(res);
						if(res=='success'){							
							$('.sifarisprint').show();
							$('.loader').removeClass('loader-show');
							$('.loader').hide();
							$('.sifarissubmit').css({'display':'none'});
							toastr.success("आबेदन सफलतापूर्वक थपियो");
						}else{							
							$('.loader').removeClass('loader-show');
							$('.loader').hide();
							$('.sifarisprint').hide();
							toastr.success("आबेदन थप्न असमर्थ !!");
						}					
						
					},error:function(){
						$('.loader').removeClass('loader-show');
						$('.loader').hide();
						$('.sifarisprint').hide();
						toastr.error('हाल डाटा प्रक्रिया गर्न असमर्थ !!');
					}
		});
		
	});
	var sifaris = $('.sifaris-form');
	
	$('.printsifaris').on('click',function(){
     sifaris.print();
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