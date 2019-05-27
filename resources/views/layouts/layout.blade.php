<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ConCast') }} @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?">
    <link rel="stylesheet" href="{{ asset('css/audio-player.css') }}">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>

<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="/">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/"><i class="fas fa-home"></i> {{ __('Home') }} <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/discover">{{ __('title.podcast') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/channel">{{ __('title.channel') }}</a>
                        </li>
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
                            <li class="nav-item">
                                <a class="nav-link" href="/upload">{{ __('title.upload') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">{{ __('title.profile') }}</a>
                                    <a class="dropdown-item" href="/profile/channel">Your channels</a>
                                    <a class="dropdown-item" href="/profile/podcast">Your podcasts</a>
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
                        @endguest
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ml-6">
                            <form class="form-inline my-2 my-lg-0 mr-2" method="POST" action="/search">
                                @csrf

                                <input id="search" type="text" class="form-control mr-sm-2 @error('search') is-invalid @enderror" name="search" value="{{ old('search') }}" placeholder="Search channels and podcasts">

                                <button class="btn btn-outline my-2 my-sm-0" type="submit">{{ __('title.search') }}</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-success">
                                <a style="color: white;" href="/upgrade"><i class="fas fa-star"></i>{{ __('title.upgrade') }}</a>
                            </button>
                        </li>

                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('title.podcast') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">THE EARTH IS FLAT</a>
                                <a class="dropdown-item" href="#">OBAMA</a>
                                <a class="dropdown-item" href="#">GLOBAL WARMING IS A HOAX</a>
                                <a class="dropdown-item" href="#">THE 9/11 ATTACKS</a>
                                <a class="dropdown-item" href="#">THE MOON LANDING HOAX</a>
                                <a class="dropdown-item" href="#">THE CIA AND AIDS</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/discover">{{ __('title.discover') }}</a>
                            </div>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if ($errors->any())
                <div class="alert alert-danger col-md-4" style="margin: auto; margin-bottom: 1rem;">
                    @foreach ($errors->all() as $errorMessage)
                        <strong>Error!</strong> {{ $errorMessage }}<br>
                    @endforeach
                </div>
            @endif

            @if(Session::has('message'))
                <div class="alert alert-success col-md-4" style="margin: auto; margin-bottom: 1rem;">
                    <strong>Success!</strong> {{ Session::get('message') }}<br>
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-center">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>