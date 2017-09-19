<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VDN') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-imageupload.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- <link href="{{ asset('css/bootstrap-imageupload.css') }}" rel="stylesheet"> -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 210;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            table{ text-align: center; font-size: 14px;}
　　        table>thead>tr>th{ font-weight: normal;}
　　        .text-right{ padding-right:73px; text-align: right;}
　　        .text{ width: 200px; height: 30px; border: 1px solid #ddd; text-align: center;}
        </style>
</head>
<body ng-app="VelozDesign" ng-controller="velozController">
    <div id="app" style="margin:0;padding:0 0 50px 0">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed  -->
                    <button type="button" class="navbar-toggle collapsed" >
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'VDN') }}
                    </a>
                </div>

                <!--search part-->
                <form class="navbar-form navbar-brand" role="search">
                  <div class="input-group">
                    <input type="text" class="form-control" size="120px" aria-describedby="isearch">
                    <span class="input-group-addon" id="isearch"><span class="glyphicon glyphicon-search"></span></span>
                  </div>
               </form>
                <div class="navbar-brand"><a href="{{route('feed')}}" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></a></div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <!-- <div id="usr"> -->
                    <ul class="nav navbar-nav navbar-right">
                        <!--Authentication Links -->
                         @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                   <img src="{{Auth::user()->getAvatar()}}" width="30" height="30" class="img-circle">    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                      </ul>
                    <!-- </div> -->
                </div>
            </div>
        </nav>
        @yield('content')        
    </div>

    <!--Scripts-->
    <div id="parent"></div>

    <!--Angulare -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-resource.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://unpkg.com/react/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/CustomAngularJs.js') }}"></script>
    <script src="{{asset('js/contact_me.js')}}"></script>
    <script src="{{asset('js/jqBootstrapValidation.js')}}"></script>
    <!-- <script src="{{asset('js/imageUpload.js')}}"></script> -->
    <!-- <script src="{{asset('js/bootstrap-imageupload.js')}}"></script> -->
    <script src="{{asset('js/CallPopUp.js')}}"></script>
    <!-- <script src="{{asset('js/ajaxtest.js')}}"></script> -->

</body>
</html>
