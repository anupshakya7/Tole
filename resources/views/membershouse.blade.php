@extends('layouts.membershouse-web')
@section('title') {{ "Dashboard" }} @endsection
@section('styles')
<style>
    .dash-card .title{
    font-size: 14px;
    color: #3a3a3a;
    text-transform: uppercase;
}
.dash-card .data{
    padding-top: 13px;
    font-size: 32px;
    color: #0041ff;
}
.dash-card .data .progress {
    font-size: 14px;
    color: #8e8e8e;
    float: right;
    margin-top: -2px;
}
.dash-card .data .progress .icon{
        vertical-align: middle;
}
.graph-up-icon {
    background-image: url({{asset('img/Icon-Graph-Green.svg')}});
    width: 24px;
    height: 24px;
}
</style>
@endsection
@section('content')
	        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
		
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
@endsection
@section('scripts')
@parent
<script>

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