@extends('site.layouts.site')
@section('pageTitle','Home')
@section('content')

<section class="innerpage-bg-wrap">
  <div class="box-transform-wrap">
    <div class="container">
      <div class="row">
        <h1 class="text-center white title-font"><span>Security Cameras</span></h1>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="box-transform"></div>
  </div>
  <div class="breadcrumbs text-center"><a href="index.php">Home</a> &nbsp;&nbsp;<i class="fas fa-arrow-right"></i> &nbsp;&nbsp;<span class="black"><b>Security Cameras</b></span> </div>
</section>
<!--end title/Breadcrumb-->
<section class="home-content-wrap innerpage-content-wrap">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
      </div>    
      <div class="col-md-3">
        <p class="font-size25 black text-uppercase">Search List</p>
        <div><input type="search" class="form-control" name="search" placeholder="Search for Product Models"></div>
        <p><button class="btn buyitnow advanced-filter-reset">RESET</button></p>
        <hr>
        <div class="font-size18">Model Parameters</div>
        <ul class="checkbox-left input-type-checkbox">
          <li>
            <input title="All" type="checkbox" id="all" value="all" required checked="">
            <label for="all">All</label>
          </li>
          <li>
            <input title="CS-C1C-D0-1D1WFR" type="checkbox" name="enquiryType" id="CS-C1C-D0-1D1WFR" value="CS-C1C-D0-1D1WFR" checked="" required>
            <label for="CS-C1C-D0-1D1WFR">CS-C1C-D0-1D1WFR</label>
          </li>
          <li>
            <input title="CS-C1C-D0-1D2WFR" type="checkbox" name="enquiryType" id="CS-C1C-D0-1D2WFR" value="CS-C1C-D0-1D2WFR" checked="" required>
            <label for="filterOption-0-1">CS-C1C-D0-1D2WFR
            </label>
          </li>
        </ul>
        <hr>
        <div class="font-size18">Camera</div>
        <ul class="checkbox-left input-type-checkbox">
          <li>
            <input title="All" type="checkbox" id="all" value="all" required checked="">
            <label for="all">All</label>
          </li>
          <li>
            <input title="CS-C1C-D0-1D1WFR" type="checkbox" name="enquiryType" id="CS-C1C-D0-1D1WFR" value="CS-C1C-D0-1D1WFR" checked="" required>
            <label for="CS-C1C-D0-1D1WFR">CS-C1C-D0-1D1WFR</label>
          </li>
          <li>
            <input title="CS-C1C-D0-1D2WFR" type="checkbox" name="enquiryType" id="CS-C1C-D0-1D2WFR" value="CS-C1C-D0-1D2WFR" checked="" required>
            <label for="filterOption-0-1">CS-C1C-D0-1D2WFR
            </label>
          </li>
        </ul>
        <hr>
        <div class="font-size18">Image</div>
        <ul class="checkbox-left input-type-checkbox">
          <li>
            <input title="All" type="checkbox" id="all" value="all" required checked="">
            <label for="all">All</label>
          </li>
          <li>
            <input title="CS-C1C-D0-1D1WFR" type="checkbox" name="enquiryType" id="CS-C1C-D0-1D1WFR" value="CS-C1C-D0-1D1WFR" checked="" required>
            <label for="CS-C1C-D0-1D1WFR">CS-C1C-D0-1D1WFR</label>
          </li>
          <li>
            <input title="CS-C1C-D0-1D2WFR" type="checkbox" name="enquiryType" id="CS-C1C-D0-1D2WFR" value="CS-C1C-D0-1D2WFR" checked="" required>
            <label for="filterOption-0-1">CS-C1C-D0-1D2WFR</label>
          </li>
        </ul>
        <hr>
        </div>
        <div class="col-md-9">

          <p class="font-size25 black text-uppercase">Featured Products</p>
          <div class="row">
            @foreach($products as $product)
            <div class="col-md-4">
              <div class="product-listing text-center">
                <a href="{{route('products.single',$product->slug)}}"> 
                  <img class="lozad img-responsive" data-src="{{$product->getMedia('products')[0]->getFullUrl('thumb')}}">
                  <p class="font-size18 text-center"><b>{{$product->sku}}</b> <br>{{$product->title}}<br>NRs {{$product->price}}</p>

                </a>
              </div>
            </div>
            @endforeach
            <div class="clearfix">&nbsp;</div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>

    </section>
    <!--end innerpage--> 

@endsection
