@extends('master')
@section('title', 'Team' )



@section('content')

    <section class="show teams">
        <h1 class="heading">
            Team {{$team->nazev}}
        </h1>

        @can('edit-team', $team)
            <p class="edit"><a href="{{ route('team.edit', $team->id) }}">Upravit</a></p>
            <form action="{{route('team.destroy', $team->id)}}" method="post" >
                @csrf 
                {{method_field('DELETE')}}
                <button class="btn btn-danger" >Smazat team</button>
            </form>
        @endcan

        @can('enter-team', [$team, $user])
            <p class="enter-team"><a class=" btn btn-primary" href="/team/register_user/{{$team->id}}">Přidat se do teamu</a></p>
        @endcan
        @can('leave-team', $team)
            <p class="leave-team"><a class=" btn btn-danger" href="/team/deregister_user/{{$team->id}}">Opustit team</a></p>
        @endcan


        <div class="content">
            
            <div class="logo-wrap">
                @if($team->logo)
                    <img src="{{asset('storage/'. $team->logo )}}" alt="logo" class="img-thumbnail">
                @else
                    <p>No logo</p>
                @endif
            </div>
            <p class="vytvoreni">Vytvořeno: {{$team->created_at}}</p>
            
            <div class="zakladatel">
                <h2>Zakladatel</h2>
                <p><a href='{{url("user", $team->user->id)}}' >{{$team->user->name}}</a></p>
            </div>
            <div class="clenove">
                <h2>Clenove teamu:</h2>
                <ul>
                @if($team->clenove && count($team->clenove) > 0 )
                    @foreach($team->clenove as $clen)
                        <li><a href="{{url('user', $clen->id )}}">{{$clen->name}}</a></li>
                    @endforeach           
                @else
                    <p>zadni clenove</p>            
                @endif
                </ul>
                <!--TODO-->
            </div>

            <h3 class="mt-4" >Statistiky</h3>
            @php

            $pocet_hracu = $team->clenove->count();
            $pocet = 0;
            $vojenske_skore = 0;
            $ekonomicke_skore = 0;
            $technologicke_skore = 0;
            $socialni_skore = 0;
            $doba_preziti = 0;
            $vyhry = $team->matches()->withPivot('vyhra', '=', '1')->count();

            $ids_zapasu = $team->matches->pluck('id')->toArray();
  
            foreach($team->clenove as $user ){
                foreach($user->statistics->whereIn('match_id', $ids_zapasu) as $statistic){
                    $pocet++;
                    $vojenske_skore += $statistic->vojenske_skore;
                    $ekonomicke_skore += $statistic->ekonomicke_skore;
                    $technologicke_skore += $statistic->technologicke_skore;
                    $socialni_skore += $statistic->socialni_skore;
                    $doba_preziti += $statistic->doba_preziti;
                }
            }





            
            @endphp

            <table class="mb-5" >
                @if($pocet > 0)
                <tr><td>Počet zápasů:</td><td> {{$pocet}}</tr>
                <tr><td>Počet výher:</td><td> {{ $vyhry }}</tr>
                <tr><td>Celkové vojenské skóre:</td><td> {{$vojenske_skore}}</tr>
                <tr><td>Celkové ekonomické skóre:</td><td> {{$ekonomicke_skore}}</tr>
                <tr><td>Celkové technologické skóre:</td><td> {{$technologicke_skore}}</tr>
                <tr><td>Celkové sociální skóre:</td><td> {{$socialni_skore}}</tr>
                <tr><td>Celková doba přežití:</td><td> {{$doba_preziti}}min</tr>
                <tr><td></tr>
                <tr><td>Průměrné vojenské skóre na hráče:</td><td> {{round($vojenske_skore/$pocet_hracu)}}</tr>
                <tr><td>Průměrné ekonomické skóre na hráče:</td><td> {{round($ekonomicke_skore/$pocet_hracu)}}</tr>
                <tr><td>Průměrné technologické skóre na hráče:</td><td> {{round($technologicke_skore/$pocet_hracu)}}</tr>
                <tr><td>Průměrné sociální skóre na hráče:</td><td> {{round($socialni_skore/$pocet_hracu)}}</tr>
                <tr><td>Průměrná doba přežití na hráče:</td><td> {{round($doba_preziti/$pocet_hracu)}}min</tr>
                
                @else
                <tr><td>Zatím žádné údaje</tr>
                
                @endif
        </table>

        </div>
    </section>

@endsection