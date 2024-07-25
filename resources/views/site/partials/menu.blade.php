<header id="main-navigation">
  <div id="navigation" class="">
    <div class="container">
      <div class="row">
        <div class="menu-wrap-flex">
        <div class="col-md-5">
          <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a class="menu-link" href="{{route('home')}}">Home</a>
            <a class="menu-link has-sub-menu" href="#">Security Cameras <em class="fa fa-chevron-down"></em></a>
            <ul class="dropdownMenu">
              <li><a href="{{route('shop.category.single','indoor-wireless-cameras')}}">Indoor Wireless Camera</a></li>
              <li><a href="{{route('shop.category.single','outdoor-wireless-cameras')}}">Outdoor Wireless Camera</a></li>
            </ul>
            <a class="menu-link" href="{{route('where')}}">Where to Buy?</a>
            <a class="menu-link" href="{{route('carts.index')}}">Estimate</a>
            <!--<a class="menu-link" href="#">Accessories</a>-->
            <a class="menu-link" href="{{route('about')}}">About Us</a>
            <a class="menu-link" href="{{route('contact')}}">Contact Us</a>

          </div>
          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        </div>
        <div class="col-md-2">
          <a class="logo" href="{{route('home')}}">
            <img src="{{asset('img/ezviz-logo.png')}}" data-src="{{asset('img/ezviz-logo.png')}}" class="lozad img-responsive" alt="Ezviz Nepal" title="Ezviz Nepal">
          </a> 
        </div>
        <div class="col-md-5">
          <div class="header-icons">
            <span>
              <a href="#" data-toggle="modal" data-target="#searchModal">
                <i class="fas fa-search"></i>
              </a>
             <!-- <a href="#" data-toggle="modal" data-target="#userModal">
                <i class="fas fa-user"></i>
              </a>-->
              <a class="cart-button">
                <i class="fas fa-cart-arrow-down"></i>@if(Cart::count()>0)<sup><span class="badge bsuccess cartcount">{{Cart::count()}}</span></sup> @endif
              </a>
			  @if(Cart::count()>0)
			  <div class="cart-wrap-design row">
                <div class="mini-cart-container">
					@foreach(Cart::content() as $item)
						<div class="col-md-4">
							<img class="lozad img-responsive cart-img" src="{{asset($item->model->getMedia('products')[0]->getUrl('tiny'))}}" data-src="{{asset($item->model->getMedia('products')[0]->getUrl('thumb'))}}" title="{{$item->model->sku}}" alt="{{$item->model->sku}}">
							<!--<span class="remove-item remove" data-id="{{$item->rowId}}"><i class="fa fa-times"></i></span>-->
						</div>
						<div class="col-md-8">
							<div class="product-name"><b>{{$item->model->sku}}</b></div>
							<div class="row ">
								<div class="display-inbl col-md-5 flex">
									<label class="fw5">Qty </label> 
									<input name="quantity" value="{{$item->qty}}" disabled class="form-control form-control-sm number-form">
								</div>
								<span class="card-total-price col-md-7"> NPR. {{ $item->subtotal }}</span>
							</div>
						</div>
						<div class="clearfix"></div>
						<hr>
					@endforeach
                </div>
                <div class="subtotal-cart-footer">
                  <div class="col-md-6">Cart Subtotal</div> 
                  <div class="col-md-6 text-right no-padding">NPR. <span class="cart-subtotal">{{Cart::subtotal()}}</span></div>
                  <div class="clearfix"></div>
                </div>
                <div class="subtotal-cart-footer">
                  <div class="col-md-6">
                    <a class="btn shopping-link addmore" href="{{route('carts.index')}}" style="padding-left: 8px;padding-right: 8px;">View Cart</a> 
                  </div>
                  <div class="col-md-6">
                    <a class="btn btn-block buyitnow" href="{{route('cart.checkout')}}">Proceed</a>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
			  @endif
			  
            </span>
          </div>
        </div>
        <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--start popup search Modal-->
<div class="modal searchModal fade" id="searchModal" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <form>
          <button type="submit" class="search__button focus-inset" aria-label="Search our site" tabindex="-1">
            <i class="fas fa-search"></i>
          </button>
          <input id="Search-In-Modal" class="search__input field__input" type="search" placeholder="Search">
          <button type="button" class="btn btn-default closes" data-dismiss="modal"><i class="fas fa-times"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--end popup search Modal-->

