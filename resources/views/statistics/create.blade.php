@extends('master')
@section('title', $title )



@section('content')

    <section class="create statistics">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::open(['url'=>'statistic', 'method'=>'post', 'class'=>'statistic' ]) !!}

            
                @php
                $options = [];

                foreach($matches as $match){
                    $options[$match->id] = "turnaj " . $match->tournament->name . ", zapas ID " . $match->id;
                }


                @endphp

                <div class="form-group">
                    {!! Form::label('match_id', 'Vyberte zapas') !!}
                    {!! Form::select('match_id', $options) !!}
                </div>
                {!! Form::hidden('user_id', 'NULL') !!}
                {!! Form::hidden('vojenske_skore', '0') !!}
                {!! Form::hidden('ekonomicke_skore', '0') !!}
                {!! Form::hidden('technologicke_skore', '0') !!}
                {!! Form::hidden('socialni_skore', '0') !!}
                {!! Form::hidden('doba_preziti', '0') !!}


            <button type="submit">Odeslat</button>

            <span class="cancel">
                <a href="{{ URL::previous() }}">Go Back</a>
            </span>

            {!! Form::close() !!}



        </div>
    </section>

@endsection