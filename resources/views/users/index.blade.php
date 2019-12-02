@extends('master')
@section('title', '' )



@section('content')

<section class="index users">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
            @forelse($posts as $post)

                <div  class="post">
                    <h2> <a href="{{ url('user', $post->id) }}">{{ $post->name }}</a></h2>
                    <div class="popis">
                    <table>
                        <tr><td>Jmeno:</td><td> {{$post->jmeno}}</td></tr>
                        <tr><td>email:</td><td> {{$post->email}}</td></tr>
                        <tr><td>administrátor:</td><td> {{($post->administrator) ? "Ano" : "Ne" }}</td></tr>
                    </table>
                    </div>
                </div>

            @empty

                <p>Zadne turnaje nejsou vytvoreny</p>

            @endforelse



        </div>
    </section>

@endsection