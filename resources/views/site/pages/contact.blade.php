@extends('site.layouts.site')
@section('pageTitle','Contact Us')
@section('content')

<!------start innerpage ------>
<!------start breadcrumb ------>
<section class="breadcrumb text-center" aria-label="breadcrumbs">
  <div class="container">
    <h1>Contact Us</h1>
    <a href="{{route('home')}}" title="Back to the frontpage">Home</a> 
    <span aria-hidden="true" class="breadcrumb__sep">/</span>
    <span>Contact Us</span>
  </div>
</section>
<!------start breadcrumb ------>
<!------start inner main page ------>
<section class="innerpage-product-wrapper home-content-wrap">
  <div class="container">
    <div class="row">
      <div class="col-md-8"> 
        <p class="font-size20 black text-uppercase">Get In Touch</p>    
        <div class="row">
          <form>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="name" placeholder="Your Name *">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email Address *">
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="number" class="form-control" id="phone" placeholder="Phone Number *">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" class="form-control" id="subject" placeholder="Enter Subject">
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
              <div class="form-group">
                <textarea class="form-control" rows="3" placeholder="Message *"></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group text-center">
                <button class="button button-secondary button-winona" type="submit"><div class="content-original">Submit</div>
                  <div class="content-dubbed">Submit</div></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-list-wrap flex">
            <div class="contact-icon"><i class="fas fa-phone"></i></div>
            <div class="contact-address">
              <p class="black font-size25">Phone</p>
              <p class="text-left">+977-1-5329922, 5329888</p>
            </div>
          </div>
          <hr>
          <div class="contact-list-wrap flex">
            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
            <div class="contact-address">
              <p class="black font-size25">Email</p>
              <p class="text-left"><a href="mailto:info@iotincorporation.com.np">info@iotincorporation.com.np</a></p>
            </div>
          </div>
          <hr>
          <div class="contact-list-wrap flex">
            <div class="contact-icon"><i class="fas fa-location-arrow"></i></div>
            <div class="contact-address">
              <p class="black font-size25">Address</p>
              <p class="text-left">SG Tower, 155 Panchayan Marg, Thapathali-11, Kathmandu, Nepal </p>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </section>
      <!------end inner main page ------>
      <!------end innerpage ------>
	  @endsection