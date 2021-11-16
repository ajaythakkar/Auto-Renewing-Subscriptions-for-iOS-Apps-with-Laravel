<div class="table-responsive">
    <table class="table" id="userSubscriptions-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Product Id</th>
        <th>Original Transaction Id</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Latest Receipt</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($userSubscriptions as $userSubscription)
            <tr>
                <td>{{ $userSubscription->user_id }}</td>
            <td>{{ $userSubscription->product_id }}</td>
            <td>{{ $userSubscription->original_transaction_id }}</td>
            <td>{{ $userSubscription->start_date }}</td>
            <td>{{ $userSubscription->end_date }}</td>
            <td>{{ $userSubscription->latest_receipt }}</td>
                <td>
                    {!! Form::open(['route' => ['userSubscriptions.destroy', $userSubscription->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('userSubscriptions.show', [$userSubscription->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('userSubscriptions.edit', [$userSubscription->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
