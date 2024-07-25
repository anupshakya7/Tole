@extends('site.layouts.site')

@section('pageTitle','Home')

@section('content')

<!-----start slideshow----->

<section style="position:relative">

	<div id="myslideshow" class="carousel slide for-laptop-slider" data-ride="carousel"> 

		<!-- Wrapper for slides -->

		<div class="carousel-inner" role="listbox">

			@foreach($sliders as $i=>$slider)

			<div class="item @if($i==0) active @endif">

				<img data-src="{{asset('img/banner.jpg')}}" class="img-responsive lozad" title="{!!$slider->title!!}" alt="{!!$slider->title!!}" />

				<div class="carousel-caption ">

					<div class="container">

						<div class="col-md-6">

							<div class="content-title slider-title zoomIn text-uppercase">

								{!!$slider->title!!}

							</div>

							<p class="font-size30 black line-height-half">

								{{$slider->tagline}}	

							</p>

						</div>

						<div class="col-md-6">

							<img src="{{asset($slider->getMedia('sliders')[0]->getUrl('large')) }}" data-src="{{asset($slider->getMedia('sliders')[0]->getUrl('large')) }}" class="img-responsive lozad slider-img" title="{!!$slider->title!!}" alt="{!!$slider->title!!}">

						</div>

					</div>

					<div class="clearfix"></div>

				</div>

			</div>

			@endforeach      

		</div>

	</div>



	<!-- Left and right controls --> 
	@if(count($sliders)>1)
	<a class="left carousel-control" href="#myslideshow" data-slide="prev"> 

		<span class="left-arrow">

			<img class="lozad" data-src="{{asset('img/slider-left-arrow.png')}}">

		</span> 

		<span class="sr-only">Previous</span> 

	</a> 

	<a class="right carousel-control" href="#myslideshow" data-slide="next"> 

		<span class="right-arrow">

			<img class="lozad" data-src="{{asset('img/slider-right-arrow.png')}}">

		</span> 

		<span class="sr-only">Next</span> 

	</a> 
	@endif

</div>

<div class="clearfix"></div>

</section>

<!-----end slideshow----->



<!-----start product----->

<section class="product-wrap">

	<div class="col-md-12">

		@foreach($category as $cat)

		<div class="col-md-6">

			<div class="product-content-wrapper">

				@foreach($cat->getMedia('category') as $img)

				<img class="lozad img-responsive" src="{{asset($img->getUrl('tiny')) }}" data-src="{{asset($img->getUrl('front')) }}">

				@endforeach

				<div class="product-content-wrap">

					<div class="product-content-title font-size30 black">{{$cat->title}}</div>

					{!!$cat->description!!}

					<p class="font-size14"><a class="shop-btn" href="{{route('shop.category.single',$cat->slug)}}">Shop Now</a></p>

				</div>

			</div>

		</div>

		@endforeach

		<div class="clearfix"></div>

	</div>

	<div class="clearfix"></div>

</section>

<!----end product------->



<!-----start shop now----->

<section class="home-content-wrap shop-now-wrap">

	<div class="col-md-12">

		<div class="black font-size35 text-uppercase text-center padding-bottom30">Shop Your Product</div>

		<!--------start tab------>

		<div class="row">

			@foreach($products as $product)

			<div class="col-xs-6 col-md-3 col-lg-3">					

				<div class="product-list-wrap text-center">
					<div class="product-listing-wrapper">
					<div class="single_team_icon"><a href="{{route('products.single',$product->slug)}}" target="_blank"></a></div>
							<div class="product-list-image">

								@foreach($product->getMedia('products') as $img)

								<img class="lozad img-responsive rounded-circle" src="{{asset($img->getUrl('tiny')) }}" title="{{$product->sku}}" alt="{{$product->sku}}" data-src="{{asset($img->getUrl('thumb')) }}">

								@endforeach

								{{--<div class="single_team_icon">

									<p class="text-center">

										<a class="hvr-icon-forward" title="View More" href="{{route('products.single',$product->slug)}}">

											<i class="fas fa-search"></i>

											</a>

									</p>

								</div>--}}

							</div>

							<p class="font-size20 black text-center text-uppercase">{{$product->sku}}</p>

							<p class="text-center gray">NRP. {{$product->price}}</p>

							<p class="gray padding-bottom30 text-center height-fixed">{{\Illuminate\Support\Str::limit($product->excerpt, 100)}}</p>

						<!--</a>-->
						</div>

					<p class="text-center"><a class="shop-btn" href="{{route('cart.add',$product->id)}}">Add to Quote</a></p>

				</div>

			</div>

			@endforeach

		</div>

			<!--------end tab-------->

			<div class="clearfix"></div>



		</div>

	</div>

	<div class="clearfix"></div>



</section>

<!----end shop now------->



<!-----start video----->

<section class="video-wrap">

	<img class="lozad img-responsive video-img" data-src="{{asset('img/video-img.jpg')}}">

	<div class="video-icon-wrap ">

		<a href="#" data-toggle="modal" data-target="#videoModal"><i class="fas fa-play"></i></a>

	</div>

</section>

<!----end video------->



<!-----start quote----->

<section class="quote-wrap">

	<div class="container">

		<div class="row">

			<div class="col-md-6">

				<div class="quote-content-wrapper">

					<div class="quote-content-wrap">

						<p class="text-uppercase black font-size30 padding-bottom30">Just one click away!<br>get a free quote in under 24hrs</p>

						<p class=""><a class="shop-btn" href="#">Get a Quote</a></p>

					</div>

				</div>

			</div>

			<div class="clearfix"></div>

		</div>

	</div>

</section>

<!----end quote------->



<!-----start testimonial----->

<section class="home-content-wrap testimonial-wrap">

	<div class="container">

		<div class="row">

			<div class="black font-size35 text-uppercase text-center padding-bottom30">Testimonials</div>

			<div class="owl-carousel owl-theme">

				@foreach($testimonials as $data)

				<div class="item">

					<div class="box">

						<div class="testimonial-content-wrap">

							<div class="testimonial-image">

								@foreach($data->getMedia('testimonials') as $img)

								<img class="lozad img-responsive" src="{{asset($img->getUrl('tiny')) }}" data-src="{{asset($img->getUrl('thumb')) }}">

								@endforeach

							</div>

							<p class="text-center black testimonial-content-height-fixed"><i class="fas fa-quote-left"></i> {{$data->excerpt}}</p>

							<p class="text-center blue font-size18"><a href="">{{$data->title}}</a></p>

						</div>

					</div>

				</div>

				@endforeach

			</div>

			<div class="clearfix"></div>

		</div>

	</div>

</section>

<!----end testimonial------->

<!--start popup video Modal-->

<div class="modal videoModal fade" id="videoModal" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">

	<div class="modal-dialog" role="document">

		<div class="modal-content">



			<div class="modal-body">

				<iframe width="100%" height="315" src="https://www.youtube.com/embed/417ciXflOTY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

				<button type="button" class="btn btn-default closes" data-dismiss="modal"><i class="fas fa-times"></i></button>

			</div>

		</div>

	</div>

</div>

<!--end popup video Modal-->

@endsection

