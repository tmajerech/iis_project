@extends('master')
@section('title', $title )



@section('content')

    <section class="index tournaments">
        <h1 class="heading">
            {{$title}}
        </h1>

        @if(Auth::check())
            <p class="pridat"> <a href="{{ url('tournament', 'create') }}">Přidat turnaj</a> </p>
        @endif

        <div class="content">
            @forelse($posts as $post)

                <div  class="post">
                    <h2> <a href="{{ url('tournament', $post->id) }}">{{ $post->name }}</a></h2>
                    <div class="popis">
                        <table>
                            <tr><td>cena za vyhru:</td><td> <span>{{$post->cena}}</span> </td></tr>
                            <tr><td>počet teamů:</td><td> <span>{{$post->pocet_teamu}}</span> </td></tr>
                            <tr><td>počet hráčů:</td><td> <span>{{$post->pocet_hracu}}</span> </td></tr>
                            <tr><td>typ hráčů:</td><td> <span>{{$post->typ_hracu}}</span> </td></tr>
                            <tr><td>poplatek:</td><td> <span>{{$post->poplatek}}</span> </td></tr>
                            <tr><td>vlastnost teamu:</td><td> <span>{{$post->vlastnost_teamu}}</span> </td></tr>
                            <tr><td>zakladatel:</td><td> <span> <a href="{{ url('user', $post->user->id) }}">{{$post->user->name}}</a> </span> </td></tr>
                        </table>
                    </div>
                </div>

            @empty

                <p>Zadne turnaje nejsou vytvoreny</p>

            @endforelse



        </div>
    </section>

@endsection