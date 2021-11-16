<div class="table-responsive">
    <table class="table" id="userTokens-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Device Token</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($userTokens as $userToken)
            <tr>
                <td>{{ $userToken->user_id }}</td>
            <td>{{ $userToken->device_token }}</td>
                <td>
                    {!! Form::open(['route' => ['userTokens.destroy', $userToken->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('userTokens.show', [$userToken->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('userTokens.edit', [$userToken->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
