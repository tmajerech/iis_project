@extends('master')
@section('title', $title )



@section('content')

    <section class="create sponsors">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::open(['url'=>'sponsor', 'method'=>'post', 'class'=>'sponsor', 'enctype' => 'multipart/form-data'  ]) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Jmeno') !!}
                    {!! Form::text('name', null, [
                        'placeholder'=>'Jmeno sponzora',
                        'required'=>'true'
                    ] ) !!}
                </div>

                <h3>Vyberte sponzorovane teamy a zadejte castku</h3>

                    
                    @foreach($tournaments as $tournament)

                        <div class="form-group">
                            {!! Form::label('tournament-'. $tournament->id , $tournament->id . "-" . $tournament->name ) !!}
                            {!! Form::checkbox('tournament[]', $tournament->id) !!}
                            {!! Form::number('castka-' . $tournament->id) !!}       
                        </div>
                    @endforeach

                    <div class="form-group">
                        {!! Form::label('logo', 'logo') !!}
                        {!! Form::file('logo', null, [
                            'accept'=>'image/*'
                        ] ) !!}
                    </div>





                <button type="submit">Odeslat</button>

            {!! Form::close() !!}



        </div>
    </section>

@endsection