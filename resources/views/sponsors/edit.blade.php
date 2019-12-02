@extends('master')
@section('title', $title )



@section('content')

    <section class="edit sponsors">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::model($post, ['url'=>['sponsor', $post->id ], 'method'=>'put', 'class'=>'post', 'enctype' => 'multipart/form-data'  ]) !!}

            @include('sponsors.form')

            {!! Form::close() !!}



        </div>
    </section>

@endsection