@extends('site.layouts.site')
@section('pageTitle','About Us')
@section('content')
	<!------start innerpage ------>
<!------start breadcrumb ------>
<section class="breadcrumb text-center" aria-label="breadcrumbs">
  <div class="container">
    <h1>About Us</h1>
    <a href="{{route('home')}}" title="Back to the frontpage">Home</a> 
    <span aria-hidden="true" class="breadcrumb__sep">/</span>
    <span>About Us</span>
  </div>
</section>
<!------start breadcrumb ------>
<!------start inner main page ------>
<section class="innerpage-product-wrapper home-content-wrap">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="about-us-wrap">
          <img class="lozad img-responsive" data-src="{{asset('img/about.jpg')}}">
          <div class="about-us-content-wrap">
            <p class="white font-size25">we create easy-to-use smart home devices that provide visual protection and tangible joy to every family. Since day one, we’ve been passionate about developing new generations of smart home products that simplify and automate your home experience.</p>
          </div>
        </div>
        <div class="contact-us-wrap">
          <img class="lozad img-responsive" data-src="{{asset('img/contact.jpg')}}">
          <div class="contact-us-content-wrap">
            <div class="white font-size25">
              <span class="white font-size30">Contact Us</span><br>
              If you require help with your order or have an enquiry for our Customer Service team, please get in touch through our contact page.<br><br>
              <a class="button" href="{{route('contact')}}">
                Contact information
              </a></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!------end inner main page ------>
    <!------end innerpage ------>
@endsection