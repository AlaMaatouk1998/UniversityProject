@extends('layouts.main')
@section('content')
            <section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
								{{$formation->titre}}		
							</h1>	
							<p class="text-white link-nav"><a href="index.html">Formation </a>  <span class="lnr lnr-arrow-right"></span>  <a href="single.html"> {{$formation->titre}}	</a></p>
						</div>											
					</div>
				</div>
            </section>
            


            <section class="blog-posts-area">
				<div class="container">
					<div class="row">
						<div class="col-md-6 post-list blog-post-list">
							<div class="single-post">
								<ul class="tags">
									<li><a href="#">A propos</a></li>
								</ul>
								<a href="#">
									<h1>
                                      {{$formation->titre}}	
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
                        <div class="col-md-6 pt-5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tags-widget formation-widget">
                                        <h4 class="title">Diplomes</h4>
                                        <ul>
                                            @foreach($diplomes as $diplome)
                                                <li><a href="/orientation#/rechercher?formation={{$formation->id}}&diplome={{$diplome->id}}">{{$diplome->titre}}</a></li>
                                            @endforeach
                                        </ul>
                                </div>	
                            </div>
                            <div class="col-md-12">
                                <div class="formation-widget tags-widget">
                                        <h6 class="title">Universites qui couvrent {{$formation->titre}}</h6>
                                        <ul>
                                            @foreach($universites as $universite)
                                                <li><a href="/etablissements?universite={{$universite->id}}">{{$universite->titre}}</a></li>
                                            @endforeach
                                        </ul>
                                </div>	
                            </div>
                            <div class="col-md-12">
                                <div class="formation-widget tags-widget">
                                        <h6 class="title">Etablissements qui couvrent {{$formation->titre}}	</h6>
                                        <ul>
                                        <ul>
                                            @foreach($etablissements as $etablissement)
                                                <li><a href="/orientation#/rechercher?etablissement={{$etablissement->id}}">{{$etablissement->titre}}</a></li>
                                            @endforeach
                                        </ul>

                                        </ul>
                                </div>	
                            </div>

                        </div>

                        </div>
                    </div>
                </div>
            </section>
@endsection