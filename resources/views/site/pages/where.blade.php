@extends('site.layouts.site')
@section('pageTitle','Where To Buy')
@section('content')
	<!------start innerpage ------>
<!------start breadcrumb ------>
<section class="breadcrumb text-center" aria-label="breadcrumbs">
  <div class="container">
    <h1>Where to Buy</h1>
    <a href="{{route('where')}}" title="Back to the frontpage">Home</a> 
    <span aria-hidden="true" class="breadcrumb__sep">/</span>
    <span>Where to Buy</span>
  </div>
</section>
<!------start breadcrumb ------>
<!------start inner main page ------>
<section class="innerpage-product-wrapper home-content-wrap">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <table class="contact-table" width="100%" cellpadding="1" cellspacing="1" border="1">
          <thead>
            <tr>
              <td>Location</td>
              <td>Phone Number</td>
              <td>Email Address</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>SG Tower, 155 Panchayan Marg, Thapathali-11, Kathmandu, Nepal<br>
                <a class="black" href="#">View in Map</a>
              </td>
              <td>
                977-1-5329922
              </td>
              <td>
                <p><a href="mailto:info@iotincorporation.com.np">info@iotincorporation.com.np</a></p>
              </td>
            </tr>
            <tr>
              <td>SG Tower, 155 Panchayan Marg, Thapathali-11, Kathmandu, Nepal<br>
                <a class="black" href="#">View in Map</a>
              </td>
              <td>
                977-1-5329922
              </td>
              <td>
                <p><a href="mailto:info@iotincorporation.com.np">info@iotincorporation.com.np</a></p>
              </td>
            </tr>
            <tr>
              <td>SG Tower, 155 Panchayan Marg, Thapathali-11, Kathmandu, Nepal<br>
                <a class="black" href="#">View in Map</a>
              </td>
              <td>
                977-1-5329922
              </td>
              <td>
                <p><a href="mailto:info@iotincorporation.com.np">info@iotincorporation.com.np</a></p>
              </td>
            </tr>
            <tr>
              <td>SG Tower, 155 Panchayan Marg, Thapathali-11, Kathmandu, Nepal<br>
                <a class="black" href="#">View in Map</a>
              </td>
              <td>
                977-1-5329922
              </td>
              <td>
                <p><a href="mailto:info@iotincorporation.com.np">info@iotincorporation.com.np</a></p>
              </td>
            </tr>
            <tr>
              <td>SG Tower, 155 Panchayan Marg, Thapathali-11, Kathmandu, Nepal<br>
                <a class="black" href="#">View in Map</a>
              </td>
              <td>
                977-1-5329922
              </td>
              <td>
                <p><a href="mailto:info@iotincorporation.com.np">info@iotincorporation.com.np</a></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<!------end inner main page ------>
<!------end innerpage ------>
@endsection