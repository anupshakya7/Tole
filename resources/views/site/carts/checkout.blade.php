@extends('site.layouts.site')

@section('pageTitle','Proceed ')

@section('content')

@section('styles')
<style>

.remove {
	display: block;
	width: 24px;
	height: 24px;
	font-size: 15px !important;
	line-height: 19px !important;
	border-radius: 100%;
	color: #ccc;
	font-weight: bold;
	text-align: center;
	border: 2px solid #ccc;
}
.has-border {
	border: 2px solid #111;
	padding: 15px 30px 30px;
}
td, th {
	font-size: .9em;
	padding: 0.5em;
}
thead th {
	line-height: 1.05;
	letter-spacing: .05em;
	text-transform: uppercase;
}
tbody th {
	text-transform: inherit;
	letter-spacing: 0;
	font-weight: normal;
}
.cart-amount {
	white-space: nowrap;
	color: #111;
	font-weight: bold;
}
.order-review {
	font-size: 1.1em;
	overflow: hidden;
	padding-top: 10px;
	font-weight: bolder;
	text-transform: uppercase;
}


/*new*/
.checkout-wrap .navs li{
	width: 50%;
}

.checkout-wrap .navs li a{
	width: auto;
    margin: 0;
    border-radius: 0;
}

.checkout-wrap .navs li:first-child a{
	border-right: 1px solid #fff;
}

.checkout-wrap .hvr-shutter-out-vertical:hover:before, 
.checkout-wrap .hvr-shutter-out-vertical:before{
	border-radius: 0;
}

.checkout-wrap .tab-content{
	
}

form{
  padding:0px 15px;
}
.error{
  color:red;
font-size:14px;
font-weight:normal;
padding: 10px 0px;
}
label.valid{
  display:none !important;
}
</style>
@endsection
<section class="breadcrumb text-center" aria-label="breadcrumbs">
	<div class="container">
		<h1>PROCEED</h1>
		<a href="/" title="Back to the frontpage">Home</a> <span aria-hidden="true" class="breadcrumb__sep">/</span> <span>Proceed</span> 
	</div>
</section>

	<!-----end title/Breadcrumb----->

<section class="innerpage-product-wrapper home-content-wrap">
	<div class="container">
		<div class="row"> @if(Cart::count()>0)
			<form id="checkoutform" action="{{ route('checkout.store') }}" method="POST" class="row">
					@csrf
			<div class="col-md-7">
				<!--static personal and company details form start-->
				<div class="checkout-wrap new-tab">
					<ul class="navs nav justify-content-center font-size18" role="tablist" id="myTab">
						<li class="active"> <a class="hvr-shutter-out-vertical" href="#personal" role="tab" data-toggle="tab">Personal Detail</a> </li>
						<li> <a class="hvr-shutter-out-vertical" href="#company" role="tab" data-toggle="tab">Company Detail</a> </li>
					</ul>
					
					<div class="tab-content">
						<div class="tab-pane fade in active" id="personal">
							<div class="tab_content">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="first_name" id="fname" placeholder="Your First Name *" required="">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="last_name" id="lname" placeholder="Your Last Name *" required="">
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number *" required="">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" name="location" class="form-control" id="location" placeholder="Your Location *" required="">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="email" id="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email Address *" required="">
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="company">
							<div class="tab_content">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="company_name" id="fname" placeholder="Company Name">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="company_address" id="fname" placeholder="Company Address">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="concerned_person" id="fname" placeholder="Concerned Person's Name">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="company_pan" id="fname" placeholder="Company Pan Number">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" name="company_contact" id="fname" placeholder="Contact Number">
										</div>
									</div>
								 </div>
							</div>
						</div>
					</div>
					<!--------end tab-------->
					<div class="clearfix"></div>
				</div>
				</div>
				<div class="col-md-5">
					<div class="col-inner has-border">
						<h3 class="order-review">Your order</h3>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<th>Product</th>
									<th>Total</th>
								</thead>
								<tbody>
									@foreach (Cart::content() as $item)
									<tr>
										<td>{{$item->model->sku}} <strong>x {{ $item->qty }}</strong></td>
										<td class="cart-amount"><strong>NPR. {{$item->model->price}}</td>
									</tr> 
									@endforeach
									{{--<tr>
										<td><strong>Tax (13%)</strong></td>
										<td class="cart-amount">NPR. {{Cart::tax()}}</td>
									</tr>--}}
									<tr>
										<td><strong>Total</strong></td>
										<td class="cart-amount">NPR. {{Cart::total()}}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<button class="button button-secondary button-winona" type="submit">
								<div class="content-original">Submit</div>
							</button>
						</div>
						
					</div>
				</div>
					</form>					
				@else
				<h3>No items in Cart!</h3>
				@endif
				
			<div class="clearfix"></div>
		</div>
	</div>
</section>

<!----end innerpage-------> 

@endsection

		