@extends('layouts.main')
@section('content')
            <section class="banner-area relative" id="home">	
				<div class="overlay overlay-bg"></div>
				<div class="container">
					<div class="row d-flex align-items-center justify-content-center">
						<div class="about-content col-lg-12">
							<h1 class="text-white">
                                Statistiques	
							</h1>	
							<!-- <p class="text-white link-nav"><a href="index.html">Universités </a>  <span class="lnr lnr-arrow-right"></span>  <a href="single.html"> </a></p> -->
						</div>											
					</div>
				</div>
            </section>
            

            <section class="facts-section" style="margin-top: -80px">
      <div class="container">
         <div class="position-relative">
            <div class="fact-absolute">
               <div class="row justify-content-center">
                  <div class="col-xl-7 col-lg-8 mb--35  text-center">
                     <span class="fact-text"></span>
                  </div>
               </div>
               <div class="row justify-content-center space-db--30">
                  <div class="col-md-3 col-lg-2 mb--30" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
                     <div class="fact-card float" >
                        <div class="card-content">
                           <span class="number">{{$nb_etablissement_publique}}</span>
                           <p class="info">Etablissements publiques</p>
                        </div>
                        <div class="card-icon">
                           <img src="{{ asset('front/image/fact-4.png') }}" alt="">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-lg-2 mb--30" data-aos="fade-up" data-aos-duration="2000" data-aos-once="true" data-aos-delay="200">
                     <div class="fact-card float" >
                        <div class="card-content">
                           <span class="number">{{$nb_etablissement_prive}}</span>
                           <p class="info">Etablissements privés</p>
                        </div>
                        <div class="card-icon">
                           <img src="{{ asset('front/image/fact-2.png') }}" alt="">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-lg-2 mb--30" data-aos="fade-up" data-aos-duration="2000" data-aos-once="true" data-aos-delay="300">
                     <div class="fact-card float" >
                        <div class="card-content">
                           <span class="number">{{$nb_domaines}}</span>
                           <p class="info">Domaines</p>
                        </div>
                        <div class="card-icon">
                           <img src="{{ asset('front/image/fact-3.png') }}" alt="">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-lg-2 mb--30" data-aos="fade-up" data-aos-duration="2000" data-aos-once="true" data-aos-delay="300">
                     <div class="fact-card float" >
                        <div class="card-content">
                           <span class="number">{{$nb_diplomes}}</span>
                           <p class="info">Diplômes</p>
                        </div>
                        <div class="card-icon">
                           <img src="{{ asset('front/image/fact-4.png') }}" alt="">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-lg-2 mb--30" data-aos="fade-up" data-aos-duration="2000" data-aos-once="true" data-aos-delay="600">
                     <div class="fact-card float" >
                        <div class="card-content">
                           <span class="number">{{$nb_mentions}}</span>
                           <p class="info">Disciplines</p>
                        </div>
                        <div class="card-icon">
                           <img src="{{ asset('front/image/users-wm.png') }}" alt="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>


   <section class="mb-4" style="margin-bottom: 150px">
         <div class="container">
            <div class="row mb-4">
                <div class="col-md 6">
                    <h3>Spécialités par domaine</h3>
                    <canvas id="charteFormation" class="mt-4" width="300" height="300"></canvas>
                </div>
                <div class="col-md 6">
                    <h3>Etablissements</h3>
                    <canvas id="charteEtablissement" class="mt-4" width="300" height="300"></canvas>
                </div>
            </div>
        </div>  
    </section> 


@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    $(document).ready(function(){
            $.ajax({
                    url:"/api/statistiques", 
                    type: 'GET',
                    success: function(data, status){
                    initiateCharte(data.specialite_values, data.specialite_labels,'Spécialités par formation', 'charteFormation', 'doughnut');
                    initiateCharte([data.nb_publique, data.nb_prive], ['Etablissements publiques', 'Etablissements privés'],'Etablissements', 'charteEtablissement', 'pie');
                    }
            });
    })



function initiateCharte(data, label, name , id, type = 'line'){
  var ctx = document.getElementById(id).getContext('2d');
  var myChart = new Chart(ctx, {
      type: type,
      data: {
          labels: label,
          datasets: [{
              label: name,
              data: data,
              backgroundColor: ['#00a8ff', '#fd79a8', '#f7d794', '#6c5ce7', '#636e72', '#ffeaa7', '#00cec9', '#cf6a87', '#303952'],
              borderColor:  'rgba(54, 162, 235, 1)',
              borderWidth: 1
          }]
      },

  });
}  
</script>
@endsection
<!-- options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      } -->