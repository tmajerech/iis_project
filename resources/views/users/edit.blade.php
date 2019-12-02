@extends('master')
@section('title', $title )



@section('content')

    <section class="edit users">
        <h1 class="heading">
            {{$title}}
        </h1>

        <div class="content">
           

            {!! Form::model($user, ['url'=>['user', $user->id ], 'method'=>'put', 'class'=>'post' ]) !!}

                {{ csrf_field() }}

                <div class="form-group">
                <label for="name">Přezdívka</label>
                <input type="text" name="name"  value="{{ $user->name }}" />
                </div>
                <div class="form-group">
                <label for="name">Jméno</label>
                <input type="text" name="jmeno"  value="{{ $user->jmeno }}" />
                </div>
                <div class="form-group">
                <label for="email">email</label>
                <input type="email" name="email"  value="{{ $user->email }}" />
                </div>
                <div class="form-group">
                <label for="password">heslo</label>
                <input type="password" name="password" />
                </div>
                <div class="form-group">
                <label for="password_confirmation">Potvrzeni hesla</label>
                <input type="password" name="password_confirmation" />
                </div>

                @if(Auth::user()->administrator)
                    <div class="form-group">
                    <label for="administrator">Administrator</label>
                    <input type="checkbox" name="administrator" value="1" {{($user->administrator) ? "checked" : '' }} />
                    </div>
                @endif


                <button type="submit">Send</button>

            {!! Form::close() !!}



        </div>
    </section>

@endsection