@extends('master')
@section('title', $title )



@section('content')

    <section class="create tournaments">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::open(['url'=>'tournament', 'method'=>'post', 'class'=>'tournament' ]) !!}

            @include('tournaments.form')

            {!! Form::close() !!}
            <p><i>Všechna pole jsou povinná</i></p>


        </div>
    </section>

@endsection