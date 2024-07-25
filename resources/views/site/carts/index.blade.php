@extends('site.layouts.site')
@section('pageTitle','Proceed ')
@section('content')
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <style>
        .remove{
display: block;
    width: 24px;
    height: 24px;
    font-size: 13px !important;
    line-height: 19px !important;
    border-radius: 100%;
    color: #ccc;
    font-weight: bold;
    text-align: center;
    border: 2px solid #ccc;
}
td,th{
	font-size:.9em;
	padding:0.5em;
}
thead th{	
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
.dropdown-menu li{
  padding: 8px 10px;
width:100%;
}
.dropdown-menu i {
  float:right;
}
.dropdown-menu button{
  padding:8px;
float:right;
}
.dropdown-menu li .product-sku{
  padding-right: 35px;
}
.addprd{  
  background:£1a88c2;
}
.loader{
  position:absolute;
  left:50%;
  top:25%;
  display:none;
}
    </style>
@endsection
<section class="breadcrumb text-center" aria-label="breadcrumbs">
  <div class="container">
    <h1>Quotations / Estimate</h1>
    <!--<a href="/" title="Back to the frontpage">Home</a> 
    <span aria-hidden="true" class="breadcrumb__sep">/</span>
    <span>Cart</span>-->
  </div>
</section>

<!-----end title/Breadcrumb----->
<section class="innerpage-product-wrapper home-content-wrap">
  <div class="container">
    <div class="row">
		 @if(Cart::count()>0)
            <div class="col-md-8 cart-products">
                <div class="table-responsive">
                <table class="table table-borderless">
                  <thead>
                    <tr>
                      <th colspan="3">PRODUCT</th>
                      <th>PRICE</th>
                      <th>QUANTITY</th>
                      <th>SUBTOTAL</th>
                    </tr>
                  </thead>
                  <tbody class="cartproducts">
						<img class="loader" width="30" src="https://i.gifer.com/ZZ5H.gif">
                      @foreach (Cart::content() as $item)
                        <tr>
                            <td style="padding:30px 0;text-align:center">
                                <button class="remove" data-id="{{$item->rowId}}"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </td>
                            <td><img class="img-responsive lozad" width="100" src="{{asset($item->model->getMedia('products')[0]->getUrl('tiny'))}}" data-src="{{asset($item->model->getMedia('products')[0]->getUrl('thumb'))}}" title="{{$item->model->sku}}" alt="{{$item->model->sku}}"></td>
                            <td>{{$item->model->sku}}</td>
                            <td class="cart-amount">NPR. {{$item->model->price.'.00'}}</td>
                            <td>
								<select class="quantity" data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->qty }}">
                                    @for ($i = 1; $i < 5 + 1 ; $i++)
                                        <option {{ $item->qty == $i ? 'selected' : '' }} data-qty="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
							</td>
                            <td class="cart-amount">NPR. {{ $item->subtotal }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
                </div>
				<div class="row">
				  <p class="col-md-2"><a class="btn shopping-link addmore" href="#">+ Add More</a></p>
				   @php $products = \App\Product::where([['status','=',1],['is_supplementary','=',0]])->get(); @endphp 
				  <ul class="dropdown-menu moreprd" style="display:none;">
					@foreach($products as $prd)
					<li>
						@foreach($prd->getMedia('products') as $img)
							<img class="lozad" width="50" data-src="{{asset($img->getUrl('thumb')) }}">
						@endforeach
						<span class="product-sku">{{$prd->sku}} <strong>NPR. {{$prd->price}}</strong></span>
						<button class="btn btn-xs shopping-link addtocart" data-id="{{$prd->id}}"><i class="fa fa-plus" aria-hidden="true"></i> </button>
					</li>
					@endforeach
				  </ul>	
				  <p class="col-md-2"><a class="btn shopping-link addsupplement" href="#">+ Add Supplement</a></p>
				   @php $products = \App\Product::where([['status','=',1],['is_supplementary','=',1]])->get(); @endphp 
				  <ul class="dropdown-menu prdsupplement" style="display:none;">
					@foreach($products as $prd)
					<li>
						@foreach($prd->getMedia('products') as $img)
							<img class="lozad" width="50" data-src="{{asset($img->getUrl('thumb')) }}">
						@endforeach
						<span class="product-sku">{{$prd->sku}} <strong>NPR. {{$prd->price}}</strong></span>
						<button class="btn btn-xs shopping-link addtocart" data-id="{{$prd->id}}"><i class="fa fa-plus" aria-hidden="true"></i> </button>
					</li>
					@endforeach
				  </ul>	
				</div>
            </div>
            <div class="col-md-4 cartprices">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
							<th colspan="3">CART TOTALS</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
							<img class="loader" width="30" src="https://i.gifer.com/ZZ5H.gif">
                            <tr>
                                <th>Subtotal</th>
                                <td style="text-align:right;"><strong>NPR. <span class="cart-subtotal">{{Cart::subtotal()}}</span></strong></td>
                            <tr>
                            {{--<tr>
                                <th>Tax (13%)</th>
                                <td style="text-align:right;"><strong>NPR. <span class="cart-tax">{{Cart::tax()}}</span></strong></td>
                            <tr>--}}
                            <tr>
                                <th	>Total</th>
                                <td style="text-align:right;"><strong>NPR. <span class="cart-total">{{Cart::total()}}</span></strong></td>
                            <tr>
                        </tbody>
                    </table>
                </div>
				<div class="row">
					<p class="col-md-12"><a class="btn btn-block buyitnow" href="{{route('cart.checkout')}}">Proceed</a></p>
				</div>
            </div>
            @else
                <h3>No items in Cart!</h3>
            @endif			
      <div class="clearfix"></div>
    </div>
  </div>
</section>
@section("scripts")
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$('.cartproducts').on('change', '.quantity', function() {
        //$(".quantity").on("change",function(){
        var quantity = $(this).find(":selected").data('qty'); 
        var id = $(this).data('id'); 
         $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            type: "POST",
            dataType: "json",
            url: '{{route("cart.update")}}',
            data: {'quantity': quantity, 'id': id},
            success: function(data){
              console.log(data)
              toastr.success(data.message);
              setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 3000); 
            }
        });
    });
	
	$('.cartproducts').on('click', '.remove', function() {
        var id = $(this).data('id'); 
         $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            type: "POST",
            dataType: "json",
            url: '{{route("carts.destroy")}}',
            data: {'id': id},
            success: function(data){
              console.log(data)
              toastr.success(data.message);
              setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000); 
            }
        });
    });
	
	$(".addmore").on("click",function(){
		$(".moreprd").toggle();
	});
	
	$(".addsupplement").on("click",function(){
		$(".prdsupplement").toggle();
	});
	
	$(".addtocart").on("click",function(){
		var id = $(this).data('id');
		$('.loader').show();
		$(".cartprices").css("opacity", ".2");
		$(".cart-products").css("opacity", ".2");
		$('.dropdown-menu').hide();
		$.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            type: "POST",
            //dataType: "json",
            url: '{{route("cart.ajaxadd")}}',
            data: {'id': id},
            success: function(data){
				
				
              console.log(data)
			   setTimeout(function() {
                    if(data.message){
						toastr.success(data.message);
						$('.loader').hide();
						$(".cartprices").css("opacity", "1");
						$(".cart-products").css("opacity", "1");
						$('.cartproducts').html(data.content);						
					  }else{
						  $('.loader').hide();
						  $(".cartprices").css("opacity", "1");
						   $(".cart-products").css("opacity", "1");
						$('.cartproducts').html(data.content);
						//console.log(data.subtotal);
						$('.mini-cart-container').html(data.cartitems);
						$('.cart-subtotal').html(data.subtotal);
						$('.cart-tax').html(data.tax);
						$('.cart-total').html(data.total);
						$('.cartcount').html(data.count);
					  }
                }, 1000);
			  
            }
        });
	});
    </script>
@endsection
<!----end innerpage-------> 
@endsection