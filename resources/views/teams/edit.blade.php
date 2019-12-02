@extends('master')
@section('title', $title )



@section('content')

    <section class="edit teams">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::model($team, ['url'=>['team', $team->id ], 'method'=>'put', 'class'=>'team', 'enctype' => 'multipart/form-data'  ]) !!}

            @include('teams.form')

            {!! Form::close() !!}



        </div>
    </section>

@endsection