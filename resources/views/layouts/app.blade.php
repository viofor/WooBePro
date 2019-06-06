<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>WooBe</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/changeprofilepic.js') }}"></script>
    <script src="{{ asset('js/searchusers.js') }}"></script>
    <script src="{{ asset('js/dayoff.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.modal')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    WooBe
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav">
                            
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <a href="#" data-toggle="modal" data-target="#changeprofilepic" id="changepic">
                                <img id="profilepic"
                                 style="height: 40px; width: 40px; background-color: grey;">
                            </a>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} {{ Auth::user()->lastname }}<span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <!------------------User profile------------------------------>
                                    <a class="dropdown-item" id="profileaddress">
                                        {{ __('Profile') }}
                                    </a>
                                    <!------------------Edit profile info------------------------------>
                                    <a class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('editprofile').submit();">
                                        {{ __('Edit profile') }}
                                    </a>
                                    <form id="editprofile" action="/profile/{{ Auth::user()->id }}/edit" method="GET" style="display: none;">
                                        @csrf
                                    </form>
                                    <!------------------Change password------------------------------>
                                    <a class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('accset').submit();">
                                        {{ __('Account settings') }}
                                    </a>
                                    <form id="accset" action="/profile" method="GET" style="display: none;">
                                        @csrf
                                    </form>
                                    <!------------------Logout form------------------------------>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>                            
                    </ul>
                    <!-- Search tool -->
                    <ul class="navbar-nav">
                        <form class="form-inline">
                            <div class="form-group mb-2">
                                <input type="text" class="form-control-plaintext" name="search" placeholder="Search users by skill">
                            </div>
                            <a href="#" id="searchuser"><img src="/storage/searchicon.jpg" style="width: 30px"></a>
                        </form>
                    </ul>
                        @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(!empty(session('error')))
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if(!empty(session('success')))
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
