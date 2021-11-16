<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $userSubscription->id }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $userSubscription->user_id }}</p>
</div>

<!-- Product Id Field -->
<div class="form-group">
    {!! Form::label('product_id', 'Product Id:') !!}
    <p>{{ $userSubscription->product_id }}</p>
</div>

<!-- Original Transaction Id Field -->
<div class="form-group">
    {!! Form::label('original_transaction_id', 'Original Transaction Id:') !!}
    <p>{{ $userSubscription->original_transaction_id }}</p>
</div>

<!-- Start Date Field -->
<div class="form-group">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $userSubscription->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="form-group">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $userSubscription->end_date }}</p>
</div>

<!-- Latest Receipt Field -->
<div class="form-group">
    {!! Form::label('latest_receipt', 'Latest Receipt:') !!}
    <p>{{ $userSubscription->latest_receipt }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $userSubscription->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $userSubscription->updated_at }}</p>
</div>

