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
                                    <h4>Etablissements {{$type}} <br><small class="notice">Cliquer sur le nom de l'université pour afficher la liste de ses etablissements</small></h4> 
                                    <ul class="cat-list">
                                         @foreach($universites as $universite)
                                           <li><a class="justify-content-between d-flex" href="/etablissements?universite={{$universite->id}}"><p>{{$universite->titre}}</p><span class="etablissement-count">{{$universite->etablissements_count}} etablissements</span></a></li>
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
                                                <li><a href="/orientation#/rechercher?type={{$type_ref}}&formation={{$formation->id}}">{{$formation->titre}}</a></li>
                                            @endforeach
                                        </ul>
                                </div>	
                            </div>
                            <div class="col-md-12">
                                <div class="formation-widget tags-widget">
                                        <h6 class="title">Diplomes</h6>
                                        <ul>
                                            @foreach($diplomes as $diplome)
                                                <li><a href="/orientation#/rechercher?type={{$type_ref}}&diplome={{$diplome->id}}">{{$diplome->titre}}</a></li>
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