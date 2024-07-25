@extends('site.layouts.site')
@section('pageTitle',$singlecat->title)
@section('content')
<!------start innerpage ------>
<!------start breadcrumb ------>
<section class="breadcrumb text-center" aria-label="breadcrumbs">
  <div class="container"> 
    <h1>{{$singlecat->title}}</h1>
    <a href="{{route('home')}}" title="Back to the frontpage">Home</a>
    <span aria-hidden="true" class="breadcrumb__sep">/</span>
    <span>{{$singlecat->title}}</span>
		{{--<div class="products-logo-wrap">
      <img class="lozad ezviz-logo-img" data-src="https://projects.shardait.com.np/iot_product/public/img/ezviz-logo.jpg">
      <img class="lozad hikvision-logo-img" data-src="https://projects.shardait.com.np/iot_product/public/img/hikvision-logo.jpg">
    </div>--}}
  </div>  
</section>
<!------start breadcrumb ------>
<!------start inner main page ------>
<section class="innerpage-product-wrapper home-content-wrap">
  <div class="container">
    <div class="row product-sort-row">
      <div class="col-md-3 product-sort-wrapper" id="product-sort-wrapper">
        <aside id="product-sort" class="product-sort">

          <div class="side-block-wrap">
            <div class="black font-size25 side-block-title">Category</div>
            <ul class="side-block-ul">
				@foreach($categories as $cat)
					<li><a href="{{route('shop.category.single',$cat->slug)}}" data-id="{{$cat->id}}" class="prod-cat"><i class="fas fa-ellipsis-v"></i>{{$cat->title}}</a></li>
				@endforeach
            </ul>
          </div>
        </aside>
      </div>
      <div class="col-md-9">
	  {{--<div class="sort-wrap">
          <select class="sort">
            <option>Sort by</option>
            <option>Sort by</option>
            <option>Sort by</option>
          </select>
        </div>--}}
		@foreach($products as $product)
        <div class="col-md-4 col-xs-6">
          <div class="innerpage-product-list-wrap product-list-wrap text-center">
			<a href="{{route('products.single',$product->slug)}}" target="_blank">
				<div class="product-list-image">
					@foreach($product->getMedia('products') as $img)
						<img class="lozad img-responsive" src="{{asset($img->getUrl('tiny')) }}" data-src="{{asset($img->getUrl('thumb')) }}" title="{{$product->title}}" alt="{{$product->title}}">
					@endforeach
					<div class="single_team_icon">
						<p class="text-center">
							<a class="hvr-icon-forward" title="View More" href="{{route('products.single',$product->slug)}}">
								<i class="fas fa-search"></i>
							</a>
						</p>
					</div>
				</div>
			</a>
            <p class="font-size20 black text-center text-uppercase">{{$product->sku}}</p>
            <p class="text-center gray">NRP. {{$product->price}}</p>
            <p class="gray padding-bottom30 text-center height-fixed">{{\Illuminate\Support\Str::limit($product->excerpt, 100)}}</p>
            <p class="text-center"><a class="shop-btn" href="{{route('cart.add',$product->id)}}">Add to Quote</a></p>
          </div>
        </div>
		@endforeach
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</section>
<!------end inner main page ------>
<!------end innerpage ------>
@endsection