@extends('master')
@section('title', $title )



@section('content')

<section class="show tournaments">
        
        <h1 class="heading">
            Turnaj {{$title}}
        </h1>

        @can('edit-tournament', $post)
            <p class="edit"><a href="{{ route('tournament.edit', $post->id) }}">Upravit</a></p>
            <form action="{{route('tournament.destroy', $post->id)}}" method="post" >
                @csrf 
                {{method_field('DELETE')}}
                <button class="btn btn-danger mb-4" >Smazat turnaj</button>
            </form>
        @endcan
        @can('enter-tournament', $post)
        <a href="{{ url("/tournament/register_user/$post->id") }}" class="btn btn-primary mb-4">Zúčastnit se</a>
        @endcan
        @can('enter-tournament-judge', $post)
        <p><a href="{{ url("/tournament/register_judge/$post->id") }}" class="btn btn-secondary mb-4" >Zúčastnit se jako rozhodčí</a></p>
        @endcan
        @can('leave-tournament', $post)
        <p><a href="{{ url("/tournament/deregister_user/$post->id") }}" class="btn btn-danger mb-4" >Odhlásit se</a></p>
        @endcan
        @can('enter-tournament', $post)
            @if(Auth::user()->vlastni_team->count() > 0 )
                @php
                    $text = "";
                    foreach(Auth::user()->vlastni_team as $team ){
                        $mem = 0;
                        if($team->tournaments->where('id', $post->id)->count() > 0 ){
                            continue;
                        }
                        if($team->clenove->count() != $post->pocet_hracu ){
                            continue;
                        }
                        foreach($team->clenove as $user){
                            if($user->registered_tournaments->where('id', $post->id)->count() > 0 ){
                                $mem = 1;
                                break;
                            }
                        }
                        if($mem == 1){
                            continue;
                        }
                        $text .= "<option value='$team->id' >$team->nazev - ID $team->id</option>";
                    }
                @endphp
                @if($text != "")
                    <div>
                        <form class="flex mb-4" action="{{ url("/tournament/register_team/$post->id") }}" method="post" >
                            @csrf
                            <select name="team" >
                                {!! $text !!}
                            </select>
                            <button class="btn btn-primary" >Přihlásit team</button>
                        </form>
                    </div>
                @endif
            @endif
        @endcan

        <div class="content">
           
            <div class="popis">
                <ul>
                    <li>cena za vyhru: <span>{{$post->cena}}</span> </li>
                    <li>počet teamů: <span>{{$post->pocet_teamu}}</span> </li>
                    <li>počet hráčů: <span>{{$post->pocet_hracu}}</span> </li>
                    <li>typ hráčů: <span>{{$post->typ_hracu}}</span> </li>
                    <li>poplatek: <span>{{$post->poplatek}}</span> </li>
                    <li>vlastnost teamu: <span>{{$post->vlastnost_teamu}}</span> </li>
                    <li class="vytvoreni"> vytvoreno: {{$post->created_at}}</li>
                </ul>
            </div> 

            <div class="zakladatel">
                <h2>Zakladatel</h2>
                <p><a href='{{url("user", $post->user->id)}}' >{{$post->user->name}}</a></p>
            </div>
            <div class="clenove">
                <h2>Registrovani ucastnici:</h2>
                
                <form method="post" accept-charset="utf-8" action="{{ action('TournamentController@update_registered') }}">
                    <ul>
                        @if($post->registered_users && count($post->registered_users) > 0 )
                            @foreach($post->registered_users as $clen)
                                <li><a href="{{url('user', $clen->id )}}">{{$clen->name}}</a> {{($clen->pivot->rozhodci) ? "- Rozhodčí" : "" }} </li>
                                @can('edit-tournament', $post)
                                <li class="zaplaceno">
                                    <label >Zaplaceno
                                        <input type="checkbox" 
                                        name="users[]" 
                                        {{($clen->pivot->poplatek_uhrazen) ? "checked" : "" }} 
                                        value="{{$clen->id}}"
                                        >
                                    </label>
                                    
                                </li>
                                @endcan
                                @can('deregister-jineho-ucastnika', $post)
                                <li><a href="{{ url("/tournament/deregister_jineho_ucastnika/$post->id/$clen->id") }}">Odhlásit ucastnika</a></li>
                                @endcan
                            @endforeach           
                        @else
                            <p>zadni registrovani ucastnici</p>            
                        @endif
                        </ul>

                        <h2>Registrovane teamy:</h2>
                        <ul>
                        @if($post->registered_teams && count($post->registered_teams) > 0 )
                            @foreach($post->registered_teams as $clen)
                                <li class="mt-4" >Team <a href="{{url('team', $clen->id )}}">{{$clen->nazev}}</a></li>
                                @can('edit-tournament', $post)
                                <li class="zaplaceno">
                                    <label >Zaplaceno
                                        <input type="checkbox" 
                                        name="teams[]" 
                                        {{($clen->pivot->poplatek_uhrazen) ? "checked" : "" }} 
                                        value="{{$clen->id}}"
                                        >
                                    </label>
                                </li>
                                @endcan
                                @can('deregister-team', [$post, $clen])
                                <li><a href="{{ url("/tournament/deregister_team/$post->id/$clen->id") }}">Odhlásit team</a></li>
                                @endcan
                            @endforeach           
                        @else
                            <p>zadne registrovane teamy</p>            
                        @endif
                    </ul>
                    @can('edit-tournament', $post)
                    <button type="submit">Upravit</button>
                    {{csrf_field()}}
                    <input type="hidden" name="tournament_id" value="{{$post->id}}">
                    @endcan
                </form>
            </div>

            <div class="zapasy my-5">
                <h3>Zápasy</h3>
                <p><i>* zápasy řazeny sestupně. Na vrcholu je poslední zápas z nejvyšší úrovně pavouka. </i></p>
                @can('edit-match', $post)
                    <p class="edit"><a href="{{ route('match.create') }}" class="btn btn-secondary" >Přidat zápas</a></p>
                @endcan

                <ul> 
                <?php 
                $i = 999;  
                $j = $post->matches->sortByDesc('uroven_pavouka')->sortByDesc('id')->count();
                ?>
                {{-- Zapasy uzivatelu --}}
                <h4>Jednotlivci</h4>
                @forelse ($post->matches->sortByDesc('uroven_pavouka')->sortByDesc('id') as $match)
                    @php

                    if($match->ucastnici_user->count() == 0){
                        continue;
                    }

                    if($i > $match->uroven_pavouka){
                        $i = $match->uroven_pavouka;
                        echo '<p>==================== '. $i .'. kolo =========================</p>';
                    }
                    @endphp
                    <li><a href="{{ url('match', $match->id) }}">Zápas s ID {{$match->id}}</a>
                        <ul>
                    @foreach($match->ucastnici_user as $user)
                        <li class="m-0"><a href="{{ url('user', $user->id) }}">{{$user->name}}</a> {{($user->pivot->vyhra == 1) ? "Vítěz" : "" }} </li>
                    @endforeach
                        </ul>
                    </li>
                @empty
                    <p>Zatím žádné zápasy</p>
                @endforelse

                {{-- Zapasy teamu --}}
                <h4 class="mt-5" >Teamy</h4>
                <?php 
                $i = 999;
                $j =  $post->matches->sortByDesc('uroven_pavouka')->sortByDesc('id')->count();
                ?>
                @foreach($post->matches->sortByDesc('uroven_pavouka')->sortByDesc('id') as $match)
                    @php

                    if($match->ucastnici_team->count() == 0){
                        continue;
                    }

                    if($i > $match->uroven_pavouka){
                        $i = $match->uroven_pavouka;
                        echo '<p>==================== '. $i .'. kolo =========================</p>';
                    }
                    @endphp
                    <li><a href="{{ url('match', $match->id) }}">Zápas s ID {{$match->id}}</a>
                    <ul>
                    @foreach($match->ucastnici_team as $team)
                        <li class="m-0"><a href="{{ url('team', $team->id) }}">{{$team->nazev}}</a> {{($team->pivot->vyhra == 1) ? "Vítěz" : "" }} </li>
                    @endforeach
                    </ul>
                    </li>
                @endforeach


                </ul>
            </div>



            
            <div class="statistics">
                <h3 class="my-4" >Statistiky</h3>

                @php


                $pocet = 0;
                $vojenske_skore = 0;
                $ekonomicke_skore = 0;
                $technologicke_skore = 0;
                $socialni_skore = 0;
                $doba_preziti = 0;


                foreach($post->matches as $match ){
                    foreach($match->statistics as $statistic){
                        $pocet++;
                        $vojenske_skore += $statistic->vojenske_skore;
                        $ekonomicke_skore += $statistic->ekonomicke_skore;
                        $technologicke_skore += $statistic->technologicke_skore;
                        $socialni_skore += $statistic->socialni_skore;
                        $doba_preziti += $statistic->doba_preziti;
                    }
                }

                @endphp


                <table>

                    @if($pocet > 0)
                    <tr><td>Celkové vojenské skóre:</td><td> {{$vojenske_skore}}</td></tr>
                    <tr><td>Celkové ekonomické skóre:</td><td> {{$ekonomicke_skore}}</td></tr>
                    <tr><td>Celkové technologické skóre:</td><td> {{$technologicke_skore}}</td></tr>
                    <tr><td>Celkové sociální skóre:</td><td> {{$socialni_skore}}</td></tr>
                    <tr><td>Celková doba přežití:</td><td> {{$doba_preziti}}min</td></tr>
                    <tr><td></td></tr>
                    <tr><td>Průměrné vojenské skóre na hráče:</td><td> {{round($vojenske_skore/$pocet)}}</td></tr>
                    <tr><td>Průměrné ekonomické skóre na hráče:</td><td> {{round($ekonomicke_skore/$pocet)}}</td></tr>
                    <tr><td>Průměrné technologické skóre na hráče:</td><td> {{round($technologicke_skore/$pocet)}}</td></tr>
                    <tr><td>Průměrné sociální skóre na hráče:</td><td> {{round($socialni_skore/$pocet)}}</td></tr>
                    <tr><td>Průměrná doba přežití na hráče:</td><td> {{round($doba_preziti/$pocet)}}min</td></tr>
                    
                    @else
                    <li>Zatím žádné údaje</li>
                    
                    @endif

            </table>



            </div>
            
    </section>

@endsection