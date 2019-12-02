@extends('master')
@section('title', $title )



@section('content')

    <section class="create matches">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::open(['url'=>'match', 'method'=>'post', 'class'=>'match' ]) !!}

                @php
                $options = [];

                foreach($tournaments as $tournament){
                    $options[$tournament->id] = $tournament->name;
                }


                @endphp

                <div class="form-group">
                    {!! Form::label('tournament_id', 'Vyberte turnaj') !!}
                    {!! Form::select('tournament_id', $options) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('uroven_pavouka', 'Uroven pavouka') !!}
                    {!! Form::number('uroven_pavouka', "0") !!}
                </div>
                {!! Form::hidden('vysledky', 'zatim nezname') !!}

                <p class="vyjimka">*ucastniky bude mozne doplnit po ulozeni</p>

                <button type="submit">Odeslat</button>

                <span class="cancel">
                    <a href="{{ URL::previous() }}">Go Back</a>
                </span>

            {!! Form::close() !!}



        </div>
    </section>

@endsection