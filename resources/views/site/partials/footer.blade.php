<!--start footer-menu-->
<footer class="footer-section-wrap">
  <div class="container">
    <div class="row">
      <div class="col-md-3">

        <div class="footer-links-wrap">
          <div class="font-size20 blue">Security Cameras</div>
          <ul class="site-info">
            <li><a href="{{route('shop.category.single','indoor-wireless-cameras')}}">Indoor Wireless Camera </a></li>
            <li><a href="{{route('shop.category.single','outdoor-wireless-cameras')}}">Outdoor Wireless Camera</a></li>
          </ul>
          
        </div>
      </div>
      <div class="col-md-3">

        <div class="footer-links-wrap">
          <div class="font-size20 blue">Ouick Links</div>
          <ul class="site-info">
            <li><a href="#">About us </a></li>
            <li><a href="#">Where t buy</a></li>
            <li><a href="#">Estimate</a></li>
            <li><a href="#">Accessories</a></li>
            <li><a href="#">Contact us</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6">
        <div class="footer-content">we create easy-to-use smart home devices that provide visual protection and tangible joy to every family. Since day one, we’ve been passionate about developing new generations of smart home products that simplify and automate your home experience.</div>
        <p class="follow-icon-wrap">
          
          <a class="follow-icon" href="#" target="_blank" rel="noreferrer" title="Viber" alt="Viber"><i class="fab fa-viber"></i></a>
          <a class="follow-icon" href="#" target="_blank" rel="noreferrer" title="Whatsapp" alt="Whatsapp"><i class="fab fa-whatsapp"></i></a></p>
        </div>
        <div class="clearfix">
        </div>
      </div>
      <div class="copyright-wrap">
    <div class="col-md-12">
      <center>
        <p class="text-center gray"><b>IoT Incorporation Pvt. Ltd. </b> &copy; <?= date('Y');?> All Rights Reserved<br>
         Designed &amp; Developed by <a class="" href="https://shardait.com/" target="_blank" title="Sharda IT Service" alt="Sharda IT Service">SHARDA IT SERVICE</a></p>
       </center>
     </div>
     <div class="clearfix"></div>
   </div>
    </div>
  </footer>
  
   <!--end footer-section--> 
   <!--start To Top--> 
   <a id="button"><i class="fa fa-angle-double-up"></i></a>  
   <!--start script links-->
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	<!----gallery---->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
	<script type="text/javascript">
  $(function(){
    var btn = $('#button');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });
  });

</script> 
<script>
  function openNav() {
    document.getElementById("mySidenav").style.width = "415px";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  }
</script>

<!-----------for image loader-----------------> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/lozad.js/1.16.0/lozad.min.js"></script>
<script>
  lozad('.lozad', {
    load: function(el) {
      el.src = el.dataset.src;
      el.onload = function() {
        el.classList.add('fadelazy')
      }
    }
  }).observe();
</script>

<!--------for homepage video/ product gallery page-------------->
<script type="text/javascript"> 
  jQuery(function($) {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
    });
  });
</script>
<script>
  $(function() {
    console.log('ready');
      // init carousel
      $('.owl-carousel-hero').owlCarousel({
        nav: true
      });
      var $preview = $('.gallerys-preview');
      $('.gallerys-thumbs').on('click', '.item', function(e) {
        var $elm = $(e.currentTarget);
        $preview.find('img').attr({
          'src': $elm.data('ref'),
          'alt': $elm.data('ref')
        });
      })
    })
  </script>

  <!----------for menu---------->
  <script type="text/javascript">
    $(function(){
      $(window).scroll(function(){
        var sticky = $('.sticky'),
        scroll = $(window).scrollTop();
        if (scroll >= 100) sticky.addClass('fixed');
        else sticky.removeClass('fixed');
      });
    });
  </script>
  <!----------------dropdown menu---------------->
  <script>
    $(function() {
      $('.menu-link.has-sub-menu').click(function(e) {
        e.preventDefault();
        var $elm = $(e.currentTarget);
        $elm.toggleClass('active');
        return false;
      });
    })
  </script>
  <!------------for homepage testimonial--------->
  <script type="text/javascript">
    //search hide show
    $(document).ready(function(){
        $(".cart-button").click(function(){
          $(".cart-wrap-design").toggle();
        });
    });
    
    $(document).ready(function(){
    // for testimonial 
    $('.owl-carousel').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:2
        },
        1000:{
          items: 3,
          nav: true,
          loop: true,
          margin: 20
        }
      }
    });
  })
</script> 
@yield('scripts')
</body>
</html>