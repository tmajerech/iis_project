@extends('master')
@section('title', $title )



@section('content')

    <section class="edit matches">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::model($post, ['url'=>['match', $post->id ], 'method'=>'put', 'class'=>'post' ]) !!}

                @php
                $options = [];

                foreach($tournaments as $tournament){
                    $options[$tournament->id] = $tournament->name;
                }


                @endphp



                <div class="form-group">
                    {!! Form::label('uroven_pavouka', 'Uroven pavouka') !!}
                    {!! Form::number('uroven_pavouka', $post->uroven_pavouka) !!}
                </div>
                {!! Form::label('vysledky', 'Vysledky') !!}
                {!! Form::text('vysledky') !!}

                
                <h3>Ucastnici</h3>
                <div class="form-group">
                    <h4>-teamy</h4>
                    <ul>
                    @foreach($post->tournament->registered_teams as $team)
                         @php
                            $ids_ucast = $team->matches()->pluck('id')->toArray();
                            $ids = $team->matches()->wherePivot('vyhra','=', 1)->pluck('id')->toArray();
                        @endphp
                        <div class="ucastnik">
                            <li>
                            {!! Form::checkbox('team[]', $team->id, in_array($post->id, $ids_ucast)) !!}
                            {!! Form::label('team[]', $team->id . ' - ' .$team->nazev ) !!}
                            </li>
                            <li>
                            {!! Form::label('vyhra_team', 'Výhra?' ) !!}
                            {!! Form::checkbox('vyhra_team', $team->id, in_array($post->id, $ids)) !!}
                            </li>
                        </div>
                    @endforeach
                    </ul>

                </div>

                <div class="form-group">
                    <h4>-jednotlivci</h4>
                    <ul>
                    @foreach($post->tournament->registered_users as $user)
                        @php
                        $ids_ucast = $user->registered_matches()->pluck('id')->toArray();
                        $ids = $user->registered_matches()->wherePivot('vyhra','=', 1)->pluck('id')->toArray();

                        //var_dump($user->registered_tournaments()->wherePivot('rozhodci', '1')->where('id',$post->tournament->id)->count() );
                        if($user->registered_tournaments()->wherePivot('rozhodci', '1')->where('id',$post->tournament->id)->count() > 0 ){
                            continue;
                        }
                        @endphp

                        <div class="ucastnik">
                            <li>
                            {!! Form::checkbox('user[]', $user->id, in_array($post->id, $ids_ucast)) !!}
                            {!! Form::label('user[]', $user->id . ' - ' .$user->name ) !!}
                            </li>
                            <li>
                            {!! Form::label('vyhra_user', 'Výhra?' ) !!}
                            {!! Form::checkbox('vyhra_user', $user->id, in_array($post->id, $ids) ) !!}
                            </li>
                        </div>
                    @endforeach
                    </ul>
                </div>

                <button type="submit">Odeslat</button>

                <span class="cancel">
                    <a href="{{ URL::previous() }}">Go Back</a>
                </span>

            {!! Form::close() !!}



        </div>
    </section>

@endsection