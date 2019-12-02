<div class="form-group">
    {!! Form::label('nazev', 'nazev') !!}
    {!! Form::text('nazev', null, [
        'placeholder'=>'Jmeno teamu',
        'required'=>'true'
    ] ) !!}

</div>

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