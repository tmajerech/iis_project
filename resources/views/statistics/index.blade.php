@extends('master')
@section('title', $title )



@section('content')

    <section class="index statistics">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
            
            @php

            $pocet_hracu = $users->count();
            $pocet = $posts->count();
            $vojenske_skore = 0;
            $ekonomicke_skore = 0;
            $technologicke_skore = 0;
            $socialni_skore = 0;
            $doba_preziti = 0;



            foreach($posts as $statistic){
                $vojenske_skore += $statistic->vojenske_skore;
                $ekonomicke_skore += $statistic->ekonomicke_skore;
                $technologicke_skore += $statistic->technologicke_skore;
                $socialni_skore += $statistic->socialni_skore;
                $doba_preziti += $statistic->doba_preziti;
            }

            $top_vyhry = 0;
            $top_user = null;
            foreach($users as $user){
                $vyhry = 0;
                $vyhry = $user->registered_matches()->withPivot('vyhra', '=', '1')->count();
                foreach($user->je_v_teamu as $team ){
                    $vyhry += $team->matches()->withPivot('vyhra', '=', '1')->count();
                }

                if($vyhry > $top_vyhry){
                    $top_vyhry = $vyhry;
                    $top_user = $user;
                }

            }







            @endphp
            <table class="mt-4">
                @if($pocet > 0)
                <tr><td>Celkový počet zápasů:</td><td> {{$pocet}}</td></tr>
                @if($top_user != null)
                    <tr><td>Hráč s největším počtem výher:</td><td> <a href="{{ url('user', $top_user->id) }}">{{ $top_user->name }}</a> - {{ $top_vyhry }} výhry</td></tr>
                @endif    
                <tr class="mt-4"><td>Celkové vojenské skóre:</td><td> {{$vojenske_skore}}</td></tr>
                <tr><td>Celkové ekonomické skóre:</td><td> {{$ekonomicke_skore}}</td></tr>
                <tr><td>Celkové technologické skóre:</td><td> {{$technologicke_skore}}</td></tr>
                <tr><td>Celkové sociální skóre:</td><td> {{$socialni_skore}}</td></tr>
                <tr class="mb-4" ><td>Celková doba přežití:</td><td> {{$doba_preziti}}min</td></tr>
                <tr><td>Průměrné vojenské skóre na hráče:</td><td> {{round($vojenske_skore/$pocet_hracu)}}</td></tr>
                <tr><td>Průměrné ekonomické skóre na hráče:</td><td> {{round($ekonomicke_skore/$pocet_hracu)}}</td></tr>
                <tr><td>Průměrné technologické skóre na hráče:</td><td> {{round($technologicke_skore/$pocet_hracu)}}</td></tr>
                <tr><td>Průměrné sociální skóre na hráče:</td><td> {{round($socialni_skore/$pocet_hracu)}}</td></tr>
                <tr><td>Průměrná doba přežití na hráče:</td><td> {{round($doba_preziti/$pocet_hracu)}}min</td></tr>
                
                @else
                <li>Zatím žádné údaje</li>
                
                @endif
            </table>

            

        </div>
        <div class="mt-5" ><i>Detailnější statistiky naleznete u jednotlivých hráčů, zápasů a turnajů.</i></div>
    </section>

@endsection