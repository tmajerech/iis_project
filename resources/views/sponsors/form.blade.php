

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
            {!! Form::checkbox('tournament[]', $tournament->id, ($tournament->sponsors->where('id', $post->id)->first->pivot != null)) !!}
            @if($tournament->sponsors->where('id', $post->id)->first->pivot != null)
                {!! Form::number('castka-' . $tournament->id, $tournament->sponsors->where('id', $post->id)->first->pivot->pivot->castka) !!}
            @else
                {!! Form::number('castka-' . $tournament->id) !!}
            @endif
            
        </div>
    @endforeach

    <div class="form-group">
        {!! Form::label('logo', 'logo') !!}
        {!! Form::file('logo', null, [
            'accept'=>'image/*'
        ] ) !!}
    </div>





<button type="submit">Odeslat</button>

<span class="cancel">
    <a href="{{ URL::previous() }}">Go Back</a>
</span>