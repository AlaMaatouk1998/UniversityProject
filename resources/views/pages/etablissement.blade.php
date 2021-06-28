@extends('layouts.main')
@section('content')
            <section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
                                Etablissements {{$type}}	
							</h1>	
							<p class="text-white link-nav"><a href="index.html">Université </a>  <span class="lnr lnr-arrow-right"></span>  <a href="single.html"> {{$univ->titre}}</a></p>
						</div>											
					</div>
				</div>
            </section>
            


            <section class="blog-posts-area pt-4">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
					    	<div class="sidebar">
                                <div class="single-slidebar">
                                    <h6>{{$univ->titre}}</h6>
                                    <h4>Etablissements: <br><small class="notice">Cliquer sur le nom de l'Etablissement pour afficher des informations supplémentaires</small></h4> 
                                    <ul class="cat-list">
                                         @foreach($etablissements as $etablissement)
                                           <li><a class="justify-content-between d-flex" href="/orientation#/rechercher?etablissement={{$etablissement->id}}"><p>{{$etablissement->titre}}</p><span class="etablissement-count">{{$etablissement->specialites_count}} spécialités</span></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tags-widget formation-widget">
                                        <h4 class="title">Formations</h4>
                                        <ul>
                                            @foreach($formations as $formation)
                                                <li><a href="/orientation#/rechercher?universite={{$univ->id}}&formation={{$formation->id}}">{{$formation->titre}}</a></li>
                                            @endforeach
                                        </ul>
                                </div>	
                            </div>
                            <div class="col-md-12">
                                <div class="formation-widget tags-widget">
                                        <h6 class="title">Diplomes</h6>
                                        <ul>
                                            @foreach($diplomes as $diplome)
                                                <li><a href="/orientation#/rechercher?universite={{$univ->id}}&diplome={{$diplome->id}}">{{$diplome->titre}}</a></li>
                                            @endforeach
                                        </ul>
                                </div>	
                            </div>
                            <div class="col-md-12">
                                <div class="formation-widget tags-widget">
                                        <h6 class="title">Spécialités</h6>
                                        <ul>
                                            @foreach($specialites as $specialite)
                                                <li><a href="/orientation#/rechercher?universite={{$univ->id}}&specialite={{$specialite->id}}">{{$specialite->titre}}</a></li>
                                            @endforeach
                                        </ul>
                                </div>	
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </section>
@endsection