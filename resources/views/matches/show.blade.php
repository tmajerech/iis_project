@extends('master')
@section('title', $title )



@section('content')

    <section class="show matches">
        <h1 class="heading">
            {{$title}} ID {{$post->id}}
        </h1>
        @can('edit-match', $post->tournament)
            <p class="edit"><a href="{{ route('match.edit', $post->id) }}" class="btn btn-secondary" >Upravit zápas</a></p>
        @endcan

        <div class="content">
            
            <div class="popis">
                <table class="mb-5" >
                    <tr><td>turnaj:</td><td> <span><a href="{{ url('tournament', $post->tournament->id) }}">{{$post->tournament->name}}</a></span> </td></tr>
                    <tr><td>vysledky:</td><td> <span>{{ $post->vysledky }}</span> </td></tr>
                    <tr><td>uroven pavouka:</td><td> <span>{{ $post->uroven_pavouka }}</span></td></tr>
                    <tr class="vytvoreni"><td> vytvoreno:</td><td> {{$post->created_at}}</td></tr>
                </table>
            </div> 
            
            
            <div class="clenove">
                <h3>Účastníci</h3>
                @if($post->ucastnici_team->count() != 0)
                    @foreach($post->ucastnici_team as $team)
                    
                        <p><a href="{{ url('team', $team->id) }}">{{$team->nazev}}</a> <span class="vyhra">{{($team->pivot->vyhra)? "- Výhra" : ""}}</span> </p>  
                    @endforeach
                @endif

                @if($post->ucastnici_user->count() != 0)
                    @foreach($post->ucastnici_user as $user)
                        <p><a href="{{ url('user', $user->id) }}">{{$user->name}}</a> <span class="vyhra">{{($user->pivot->vyhra)? "- Výhra" : "" }}</span> </p>
                    @endforeach
                @endif



                @if($post->ucastnici_team->count() == 0 && $post->ucastnici_user->count() == 0)
                    <p>Zatím žádní účastníci.</p>
                @endif
                
            </div>

            <div class="statistiky mt-2">
                <h3>Statistiky hráčů v tomto zápase</h3>
                
                @can('create-statistic', $post)
                    <a href="{{ route('statistic.create') }}" class="btn btn-secondary mt-2 mb-4" >Přidat statistiku</a>
                @endcan

                <ul>
                @foreach($post->statistics as $statistic)
                    <li><a href="{{ url('statistic', $statistic->id) }}">Statistika pro {{($statistic->user != null ) ? $statistic->user->name : "*Nepřiřazeno*"  }}</a></li>
                @endforeach
                </ul>
            </div>

        </div>
    </section>

@endsection