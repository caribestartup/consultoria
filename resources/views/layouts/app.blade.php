<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/styles.css') }}" rel="stylesheet">
</head>
<body class="app">

@include('partials.spinner')

<div class="peers ai-s fxw-nw h-100vh" style='background-image: url("/images/assets/home.jpg"); min-height: 100%; background-attachment: fixed;
background-size: cover; background-repeat: no-repeat'>
    {{--<div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" >
      <div class="pos-a centerXY">
        <div class="bgc-white bdrs-50p pos-r" style='width: 120px; height: 120px;'>
          <img class="pos-a centerXY" src="{{ asset('/images/logo.png') }}" alt="">
            <h1>Rocket Learning</h1>
        </div>
      </div>
    </div>
  --}}
    <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" >
        <div class="pos-a centerXY w-100 text-center">
            <img class="image-logo-login" src="{{ asset('/images/assets/logo_login_page.png') }}" alt="">
        </div>
    </div>

    <div class="col-xs-12 col-md-5 peer pX-40 pY-80 h-100 scrollable" >
        <div class="bgc-white">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
