@extends('master')
@section('title', 'Teamy' )



@section('content')

    <section class="index teams">
        <h1 class="heading">
            Teamy
        </h1>

        @if(Auth::check())
            <p class="pridat"> <a href="{{ url('team', 'create') }}">Přidat team</a> </p>
        @endif

        <div class="content">
            @forelse($teams as $team)

                <div  class="team">
                    <h2> <a href="{{ url('team', $team->id) }}">{{ $team->nazev }}</a></h2>
                    @if($team->logo)
                        <img src="{{asset('storage/'. $team->logo )}}" alt="logo" class="img-thumbnail">
                    @else
                        <p>No logo</p>
                    @endif
                    
                    <table class="popis">
                        <tr><td>Zakladatel:</td><td> <a href='{{url("user", $team->user->id)}}' >{{$team->user->name}}</a></td></tr>
                        <tr><td>Vytvoreno:</td><td> <span>{{$team->created_at}}</span></td></tr>
                        <tr><td>Clenove:</td><td> <span>{{count($team->clenove)}}</span></td></tr>
                    </table>
                   
                </div>

            @empty

                <p>Zadne teamy nejsou vytvoreny</p>

            @endforelse



        </div>
    </section>

@endsection