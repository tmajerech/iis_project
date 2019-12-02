@extends('master')
@section('title', $title )



@section('content')

    <section class="edit tournaments">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::model($post, ['url'=>['tournament', $post->id ], 'method'=>'put', 'class'=>'post' ]) !!}

            @include('tournaments.form')

            {!! Form::close() !!}



        </div>
    </section>

@endsection