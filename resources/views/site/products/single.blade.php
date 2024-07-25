@extends('site.layouts.site')
@section('pageTitle','Product: '.$products->title)
@section('content')

<section class="breadcrumb text-center" aria-label="breadcrumbs">
  <div class="container">
    <h1>{{$products->sku}}</h1>
    <a href="/" title="Back to the frontpage">Home</a> 
    <span aria-hidden="true" class="breadcrumb__sep">/</span>
    <span>{{$products->title}}</span>
    <div class="products-logo-wrap">
      <img class="lozad" data-src="{{asset('img/hikvision-logo.jpg')}}">
    </div>
  </div> 
</section>
<!------start breadcrumb ------>
<!------start inner main page ------>
<section class="innerpage-product-wrapper home-content-wrap">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="product-detail-image">
          <div class="gallerys">
            <div class="gallerys-preview">
              <div class="gallery-image"> 
					<a href="{{asset($products->getMedia('gallery')[0]->getUrl('thumb')) }}" data-toggle="lightbox" data-gallery="example-gallery">
						<img class="img-responsive" src="{{asset($products->getMedia('gallery')[0]->getUrl('thumb')) }}" class="img-fluid"> 
					</a>            
              </div>
            </div>
            <div class="gallerys-thumbs">
				<div class="owl-carousel owl-theme">
					@foreach($products->getMedia('gallery') as $img)
						<div class="item" data-ref="{{asset($img->getUrl('thumb')) }}" style="background-image: url({{asset($img->getUrl('thumb')) }})"></div>
					@endforeach
				</div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-md-8">
        <div class="font-size25 black text-uppercase">{{$products->title}}</div>
        
        <p>{!!$products->overview!!}</p>
		<table class="product-table">
          <tr>
            <td>Price :</td>
            <td>Nrs. {{$products->price}}</td>
          </tr>
          <tr>
            <td>Brand : </td>
            <td>{{$products->brand->name}}</td>
          </tr>
          {{--<tr>
            <td>Availability : </td>
            <td>@if($products->quantity>0) {{"In stock"}} @endif</td>
          </tr>--}}
          <tr>
            <td>Quantity : </td>
            <td>
				<form action="{{route('cart.store')}}" method="POST">
					@csrf
					<input type="hidden" name="product_id" value="{{$products->id}}">
					<input type="hidden" name="product_name" value="{{$products->sku}}">
					<input type="hidden" name="product_price" value="{{$products->price}}">
					<div class="flex">
						<button class="btn" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
						  <i class="fas fa-minus"></i>
						</button>

						<input id="form1" min="0" name="quantity" value="1" type="number" class="form-control form-control-sm number-form">

						<button class="btn" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
						  <i class="fas fa-plus"></i>
						</button>
					</div>					
              </td>
            </tr>
          </table>
			<div class="row">
						<div class="col-md-3">
							<button type="submit" name="add" id="AddToCart" class="btn buyitnow" title="Add To Cart">
							  <span id="AddToCartText">Add to Quote</span>
							</button>
						</div>
					</div>
				  </form>
          </div>
          <div class="clearfix">&nbsp;</div>
          <div class="col-md-12">
            <div class="new-tab">
              <ul class="nav nav-tabs" role="tablist" id="myTab">
                <li class="active "> <a href="#description" role="tab" data-toggle="tab"><b>Description</b></a></li>
                <li><a href="#specs" role="tab" data-toggle="tab"><b>Specifications</b></a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade in  active " id="description">
                  <div class="">
				  {!!$products->description!!}
                  </div>
                </div>
                <div class="tab-pane fade" id="specs">
                  <p><b>Model Parameters</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Name</th>
                      <td>C1C 720p</td>
                      <td>C1C 1080p</td>
                    </tr>
                    <tr>
                      <th>Model</th>
                      <td>CS-C1C-D0-1D1WFR</td>
                      <td>CS-C1C-D0-1D2WFR</td>
                    </tr>
                  </table>
                  <hr>
                  <p><b>Camera</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Image Sensor</th>
                      <td>1/4" Progressive Scan
                      CMOS</td>
                      <td>1/2.9" Progressive
                      Scan CMOS</td>
                    </tr>
                    <tr>
                      <th>Shutter Speed</th>
                      <td>Self-adaptive shutter</td>
                      <td>Self-adaptive shutter</td>
                    </tr>
                    <tr>
                      <th>Lens</th>
                      <td>2.8mm, view angle:92°
                      (Horizontal), 110°(Diagonal)</td>
                      <td>2.8mm, view angle:106°
                      (Horizontal), 130°(Diagonal)</td>
                    </tr>
                    <tr>
                      <th>Lens Mount</th>
                      <td>M12</td>
                      <td>M12</td>
                    </tr>
                    <tr>
                      <th>Day &amp; Night</th>
                      <td>IR-cut filter with
                      auto-switching</td>
                      <td>IR-cut filter with
                      auto-switching</td>
                    </tr>
                    <tr>
                      <th>DNR</th>
                      <td>3D DNR</td>
                      <td>3D DNR</td>
                    </tr>
                  </table>
                  <hr>
                  <p><b>Image</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Max. Resolution</th>
                      <td>1280 x 720</td>
                      <td>1920 x 1080</td>
                    </tr>
                    <tr>
                      <th>Frame Rate</th>
                      <td>Max. 25fps; Self-adaptive
                      during network transmission</td>
                      <td>Max. 20fps; Self-adaptive
                      during network transmission</td>
                    </tr>
                  </table>
                  <hr>
                  <p><b>Compression</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Video Compression</th>
                      <td>H.264</td>
                      <td>H.264</td>
                    </tr>
                    <tr>
                      <th>H.264 Type</th>
                      <td>Main profile</td>
                      <td>Main profile</td>
                    </tr>
                    <tr>
                      <th>Video Bit Rate</th>
                      <td>HD; Standard; Basic.
                      Adaptive bit rate</td>
                      <td>Ultra-HD; HD; Standard.
                      Adaptive bit rate</td>
                    </tr>
                    <tr>
                      <th>Auto Bit Rate</th>
                      <td>Self-adaptive</td>
                      <td>Self-adaptive</td>
                    </tr>
                    <tr>
                      <th>Max. Bitrate</th>
                      <td>2Mbps</td>
                      <td>2Mbps</td>
                    </tr>
                  </table>
                  <hr>
                  <p><b>Network</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Smart Alarm</th>
                      <td>Motion detection</td>
                      <td>Motion detection</td>
                    </tr>
                    <tr>
                      <th>Wi-Fi Pairing</th>
                      <td>AP pairing</td>
                      <td>AP pairing</td>
                    </tr>
                    <tr>
                      <th>Protocol</th>
                      <td>EZVIZ cloud proprietary
                      protocol</td>
                      <td>EZVIZ cloud proprietary
                      protocol</td>
                    </tr>
                    <tr>
                      <th>Interface Protocol</th>
                      <td>EZVIZ cloud proprietary
                      protocol</td>
                      <td>EZVIZ cloud proprietary
                      protocol</td>
                    </tr>
                    <tr>
                      <th>General Features</th>
                      <td>Anti-Flicker, Dual-Stream,
                      Heart Beat, Mirror Image, Password Protection, Watermark</td>
                      <td>Anti-Flicker, Dual-Stream,
                      Heart Beat, Mirror Image, Password Protection, Watermark</td>
                    </tr>
                  </table>
                  <hr>
                  <p><b>Interface</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Storage</th>
                      <td>Support Micro SD card (Max.
                      256G)</td>
                      <td>Support Micro SD card (Max.
                      256G)</td>
                    </tr>
                    <tr>
                      <th>Power</th>
                      <td>Micro USB</td>
                      <td>Micro USB</td>
                    </tr>
                  </table>
                  <hr>
                  <p><b>Wi-Fi</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Standard</th>
                      <td>IEEE802.11b, 802.11g,
                      802.11n</td>
                      <td>IEEE802.11b, 802.11g,
                      802.11n</td>
                    </tr>
                    <tr>
                      <th>Frequency Range</th>
                      <td>2.4 GHz ~ 2.4835 GHz</td>
                      <td>2.4 GHz ~ 2.4835 GHz</td>
                    </tr>
                    <tr>
                      <th>Channel Bandwidth</th>
                      <td>Supports 20MHz</td>
                      <td>Supports 20MHz</td>
                    </tr>
                    <tr>
                      <th>Security</th>
                      <td>64/128-bit WEP, WPA/WPA2,
                      WPA-PSK/WPA2-PSK</td>
                      <td>64/128-bit WEP, WPA/WPA2,
                      WPA-PSK/WPA2-PSK</td>
                    </tr>
                    <tr>
                      <th>Transmission Rate</th>
                      <td>11b: 11 Mbps, 11g: 54 Mbps,
                      11n: 72 Mbps</td>
                      <td>11b: 11 Mbps, 11g: 54 Mbps,
                      11n: 72 Mbps</td>
                    </tr>
                  </table>
                  <hr>
                  <p><b>General</b></p>
                  <table class="tab-table">
                    <tr>
                      <th>Requirements</th>
                      <td>- 10 - 45°C (14 - 113°F)
                      Humidity 95% or less (non-condensing)</td>
                      <td>- 10 - 45°C (14 - 113°F)
                      Humidity 95% or less (non-condensing)</td>
                    </tr>
                    <tr>
                      <th>Power Supply</th>
                      <td>DC 5V±10%</td>
                      <td>DC 5V±10%</td>
                    </tr>
                    <tr>
                      <th>Power Consumption</th>
                      <td>Max. 4.0W</td>
                      <td>Max. 4.0W</td>
                    </tr>
                    <tr>
                      <th>IR Range</th>
                      <td>Max. 12 meters&nbsp;</td>
                      <td>Max. 12 meters&nbsp;</td>
                    </tr>
                    <tr>
                      <th>Product Dimensions</th>
                      <td>64mm x 64mm x 103mm&nbsp;</td>
                      <td>64mm x 64mm x 103mm&nbsp;</td>
                    </tr>
                    <tr>
                      <th>Packaging Dimensions</th>
                      <td>123mm x 79mm x 125.5mm&nbsp;</td>
                      <td>123mm x 79mm x 125.5mm&nbsp;</td>
                    </tr>
                    <tr>
                      <th>Weight</th>
                      <td>96g</td>
                      <td>96g</td>
                    </tr>
                  </table>
                </div>
                <div class="tab-pane fade" id="additional">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="box-block">
                        720p/1080p
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        110°/130° <br>Wide-Angle Lens
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Infrared Night Vision <br>(Up to 12 meters)
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Supports 2.4GHz Wi-Fi
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Two-Way Talk
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Supports MicroSD Card <br>(Up to 256 GB)
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Live View
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Real-Time Talk
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Instant Alerts
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Video History
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Up to 8x Zoom
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="box-block">
                        Smart Home Enabled
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <hr>
          <!--related product-->
          <div class="col-md-12">
            <p class="font-size25 black text-uppercase text-center">RELATED PRODUCTS</p>
            <div class="row">
              <div class="col-md-3 col-xs-6">
                <div class="related-product-list-wrap product-list-wrap text-center">
                  <div class="product-list-image"><img class="lozad img-responsive" data-src="{{asset('img/s1.png')}}">
                    <div class="single_team_icon">
                      <p class="text-center"><a class="hvr-icon-forward" title="View More" href="detail.php"><i class="fas fa-search"></i></a></p>
                    </div>
                  </div>
                  <p class="font-size20 black text-center text-uppercase">C8C Lite</p>
                  <p class="text-center gray">Rs. 5000.00</p>
                  <p class="gray padding-bottom30 text-center height-fixed">The C8C Lite features flexible pan & tilt design to watch over large space, which helps greatly reduce blind spots in </p>
                  <p class="text-center"><a class="shop-btn" href="#">Add to Quote</a></p>
                </div>
              </div>
              <div class="col-md-3 col-xs-6">
                <div class="related-product-list-wrap product-list-wrap text-center">
                  <div class="product-list-image"><img class="lozad img-responsive" data-src="{{asset('img/s1.png')}}">
                    <div class="single_team_icon">
                      <p class="text-center"><a class="hvr-icon-forward" title="View More" href="detail.php"><i class="fas fa-search"></i></a></p>
                    </div>
                  </div>
                  <p class="font-size20 black text-center text-uppercase">C8C Lite</p>
                  <p class="text-center gray">Rs. 5000.00</p>
                  <p class="gray padding-bottom30 text-center height-fixed">The C8C Lite features flexible pan & tilt design to watch over large space, which helps greatly reduce blind spots in </p>
                  <p class="text-center"><a class="shop-btn" href="#">Add to Quote</a></p>
                </div>
              </div>
              <div class="col-md-3 col-xs-6">
                <div class="related-product-list-wrap product-list-wrap text-center">
                  <div class="product-list-image"><img class="lozad img-responsive" data-src="{{asset('img/s1.png')}}">
                    <div class="single_team_icon">
                      <p class="text-center"><a class="hvr-icon-forward" title="View More" href="detail.php"><i class="fas fa-search"></i></a></p>
                    </div>
                  </div>
                  <p class="font-size20 black text-center text-uppercase">C8C Lite</p>
                  <p class="text-center gray">Rs. 5000.00</p>
                  <p class="gray padding-bottom30 text-center height-fixed">The C8C Lite features flexible pan & tilt design to watch over large space, which helps greatly reduce blind spots in </p>
                  <p class="text-center"><a class="shop-btn" href="#">Add to Quote</a></p>
                </div>
              </div>
              <div class="col-md-3 col-xs-6">
                <div class="related-product-list-wrap product-list-wrap text-center">
                  <div class="product-list-image"><img class="lozad img-responsive" data-src="{{asset('img/s1.png')}}">
                    <div class="single_team_icon">
                      <p class="text-center"><a class="hvr-icon-forward" title="View More" href="detail.php"><i class="fas fa-search"></i></a></p>
                    </div>
                  </div>
                  <p class="font-size20 black text-center text-uppercase">C8C Lite</p>
                  <p class="text-center gray">Rs. 5000.00</p>
                  <p class="gray padding-bottom30 text-center height-fixed">The C8C Lite features flexible pan & tilt design to watch over large space, which helps greatly reduce blind spots in </p>
                  <p class="text-center"><a class="shop-btn" href="#">Add to Quote</a></p>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</section>

	@endsection