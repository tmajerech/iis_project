@extends('master')
@section('title', $title )



@section('content')

    <section class="create teams">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::open(['url'=>'team', 'method'=>'post', 'class'=>'team', 'enctype' => 'multipart/form-data' ]) !!}

            @include('teams.form')

            {!! Form::close() !!}
            <p><i>Všechna pole jsou povinná</i></p>


        </div>
    </section>

@endsection