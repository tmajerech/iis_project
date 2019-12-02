@extends('master')
@section('title', $title )



@section('content')

    <section class="show sponsors">
        <h1 class="heading">
            Sponzor {{$title}}
        </h1>
        @can('edit-sponsor')
            <p class="pridat"> <a href="{{ route('sponsor.edit', $post->id) }}">Upravit sponzora</a> </p>
            <form action="{{route('sponsor.destroy', $post->id)}}" method="post" >
                @csrf 
                {{method_field('DELETE')}}
                <button class="btn btn-danger" >Smazat sponzora</button>
            </form>
        @endcan

        <div class="logo">
            @if($post->logo)
                <img src="{{asset('storage/'. $post->logo )}}" alt="logo" class="img-thumbnail">
            @else
                <p>No logo</p>
            @endif
        </div>


        <div class="content">
        <h3>Sponzorovane turnaje:</h3>
        <table>
        @if($post->sponsoring && count($post->sponsoring) > 0 )
            @foreach($post->sponsoring as $clen)
                <tr><td><a href="{{url('tournament', $clen->id )}}">{{$clen->name}}</a> </td><td> {{$clen->pivot->castka}} Kč</td></tr>
            @endforeach   
        @else
            <tr><td>Zadne sponzorovane turnaje</td></tr>
        @endif        
        </table>

        </div>
    </section>

@endsection