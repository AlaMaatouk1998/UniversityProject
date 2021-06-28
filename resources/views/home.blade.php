@extends('layouts.main')
@section('content')
<!-- start banner Area -->
<section class="position-relative" id="home">

<div id="myCarousel" class="carousel slide " data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
    <!-- caroussel one -->
    <div class="carousel-item active  overlay1 overlay1-bg" 
      data-interval="2000">
         <div class="overlay1-image" style="background-image:url(front/img/b1.jpg);" ></div>

        <div class="container">
        <div class="carousel-caption  text-content">
                  <h1>{{ __('messages.home_title') }}</h1>
                  <p>{{ __('messages.home_description') }}</p>
                  <div class="hero-btn"><a href="/{{$locale}}/orientation#/rechercher?filter=all" class=" genric-btn primary e-large action-btn">{{ __('messages.home_action_btn') }}</a></div>

         </div>
      </div>
      </div>
    <!-- caroussel two-->

    <div class="carousel-item  overlay1 overlay1-bg" 
      data-interval="2000">
         <div class="overlay1-image" style="background-image:url(front/img/header-bg.jpg);" ></div>

        <div class="container">
        <div class="carousel-caption  text-content">
                  <h1>{{ __('messages.home_title') }}</h1>
                  <p>{{ __('messages.home_description') }}</p>
                  <div class="hero-btn"><a href="/{{$locale}}/orientation#/rechercher?filter=all" class=" genric-btn primary e-large action-btn">{{ __('messages.home_action_btn') }}</a></div>

         </div>
      </div>
      </div>
          <!-- caroussel three -->

      <div class="carousel-item  overlay1 overlay1-bg" 
      data-interval="2000">
         <div class="overlay1-image" style="background-image:url(front/img/b2.jpg);" ></div>

        <div class="container">
        <div class="carousel-caption  text-content">
                  <h1>{{ __('messages.home_title') }}</h1>
                  <p>{{ __('messages.home_description') }}</p>
                  <div class="hero-btn"><a href="/{{$locale}}/orientation#/rechercher?filter=all" class=" genric-btn primary e-large action-btn">{{ __('messages.home_action_btn') }}</a></div>

         </div>
      </div>
      </div>

         <!-- !!!! -->
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </a>
  </div>



   </div>
</section>
<!-- End banner Area -->	
<!-- Start features Area -->
<section class="features-area">
   <div class="container">
      <div class="row">

         <div class="col-lg-4 col-md-6">
            <a href="/{{$locale}}/formations">
               <div class="single-fcat float">
                  <img src="front/img/o2.png" alt="">
                  <h4 class="pt-4">{{ __('messages.home_formations_label') }}</h4>
               </div>
            </a>
         </div>

         <div class="col-lg-4 col-md-6">
            <a href="/{{$locale}}/etablissements">
               <div class="single-fcat float">
                  <img src="front/img/u2.png" alt="">
                  <h4 class="pt-4">{{ __('messages.home_etablissements_label') }}</h4>
               </div>
            </a>
         </div>

         <div class="col-lg-4 col-md-6">
            <a href="/{{$locale}}/statistiques">
               <div class="single-fcat float">
                  <img src="front/img/graph.png" alt="">
                  <h4 class="pt-4">{{ __('messages.home_statistiques_label') }}</h4>
               </div>
            </a>
         </div>

      </div>
   </div>
</section>
<!-- End features Area -->







<section class="section-gap" id="etablissements"> 
   <div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="menu-content pb-60 col-lg-10">
				<div class="title text-left">


            

				<h1 class="mb-10">{{ __('messages.home_etablissement_title') }}</h1>
            <p>{{ __('messages.home_etablissement_description') }}</p>
            <a href="/{{$locale}}/orientation#/rechercher?type=publique" class="genric-btn primary small">{{__('messages.home_publique')}}</a>
            <a href="/{{$locale}}/orientation#/rechercher?type=prive" class="genric-btn danger small bg-orange">{{__('messages.home_prive')}}</a>
				</div>
			</div>
		</div>
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-6">
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
					<div class="col-md-6">
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
			</div>
		</div>
	</div>
</section>

<section class="section-gap">
   <div class="container" id="formations">
      <div class="row d-flex justify-content-center">
         <div class="menu-content pb-60 col-lg-10">
            <div class="title text-center">
               <h1 class="mb-10">Domaines</h1>
               <p>Who are in extremely love with eco friendly system.</p>
            </div>
         </div>
      </div>
      <div class="row">
		@foreach($global_formations as $formation)
         <div class="col-lg-4 col-md-6">
            <div class="single-feature formation">
               <h4>{{$formation->titre}}</h4>
               <div class="content">
                  <p>
                     Lorem ipsum dolor sit amet, consectetur adipisicing.
                  </p>
               </div>
               <div class="btn-action text-center mt-4"><a class="btn-block" href="/{{$locale}}/formations?domaine={{$formation->id}}">Voir</a></div>
            </div>
		 </div>
		 @endforeach
      </div>
   </div>
</section>



<section class="blog-posts-area pt-4">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
					    	<div class="sidebar">
                                <div class="single-slidebar">
                                    <h4>Rechercher des Etablissements par gouvernorat<br></h4> 
									<div class="post-list">
										<div class="single-post d-flex flex-row formationTags">
											<div class="thumb">
											<ul class="tags">
												@foreach($gouvernorats as $gouvernorat)
													<li>
														<a href="/{{$locale}}/orientation#/rechercher?gouvernorat={{$gouvernorat}}">{{$gouvernorat}}</a>
													</li>
												@endforeach
		
											</ul>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 sidebar">
						<div class="single-slidebar">
								<h4>Des spécialités</h4>
						
								<div class="active-relatedjob-carusel">
									@foreach($specialites as $specialite)
									<div class="single-rated">
										<p>
										{{$specialite->mention['domaine']['titre']}}
										</p>
										<h5>{{$specialite->diplome['titre']}}</h5>

										<a href="single.html"><h4>{{$specialite->titre}}</h4></a>
										<h6 class="pb-3">{{$specialite->mention['titre']}}</h6>

										@foreach($specialite->etablissements as $etablissement)
										<p class="address"><span class="lnr lnr-map"></span> {{$etablissement['titre']}}</p>
										@endforeach
										<a href="/{{$locale}}/orientation#/rechercher?specialite={{$specialite->id}}" class="btns text-uppercase">Plus d'informations</a>
										<a href="/{{$locale}}/orientation#/rechercher" class="genric-btn primary-border small mt-2">Voir autres</a>		
									</div>
									@endforeach	
											
								</div>
							</div>	
                        </div>
                    </div>
                </div>
     </section>


<!-- End feature-cat Area -->
<!-- Start callto-action Area -->
<section class="callto-action-area section-gap" id="join">
   <div class="container">
      <div class="row d-flex justify-content-center">
         <div class="menu-content col-lg-9">
            <div class="title text-center">
               <h1 class="mb-10 text-white">Vous êtes bachelier, étudiants ou universitaire ?</h1>
               <p class="text-white">Vous avez des idées de carrières plein la tête mais vous ne savez quel parcours choisir pour y arriver ?</p>
               <a class="primary-btn" href="/{{$locale}}/orientation#/rechercher?filter=all">Recherche avancée</a>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- End calto-action Area -->
@endsection