<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>super app</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="frontpage" >
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
                    <a href="{{url('/')}}" class="logo"><img src="{{asset('img/logo.png')}}" alt="logo"></a>
                    <div class="flex-center position-ref full-height bg-red">
                    @if (Route::has('login'))
                        <ul class="top-right links">

                        <li><a href="{{ url('statistic') }}">Statistiky</a></li>

                        <li><a href="{{ url('team') }}">Teamy</a></li>

                        <li><a href="{{ url('tournament') }}">Turnaje</a></li>

                        <li><a href="{{ url('user') }}">Uživatelé</a></li>

                        <li><a href="{{ url('sponsor') }}">Sponzoři</a></li>
                            @auth
                                <li><a href="{{ url('user', Auth::user()->id) }}">Profil</a></li>
                                <li><a href="{{ url('logout') }}">Odhlásit</a></li>
                            @else
                            <li><a href="{{ route('login') }}">Login</a></li>

                                @if (Route::has('register'))
                                <li><a href="{{ route('register') }}">Register</a></li>
                                @endif
                            @endauth
                        </ul>
                    @endif
                    </div>
                </div>
        </nav>
           

            <div class="content-main">
               <div class="container">
                   <h1>Nejlepší systém pro správu turnajů ve hře
                        <span>AGE OF EMPIRES</span>
                   </h1>
               </div>
            </div>
        </div>
    </body>
</html>
