@extends('master')
@section('title', $title )



@section('content')

    <section class="show statistics">
        <h1 class="heading">
            {{$title}}
        </h1>
        @can('create-statistic', $post->match)
            <p class="edit"><a href="{{ route('statistic.edit', $post->id) }}">Upravit</a></p>
            <form action="{{route('statistic.destroy', $post->id)}}" method="post" >
                @csrf 
                {{method_field('DELETE')}}
                <button class="btn btn-danger mb-4" >Smazat statistiku</button>
            </form>
        @endcan
        
            <table>
            @if($post->user)
                <tr><td>Hráč:</td><td> <a href="{{ url('user', $post->user->id) }}">{{$post->user->name}}</a></td></tr>
            @else 
                <tr><td>Hráč:</td><td> Nepřiřazen</td></tr>
            @endif
            
            <tr><td>Turnaj:</td><td> <a href="{{ url('tournament', $post->match->tournament->id) }}">{{ $post->match->tournament->name }}</a></td></tr>
            <tr><td>Zápas:</td><td> <a href="{{ url('match', $post->match->id ) }}">{{$post->match->id}}</a></td></tr>
        </table>
        <div class="content">
        <h3>Statistiky hráče v zápase:</h3>
        
        <table>
            <tr><td>Vojenské skóre:</td><td> <span>{{$post->vojenske_skore}}</span></td></tr>
            <tr><td>Ekonomické skóre:</td><td> <span>{{$post->ekonomicke_skore}}</span></td></tr>
            <tr><td>Technologické skóre:</td><td> <span>{{$post->technologicke_skore}}</span></td></tr>
            <tr><td>Sociální skóre:</td><td> <span>{{$post->socialni_skore}}</span></td></tr>
            <tr><td>Doba přežití:</td><td> <span>{{$post->doba_preziti}} </span>min</td></tr>
        </table>
        

        </div>
    </section>

@endsection