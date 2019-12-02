@extends('master')
@section('title', 'jeden user' )



@section('content')

    <section class="show users">

        @can('edit-user', $user)
            <p class="edit"><a href="{{ route('user.edit', $user->id) }}">Upravit</a></p>
            <form action="{{route('user.destroy', $user->id)}}" method="post" >
                @csrf 
                {{method_field('DELETE')}}
                <button class="btn btn-danger" >Smazat uživatele</button>
            </form>
        @endcan

        <h1 class="heading">
           uzivatel {{$user->name}}
        </h1>

        <table>
            <tr><td>Jmeno:</td><td> {{$user->jmeno}}</td></tr>
            <tr><td>email:</td><td> {{$user->email}}</td></tr>
            <tr><td>administrátor:</td><td> {{($user->administrator) ? "Ano" : "Ne" }}</td></tr>
        </table>
            <h3>Zakladatelem teamů:</h3>
        <ul>
            @foreach($user->vlastni_team as $team)
                <li><a href="{{url('team', $team->id )}}">{{$team->nazev}}</a></li>
            @endforeach
        </ul>

            <h3>Členem teamů:</h3>
        <ul>
            @foreach($user->je_v_teamu as $team)
                <li><a href="{{url('team', $team->id )}}">{{$team->nazev}}</a></li>
            @endforeach
        </ul>

        <h3 class="mt-4" >Statistiky</h3>
        @php

        $pocet = $user->statistics->count();
        $vojenske_skore = 0;
        $ekonomicke_skore = 0;
        $technologicke_skore = 0;
        $socialni_skore = 0;
        $doba_preziti = 0;
        $vyhry = $user->registered_matches()->withPivot('vyhra', '=', '1')->count();

        foreach($user->statistics as $statistic){
            $vojenske_skore += $statistic->vojenske_skore;
            $ekonomicke_skore += $statistic->ekonomicke_skore;
            $technologicke_skore += $statistic->technologicke_skore;
            $socialni_skore += $statistic->socialni_skore;
            $doba_preziti += $statistic->doba_preziti;
        }

        foreach($user->je_v_teamu as $team ){
            $vyhry += $team->matches()->withPivot('vyhra', '=', '1')->count();
        }

        
        @endphp

        <table class="mb-5" >
            @if($pocet > 0)
            <tr><td>Počet zápasů:</td><td> {{$pocet}}</td></tr>
            <tr><td>Počet výher (jednottrvec + team):</td><td> {{ $vyhry }}</td></tr>
            <tr><td>Celkové vojenské skóre:</td><td> {{$vojenske_skore}}</td></tr>
            <tr><td>Celkové ekonomické skóre:</td><td> {{$ekonomicke_skore}}</td></tr>
            <tr><td>Celkové technologické skóre:</td><td> {{$technologicke_skore}}</td></tr>
            <tr><td>Celkové sociální skóre:</td><td> {{$socialni_skore}}</td></tr>
            <tr><td>Celková doba přežití:</td><td> {{$doba_preziti}}min</td></tr>
            <tr><td></td></tr>
            <tr><td>Průměrné vojenské skóre na zápas:</td><td> {{round($vojenske_skore/$pocet)}}</td></tr>
            <tr><td>Průměrné ekonomické skóre na zápas:</td><td> {{round($ekonomicke_skore/$pocet)}}</td></tr>
            <tr><td>Průměrné technologické skóre na zápas:</td><td> {{round($technologicke_skore/$pocet)}}</td></tr>
            <tr><td>Průměrné sociální skóre na zápas:</td><td> {{round($socialni_skore/$pocet)}}</td></tr>
            <tr><td>Průměrná doba přežití na zápas:</td><td> {{round($doba_preziti/$pocet)}}min</td></tr>
            
            @else
            <li>Zatím žádné údaje</li>
            
            @endif
    </table>




    </section>

@endsection