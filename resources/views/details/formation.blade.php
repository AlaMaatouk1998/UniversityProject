@extends('layouts.main')
@section('content')
            <section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								Formations	
							</h1>	
							<p class="text-white link-nav"><a href="index.html">Accueil </a>  <span class="lnr lnr-arrow-right"></span>  <a href="single.html"> Formations	</a></p>
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
                                      Formations 
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
                    <div>
                    <h4>
                        Liste des Formations disponibles
					</h4> 
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 ">
                        @foreach($diplomes as $diplome)
                            <div class="col-lg-12 col-md-12">
                            <a href="/orientation#/rechercher?diplome={{$diplome->id}}">
                                <div class="single-fcat float formation-card">
                                <h5>
                                {{\GlobalHelper::getRespectiveLanguage($diplome->titre, $diplome->titre_ar)}}</h5>
                                </div>
                                </a>
                            </div>
                        @endforeach
                        </div>
                        <div class="col-lg-9 col-md-9 ">
                            <div class="row">
                            @foreach($formations as $formation)
                                    <div class="col-lg-4 col-md-4">
                                    <a href="/orientation#/rechercher?formation={{$formation->id}}">
                                        <div class="single-fcat float formation-card">
                                        <h5>
                                        {{\GlobalHelper::getRespectiveLanguage($formation->titre, $formation->titre_ar)}}</h5>
                                        </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="/orientation#/rechercher" class="link-formations">Voir tous les formations disponibles</a>
                        
                    </div>
                </div>
            </section>
@endsection