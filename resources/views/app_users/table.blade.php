<div class="table-responsive">
    <table class="table" id="appUsers-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($appUsers as $appUser)
            <tr>
                <td>{{ $appUser->name }}</td>
            <td>{{ $appUser->status }}</td>
                <td>
                    {!! Form::open(['route' => ['appUsers.destroy', $appUser->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('appUsers.show', [$appUser->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('appUsers.edit', [$appUser->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
