<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PAGOD') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/pagod.ico') }}" type="image/x-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('js/JQS_Scheduler/dist/jquery.schedule.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_home1.css') }}"/>
    <link type="text/css" href="{{ asset('css/bootstrap-3.3.7-dist/css/bootstrap-datetimepicker.min.css') }}" />
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <!-- <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script> -->
    <script src="{{ asset('css/bootstrap-3.3.7-dist/js/jquery.min.js')}}"></script>
    <script src="{{ asset('css/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/JQS_Scheduler/dist/jquery.schedule.js') }}"></script>
    <script type="text/javascript" src="{{ asset('css/bootstrap-3.3.7-dist/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{  asset('js/LoadingModal/js/jquery.loadingModal.js') }}"></script>
    @stack('header_scripts')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
     @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar but_color navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button id="menu" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                    </button>

                    <a href="/home" class="but_color navbar-brand">{{ config('app.name', 'PAGOD') }} </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="but_color" href="/home" data-toggle="tooltip" data-placement="bottom" title="Home" >
                                <span class="glyphicon glyphicon-home"></span>
                                Home
                            </a>
                        </li>
                        <!-- <li>
                            <a class="but_color" href="/studyplan" data-toggle="tooltip" data-placement="bottom" title="Study Plan" >
                                <span class="glyphicon glyphicon-education"></span>
                                Study Plan
                            </a>
                        </li>
                        <li>
                            <a class="but_color" href="/acadprogress" data-toggle="tooltip" data-placement="bottom" title="Academic Progress" >
                                <span class="glyphicon glyphicon-tasks"></span>
                                Progress
                            </a>
                        </li>
                        <li>
                            <a class="but_color" href="/addpreference" data-toggle="tooltip" data-placement="bottom" title="Preferences" >
                                <span class="glyphicon glyphicon-dashboard"></span>
                                Preferences
                            </a>
                        </li>
                        <li>
                            <a class="but_color" href="/addwishlist" data-toggle="tooltip" data-placement="bottom" title="Add Wishlist" >
                                <span class="glyphicon glyphicon-list"></span>
                                Wishlist
                            </a>
                        </li> -->
                        <li>
                            <a class="but_color" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                <span class="glyphicon glyphicon-off"></span>
                                Logout
                            </a>

                            <form class="but_color" id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>