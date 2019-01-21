<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') | {{ config('app.name', 'Rocket Learning') }}</title>

    <!-- Styles -->
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/multirange.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    @yield('css')

</head>

<body class="app">


    @include('partials.spinner')
    
        <!-- #Left Sidebar ==================== -->
        @include('partials.sidebar')

        <!-- #Main ============================ -->
        <div class="page-container ">
       
            <!-- ### $Topbar ### -->
            @include('partials.topbar')

            <!-- ### $App Screen Content ### -->
             <main class='main-content bgc-grey-200  '>
                <div id='mainContent'>
                    <div class="container-fluid ">

                        <h4 class="c-grey-900 mT-10 mB-30 ">@yield('page-header')</h4>
                        @yield('content-chatbot')
                        @include('partials.messages')
                        @yield('content')

                    </div>
                </div>
                      
            </main>
         <!-- ### $App Screen Footer ### -->
                     
              @include('partials.footer')
        
         </div>
  

    <script src="{{ asset('/js/app.js') }}"></script>
    <script src="{{ asset('/plugins/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('/js/ratingstart.js') }}"></script>
    <script src="{{ asset('/js/jquery-clockpicker.min.js') }}"></script>
    <script src="{{ asset('/js/progressbar.min.js') }}"></script>
    @yield('js')

    </body>

</html>
