

<div class="form-group">
    {!! Form::label('name', 'Jmeno') !!}
    {!! Form::text('name', null, [
        'placeholder'=>'Jmeno turnaje',
        'required'=>'true'
    ] ) !!}

</div>

<div class="form-group">
    {!! Form::label('cena', 'Cena') !!}
    {!! Form::number('cena', null, [
        'required'=>'true'
    ] ) !!}
</div>

<div class="form-group">
    {!! Form::label('pocet_teamu', 'Počet teamů') !!}
    {!! Form::number('pocet_teamu', null, [
        'required'=>'true'
    ] ) !!}
</div>

<div class="form-group">
    {!! Form::label('pocet_hracu', 'Počet hráčů') !!}
    {!! Form::number('pocet_hracu', null, [
        'required'=>'true'
    ] ) !!}
</div>

<div class="form-group">
    {!! Form::label('typ_hracu', 'Typ hráčů') !!}
    {!! Form::text('typ_hracu', null, [
        'required'=>'true'
    ] ) !!}
</div>

<div class="form-group">
    {!! Form::label('poplatek', 'Poplatek') !!}
    {!! Form::number('poplatek', null, [
        'required'=>'true'
    ] ) !!}
</div>

<div class="form-group">
    {!! Form::label('vlastnost_teamu', 'Vlastnost teamu') !!}
    {!! Form::text('vlastnost_teamu', null, [
        'required'=>'true'
    ] ) !!}
</div>



<button type="submit">Odeslat</button>

<span class="cancel">
    <a href="{{ URL::previous() }}">Go Back</a>
</span>