
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css" rel="stylesheet" />
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <script>window.Laravel = { csrfToken: '{{csrf_token() }}' }</script>
    <title>Orientation</title>
    <style>
        #loader {
          position: absolute;
          left: 50%;
          top: 50%;
          z-index: 1;
          width: 100px;
          height: 100px;
          margin: -75px 0 0 -75px;
          border: 2px solid #f3f3f3;
          border-radius: 50%;
          border-top: 2px solid #3498db;
          width: 100px;
          height: 100px;
          -webkit-animation: spin 2s linear infinite;
          animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

        /* Add animation to "page content" */
        .animate-bottom {
          position: relative;
          -webkit-animation-name: animatebottom;
          -webkit-animation-duration: 1s;
          animation-name: animatebottom;
          animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
          from { bottom:-100px; opacity:0 } 
          to { bottom:0px; opacity:1 }
        }

        @keyframes animatebottom { 
          from{ bottom:-100px; opacity:0 } 
          to{ bottom:0; opacity:1 }
        }

        #myDiv {
          display: none;
          text-align: center;
        }
</style>

  </head>
  <body>
    <noscript>
      <strong>We're sorry but Chatty doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <div id="loader"></div>
    <div class="wrapper" id="app"></div>
    
  </body>
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
  <script>
    window.onload = function() {
      document.getElementById('loader').style.display ='none';
  }
  </script>
</html>