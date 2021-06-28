@extends('layouts.main')
@section('content')
            <section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
                                Nous contacter	
							</h1>	
							<!-- <p class="text-white link-nav"><a href="index.html">Universités </a>  <span class="lnr lnr-arrow-right"></span>  <a href="single.html"> </a></p> -->
						</div>											
					</div>
				</div>
            </section>
            
			<section class="contact-page-area section-gap">
				<div class="container">
					<div class="row justify-content-center">
						<!-- <div class="map-wrap" style="width:100%; height: 445px;" id="map"></div> -->
						<!-- <div class="col-lg-4 d-flex flex-column">
							<a class="contact-btns" href="#">Submit Your CV</a>
							<a class="contact-btns" href="#">Post New Job</a>
							<a class="contact-btns" href="#">Create New Account</a>
						</div> -->
						<div class="col-lg-8">
							<form class="form-area " id="myForm" action="mail.php" method="post" class="contact-form text-right">
								<div class="row">	
									<div class="col-lg-12 form-group">
										<input name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nom'" class="common-input mb-20 form-control" required="" type="text">
									
										<input name="email" placeholder="Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Adresse EMail'" class="common-input mb-20 form-control" required="" type="email">

										<input name="subject" placeholder="Sujet" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Sujet'" class="common-input mb-20 form-control" required="" type="text">
										<textarea class="common-textarea mt-10 form-control" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
										<button class="primary-btn mt-20 text-white" style="float: right;">Envoyer</button>
										<div class="mt-20 alert-msg" style="text-align: left;"></div>
									</div>
								</div>
							</form>	
						</div>
					</div>
				</div>	
			</section>


@endsection
