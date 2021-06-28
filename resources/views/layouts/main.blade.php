<!DOCTYPE html>
	<html lang="{{$locale}}" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="codepixer">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Orientation</title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="{{ asset('front/css/linearicons.css') }}">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

			<link rel="stylesheet" href="{{ asset('front/css/font-awesome.min.css') }}">
			<link rel="stylesheet" href="{{ asset('front/css/bootstrap.css') }}">
			<link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css') }}">
			<link rel="stylesheet" href="{{ asset('front/css/nice-select.css') }}">					
			<link rel="stylesheet" href="{{ asset('front/css/animate.min.css') }}">
			<link rel="stylesheet" href="{{ asset('front/css/owl.carousel.css') }}">
			<link rel="stylesheet" href="{{ asset('front/css/main.css') }}">

      <link rel="stylesheet" href="{{ asset('css/style.css') }}">

			@yield('css')
      @if($locale != 'fr')
      <style>
        body, .text-content, .etablissement .content{
          text-align: right !important;
        }
      </style>
      @endif
   </head>

		<body>
				<a id="button"></a>
			  <header id="header" id="home">
			    <div class="container">
			    	<div class="row align-items-center justify-content-between d-flex">
				      <div id="logo">
				        <a href="/" style="color: white;">
						<img src="{{ asset('front/image/logo-bg.png') }}" style="max-width: 140px" alt="">
						</a>
				      </div>
				      <nav id="nav-menu-container">
				        <ul class="nav-menu">
				          <li class="menu-active"><a href="/{{$locale}}">{{__('messages.nav_home')}}</a></li>
                  <li><a href="/{{$locale}}/formations">{{__('messages.home_formations_label')}}</a></li>
				          <li class="menu-has-children"><a href="/{{$locale}}/etablissements">{{__('messages.home_etablissements_label')}}</a>
				            <ul>
								<li><a href="/{{$locale}}/orientation#/rechercher?type=publique">{{__('messages.home_prive')}}</a></li>
								<li><a href="/{{$locale}}/orientation#/rechercher?type=prive">{{__('messages.home_publique')}}</a></li>
				            </ul>
				          </li>
				          <li><a href="/{{$locale}}/statistiques">{{__('messages.home_statistiques_label')}}</a></li>
				          <li><a href="/{{$locale}}/contact">{{__('messages.contact')}}</a></li>
				          <li><a class="ticker-btn bg-orange" href="/{{$locale}}/orientation#/rechercher?filter=all" >{{__('messages.recherche_avancee')}}</a></li>
				          <li><a class="ticker-btn" href="/{{$locale}}/orientation#/login">{{__('messages.connexion')}}</a></li>				
                  <li class="menu-active {{$locale == 'fr' ? 'selected' : ''}}"><a href="/fr">FR</a></li>      
                  <li class="menu-active {{$locale == 'ar' ? 'selected' : ''}}"><a href="/ar">عربية</a></li> 				          
				        </ul>
				      </nav><!-- #nav-menu-container -->		    		
			    	</div>
			    </div>
			  </header><!-- #header -->

        <style>
        html:lang(ar) { 
            font-size: 20px;
        }
          .selected a{
            color: #0984e3;
          }
          .etablissement h4{
            text-align: center;
          }
        </style>


            @yield('content')
		
			<!-- start footer Area -->		
			<footer class="footer-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-3  col-md-12">
							<div class="single-footer-widget">
								
								<ul class="footer-nav">
									<li><a href="">A propos</a></li>
									<li><a href="">Universités</a></li>
									<li><a href="">Etablissemens</a></li>
									<li><a href="">Spécialités</a></li>
									<li><a href="">Besoin d'aide</a></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-6  col-md-12">
							<div class="single-footer-widget newsletter">
								<h6>Abonnez-vous</h6>
								<p>Abonnez-vous pour recevoir les dernières nouvelles et annonces d'événements. Aucun spam dans votre boîte de réception..</p>
								<div id="mc_embed_signup">
									<form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="form-inline">

										<div class="form-group row" style="width: 100%">
											<div class="col-lg-8 col-md-12">
												<input name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
												<div style="position: absolute; left: -5000px;">
													<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
												</div>
											</div> 
										
											<div class="col-lg-4 col-md-12">
												<button class="nw-btn primary-btn">Subscribe<span class="lnr lnr-arrow-right"></span></button>
											</div> 
										</div>		
										<div class="info"></div>
									</form>
								</div>		
							</div>
						</div>
						<div class="col-lg-3  col-md-12">

						</div>						
					</div>

					<div class="row footer-bottom d-flex justify-content-between">
						<p class="col-lg-8 col-sm-12 footer-text m-0 text-white">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							<!-- Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank"></a> -->
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>

					</div>
				</div>
			</footer>
			<!-- End footer Area -->		

			<script src="{{ asset('front/js/vendor/jquery-2.2.4.min.js') }}"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
			<script src="{{ asset('front/js/vendor/bootstrap.min.js') }}"></script>			
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
  			<script src="{{ asset('front/js/easing.min.js') }}"></script>			
			<script src="{{ asset('front/js/hoverIntent.js') }}"></script>
			<script src="{{ asset('front/js/superfish.min.js') }}"></script>	
			<script src="{{ asset('front/js/jquery.ajaxchimp.min.js') }}"></script>
			<script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>	
			<script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>			
			<script src="{{ asset('front/js/jquery.sticky.js') }}"></script>
			<script src="{{ asset('front/js/jquery.nice-select.min.js') }}"></script>			
			<script src="{{ asset('front/js/parallax.min.js') }}"></script>		
			<script src="{{ asset('front/js/mail-script.js') }}"></script>	
			<script src="{{ asset('front/js/main.js') }}"></script>	
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
			@yield('js')
		</body>
	</html>
