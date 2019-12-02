@extends('master')
@section('title', $title )



@section('content')

    <section class="index sponsors">
        <h1 class="heading">
            {{$title}}
        </h1>
        @can('edit-sponsor')
            <p class="pridat"> <a href="{{ url('sponsor', 'create') }}">Přidat sponzora</a> </p>
        @endcan
        

        <div class="content">
            @forelse($posts as $post)

                <div  class="post">
                    <h2> <a href="{{ url('sponsor', $post->id) }}">{{ $post->name }}</a></h2>
                    <div class="logo">
                        @if($post->logo)
                            <img src="{{asset('storage/'. $post->logo )}}" alt="logo" class="img-thumbnail">
                        @else
                            <p>No logo</p>
                        @endif
                    </div>
                    <div class="popis">
                        <p>sponzoruje: <span>{{count($post->sponsoring)}}</span> </p>
                    </div>
                   
                </div>

            @empty

                <p>Zadni sponzori nejsou vytvoreni</p>

            @endforelse



        </div>
    </section>

@endsection