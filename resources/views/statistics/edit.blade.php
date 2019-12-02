@extends('master')
@section('title', $title )



@section('content')

    <section class="edit statistics">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::model($post, ['url'=>['statistic', $post->id ], 'method'=>'put', 'class'=>'statistic' ]) !!}

                @php
                $options = [];
                foreach($matches as $match){
                    $options[$match->id] = "turnaj " . $match->tournament->name . ", zapas " . $match->id;
                }

                $options_user = [];


                foreach($post->match->tournament->registered_users as $user){
                    $options_user[$user->id] = $user->id . " - " . $user->name;
                }
                foreach($post->match->tournament->registered_teams as $team){
                    foreach($team->clenove as $user){
                        $options_user[$user->id] = $team->nazev . " ID" . $user->id . " - " . $user->name;
                    }                
                }


                @endphp


                <div class="form-group">
                    {!! Form::label('user_id', 'Vyberte ucastnika') !!}
                    {!! Form::select('user_id', $options_user) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('match_id', 'Vojenské skore') !!}
                    {!! Form::number('vojenske_skore') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('match_id', 'Ekonomické skore') !!}
                    {!! Form::number('ekonomicke_skore') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('match_id', 'Technologické skore') !!}
                    {!! Form::number('technologicke_skore') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('match_id', 'Sociálni skore') !!}
                    {!! Form::number('socialni_skore') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('match_id', 'Doba přežití') !!}
                    {!! Form::number('doba_preziti') !!}
                </div>


                <button type="submit">Odeslat</button>

                <span class="cancel">
                    <a href="{{ URL::previous() }}">Go Back</a>
                </span>

            {!! Form::close() !!}



        </div>
    </section>

@endsection