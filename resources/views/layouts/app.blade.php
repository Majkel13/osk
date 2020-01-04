<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
      
     </style>
</head>
<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-info shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    OSK
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    @guest

                    @else
                        @if(Auth::user()->hasRolee('Admin'))
                            <li class="nav-item">
                            <a class="nav-link" href="/dodajUzytkownika" >Dodaj użytkownika</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="{{route('user.wszyscyUzytkownicy')}}" >Wszysycy użytkownicy</a>
                            </li>
                            <li class='nav-item'>
                            <a class="nav-link" href="{{route('jazdy.wszystkieJazdy')}}">Wszystkie jazdy</a>
                            </li>
                            <li class='nav-item'>
                                <a class="nav-link" href="{{route('user.raport')}}">Raporty</a>
                            </li>
                            
                        @endif 
                        @if(Auth::user()->hasRolee('Pracownik'))
                            <li class="nav-item">
                            <a class="nav-link" href="/dodajKursant" >Dodaj kursanta</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="{{route('user.wszyscyKursanci')}}" >Wszysycy kursanci</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="{{route('jazdy.mojeJazdy')}}" >Moje jazdy</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="{{route('jazdy.dodajJazdy')}}" >Dodaj jazdy</a>
                             </li>
                        @endif 
                        @if(Auth::user()->hasRolee('Kursant'))
                        
                            <li class="nav-item">
                            <a class="nav-link" href="{{route('jazdy.mojeJazdyK')}}" >Moje jazdy</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="{{route('jazdy.wolneTerminy')}}" >Wolne terminy</a>
                            </li>
                        @endif 
                    @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                
                            @endif
                        @else
                            <li class="nav-item ">
                                

                                    <a class="nav-link active" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wyloguj') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
        <div class="container">
        @yield('content')
        </div>
            
        </main>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @yield('script')
    
</body>
</html>
