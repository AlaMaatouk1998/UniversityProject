@extends('layouts.main')
@section('content')
            <section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
							{{__('messages.home_etablissements_label')}}	
							</h1>	
							<p class="text-white link-nav"><a href="index.html">Accueil </a>  <span class="lnr lnr-arrow-right"></span>  <a href="single.html"> Etablissements	</a></p>
						</div>											
					</div>
				</div>
            </section>
            
            <section class="section-gap">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="intro-content">
								<ul class="tags">
									<li><a href="#">A propos</a></li>
								</ul>
								<a href="#">
									<h1>
									{{__('messages.home_etablissements_label')}} 
									</h1>
								</a>
								<div class="content-wrap">
									<p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit facere illo vitae in? Aspernatur repellat exercitationem earum ipsam, inventore nemo. Eos, iure dignissimos dicta nulla maxime doloremque eum id earum!
									</p>

									<blockquote class="generic-blockquote">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quasi, inventore accusantium a accusamus voluptas exercitationem esse corporis reiciendis aut placeat soluta temporibus alias explicabo harum tempora deserunt? Quaerat, repellendus?
									</blockquote>
										
						    	</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                   
                    <div class="col-md-4">
						<div class="single-feature etablissement">
							<div class="acc-icon text-center">
								<img src="/front/img/u2.png" alt="">
							</div>
							<h4>{{__('messages.home_etablissements_label')}} {{__('messages.home_publique')}}</h4>


							<div class="content">
								<p>
									Lorem ipsum dolor sit amet, consectetur adipisicing.
								</p>
							</div>
							
							<div class="text-center mt-4 circleAction"><a href="/{{$locale}}/orientation#/rechercher?type=publique"  class="nw-btn primary-btn">Voir<span class="lnr lnr-arrow-right"></span></a></div>
						</div>
					</div>
					<div class="col-md-4">
							<div class="single-feature etablissement">
								<div class="acc-icon text-center">
									<img src="/front/img/u1.png" alt="">
								</div>
								<h4>{{__('messages.home_etablissements_label')}} {{__('messages.home_prive')}}</h4>
								<div class="content">
									<p>
										Lorem ipsum dolor sit amet, consectetur adipisicing.
									</p>
								</div>
								<div class="text-center mt-4 circleAction"><a  href="/{{$locale}}/orientation#/rechercher?type=prive"class="nw-btn primary-btn">Voir<span class="lnr lnr-arrow-right"></span></a></div>
							</div>
					</div>             
                    </div>
                    <div class="mt-4">
                        <a href="/orientation#/rechercher" class="link-formations">Voir toutes les universités</a>
                        
                    </div>
                </div>
            </section>
@endsection