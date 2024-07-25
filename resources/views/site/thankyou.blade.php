@extends('site.layouts.site')
@section('pageTitle','Thank You')
@section('styles')
<style>.confirmation{
  margin:50px auto;
}
.thank-you-section{    padding:10% 0px;text-align:center;background-color: #fff;
	-webkit-box-shadow: rgb(0 0 0 / 25%) 0px 54px 55px, rgb(0 0 0 / 12%) 0px -12px 30px, rgb(0 0 0 / 12%) 0px 4px 6px, rgb(0 0 0 / 17%) 0px 12px 13px, rgb(0 0 0 / 9%) 0px -3px 5px;
	box-shadow: rgb(0 0 0 / 25%) 0px 54px 55px, rgb(0 0 0 / 12%) 0px -12px 30px, rgb(0 0 0 / 12%) 0px 4px 6px, rgb(0 0 0 / 17%) 0px 12px 13px, rgb(0 0 0 / 9%) 0px -3px 5px;
border-radius:15px;
min-height:450px;}.btn{padding: 10px 45px;background: #F15725;font-weight: 700;}
.card__success {
	position: absolute;
	top: -50px;
	left: 45%;
	width: 100px;
	height: 100px;
	border-radius: 100%;
	background-color: #60c878;
	border: 5px solid #fff;
}
.card__success i {
	color: #fff;
	line-height: 100px;
	font-size: 45px;
}
</style>
@endsection
@section('content')

	<div class="container confirmation">
		<div class="row">
			<div class="col-md-12">
				<div class="thank-you-section">
					<span class="card__success">
						<i class="fas fa-check" aria-hidden="true"></i>     
					</span>
				
					<h2>Thank You for your quotation.<br> Our Team will be in contact soon.</h2>
					<p style="text-align:center;">A confirmation email was sent</p>
					<div class="spacer"></div>
					<div>
					<button class="btn"><a href="{{ route('home') }}" style="color:#FFF;text-decoration:none;">Return Home</a></button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection