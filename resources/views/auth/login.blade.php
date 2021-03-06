<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>{{ config('app.name', 'PAGOD') }}</title>
        <link rel="shortcut icon" href="{{ asset('images/pagod.ico') }}" type="image/x-icon">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ asset('css/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
        <link rel="stylesheet" href="{{ asset('js/JQS_Scheduler/dist/jquery.schedule.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style_home1.css') }}"/>
        <script src="{{ asset('css/bootstrap-3.3.7-dist/js/jquery.min.js')}}"></script>
        <script src="{{ asset('js/JQS_Scheduler/dist/jquery.schedule.js') }}"></script>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="container" class="container">
            
            <div class="row body-head">
                <div class="col-md-12 header-container">
                    <div class="col-xs-4 col-md-3 col-md-offset-1">
                        <img class="img-icon" src="{{ asset('images/pagod.ico') }}">
                    </div>
                    <div class="col-xs-8 col-md-6 col-md-offset-1 txt-title">
                        <h1 class="txt-title-name">PAGOD</h1>
                        <h3 class="hidden-xs">Pre-enlistment Adviser and Guide via Online Data</h3>
                        <h5 class="visible-xs">Pre-enlistment Adviser and Guide via Online Data</h5>
                    </div>
                </div>
            </div>

            <div class="row body">

                <div id="welcome" class="col-xs-12 col-md-5 col-md-offset-1 ">
                    <p>
                        Please type the Student ID and password given to you in the appropriate Student Number and Password boxes at the right then click on the "login" button to enter the menu and registration page.
                    </p>
                    <ul>
                        <li> Get your login account from your college.</li>
                        <li> Note the schedule posted on the main page of this site. </li>
                        <li><b> IMPORTANT:  Always update your personal data. </b></li>
                    </ul>
                    <p>
                        <b>Problems, Comments, Suggestions?</b> Email us at <b style="color:green">gvicay@up.edu.ph</b> / <b style="color:green">adcalcaben@up.edu.ph</b> or call <b style="color:green"> (+63)946-0902-913 </b> / <b style="color:green"> (+63)907-0580-991</b>
                    </p>
                </div>
 
                <div class="col-xs-12 col-md-4 col-md-offset-1">
                    <div class="panel panel-default panel-shadow login_panel">
                        <div class="panel-body">
                            <form role="form" method="POST" action="{{ route('login') }}">
                                 {{ csrf_field() }}

                                <div class="input-group btn_logged"> 
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="Student Number" /> 
                                </div>

                                <div class="input-group btn_logged">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Password" />
                                </div>

                                <button class="but_color btn btn-block" type="submit" name="submit">LOG IN <span class="glyphicon glyphicon-log-in"></span></button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="footer" class="text-center footer">
            <p> <br> CALCABEN - ICAY &copy; 2017 </p>
        </div>

        <script type="text/javascript">
            $(".has-error").click(function(){
                $(this).removeClass("has-error");
                $(this).next().addClass("resolved");
            });
        </script>

    </body>
</html>