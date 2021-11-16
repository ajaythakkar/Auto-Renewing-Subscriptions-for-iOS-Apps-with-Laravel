<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Device Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_token', 'Device Token:') !!}
    {!! Form::text('device_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('userTokens.index') }}" class="btn btn-default">Cancel</a>
</div>
